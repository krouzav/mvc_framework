<?php

//App core class
//creates URL and loads core controller
//URL format = /controller/method/params

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        //print_r($this->getUrl());

        $url = $this->getUrl();
        //validate that url array exists

        //Look in controllers for first value (index)
        if (isset($url)) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                //If exists, set as controller
                $this->currentController = ucwords($url[0]);
                //Unset 0 index -eliminates controller from parameters
                unset($url[0]);
            }
        }


        //require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instatiate controller class
        $this->currentController = new $this->currentController;

        //check for method part of url (second part)
        if (isset($url[1])) {
            //check if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                //unset url [1] -eliminates method from parameters
                unset($url[1]);
            }
        }
        //get parameters
        $this->params = $url ? array_values($url) : [];

        //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            //stript URL of any "/" on the end of the string
            $url = rtrim($_GET['url'], '/');
            //sanitaze URL 
            //FILTER_SANITIZE_URL removes:
            //Remove all characters except letters, digits 
            //and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //break url into array by /
            $url = explode('/', $url);
            return $url;
        }
    }
}