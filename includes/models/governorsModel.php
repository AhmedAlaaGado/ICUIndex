<?php

class governorsModel
{
    /**
     * Add new product
     * @param $productData
     * @return bool
     */
    public function addGov($govData)
    {
        if(System::Get('db')->Insert('governor',$govData))
            return true;

        return false;
    }


    /**
     * @param string $extra
     * @return null
     */
    public function getGovs($extra='')
    {
        System::Get('db')->Execute("SELECT * FROM `governor` $extra");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    /**
     * @param $id
     * @return null
     */
    public function getGov($gov_id)
    {
        $gov = $this->getgovs("WHERE `governor`.`gov_id`=$gov_id");

        if($gov != null)
            return $gov[0];

        return null;
    }


    /**
     * @param $id
     * @param $brandData
     * @return bool
     */
    public function updateGov($gov_id,$govData)
    {
        if(System::Get('db')->Update('governor',$govData,"WHERE `governor`.`gov_id`=$gov_id"))
            return true;

        return false;
    }


    /**
     * @param $id
     * @return bool
     */
    public function deleteGov($gov_id)
    {

        if(System::Get('db')->Delete('governor',"WHERE `governor`.`gov_id`=$gov_id"))
            return true;

        return false;
    }


} 