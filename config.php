<?php

define('DEBUG', false);
define('DEBUG_FILE', __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'debug.log');

define('PLUGINS_DIR', 'plugins');
define('FILES_DIR', 'data'.DIRECTORY_SEPARATOR.'files');

define('MAIL_TRANSPORT', 'mailgun');
define('MAILGUN_API_TOKEN', 'key-d04dae8cd2729be6edf5b1780b0e38ce');
define('MAILGUN_DOMAIN', 'app8446c21643be4877852e73baa0d40432.mailgun.org');
define('MAIL_FROM', 'postmaster@app8446c21643be4877852e73baa0d40432.mailgun.org');

define('REMEMBER_ME_AUTH', true);
define('ENABLE_HSTS', true);
define('ENABLE_XFRAME', true);
define('ENABLE_SYSLOG', true);
define('MARKDOWN_ESCAPE_HTML', true);
define('BRUTEFORCE_CAPTCHA', 3);
define('BRUTEFORCE_LOCKDOWN', 6);
define('BRUTEFORCE_LOCKDOWN_DURATION', 15);
define('SESSION_DURATION', 0);