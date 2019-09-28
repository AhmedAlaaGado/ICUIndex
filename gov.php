<?php
require('globals.php');
require(GPMODELS.'/governorsModel.php');
require(GPCONTROLLERS.'/governorsAdminController.php');

$governorsModel = new governorsModel();
$governorsController = new governorsAdminController($governorsModel);
$response = "";
$governorsController->showGovs($response);
