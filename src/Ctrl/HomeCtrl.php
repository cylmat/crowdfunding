<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Classes\Records;
use Record\Project as ProjectRecord;

/**
 * Page d'accueil
 */
class HomeCtrl extends Ctrl
{
    function indexAction()
    {
        $project = new ProjectRecord();

        //last project inserted
        $last = $project->getLastData();
        
        //project
        $list = $project->getAllDatas();

        return [
            'last_project' => $last,
            'list' => $list
        ];
    }
}
