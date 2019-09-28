<?php
session_start();

define('GPROOT',dirname(__FILE__));
define('GPCONTROLLERS',GPROOT.'/includes/controllers');
define('GPMODELS',GPROOT.'/includes/models');
define('GPCORE',GPROOT.'/includes/core');
define('GPVIEW',GPROOT.'/view');
define('GPPASSWORD_HASHING',GPCORE.'/password_compat-master/lib');

require(GPCORE.'/config.php');
require(GPCORE.'/System.php');
require(GPCORE.'/mysql.class.php');
require(GPPASSWORD_HASHING.'/password.php');

System::Store('db', new mysqlDB());