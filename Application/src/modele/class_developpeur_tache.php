<?php

class Developpeur_Tache
{
    // iddev, nom, prenom, mail, idremu, idrole
    // idtache, libelle, priorite, etat, cout, idprojet
    #region Properties
    private $db;
    private $select;
    private $selectByIdDev;
    private $selectByIdTache;
    private $selectCount;
    private $selectCountDevTaches;
    private $insert;
    private $update;
    private $delete;
    private $deleteByIdDev;
    private $deleteByIdTache;
    #endregion

    #region Constructor
    public function __construct($db)
    {
        $this->db = $db;

        $this->select = $db->prepare("SELECT developpeur.nom, developpeur.prenom, tache.libelle, nb_heure, date_debut, date_fin 
                                    FROM developpeur_tache, tache, developpeur 
                                    WHERE developpeur.iddev = developpeur_tache.iddev AND tache.idtache = developpeur_tache.idtache 
                                    ORDER BY date_debut");
        $this->selectByIdDev = $db->prepare("SELECT developpeur.nom, developpeur.prenom, tache.libelle, nb_heure, date_debut, date_fin 
                                           FROM developpeur_tache, tache, developpeur 
                                           WHERE developpeur_tache.iddev = :iddev AND developpeur.iddev = developpeur_tache.iddev AND tache.idtache = developpeur_tache.idtache 
                                           ORDER BY iddev ");
        $this->selectByIdTache = $db->prepare("SELECT developpeur.nom, developpeur.prenom, tache.libelle, nb_heure, date_debut, date_fin 
                                            FROM developpeur_tache, tache, developpeur 
                                            WHERE developpeur_tache.idtache = :idtache AND tache.idtache = developpeur_tache.idtache AND developpeur.iddev = developpeur_tache.iddev 
                                            ORDER BY idtache");
        $this->selectCount = $db->prepare("SELECT COUNT (*) FROM developpeur_tache"); // Compte le nombre de tâches totale
        $this->selectCountDevTaches = $db->prepare("SELECT COUNT (*) FROM developpeur_tache WHERE iddev = :iddev"); // Compte le nombre de tâches assignées à un développeur précis

        $this->insert = $db->prepare("INSERT INTO developpeur_tache(iddev, idtache, nb_heure, date_debut, date_fin) VALUES (:iddev, :idtache, :nb_heure, :date_debut, :date_fin)");
        $this->update = $db->prepare("UPDATE developpeur_tache SET nb_heure = :nb_heure, date_fin = :date_fin WHERE iddev = :iddev AND idtache = :idtache");

        $this->delete = $db->prepare("DELETE FROM developpeur_tache WHERE iddev = :iddev AND idtache = :idtache");
        $this->deleteByIdDev = $db->prepare("DELETE FROM developpeur_tache WHERE iddev = :iddev");
        $this->deleteByIdTache = $db->prepare("DELETE FROM developpeur_tache WHERE idtache = :idtache");
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

    public function selectByIdDev($iddev)
    {
        $this->selectByIdDev->execute(array(':iddev' => $iddev));

        if ($this->selectByIdDev->errorCode() != 0)
        {
            print_r($this->selectByIdDev->errorInfo());  
        }

        return $this->selectByIdDev->fetchAll();
    }

    public function selectByIdTache($idtache)
    {
        $this->selectByIdDev->execute(array(':idtache' => $idtache));

        if ($this->selectByIdTache->errorCode() != 0)
        {
            print_r($this->selectByIdTache->errorInfo());  
        }

        return $this->selectByIdTache->fetchAll();
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

    public function selectCountDevTaches($iddev)
    {
        $this->selectCountDevTaches->execute(array(':iddev' => $iddev));

        if ($this->selectCountDevTaches->errorCode() != 0)
        {
            print_r($this->selectCountDevTaches->errorInfo());  
        }

       return $this->selectCountDevTaches->fetchColumn();
    }
    #endregion

    public function insert($iddev, $idtache, $nbHeure, $dateDebut, $dateFin)
    {
        $r = true;

        $this->insert->bindValue(':iddev', $iddev, PDO::PARAM_STR);
        $this->insert->bindValue(':idtache', $idtache, PDO::PARAM_STR);
        $this->insert->bindValue(':nb_heure', $nbHeure, PDO::PARAM_STR);
        $this->insert->bindValue(':date_debut', $dateDebut, PDO::PARAM_STR);
        $this->insert->bindValue(':date_fin', $dateFin, PDO::PARAM_STR);
        $this->insert->execute();

        if ($this->insert->errorCode() != 0)
        {
            print_r($this->insert->errorInfo());  
            $r = false;
        }

        return $r;
    }

    public function update($iddev, $idtache, $nbHeure, $dateFin)
    {
        $r = true;
        $this->update->execute(array(':iddev' => $iddev, ':idtache' => $idtache, ':nb_heure' => $nbHeure, ':date_Fin' => $dateFin));

        if ($this->update->errorCode() != 0)
        {
            print_r($this->update->errorInfo());  
            $r = false;
        }

        return $r;
    }

    #region Delete
    public function delete($iddev, $idtache)
    {
        $r = true;
        $this->delete->execute(array(':iddev' => $iddev, ':idtache' => $idtache));

        if ($this->delete->errorCode() != 0)
        {
            print_r($this->delete->errorInfo());  
            $r = false;
        }

        return $r;
    }

    public function deleteByIdDev($iddev)
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

    public function deleteByIdTache($idtache)
    {
        $r = true;
        $this->delete->execute(array(':idtache' => $idtache));

        if ($this->delete->errorCode() != 0)
        {
            print_r($this->delete->errorInfo());  
            $r = false;
        }

        return $r;
    }
    #endregion
    #endregion
}

?>