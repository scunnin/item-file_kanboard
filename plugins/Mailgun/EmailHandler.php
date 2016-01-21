<?php

namespace Kanboard\Plugin\Mailgun;

require_once __DIR__.'/vendor/autoload.php';

use Kanboard\Core\Base;
use Kanboard\Core\Tool;
use Kanboard\Core\Mail\ClientInterface;
use League\HTMLToMarkdown\HtmlConverter;

defined('MAILGUN_API_TOKEN') or define('MAILGUN_API_TOKEN', '');
defined('MAILGUN_DOMAIN') or define('MAILGUN_DOMAIN', '');

/**
 * Mailgun Mail Handler
 *
 * @package  mailgun
 * @author   Frederic Guillot
 */
class EmailHandler extends Base implements ClientInterface
{
    /**
     * Send a HTML email
     *
     * @access public
     * @param  string  $email
     * @param  string  $name
     * @param  string  $subject
     * @param  string  $html
     * @param  string  $author
     */
    public function sendEmail($email, $name, $subject, $html, $author)
    {
        $headers = array(
            'Authorization: Basic '.base64_encode('api:'.MAILGUN_API_TOKEN)
        );

        $payload = array(
            'from' => sprintf('%s <%s>', $author, MAIL_FROM),
            'to' => sprintf('%s <%s>', $name, $email),
            'subject' => $subject,
            'html' => $html,
        );

        $this->httpClient->postForm('https://api.mailgun.net/v3/'.MAILGUN_DOMAIN.'/messages', $payload, $headers);
    }

    /**
     * Parse incoming email
     *
     * @access public
     * @param  array   $payload   Incoming email
     * @return boolean
     */
    public function receiveEmail(array $payload)
    {
        if (empty($payload['sender']) || empty($payload['subject']) || empty($payload['recipient'])) {
            return false;
        }

        // The user must exists in Kanboard
        $user = $this->user->getByEmail($payload['sender']);

        if (empty($user)) {
            $this->logger->debug('Mailgun: ignored => user not found');
            return false;
        }

        // The project must have a short name
        $project = $this->project->getByIdentifier(Tool::getMailboxHash($payload['recipient']));

        if (empty($project)) {
            $this->logger->debug('Mailgun: ignored => project not found');
            return false;
        }

        // The user must be member of the project
        if (! $this->projectPermission->isMember($project['id'], $user['id'])) {
            $this->logger->debug('Mailgun: ignored => user is not member of the project');
            return false;
        }

        // Get the Markdown contents
        if (! empty($payload['stripped-html'])) {
            $htmlConverter = new HtmlConverter(array('strip_tags' => true));
            $description = $htmlConverter->convert($payload['stripped-html']);
        }
        else if (! empty($payload['stripped-text'])) {
            $description = $payload['stripped-text'];
        }
        else {
            $description = '';
        }

        // Finally, we create the task
        return (bool) $this->taskCreation->create(array(
            'project_id' => $project['id'],
            'title' => $payload['subject'],
            'description' => $description,
            'creator_id' => $user['id'],
        ));
    }
}
