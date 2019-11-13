<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;
use Record\User as UserRecord;
use Record\Stat as StatRecord;

/**
 * Recupère les données d'un projet
 */
class Project extends Record
{
    /**
     * Récupère le dernier projet pour la page d'accueil
     */
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
     * Recupère les projets 
     */
    function getAllDatas()
    {
        $results = $this->getAll('WHERE actif=1');
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
        $res = $this->get($id, "AND actif=1");
        if(is_array($res))
            $this->setDatas($res);
        return $res;
    }

    /**
     * Rajoute des données au projets récupérés
     * 
     * ex: le nombre de dons récoltés, le pourcentage correspondant, les jours restants, etc...
     */
    function setDatas(array &$res): void
    {
        $stat = new StatRecord();
        $statData = $stat->getByIdProject((int)$res['id']);

        $total = $statData[0];
        $res['stats_somme_rec'] = $total['somme'];
        $res['stats_nb_dons'] = $total['compte'];

        $res['category'] = \Model\ProjectModel::getCategory($res['category_num']);

        if($res['somme_necessaire'] && $total['somme']) {
            $res['percent'] = \Model\ProjectModel::getDonatorPercent($res['somme_necessaire'], $total['somme']);
        } else {
            $res['percent'] = 0;
        }
        $res['days_reste'] = \Model\ProjectModel::getDaysToEnd($res['date_fin']);

        $user = new UserRecord();
        $userData = $user->get((int)$res['fk_id_user']);

        $res += [
            'user_login' => ucfirst($userData['login']),
            'user_ville' => ucfirst($userData['ville']),
            'user_date_creation' => (new \DateTime($userData['date_creation']))->format('Y-m-d')
        ];
    }

    /**
     * Simulation de somme récupéré
     */
    function getRandSomme(int $somme_max)
    {
        return rand(200,$somme_max);
    }

    /**
     * Simulation du nombre de donateurs
     */
    function getRandDons()
    {
        return rand(100,300);
    }
}
