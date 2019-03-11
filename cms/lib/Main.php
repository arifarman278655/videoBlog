<?php
/**
 * Created by PhpStorm.
 * User: ADN
 * Date: 3/11/2019
 * Time: 8:47 PM
 */

class Main
{


    public function __construct()
    {
        // TODO: DB Connection
        $db   = new Database();
    }

    public function addCategory($category, $status){

        $sql = "INSERT INTO categories (name,user_id,status)VALUES('$category',1,'$status')";


        return "category is ". $category . "And Status is ". $status;
    }

}