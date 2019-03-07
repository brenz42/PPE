<?php
//iddevcomp, iddev, idcomp
/* Pourquoi ce contrôleur ? :
- Ajouter des compétences à un développeur
- Supprimer des compétences à un développeur
- Lister toutes les compétences d'un développeur
- Lister tous les développeurs possédant telle ou telle compétence
*/

function getAllCompetencesOfDeveloppeur($db, $iddev)
{
    $devComp = new Developpeur_Competence($db);
    $liste = $devComp->selectByIdDev($iddev);

    return $liste;
}

function getAllDeveloppeursHavingCompetence($db, $idcomp)
{
    $devComp = new Developpeur_Competence($db);
    $liste = $devComp->selectByIdComp($idcomp);

    return $liste;
}


?>