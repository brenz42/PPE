<?php

function actionEquipe($twig, $db)
{
    $form = array();
    $equipe = new Equipe($db);
    $equi = new Developpeur_Equipe($db);

    if (isset($_GET['id'])) 
    {
        $exec = $equi->deleteByIdEqui($_GET['id']);
        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        } 
        else 
        {
            $form['valide'] = true;
        }
        $exec = $equipe->delete($_GET['id']);
        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table équipe';
        } 
        else 
        {
            $form['valide'] = true;
        }
        $form['message'] = 'Equipe supprimée avec succès';
    }

    $liste = $equipe->select();
    echo $twig->render('equipe.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionEquipeAjout($twig, $db)
{
    $form = array();
    if (isset($_POST['btAjouter'])) 
    {
        $inputLibelle = $_POST['inputLibelle'];
        $inputIdResponsable = $_POST['inputIdResponsable'];
        $form['valide'] = true;

        $equipe = new Equipe($db);
        $equipeResponsable = new Developpeur_Equipe($db);

        $exec = $equipe->insert($inputLibelle, $inputIdResponsable);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table équipe ';
        }

        $idEqui = $equipe->selectByIdRespAndLibelle($inputIdResponsable, $inputLibelle);
        $exec = $equipeResponsable->insert($inputIdResponsable, $idEqui[0]);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table équipe ';
        }
    } 
    else
    {
        $utilisateur = new Developpeur($db);
        $liste = $utilisateur->select();
        $form['liste'] = $liste;
    }

    echo $twig->render('equipe-ajout.html.twig', array('form' => $form));
}

function actionEquipeModif($twig, $db)
{
    $form = array();
    if (isset($_GET['id'])) 
    {
        $equipe = new Equipe($db);
        $uneEquipe = $equipe->selectById($_GET['id']);
        $test = $_GET['id'];
        $form['id'] = $test;
        if ($uneEquipe != null) 
        {
            $form['equipe'] = $uneEquipe;

            $developpeur = new Developpeur($db);
            $liste = $developpeur->select();
            $form['liste'] = $liste;

        } 
        else 
        {
            $form['message'] = 'Equipe incorrecte';
        }
    } 
    else 
    {
        if (isset($_POST['btModifier'])) 
        {
            $id = $_POST['id'];
            $libelle = $_POST['inputLibelle'];
            $idResponsable = $_POST['inputIdResponsable'];
            $equipe = new Equipe($db);
            $equipeResponsable = new Developpeur_Equipe($db);
            $exec = $equipe->update($id, $libelle, $idResponsable);
            if (!$exec) 
            {
                $form['valide'] = false;
                $form['message'] .= 'Echec de la modification del\'équipe';
            } 
            else 
            {
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
            }
            $exec = $equipeResponsable->update($id, $idResponsable);
            if (!$exec) 
            {
                $form['valide'] = false;
                $form['message'] .= 'Echec de la modification del\'équipe';
            } 
            else 
            {
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
            }

        } 
        else 
        {
            $form['message'] = 'Utilisateur non précisé';
        }

    }

    echo $twig->render('equipe-modif.html.twig', array('form' => $form));
}


// WebService
function actionEquipeWS($twig, $db)
{
    $equipe = new Equipe($db);
    $json = json_encode($liste = $equipe->select());
    echo $json;
}

