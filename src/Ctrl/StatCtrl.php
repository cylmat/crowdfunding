<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Stat as StatRecord;

class StatCtrl extends Ctrl
{
    function showAction()
    {
        return [
            
        ];
    }

    /**
     * Get data from ajax
     */
    function getallstatsjsonAction()
    {
        if(!$_GET['ajax']) die();

        $stat = new StatRecord;
        $results = $stat->getAllByDate();

        if(!is_null($results))
            echo json_encode($results);
        die();
    }

    /**
     * Ajax lors de l'envoi d'un donateur sur le page d'un projet
     */
    function createAction()
    {
        if(!$_GET['ajax']) die();

        //securite
        if($this->get['session_id'] != session_id()) die();

        $stat = new StatRecord;
        $stat->fk_id_project = $this->get['id_project'];
        $stat->montant = $this->get['don'];

        if($stat->create()) {
            echo '1';
        }
        else {
            echo '0';
        }
        die();
    }
}
