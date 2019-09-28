<?php

class departmentsModel
{
    /**
     * Add new article
     * @param $articleData
     * @return bool
     */
    public function addDepartment($departmentData)
    {
        if(System::Get('db')->Insert('departments',$departmentData))
        {
            return true;
        }


        return false;
    }

    public function last()
    {
        return System::Get('db')->Last();
    }


    /**
     * @param string $extra
     * @return null
     */
    public function getDepartments($extra='')
    {
        System::Get('db')->Execute("SELECT `departments`.*,`hospital`.`name` AS 'hospital' FROM `departments` LEFT JOIN `hospital` ON `departments`.`hos_id` = `hospital`.`hos_id` $extra");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    /**
     * @param $id
     * @return null
     */
    public function getDepartment($id)
    {
        $departments = $this->getDepartments("WHERE `departments`.`dep_id`=$id");

        if($departments != null)
            return $departments[0];

        return null;
    }


    public function getDepartmentsByHospital($id)
    {
        $departments =  $this->getDepartments("WHERE `departments`.`hos_id`=$id");

        if($departments != null)
            return $departments;

        return null;
    }




    /**
     * search for Article
     * @param $keyword
     * @return null
     */
    public function searchDepartment($keyword)
    {
        return $this->getDepartments("WEHERE `departments`.`name` LIKE '%$keyword%'");
    }


    /**
     * @param $id
     * @param $articleData
     * @return bool
     */
    public function updateDepartment($id,$departmentData)
    {
        if(System::Get('db')->Update('departments',$departmentData,"WHERE `departments`.`dep_id`=$id"))
            return true;

        return false;
    }


    /**
     * @param $id
     * @return bool
     */
    public function deleteDepartment($id)
    {

        if(System::Get('db')->Delete('departments',"WHERE `departments`.`dep_id`=$id"))
            return true;

        return false;
    }


} 