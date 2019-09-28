<?php
/**
 * Created by PhpStorm.
 * User: dev.syam
 * Date: 9/30/2015
 * Time: 2:09 PM
 */

class governorsAdminController
{

    private $model;

    public function __construct(governorsModel $model)
    {
        $this->model = $model;
    }


    public function showGovs($response)
    {
        $govs = $this->model->getGovs();

        if( $response == 'android')
        {
            echo json_encode(array("results"=>$govs));
        }

    }



    public function deleteGov()
    {
        if(isset($_GET['id']))
        {

            $id = (int)$_GET['id'];

            if($this->model->deleteGov($id))
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



    public function updateGov()
    {


        if(isset($_POST['submit']))
        {
            $id = $_POST['gov_id'];

            $data = array();
            $data['name'] = $_POST['gov_name'];


            if($this->model->updateGov($id,$data))
                System::RedirectTo("brands.php");
            else
                System::RedirectTo("updatebrand.php?id=$id");

        }
        else
        {
            if(isset($_GET['id'])) {
                $id = (int)$_GET['id'];

                $gov = $this->model->getGov($id);

                if($gov == null)
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



    public function addGov()
    {
        if(isset($_POST['submit']))
        {
            //data
            $data = array();
            $data['name'] = $_POST['gov_name'];

            if($this->model->addGov($data))
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