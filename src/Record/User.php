<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class User extends Record
{
    public function loginExists($login): ?bool
    {
        $smt = $this->db->prepare("SELECT count(*) AS cnt FROM `user` WHERE login=?");
        $smt->execute([$login]);

        if(!isset($smt->fetch()['cnt']) || false === $smt->fetch()) {
            return null;
        } elseif(0 !== $smt->fetch()['cnt']) {
            return true;
        }
        return false;
    }
}
