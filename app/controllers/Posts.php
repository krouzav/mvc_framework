<?php

class Posts extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $posts = $this->postModel->getPost();

        $data = [
            'posts' => $posts

        ];

        $this->view('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' =>  '',
            ];
            //Validate title
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter title';
            }
            //Validate body
            if (empty($data['body'])) {
                $data['body_error'] = 'Please enter body text';
            }

            //Validate if there are no errors
            if (empty($data['title_error']) && empty($data['body_error'])) {
                //validated form
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                //Load view with errors
                $this->view('posts/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'body' => '',

            ];

            $this->view('posts/add', $data);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' =>  '',
            ];
            //Validate title
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter title';
            }
            //Validate body
            if (empty($data['body'])) {
                $data['body_error'] = 'Please enter body text';
            }

            //Validate if there are no errors
            if (empty($data['title_error']) && empty($data['body_error'])) {
                //validated form
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post updated');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                //Load view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            //get existing post from model
            $post = $this->postModel->getPostById($id);
            //check for owner of the post
            if ($post->userId !== $_SESSION['user_id']) {
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,

            ];

            $this->view('posts/edit', $data);
        }
    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->userId);
        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }


    public function delete($id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //get existing post from model
            $post = $this->postModel->getPostById($id);

            //check for owner of the post
            if ($post->userId !== $_SESSION['user_id']) {
                redirect('posts');
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post removed');
                redirect('post');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('post');
        }
    }
}