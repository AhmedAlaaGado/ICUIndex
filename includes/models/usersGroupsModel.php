<?php

class usersGroupsModel
{

    public function addUserGroup($usergroupData)
    {
        if(System::Get('db')->Insert('usersgroups',$usergroupData))
            return true;

        return false;
    }


    public function getUsersGroups($extra='')
    {
        System::Get('db')->Execute("SELECT * FROM `usersgroups` $extra");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    public function getUserGroup($id)
    {
        $usersgroups = $this->getUsersGroups("WHERE `usersgroups`.`id`=$id");

        if($usersgroups != null)
            return $usersgroups[0];

        return null;
    }


    public function updateUserGroup($id,$usergroupData)
    {
        if(System::Get('db')->Update('usersgroups',$usergroupData,"WHERE `usersgroups`.`id`=$id"))
            return true;

        return false;
    }


    public function deleteUserGroup($id)
    {
        if(System::Get('db')->Delete('usersgroups',"WHERE `usersgroups`.`id`=$id"))
            return true;

        return false;
    }


} 