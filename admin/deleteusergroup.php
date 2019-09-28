<?php
require('../globals.php');
require(GPCONTROLLERS . '/departmentsController.php');
require(GPMODELS . '/usersGroupsModel.php');

$model = new usersGroupsModel();

$controller= new usersGroupsAdminController($model);

$controller->deleteUserGroup();