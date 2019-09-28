<?php

class feedbackController
{
    private $model;

    public function __construct(feedbackModel $model)
    {
        $this->model = $model;
    }

    public function sendFeedback()
    {

        if(isset($_POST['submit']))
        {
            parse_str($_POST['data'], $output);
            //data
            $data = array();
            $data['name'] = strip_tags($output['name']);
            $data['email'] = strip_tags($output['email']);
            $data['message'] = strip_tags($output['message']);

            if($this->model->addFeedback($data))
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
}