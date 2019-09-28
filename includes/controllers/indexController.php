<?php

class indexController
{

    public function index($lang,$source)
    {

        if($lang == 'en' && $source == 'web') {
            include(GPVIEW . '/index.html');
        }else if ($lang == 'ar' && $source == 'web'){
            include(GPVIEW . '/index-ar.html');
        }elseif($lang == 'en' && $source == 'android'){
            include(GPVIEW . '/android-index.html');
        }elseif($lang == 'ar' && $source == 'android'){
            include(GPVIEW . '/android-index-ar.html');
        }


    }

    public function work($lang)
    {
        if($lang == 'en') {
            include(GPVIEW . '/work.html');
        }else if ($lang == 'ar'){
            include(GPVIEW . '/work-ar.html');
        }
    }

    public function adminwork($lang)
    {

        if($lang == 'en') {
            include(GPVIEW . '/adminwork.html');
        }else if ($lang == 'ar'){
            include(GPVIEW . '/adminwork-ar.html');
        }

    }

    public function validate($lang)
    {

        if (!empty($_SESSION)) {
            if ($_SESSION['usergroup'] == '1') {
                $this->adminwork($lang);
            } else {
                $this->work($lang);
            }
        } else {
            System::RedirectTo('index.php#login');
        }


    }
} 