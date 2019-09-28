<?php

class usersAdminController extends usersController
{

    public function __construct(usersModel $model)
    {
        parent::__construct($model);
    }

    public function Profile()
    {
        if (isset($_SESSION['id'])) {


            $userData = $this->model->getUser($_SESSION['id']);
            include(TEMPLATES . '/admin/header.html');
            include(TEMPLATES . '/admin/profile.html');
            include(TEMPLATES . '/admin/footer.html');

            //print_r($userData);
        } else {
            System::RedirectTo('login.php');
        }
    }

    public function Users()
    {
        $userData = $this->model->getUser($_SESSION['id']);
        $users = $this->model->getAllUsers();


    }

    public function addUser()
    {
        if (isset($_POST['addUser'])) {
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $pass = strip_tags($_POST['password']);
            $ug_id = (int)strip_tags($_POST['ug_id']);
            $phone = strip_tags($_POST['phone']);

            if(empty($_POST['active']) || $_POST['active'] == "" || $_POST['active'] == null)
            {
                $active = "لا";
            }else{
                $active = strip_tags($_POST['active']);
            }


            if(empty($_POST['hos_id']) || $_POST['hos_id'] == "" || $_POST['hos_id'] == null)
            {
                $hos_id = 0;
            }else{
                $hos_id = (int)strip_tags($_POST['hos_id']);
            }

            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

            //array of data to be inserted
            $userData = array();
            $userData['name'] = $name;
            $userData['email'] = $email;
            $userData['password'] = $pass_hash;
            $userData['ug_id'] = $ug_id;
            $userData['phone'] = $phone;
            $userData['active'] = $active;
            $userData['hos_id'] = $hos_id;


            if ($this->model->register($userData)) {
                echo $this->model->last();
                exit();
            } else {
            }


        } else {
        }

    }

