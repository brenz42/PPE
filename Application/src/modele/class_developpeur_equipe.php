<?php
class Developpeur_Equipe{
    private $db;
    private $insert;
    private $select;
    private $delete;
    private $update;
    private $selectByIdDev;
    private $selectByIdEqui;
    private $deleteByIdDev;
    private $deleteByIdEqui;

    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into developpeur_equipe(iddev, idequi) values (:iddev, :idequi)");
        $this->select = $db->prepare("select equipe.libelle, , developpeur.nom, developpeur.prenom from developpeur_equipe, equipe, developpeur where developpeur.iddev=developpeur_equipe.iddev and equipe.idequi=developpeur_equipe.idequi");
        $this->delete = $db->prepare("delete from developpeur_equipe where iddev=:iddev and idequi=:idequi");
        $this->update = $db->prepare("update developpeur_equipe set idequi=:idequi, iddev=:iddev");
        $this->selectByIdDev = $db->prepare("select equipe.libelle, developpeur.nom, developpeur.prenom from developpeur_equipe, equipe, developpeur where developpeur_equipe.iddev=:iddev and developpeur.iddev=developpeur_equipe.iddev and equipe.idequi=developpeur_equipe.idequi order by equipe.libelle");
        $this->selectByIdEqui  =$db->prepare("select equipe.libelle, developpeur.nom, developpeur.prenom from developpeur_equipe, equipe, developpeur where developpeur_equipe.idequi=:idequi and developpeur.iddev=developpeur_equipe.iddev and equipe.idequi=developpeur_equipe.idequi order by equipe.libelle");
        $this->deleteByIdDev = $db->prepare("delete from developpeur_equipe where iddev=:iddev");
        $this->deleteByIdEqui = $db->prepare("delete from developpeur_equipe where idequi=:idequi");
    }

    public function insert($iddev , $idequi){
        $r=true;
        $this->insert->bindValue(':iddev',$iddev,PDO::PARAM_STR);
        $this->insert->bindValue(':idequi',$idequi,PDO::PARAM_STR);
        $this->insert->execute();
        if($this->insert->errorCode()!=0){
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }

    public function delete($iddev, $idequi){
        $r = true;
        $this->delete->execute(array(':iddev'=>$iddev, ':idequi'=>$idequi));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }

    public function update($idequi, $iddev){
        $r=true;
        $this->update->execute(array(':idequi'=>$idequi,':iddev'=>$iddev));
        if($this->update->errorCode()!=0){
            $r=false;
        }
        return $r;
    }

    public function selectByIdDev($iddev){
        $this->selectByIdDev->execute(array(':iddev'=>$iddev));
        if ($this->selectByIdDev->errorCode()!=0){
             print_r($this->selectByIdDev->errorInfo());  
        }
        return $this->selectByIdDev->fetchAll();
    }

    public function selectByIdEqui($idequi){
        $this->selectByIdDev->execute(array(':idequi'=>$idequi));
        if ($this->selectByIdDev->errorCode()!=0){
             print_r($this->selectByIdDev->errorInfo());  
        }
        return $this->selectByIdDev->fetchAll();
    }

    public function deleteByIdDev($iddev){
        $r = true;
        $this->deleteByIdDev->execute(array(':iddev'=>$iddev));
        if ($this->deleteByIdDev->errorCode()!=0){
             print_r($this->deleteByIdDev->errorInfo());  
             $r=false;
        }
        return $r;
    }

    public function deleteByIdEqui($idequi){
        $r = true;
        $this->deleteByIdEqui->execute(array(':idequi'=>$idequi));
        if ($this->deleteByIdEqui->errorCode()!=0){
             print_r($this->deleteByIdEqui->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>