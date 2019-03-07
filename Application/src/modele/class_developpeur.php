<?php

class Developpeur 
{
    //iddev, nom, prenom, mail, idremu, idrole
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
        $this->select = $db->prepare("SELECT iddev, nom, prenom, mail, developpeur.idremu, remuneration.cout_horaire 
                                    FROM developpeur 
                                    LEFT JOIN remuneration ON developpeur.idremu = remuneration.idremu
                                    ORDER BY nom");
        $this->selectById = $db->prepare("SELECT iddev, nom, prenom, mail, developpeur.idremu, developpeur.idrole, remuneration.cout_horaire, role.libelle 
                                        FROM developpeur 
                                        LEFT JOIN remuneration ON developpeur.idremu = remuneration.idremu 
                                        LEFT JOIN role ON developpeur.idrole = role.idrole 
                                        WHERE iddev = :iddev");
        $this->selectCount = $db->prepare("SELECT COUNT(*) FROM developpeur");
        $this->insert = $db->prepare("INSERT INTO developpeur(nom, prenom, mail, idremu, idrole) VALUES (:nom, :prenom, :mail, :idremu, :idrole)");
        // $this->insert = $db->prepare("INSERT INTO developpeur(nom, prenom, mail, mdp, idremu, idrole) VALUES (:nom, :prenom, :mail, :mdp, :idremu, :idrole)");
        $this->update = $db->prepare("UPDATE developpeur SET nom = :nom, prenom = :prenom, mail = :mail, idremu = :idremu, idrole = :idrole WHERE iddev = :iddev");
        // $this->update = $db->prepare("UPDATE developpeur SET nom=:nom, prenom=:prenom, mail=:mail, mdp=:mdp, idremu=:idremu, idrole=:idrole WHERE iddev=:iddev");
        $this->delete = $db->prepare("DELETE FROM developpeur WHERE iddev = :iddev");
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

    public function selectById($iddev) 
    {
        $this->selectById->execute(array(':iddev' => $iddev));

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

    public function insert($nom, $prenom, $mail, $idremu, $idrole) 
    {
        $r = true;

        $this->insert->bindValue(':nom', $nom, PDO::PARAM_STR);
        $this->insert->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $this->insert->bindValue(':mail', $mail, PDO::PARAM_STR);
        $this->insert->bindValue(':idremu', $idremu, PDO::PARAM_STR);
        $this->insert->bindValue(':idrole', $idrole, PDO::PARAM_STR);
        $this->insert->execute();

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function update($iddev, $nom, $prenom, $mail, $idremu, $idrole) 
    {
        $r = true;

        $this->update->execute(array(':iddev' => $iddev, ':nom' => $nom, ':prenom' => $prenom, ':mail' => $mail, 'idremu' => $idremu, 'idrole' => $idrole));
        
        if ($this->update->errorCode() != 0)
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($iddev) 
    {
        $r = true;

        $this->delete->execute(array(':iddev' => $iddev));

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