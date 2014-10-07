<?php
	require 'vendor/autoload.php';
	include 'Util/DatabaseBridge.php';
	include 'Util/Tools.php';
	include 'Util/Errors.php';
	include 'Util/Config.php';

	foreach (glob("classes/*.class.php") as $filename)
	{
	    include $filename;
	}

	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');



	/* 	*******************************************  *
	 *		Define all routes about a project 		 *
	 *		It means all creation in au project 	 *
	 *		has to be in this group 		 	  	 *
	 * 	*******************************************  */
	$app->group('/projects', function () use ($app) {

		/**
		*	Show all projects
		*/
		$app->get('/', function(){
			$response = new Response(Request::requestForAllProjects());
			echo json_encode($response);
		});

		/**
		*	Show One project
		*/
		$app->get('/:projectId', function ($projectId) use($app){
			if($projectId == "create" || $projectId == "filter"){
				$app->response->redirect('/', 404);
				return;
			}

			$response = new Response(null);
			$response->makeResponseForGetId($projectId, "requestForProject");
		});

		/**
		*	Choose the type of add
		*/
		$app->get('/:projectId/add', function ($projectId){
			$tab = array();
			$tab[0] = "tool";
			$tab[1] = "material";
			$tab[2] = "step";
			$response = new Response($tab,4211,true);
			$response->addMessage("You can use three type of add, on a project. tool, material and step. Exemple: /projects/1/add/tool/3");
			echo json_encode($response);
		});

		/**
		*	Choose the type of add
		*/
		$app->get('/:projectId/add/:what/', function ($projectId,$what){
			$response = new Response(null,4206,true);
			$response->addMessage("This action doesn't exist.");

			switch($what){
				case 'step':
					$response = new Response(null,4207,true);
                	$response->addMessage("The action step have to be posted with 'base64' parameter");
					break;
				case 'tool':
				case 'material':
					$response = new Response(null,4212,true);
					$response->addMessage("The id of $what is missing");
			}
			
			echo json_encode($response);
		});

		/**
		*	This route have to be posting. It is to make a new step for the project
		*/
		$app->post('/:projectId/add/:what', function ($projectId, $what) use($app){
			$base = $app->request->post('base64');
            $text = $app->request->post('text');

            $method = $app->router()->getCurrentRoute()->getHttpMethods()[0];
			$response = new Response(null);
			$response->makeResponseForAdd($method, $what, $projectId, null, $base, $text);
		});


		/**
		*	The action add, for a project, can be in get.
		*	The actions can be tool or material
		*/
		$app->get('/:projectId/add/:what/:id', function ($projectId, $what, $id) use($app){
			$method = $app->router()->getCurrentRoute()->getHttpMethods()[0];
			$response = new Response(null);
			$response->makeResponseForAdd($method, $what, $projectId, $id);
		});


		/**
		*	Create a new project in database, giving the name
		*/
		$app->get('/create/:projectName', function ($projectName) {
			$projectName = htmlentities($projectName);

			$response = new Response(null);
			$response->makeResponseForGetId($projectName, "createProject",true);
		});


		/**
		*	Groupe for the filters action on projects
		*/
		$app->group('/filter', function () use ($app) {
			/**
			*	Get all project after the date in parameter
			*/
			$app->get('/update/:date', function ($date) {
				$date = htmlentities($date);

				$response = null;

				//Check the date
				if(!Tools::isValidTimeStamp($date) || !Tools::isCorrect($date))
				{
					$response = new Response(null,4204,true);
					$response->addMessage("The date " . $date . " is not a valide timestamp");
				}
				else
				{
					$project = Request::requestForProjectsAfter($date);
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
		});

	});



	/* 	*******************************************  *
	 *		Define all routes about an Author 		 *
	 * 	*******************************************  */
	$app->group('/authors', function () use ($app) {

		/**
		*	Show all Authors
		*/
		$app->get('/', function(){
			$response = new Response(Request::requestForAllAuthors());
			echo json_encode($response);
		});

		/**
		*	Show one Author
		*/
		$app->get('/:id', function($id){
			$response = new Response(null);
			$response->makeResponseForGetId($id, "requestForAuthor");
		});

		$app->get('/:id/contribute/:stepId', function($id,$stepId){
			//Get projects
			$state = Request::addAuthorToStep($id,$stepId);


			if($state != null){
				$response = new Response(null,$state,true);
				$response->addMessage("The step id $stepId is already associated to the author $id");
			}
			else{
				$response = new Response(null);
				$response->addMessage("The contribution have been had");
			}

			//Send sesponse
			echo json_encode($response);
		});

		/**
		*	Create an author with name and birthday date
		*/
		$app->group('/create', function () use ($app) {

			//If the birthday is not pass in the route
			//There are a redirection with NULL as birth
			$app->get('/:name', function($name) use($app){
				$app->redirect("/authors/create/$name/NULL");
			});

			$app->get('/:name/:birth', function($name, $birth){
				$id = Request::createAuthor($name,$birth);

				//Make a response
				$response = new Response($id);
				$response->addMessage("The data is the id of the project");

				//Send sesponse
				echo json_encode($response);
			});
		});
	});



	/* 	*******************************************  *
	 *		Define all routes about an Tools 		 *
	 * 	*******************************************  */
	$app->group('/tools', function () use ($app) {

		/**
		*	Show all Tools
		*/
		$app->get('/', function(){
			$response = new Response(Request::requestForAllTools());
			echo json_encode($response);
		});

		/**
		*	Show one tool
		*/
		$app->get('/:id', function($id){
			$response = new Response(null);
			$response->makeResponseForGetId($id, "requestForTool");
		});

		/**
		*	Create a material with name, width, length and thickness
		*/
		$app->group('/create', function () use ($app) {

			//Redirections
			$app->get('/:name', function($name){
				$name = htmlentities($name);

				$response = new Response(null);
				$response->makeResponseForGetId($name, "createTool",true);
			});
		});
	});

	/* 	*******************************************  *
	 *		Define all routes about a Material 		 *
	 * 	*******************************************  */
	$app->group('/materials', function () use ($app) {

		/**
		*	Show all Tools
		*/
		$app->get('/', function(){
			$response = new Response(Request::requestForAllMaterials());
			echo json_encode($response);
		});

		/**
		*	Show one tool
		*/
		$app->get('/:id', function($id){
			$response = new Response(null);
			$response->makeResponseForGetId($id, "requestForMaterial");
		});

		/**
		*	Create a material with name, width, length and thickness
		*/
		$app->group('/create', function () use ($app) {

			//Redirections
			$app->get('/:name', function($name) use($app){
				$app->redirect("/materials/create/$name/NULL/NULL/NULL");
			});

			$app->get('/:name/:width', function($name,$width) use($app){
				$app->redirect("/materials/create/$name/$width/NULL/NULL");
			});

			$app->get('/:name/:width/:length', function($name,$width,$length) use($app){
				$app->redirect("/materials/create/$name/$width/$length/NULL");
			});

			//Real route
			$app->get('/:name/:width/:length/:thickness', function($name,$width,$length,$thickness){
				$id = Request::createMaterial($name, $width, $length, $thickness);

				//Make a response
				$response = new Response($id);
				$response->addMessage("The data is the id of the project");

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
	    $router   = $app->router();
	    $routes = $router->getAllRoutes();

	    $tab = array();

	    foreach($routes as $route){
	    	$methods = $route->getHttpMethods();
	    	$text = "";
	    	foreach($methods as $key => $method){
	    		$text .= $method . ( $key == count($methods)-1 ? "." : ", ");
	    	}
	    	$pat = $route->getPattern();
	    	$tab[] = $pat;
	    }

		//Make a response
		$response = new Response($tab,404,true);
		$response->addMessage("This route dosn't exist. Please try one of them.");

		//Send sesponse
		echo json_encode($response);
	});


	

	$app->run();