    public function refreshAddUser()
    {
        if(isset($_POST['refresh']))
        {
            //Prepare response html markup
            $r = '<table>
                        <thead>
                        <tr id="new_user">
                            <td>
                                <div id="hospital">
                                    <select id="user_hospital">
                                        <option value="">Select a Hospital</option>';

            //to show Hospital
            $hospitalModel = new hospitalModel();
            $hospitals = $hospitalModel->getHospitals();

            if (count($hospitals) > 0) {
                foreach ($hospitals as $result) {

                    $id = $result['hos_id'];
                    $name = $result['name'];

                    $r = $r . '<option value="'.$id.'"">'.$name.'</option>';

                }
            }

            $r = $r . ' </select>
                                </div>
                            </td>
                            <td>
                                <select id="user_group">
                                    <option value="">Select a User Group</option>';

            $usersGroupsModel = new usersGroupsModel();
            $usersgroups = $usersGroupsModel->getUsersGroups();
            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($usersgroups) > 0) {
                foreach ($usersgroups as $result) {

                    $id = $result['id'];
                    $name = $result['name'];

                    $r = $r . '<option value="'.$id.'"">'.$name.'</option>';

                }
            }



            //die('You sent: ' . $r);
            //Add this extra button for fun
            $r = $r . '</select></td>
                            <td><input type="text" id="user_name" placeholder="Name"></td>
                            <td><input type="text" id="user_email" placeholder="Email" required="true"></td>
                            <td><input type="text" id="user_password" required="true" placeholder="Password"></td>
                            <td><input type="text" id="user_phone" placeholder="Phone"></td>
                            <td>
                                <select id="user_active">
                                    <option value="">Active?</option>
                                    <option value="نعم">نعم</option>
                                    <option value="لا">لا</option>
                                </select></td>
                            <td><input type="button" class="special" value="Add User" onclick="add_user();"></td>
                        </tr>
                        </thead>
                    </table>';

            //The response echoed below will be inserted into the
            echo $r;
        }
    }

    public function refreshAddUser_ar()
    {
        if(isset($_POST['refresh']))
        {
            //Prepare response html markup
            $r = '<table>
                        <thead>
                        <tr id="new_user">
                            <td width="15%">
                                <div id="hospital">
                                    <select id="user_hospital">
                                        <option value="">اختر مشفى</option>';

            //to show Hospital
            $hospitalModel = new hospitalModel();
            $hospitals = $hospitalModel->getHospitals();

            if (count($hospitals) > 0) {
                foreach ($hospitals as $result) {

                    $id = $result['hos_id'];
                    $name = $result['name'];

                    $r = $r . '<option value="'.$id.'"">'.$name.'</option>';

                }
            }

            $r = $r . ' </select>
                                </div>
                            </td>
                            <td>
                                <select id="user_group">
                                    <option value="">اختر نوع المستخدم</option>';

            $usersGroupsModel = new usersGroupsModel();
            $usersgroups = $usersGroupsModel->getUsersGroups();
            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($usersgroups) > 0) {
                foreach ($usersgroups as $result) {

                    $id = $result['id'];
                    $name = $result['name'];

                    $r = $r . '<option value="'.$id.'"">'.$name.'</option>';

                }
            }



            //die('You sent: ' . $r);
            //Add this extra button for fun
            $r = $r . '</select></td>
                            <td><input type="text" id="user_name" placeholder="الاسم"></td>
                            <td><input type="text" id="user_email" placeholder="البريد الإلكتروني" required="true"></td>
                            <td><input type="text" id="user_password" required="true" placeholder="كلمة السر"></td>
                            <td><input type="text" id="user_phone" placeholder="رقم الهاتف"></td>
                            <td>
                                <select id="user_active">
                                    <option value="">مفعل؟</option>
                                    <option value="نعم">نعم</option>
                                    <option value="لا">لا</option>
                                </select></td>
                            <td><input type="button" class="special" value="أضف مستخدم" onclick="add_user();"></td>
                        </tr>
                        </thead>
                    </table>';

            //The response echoed below will be inserted into the
            echo $r;
        }
    }

    public function user()
    {
        $userData = $this->model->getUser($_SESSION['id']);
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $user = $this->model->getUser($id);
            include(TEMPLATES . '/user.html');
        } else {
            echo 'user not found';
        }
    }


    public function deleteUser()
    {
        if (isset($_POST['delete_user'])) {

            $id = (int)$_POST['id'];

            if ($this->model->deleteUser($id))
            {
                echo "success";
                exit;
            }
            else {
                echo "error";
                exit;
            }
        } else {
            echo "unknownError";
            exit;
        }
    }


    public function updateUser()
    {

        if (isset($_POST['edit_user'])) {
            $id = (int)$_POST['user_id'];

            $data = array();
            $data['name'] = strip_tags($_POST['name']);
            $data['ug_id'] = (int)strip_tags($_POST['ug_id']);

            if(empty($_POST['active']) || $_POST['active'] == "" || $_POST['active'] == null)
            {
                $data['active'] = "لا";
            }else{
                $data['active'] = strip_tags($_POST['active']);
            }

            if(empty($_POST['hos_id']) || $_POST['hos_id'] == "" || $_POST['hos_id'] == null)
            {
                $data['hos_id'] = 0;
            }else{
                $data['hos_id'] = (int)strip_tags($_POST['hos_id']);
            }

            if ($this->model->updateUser($id, $data))
            {
                echo "success";
                exit;
            }
            else
            {
                echo "error";
                exit;
            }
        } else {
            echo "unknownError";
            exit;
        }

    }

    public function refreshUsers()
    {
        if(isset($_POST['refresh']))
        {
            //Prepare response html markup
            $r = '<table id="users">
                                <thead>
                                <tr>
                                    <th><h3>Hospital</h3></th>
                                    <th><h3>User Group</h3></th>
                                    <th><h3>refreshed Name</h3></th>
                                    <th><h3>Email</h3></th>
                                    <th><h3>Phone</h3></th>
                                    <th><h3>Address</h3></th>
                                    <th><h3>Active</h3></th>
                                    <th><h3>Edit</h3></th>
                                </tr>
                                </thead>

                                <tbody>
                        <tbody>';

            $users =$this->model->getAllUsers();
            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($users) > 0) {
                foreach ($users as $user) {

                    $user_id = $user['user_id'];
                    $hos_id = $user['hos_id'];
                    $hospital = $user['hospital'];
                    $ug_id = $user['ug_id'];
                    $usergroup = $user['usergroup'];
                    $name = $user['name'];
                    $email = $user['email'];
                    $phone = $user['phone'];
                    $address = $user['address'];
                    $active = $user['active'];

                    $r = $r . '<tr id="row'.$user_id.'">
                                    <td><h3 id="hospital_val'.$user_id.'"><a hidden="" id="hos_id_val'.$user_id.'">'.$hos_id.'</a>'.$hospital.'</h3></td>
                                    <td><h3 id="usergroup_val'.$user_id.'"><a hidden="" id="ug_id_val'.$user_id.'">'.$ug_id.'</a>'.$usergroup.'</h3></td>
                                    <td><h3 id="name_val'.$user_id.'">'.$name.'</h3></td>
                                    <td><h3 id="email_val'.$user_id.'">'.$email.'</h3></td>
                                    <td><h3 id="phone_val'.$user_id.'">'.$phone.'</h3></td>
                                    <td><h3 id="address_val'.$user_id.'">'.$address.'</h3></td>
                                    <td><h3 id="active_val'.$user_id.'">'.$active.'</h3></td>
                                    <td width="17%">
                                        <input type="button" class="edit_button"
                                               id="edit_button'.$user_id.'" value="edit"
                                               onclick="edit_user('.$user_id.');">
                                        <input type="button" class="save_button"
                                               id="save_button'.$user_id.'" value="save"
                                               onclick="save_user('.$user_id.');"
                                               style="display: none">
                                        <input type="button" class="delete_button special"
                                               id="delete_buttton'.$user_id.'" value="delete"
                                               onclick="delete_user('.$user_id.');">
                                    </td>
                                </tr>';

                }
            }

            //die('You sent: ' . $r);
            //Add this extra button for fun
            $r = $r . '</tbody></table>';

            //The response echoed below will be inserted into the
            echo $r;
        }

    }



    public function searchUser()
    {
        $userData = $this->model->getUser($_SESSION['id']);
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];

            $users = $this->model->searchUser($keyword);

            include(TEMPLATES . '/searchresults.html');
        } else {
            include(TEMPLATES . '/searchuser.html');
        }
    }

    public function usersByGroup()
    {

        $userData = $this->model->getUser($_SESSION['id']);

        include(TEMPLATES . '/admin/header.html');
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $users = $this->model->getUsersByGroup($id);
            include(TEMPLATES . '/admin/users.html');
        } else {
            echo 'users not found';
        }
        include(TEMPLATES . '/admin/footer.html');

    }

    public function usersByHospital()
    {
        $userData = $this->model->getUser($_SESSION['id']);

        include(TEMPLATES . '/admin/header.html');
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $users = $this->model->getUsersByHospital($id);
            include(TEMPLATES . '/admin/users.html');
        } else {
            echo 'users not found';
        }
        include(TEMPLATES . '/admin/footer.html');
    }

}