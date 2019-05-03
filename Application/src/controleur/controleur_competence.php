<?php
// idcomp, libelle, version

function actionCompetence($twig, $db) 
{
    $form = array();
    $competence = new Competence($db);
    $devComp = new Developpeur_Competence($db);

    if (isset($_GET['idcomp'])) 
    {
        $exec1 = $devComp->deleteByIdComp($_GET['idcomp']);
        $exec = $competence->delete($_GET['idcomp']);

        if (!$exec && !$exec1) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table compétence';
        } 
        else 
        {
            $form['valide'] = true;
        }
        $form['message'] = 'Compétence supprimée avec succès';
    }

    $liste = $competence->select();
    echo $twig->render('competence.html.twig', array('form' => $form, 'liste' => $liste));
}


function actionCompetenceAjout($twig, $db) 
{
    $form = array();
    $competence = new Competence($db);

    if (isset($_POST['btAjouter'])) 
    {
        $inputLibelle = $_POST['inputLibelle'];
        $inputVersion = $_POST['inputVersion'];

        $form['valide'] = true;
        
        $exec = $competence->insert($inputLibelle, $inputVersion);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table compétence';
        }
    } 
    else 
    {
        $liste = $competence->select();
        $form['liste'] = $liste;

        // $developpeur = new Developpeur($db);
        // $liste = $developpeur->select();
        // $form['liste'] = $liste;
    }

    echo $twig->render('competence-ajout.html.twig', array('form' => $form));
}

function actionCompetenceModif($twig, $db) 
{
    $form = array();

    if (isset($_GET['idcomp'])) 
    {
        $competence = new Competence($db);
        $uneCompetence = $competence->selectById($_GET['idcomp']);

        if ($uneCompetence != NULL) 
        {
            $displayComp = $uneCompetence;
        } 
        else 
        {
            $form['message'] = 'Compétence incorrecte';
        }
    } 

    if (isset($_POST['btModifier'])) 
    {
        $idcomp = $_GET['idcomp'];
        $inputLibelle = $_POST['inputLibelle'];
        $inputVersion = $_POST['inputVersion'];
        
        $competence = new Competence($db);
        $exec = $competence->update($idcomp, $inputLibelle, $inputVersion);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Echec de la modification de la compétence';
        } 
        else 
        {
            $form['valide'] = true;
            $form['message'] = 'Modification de la compétence réussie';
        }
    } 
    else 
    {
        $form['message'] = 'Compétence non précisée';
    }

    echo $twig->render('competence-modif.html.twig', array('form' => $form, 'displayComp' => $displayComp));
}


//WebService
function actionCompetenceWS($twig, $db) 
{
    $competence = new Competence($db);
    $json = json_encode($liste = $competence->select());
    echo $json;
}

?>