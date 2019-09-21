<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Project;

class Project extends Ctrl
{
    function createAction()
    {   
        //Envoi du formulaire de création
        if($this->post) {
            $project = new Project('project');
            $project = $this->post['title'];
        }
        
        return [
            
        ];
    }

    function getAction()
    {
        
    }
}
