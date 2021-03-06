<?php
/**
 * Created by PhpStorm.
 * User: ADN
 * Date: 3/11/2019
 * Time: 8:47 PM
 */

class Main implements QueryInterface
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
        $sql = "SELECT categories.*, users.username as user_name FROM categories INNER JOIN users ON categories.user_id=users.id";
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

    public function gen_uuid()
    {
        $uuid = array(
            'time_low' => 0,
            'time_mid' => 0,
            'time_hi' => 0,
            'clock_seq_hi' => 0,
            'clock_seq_low' => 0,
            'node' => array()
        );

        $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
        $uuid['time_mid'] = mt_rand(0, 0xffff);
        $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
        $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
        $uuid['clock_seq_low'] = mt_rand(0, 255);

        for ($i = 0; $i < 6; $i++) {
            $uuid['node'][$i] = mt_rand(0, 255);
        }

        $uuid = sprintf('%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $uuid['time_low'],
            $uuid['time_mid'],
            $uuid['time_hi'],
            $uuid['clock_seq_hi'],
            $uuid['clock_seq_low'],
            $uuid['node'][0],
            $uuid['node'][1],
            $uuid['node'][2],
            $uuid['node'][3],
            $uuid['node'][4],
            $uuid['node'][5]
        );

        return $uuid;
    }


    public function addUser($data, $file_temp, $uploaded_image)
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

    public function addContent($data, $file_temp, $uploaded_image)
    {
        $title = $data['title'];
        $short_desc = $data['short_desc'];
        $long_desc = $data['long_desc'];
        $tag = $data['tag'];
        $cat_id = $data['cat_id'];


        $result = null;

        $sql = "INSERT INTO contents(title,short_desc,long_desc,cat_id,postal_img,tags)VALUE (:title, :short_desc, :long_desc, :cat_id, :postal_img, :tags)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue('title', str_replace(' ', '_', trim($title)));
        $query->bindValue('short_desc', $short_desc);
        $query->bindValue('long_desc', $long_desc);
        $query->bindValue('cat_id', $cat_id);
        $query->bindValue('postal_img', $uploaded_image);
        $query->bindValue('tags', $tag);
        if ($query->execute() == 1) {
            $result = "Content Added!";
            move_uploaded_file($file_temp, $uploaded_image);

        }
        return $result;
    }

    public function addVideo($data)
    {
        $content_id = $data['content_id'];
        $video_url = $data['video_url'];
        $status = $data['status'];


        $result = null;

        $sql = "INSERT INTO videos(content_id, file_path,status, user_id)VALUE (:content_id, :file_path, :status, :user_id)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue('content_id', $content_id);
        $query->bindValue('file_path', $video_url);
        $query->bindValue('status', $status);
        $query->bindValue('user_id', Session::get('id'));
        if ($query->execute() == 1) {
            $result = "Video Added!";
        }
        return $result;
    }

    public function delete($id, $table)
    {
        $sql = "DELETE FROM $table WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        if ($query->execute() == 1) {
            $msg = "<div class='alert alert-danger'><strong>Success !</strong> Item Successfully Deleted ! </div>";
            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Something Wrong, Please try again </div>";
            return $msg;
        }
    }

    public function detailById($id, $table)
    {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        if ($query->execute() == 1) {
            $msg = "<div class='alert alert-danger'><strong>Success !</strong> Item Successfully Deleted ! </div>";
            return $msg;
        } else {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Something Wrong, Please try again </div>";
            return $msg;
        }
    }


    function getAllDataFrom($table)
    {
        // TODO: Implement getAllDataFrom() method.

        $sql = "SELECT categories.*, users.username as user_name FROM categories INNER JOIN users ON categories.user_id=users.id";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}