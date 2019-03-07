<?php

function getPage($db)
{
  // Inscrire vos contrôleurs ici
  $lesPages['inscription'] = "actionInscription;0";
  $lesPages['connexion'] = "actionConnexion;0";
  $lesPages['deconnexion'] = "actionDeconnexion;0";

  $lesPages['accueil'] = "actionAccueil;0";
  $lesPages['mentions'] = "actionMentions;0";
  $lesPages['apropos'] = "actionApropos;0";
  $lesPages['maintenance'] = "actionMaintenance;0";
  $lesPages['profil'] = "actionProfil;0";

  $lesPages['utilisateur'] = "actionUtilisateur;1";
  $lesPages['utilisateurmodif'] = "actionUtilisateurModif;1";

  $lesPages['equipe'] = "actionEquipe;1";
  $lesPages['equipeajout'] = "actionEquipeAjout;1";
  $lesPages['equipemodif'] = "actionEquipeModif;1";
  $lesPages['equipews'] = "actionEquipeWS;0";

  $lesPages['competence'] = "actionCompetence;1";
  $lesPages['competenceajout'] = "actionCompetenceAjout;1";
  $lesPages['competencemodif'] = "actionCompetenceModif;1";
  $lesPages['competencews'] = "actionCompetenceWS;0";

  $lesPages['developpeur'] = "actionDeveloppeur;1";
  $lesPages['developpeurajout'] = "actionDeveloppeurAjout;1";
  $lesPages['developpeurmodif'] = "actionDeveloppeurModif;1";
  $lesPages['developpeurws'] = "actionDeveloppeurWS;0";

  $lesPages['remuneration'] = "actionRemuneration;1";
  $lesPages['remunerationajout'] = "actionRemunerationAjout;1";
  $lesPages['remunerationmodif'] = "actionRemunerationModif;1";
  $lesPages['remunerationws'] = "actionRemunerationWS;0";


  if ($db != null) 
  {
    if (isset($_GET['page'])) 
    {
      // Nous mettons dans la variable $page, la valeur qui a été passée dans le lien
      $page = $_GET['page'];
    } 
    else 
    {
      // S'il n'y a rien en mémoire, nous lui donnons la valeur « accueil » 
      // afin de lui afficher une page par défaut
      $page = 'accueil';
    }

    if (!isset($lesPages[$page])) 
    {
      // Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
      $page = 'accueil';
    }

    $explose = explode(";", $lesPages[$page]);
    $role = $explose[1];
      
      // Si le rôle nécessite de contrôler les droits
    if ($role != 0) 
    {
      // Nous vérifions que la personne est connectée
      if (isset($_SESSION['login'])) 
      {
        //Nous vérifions qu'elle a un rôle
        if (isset($_SESSION['role'])) 
        {
          if ($role != $_SESSION['role']) 
          {
            //Nous redigeons la personne vers la page d'acccueil car elle n'a pas le bon rôle 
            $contenu = 'actionAccueil';
          } 
          else 
          {
            // La personne est autorisée à récupérer  
            $contenu = $explose[0];
          }
        } 
        else 
        {
          // Dans la session le rôle n'existe pas donc on va sur la page d'accueil 
          $contenu = 'actionAccueil';
        }
      } 
      else 
      {
        // La personne n'est pas connectée, donc on va sur la page d'accueil  
        // $contenu = 'actionAccueil';
        $contenu = 'actionConnexion';
      }
    } 
    else 
    {
      // Nous donnons du contenu non protégé  
      $contenu = $explose[0];
    }
  }
  else 
  {
    // La base de données n'est pas accessible
    $contenu = 'actionMaintenance';
  }

  // La fonction envoie le contenu
  return $contenu;
}

?>