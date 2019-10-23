<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class User extends Record
{
    public function loginExists($login): ?bool
    {
        $smt = $this->db->prepare("SELECT count(*) AS cnt FROM `{$this->tableName}` WHERE login=?");
        $smt->execute([$login]);
        $res = $smt->fetch();

        if(!isset($res['cnt']) || false === $res) {
            return null;
        } elseif($res['cnt']==0) {
            return false;
        }
        return true;
    }

    public function checkLoginPassword(string $login, string $password): ?int
    {
        $sql = "SELECT id FROM `{$this->tableName}` WHERE login=? AND password=?";
        $smt = $this->db->prepare($sql);
        $smt->execute([$login, $password]);
        $res = $smt->fetch();

        if(!isset($res['id']) || false === $res) {
            return null;
        } elseif(!is_int( (int)$res['id'] )) {
            return false;
        }

        return (int)$res['id'];
    }
}
