<?php

/**
 * Created by PhpStorm.
 * User: dev.syam
 * Date: 9/30/2015
 * Time: 2:09 PM
 */
class departmentsController
{

    private $model;

    public function __construct(departmentsModel $model)
    {
        $this->model = $model;
    }


    public function showDepartments()
    {

        $departments = $this->model->getDepartments();

    }

    public function showDepartmentsByHospital($response)
    {
        //Get value posted in by ajax
        $selhos = (int)$_POST['theOption'];
        //die('You sent: ' . $selhos);

        require(GPMODELS . '/hospitalModel.php');
        require(GPCONTROLLERS . '/hospitalAdminController.php');
        $hospitalModel = new hospitalModel();
        $hospitalController = new hospitalAdminController($hospitalModel);
        $hospital = $hospitalController->showHospital($selhos);

        $results = $this->model->getDepartmentsByHospital($selhos);
        /* if you removed this comment don't forget to edit the else if condition*/
          /*if (isset($_SESSION['id'])) {

            return $results;
            exit;
        }else*/if( $response == 'android')
        {
            if($results == null)
            {
                echo "Not Found";
            }else{
                echo json_encode(array("results"=>$results));
            }
        }
        else if(isset($selhos) ){
            //die('You sent: ' . $results);
            //Prepare response html markup
            $r = '
                    <details>
                        <summary style="font-size: x-large">' . $hospital["name"] . '</summary>
                        <option style="font-size: x-large">' . $hospital["phone"] . '</option>
                        <option style="font-size: large">' . $hospital["address"] . '</option>
                    </details><br>
        ';

            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if(count($results) == 0)
            {
                $r = $r . '<h2>There is currently no departments entered in this hospital</h2>' ;
            }
            else{
                $r = $r . '<div class="field">

                        <div class="table-wrapper" >

                            <table>
                            <thead>
                                <tr>
                                    <th><h3>Department</h3></th>
                                    <th><h3>Available Beds</h3></th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($results as $result) {

                    $dep_id = $result['dep_id'];
                    $dep_name = $result['name'];
                    $free_beds = $result['free_beds'];
                    $r = $r . '<tr>
                            <td><h3>' . $dep_name . '</h3></td>
                            <td><h3>' . $free_beds . '</h3></td>
                        </tr>';

                }


                //die('You sent: ' . $r);
                //Add this extra button for fun
                $r = $r . '</tbody></table></div></div>';
            }
            //The response echoed below will be inserted into the
            echo $r;
        }else{
            echo "error";
            exit;
        }


    }



    public function showDepartmentsByHospital_ar()
    {
        //Get value posted in by ajax
        $selhos = (int)$_POST['theOption'];
        //die('You sent: ' . $selhos);

        require(GPMODELS . '/hospitalModel.php');
        require(GPCONTROLLERS . '/hospitalAdminController.php');
        $hospitalModel = new hospitalModel();
        $hospitalController = new hospitalAdminController($hospitalModel);
        $hospital = $hospitalController->showHospital($selhos);

        $results = $this->model->getDepartmentsByHospital($selhos);
       if(isset($selhos) ){
        //die('You sent: ' . $results);
        //Prepare response html markup
        $r = '
                    <details>
                        <summary style="font-size: x-large">' . $hospital["name"] . '</summary>
                        <option style="font-size: x-large">' . $hospital["phone"] . '</option>
                        <option style="font-size: large">' . $hospital["address"] . '</option>
                    </details><br>
        ';

        //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
        if(count($results) == 0)
        {
            $r = $r . '<h2>لا يوجد حالياً أقسام في هذه المستشفى</h2>' ;
        }
        else{
            $r = $r . '<div class="field">

                        <div class="table-wrapper" >

                            <table>
                            <thead>
                                <tr>
                                    <th><h3>قسم</h3></th>
                                    <th><h3>الأسرة المتاحة</h3></th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach ($results as $result) {

                $dep_id = $result['dep_id'];
                $dep_name = $result['name'];
                $free_beds = $result['free_beds'];
                $r = $r . '<tr>
                            <td><h3>' . $dep_name . '</h3></td>
                            <td><h3>' . $free_beds . '</h3></td>
                        </tr>';

            }


            //die('You sent: ' . $r);
            //Add this extra button for fun
            $r = $r . '</tbody></table></div></div>';
        }
        //The response echoed below will be inserted into the
        echo $r;
    }else{
        echo "error";
        exit;
    }
    }


