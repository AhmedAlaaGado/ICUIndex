<?php


class feedbackAdminController
{

    private $model;

    public function __construct(feedbackModel $model)
    {
        $this->model = $model;
    }


    public function showFeedbacks()
    {
        $feedbacks = $this->model->getFeedbacks();
        return $feedbacks;
    }

    public function showFeedback($id)
    {
        $feedback = $this->model->getFeedback($id);
        return $feedback;
    }



    public function deleteFeedback()
    {
        if(isset($_POST['delete_fb']))
        {

            $id = (int)$_POST['id'];

            if($this->model->deleteFeedback($id))
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