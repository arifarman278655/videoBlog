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

    public function updateCategory($data)
    {
        $category = $data['category'];
        $status = $data['status'];
        $id = $data['id'];
        $result = null;

        if (strlen($category) < 3) {
            $result = "Category is too short";
        } elseif ($category == '') {
            $result = "Category Field is required";
        } elseif ($status == '') {
            $result = "Category Field is required";
        } elseif ($id == '') {
            $result = "Id Field is required";
        } else {

            $sql = "UPDATE categories SET name = :name, status = :status WHERE id=:id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', $category);
            $query->bindValue(':status', $status);
            $query->bindValue(':id', $id);
            $result = $query->execute();
            if ($result) {
                $msg = "<div class='alert alert-success'><strong>Success !</strong> Category Successfully Updated.</div>";
                return $msg;
            } else {
                $msg = "<div class='alert alert-danger'><strong>Error !</strong> Something Wrong, Please try again </div>";
                return $msg;
            }
        }
    }

    public function addUser($data,$file_temp, $uploaded_image)
    {
        $full_name = $data['full_name'];
        $username = $data['username'];
        $email = $data['email'];
        $phone = $data['phone'];
        $password = md5($data['password']);
        $address = $data['address'];
        $gender = $data['gender'];
        $status = $data['status'];


        $result = null;
        $sql = "INSERT INTO users(full_name, username, email, phone, password, address, gender, status, photo)VALUE (:full_name, :username, :email, :phone, :password, :address, :gender, :status, :photo)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue('full_name', str_replace(' ', '_', trim($full_name)));
        $query->bindValue('username', $username);
        $query->bindValue('email', $email);
        $query->bindValue('phone', $phone);
        $query->bindValue('password', $password);
        $query->bindValue('address', $address);
        $query->bindValue('gender', $gender);
        $query->bindValue('status', $status);
        $query->bindValue('photo', $uploaded_image);
        if ($query->execute() == 1) {
            $result = "Users Added";
            move_uploaded_file($file_temp, $uploaded_image);

        }
        return $result;
    }

}