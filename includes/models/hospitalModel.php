<?php
/**
 * Created by PhpStorm.
 * User: Gado
 * Date: 12/20/2016
 * Time: 5:21 PM
 */

class hospitalModel
{
    public function addHospital($hospitalData)
    {
        if(System::Get('db')->Insert('hospital',$hospitalData))
            return true;

        return false;
    }


    public function getHospitals($extra='')
    {
        System::Get('db')->Execute("SELECT `hospital`.*,`city`.`name` AS 'city' FROM `hospital`,`city` WHERE `hospital`.`city_id` = `city`.`city_id` $extra");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }



    public function getHospital($id)
    {
        $hospital = $this->gethospitals("&& `hospital`.`hos_id`=$id");

        if($hospital != null)
            return $hospital[0];

        return null;
    }


    public function getHospitalByCity($id)
    {
        System::Get('db')->Execute("SELECT * FROM `hospital` WHERE `hospital`.`city_id`=$id");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    public function updateHospital($id,$hospitalData)
    {
        if(System::Get('db')->Update('hospital',$hospitalData,"WHERE `hospital`.`hos_id`=$id"))
            return true;

        return false;
    }

    public function last()
    {
        return System::Get('db')->Last();
    }

    public function deleteHospital($id)
    {

        if(System::Get('db')->Delete('hospital',"WHERE `hospital`.`hos_id`=$id"))
            return true;

        return false;
    }

} 