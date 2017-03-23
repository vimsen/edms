<?php
define ('BASEPATH', '');

define('THRESHOLD_ALERT_TYPE_ID', 1);

define('SEND_MAIL', true);

/*
define('MASTER_EMAIL', 'bis@intelen.com');
define('SMTP_HOST', 'mail.intelen.com');
define('SMTP_USERNAME', 'bis@intelen.com');
define('SMTP_PASSWORD', '123bis456!2#');
*/


define('MASTER_EMAIL', 'bis@intelen.com');
define('SMTP_HOST', 'email-smtp.eu-west-1.amazonaws.com');
define('SMTP_USERNAME', 'AKIAIZSBI52OWXJOQHYA');
define('SMTP_PASSWORD', 'Ar2DLaZJXjSXVV0V6LyWCPPovw/2b0E6q+Q0xdGDFApE');


// enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
define('SMTP_DEBUG', 1);

define('THRESHOLD_ALERT_TYPE_ID', 1);

require_once '/home/intelendev/biswv-config/bpa.php';

require_once '/home/intelendev/biswv-config/database.php';

?>
