<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Stat as StatRecord;

class StatCtrl extends Ctrl
{
    /**
     * Page des statistiques
     */
    function showAction(): array
    {
        return [];
    }

    /**
     * Get data pour l'ajax
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
     * Ajax lors de l'envoi d'une donation sur la page d'un projet
     */
    function createAction()
    {
        if(!$_GET['ajax']) die();

        //securite
        if($this->get['session_id'] != session_id()) die();

        $stat = new StatRecord;
        $stat->fk_id_project = $this->get['id_project'];
        $stat->montant = $this->get['don'];

        /**
         * Si le don a bien été effectué
         */
        if($stat->create()) {
            echo json_encode('1');
        }
        else {
            echo json_encode('0');
        }
        die();
    }
}
