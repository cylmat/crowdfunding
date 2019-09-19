<?php declare(strict_types = 1);

namespace Classes;

 /** 
  * Controller class
  */
class Ctrl
{
    protected $get, $post;

    public function __construct()
    {
        $this->getRequest();
    }

    protected function getRequest()
    {
        if(isset($_GET) && !empty($_GET)) {
            $this->get = $_GET;
        }

        if(isset($_POST) && !empty($_POST)) {
            $this->post = $_POST;
        }
    }
}