<?php

class Database{
	/* ****************************** */
	/*		Connexion function 		  */
	/* ****************************** */
	public static function connect(){
		$dns = Config::$DNS;
		$utilisateur = Config::$USER;
		$motDePasse = Config::$PASSWORD;

		$connexion = null;
		try
		{
		    $connexion = new PDO( $dns, $utilisateur, $motDePasse );
		    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		}
		catch(Exception $e)
		{
	        echo 'Erreur : '.$e->getMessage().'<br />';
	        echo 'N° : '.$e->getCode();
	        die;
		}
		return $connexion;
	}

	public static function pdoExec($query, $connexion = null){
		if($connexion == null)
			$connexion = Database::connect();

		try { 
			$stmt = $connexion->prepare($query);
			$stmt->execute();
		}
		catch (PDOException $e) { 
		    if ($e->getCode() == '23000') {
		    	//Switch on driver error. Here, Mysql
		    	switch($e->errorInfo[1]){
		    		case 1062:
		    			$code = 4208;
		    			break;
		    		case 1452:
		    			$code = 4202;
		    			break;
		    		default:
		    			$code = 4299;
		    			break;
		    	}
		    	throw new Exception($e->getMessage(), $code);
		        
		    }
		} 

		return $connexion;
	}
}


class Request{
	/* ****************************** */
	/*		Request functions 		  */
	/* ****************************** */


	//Shortcut
	public static function requestForAllAuthors($connexion = null){
		return Request::requestFor("SELECT * FROM Author", 'Author', $connexion);
	}

	public static function requestForAllTools($connexion = null){
		return Request::requestFor("SELECT * FROM Tool", 'Tool', $connexion);
	}

	public static function requestForAllMaterials($connexion = null){
		return Request::requestFor("SELECT * FROM Material", 'Material', $connexion);
	}

	public static function requestForAuthor($id = null, $connexion = null){
		return Request::requestFor("SELECT * FROM Author WHERE id=$id", 'Author', $connexion);
	}

	public static function requestForTool($id = null, $connexion = null){
		return Request::requestFor("SELECT * FROM Tool WHERE id=$id", 'Tool', $connexion);
	}

	public static function requestForMaterial($id = null, $connexion = null){
		return Request::requestFor("SELECT * FROM Material WHERE id=$id", 'Material', $connexion);
	}

	//Real generic function
	public static function requestFor($query, $class, $connexion = null){
		$tab = array();
		$tab = Request::hydrate($tab, $query, $class, $connexion);

	  	if(count($tab) == 1)
	  		return $tab[0];
	  	else if(count($tab) == 0)
	  		return null;

	  	return $tab;
	}

	/* ************************************** */
	/*		Request functions for step		  */
	/* ************************************** */

	/**
	*	This function is used to associate the authors of a step to the object step pass in parameters
	*/
	public static function requestForAuthorsOfStep($step, $connexion = null){
		$step->authors = Request::hydrate(
			$step->authors,
			"SELECT id, name FROM Author JOIN Step_has_Author ON Step_has_Author.authorId=Author.id WHERE Step_has_Author.stepId='" . $step->id . "'",
			'Author',
			$connexion);
	}


	/* ****************************************** */
	/*		Request functions for project		  */
	/*		-------------------------------		  */
	/*		A project need other methods 		  */
	/*		of finding than the others 			  */
	/*		above. It is because a Project		  */
	/*		has many differents object to 		  */
	/*		be complete 						  */
	/* ****************************************** */

	//Shortcuts
	public static function requestForAllProjects($connexion = null){
		return Request::requestForManyProjects("SELECT * FROM Project", $connexion);
	}

	public static function requestForProjectsAfter($date, $connexion = null){
		return Request::requestForManyProjects("SELECT * FROM Project WHERE UNIX_TIMESTAMP(date)>" . $date, $connexion);
	}

	//Real request for many project
	public static function requestForManyProjects($query, $connexion = null){
		if($connexion == null)
			$connexion = Database::connect();

		$tab = array();
		$projects = $connexion->query($query);

		while($project = $projects->fetchObject('Project')) {
			Request::hydrateProject($project, $connexion);
	    	$tab[] = $project;
	  	}

	  	if(count($tab) == 1)
	  		return $tab[0];
	  	else if(count($tab) == 0)
	  		return null;

	  	return $tab;
	}

	/**
	*	This function return only the project for the id pass in argument
	*/
	public static function requestForProject($id = null, $connexion = null){
		if($connexion == null)
			$connexion = Database::connect();

		$tab = array();
		$projects = $connexion->query("SELECT * FROM Project WHERE id='" . $id ."'");

		while($project = $projects->fetchObject('Project')) {
			Request::hydrateProject($project, $connexion);
	    	return $project;
	  	}
	  	return null;
	}


