<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Project as ProjectRecord;
use Classes\Session;

class ProjectCtrl extends Ctrl
{
    function createAction()
    {   
        $msg = '';
        $form = [];

        //Envoi du formulaire de création
        if($this->post) {
            $msg = 'Une erreur est survenue lors de la création du projet';
            $form = $this->post;

            $project = new ProjectRecord();
            $project->titre = $this->post['titre'];
            $project->description = $this->post['description'];
            $project->resume = $this->post['resume'];
            $project->fk_id_user = Session::get('id_user');

            $project->somme = $this->post['somme'];
            $project->max_date = $this->post['max_date'];

            if(isset($_FILES['image_url']) && !$_FILES['image_url']['error']) {
                $url = ASSETS.'img/'.$_FILES['image_url']['name'];
                move_uploaded_file($_FILES['image_url']['tmp_name'], $url);
                
                $project->image_url = $url;
                if($project->create()) {
                    //REDIRECT
                    $msg = 'Votre projet a bien été crée';
                    $form = [];
                }
            } else {
                $msg = 'Merci de bien vouloir recharger votre image';
            }
        }

        return [
            'msg' => $msg,
            'form' => $form,
            'nom_user' => \Classes\Session::get('prenom_user') . ' ' . \Classes\Session::get('nom_user') 
        ];
    }

    function getAction()
    {
        if(is_null($this->get['id'] || !ctype_digit($this->get['id']))) {
            redirect('project_list');
        }

        $project = new ProjectRecord();
        $project = $project->get((int)$this->get['id']);
        if(is_null($project)) {
            redirect(url('project_list'));
        }
        return [
            'project' => $project
        ];
    }

    function listAction()
    {
        $project = new ProjectRecord();
        $list = $project->getAll();

        return [
            'list' => $list
        ];
    }
}
