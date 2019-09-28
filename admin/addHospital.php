<?php
require('../globals.php');
require(GPCONTROLLERS . '/hospitalAdminController.php');
require(GPMODELS . '/hospitalModel.php');
require(GPMODELS . '/usersModel.php');

$model = new hospitalModel();

$controller= new hospitalAdminController($model);

$controller->addHospital();