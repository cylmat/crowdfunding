<?php declare(strict_types = 1);

namespace Classes;

/** 
 * Controller class
 *
 * Recupère la requete 
 */
class Ctrl
{
    protected $get, $post;

    public function __construct()
    {
        $this->getRequest();
    }

    /**
     * Recupère la requete
     * 
     * Les requêtes sont dejà protégées grâce au router
     * Router::PREG_URL
     */
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