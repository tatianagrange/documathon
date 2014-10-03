<?php
	require 'vendor/autoload.php';
	include 'Util/DatabaseBridge.php';
	include 'Util/Tools.php';
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
		$app->get('/:projectId', function ($projectId) {
			//Get project
			$project = requestForProject($projectId);

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
		*	The action add, for a project, can be in get.
		*	The actions can be tool or material
		*/
		$app->get('/:projectId/add/:what/:id', function ($projectId, $what, $id) {
			$response = new Response(null,4206,true);
			$response->addMessage("This action doesn't exist.");

			switch($what){
				case 'step':
	    			$response = new Response(null,4207,true);
	    			$response->addMessage("The action step have to be posted with 'base64' parameter");
					break;
				case 'tool':
				case 'material':
					$state = addToProject($projectId, $what, $id);
					if($state != null){
						$response = new Response(null,$state,true);
						$response->addMessage("The id $id is already associated to the project $projectId");
					}
					else{
						$response = new Response(null);
						$response->addMessage("The $what have been had");
					}
					break;
			}

			echo json_encode($response);
		});


		/**
		*	This route have to be posting. It is to make a new step for the project
		*/
			$app->post('/:projectId/add/:what/:id', function ($projectId, $what, $id) {
				$response = new Response(null,4206,true);
				$response->addMessage("This action doesn't exist.");

				switch($what){
					case 'step':
						$base = $app->request->post('base64');
						if($base == null){
							$response = new Response(null,4207,true);
							$response->addMessage("The action step have to be posted with 'base64' parameter");
						}else{
			    			$id = createStep($id, $base, $text);
			    			$response = new Response($id);
			    			$response->addMessage("The data is the id of the project");
			    		}
						break;
					case 'tool':
					case 'material':
						$response = new Response(null,4209,true);
		    			$response->addMessage("The action $what is a GET request");
						break;
					break;
				}

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

		// $app->group('/associate', function () use ($app) {
		// 	$app->get('/tool/:id', function ($id) {
		// 		$state = associateToolAndProject()
		// 	});

		// 	$app->get('/tool/:id', function ($id) {

		// 	});
		// });


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



	/* 	*******************************************  *
	 *		Define all routes about an Author 		 *
	 * 	*******************************************  */
	$app->group('/authors', function () use ($app) {

		/**
		*	Show all Authors
		*/
		$app->get('/', function(){
			//Get projects
			$tab = requestForAllAuthors();

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
		});

		/**
		*	Show one Author
		*/
		$app->get('/:id', function($id){
			//Get projects
			$tab = requestForAuthor($id);

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
		});

		$app->get('/:id/contribute/:stepId', function($id,$stepId){
			//Get projects
			$state = addAuthorToStep($id,$stepId);


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
				$id = createAuthor($name,$birth);

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
			//Get projects
			$tab = requestForAllTools();

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
		});

		/**
		*	Show one tool
		*/
		$app->get('/:id', function($id){
			//Get projects
			$tab = requestForTool($id);

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
		});

		/**
		*	Create a material with name, width, length and thickness
		*/
		$app->group('/create', function () use ($app) {

			//Redirections
			$app->get('/:name', function($name){
				$id = createTool($name);

				//Make a response
				$response = new Response($id);
				$response->addMessage("The data is the id of the project");

				//Send sesponse
				echo json_encode($response);
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
			//Get projects
			$tab = requestForAllMaterials();

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
		});

		/**
		*	Show one tool
		*/
		$app->get('/:id', function($id){
			//Get projects
			$tab = requestForMaterial($id);

			//Make a response
			$response = new Response($tab);

			//Send sesponse
			echo json_encode($response);
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
				$id = createMaterial($name, $width, $length, $thickness);

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
	    	$tab[$route->getPattern()] = $text;
	    }

		//Make a response
		$response = new Response($tab,404,true);
		$response->addMessage("This route dosn't exist. Please try one of them.");

		//Send sesponse
		echo json_encode($response);
	});


	

	$app->run();
