<?php declare(strict_types = 1);

namespace Record;

use Classes\Record;

class User extends Record
{
    /**
     * Vérifie si un user existe
     */
    public function loginExists($login): bool
    {
        $smt = $this->db->prepare("SELECT count(*) AS cnt FROM `{$this->tableName}` WHERE login=?");
        $smt->execute([$login]);
        $res = $smt->fetch();

        if(!isset($res['cnt']) || false === $res) {
            return false;
        } elseif($res['cnt']==0) {
            return false;
        }
        return true;
    }

    /**
     * Vérifie le password
     */
    public function checkLoginPassword(string $login, string $password): ?int
    {
        $sql = "SELECT id, `password` FROM `{$this->tableName}` WHERE login=?";
        $smt = $this->db->prepare($sql);
        $smt->execute([$login]);
        $res = $smt->fetch();

        if(!isset($res['id']) || false === $res) {
            return null;
        } elseif(!is_int( (int)$res['id'] )) {
            return false;
        }

        if(password_verify($password, $res['password'])) {
            return (int)$res['id'];
        } else {
            return null;
        }
    }
}
