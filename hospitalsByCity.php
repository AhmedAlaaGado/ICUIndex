<?php
require('globals.php');
require(GPMODELS . '/hospitalModel.php');
require(GPCONTROLLERS . '/hospitalAdminController.php');


$hospitalModel = new hospitalModel();
$hospitalController = new hospitalAdminController($hospitalModel);
$response = "";
$hospitalController->showHospitalsByCity($response);