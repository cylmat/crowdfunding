<?php declare(strict_types = 1);

namespace Classes;

abstract class Record extends Database
{
    /**
     * Values
     */
    protected $values = [];

    /**
     * Id
     */
    protected $id;

    /**
     * Class name
     * 
     * @var string
     */
    protected $tableName;

    /**
     * Recupere la table correspondant à la class
     */
    public function __construct($tableName=null)
    {
        parent::__construct();
        if(!$tableName) {
            $this->tableName = strtolower(basename(self::class));
        } else {
            $this->tableName = $tableName;
        }
    }

    /**
     * throw InvalidArgumentException
     */
    function __set(string $name, string $value)
    {
        if(property_exists($this, $name)) {
            $this->values[$name] = $value;
            return;
        }
        throw new \InvalidArgumentException("Le paramètre $name n'existe pas");
    }

    /**
     * throw InvalidArgumentException
     */
    function __get(string $name)
    {
        if('id' === $name && !is_null($this->id)) {
            return $this->id;
        }
        
        if(array_key_exists($name, $this->values)) {
            return $this->values[$name];
        }
        throw new \InvalidArgumentException("Le paramètre $name n'existe pas");
    }

    function create(): bool
    {
        $smt = $this->db->prepare("INSERT INTO {$this->tableName} ( {$this->keysList()} ) VALUES ( {$this->valuesToPrepare()} );");
        $res = $smt->execute($this->bindingList());
        if(true ===$res) {
            $this->id = $this->lastInsertId();
        }
        return $res;
    }

    function update(): bool
    {
        $prep = "UPDATE {$this->tableName} SET {$this->valuesToUpdate()} WHERE id={$this->id};";
        $smt = $this->db->prepare($prep);
        /*foreach($this->bindingList() as $k=>$v) {
            $res = str_replace($k,$this->db->quote($v),$res);
        }*/
        return $smt->execute($this->bindingList());
    }

    function delete(int $id): bool
    {
        $smt = $this->db->prepare("DELETE FROM {$this->tableName} WHERE id=:id;");
        return $smt->execute([':id'=>$id]);
    }

    function get(int $id): ?array
    {
        $smt = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE id=:id;");
        $smt->execute([':id'=>$id]);
        
        if(false !== ($res = $smt->fetch(\PDO::FETCH_ASSOC))) {
            $this->values = $res;
            unset($this->values['id']);
            $this->id = $id;
            return $res;
        }
        return null; 
    }

    public function gets(): array
    {

    }

    public function lastInsertId(): int
    {
        return (int)$this->db->lastInsertId();
    }


    /**
     * @return array [:k1=>val1, :k2=>val2]
     */
    protected function bindingList(): array
    {
        $values = array_flip($this->values);
        array_walk(
            $values, function (&$v, $k) {
                $v = ':'.$v;
            }
        );
        return array_flip($values);
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
