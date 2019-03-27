<?php
/**
 * Created by PhpStorm.
 * User: ADN
 * Date: 3/27/2019
 * Time: 9:11 PM
 */

class Helper
{

    public function getTitle(){
        $titleHeader = explode('/', $_SERVER['SCRIPT_NAME']);
        explode('.',end( $titleHeader));
        $res =  explode('.',end( $titleHeader));
        echo strtoupper( str_replace('_', ' ', $res[0]));
    }

}