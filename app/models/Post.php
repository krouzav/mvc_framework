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
}