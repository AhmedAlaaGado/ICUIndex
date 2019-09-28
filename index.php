<?php
require('globals.php');
require(GPCONTROLLERS . '/indexController.php');
require(GPMODELS . '/citysModel.php');
require(GPCONTROLLERS . '/citysAdminController.php');
require(GPMODELS . '/governorsModel.php');
require(GPCONTROLLERS . '/governorsAdminController.php');
include_once 'language/lang.php';

$indexController = new indexController();

if(isset($_GET['lang']))
{
    $lang = $_GET['lang'];
    if(isset($_GET['source']))
    {
        $source = $_GET['source'];
    }else{
        //default site source
        $source = 'web';
    }
}else{
    //default site language
    $lang = 'ar';
    $source = 'web';
}

$indexController->index($lang,$source);

