<?php
require('../globals.php');
require(GPMODELS . '/usersModel.php');
require(GPCONTROLLERS.'/usersController.php');
require(GPCONTROLLERS.'/usersAdminController.php');


$usersModel = new usersModel();

$usersAdminController = new usersAdminController($usersModel);

$usersAdminController->Profile();

