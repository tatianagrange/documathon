<?php
	require 'vendor/autoload.php';
	include 'Util/DatabaseBridge.php';
	include 'Util/Tools.php';
	include 'Util/Config.php';

	foreach (glob("classes/*.class.php") as $filename)
	{
	    include $filename;
	}


	/* 	************************  */
	/*		Define all routes  	  */
	/* 	************************  */

	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');


	$app->group('/projects', function () use ($app) {

		/**
		*	Show all projects
		*/
		$app->get('/', function(){
			//Get projects
			$tab = requestForAllProjects();

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
		});


		/**
		*	Show One project
		*/
		$app->get('/:id', function ($id) {
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
		*	This route have to be posting. It is to make a new step for the project
		*/
		$app->post('/:id/addStep/:text', function($id,$text) use($app){
			$base = $app->request->post('base64');
	    	$id = createStep($id, $base, $text);
	        
			//Make a response
			$response = new Response($id);
			$response->addMessage("The data is the id of the project");

			//Send response
			echo json_encode($response);
		});


		/**
		*	Create a new project in database, giving the name
		*/
		$app->get('/create/:projectName', function ($projectName) {
			
			$id = createProject($projectName);


			//Make a response
			$response = new Response($id);
			$response->addMessage("The data is the id of the project");

			//Send sesponse
			echo json_encode($response);
		});


		/**
		*	Groupe for the filters action on projects
		*/
		$app->group('/filter', function () use ($app) {
			/**
			*	Get all project after the date in parameter
			*/
			$app->get('/update/:date', function ($date) {
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
			$app->get('/start/:date', function ($date) {
				$response = new Response(42);
				$response->addMessage("Under construction");
				//Send sesponse
				echo json_encode($response);
			});


			/**
			*	Get the projects on which the author participated
			*/
			$app->get('/author/:id', function ($date) {
				$response = new Response(42);
				$response->addMessage("Under construction");
				//Send sesponse
				echo json_encode($response);
			});


			/**
			*	Get the projects on which use the material
			*/
			$app->get('/material/:id', function ($date) {
				$response = new Response(42);
				$response->addMessage("Under construction");
				//Send sesponse
				echo json_encode($response);
			});


			/**
			*	Get the projects on which use the tool
			*/
			$app->get('/tool/:id', function ($date) {
				$response = new Response(42);
				$response->addMessage("Under construction");
				//Send sesponse
				echo json_encode($response);
			});
		});

	});


	/* 	************************************  */
	/*		The routes bellow are empty.  	  */
	/*		There juste used to informe  	  */
	/*		user about the other routes 	  */
	/* 	************************************  */

	$app->notFound(function () use ($app) {
	    //Liste all routes
	    $tab = array();
		$tab["In Construction"] = "In Construction";

		//Make a response
		$response = new Response($tab,404,true);
		$response->addMessage("This route dosn't exist. Please try one of them.");

		//Send sesponse
		echo json_encode($response);
	});


	

	$app->run();
