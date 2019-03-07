<?php 


function actionContrat(){
    $form = array();
    $equipe = new Contrat($db);
    if(isset($_GET['id'])){
        $exec=$contrat->delete($_GET)['id'];
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table contrat';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] ='Contrat supprimée avec succès';
    }
        $liste = $equipe->select();
        echo$twig->redner('contrat.html.twig', array('form'=>$form,'liste'=>$liste));
}



function actionContratAjout($twig,$db){
    $form = array();
    if(isset($_POST['btAjouter'])){
        $inputDate_debut = $_POST['inputDate_debut'];
        $inputIdent = $_POST['inputIdent']; // a revoir //
        $form['valide'] = true ;
        $exec = $ contrat->insert($inputDate_debut, $inputIdent);
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion ddans la table Contrat';
        }
    }
    //a revoir// 
    else { 
        $utilisateur = new Utilisateur($db);
        $liste->$utilisateur->select();
        $form['liste'] = $liste;

    }
   echo $twig->render('contrat-ajout.html.twig', array('form'=>$form));

}

function actionContratMondif($twig,$db){

    $form = array();
    if(isset($_GET['id'])){
        $contrat = new contrat ($db);
        $unContrat = $contrat->selectById($_GET['id']);
    }
    if($unContrat != null){
        $form['contrat'] = $unContrat;
        //a revoir// 
        $developpeur = new Developpeur ($db);
        $liste = $developpeur->select();
        $form['liste'] = $liste;
    }
    else{
        $form['message'] = 'Contrat incorrect';
    }
    else{
        if(isset($_POST['btModifier'])){
            $id = $_POST['id'];
            $date_debut = $_POST['inputDate_debut'];
            $ident = new $_POST['inputIdent'];
            $contrat = new Contrat($db);
            $exec = $contrat->update($id,$date_debut,$date_fin,$date_signature,$cout_global,$idprojet,$ident); // a revoir // 
            if(!$exec){
                $form['valide'] = false;
                $form['message']= 'Echec de la modification du Contrat';
            }
            else{
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
                }

            }
                else {
                    $form['message'] = 'Utilisateur non précisé';
        }
    }

        echo $twig->render('contrat-modif.html.twig', array('form'=>$form));
}




// WebService
function actionEquipeWS($twig, $db){
    $contrat = new contrat($db);
    $json = json_encode($liste = $contrat->select()); 
    echo $json; 
 }

    


    

































    

?>