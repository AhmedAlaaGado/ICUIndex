<?php
require('globals.php');
require(GPMODELS . '/citysModel.php');
require(GPCONTROLLERS . '/citysAdminController.php');

$citysModel = new citysModel();
$citysController = new citysAdminController($citysModel);
$response = "";
$citysController->showCitysByGov_ar($response);