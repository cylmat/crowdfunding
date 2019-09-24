<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class User extends Record
{
    public function loginExists($login): ?bool
    {
        $smt = $this->db->prepare("SELECT count(*) AS cnt FROM `user` WHERE login=?");
        $smt->execute([$login]);
        $res = $smt->fetch();

        if(!isset($res['cnt']) || false === $res) {
            return null;
        } elseif($res['cnt']==0) {
            return false;
        }
        return true;
    }
}
