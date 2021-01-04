<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    //Register user
    public function register($data)
    {
        $this->db->query('INSERT INTO mvc.users (name, email, password) VALUES (:name, :email, :password)');
        //bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //execute querty
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //login user
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM mvc.users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hassed_password = $row->password;

        if (password_verify($password, $hassed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    //find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM mvc.users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        //check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    //get user by ID
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM mvc.users WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }
}