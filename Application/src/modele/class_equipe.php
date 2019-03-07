<?php

class Equipe{
    // idequi, libelle, idresp
    #region Properties
    private $db;
    private $select;
    private $selectById;
    private $selectByIdRespAndLibelle;
    private $selectByIddev;
    private $selectCount;
    private $insert;
    private $update;
    private $delete;
    #endregion
    
    #region Consrtuctor
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("SELECT idequi, libelle, developpeur.nom, developpeur.prenom FROM equipe INNER JOIN developpeur ON equipe.idresp = developpeur.iddev  ORDER BY libelle");
        $this->selectById = $db->prepare("SELECT idequi, libelle, equipe.idresp FROM equipe WHERE idequi=:idequi ORDER BY libelle");
        $this->selectByIddev = $db->prepare("SELECT idequi, libelle, idresp FROM equipe WHERE idresp=:idresp");
        $this->selectByIdRespAndLibelle = $db->prepare("SELECT idequi FROM equipe WHERE idresp=:idresp AND libelle=:libelle");
        $this->selectCount = $db->prepare("SELECT COUNT(*) FROM equipe");
        $this->insert = $db->prepare("INSERT INTO equipe(libelle, idresp) VALUES (:libelle, :idresp)");
        $this->update = $db->prepare("UPDATE equipe SET libelle=:libelle, idresp=:idresp WHERE idresp=:idresp"); 
        $this->delete = $db->prepare("DELETE FROM equipe WHERE idequi=:idequi");
    }
    #endregion
    
    #region Functions
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }

    public function selectById($id){ 
        $this->selectById->execute(array(':idequi'=>$id)); 
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo()); 
            
        }
        return $this->selectById->fetch(); 
    }
    
    public function selectByIddev($iddev){
        $this->selectByIddev->execute(array(':idresp'=>$iddev));
        if ($this->selectByIddev->errorCode()!=0){
             print_r($this->selectByIddev->errorInfo());  
        }
        return $this->selectByIddev->fetchAll();
    }

    public function selectByIdRespAndLibelle($idresp, $libelle){
        $this->selectByIdRespAndLibelle->execute(array(':idresp'=>$idresp,':libelle'=>$libelle));
        if ($this->selectByIdRespAndLibelle->errorCode()!=0){
            print_r($this->selectByIdRespAndLibelle->errorInfo());  
       }
       
       return $this->selectByIdRespAndLibelle->fetch();
    }

    public function selectCount()
    {
        $this->selectCount->execute();
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo());  
       }
       return $this->selectCount->fetchColumn();
    }

    public function insert($libelle, $iddev){
        $r = true;
        if($iddev=="non"){
          $iddev=null;  
        }
      
        $this->insert->bindValue(':idresp', $iddev,PDO::PARAM_STR);
        
        $this->insert->bindValue(':libelle', $libelle,PDO::PARAM_STR); 
        $this->insert->execute();
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function update($id, $libelle, $iddev){
        $r = true;
        if($iddev=="non"){
          $iddev=null;  
        }
        $this->update->execute(array(':idequi'=>$id, ':libelle'=>$libelle, ':idresp'=>$iddev));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':idequi'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    #endregion
}

?>



