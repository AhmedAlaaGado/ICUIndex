<?php
/**
 * Created by PhpStorm.
 * User: dev.syam
 * Date: 9/30/2015
 * Time: 2:09 PM
 */

class usersGroupsAdminController
{

    private $model;

    public function __construct(usersGroupsModel $model)
    {
        $this->model = $model;
    }


    public function showUsersGroups()
    {
        $userModel = new usersModel();
        $userData = $userModel->getUser($_SESSION['id']);

        $usersgroups = $this->model->getUsersGroups();
        include(TEMPLATES.'/admin/header.html');
        include(TEMPLATES.'/admin/usersgroups.html');
        include(TEMPLATES.'/admin/footer.html');
    }



    public function deleteUserGroup()
    {
        if(isset($_GET['id']))
        {

            $id = (int)$_GET['id'];

            if($this->model->deleteUserGroup($id))
                System::RedirectTo("usersgroups.php");
            else
            {
                include(TEMPLATES.'/admin/header.html');
                echo '<h2>User Group Not deleted</h2>';
                include(TEMPLATES.'/admin/footer.html');
            }
        }
        else
        {
            System::RedirectTo("usersgroups.php");
        }
    }



    public function updateUserGroup()
    {
        $userModel = new usersModel();
        $userData = $userModel->getUser($_SESSION['id']);

        if(isset($_POST['submit']))
        {
            $id = $_POST['id'];

            $data = array();
            $data['name'] = $_POST['name'];


            if($this->model->updateUserGroup($id,$data))
                System::RedirectTo("usersgroups.php");
            else
                System::RedirectTo("updateusergroup.php?id=$id");

        }
        else
        {
            if(isset($_GET['id'])) {
                $id = (int)$_GET['id'];

                $usergroup = $this->model->getUserGroup($id);

                if($usergroup == null)
                {
                    include(TEMPLATES.'/admin/header.html');
                    echo "User Group not found";
                    include(TEMPLATES.'/admin/footer.html');
                    exit();
                }
                include(TEMPLATES.'/admin/header.html');
                include(TEMPLATES.'/admin/updateusergroup.html');
                include(TEMPLATES.'/admin/footer.html');
            }
            else
            {
                System::RedirectTo('usersgroups.php');
            }
        }



    }



    public function addUserGroup()
    {
        $userModel = new usersModel();
        $userData = $userModel->getUser($_SESSION['id']);

        if(isset($_POST['submit']))
        {
            //data
            $data = array();
            $data['name'] = $_POST['name'];

            if($this->model->addUserGroup($data))
            {

               System::RedirectTo("usersgroups.php");
            }
            else
            {
                include(TEMPLATES.'/admin/header.html');
                echo '<h3>Error adding User Group</h3>';
                include(TEMPLATES.'/admin/footer.html');
            }


        }
        else
        {

            include(TEMPLATES.'/admin/header.html');

            include(TEMPLATES.'/admin/addusergroup.html');

            include(TEMPLATES.'/admin/footer.html');
        }

    }

} 