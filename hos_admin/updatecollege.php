<?php
require('../globals.php');
require(GPCONTROLLERS . '/hospitalAdminController.php');
require(GPMODELS . '/hospitalModel.php');
require(GPMODELS . '/usersModel.php');

$model = new departmentsModel;
$controller= new departmentsController($model);

$controller->updateDepartment();