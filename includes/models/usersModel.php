<?php

class usersModel
{

    private $userData;


    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function login($email)
    {
        System::Get('db')->Execute("SELECT * FROM `users` WHERE `email`='$email'");

        if(System::Get('db')->AffectedRows()>0)
        {
            $this->userData = System::Get('db')->GetRow();
            return true;
        }

        return false;
    }


    public function getUserData()
    {
        return $this->userData;
    }


    /**
     *register new user
     * @param $userData
     * @return bool
     */
    public function register($userData )
    {
        if(System::Get('db')->Insert('users',$userData))
        {
            return true;
        }

        return false;

    }


    /**
     * Get all users
     * @return null
     */
    public function getAllUsers()
    {
        System::Get('db')->Execute("SELECT `users`.*,`usersgroups`.`name` AS 'usergroup',`hospital`.`name` AS 'hospital' FROM `users`,`usersgroups`,`hospital` WHERE `users`.`ug_id` = `usersgroups`.`id` AND `users`.`hos_id` = `hospital`.`hos_id` ");
        if(System::Get('db')->AffectedRows()>0)
        {
            return System::Get('db')->GetRows();
        }

        return null;
    }


    public function getUser($id)
    {
        System::Get('db')->Execute("SELECT `users`.*,`usersgroups`.`name` AS 'usergroup',`hospital`.`name` AS 'hospital' FROM `users`,`usersgroups`,`hospital` WHERE `users`.`ug_id` = `usersgroups`.`id` AND `users`.`hos_id` = `hospital`.`hos_id` AND `users`.`user_id`=$id");
        if(System::Get('db')->AffectedRows()>0)
        {
            return System::Get('db')->GetRow();
        }

        return null;
    }


    public function getUsersByGroup($id)
    {
        System::Get('db')->Execute("SELECT `users`.*,`usersgroups`.`name` AS 'usergroup',`hospital`.`name` AS 'hospital' FROM `users`,`usersgroups`,`hospital` WHERE `users`.`ug_id` = `usersgroups`.`id` AND `users`.`hos_id` = `hospital`.`hos_id` AND `usersgroups`.`id`=$id");
        if(System::Get('db')->AffectedRows()>0)
        {
            return System::Get('db')->GetRows();
        }

        return null;

    }

    public function getUsersByHospital($id)
    {
        System::Get('db')->Execute("SELECT `users`.*,`usersgroups`.`name` AS 'usergroup',`hospital`.`name` AS 'hospital' FROM `users`,`usersgroups`,`hospital` WHERE `users`.`ug_id` = `usersgroups`.`id` AND `users`.`hos_id` = `hospital`.`hos_id` AND `hospital`.`hos_id`=$id");
        if(System::Get('db')->AffectedRows()>0)
        {
            return System::Get('db')->GetRows();
        }

        return null;

    }


    public function searchUser($keyword)
    {
        System::Get('db')->Execute("SELECT * FROM `users` WHERE `name` LIKE '%$keyword%' OR `email` LIKE '%$keyword%'");
        if(System::Get('db')->AffectedRows()>0)
        {
            return System::Get('db')->GetRows();
        }

        return null;
    }


    public function updateUser($id,$userDate)
    {
        if(System::Get('db')->Update('users',$userDate,"WHERE `user_id`=$id"))
            return true;

        return false;


    }

    public function last()
    {
        return System::Get('db')->Last();
    }

    public function deleteUser($id)
    {
        if(System::Get('db')->Delete('users',"WHERE `user_id`=$id"))
            return true;

        return false;
    }



} 