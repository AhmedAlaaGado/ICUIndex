<?php
require('../globals.php');
require(GPMODELS . '/usersModel.php');
require(GPCONTROLLERS.'/usersController.php');


$usersModel = new usersModel();
$usersController = new usersController($usersModel);

$usersController->updateProfile();