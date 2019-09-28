<?php
require('globals.php');
require(GPCONTROLLERS.'/indexController.php');
require(GPMODELS . '/departmentsModel.php');
require(GPCONTROLLERS.'/departmentsController.php');
require(GPMODELS . '/hospitalModel.php');
//require(CONTROLLERS.'/hospitalAdminController.php');
require(GPMODELS . '/usersGroupsModel.php');
require(GPMODELS . '/usersModel.php');
require(GPMODELS . '/citysModel.php');
require(GPMODELS . '/feedbackModel.php');
require(GPCONTROLLERS.'/usersController.php');
require(GPCONTROLLERS.'/usersAdminController.php');
include_once 'language/lang.php';



$departmentModel = new departmentsModel();
$departmentController = new departmentsController($departmentModel);

$usersModel = new usersModel();
$usersAdminController = new usersAdminController($usersModel);

$indexController = new indexController();

if(isset($_GET['lang']))
{
    $lang = $_GET['lang'];
}else{
    //default site language
    $lang = 'ar';
}
$indexController->validate($lang);

