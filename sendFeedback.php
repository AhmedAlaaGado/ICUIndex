<?php
require('globals.php');
require(GPMODELS . '/feedbackModel.php');
require(GPCONTROLLERS . '/feedbackController.php');

$feedbackModel = new feedbackModel();
$feedbackController = new feedbackController($feedbackModel);

$feedbackController->sendFeedback();