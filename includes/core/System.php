<?php

/**
 * System
 */
class System
{
    /**
     * used to store objects
     * @var array
     */
    private static $objects = array();


    /**
     * used to store objects with certain key
     * @param $key
     * @param $value
     */
    public static function Store($key, $value)
    {
        self::$objects[$key] = $value;
    }


    /**
     * Used to return an abject
     * @param $key
     * @return mixed
     */
    public static function Get($key)
    {
        return self::$objects[$key];
    }


    /**
     * Redirect user to a $location
     * @param type $location
     */
    public static function RedirectTo($location)
    {
        if (!headers_sent()) {
            //If headers not sent yet... then do php redirect
            header("Location: $location");
            exit;
        } else {
            //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
            $red = '<script type="text/javascript">';
            $red .= 'window.location.href="' . $location . '";';
            $red .= '</script>';
            echo $red;

            /*---------- HTML Meta Refresh ---------*/
            $meta = '<noscript>';
            $meta .= '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
            $meta .= '</noscript>';
            echo $meta;
            exit;
        }

    }

}
