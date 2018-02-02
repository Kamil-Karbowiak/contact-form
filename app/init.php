<?php
session_start();

require_once "config/config.php";
require_once DIR_ROOT.DS."vendor".DS."autoload.php";
require_once "class".DS."core".DS."App.php";

$app = new App();
