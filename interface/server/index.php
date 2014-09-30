<?php
	require 'vendor/autoload.php';
	include 'Util/DatabaseBridge.php';
	include 'Util/Tools.php';

	foreach (glob("classes/*.class.php") as $filename)
	{
	    include $filename;
	}


	/* 	************************  */
	/*		Define all routes  	  */
	/* 	************************  */

	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');


	/**
	*	Informe the user that the route is not correct.
	*/

	// $app->get('/projects/create', function () {
	// 	//Liste all routes
	//     $tab = array();
	// 	$tab["/projects/create/:projectName"] = "Create a new project in database, with de name pass in argument";

	// 	listFonctionality($tab,4201);
	// });

	$app->get('/projects/filter', function () {
		//Liste all routes
	    $tab = array();
		$tab["/projects/filter/date/:date"] = "Get the projects update after the date in timestamp";
		$tab["/projects/filter/start/:date"] = "Get the projects start after the date in timestamp";
		$tab["/projects/filter/author/:id"] = "Get the projects on which the author participated.";
		$tab["/projects/filter/material/:id"] = "Get the projects on which use the material.";
		$tab["/projects/filter/tool/:id"] = "Get the projects on which use the tool.";

		Tools::listFonctionality($tab,4205);
	});


	/* 	************************  */
	/*		Filters routes  	  */
	/* 	************************  */

	/**
	*	Get all project after date
	*/
	$app->get('/projects/filter/date/:date', function ($date) {
		$response = null;

		//Check the date
		if(!Tools::isValidTimeStamp($date) || !Tools::isCorrect($date))
		{
			$response = new Response(null,4204,true);
			$response->addMessage("The date " . $date . " is not a valide timestamp");
		}
		else
		{
			$project = requestForProjectsAfter($date);
			if(count($project) != 0){
				$response = new Response($project);
			}
			else{
				$response = new Response(null,4203,true);
				$response->addMessage("There are no projects after this date");
			}
		}

		
		//Send sesponse
		echo json_encode($response);
	});

	/**
	*	Get all project which start after date
	*/
	$app->get('/projects/filter/start/:date', function ($date) {
		$response = new Response(42);
		$response->addMessage("Under construction");
		//Send sesponse
		echo json_encode($response);
	});

	/**
	*	Get the projects on which the author participated
	*/
	$app->get('/projects/filter/author/:id', function ($date) {
		$response = new Response(42);
		$response->addMessage("Under construction");
		//Send sesponse
		echo json_encode($response);
	});

	/**
	*	Get the projects on which use the material
	*/
	$app->get('/projects/filter/material/:id', function ($date) {
		$response = new Response(42);
		$response->addMessage("Under construction");
		//Send sesponse
		echo json_encode($response);
	});

	/**
	*	Get the projects on which use the tool
	*/
	$app->get('/projects/filter/tool/:id', function ($date) {
		$response = new Response(42);
		$response->addMessage("Under construction");
		//Send sesponse
		echo json_encode($response);
	});


	/* 	********************  */
	/*		Other routes  	  */
	/* 	********************  */

	/**
	*	Create a new project in database, with de folder pass in argument
	*/
	$app->get('/projects/create/:projectName', function ($projectName) {
		
		$id = createProject($projectName);


		//Make a response
		$response = new Response($id);
		$response->addMessage("The data is the id of the project");

		//Send sesponse
		echo json_encode($response);
	});

    
    $app->post('/projects/:id/addStep/:text', function($id,$text) use($app){
		$base = $app->request->post('base64');
    	$id = createStep($id, $base, $text);
        
		//Make a response
		$response = new Response($id);
		$response->addMessage("The data is the id of the project");

		//Send response
		echo json_encode($response);
	});


	/**
	*	Show One project
	*/
	$app->get('/projects/:id', function ($id) {
		//Get project
		$project = requestForProject($id);

		if(!is_array($project)){
			$response = new Response($project);
		}
		else{
			$response = new Response(null,4202,true);
			$response->addMessage("THIS ID DOSN'T EXIST");
		}

		//Send sesponse
		echo json_encode($response);
	});


	/**
	*	Show all projects
	*/
	$app->get('/projects', function () {
		//Get projects
		$tab = requestForAllProjects();
		//Make a response
		$response = new Response($tab);
		//Send sesponse
		echo json_encode($response);
	
	});


	/* 	************************************  */
	/*		The routes bellow are empty.  	  */
	/*		There juste used to informe  	  */
	/*		user about the other routes 	  */
	/* 	************************************  */

	$app->notFound(function () use ($app) {
	    //Liste all routes
	    $tab = array();
		$tab["/projects"] = "Show all projects";
		$tab["/projects/:id"] = "Show One project";
		$tab["/projects/create/:folderName"] = "Create a new project in database, with de folder pass in argument";
		$tab["/projects/filter"] = "Get all route with filter for projects";
		$tab["/projects/filter/date/:date"] = "Get the projects update after the date in timestamp";
		$tab["/projects/filter/start/:date"] = "Get the projects start after the date in timestamp";
		$tab["/projects/filter/author/:id"] = "Get the projects on which the author participated.";
		$tab["/projects/filter/material/:id"] = "Get the projects on which use the material.";
		$tab["/projects/filter/tool/:id"] = "Get the projects on which use the tool.";

		//Make a response
		$response = new Response($tab,404,true);
		$response->addMessage("This route dosn't exist. Please try one of them.");

		//Send sesponse
		echo json_encode($response);
	});


	

	$app->run();
