<?php
	require 'vendor/autoload.php';
	include('classes/Image.class.php');
	include('classes/Response.class.php');


	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');


	$app->get('/projects/create', function () {
		//Liste all routes
	    $tab = array();
		$tab["/projects/create/:folderName"] = "Create a new project in database, with de folder pass in argument";

		//Make a response
		$response = new Response($tab,4201,true);
		$response->addMessage("This is not the correct use of this route. Please use this");

		//Send sesponse
		echo json_encode($response);
	});


	/**
	*	Show all projects
	*/
	$app->get('/projects', function () {

		//TODO Find all projects in database
		$image = new Image("Mon image", "Mon Auteur");
		$image2 = new Image("Deuxième", "Mon Auteur");

		$tab = array();
		$tab[0] = $image;
		$tab[1] = $image2;

		//Make a response
		$response = new Response($tab);
		$response->addMessage("WARNING: THE DATAS ARE NOT OBJECT OF PROJECT TYPE. IT IS JUSTE SOME IMAGES");

		//Send sesponse
		echo json_encode($response);
	
	});

	/**
	*	Show One project
	*/
	$app->get('/projects/:id', function ($id) {
		//TODO get the good project
		$image = new Image("Super projet $id", "haha");

		//Make a response
		$response = new Response($image);
		$response->addMessage("WARNING: THE DATAS ARE NOT OBJECT OF PROJECT TYPE. IT IS JUSTE ONE IMAGE");

		//Send sesponse
		echo json_encode($response);
	});

	/**
	*	Create a new project in database, with de folder pass in argument
	*/
	$app->get('/projects/create/:folderName', function () {
		//Make a response
		$response = new Response(42);
		$response->addMessage("The data is the id of the project");

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

		//Make a response
		$response = new Response($tab,404,true);
		$response->addMessage("This route dosn't exist. Please try one of them.");

		//Send sesponse
		echo json_encode($response);
	});


	

	$app->run();
