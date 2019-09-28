<?php
require('../globals.php');
require(GPCONTROLLERS . '/hospitalAdminController.php');
require(GPMODELS . '/hospitalModel.php');

$model = new hospitalModel();

$controller= new hospitalAdminController($model);

$controller->updateHospital();