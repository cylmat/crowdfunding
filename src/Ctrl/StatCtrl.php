<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Stat as StatRecord;

class StatCtrl extends Ctrl
{
    function showAction()
    {
        $stat = new StatRecord;
        //$res = $stat->getAll();

        return [
            //'resultats' => $res
        ];
    }

    /**
     * Get data from ajax
     */
    function getjsonAction()
    {
        if(!$_GET['ajax']) die();

        $stat = new StatRecord;
        $res = $stat->getAll();

        if(!is_null($res))
            echo json_encode($res);
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
