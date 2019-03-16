<?php
/**
 * Created by PhpStorm.
 * User: ADN
 * Date: 3/11/2019
 * Time: 8:47 PM
 */

class Main
{
    private $db;

    public function __construct()
    {
        // TODO: DB Connection
        $this->db = new Database();
    }

    public function addCategory($data)
    {
        $category = $data['category'];
        $status = $data['status'];
        $result = null;

        if (strlen($category) < 3) {
            $result = "Category is too short";
        } elseif ($category == '') {
            $result = "Category Field is required";
        } elseif ($status == '') {
            $result = "Category Field is required";
        } else {
            $sql = "INSERT INTO categories (name,user_id,status)VALUES(:category,:uid,:status)";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue("category", str_replace(" ", "_", trim($category)));
            $query->bindValue("status", $status);
            $query->bindValue("uid", 1);
            if ($query->execute() == 1) {
                $result = "Category Added!";
            }
        }

        return $result;

    }

    public function getData($table)
    {
        $sql = "SELECT * FROM $table ORDER BY id ASC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getDataById($table, $id)
    {

        /// select * from categories where id = 1;
        $sql = "SELECT * FROM " . $table . " where id = " . $id;
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function categoryUpdate()
    {

    }

}