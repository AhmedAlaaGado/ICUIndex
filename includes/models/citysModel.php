<?php

class citysModel
{
    /**
     * Add new product
     * @param $productData
     * @return bool
     */
    public function addCity($cityData)
    {
        if(System::Get('db')->Insert('city',$cityData))
            return true;

        return false;
    }


    /**
     * @param string $extra
     * @return null
     */
    public function getCitys($extra='')
    {
        System::Get('db')->Execute("SELECT * FROM `city` $extra");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    /**
     * @param $id
     * @return null
     */
    public function getCity($city_id)
    {
        $city = $this->getCitys("WHERE `city`.`city_id`=$city_id");

        if($city != null)
            return $city[0];

        return null;
    }

    public function getCityByGov($id)
    {
        System::Get('db')->Execute("SELECT * FROM `city` WHERE `city`.`gov_id`=$id");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    /**
     * @param $id
     * @param $brandData
     * @return bool
     */
    public function updateCity($city_id,$cityData)
    {
        if(System::Get('db')->Update('city',$cityData,"WHERE `city`.`city_id`=$city_id"))
            return true;

        return false;
    }


    /**
     * @param $id
     * @return bool
     */
    public function deleteCity($city_id)
    {

        if(System::Get('db')->Delete('city',"WHERE `city`.`city_id`=$city_id"))
            return true;

        return false;
    }


} 