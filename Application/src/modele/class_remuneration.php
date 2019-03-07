<?php

class Remuneration {
    // idremu, cout_horaire
    #region Properties
    private $db;
    private $select;
    private $selectById;
    private $selectCount;
    private $insert;
    private $update;
    private $delete;
    #endregion

    #region Constructor
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("SELECT idremu, cout_horaire FROM remuneration ORDER BY cout_horaire");
        $this->selectById = $db->prepare("SELECT idremu, cout_horaire FROM remuneration WHERE idremu = :idremu");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM remuneration");
        $this->insert = $db->prepare("INSERT INTO remuneration(cout_horaire) VALUES (:cout_horaire)");
        $this->update = $db->prepare("UPDATE remuneration SET cout_horaire = :cout_horaire WHERE idremu = :idremu");
        $this->delete = $db->prepare("DELETE FROM remuneration WHERE idremu = :idremu");
    }
    #endregion

    #region Functions
    public function select() 
    {
        $this->select->execute();

        if ($this->select->errorCode() != 0) 
        {
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function selectById($idremu) 
    {
        $this->selectById->execute(array(':idremu' => $idremu));

        if ($this->selectById->errorCode() != 0) 
        {
            print_r($this->selectById->errorInfo());
        }

        return $this->selectById->fetch();
    }

    public function selectCount() 
    {
        $this->selectCount->execute();

        if ($this->selectCount->errorCode() != 0) 
        {
            print_r($this->selectCount->errorInfo());
        }

        return $this->selectCount->fetchColumn();
    }

    public function insert($cout_horaire) 
    {
        $r = true;
        $this->insert->bindValue(':cout_horaire', $cout_horaire, PDO::PARAM_STR);
        $this->insert->execute();

        if ($this->insert->errorCode() != 0)
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function update($idremu, $cout_horaire) 
    {
        $r = true;
        $this->update->execute(array(':idremu' => $idremu, ':cout_horaire' => $cout_horaire));
        
        if ($this->update->errorCode() != 0) 
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($idremu) 
    {
        $r = true;
        $this->delete->execute(array(':idremu' => $idremu));

        if ($this->delete->errorCode() != 0) 
        {
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }
    #endregion
}

?>