<?php

class Projet
{
    //idprojet, libelle, idpriorite, idprogression, idequi, idcontrat
    #region Properties
    private $db;
    private $select;
    private $selectById;
    private $selectCount;
    private $selectForDashboard;
    private $insert;
    private $update;
    private $delete;
    #endregion

    #region Constructor
    public function __construct($db) 
    {
        $this->db = $db;
        $this->select = $db->prepare("SELECT p.idprojet, p.libelle, p.actif, e.libelle AS Equipe, ep.nom, c.cout_global, c.idcontrat AS idcontrat 
                                    FROM projet p 
                                    LEFT OUTER JOIN equipe e ON p.idequi = e.idequi 
                                    LEFT OUTER JOIN contrat c ON p.idcontrat = c.idcontrat 
                                    LEFT OUTER JOIN entreprise_cliente ep ON c.ident = ep.ident 
                                    ORDER BY p.libelle");
        $this->selectById = $db->prepare("SELECT idprojet, libelle, actif, idpriorite, idprogression, idequi, idcontrat FROM projet WHERE idprojet = :idprojet");
        $this->selectByIdContrat = $db->prepare("SELECT * FROM projet WHERE projet.idcontrat = :idcontrat");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM projet");
        $this->selectForDashboard = $db->prepare("SELECT tpro.libelle AS Projet, tent.nom AS Client, tequi.libelle AS Equipe, tprio.libelle AS Priorité, tprio.couleur AS CouleurPrio, tprogr.valeur AS Progression, tprogr.couleur AS CouleurProgr
                                                FROM projet tpro
                                                LEFT OUTER JOIN equipe tequi ON tpro.idequi = tequi.idequi
                                                LEFT OUTER JOIN contrat tcon ON tcon.idcontrat = tpro.idcontrat
                                                LEFT OUTER JOIN entreprise_cliente tent ON tent.ident = tcon.ident
                                                LEFT OUTER JOIN priorite tprio ON tprio.idprio = tpro.idpriorite
                                                LEFT OUTER JOIN progression tprogr ON tprogr.idprogr = tpro.idprogression");
        $this->insert = $db->prepare("INSERT INTO projet (libelle, actif, idpriorite, idprogression, idequi, idcontrat) VALUES (:libelle, :actif, :idpriorite, :idprogression, :idequi, :idcontrat) "); // TO-DO
        $this->update = $db->prepare("UPDATE projet SET libelle = :libelle, actif = :actif, idpriorite = :idpriorite, idprogression = :idprogression, idequi = :idequi , idcontrat = :idcontrat WHERE idprojet = :idprojet"); // TO-DO
        $this->delete = $db->prepare("DELETE FROM projet WHERE idprojet = :idprojet"); // TO-DO
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

    // TO-DO
    public function selectById($idprojet)
     { 
        $this->selectById->execute(array(':idprojet' => $idprojet)); 

        if ($this->selectById->errorCode() != 0)
        {
            print_r($this->selectById->errorInfo()); 
        }

        return $this->selectById->fetch();
     } 


     public function selectByIdContrat($idcontrat)
     { 
        $this->selectByIdContrat->execute(array(':idcontrat' => $idcontrat)); 

        if ($this->selectByIdContrat->errorCode() != 0)
        {
            print_r($this->selectByIdContrat->errorInfo()); 
        }

        return $this->selectByIdContrat->fetch();
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

    // TO-DO
     public function insert($libelle, $actif, $idpriorite, $idprogression, $idequi, $idcontrat) 
     {
         $r = true;

         $this->insert->bindValue(':actif', $actif, PDO::PARAM_INT);
         $this->insert->bindValue(':idpriorite', $idpriorite, PDO::PARAM_INT);
         $this->insert->bindValue(':idprogression', $idprogression, PDO::PARAM_INT);
         $this->insert->bindValue(':idequi', $idequi, PDO::PARAM_INT);
         $this->insert->bindValue(':idcontrat', $idcontrat, PDO::PARAM_INT);
         $this->insert->bindValue(':libelle', $libelle, PDO::PARAM_STR);
         $this->insert->execute();
         

         if ($this->insert->errorCode() != 0)
         {
            print_r($this->insert->errorInfo());  
           $r = false;
        }
        
        return $r;
     }

    // TO-DO
 public function update($idprojet, $libelle, $actif, $idpriorite, $idprogression, $idequi, $idcontrat) 
     {
         $r = true;
         $this->update->execute(array(':idprojet' => $idprojet, ':libelle' => $libelle, ':actif' => $actif, ':idpriorite' => $idpriorite, ':idprogression' => $idprogression, ':idequi' => $idequi, ':idcontrat' => $idcontrat));
        
         if ($this->update->errorCode() != 0)
        {
            print_r($this->update->errorInfo());  
        $r = false;
         }

       return $r;
     }

    // TO-DO
     public function delete($idprojet)
     {
         $r = true;
         $this->delete->execute(array(':idprojet' => $idprojet));

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