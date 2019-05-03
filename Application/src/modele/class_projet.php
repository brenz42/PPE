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
        $this->select = $db->prepare("SELECT  FROM  ORDER BY "); // TO-DO
        $this->selectById = $db->prepare("SELECT  FROM  WHERE "); // TO-DO
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM projet");
        // Sélection des 10 projets les plus récents pour les afficher sur la page d'accueil (Tableau de bord)
        $this->selectForDashboard = $db->prepare("SELECT tpro.libelle AS Projet, tent.nom AS Client, tequi.libelle AS Equipe, 
                                                        tprio.libelle AS Priorite, tprio.couleur AS CouleurPrio, 
                                                        tprogr.valeur AS Progression, tprogr.couleur AS CouleurProgr
                                                FROM projet tpro
                                                LEFT OUTER JOIN equipe tequi ON tpro.idequi = tequi.idequi
                                                LEFT OUTER JOIN contrat tcon ON tcon.idcontrat = tpro.idcontrat
                                                LEFT OUTER JOIN entreprise_cliente tent ON tent.ident = tcon.ident
                                                LEFT OUTER JOIN priorite tprio ON tprio.idprio = tpro.idpriorite
                                                LEFT OUTER JOIN progression tprogr ON tprogr.idprogr = tpro.idprogression
                                                ORDER BY tcon.date_signature DESC
                                                LIMIT 10");
        $this->insert = $db->prepare("INSERT INTO  VALUES "); // TO-DO
        $this->update = $db->prepare("UPDATE  SET  WHERE "); // TO-DO
        $this->delete = $db->prepare("DELETE FROM  WHERE "); // TO-DO
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
    // public function selectById(...)
    // { 
    //     $this->selectById->execute(array(...)); 

    //     if ($this->selectById->errorCode() != 0)
    //     {
    //         print_r($this->selectById->errorInfo()); 
    //     }

    //     return $this->selectById->fetch();
    // } 

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
    // public function insert(...) 
    // {
    //     $r = true;

    //     // $this->insert->bindValue(':libelle', $libelle, PDO::PARAM_STR);
    //     // $this->insert->bindValue(':version', $version, PDO::PARAM_STR);
    //     // $this->insert->execute();

    //     if ($this->insert->errorCode() != 0)
    //     {
    //         print_r($this->insert->errorInfo());  
    //         $r = false;
    //     }
        
    //     return $r;
    // }

    // TO-DO
    // public function update(...) 
    // {
    //     $r = true;
    //     $this->update->execute(array(...));
        
    //     if ($this->update->errorCode() != 0)
    //     {
    //         print_r($this->update->errorInfo());  
    //         $r = false;
    //     }

    //    return $r;
    // }

    // TO-DO
    // public function delete(...)
    // {
    //     $r = true;
    //     $this->delete->execute(array(...));

    //     if ($this->delete->errorCode() != 0)
    //     {
    //         print_r($this->delete->errorInfo());  
    //         $r = false;
    //     }

    //     return $r;
    // }
    #endregion
}

?>