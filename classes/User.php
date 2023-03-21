<?php
require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($data) {
        $this->db->query("INSERT INTO users (name, email, password, image) VALUES (:name, :email, :password, :image)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':image', $data['image']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function login($email, $password) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }
}
