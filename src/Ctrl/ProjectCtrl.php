<?php declare(strict_types = 1);

namespace Ctrl;

use Classes\Ctrl;
use Record\Project as ProjectRecord;
use Record\USer as UserRecord;
use Record\Stat as StatRecord;
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
            $project->titre = ($this->post['titre']);
            $project->description = ($this->post['description']);
            $project->resume = ($this->post['resume']);
            $project->fk_id_user = Session::get('id_user');
            $project->category_num = $this->post['category_num'];

            $project->somme_necessaire = (int)$this->post['somme'];
            $project->date_fin = $this->post['date_fin'];

            if(isset($_FILES['image_url']) && !$_FILES['image_url']['error']) {
                $url = ASSETS.'img/'.$_FILES['image_url']['name'];
                move_uploaded_file($_FILES['image_url']['tmp_name'], $url);

                $project->image_url = REL_ASSETS.'img/'.$_FILES['image_url']['name'];
                if($project->create()) {
                    //REDIRECT
                    $msg = 'Votre projet a bien été crée';
                    $form = [];
                    
                    /**
                     * Random data pour simuler les donateurs
                     */
                    (new StatRecord)->insertRandomDons((int)$project->lastInsertId());
                    
                    redirect(url('project_list'));
                } else {
                    $project->getLastError();
                }
            } else {
                $msg = 'Merci de bien vouloir recharger votre image';
            }
        }

        return [
            'msg' => $msg,
            'is_create' => true,
            'title' => 'Création',
            'form' => $form,
            'nom_user' => \Classes\Session::get('prenom_user') . ' ' . \Classes\Session::get('nom_user') 
        ];
    }

    function updateAction()
    {
        $msg = '';
        $form = [];
        
        $project = new ProjectRecord();
        $form = $project->getDataId((int)$this->get['id']); 
        
        $user = new UserRecord;
        $user->get( (int)$project->fk_id_user );
        
        //Envoi du formulaire de création
        if($this->post) {
            $msg = 'Une erreur est survenue lors de la modification du projet';
            $form = $this->post;
            
            $project->titre = ($this->post['titre']);
            $project->description = ($this->post['description']);
            $project->resume = ($this->post['resume']);
            $project->category_num = $this->post['category_num'];
            
            if(isset($_FILES['image_url']) && !$_FILES['image_url']['error']) {
                $url = ASSETS.'img/'.$_FILES['image_url']['name'];
                move_uploaded_file($_FILES['image_url']['tmp_name'], $url);
                
                $project->image_url = REL_ASSETS.'img/'.$_FILES['image_url']['name'];
            }
            
            if($project->update()) {
                //REDIRECT
                $msg = 'Votre projet a bien été modifié';
                
                /**
                 * Random data pour simuler les donateurs
                 */
                (new StatRecord)->insertRandomDons((int)$this->get['id']);
            }
        }
        
        return [
            'is_create' => false,
            'title' => 'Modification',
            'msg' => $msg,
            'form' => $form,
            'nom_user' => $user->prenom.' '.$user->nom 
        ];
    }

    function randAction()
    {
        $project = new ProjectRecord();
        $list = $project->getAllDatas();

        //Si pas de projets actifs
        if(empty($list)) {
            redirect(url('project_list'));
        }

        $id = $list[array_rand($list)]['id'];
        redirect(url('project_get_id='.$id));
    }

    function getAction()
    {
        if(is_null($this->get['id'] || !ctype_digit($this->get['id']))) {
            redirect('project_list');
        }

        $project = new ProjectRecord();
        $project = $project->getDataId((int)$this->get['id']);
   
        if(is_null($project)) {
            redirect(url('project_list'));
        }
        return [
            'project' => $project,
            'is_admin' => Session::get('is_admin')?true:false
        ];
    }

    function listmyAction()
    {
        $project = new ProjectRecord();
        $id_user = \Classes\Session::get('id_user');
        $list = $project->getAllDatas();

        $result = [];
        $others = [];
        foreach($list as $prj) {
            if($prj['fk_id_user'] == $id_user) {
                $result[] = $prj;
            } elseif(is_admin()) {
                $others[] = $prj;
            } 
        }
        
        return [
            'list' => $result,
            'others' => $others //if admin
        ];
    }

    function listAction()
    {
        $project = new ProjectRecord();
        $list = $project->getAllDatas();

        return [
            'list' => $list
        ];
    }
}
