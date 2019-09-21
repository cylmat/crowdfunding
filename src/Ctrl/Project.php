<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Project as ProjectRecord;

class Project extends Ctrl
{
    function createAction()
    {   
        //Envoi du formulaire de création
        if($this->post) {
            $project = new ProjectRecord('project');
            $project = $this->post['title'];
        }
        
        return [
            
        ];
    }

    function getAction()
    {
        
    }
}
