<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class Project extends Record
{
    function getLastData()
    {
        $smt = $this->db->prepare("SELECT * FROM {$this->tableName} ORDER by DATE_CREATION DESC LIMIT 1");
        $smt->execute();
        $this->smt = $smt;
        
        if(false !== ($res = $smt->fetch(\PDO::FETCH_ASSOC))) {
            $this->setDatas($res);
            return $res;
        }
        return null; 
    }

    /**
     * Get all projects with added datas
     */
    function getAllDatas()
    {
        $results = $this->getAll();
        foreach($results as &$res) {
            $this->setDatas($res);
        }
        return $results;
    }

    /**
     * Get project id
     */
    function getDataId(int $id)
    {
        $res = $this->get($id);
        $this->setDatas($res);
        return $res;
    }

    function setDatas(array &$res): void
    {
        $res['category'] = \Model\ProjectModel::getCategory($res['category_num']);
        $res['percent'] = \Model\ProjectModel::getDonatorPercent($res['somme_necessaire'], $res['stats_somme_rec']);
        $res['days_reste'] = \Model\ProjectModel::getDaysToEnd($res['date_fin']);
    }

    /*
     * @param $somme int Somme récoltée
     * @param $dons int Nombre de donateurs
     */
    function randomizeStats(int $somme=1000, int $dons=300)
    {
        $sql = "UPDATE project SET stats_somme_rec = ROUND(RAND()*?), stats_nb_dons = ROUND(RAND()*?)";
        $smt = $this->db->prepare($sql);
        $smt->execute([$somme, $dons]);
        $this->smt = $smt;
        
        if(false !== ($res = $smt->fetch(\PDO::FETCH_ASSOC))) {
            return $res;
        }
        return null; 
    }
}
