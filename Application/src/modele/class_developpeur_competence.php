<?php

class Developpeur_Competence
{
    // DEV = iddev, nom, prenom, mail, idremu, idrole
    // DEV_COMP = iddevcomp, iddev, idcomp
    // COMP = idcomp, libelle, version

    #region Properties
    private $db;
    private $select;
    private $selectById;
    private $selectByIdDev;
    private $selectByIdComp;
    private $selectCount;
    private $insert;
    private $update;
    private $deleteByIdDev;
    private $deleteByIdComp;
    #endregion

    #region Constructor
    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("SELECT dc.iddevcomp, dc.iddev, dc.idcomp, d.nom, d.prenom, c.libelle, c.version
                                    FROM developpeur_competence dc
                                    INNER JOIN developpeur d ON dc.iddev = d.iddev
                                    INNER JOIN competence c ON dc.idcomp = c.idcomp");
        $this->selectById = $db->prepare("SELECT iddevcomp, iddev, idcomp FROM developpeur_competence WHERE iddevcomp = :iddevcomp");
        $this->selectByIdDev = $db->prepare("SELECT d.nom, d.prenom, c.libelle, c.version
                                            FROM developpeur_competence dc
                                            INNER JOIN developpeur d ON dc.iddev = d.iddev
                                            INNER JOIN competence c ON dc.idcomp = c.idcomp
                                            WHERE dc.iddev = :iddev");
        $this->selectByIdComp = $db->prepare("SELECT d.nom, d.prenom, c.libelle, c.version
                                            FROM developpeur_competence dc
                                            INNER JOIN developpeur d ON dc.iddev = d.iddev
                                            INNER JOIN competence c ON dc.idcomp = c.idcomp
                                            WHERE dc.idcomp = :idcomp");
        $this->selectCount = $db->prepare("SELECT COUNT(*) FROM developpeur_competence");
        $this->insert = $db->prepare("INSERT INTO developpeur_competence (iddev, idcomp) VALUES (:iddev, :idcomp)");
        $this->update = $db->prepare("UPDATE developpeur_competence SET iddev = :iddev, idcomp = :idcomp WHERE developpeur_competence.iddevcomp = :iddevcomp");
        $this->deleteByIdDev = $db->prepare("DELETE FROM developpeur_competence WHERE developpeur_competence.iddev = :iddev");
        $this->deleteByIdComp = $db->prepare("DELETE FROM developpeur_competence WHERE developpeur_competence.idcomp = :idcomp");
    }
    #endregion

    #region Functions
    #region Select
    public function select() 
    {
        $this->select->execute();

        if ($this->select->errorCode() != 0) 
        {
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function selectById($iddevcomp) 
    {
        $this->selectById->execute(array(':iddevcomp' => $iddevcomp));

        if ($this->selectById->errorCode() != 0) 
        {
            print_r($this->selectById->errorInfo());
        }

        return $this->selectById->fetch();
    }

    public function selectByIdDev($iddev)
    {
        $this->selectByIdDev->execute(array(':iddev' => $iddev));

        if ($this->selectByIdDev->errorCode() != 0)
        {
            print_r($this->selectByIdDev->errorInfo());  
        }

        return $this->selectByIdDev->fetchAll();
    }

    public function selectByIdComp($idcomp)
    {
        $this->selectByIdDev->execute(array(':idcomp' => $idcomp));

        if ($this->selectByIdComp->errorCode() != 0)
        {
            print_r($this->selectByIdComp->errorInfo());  
        }

        return $this->selectByIdComp->fetchAll();
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
    #endregion

    public function insert($iddev, $idcomp) 
    {
        $r = true;

        $this->insert->bindValue(':iddev', $iddev, PDO::PARAM_STR);
        $this->insert->bindValue(':idcomp', $idcomp, PDO::PARAM_STR);
        $this->insert->execute();

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function update($iddevcomp, $iddev, $idcomp) 
    {
        $r = true;

        $this->update->execute(array(':iddevcomp' => $iddevcomp, ':iddev' => $iddev, ':idcomp' => $idcomp));
        
        if ($this->update->errorCode() != 0)
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function deleteByIdDev($iddev) 
    {
        $r = true;

        $this->deleteByIdDev->execute(array(':iddev' => $iddev));

        if ($this->deleteByIdDev->errorCode() != 0) 
        {
            print_r($this->deleteByIdDev->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function deleteByIdComp($idcomp) 
    {
        $r = true;

        $this->deleteByIdComp->execute(array(':idcomp' => $idcomp));

        if ($this->deleteByIdComp->errorCode() != 0) 
        {
            print_r($this->deleteByIdComp->errorInfo());
            $r = false;
        }

        return $r;
    }

    #endregion
}

?>