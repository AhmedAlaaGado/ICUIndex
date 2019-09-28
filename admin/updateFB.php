<?php
require('../globals.php');
require(GPCONTROLLERS . '/departmentsController.php');
require(GPMODELS . '/departmentsModel.php');


$model = new departmentsModel();
$controller= new departmentsController($model);

$controller->updateDepartmentFB();