<?php 


function actionContrat($twig,$db)
{
    $form = array();
    $contrat = new Contrat($db);

    if(isset($_GET['idcontrat']))
    {
        $idcont = $_GET['idcontrat'];

        $tache = new Tache($db);
        $projet = new Projet($db);

        $unProject = $projet->selectByIdContrat($idcont);
    
        var_dump($unProject);

                // $tache->deleteByIdProjet($unProject["idprojet"]);
                // $projet->delete($unProject["idprojet"]);
        

       
        $exec=$contrat->delete($_GET['idcontrat']);

        if(!$exec){
            echo"etape2";

            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table contrat';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] ='Contrat supprimée avec succès';
    }

    $liste = $contrat->select();
    echo $twig->render('contrat.html.twig', array('form'=>$form,'liste'=>$liste));
}



function actionContratAjout($twig,$db){
    $form = array();
    $contrat = new Contrat($db);
    $entreprise = new Entreprise_Cliente($db);
    $listeEntreprise = $entreprise->select();

    if(isset($_POST['btAjouter'])){
        echo 'etape 1';
        $inputDate_debut = $_POST['inputDate_debut'];
        $inputDate_fin = $_POST['inputDate_fin'];
        $inputDate_signature = $_POST['inputDate_signature'];
        $inputCout_global = $_POST['inputCout_global'];
        $inputIdent = $_POST['inputIdent'];
        
        
        $form['valide'] = true ;

        $exec = $contrat->insert($inputDate_debut, $inputDate_fin, $inputDate_signature, $inputCout_global, $inputIdent);
        if(!$exec){ 
            echo 'etape 2';
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table Contrat';
        }
    }
    
  
   echo $twig->render('contrat-ajout.html.twig', array('form'=>$form,'liste'=>$liste, 'listeEntreprise'=>$listeEntreprise));

}

// function actionContratMondif($twig,$db){
//     $form = array();

//     if(isset($_GET['idcontrat'])){

//         $contrat = new contrat($db);
//         $unContrat = $contrat->selectById($_GET['idcontrat']);

//         if($unContrat != NUL)
//         {

//             $displayComp = $unContrat;
//         }
//         else
//         {
//             $form['message'] = 'Contrat incorrecte';
//         }
//     }   
    
//     if (isset($_POST['btModifier'])) 
//     {
//         $idcomp = $_GET['idcontrat'];
//         $inputLibelle = $_POST['inputLibelle'];
//         $inputDate_debut = $_POST['Date_debut'];
        
//         $competence = new Competence($db);
//         $exec = $competence->update($idcomp, $inputLibelle, $inputVersion);

//         if (!$exec) 
//         {
//             $form['valide'] = false;
//             $form['message'] = 'Echec de la modification de la compétence';
//         } 
//         else 
//         {
//             $form['valide'] = true;
//             $form['message'] = 'Modification de la compétence réussie';
//         }
//     } 
//     else 
//     {
//         $form['message'] = 'Compétence non précisée';
//     }

//     echo $twig->render('competence-modif.html.twig', array('form' => $form, 'displayComp' => $displayComp));
// }

//}




// WebService
function actionContratWS($twig, $db){
    $contrat = new contrat($db);
    $json = json_encode($liste = $contrat->select()); 
    echo $json; 
 }

    


    

































    

?>