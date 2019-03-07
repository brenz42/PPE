<?php

function actionDeveloppeur($twig, $db) 
{
    $form = array(); 
    $developpeur = new Developpeur($db);
    
    if (isset($_GET['iddev'])) 
    {
        $exec = $developpeur->delete($_GET['iddev']);

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table développeur';
        }
        else
        {
            $form['valide'] = true;
        }

        $form['message'] = 'Developpeur supprimée avec succès';
    }

    $liste = $developpeur->select();
    echo $twig->render('developpeur.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionDeveloppeurAjout($twig, $db) 
{
    $form = array();
    $developpeur = new Developpeur($db);
    $remuneration = new Remuneration($db);
    $role = new Role($db);
    $competence = new Competence($db);

    $listeRemuneration = $remuneration->select();
    $listeRole = $role->select();
    $listeCompetence = $competence->select();

    if (isset($_POST['btAjouter'])) 
    {
        $inputNom = $_POST['inputNom'];
        $inputPrenom = $_POST['inputPrenom'];
        $inputMail = $_POST['inputMail'];
        $inputIdRemuneration = $_POST['inputIdRemuneration'];
        $inputIdRole = $_POST['inputIdRole'];

        $form['valide'] = true;
        
        $exec = $developpeur->insert($inputNom, $inputPrenom, $inputMail, $inputIdRemuneration, $inputIdRole);
        $lastId = $db->lastInsertId();

        if (!$exec) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table développeur ';
        }
        elseif ($lastId != NULL) 
        {
            $devComp = new Developpeur_Competence($db);
            $competences = $_POST['competence'];

            foreach ($competences as $comp) 
            {
                $exec2 = $devComp->insert($lastId, $comp);

                if (!$exec2) 
                {
                    $form['valide'] = false;  
                    $form['message'] = 'Problème d\'insertion dans la table développeur ';
                    header("Location:index.php");
                }
            }
        }
    }
    else
    {
        $liste = $developpeur->select();
        $form['liste'] = $liste;
    }

    echo $twig->render('developpeur-ajout.html.twig', array('form' => $form, 'listeRemuneration' => $listeRemuneration, 'listeRole' => $listeRole, 'listeCompetence' => $listeCompetence)); 
}

function actionDeveloppeurModif($twig, $db) 
{
    $form = array();
    $remuneration = new Remuneration($db);
    $role = new Role($db);

    $listeRemuneration = $remuneration->select();
    $listeRole = $role->select();

    if (isset($_GET['iddev'])) 
    {
        $developpeur = new Developpeur($db);
        $unDeveloppeur = $developpeur->selectById($_GET['iddev']);  
        
        if ($unDeveloppeur != NULL) 
        {
            $displayDev = $unDeveloppeur;
        }
        else
        {
            $form['message'] = 'Développeur incorrect';  
        }
    }

    if (isset($_POST['btModifier'])) 
    {
        $iddev = $_GET['iddev'];  
        $inputNom = $_POST['inputNom'];
        $inputPrenom = $_POST['inputPrenom'];
        $inputMail = $_POST['inputMail'];
        $inputIdremuneration = $_POST['inputIdRemuneration'];
        $inputIdrole = $_POST['inputIdRole'];

        $developpeur = new Developpeur($db);
        $exec = $developpeur->update($iddev, $inputNom, $inputPrenom, $inputMail, $inputIdremuneration, $inputIdrole);

        if (!$exec) 
        {
          $form['valide'] = false;  
          $form['message'] = 'Echec de la modification du développeur'; 
        }
        else
        {
            $form['valide'] = true;  
            $form['message'] = 'Modification du développeur réussie';  
        }
    }
    else
    {
        $form['message'] = 'Développeur non précisé';
    }

    echo $twig->render('developpeur-modif.html.twig', array('form' => $form, 'displayDev' => $displayDev, 'listeRemuneration' => $listeRemuneration, 'listeRole' => $listeRole));
}


// WebService
function actionDeveloppeurWS($twig, $db) 
{
   $developpeur = new Developpeur($db);
   $json = json_encode($liste = $developpeur->select()); 
   echo $json; 
}

