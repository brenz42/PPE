<?php

// function actionAccueil($twig, $db)
// {
//     $form = array();
//     $form['valide'] = true;

//     if (isset($_POST['btConnecter'])) 
//     {
//         $inputEmail = $_POST['inputEmail'];
//         $inputPassword = $_POST['inputPassword'];

//         $utilisateur = new Utilisateur($db);
//         $unUtilisateur = $utilisateur->connect($inputEmail);

//         if ($unUtilisateur != null) 
//         {
//             if (!password_verify($inputPassword, $unUtilisateur['mdp'])) 
//             {
//                 $form['valide'] = false;
//                 $form['message'] = 'Login ou mot de passe incorrect';
//             } 
//             else 
//             {
//                 $_SESSION['login'] = $inputEmail;
//                 $_SESSION['role'] = $unUtilisateur['idRole'];

//                 header("Location:index.php");
//             }
//         } 
//         else 
//         {
//             $form['valide'] = false;
//             $form['message'] = 'Login ou mot de passe incorrect';
//         }
//     }

//     echo $twig->render('index.html.twig', array('form' => $form));
// }

function actionAccueil($twig, $db)
{
    if (isset($_SESSION['login'])) 
    {
        $projet = new Projet($db);
        $displayProjet = $projet->selectForDashboard();

        $tache = new Tache($db);
        $displayTache = $tache->selectForDashboard();

        echo $twig->render('index.html.twig', array('displayProjet' => $displayProjet, 'displayTache' => $displayTache));
    } 
    else 
    {
        echo $twig->render('connexion.html.twig');
    }
}


function actionConnexion($twig, $db)
{
    $form = array();
    $form['valide'] = true;

    if (isset($_POST['btConnecter'])) 
    {
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];

        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($inputEmail);

        if ($unUtilisateur != null) 
        {
            if (!password_verify($inputPassword, $unUtilisateur['mdp'])) 
            {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            } 
            else
            {
                $_SESSION['login'] = $inputEmail;
                $_SESSION['role'] = $unUtilisateur['idrole'];
                $_SESSION['idUtilisateur'] = $unUtilisateur['idUtilisateur'];

                if ($unUtilisateur['idrole'] == 2) 
                {
                    $ent = new Entreprise_Cliente($db);
                    $entInfos = $ent->selectById($_SESSION['idUtilisateur']);
                    $_SESSION['nom'] = $entInfos['nom'];
                }
                elseif ($unUtilisateur['idrole'] == 3 || $unUtilisateur['idrole'] == 4) 
                {
                    $dev = new Developpeur($db);
                    $devInfos = $dev->selectById($_SESSION['idUtilisateur']);
                    $_SESSION['nom'] = $devInfos['nom'];
                    $_SESSION['prenom'] = $devInfos['prenom'];
                }

                header("Location:index.php");
            }
        }
        else 
        {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'authentification';
        }
    }

    echo $twig->render('connexion.html.twig', array('form' => $form));
}

function actionDeconnexion($twig)
{
    session_unset();
    session_destroy();

    header("Location:index.php");
}

function actionInscription($twig, $db)
{
    $form = array();

    if (isset($_POST['btInscrire'])) 
    {
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 = $_POST['inputPassword2'];
        $inputNom = $_POST['inputNom'];
        $inputPrenom = $_POST['inputPrenom'];
        $inputRole = 2; // Signifie que par défaut, une personne est une entreprise cliente
        $form['valide'] = true;

        if ($inputPassword != $inputPassword2) 
        {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } 
        else 
        {
            $utilisateur = new Utilisateur($db);
            $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), $inputRole, $inputNom, $inputPrenom);

            if (!$exec) 
            {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
            }
            else
            {
                $unUtilisateur = $utilisateur->connect($inputEmail);
                $displayUtilisateur = $utilisateur->selectByEmail($inputEmail);

                $_SESSION['nom'] = $displayUtilisateur['nom'];
                $_SESSION['prenom'] = $displayUtilisateur['prenom'];
                $_SESSION['login'] = $inputEmail;
                $_SESSION['role'] = $unUtilisateur['idrole'];

                header("Location:index.php");
            }
        }

        $form['email'] = $inputEmail;
        $form['role'] = $inputRole;
    }

    echo $twig->render('inscription.html.twig', array('form' => $form));
}

function actionProfil($twig, $db)
{
    // // 0 : Utilisateur / 1 : Administrateur / 2 : Entreprise cliente / 3 : Développeur
    // if ($_SESSION['role'] = 0) 
    // {
        
    // }
    // elseif ($_SESSION['role'] = 1) 
    // {
        
    // }
    // elseif ($_SESSION['role'] = 2) 
    // {
        
    // }
    // elseif ($_SESSION['role'] = 3) 
    // {
    //     $dev = new Developpeur($db);
    //     $devComp = new Developpeur_Competence($db);
    //     $devEqui = new Developpeur_Equipe($db);

    //     $comp = $devComp->selectByIdDev()
    // }
    // else 
    // {
    //     // Un problème est survenu et tu fermes ta gueule !
    // }

    echo $twig->render('profil.html.twig', array());
}

function actionMentions($twig)
{
    echo $twig->render('mentions.html.twig', array());
}

function actionApropos($twig)
{
    echo $twig->render('apropos.html.twig', array());
}

function actionMaintenance($twig)
{
    echo $twig->render('maintenance.html.twig', array());
}

?>
