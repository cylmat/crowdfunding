<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Classes\Records;
use Record\Project as ProjectRecord;

class DefaultCtrl extends Ctrl
{
    function indexAction()
    {
        $project = new ProjectRecord();
        $list = $project->getAll();

        return [
            'list' => $list
        ];
    }
}
