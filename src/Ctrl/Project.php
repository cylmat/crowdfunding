<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Project as ProjectRecord;
use Classes\Session;

class Project extends Ctrl
{
    function createAction()
    {   
        $msg = '';

        //Envoi du formulaire de création
        if($this->post) {
            $project = new ProjectRecord('project');
            $project->title = $this->post['title'];
            $project->description = $this->post['description'];
            $project->fk_id_user = Session::get('id_user');

            if($project->create()) {
                $msg = "Le projet vient d'être crée";
            }
        }
        
        return [
            'msg' => $msg
        ];
    }

    function getAction()
    {
        
    }

    function listAction()
    {
        $project = new ProjectRecord('project');
        $list = $project->getAll();

        return [
            'list' => $list
        ];
    }
}