	//Request for childs of project
	private static function requestForStepsOfProject($project, $connexion = null){
		if($connexion == null)
			$connexion = Database::connect();

		$stepsForProject = $connexion->query("SELECT * FROM Step WHERE projectId='". $project->id ."'");
		while($step = $stepsForProject->fetchObject('Step')){
			Request::requestForAuthorsOfStep($step,$connexion);
			$project->steps[] = $step;
		}
	}

	private static function requestForToolsOfProject($project, $connexion = null){
		$project->tools = Request::hydrate(
			$project->tools, 
			"SELECT id, name FROM Tool JOIN Tool_has_Project ON Tool_has_Project.toolId=Tool.id WHERE Tool_has_Project.projectId='" . $project->id . "'",
			'Tool',
			$connexion);
	}

	private static function requestForMaterialsOfProject($project, $connexion = null){
		$project->materials = Request::hydrate(
			$project->materials,
			"SELECT id, name, width, length, thickness FROM Material JOIN Material_has_Project ON Material_has_Project.materialId=Material.id WHERE Material_has_Project.projectId='" . $project->id . "'",
			'Material',
			$connexion);
	}




	/* ************************** */
	/*		Save functions 		  */
	/* ************************** */

	public static function addToProject($projectId, $what, $id, $connexion = null){
		$field = $what . "Id";
		$table = ucfirst($what) . "_has_Project";
		$query = "INSERT INTO `$table` (`$field`, `projectId`) VALUES ($id, $projectId);";
		try{
			Request::create($query, $connexion);
		}
		catch(Exception $e){
			return $e->getCode();
		}
		return null;
	}

	public static function addAuthorToStep($authorId, $stepId, $connexion = null){
		$query = "INSERT INTO `Step_has_Author` (`stepId`, `authorId`) VALUES ($stepId, $authorId);";
		try{
			Request::create($query, $connexion);
		}
		catch(Exception $e){
			return $e->getCode();
		}
		return null;
	}

	public static function createAuthor($name, $birth, $connexion = null){
		$query = "INSERT INTO `Author` (`name`, `birth`) VALUES ('$name', $birth);";
		return Request::create($query, $connexion);
	}

	public static function createTool($name, $connexion = null){
		$query = "INSERT INTO `Tool` (`name`) VALUES ('$name');";
		return Request::create($query, $connexion);
	}

	public static function createMaterial($name, $width, $length, $thickness, $connexion = null){
		$query = "INSERT INTO `Material` (`name`, `width`, `length`, `thickness`) VALUES ('$name', $width, $length, $thickness);";
		return Request::create($query, $connexion);
	}

	private static function create($query, $connexion = null){
		try{
			$connexion = Database::pdoExec($query,$connexion);
		}
		catch(Exception $e){
			throw $e;
		}
	    return $connexion->lastInsertId(); 
	}


	public static function createProject($projectName, $connexion = null){
		//Get actual time
		$datetime = new DateTime();
		$date = date("Y-m-d H:i:s", $datetime->getTimestamp());

		//Save in base
		$query = "INSERT INTO Project (name, start, date) VALUES ('" . $projectName . "', '" . $date . "', '" . $date . "')";
		$connexion = Database::pdoExec($query,$connexion);
	    return $connexion->lastInsertId(); 
	}

	public static function createStep($projectId, $base, $text, $connexion = null){
	    //$path = '/home/tatiana/www/images/'.$projectId;
	    $path = Config::$IMAGE_PATH . $projectId;

	    if (!file_exists($path)) {
	        try{
	            mkdir($path, 0775, true);
	        }catch(Exception $e){
	            var_dump($e);
	            die;
	        }
	    }

	    //Save Step
	    $query = "INSERT INTO `Step` (`path`, `text`, `projectId`) VALUES ('wait path', '" . $text . "', " . $projectId . ");";
	   	$connexion = Database::pdoExec($query, $connexion);

	    //Get id after save step
	    $id = $connexion->lastInsertId();

	    //Generate image with the id of the step
	    $image = $path . '/' . $id . '.png';
	    //$realPath = "http://images.documathon.tgrange.com/$projectId/$id.png";
	    $realPath = Config::$IMAGE_SERVER . "/$projectId/$id.png";
	    Tools::base64ToJpeg($base,$image);

	    //Update Step in base
	    $query = "UPDATE Step SET path='" . $realPath . "' WHERE id=" . $id;
	    $connexion = Database::pdoExec($query, $connexion);

	    return $id;

	}


	/* ****************************** */
	/*		Hydrate functions 		  */
	/* ****************************** */

	private static function hydrateProject($project, $connexion){
		if($connexion == null)
			$connexion = Database::connect();

		Request::requestForStepsOfProject($project,$connexion);
		Request::requestForMaterialsOfProject($project,$connexion);
		Request::requestForToolsOfProject($project,$connexion);
	}

	private static function hydrate($objectTab, $query, $class, $connexion){
		if($connexion == null)
			$connexion = Database::connect();

		$tabResult = $connexion->query($query);
		while($obj = $tabResult->fetchObject($class)){
			$objectTab[] = $obj;
		}

		return $objectTab;
	}
}