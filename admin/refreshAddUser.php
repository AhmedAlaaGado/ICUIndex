<?php
/**
 * Created by PhpStorm.
 * User: Gado
 * Date: 6/27/2017
 * Time: 12:37 PM
 */
require('../globals.php');
require(GPMODELS . '/usersModel.php');
require(GPCONTROLLERS.'/usersController.php');
require(GPCONTROLLERS.'/usersAdminController.php');
require(GPMODELS . '/usersGroupsModel.php');
require(GPMODELS . '/hospitalModel.php');

$usersModel = new usersModel();

$usersAdminController = new usersAdminController($usersModel);

$usersAdminController->refreshAddUser();

