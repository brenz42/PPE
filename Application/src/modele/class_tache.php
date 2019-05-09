<?php

class Tache
{
    #region Properties
    private $db;
    private $select;
    private $selectById;
    private $selectByIdProjet;
    private $selectForDashboard;
    private $insert;
    private $update;
    private $delete;
    #endregion

    #region Constructor
    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("SELECT idtache, libelle, etat, cout, projet.libelle FROM tache, projet WHERE tache.idprojet = projet.idprojet ORDER BY libelle ");
        $this->selectById = $db->prepare("SELECT idtache, libelle, etat, cout, idprojet FROM tache WHERE idtache = :idtache");
        $this->selectByIdProjet = $db->prepare("SELECT idtache, libelle, etat, cout, idprojet FROM tache WHERE idprojet = :idprojet");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM tache");
        $this->selectForDashboard = $db->prepare("SELECT ttac.libelle AS Tâche, tproj.libelle AS Projet, tdev.nom AS Nom, tdev.prenom AS Prénom, tprio.libelle AS Priorité, tprio.couleur AS CouleurPrio, tprog.valeur AS Progression, tprog.couleur AS CouleurProg
                                                FROM developpeur_tache tdevta
                                                LEFT OUTER JOIN developpeur tdev ON tdevta.iddev = tdev.iddev
                                                LEFT OUTER JOIN tache ttac ON tdevta.idtache = ttac.idtache
                                                LEFT OUTER JOIN projet tproj ON ttac.idprojet = tproj.idprojet
                                                LEFT OUTER JOIN progression tprog ON ttac.idprogression = tprog.idprogr
                                                LEFT OUTER JOIN priorite tprio ON ttac.idpriorite = tprio.idprio");
        $this->insert = $db->prepare("INSERT INTO tache(libelle, etat, cout, idprojet) VALUES (:libelle, :etat, :cout, :idprojet)");
        $this->update = $db->prepare("UPDATE libelle SET libelle = :libelle, etat = :etat, cout = :cout, idprojet = :idprojet WHERE idtache = :idtache");
        $this->delete = $db->prepare("DELETE FROM tache WHERE idtache = :idtache");
        $this->deleteByIdProjet = $db->prepare("DELETE FROM tache WHERE tache.idprojet = :idprojet");   }
    #endregion

    #region Functions
    public function select()
    {
        $this->slelect->execute();
        
        if ($this->select->errorCode() != 0) 
        {
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function selectById($id)
    {
        $this->selectById->excute(array(':idtache' => $id));

        if ($this->selectById->errorCode() != 0) 
        {
            print_r($this->selectById->errorInfo());
        }

        return $this->selectById->fetch();
    }

    public function selectByIdProjet($idprojet)
    {
        $this->selectByIdProjet->execute(array(':idprojet' => $idprojet));

        if ($this->selectByIdProjet->errorCode() != 0) 
        {
            print_r($this->selectByIdProjet->errorInfo());
        }

        return $this->selectByIdProjet->fetchAll();
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

    public function selectForDashboard()
    {
        $this->selectForDashboard->execute();

        if ($this->selectForDashboard->errorCode() != 0) 
        {
            print_r($this->selectForDashboard->errorInfo());  
        }

        return $this->selectForDashboard->fetchAll();
    }

    public function insert($libelle, $etat, $cout, $idprojet)
    {
        $r = true;
        
        $this->insert->bindValue(':libelle', $libelle, PDO::PARAM_STR);
        $this->insert->bindValue(':etat', $etat, PDO::PARAM_STR);
        $this->insert->bindValue(':cout', $cout, PDO::PARAM_STR);
        $this->insert->bindValue(':idprojet', $idprojet, PDO::PARAM_STR);
        $this->insert->execute();

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function update($id, $libelle, $etat, $cout, $idprojet)
    {
        $r = true;
        $this->update->execute(array(':idtache' => $id, ':libelle' => $libelle, ':etat' => $etat, ':cout' => $cout, ':idprojet' => $idprojet));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function delete($id)
    {
        $r = true;
        $this->delete->execute(array(':idtache' => $id));

        if ($this->delete->errorCode() != 0) 
        {
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function deleteByIdProjet($idprojet)
    {
        $r = true;
        $this->deleteByIdProjet->execute(array(':idprojet' => $idprojet));

        if ($this->deleteByIdProjet->errorCode() != 0) 
        {
            print_r($this->deleteByIdProjet->errorInfo());
            $r = false;
        }

        return $r;
    }
    #endregion
}

?>