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

        //set random stats
        $project->randomizeStats();

        //last
        $last = $project->getLastData();
        /*$last['category'] = \Model\ProjectModel::getCategory($last['category_num']);
        $last['percent'] = \Model\ProjectModel::getDonatorPercent($last['somme_necessaire'], $last['stats_somme_rec']);
        $last['days_reste'] = \Model\ProjectModel::getDaysToEnd($last['date_fin']);*/
        
        //project
        $list = $project->getAllDatas();
        /*foreach($list as &$prj) {
            $prj['category'] = \Model\ProjectModel::getCategory($prj['category_num']);
            $prj['percent'] = \Model\ProjectModel::getDonatorPercent($prj['somme_necessaire'], $prj['stats_somme_rec']);
            $prj['days_reste'] = \Model\ProjectModel::getDaysToEnd($prj['date_fin']);
        }*/

        return [
            'last_project' => $last,
            'list' => $list
        ];
    }
}
