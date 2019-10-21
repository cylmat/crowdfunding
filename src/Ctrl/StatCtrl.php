<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Stat as StatRecord;

class StatCtrl extends Ctrl
{
    function showAction()
    {
        $stat = new StatRecord;
        //$stat->fk_id_project = $id;
        //$stat->montant = rand(200, 900);
        //$stat->create();

        return [
            
        ];
    }

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
