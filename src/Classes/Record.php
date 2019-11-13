<?php declare(strict_types = 1);

namespace Classes;

/**
 * Simule un ORM ActiveRecord
 * 
 * Permet la relation entre la base de données et les classes d'appel
 * Le nom des colonnes est récupéré grâce à une première requête SELECT
 */
abstract class Record extends Database
{
    /**
     * Valeurs
     */
    protected $values = [];

    
    /**
     * Nom des colonnes
     */
    protected $columns;
    
    /**
     * Id
     */
    protected $id;
    
    /**
     * Table name
     * 
     * @var string
     */
    protected $tableName;
    
    /**
     * Statement PDO
     * 
     * @var PDOStatement
     */
    protected $smt;
    
    /**
     * Debug mode activé ou non
     */
    protected static $debug = false;
    
    /**
     * Recupere la table correspondant à la classe
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableName = '3wa_'.strtolower(str_replace('Record\\','',static::class));
        $this->columns = $this->getColumns();
    }

    /**
     * Set debug
     */
    public function debug()
    {
        self::$debug = true;
        return $this;
    }
    
    /**
     * @return void
     * @throw InvalidArgumentException
     */
    function __set(string $name,  $value)
    {
        if(in_array($name, $this->columns)) {
            $this->values[$name] = $value;
            return;
        }
        throw new \InvalidArgumentException("Le paramètre $name n'existe pas dans la base de données");
    }

    /**
     * @return mixed
     * @throw InvalidArgumentException
     */
    function __get(string $name)
    {
        if('id' === $name && !is_null($this->id)) {
            return $this->id;
        }
        
        if(array_key_exists($name, $this->values)) {
            return $this->values[$name];
        }
        throw new \InvalidArgumentException("Le paramètre $name n'existe pas dans la base de données");
    }

    /**
     * Créer une requête INSERT
     */
    function create(): bool
    {
        $smt = $this->db->prepare("INSERT INTO {$this->tableName} ( {$this->keysList()} ) VALUES ( {$this->valuesToPrepare()} );");
        if(self::$debug) {
            print "INSERT INTO {$this->tableName} ( {$this->keysList()} ) VALUES ( {$this->valuesToPrepare()} );";
            print_r($this->bindingList());
            return false;
        } else {
            $res = $smt->execute($this->bindingList());
            $this->smt = $smt;
            if(true ===$res) {
                $this->id = $this->lastInsertId();
            }
            return $res;
        }
    }

    /**
     * Requête UPDATE
     */
    function update(): bool
    {
        $prep = "UPDATE {$this->tableName} SET {$this->valuesToUpdate()} WHERE id={$this->id};";
        $smt = $this->db->prepare($prep);
        if(self::$debug) {
            print $prep;
            print_r($this->bindingList());
            return false;
        } else {
            $exec = $smt->execute($this->bindingList());
            $this->smt = $smt;
            return $exec;
        }
    }

    /**
     * Requête DELETE
     */
    function delete(int $id): bool
    {
        $smt = $this->db->prepare("DELETE FROM {$this->tableName} WHERE id=?;");
        $exec = $smt->execute([$id]);
        $this->smt = $smt;
        return $exec;
    }

    /**
     * Requête SELECT 
     * Un seul retour, sélectionné par l'ID
     */
    function get(int $id, $and_where=''): ?array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id=? $and_where;";
        $smt = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE id=?;");
        $smt->execute([$id]);
        $this->smt = $smt;
        
        if(false !== ($res = $smt->fetch(\PDO::FETCH_ASSOC))) {
            $this->values = $res;
            unset($this->values['id']);
            $this->id = $id;
            return $res;
        }
        return null; 
    }

    /**
     * Requete SELECT globale
     */
    public function getAll($where=''): array
    {
        $smt = $this->db->prepare("SELECT * FROM {$this->tableName} $where;");
        $smt->execute();
        $this->smt = $smt;
        
        if(false !== ($res = $smt->fetchAll(\PDO::FETCH_ASSOC))) {
            return $res;
        }
        return null; 
    }

    public function lastInsertId(): int
    {
        return (int)$this->db->lastInsertId();
    }

    /**
     * Retourne erreur statemement si il y en a
     */
    public function getLastError(): ?string
    {
        if($this->smt && $e=$this->smt->errorInfo()[2]) {
            return $e;
        } else {
            return null;
        }
    }



    /**
     * Recupere les informations de schema à partir de la base de donnée
     */
    protected function getColumns(): ?array
    {
        $sql =  "SELECT * FROM {$this->tableName}";
        $smt = $this->db->prepare($sql);
        $smt->execute([$this->tableName]);
        $this->smt = $smt;

        if(false !== ($res = $smt->fetchAll(\PDO::FETCH_ASSOC))) {
            $columns=[];

            foreach($res as $name => $vals) {
                if('id' !== $name) {
                    $columns[] = $name;
                }
            }
            return $columns;
        } else {
            return null;
        }
    }

    /**
     * @return array [:k1=>val1, :k2=>val2]
     */
    protected function bindingList(): array
    {
        $ret = [];
        foreach($this->values as $key => $value) {
            $ret[':'.$key] = $value;
        }
        return $ret;
    }

    /**
     * @return string k1, k2, k3
     */
    protected function keysList(): string
    {
        return implode(', ', array_keys($this->values));
    }

    /**
     * @return string :val1, :val2
     */
    protected function valuesToPrepare(): string
    {
        $values = array_map(
            function ($v) {
                return ':'.$v;
            }, array_keys($this->values)
        );
        return implode(',', $values);
    }

    /**
     * @return string k1=:k1, k2=:k2
     */
    protected function valuesToUpdate(): string
    {
        $values = array_keys($this->values);
        if(false !== ($key = array_search('id', $values))) {
            unset($values[$key]);
        }
        array_walk(
            $values, function (&$v, $k) {
                $v = $v.'=:'.$v;
            }
        );
        return implode(', ', $values);
    }
}
