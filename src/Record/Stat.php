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
        
        $smt = $this->db->prepare("INSERT INTO {$this->tableName} ( {$this->keysList()} ) VALUES ( {$this->valuesToPrepare()} );");

        if(self::$debug) {
            print "INSERT INTO {$this->tableName} ( {$this->keysList()} ) VALUES ( {$this->valuesToPrepare()} );";
            print_r($this->bindingList());
            return false;
        } else {
            $res = $smt->execute($this->bindingList());
            $this->smt = $smt;
            return $res;
        }
    }

}
