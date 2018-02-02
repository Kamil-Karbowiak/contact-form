<?php

define("DS", DIRECTORY_SEPARATOR);
define("DIR_ROOT", dirname(__DIR__, 2));
define("APP_ROOT", DIR_ROOT.DS.'app');
define("VIEWS_DIR", DIR_ROOT.DS."app".DS."resources".DS."views".DS);

//DB PARAMETERS
define("DB_HOST", "");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASSWORD", "");

//MAIL CONFIGURATION
define("EMAIL_ADDRESS", "");
define("EMAIL_HOST", "");
define("EMAIL_USERNAME", "");
define("EMAIL_PASSWORD", "");
define("EMAIL_PORT", "");
define("EMAIL_SMTP_SECURE", "tls");