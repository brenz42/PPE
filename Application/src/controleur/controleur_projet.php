<?php 

function actionProjet($twig,$db)
{
    $form = array();
    $projet = new Projet($db);

    if(isset($_GET['idprojet']))
    {
        
        $exec = $projet->delete($_GET['idprojet']);

        if(!$exec)
        {
            $form['valide'] = false;
            $form['message']= 'Problème de suppression dans la table projet ';
        }
        else
        {
            $form['valide'] = true;
        }

        $form['message'] = 'Projet supprimé avec succès ';
    }

    $liste = $projet->select();

    $coutOriginal = array_search('cout_global', $liste);
    $coutFormate = number_format($coutOriginal, 2, ',', ' ');
    $liste['coutGlobal'] = $coutFormate;
    //print_r($liste);

    echo $twig->render('projet.html.twig', array('form' => $form, 'liste' => $liste));
}


function actionProjetAjout($twig,$db)
{
    $form =  array ();
    $projet = new Projet($db);

    $equipe = new Equipe($db);
    $contrat = new Contrat($db);
   

    $listeEquipe = $equipe->select();
    $listeContrat = $contrat->select();
    

    if(isset($_POST['btAjouter']))
    {
        
        $inputLibelle = $_POST['inputLibelle'];
        $inputActif = $_POST['inputIdActif'];
        $inputIdpriorite = $_POST['inputIdpriorite'];
        $inputIdprogression = $_POST['inputIdprogression'];
        $inputIdequi = $_POST['inputIdequi'];
        $inputIdcontrat = $_POST['inputIdcontrat'];
        
        $form['valide'] = true ;

        $exec = $projet->insert($inputLibelle,$inputActif,$inputIdpriorite,$inputIdprogression,$inputIdequi,$inputIdcontrat );

        if(!$exec)
        {
            
            $form['valide'] = false;
            $form['message'] = 'Probleme d\'insertion dans la table projet';
        }
    }
    

    echo $twig->render('projet-ajout.html.twig', array('form'=>$form,'liste'=>$liste,'listeEquipe'=>$listeEquipe,'listeContrat'=>$listeContrat)); 
}



function actionProjetModif($twig,$db)
{
    $form = array ();

    $equipe = new Equipe($db);
    $contrat = new Contrat($db);


    $listeEquipe = $equipe->select();
    $listeContrat = $contrat->select();

    if(isset($_GET['idprojet']))
    {
        $projet = new Projet($db);
        $unProjet = $projet->selectById($_GET['idprojet']);

        if($unProjet!=null)
        {
          $displayProjet = $unProjet;
        }
        else
        {
            $form['message'] = 'Projet inconrecte ';
        }
    }
    
        if(isset($_POST['btModifier']))
        {
            $idProjet = $_GET['idprojet'];
            $inputLibelle = $_POST['inputLibelle'];
            $inputActif = $_POST['inputActif'];
            $inputIdpriorite = $_POST['inputIdpriorite'];
            $inputIdprogression = $_POST['inputIdprogression'];
            $inputIdequi = $_POST['inputIdequi'];
            $inputIdcontrat = $_POST['inputIdcontrat'];
    
            $projet = new Projet($db);
            $exec = $projet->update($idProjet, $inputLibelle, $inputActif, $inputIdpriorite, $inputIdprogression, $inputIdequi, $inputIdcontrat);

            if (!$exec)
            {
                $form['valide'] = false ;
                $form['message'] = 'Echec de la modification du Projet';
            }
            else
            {
                $form['valide'] = true ;
                $form['message'] = 'Modification reussie';
            }
        }
        else
        {
            $form['message'] = 'Projet non precise';
        }
    

    echo $twig->render('projet-modif.html.twig', array('form'=>$form, 'displayProjet' =>$displayProjet,'liste'=>$liste,'listeEquipe'=>$listeEquipe,'listeContrat'=>$listeContrat));
}


        
// WebService
function actionProjetWS($twig, $db)
{
    $projet = new Projet($db);
    $json = json_encode($liste = $projet->select()); 
    echo $json; 
}

?> 