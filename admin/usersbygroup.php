<?php
require('../globals.php');
require(GPMODELS . '/usersModel.php');
require(GPCONTROLLERS.'/usersController.php');
require(GPCONTROLLERS.'/usersAdminController.php');
require(GPMODELS . '/usersGroupsModel.php');

$usersModel = new usersModel();

$usersAdminController = new usersAdminController($usersModel);

$usersAdminController->usersByGroup();
