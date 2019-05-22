<?php

function actionEntrepriseCliente($twig,$db){
    $form = array();

    $entreprisecliente = new Entreprise_Cliente($db);


    if(isset($_GET['ident'])){

        $exec=$entreprisecliente->delete($_GET['ident']);

        if (!$exec){

            $form['valide'] = false;
            $form['message'] = 'Probleme de suppression dans la table entreprise cliente ';
        }

        else{

            $form['valide'] = true;

        }
        $form['message'] = 'entreprise cliente supprimée avec succes ';
    }
        $liste = $entreprisecliente->select();

        echo $twig->render('entreprise_cliente.html.twig',array('form'=>$form,'liste'=>$liste));

}

function actionEntrepriseClienteAjout($twig,$db){

    $form =  array(); 

    $entreprise_cliente = new Entreprise_Cliente($db);

    if (isset($_POST['btAjouter']))
    {

        $inputNom = $_POST['inputnom'];
        $inputAdresse=$_POST['inputadresse'];
        $inputCodep = $_POST['inputcodep'];
        $inputVille = $_POST['inputville'];
        $inputContact = $_POST['inputcontact'];

        //$inputIdutilisateur = $_POST['inputIdutilisateur'];
        
        $form['valide'] = true ; 

        
        $exec = $entreprise_cliente->insert($inputNom,$inputAdresse,$inputCodep,$inputVille,$inputContact);
        

        if(!$exec){

            $form['valide'] = false ;
            $form['message'] = 'Probleme d\'insertion dans la table entreprise cliente';
        }
    }
    

    echo $twig->render('entreprise_cliente-ajout.html.twig', array('form'=>$form,'liste'=>$liste)); 
}

function actionEntrepriseClienteModif($twig,$db)
{
    $form = array ();

    if(isset($_GET['ident']))
    {
        $entreprise_cliente = new Entreprise_Cliente($db);
        $uneEntrepriseCliente = $entreprise_cliente->selectById($_GET['ident']);
        
        if ($uneEntrepriseCliente != NULL)
        {
            $liste = $uneEntrepriseCliente;

            // $form['entreprisecliente'] = $uneEntrepriseCliente;
           
            // $developpeur = new Developpeur($db);
            // $liste = $developpeur->select();
            // $form['liste'] = $liste;
        }
        else
        {
            $form['message'] = 'Entreprise  incorrecte';  
        }

    }
        if(isset($_POST['btModifier']))
        {
            $id = $_GET['ident'];

            //$id = $_POST['inputid'];
            $Nom = $_POST['inputnom'];
            $Adresse=$_POST['inputadresse'];
            $Codep = $_POST['inputcodep'];
            $Ville = $_POST['inputville'];
            $Contact = $_POST['inputcontact'];

            
            $entreprise_cliente = new Entreprise_Cliente($db);

            $exec = $entreprise_cliente->update($id,$Nom,$Adresse,$Ville,$Codep,$Contact);

            if(!$exec)
            {
                $form['valide'] = false;
                $form['message'] .='Echec de la modification de l\' entreprise cliente ';
            }
            else
            {
                $form['valide'] = true;
                $form['message']='Modification reussie';
                //header('Location: index.php?page=entreprise_cliente_modif&ident='.$id);
            }
        }
        else
        {
            $form['message'] = 'Utilisateur non précise';
        }
    

    echo $twig->render('entreprise_cliente_modif.html.twig', array('form'=>$form, 'liste'=>$liste));
}
// function AnctionEntrepriseClienteWS($twig, $db){
//     $entreprise_cliente = new Entreprise_Cliente($db);
//     $json = json_encode($liste = equipe->select());
//     echo $json;
//}