<?php

function actionDeveloppeur($twig, $db) 
{
    $form = array(); 
    $developpeur = new Developpeur($db);
    $devComp = new Developpeur_Competence($db);
    $devEqui = new Developpeur_Equipe($db);
    $utilisateur = new Utilisateur($db);
    $devInfos = $developpeur->selectById($_GET['iddev']);
    $idUtilisateur = $devInfos["idUtilisateur"];

    if (isset($_GET['iddev'])) 
    {
        $exec1 = $devComp->deleteByIdDev($_GET['iddev']);
        $exec2 = $devEqui->deleteByIdDev($_GET['iddev']);
        $exec = $developpeur->delete($_GET['iddev']);

        if (!$exec && !$exec1 && !$exec2) 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table développeur';
        }
        else
        {
            $exec3 = $utilisateur->delete($idUtilisateur);

            if (!$exec3) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table développeur';    
            }
            else
            {
                $form['valide'] = true;
            }
        }

        $form['message'] = 'Developpeur supprimée avec succès';
    }

    $liste = $developpeur->select();
    echo $twig->render('developpeur.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionDeveloppeurAjout($twig, $db) 
{
    $form = array();
    $utilisateur = new Utilisateur($db);
    $developpeur = new Developpeur($db);
    $remuneration = new Remuneration($db);
    $equipe = new Equipe($db);
    $devEqu = new Developpeur_Equipe($db);
    $role = new Role($db);
    $competence = new Competence($db);
    $devComp = new Developpeur_Competence($db);

    $listeRemuneration = $remuneration->select();
    $listeEquipe = $equipe->select();
    $listeRole = $role->select();
    $listeCompetence = $competence->select();

    if (isset($_POST['btAjouter'])) 
    {
        $inputNom = $_POST['inputNom'];
        $inputPrenom = $_POST['inputPrenom'];
        $inputIdRemuneration = $_POST['inputIdRemuneration'];
        $inputIdEquipe = $_POST['inputIdEquipe'];
        $inputEmail = $_POST['inputEmail'];
        $inputMdp = $_POST['inputMdp'];
        $inputConfMdp = $_POST['inputConfMdp'];
        $competences = $_POST['competence'];
        $form['valide'] = true;

        if ($inputMdp != $inputConfMdp) 
        {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        }
        else
        {
            $exec = $utilisateur->insert($inputEmail, password_hash($inputMdp, PASSWORD_DEFAULT), 3);
            $lastIdU = $db->lastInsertId();

            if (!$exec)
            {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table développeur';
            }

            if ($lastIdU != NULL) 
            {
                $exec2 = $developpeur->insert($inputNom, $inputPrenom, $inputIdRemuneration, $lastIdU);
                $lastIdD = $db->lastInsertId();

                if (!$exec2) 
                {
                    $form['valide'] = false;
                    $form['message'] = 'Problème d\'insertion dans la table développeur';
                }

                if ($lastIdD != NULL) 
                {
                    foreach ($competences as $comp) 
                    {
                        $exec3 = $devComp->insert($lastIdD, $comp);

                        if (!$exec3) 
                        {
                            $form['valide'] = false;  
                            $form['message'] = 'Problème d\'insertion dans la table développeur ';
                        }
                    }

                    $exec4 = $devEqu->insert($lastIdD, $inputIdEquipe);

                    if (!$exec4) 
                    {
                        $form['valide'] = false;  
                        $form['message'] = 'Problème d\'insertion dans la table développeur ';
                    }
                }
                else
                {
                    $form['valide'] = false;  
                    $form['message'] = 'Problème d\'insertion dans la table développeur ';
                }
            }
            else 
            {
                $form['valide'] = false;  
                $form['message'] = 'Problème d\'insertion dans la table développeur ';
            }
        }
    }
    else
    {
        $liste = $developpeur->select();
        $form['liste'] = $liste;
    }

    echo $twig->render('developpeur-ajout.html.twig', array('form' => $form, 'listeRemuneration' => $listeRemuneration, 'listeEquipe' => $listeEquipe, 'listeRole' => $listeRole, 'listeCompetence' => $listeCompetence)); 
}

function actionDeveloppeurModif($twig, $db) 
{
    $form = array();
    $remuneration = new Remuneration($db);
    $equipe = new Equipe($db);

    $listeRemuneration = $remuneration->select();
    $listeEquipe = $equipe->select();

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
        $inputEmail = $_POST['inputEmail'];
        $inputIdremuneration = $_POST['inputIdRemuneration'];
        $inputIdEquipe = $_POST['inputIdEquipe'];

        $developpeur = new Developpeur($db);
        $exec = $developpeur->update($iddev, $inputNom, $inputPrenom, $inputEmail, $inputIdremuneration, $inputIdEquipe);

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

    echo $twig->render('developpeur-modif.html.twig', array('form' => $form, 'displayDev' => $displayDev, 'listeRemuneration' => $listeRemuneration, 'listeEquipe' => $listeEquipe));
}


// WebService
function actionDeveloppeurWS($twig, $db) 
{
   $developpeur = new Developpeur($db);
   $json = json_encode($liste = $developpeur->select()); 
   echo $json; 
}

