<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        //check for post
        if (($_SERVER['REQUEST_METHOD']) == 'POST') {
            //process form

            //sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            //init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];

            //validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            } else {
                //check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email already exists';
                }
            }

            //validate Name
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter username';
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be at least 6 characters long';
            }
            //validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please confirm password';
            } elseif ($data['confirm_password'] != $data['password']) {
                $data['confirm_password_error'] = 'Password and confirm password does not match';
            }

            //make sure errors are empty
            if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                //validated

                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //register user
                if ($this->userModel->register($data)) {
                    flash('register_success', 'Registration sucessful');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                //load view with error
                $this->view('users/register', $data);
            };
        } else {
            //init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];
            //load view
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        //check for post
        if (($_SERVER['REQUEST_METHOD']) == 'POST') {
            //process form
            //sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            //init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];

            //validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }
            //validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be at least 6 characters long';
            }

            //check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                //user found
            } else {
                //user not found
                $data['email_error'] = 'User not found';
            }

            //make sure errors are empty
            if (empty($data['email_error']) && empty($data['password_error'])) {
                //validated
                //check and set logged user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    //Crate session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                //load view with error
                $this->view('users/login', $data);
            };
        } else {
            //init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            //load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('posts');
    }
}