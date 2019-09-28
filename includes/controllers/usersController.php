<?php

class usersController
{
    protected $model;

    public function __construct(usersModel $model)
    {
        $this->model = $model;
    }

    /**
     * Login Operation
     */
    public function login()
    {

        if (isset($_SESSION['id']))
        {
            System::RedirectTo('controlPanel.php');
        }

        if (isset($_POST['submit'])) {
            $email = strip_tags($_POST['loginemail']);
            $password = strip_tags($_POST['pass']);

            if ($this->model->login($email)) {
                $userInfo = $this->model->getUserData();
                $hash = $userInfo['password'];

                // Verify stored hash against plain-text password
                if (password_verify($password, $hash)) {
                    // Check if a newer hashing algorithm is available
                    // or the cost has changed
                    if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                        // If so, create a new hash, and replace the old one
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        //array of data to be inserted
                        $userData = array();
                        $userData['password'] = $newHash;
                        $this->model->updateUser($userInfo['id'],$userData);
                    }

                    $_SESSION['id'] = $userInfo['user_id'];
                    $_SESSION['name'] = $userInfo['name'];
                    $_SESSION['email'] = $userInfo['email'];
                    $_SESSION['hos_id'] = $userInfo['hos_id'];
                    $_SESSION['usergroup'] = $userInfo['ug_id'];
                    $_SESSION['password'] = $userInfo['password'];
                    $_SESSION['phone'] = $userInfo['phone'];
                    $_SESSION['address'] = $userInfo['address'];
                    $_SESSION['sec_q'] = $userInfo['sec_q'];
                    $_SESSION['sec_q_a'] = $userInfo['sec_q_a'];
                    $_SESSION['active'] = $userInfo['active'];

                    // Log user in
                    if($_SESSION['active'] == "نعم")
                    {
                        System::RedirectTo('controlPanel.php');
                    }
                    else{
                        System::RedirectTo('index.php#successfulRegister');
                    }


                }else {
                    System::RedirectTo('index.php#loginFailedP');
                    print "<script>swal('Invalid Data');</script>";

                }
            }else {
                System::RedirectTo('index.php#loginFailedE');
                print "<script>swal('Invalid Data');</script>";

            }

        } else {
            System::RedirectTo('index.php#login');
        }

    }


    /**
     * Register Users
     */
    public function register()
    {

        if (!empty($_SESSION))
        {
            System::RedirectTo('controlPanel.php');
        }
        else{
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $hos_id = $_POST['hos_id'];
                $sec_q = $_POST['sec_q'];
                $sec_q_a = $_POST['sec_q_a'];

                $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

                //array of data to be inserted
                $userData = array();
                $userData['name'] = $name;
                $userData['phone'] = $phone;
                $userData['address'] = $address;
                $userData['email'] = $email;
                $userData['password'] = $pass_hash;
                $userData['hos_id'] = $hos_id;
                $userData['sec_q'] = $sec_q;
                $userData['sec_q_a'] = $sec_q_a;

                if ($this->model->register($userData)) {
                    System::RedirectTo('index.php#successfulRegister');
                } else {
                    System::RedirectTo('index.php#failedRegister');
                }


            } else {
                System::RedirectTo('index.php#register');

            }
        }
    }

    public function updateProfile()
    {
        if (isset($_POST['submit'])) {
            $name = strip_tags($_POST['prname']);
            $email = strip_tags($_POST['premail']);
            $pass = strip_tags($_POST['prnpass']);
            $opass = strip_tags($_POST['propass']);
            $phone = strip_tags($_POST['prphone']);
            $address = strip_tags($_POST['praddress']);
            $sec_q = strip_tags($_POST['prsec_q']);
            $sec_q_a = strip_tags($_POST['prsec_q_a']);


            $hash = $_SESSION['password'];

            if(empty($pass) || !isset($pass))
            {
                $pass_hash = $hash;
            }
            elseif((!empty($opass) || isset($opass)) && empty($pass))
            {
                echo "erroremptypass";
                die;
            }
            elseif((empty($opass) || !isset($opass)) && !empty($pass))
            {
                echo "erroremptyopass";
                die;
            }
            elseif(!empty($opass) && !empty($pass))
            {
                if(password_verify($opass, $hash))
                {
                    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
                }else{
                    echo "errorpass";
                    die;
                }
            }


            $id = $_SESSION['id'];
            //array of data to be inserted
            $userData = array();
            $userData['name'] = $name;
            $userData['phone'] = $phone;
            $userData['address'] = $address;
            $userData['email'] = $email;
            $userData['password'] = $pass_hash;
            $userData['sec_q'] = $sec_q;
            $userData['sec_q_a'] = $sec_q_a;

            //die('You sent: ' . $id);
            if ($this->model->updateUser($id,$userData)) {

                $_SESSION['name'] = $userData['name'];
                $_SESSION['email'] = $userData['email'];
                $_SESSION['password'] = $userData['password'];
                $_SESSION['phone'] = $userData['phone'];
                $_SESSION['address'] = $userData['address'];
                $_SESSION['sec_q'] = $userData['sec_q'];
                $_SESSION['sec_q_a'] = $userData['sec_q_a'];

                echo "success";
            } else {
                echo "error";
            }

        } else {
            System::RedirectTo('controlPanel.php');

        }
    }


    /**
     * Logout users
     */
    public function logout()
    {
        session_destroy();

        System::RedirectTo('index.php');
    }


    public function profile()
    {
        if (isset($_SESSION['id'])) {

            include(TEMPLATES . '/front/header.html');


            $userData = $this->model->getUser($_SESSION['id']);

            include(TEMPLATES . '/front/profile.html');
            include(TEMPLATES . '/front/footer.html');

            //print_r($userData);
        } else {
            System::RedirectTo(ROOT.' login.php');
        }
    }



}