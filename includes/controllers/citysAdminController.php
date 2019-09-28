<?php
/**
 * Created by PhpStorm.
 * User: dev.syam
 * Date: 9/30/2015
 * Time: 2:09 PM
 */

class citysAdminController
{

    private $model;

    public function __construct(citysModel $model)
    {
        $this->model = $model;
    }


    public function showCitys()
    {
        $citys = $this->model->getCitys();

    }

    public function showCitysByGov($response)
    {
        //Get value posted in by ajax
        $selGov = (int)$_POST['theOption'];
        //die('You sent: ' . $selCity);

//        $values[]=array();
        $results = $this->model->getCityByGov($selGov);
        if( $response == 'android')
        {
            if($results == null)
            {
                echo "Not Found";
            }else{
                echo json_encode(array("results"=>$results));
            }

        }
        elseif(isset($_POST["theOption"]) && !empty($_POST["theOption"])) {

//        if(count($results) > 0 ){
//            foreach($results as $result)
//            {
//
//                $value = $result['city_id'];
//                $label = $result['name'];
//
//                $values[] = array(
//                    'value' => $value,
//                    'label' => $label,
//                );
//
//            }
//            return $values;
//        }

            //die('You sent: ' . $results);
            //Prepare response html markup

            if( $response == 'ali')
            {
                $r = '
                <select name="city_id" id="selcity" required="">
                <option value="">Select a City</option>
        ';
            }else{
                $r = '
                <script>
                    $("#selcity").chosen({rtl: true,disable_search_threshold: 10,no_results_text: "Oops, nothing found!",search_contains:true,width: "160px"});
                </script>
                <select name="city_id" id="selcity" required="">
                <option value="">Select a City</option>
        ';
            }


            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($results) > 0) {
                foreach ($results as $result) {

                    $city_id = $result['city_id'];
                    $city_name = $result['name'];
                    $r = $r . '<option value="' . $city_id . '">' . $city_name . '</option>';
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

    public function showCitysByGov_ar($response)
    {
        //Get value posted in by ajax
        $selGov = (int)$_POST['theOption'];
        //die('You sent: ' . $selCity);

        $results = $this->model->getCityByGov($selGov);

        if(isset($_POST["theOption"]) && !empty($_POST["theOption"])) {

            //die('You sent: ' . $results);
            //Prepare response html markup

            if( $response == 'ali')
            {
                $r = '
                <select name="city_id" id="selcity" required="">
                <option value="">اختر مدينة</option>
        ';
            }else{
                $r = '
                <script>
                    $("#selcity").chosen({rtl: true,disable_search_threshold: 10,no_results_text: "للأسف, لم يتم العثور على",search_contains:true,width: "160px"});
                </script>
                <select name="city_id" id="selcity" required="">
                <option value="">اختر مدينة</option>
        ';
            }


            //Parse mysql results and create response string. Response can be an html table, a full page, or just a few characters
            if (count($results) > 0) {
                foreach ($results as $result) {

                    $city_id = $result['city_id'];
                    $city_name = $result['name'];
                    $r = $r . '<option value="' . $city_id . '">' . $city_name . '</option>';
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



    public function deleteCity()
    {
        if(isset($_GET['id']))
        {

            $id = (int)$_GET['id'];

            if($this->model->deleteCity($id))
                System::RedirectTo("brands.php");
            else
            {
                include(TEMPLATES.'/admin/header.html');
                echo '<h2>Brand Not deleted</h2>';
                include(TEMPLATES.'/admin/footer.html');
            }
        }
        else
        {
            System::RedirectTo("brands.php");
        }
    }



    public function updateCity()
    {


        if(isset($_POST['submit']))
        {
            $id = $_POST['city_id'];

            $data = array();
            $data['city_name'] = $_POST['city_name'];


            if($this->model->updateCity($id,$data))
                System::RedirectTo("brands.php");
            else
                System::RedirectTo("updatebrand.php?id=$id");

        }
        else
        {
            if(isset($_GET['id'])) {
                $id = (int)$_GET['id'];

                $city = $this->model->getCity($id);

                if($city == null)
                {
                    include(TEMPLATES.'/admin/header.html');
                    echo "Brand not found";
                    include(TEMPLATES.'/admin/footer.html');
                    exit();
                }
                include(TEMPLATES.'/admin/header.html');
                include(TEMPLATES.'/admin/updatebrand.html');
                include(TEMPLATES.'/admin/footer.html');
            }
            else
            {
                System::RedirectTo('brands.php');
            }
        }



    }



    public function addCity()
    {
        if(isset($_POST['submit']))
        {
            //data
            $data = array();
            $data['city_name'] = $_POST['city_name'];

            if($this->model->addCity($data))
            {

               System::RedirectTo("brands.php");
            }
            else
            {
                include(TEMPLATES.'/admin/header.html');
                echo '<h3>Error adding Brand</h3>';
                include(TEMPLATES.'/admin/footer.html');
            }


        }
        else
        {

            include(TEMPLATES.'/admin/header.html');

            include(TEMPLATES.'/admin/addbrand.html');

            include(TEMPLATES.'/admin/footer.html');
        }

    }

}