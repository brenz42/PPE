<?php

class Utilisateur
{
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectById;
    private $selectByEmail;
    private $selectCount;
    private $update;
    private $updateMdp;
    private $delete;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare("INSERT INTO utilisateur(email, mdp, idrole) VALUES (:email, :mdp, :idrole)");
        $this->connect = $db->prepare("SELECT idUtilisateur, email, mdp, idrole FROM utilisateur WHERE email = :email");
        $this->select = $db->prepare("SELECT email, r.libelle AS role 
                                    FROM utilisateur u 
                                    LEFT JOIN role r ON u.idrole = r.idrole");
        $this->selectById = $db->prepare("SELECT idUtilisateur, email, idrole FROM utilisateur WHERE idUtilisateur = :idUtilisateur");
        $this->selectByEmail = $db->prepare("SELECT idUtilisateur, email, idrole FROM utilisateur WHERE email = :email");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM utilisateur");
        $this->update = $db->prepare("UPDATE utilisateur SET email = :email, idrole = :idrole WHERE idUtilisateur = :idUtilisateur");
        $this->updateMdp = $db->prepare("UPDATE utilisateur SET mdp = :mdp WHERE idUtilisateur = :idUtilisateur");
        $this->delete = $db->prepare("DELETE FROM utilisateur WHERE idUtilisateur = :idUtilisateur");
    }

    public function insert($email, $mdp, $idrole)
    {
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':idrole' => $idrole));

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function connect($email)
    {
        $this->connect->execute(array(':email' => $email));

        if ($this->connect->errorCode() != 0) 
        {
            print_r($this->connect->errorInfo());
        }

        return $this->connect->fetch();
    }

    public function select()
    {
        $this->select->execute();

        if ($this->select->errorCode() != 0) 
        {
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function selectById($idUtilisateur)
    {
        $this->selectById->execute(array(':idUtilisateur' => $idUtilisateur));

        if ($this->selectById->errorCode() != 0) 
        {
            print_r($this->selectById->errorInfo());
        }

        return $this->selectById->fetch();
    }

    public function selectByEmail($email)
    {
        $this->selectByEmail->execute(array(':email' => $email));

        if ($this->selectByEmail->errorCode() != 0) 
        {
            print_r($this->selectByEmail->errorInfo());
        }

        return $this->selectByEmail->fetch();
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

    public function update($idUtilisateur, $email, $idrole)
    {
        $r = true;
        $this->update->execute(array(':idUtilisateur' => $idUtilisateur, ':email' => $email, ':idrole' => $idrole));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function updateMdp($idUtilisateur, $mdp)
    {
        $r = true;
        $this->updateMdp->execute(array(':idUtilisateur' => $idUtilisateur, ':mdp' => $mdp));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->updateMdp->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($idUtilisateur)
    {
        $r = true;
        $this->delete->execute(array(':idUtilisateur' => $idUtilisateur));

        if ($this->delete->errorCode() != 0) 
        {
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }
}

?>

