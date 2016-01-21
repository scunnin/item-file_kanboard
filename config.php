<?php

define('DEBUG', false);
define('DEBUG_FILE', __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'debug.log');

define('PLUGINS_DIR', 'plugins');
define('FILES_DIR', 'data'.DIRECTORY_SEPARATOR.'files');

define('MAIL_FROM', 'stephen.cunningham@walmart.com');
define('MAIL_TRANSPORT', 'sendmail');
define('MAIL_SENDMAIL_COMMAND', '/usr/sbin/sendmail -bs');

define('REMEMBER_ME_AUTH', true);
define('ENABLE_HSTS', true);
define('ENABLE_XFRAME', true);
define('ENABLE_SYSLOG', true);
define('MARKDOWN_ESCAPE_HTML', true);
define('BRUTEFORCE_CAPTCHA', 3);
define('BRUTEFORCE_LOCKDOWN', 6);
define('BRUTEFORCE_LOCKDOWN_DURATION', 15);
define('SESSION_DURATION', 0);