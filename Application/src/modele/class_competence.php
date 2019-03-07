<?php

class Competence 
{
    //idcomp, libelle, version
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
    public function __construct($db) 
    {
        $this->db = $db;
        $this->select = $db->prepare("SELECT idcomp, libelle, version FROM competence ORDER BY libelle");
        $this->selectById = $db->prepare("SELECT idcomp, libelle, version FROM competence WHERE idcomp = :idcomp");
        $this->selectCount = $db->prepare("SELECT COUNT(*) FROM competence");
        $this->insert = $db->prepare("INSERT INTO competence(libelle, version) VALUES (:libelle, :version)");
        $this->update = $db->prepare("UPDATE competence SET libelle = :libelle, version = :version WHERE idcomp = :idcomp");
        $this->delete = $db->prepare("DELETE FROM competence WHERE idcomp = :idcomp");
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

    public function selectById($idcomp)
    { 
        $this->selectById->execute(array(':idcomp' => $idcomp)); 

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

    public function insert($libelle, $version) 
    {
        $r = true;

        $this->insert->bindValue(':libelle', $libelle, PDO::PARAM_STR);
        $this->insert->bindValue(':version', $version, PDO::PARAM_STR);
        $this->insert->execute();

        if ($this->insert->errorCode() != 0)
        {
            print_r($this->insert->errorInfo());  
            $r = false;
        }
        
        return $r;
    }

    public function update($idcomp, $libelle, $version) 
    {
        $r = true;
        $this->update->execute(array(':idcomp' => $idcomp, ':libelle' => $libelle, ':version' => $version));
        
        if ($this->update->errorCode() != 0)
        {
            print_r($this->update->errorInfo());  
            $r = false;
        }

       return $r;
    }

    public function delete($idcomp)
    {
        $r = true;
        $this->delete->execute(array(':idcomp' => $idcomp));

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