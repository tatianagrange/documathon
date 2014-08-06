<?php
	require 'vendor/autoload.php';
	include('classes/Step.class.php');
	include('classes/Author.class.php');
	include('classes/Project.class.php');
	include('classes/Response.class.php');


	//This is a realy dirty code to send something in the api
	function makeDirtyDatas($id = null, $date = null){
		$adel = new Author("Adel",2,680608800);
		$cloe = new Author("Cloe",3,613216800);
		$faclab = new Author("Faclab",1);

		$project1 = new Project(1407324126, "Enceintes", 1);

		$step1 = new Step("http://i2.cdscdn.com/pdt2/5/7/6/1/700x700/inn3700615068576/rw/mini-enceinte-bluetooth-innova.jpg", 1, "premières réflexions sur l'enceinte", $faclab->getId());
		$step1->mAuthor = $faclab;
		$step2 = new Step("http://i2.cdscdn.com/pdt2/0/5/7/1/700x700/mus3700460202057/rw/enceinte-bluetooth-et-stereo.jpg", 1, null, $faclab->getId());
		$step2->mAuthor = $faclab;
		$step3 = new Step("http://www.son-video.com/images/dynamic/Docks_et_enceintes_iPod_iPhone/articles/Samsung/SAMSDAE750/Samsung-DA-E750_3QG_1200.jpg", 1, "C'est mieux comme ça", $adel->getId());
		$step3->mAuthor = $adel;

		$project1->mSteps = array($step1,$step2,$step3);
		$project1->mAuthor = array($adel,$faclab);

		if($id == 1)
			return $project1;

		$project2 = new Project(1375869600,"Planteux", 2);
		$step1 = new Step("https://2.bp.blogspot.com/_JAEagW5pJPU/R7mlDuGUpOI/AAAAAAAAAW4/SLNvJtIdMjI/s320/planteux.jpg", 2, null, $cloe->getId());
		$step1->mAuthor = $cloe;

		$project2->mSteps = array($step1);
		$project2->mAuthor = array($cloe);

		if($id == 2)
			return $project2;

		$tab = array();
		if($date <= $project1->getDate())
			$tab[0] = $project1;
		if($date <= $project2->getDate())
			$tab[1] = $project2;

		return $tab;
	}


	/* 	************************  */
	/*		Define all routes  	  */
	/* 	************************  */

	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');

	/**
	*	Informe the user that the route is not correct.
	*/
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
	*	Get all project after date
	*/
	$app->get('/projects/date/:date', function ($date) {
		//TODO get the good project
		$data = makeDirtyDatas(null, $date);

		$response = null;

		if(count($data) != 0){
			$response = new Response($data);
			$response->addMessage("WARNING: THE DATAS ARE WRITE IN THE CODE. IT IS SOME DATA TO MAKE TESTS");
		}
		else{
			$response = new Response(null,4203,true);
			$response->addMessage("THERE ARE NO PROJECT AFTER THIS DATE");
		}

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


	/**
	*	Show One project
	*/
	$app->get('/projects/:id', function ($id) {
		//TODO get the good project
		$data = makeDirtyDatas($id);
		if(is_array($data))
			$data = null;

		$response = null;

		if($data != null){
			$response = new Response($data);
			$response->addMessage("WARNING: THE DATAS ARE WRITE IN THE CODE. IT IS SOME DATA TO MAKE TESTS");
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

		//TODO Find all projects in database
		$tab = makeDirtyDatas();

		//Make a response
		$response = new Response($tab);
		$response->addMessage("WARNING: THE DATAS ARE WRITE IN THE CODE. IT IS SOME DATA TO MAKE TESTS");

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
		$tab["/projects/date/:date"] = "Return all project after the date pass in argument";

		//Make a response
		$response = new Response($tab,404,true);
		$response->addMessage("This route dosn't exist. Please try one of them.");

		//Send sesponse
		echo json_encode($response);
	});


	

	$app->run();
