<?php

/* ****************************** */
/*		Connexion function 		  */
/* ****************************** */
function connect(){
	$dns = 'mysql:host=localhost;dbname=documathon;charset=utf8';
	$utilisateur = 'root';
	$motDePasse = 'root';
	$connexion = null;
	try
	{
	    $connexion = new PDO( $dns, $utilisateur, $motDePasse );
	}
	catch(Exception $e)
	{
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
        die;
	}

	return $connexion;
}

/* ****************************** */
/*		Request functions 		  */
/* ****************************** */

function requestForAllProjects($connexion = null){
	return requestForManyProjects("SELECT * FROM Project");
}

function requestForProjectsAfter($date, $connexion = null){
	return requestForManyProjects("SELECT * FROM Project WHERE UNIX_TIMESTAMP(date)>" . $date);
}

function requestForManyProjects($query, $connexion = null){
	if($connexion == null)
		$connexion = connect();

	$tab = array();
	$projects = $connexion->query($query);

	while($project = $projects->fetchObject('Project')) {
		hydrateProject($project, $connexion);
    	$tab[] = $project;
  	}

  	if(count($tab) == 1)
  		return $tab[0];
  	else if(count($tab) == 0)
  		return null;

  	return $tab;
}

function requestForProject($id = null, $connexion = null){
	if($connexion == null)
		$connexion = connect();

	$tab = array();
	$projects = $connexion->query("SELECT * FROM Project WHERE id='" . $id ."'");

	while($project = $projects->fetchObject('Project')) {
		hydrateProject($project, $connexion);
    	return $project;
  	}
  	return null;
}

function requestForSteps($project, $connexion = null){
	if($connexion == null)
		$connexion = connect();

	$stepsForProject = $connexion->query("SELECT * FROM Step WHERE projectId='". $project->id ."'");
	while($step = $stepsForProject->fetchObject('Step')){
		requestForAuthors($step,$connexion);
		$project->steps[] = $step;
	}
}

function requestForTools($project, $connexion = null){
	$project->tools = hydrate(
		$project->tools, 
		"SELECT id, name FROM Tool JOIN Tool_has_Project ON Tool_has_Project.toolId=Tool.id WHERE Tool_has_Project.projectId='" . $project->id . "'",
		'Tool',
		$connexion);
}

function requestForMaterials($project, $connexion = null){
	$project->materials = hydrate(
		$project->materials,
		"SELECT id, name, width, length, thickness FROM Material JOIN Material_has_Project ON Material_has_Project.materialId=Material.id WHERE Material_has_Project.projectId='" . $project->id . "'",
		'Material',
		$connexion);
}

function requestForAuthors($step, $connexion = null){
	$step->authors = hydrate(
		$step->authors,
		"SELECT id, name FROM Author JOIN Step_has_Author ON Step_has_Author.authorId=Author.id WHERE Step_has_Author.stepId='" . $step->id . "'",
		'Author',
		$connexion);
}

/* ****************************** */
/*		Hydrate functions 		  */
/* ****************************** */

function hydrateProject($project, $connexion){
	if($connexion == null)
		$connexion = connect();

	requestForSteps($project,$connexion);
	requestForMaterials($project,$connexion);
	requestForTools($project,$connexion);
}

function hydrate($objectTab, $query, $class, $connexion){
	if($connexion == null)
		$connexion = connect();
	$tabResult = $connexion->query($query);
	while($obj = $tabResult->fetchObject($class)){
		$objectTab[] = $obj;
	}

	return $objectTab;
}