<?php 

class Contrat
{
    #region Properties
    private $db;
    private $select;
    private $selectById;
    private $selectByIdEnt;
    private $selectByIdProjet;
    private $selectCount;
    private $selectSumCout;
    private $insert;
    private $update;
    private $delete;
    #endregion

    #region Constructor
    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("SELECT c.idcontrat, date_debut, date_fin, date_signature, cout_global, ep.nom, p.libelle
         FROM contrat c 
         LEFT OUTER JOIN
        projet p ON p.idcontrat = c.idcontrat LEFT OUTER JOIN entreprise_cliente ep On c.ident = ep.ident");
        $this->selectById = $db->prepare("SELECT c.idcontrat, date_debut, date_fin, date_signature, cout_global, ep.nom, p.libelle 
        FROM contrat c 
        LEFT OUTER JOIN projet p ON p.idcontrat = c.idcontrat 
        LEFT OUTER JOIN entreprise_cliente ep On c.ident = ep.ident 
        WHERE idcontrat = :idcontrat");
        $this->selectByIdEnt = $db->prepare("SELECT c.idcontrat, date_debut, date_fin, date_signature, cout_global, ep.nom, p.libelle 
        FROM contrat c 
        LEFT OUTER JOIN projet p ON p.idcontrat = c.idcontrat 
        LEFT OUTER JOIN entreprise_cliente ep On c.ident = ep.ident 
        WHERE ident = :ident");
        $this->selectByIdProjet = $db->prepare("SELECT c.idcontrat, date_debut, date_fin, date_signature, cout_global, ep.nom, p.libelle 
        FROM contrat c 
        LEFT OUTER JOIN projet p ON p.idcontrat = c.idcontrat 
        LEFT OUTER JOIN entreprise_cliente ep On c.ident = ep.ident 
        WHERE idprojet = :idprojet");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM contrat");
        $this->selectSumCout = $db->prepare("SELECT SUM(cout_global) FROM contrat");
        $this->insert = $db->prepare("INSERT INTO contrat (date_debut, date_fin, date_signature, cout_global, ident) VALUES (:date_debut, :date_fin, :date_signature, :cout_global, :ident )");
        $this->update = $db->prepare("UPDATE contrat SET date_debut = :date_debut, date_fin = :date_fin, date_signature = :_date_signature, cout_global = :cout_global WHERE idContrat = :idcontrat");
        $this->delete = $db->prepare("DELETE FROM contrat WHERE idcontrat = :idcontrat");
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

    public function selectById($idcontrat)
    {
        $this->selectById->execute(array(':idcontrat' => $idcontrat));

        if ($this->selectById->errorCode() != 0) 
        {
            print_r($this->selectById->errorInfo());

        }

        return $this->selectById->fetch();
    }

    public function selectByIdEnt($ident)
    {
        $this->selectByIdEnt->execute(array(':ident' => $ident));

        if ($this->selectByIdEnt->errorCode() != 0) 
        {
            print_r($this->selectByIdEnt->errorInfo());
        }

        return $this->selectByIdEnt->fetchAll();
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

    public function selectSumCount()
    {
        $this->selectSumCout->execute();

        if ($this->selectSumCout->errorCode() != 0)
        {
            print_r($this->selectSumCout->errorInfo());  
        }

       return $this->selectSumCout->fetchColumn();
    }

    public function insert($date_debut, $date_fin, $date_signature, $cout_global, $ident)
    {
        $r = true;
        
        $this->insert->bindValue(':date_debut', $date_debut, PDO::PARAM_STR);
        $this->insert->bindValue(':date_fin', $date_fin, PDO::PARAM_STR);
        $this->insert->bindValue(':date_signature', $date_signature, PDO::PARAM_STR);
        $this->insert->bindValue(':cout_global', $cout_global, PDO::PARAM_STR);
        $this->insert->bindValue(':ident', $ident, PDO::PARAM_STR);
        
       

        $this->insert->execute();

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function update($date_debut, $date_fin, $date_signature, $cout_global, $ident, $idprojet)
    {
        $r = true;
        
        $this->update->execute(array(':idcontrat' => $idcontrat, ':date_debut' => $date_debut, ':date_fin' => $date_signature, ':date_global' => $cout_global, ':ident' => $ident, ':idprojet' => $idprojet));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($idcontrat)
    {
        $r = true;
        $this->delete->execute(array(':idcontrat' => $idcontrat));

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