    public function deleteDepartment()
    {
        if (isset($_POST['delete_row'])) {

            $id = (int)$_POST['id'];

            if ($this->model->deleteDepartment($id))
                echo "success";
            else {
                echo "error";
            }
        } else {
            echo "unknownError";
        }
    }


    public function updateDepartment()
    {

        if (isset($_POST['edit_row'])) {
            $id = (int)$_POST['dep_id'];

            $data = array();
            $data['name'] = strip_tags($_POST['name']);
            $data['total_beds'] = strip_tags($_POST['total_beds']);

            $department = $this->model->getDepartment($id);

            if($department['free_beds'] > (int)$_POST['total_beds'])
            {
                $data['free_beds'] = strip_tags($_POST['total_beds']);
            }elseif($department['free_beds'] < (int)$_POST['total_beds']){
                $data['free_beds'] = (int)$_POST['total_beds'] - $department['free_beds'];
            }


            if ($this->model->updateDepartment($id, $data))
            {
                echo "success";
                exit();
            }
            else {
                echo "error";
                exit();
            }
        } else {

        }


    }

    public function refreshDepartment()
    {
        if(isset($_POST['refresh']))
        {
            //Prepare response html markup
            $r = '<table>
                        <thead>
                        <tr>
                            <th><h3>Department</h3></th>
                            <th><h3>Total Beds</h3></th>
                            <th><h3>Available Beds</h3></th>
                            <th><h3>EDIT</h3></th>
                        </tr>
                        </thead>
                        <tbody>';

            $results =$this->model->getDepartmentsByHospital($_SESSION['hos_id']);
            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($results) > 0) {
                foreach ($results as $result) {

                    $dep_id = $result['dep_id'];
                    $dep_name = $result['name'];
                    $total_beds = $result['total_beds'];
                    $free_beds = $result['free_beds'];
                    $r = $r . '<tr>
                                        <td><h3>'.$dep_name.'</h3></td>
<td><h3>'.$total_beds.'</h3></td>
<td>
    <h3 id="freebeds_val'.$dep_id.'">'.$free_beds.'</h3>
</td>
<td>
    <input type="button" class="edit_button"
           id="edit_button'.$dep_id.'" value="edit"
           onclick="edit_row('.$dep_id.');">
    <input type="button" class="save_button"
           id="save_button'.$dep_id.'" value="save"
           onclick="save_row('.$dep_id.');" style="display: none">
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

    public function refreshDepartment_ar()
    {
        if(isset($_POST['refresh']))
        {
            //Prepare response html markup
            $r = '<table>
                        <thead>
                        <tr>
                            <th><h3>القسم</h3></th>
                            <th><h3>إجمالي الأسرة</h3></th>
                            <th><h3>الأسرة المتاحة</h3></th>
                            <th><h3>خيارات</h3></th>
                        </tr>
                        </thead>
                        <tbody>';

            $results =$this->model->getDepartmentsByHospital($_SESSION['hos_id']);
            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($results) > 0) {
                foreach ($results as $result) {

                    $dep_id = $result['dep_id'];
                    $dep_name = $result['name'];
                    $total_beds = $result['total_beds'];
                    $free_beds = $result['free_beds'];
                    $r = $r . '<tr>
                                        <td><h3>'.$dep_name.'</h3></td>
<td><h3>'.$total_beds.'</h3></td>
<td>
    <h3 id="freebeds_val'.$dep_id.'">'.$free_beds.'</h3>
</td>
<td>
    <input type="button" class="edit_button"
           id="edit_button'.$dep_id.'" value="تعديل"
           onclick="edit_row('.$dep_id.');">
    <input type="button" class="save_button"
           id="save_button'.$dep_id.'" value="حفظ"
           onclick="save_row('.$dep_id.');" style="display: none">
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


    public function updateDepartmentFB()
    {

        if (isset($_POST['edit_row'])) {
            $id = (int)$_POST['dep_id'];

            $data = array();
            $data['free_beds'] = strip_tags($_POST['free_beds']);

            if ($this->model->updateDepartment($id, $data)) {
                echo "success";
                exit();
            } else{
                echo "error";
                exit();
            }

        } else {
            echo "unknownError";
            exit();
        }


    }


    public function addDepartment()
    {

        if (isset($_POST['insert_row'])) {
            //data
            $data = array();
            $data['name'] = strip_tags($_POST['name_val']);
            $data['total_beds'] = strip_tags($_POST['totalbeds_val']);
            $data['free_beds'] = strip_tags($_POST['totalbeds_val']);
            $data['hos_id'] = strip_tags($_SESSION['hos_id']);

            if ($this->model->addDepartment($data)) {

                echo $this->model->last();
                exit();

            }


        }

    }

}