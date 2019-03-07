<?php

class Entreprise_Cliente
{
    private $db;
    private $select;
    private $selectById;
    private $selectCount;
    private $insert;
    private $update;
    private $delete;

    public function __construct($db)
    {
        $this->db = $db;
        $this->select = $db->prepare("SELECT ident, nom, adresse, ville, codep, contact FROM entreprise_cliente ORDER BY nom");
        $this->selectById = $db->prepare("SELECT ident, nom, adresse, ville, codep, contact FROM entreprise_cliente WHERE ident = :ident ORDER BY nom");
        $this->selectCount = $db->prepare("SELECT COUNT(1) FROM entreprise_cliente");
        $this->insert = $db->prepare("INSERT INTO entreprise_cliente(nom, adresse, ville, codep, contact) VALUES(:nom, :adresse, :ville, :codep, :contact)");
        $this->update = $db->prepare("UPDATE entreprise_cliente SET nom = :nom, adresse = :adresse, ville = :ville, codep = :codep, contact = :contact WHERE ident = :ident");
        $this->delete = $db->prepare("DELETE FROM entreprise_cliente WHERE ident = :ident");
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

    public function selectById($ident)
    {
        $this->selectById->execute(array(':ident' => $ident));

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

    public function insert($nom, $adresse, $ville, $codep, $contact)
    {
        $r = true;
        $this->insert->bindValue(':nom', $nom, PDO::PARAM_STR);
        $this->insert->bindValue(':adresse', $adresse, PDO::PARAM_STR);
        $this->insert->bindValue(':ville', $ville, PDO::PARAM_STR);
        $this->insert->bindValue(':codep', $codep, PDO::PARAM_STR);
        $this->insert->bindValue(':contact', $contact, PDO::PARAM_STR);

        $this->insert->execute();

        if ($this->insert->errorCode() != 0) 
        {
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function update($ident, $nom, $adresse, $ville, $codep, $contact)
    {
        $r = true;
        $this->update->execute(array(':ident' => $ident, ':nom' => $nom, ':adresse' => $adresse, ':ville' => $ville, ':codep' => $codep, ':contact' => $contact));

        if ($this->update->errorCode() != 0) 
        {
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($ident)
    {
        $r = true;
        $this->delete->execute(array(':ident' => $ident));

        if ($this->delete->errorCode() != 0) 
        {
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }
}

?>