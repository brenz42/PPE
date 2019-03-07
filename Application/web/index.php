<?php
session_start();
/* initialisation des fichiers TWIG */
require_once '../src/lib/vendor/autoload.php';
require_once '../src/config/parametres.php';
require_once '../src/app/connexion.php';
require_once '../src/config/routing.php';
require_once '../src/controleur/_controleurs.php';
require_once '../src/modele/_classes.php';

$loader = new Twig_Loader_Filesystem('../src/vue/');
$twig = new Twig_Environment($loader, array());
$twig->addGlobal('session', $_SESSION);

$db = connect($config);

#region SELECT COUNT des données dans les tables
$user = new Utilisateur($db);
$userCount = $user->selectCount();
$twig->addGlobal('userCount', $userCount);

$comp = new Competence($db);
$compCount = $comp->selectCount();
$twig->addGlobal('compCount', $compCount);

$dev = new Developpeur($db);
$devCount = $dev->selectCount();
$twig->addGlobal('devCount', $devCount);

$equi = new Equipe($db);
$equiCount = $equi->selectCount();
$twig->addGlobal('equiCount', $equiCount);

$cli = new Entreprise_Cliente($db);
$cliCount = $cli->selectCount();
$twig->addGlobal('cliCount', $cliCount);

$proj = new Projet($db);
$projCount = $proj->selectCount();
$twig->addGlobal('projCount', $projCount);

$tac = new Tache($db);
$tacCount = $tac->selectCount();
$twig->addGlobal('tacCount', $tacCount);

$cont = new Contrat($db);
$contCount = $cont->selectCount();
$twig->addGlobal('contCount', $contCount);

$sumCout = $cont->selectSumCount();
// Notation française
$contSumCout = number_format($sumCout, 2, ',', ' ');
$twig->addGlobal('contSumCout', $contSumCout);

$remu = new Remuneration($db);
$remuCount = $remu->selectCount();
$twig->addGlobal('remuCount', $remuCount);
#endregion

$contenu = getPage($db);
// Exécution de la fonction souhaitée
$contenu($twig,$db);


?>
