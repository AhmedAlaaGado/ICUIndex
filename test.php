<?php
/**
 * Created by PhpStorm.
 * User: Gado
 * Date: 6/27/2017
 * Time: 6:34 PM
 */


require('globals.php');
require(GPMODELS . '/hospitalModel.php');
require(GPCONTROLLERS . '/hospitalAdminController.php');

require(GPMODELS . '/departmentsModel.php');


$hospitalModel = new hospitalModel();
$hospital = $hospitalModel->getHospital(1);

$departmentsModel = new departmentsModel();
$alldeps = $departmentsModel->getDepartmentsByHospital($_SESSION['hos_id']);

$name = $hospital['name'];
$phone = $hospital['phone'];
$address = $hospital['address'];

print $hospital;
echo $name;
echo $phone;
echo $address;
echo $alldeps[0]['name'];
echo "fuck";