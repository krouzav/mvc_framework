<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }



    public function getPost()
    {
        $this->db->query('SELECT *,
                            mvc.posts.id as postId,
                            mvc.users.id as userId,
                            mvc.posts.created as postCreated,
                            mvc.users.created as userCreated
                            FROM mvc.posts
                            INNER JOIN mvc.users
                            ON posts.userId = users.id
                            ORDER BY posts.created DESC
                            ');
        $results = $this->db->resultSet();
        return $results;
    }

    public function addPost($data)
    {
        $this->db->query('INSERT INTO mvc.posts (title, userId, body) VALUES (:title, :userId, :body)');
        //bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':userId', $data['user_id']);
        $this->db->bind(':body', $data['body']);

        //execute querty
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->db->query('UPDATE mvc.posts SET title = :title, body = :body WHERE id = :id');
        //bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);

        //execute querty
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostById($id)
    {
        $this->db->query('SELECT * from mvc.posts WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    public function deletePost($id)
    {
        $this->db->query('DELETE FROM mvc.posts WHERE id=:id');
        //bind values
        $this->db->bind(':id', $id);

        //execute querty
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}