<?php
/**
 * Created by PhpStorm.
 * User: Gado
 * Date: 12/20/2016
 * Time: 5:18 PM
 */

class hospitalAdminController
{

    private $model;

    public function __construct(hospitalModel $model)
    {
        $this->model = $model;
    }


    public function showHospitals()
    {
        $userModel = new usersModel();
        $userData = $userModel->getUser($_SESSION['id']);
        $hospitals = $this->model->getHospitals();

    }

    public function showHospital($id)
    {
        $hospital = $this->model->getHospital($id);
        return $hospital;
    }

    public function showHospitalByUser($id)
    {
        $hospital = $this->model->getHospitalByUser($id);
        return $hospital;
    }

    public function showHospitalsByCity($response)
    {
        //Get value posted in by ajax
        $selCity = (int)$_POST['theOption'];
        //die('You sent: ' . $selCity);
        $results = $this->model->getHospitalByCity($selCity);
        if( $response == 'android')
        {
            if($results == null)
            {
                echo "Not Found";
            }else{
                echo json_encode(array("results"=>$results));
            }
        }
        elseif (isset($_POST["theOption"]) && !empty($_POST["theOption"])) {

            //die('You sent: ' . $results);
            //Prepare response html markup

            if( $response == 'ali')
            {
                $r = '
                <select name="hos_id" id="selHos" required="">
                <option value="">Select a Hospital</option>
        ';
            }else{
                $r = '
                <script>
                    $("#selHos").chosen({rtl: true,disable_search_threshold: 10,no_results_text: "Oops, nothing found!",search_contains:true,width: "160px"});
                </script>
                <select name="hos_id" id="selHos" required="">
                <option value="">Select a Hospital</option>
        ';
            }


            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($results) > 0) {
                foreach ($results as $result) {

                    $hos_id = $result['hos_id'];
                    $hos_name = $result['name'];
                    $r = $r . '<option value="' . $hos_id . '">' . $hos_name . '</option>';
                    //$rn[] = $r;

                }
            }

            //die('You sent: ' . $r);
            //Add this extra button for fun
            $r = $r . '</select>';

            //The response echoed below will be inserted into the
            echo $r;
        }

    }

    public function showHospitalsByCity_ar($response)
    {
        //Get value posted in by ajax
        $selCity = (int)$_POST['theOption'];
        //die('You sent: ' . $selCity);
        $results = $this->model->getHospitalByCity($selCity);

        if (isset($_POST["theOption"]) && !empty($_POST["theOption"])) {

            //die('You sent: ' . $results);
            //Prepare response html

            if( $response == 'ali')
            {
                $r = '
                <select name="hos_id" id="selHos" required="">
                <option value="">اختر مستشفى</option>
        ';
            }else{
                $r = '
                <script>
                    $("#selHos").chosen({rtl: true,disable_search_threshold: 10,no_results_text: "للأسف, لم يتم العثور على",search_contains:true,width: "160px"});
                </script>
                <select name="hos_id" id="selHos" required="">
                <option value="">اختر مستشفى</option>
        ';
            }


            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($results) > 0) {
                foreach ($results as $result) {

                    $hos_id = $result['hos_id'];
                    $hos_name = $result['name'];
                    $r = $r . '<option value="' . $hos_id . '">' . $hos_name . '</option>';
                    //$rn[] = $r;

                }
            }

            //die('You sent: ' . $r);
            //Add this extra button for fun
            $r = $r . '</select>';

            //The response echoed below will be inserted into the
            echo $r;
        }

    }

    public function deleteHospital()
    {
        if(isset($_POST['delete_hos']))
        {

            $id = (int)$_POST['id'];

            if($this->model->deleteHospital($id))
            {
                echo "success";
                exit;
            }else
            {
                echo "error";
                exit;
            }
        }
        else
        {
            echo "unknownError";
            exit;
        }
    }



    public function updateHospital()
    {


        if(isset($_POST['submit']))
        {
            if($_POST['source'] == "Hadmin")
            {
                parse_str($_POST['data'], $output);
                $id = $_SESSION['hos_id'];

                $data = array();
                $data['name'] = strip_tags($output['name']);
                $data['address'] = strip_tags($output['address']);
                $data['phone'] = strip_tags($output['phone']);
//                die('your H id'. $id);


            }elseif ($_POST['source'] == "Sadmin")
            {
                $id = (int)$_POST['hos_id'];

                $data = array();
                $data['name'] = strip_tags($_POST['name']);
                $data['address'] = strip_tags($_POST['address']);
                $data['phone'] = strip_tags($_POST['phone']);
                $data['city_id'] = strip_tags($_POST['city_id']);

//                die('your S id'. $id);

            }
//            die('your id'. $id);



            if($this->model->updateHospital($id,$data))
            {
                echo "success";
                exit;
            }
            else
            {
                echo "error";
                exit;
            }

        }
        else
        {
            echo "unknownError";
            exit;
        }



    }



    public function addHospital()
    {
        if(isset($_POST['insert_hos']))
        {
            //data
            $data = array();
            $data['name'] = strip_tags($_POST['name']);
            $data['phone'] = strip_tags($_POST['phone']);
            $data['address'] = strip_tags($_POST['address']);
            $data['city_id'] = strip_tags($_POST['city_id']);


            if($this->model->addHospital($data))
            {
                echo $this->model->last();
                exit();
            }
            else
            {
                echo "error";
                exit;
            }


        }
        else
        {
            echo "unknownError";
            exit;
        }

    }

} 