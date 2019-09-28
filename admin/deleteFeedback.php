<?php
require('../globals.php');
require(GPMODELS . '/feedbackModel.php');
require(GPCONTROLLERS . '/feedbackAdminController.php');

$feedbackModel = new feedbackModel();
$feedbackController = new feedbackAdminController($feedbackModel);

$feedbackController->deleteFeedback();