<?php

class Utilisateur
{
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectByEmail;
    private $selectCount;
    private $update;
    private $updateMdp;
    private $delete;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare("INSERT INTO utilisateur(email, mdp, nom, prenom, idrole) VALUES (:email, :mdp, :nom, :prenom, :role)");
        $this->connect = $db->prepare("SELECT email, idrole, mdp FROM utilisateur WHERE email=:email");
        $this->select = $db->prepare("SELECT email, u.idrole, nom, prenom, r.libelle AS role 
                                    FROM utilisateur u, role r 
                                    WHERE u.idrole = r.idrole 
                                    ORDER BY nom");
        $this->selectByEmail = $db->prepare("SELECT email, nom, prenom, idrole FROM utilisateur WHERE email=:email");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM utilisateur");
        $this->update = $db->prepare("UPDATE utilisateur SET nom=:nom, prenom=:prenom, idrole=:role WHERE email=:email");
        $this->updateMdp = $db->prepare("UPDATE utilisateur SET mdp=:mdp WHERE email=:email");
        $this->delete = $db->prepare("DELETE FROM utilisateur WHERE email=:id");
    }

    public function insert($email, $mdp, $role, $nom, $prenom)
    {
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom));

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function connect($email)
    {
        $unUtilisateur = $this->connect->execute(array(':email' => $email));

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

    public function update($email, $role, $nom, $prenom)
    {
        $r = true;
        $this->update->execute(array(':email' => $email, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function updateMdp($email, $mdp)
    {
        $r = true;
        $this->updateMdp->execute(array(':email' => $email, ':mdp' => $mdp));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->updateMdp->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($id)
    {
        $r = true;
        $this->delete->execute(array(':id' => $id));

        if ($this->delete->errorCode() != 0) 
        {
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }
}

?>

