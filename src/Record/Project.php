<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class Project extends Record
{
    function getLast()
    {
        $smt = $this->db->prepare("SELECT * FROM {$this->tableName} ORDER by DATE DESC LIMIT 1");
        $smt->execute();
        $this->smt = $smt;
        
        if(false !== ($res = $smt->fetch(\PDO::FETCH_ASSOC))) {
            return $res;
        }
        return null; 
    }
}
