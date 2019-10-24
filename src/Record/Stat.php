<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class Stat extends Record
{
    /**
     * Permet de simuler les dons 
     * Dans le cadre du Projet -Crowdfunding-
     */
    function insertRandomDons(int $project_id)
    {
        $r = rand(10,20);
        $d1 = (new \DateTime('2019-01-01'))->getTimestamp();
        $d2 = (new \DateTime())->getTimestamp();
        
        $r_date = (new \DateTime())->setTimestamp(mt_rand($d1, $d2));
        
        for($i=0; $i<$r; $i++) {
            $this->fk_id_project = $project_id;
            $this->montant = rand(10,200);
            $this->date_don = $r_date->format('Y-m-d H:i:s');
        }
        
        $sql = "INSERT INTO {$this->tableName} ( {$this->keysList()} ) VALUES ( {$this->valuesToPrepare()} );";
        $smt = $this->db->prepare($sql);

        if(self::$debug) {
            print $sql;
            print_r($this->bindingList());
            return false;
        } else {
            $res = $smt->execute($this->bindingList());
            $this->smt = $smt;
            return $res;
        }
    }

    function getByIdProject(int $id_project)
    {
        $sql = "SELECT *, 
            (SELECT COUNT(*) FROM `{$this->tableName}` WHERE `fk_id_project` = $id_project) AS compte,
            (SELECT SUM(montant) FROM `{$this->tableName}` WHERE `fk_id_project` = $id_project) AS somme
            FROM `{$this->tableName}` WHERE `fk_id_project` = $id_project";
        $smt = $this->db->prepare($sql);

        if(self::$debug) {
            print $sql;
            return false;
        } else {
            $res = $smt->execute($this->bindingList());
            $this->smt = $smt;
            return $smt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    function getAllByDate()
    {
        $sql = "SELECT MONTH(date_don) as month_don, YEAR(date_don) as year_don, montant, ".
            "COUNT(*) as count_total, SUM(montant) as somme ".
            "FROM `{$this->tableName}` GROUP BY MONTH(date_don) ORDER BY date_don";
        $smt = $this->db->prepare($sql);

        if(self::$debug) {
            print $sql;
            return false;
        } else {
            $res = $smt->execute($this->bindingList());
            $this->smt = $smt;
            return $smt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
