<?php
// idremuremu, cout_horaire

function actionRemuneration($twig, $db) 
{
    $form = array();
    $remuneration = new Remuneration($db);

    if (isset($_GET['idremu']))
    {
        $exec = $remuneration->delete($_GET['idremu']);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table Rémunération';
        }
        else 
        {
            $form['valide'] = true;
        }
        $form['message'] = 'Rémunération supprimée avec succès';
    }

    $liste = $remuneration->select();
    echo $twig->render('remuneration.html.twig', array('form'=>$form, 'liste'=>$liste));
}

function actionRemunerationAjout($twig, $db) 
{
    $form = array();
    $remuneration = new Remuneration($db);

    if (isset($_POST['btAjouter'])) 
    {
        $inputCoutHoraire = $_POST['inputCoutHoraire'];

        $form['valide'] = true;

        $exec = $remuneration->insert($inputCoutHoraire);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table Rémunération';
        }
        // else
        // {
        //     header("Location:index.php?page=remuneration");
        // }
    }

    echo $twig->render('remuneration-ajout.html.twig', array('form'=>$form));
}

function actionRemunerationModif($twig, $db) 
{
    $form = array();

    if (isset($_GET['idremu'])) 
    {
        $remuneration = new Remuneration($db);
        $uneRemuneration = $remuneration->selectById($_GET['idremu']);

        if ($uneRemuneration != NULL) 
        {
            $displayRemu = $uneRemuneration;
        } 
        else 
        {
            $form['message'] = 'Rémunération incorrecte';
        }
    }
    
    if (isset($_POST['btModifier'])) 
    {
        $idremu = $_GET['idremu'];
        $inputCoutHoraire = $_POST['inputCoutHoraire'];
        
        $remuneration = new Remuneration($db);
        $exec = $remuneration->update($idremu, $inputCoutHoraire);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Echec de la modification de la rémunération';
        } 
        else 
        {
            $form['valide'] = true;
            $form['message'] = 'Modification de la rémunération réussie';
        }
    } 
    else 
    {
        $form['message'] = 'Rémunération non précisée';
    }

    echo $twig->render('remuneration-modif.html.twig', array('form' => $form, 'displayRemu' => $displayRemu));
}

//WebService
function actionRemunerationWS($twig, $db) 
{
    $remuneration = new Remuneration($db);
    $json = json_encode($liste = $remuneration->select());
    echo $json;
}

?>