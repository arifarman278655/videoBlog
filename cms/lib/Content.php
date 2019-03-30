<?php
/**
 * Created by PhpStorm.
 * User: ADN
 * Date: 3/30/2019
 * Time: 8:11 PM
 */

class Content implements QueryInterface
{

    private $db;

    public function __construct()
    {
        // TODO: DB Connection
        $this->db = new Database();
    }

    function getAllDataFrom($table)
    {
        $sql = "SELECT contents.*, users.username as user_name FROM contents INNER JOIN users ON contents.user_id=users.id";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}