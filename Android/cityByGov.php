<?php
require('../globals.php');
require(GPMODELS . '/citysModel.php');
require(GPCONTROLLERS . '/citysAdminController.php');

$citysModel = new citysModel();
$citysController = new citysAdminController($citysModel);
$android = "android";
$citysController->showCitysByGov($android);