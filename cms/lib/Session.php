<?php
/**
 * Created by PhpStorm.
 * User: ADN
 * Date: 3/18/2019
 * Time: 8:55 PM
 */

class Session
{
    public static function init(){
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        }else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }
}