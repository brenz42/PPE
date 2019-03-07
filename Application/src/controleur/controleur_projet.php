<?php 

function ActionProjet($twig,$db)
{
    $form = array();
    $projet = new Projet($db);

    if(isset($_GET['id']))
    {
        $exec = $projet->delete($_GET['id']);

        if(!$exec)
        {
            $form['valide'] = false;
            $form['message']= 'Problème de suppression dans la table ';
        }
        else
        {
            $form['valide'] = true;
        }

        $form['message'] = 'Contrat supprimé avec succès ';
    }

    $liste = $equipe->select();
    echo $twig->render('contrat.html.twig',array('form'=>$form,'liste'=>$liste));
}


function ActionProjetAjout($twig,$db)
{
    $form =  array ();

    if(isset($_POST['btAjouter']))
    {
        $inputLibelle = $_POST['inputLibelle'];
        $inputIdequi = $_POST['inputIdequi'];  
        $form['valide'] = true ;
        $projet = new projet ($db);
        $exec = $projet->insert($inputLibelle, $inputIdequi);

        if(!exec)
        {
            $form['valide'] = false;
            $form['message'] = 'Probleme d\'insertion dans la table projet';
        }
    }
    else
    {
        // a revoir // 
        $developpeur = new Developpeur($db);
        $liste = $developpeur->select();
        $form['liste'] = $liste;
    }

    echo $twig->render('projet-ajout.html.twig', array('form'=>$form)); 
}



function ActionProjetModif($twig,$db)
{
    $form = array ();

    if(isset($_GET['id']))
    {
        $projet = new Projet($db);
        $unProjet = $equipe->selectedById($_GET['id']);

        if($unProjet!=null)
        {
            $form['equipe'] = $unProjet;
            $utilisateur = new Utilisateur($db);
            $liste = $utilisateur->select();
            $form['liste'] = $liste;
        }
        else
        {
            $form['message'] = 'Projet inconrrecte ';
        }
    }
    else 
    {
        if(isset($_POST['btModifier']))
        {
            $id = $POST['id'];
            $libelle = $_POST['inputLibelle'];
            $projet = new Projet($db);
            $exec = $projet->update($id,$libelle,$idequi);

            if($exec)
            {
                $form['valide'] = false ;
                $form['message'] = 'Echec de la modification de l\'equipe';
            }
            else
            {
                $form['valide'] = true ;
                $form['message'] = 'Modification reussie';
            }
        }
        else
        {
            $form['message'] = 'Utilisateur non precise';
        }
    }

    echo $twig->render('projet-modif.html.twig', array('form'=>$form));
}


        
// WebService
function actionEquipeWS($twig, $db)
{
    $projet = new projet($db);
    $json = json_encode($liste = $projet->select()); 
    echo $json; 
}

?> 