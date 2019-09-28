<?php

class feedbackModel
{

    public function addFeedback($feedbackData)
    {
        if(System::Get('db')->Insert('feedback',$feedbackData))
            return true;

        return false;
    }


    public function getFeedbacks($extra='')
    {
        System::Get('db')->Execute("SELECT * FROM `feedback` $extra");
        if(System::Get('db')->AffectedRows()>0)
            return System::Get('db')->GetRows();

        return null;
    }


    public function getFeedback($id)
    {
        $feedback = $this->getFeedbacks("WHERE `feedback`.`id`=$id");

        if($feedback != null)
            return $feedback[0];

        return null;
    }





    public function deleteFeedback($id)
    {
        if(System::Get('db')->Delete('feedback',"WHERE `feedback`.`id`=$id"))
            return true;

        return false;
    }


} 