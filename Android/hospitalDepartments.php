<?php
require('../globals.php');
require(GPMODELS . '/departmentsModel.php');
require(GPCONTROLLERS . '/departmentsController.php');


$departmentModel = new departmentsModel();
$departmentController = new departmentsController($departmentModel);
$android = "android";
$departmentController->showDepartmentsByHospital($android);

