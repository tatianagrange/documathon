<?php


class Request{
	/* ****************************** */
	/*		Request functions 		  */
	/* ****************************** */


	//Shortcut
	public static function requestForAllAuthors(){
		return Request::requestFor("SELECT * FROM Author", 'Author');
	}

	public static function requestForAllTools(){
		return Request::requestFor("SELECT * FROM Tool", 'Tool');
	}

	public static function requestForAllMaterials(){
		return Request::requestFor("SELECT * FROM Material", 'Material');
	}

	public static function requestForAuthor($id){
		return Request::requestFor("SELECT * FROM Author WHERE id=$id", 'Author');
	}

	public static function requestForTool($id){
		return Request::requestFor("SELECT * FROM Tool WHERE id=$id", 'Tool');
	}

	public static function requestForMaterial($id){
		return Request::requestFor("SELECT * FROM Material WHERE id=$id", 'Material');
	}

	//Real generic function
	public static function requestFor($query, $class){
		$tab = array();
		$tab = Request::hydrate($tab, $query, $class);

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
	public static function requestForAuthorsOfStep($step){
		$step->authors = Request::hydrate(
			$step->authors,
			"SELECT id, name FROM Author JOIN Step_has_Author ON Step_has_Author.authorId=Author.id WHERE Step_has_Author.stepId='" . $step->id . "'",
			'Author');
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
	public static function requestForAllProjects(){
		return Request::requestForManyProjects("SELECT * FROM Project");
	}

	public static function requestForProjectsAfter($date){
		return Request::requestForManyProjects("SELECT * FROM Project WHERE UNIX_TIMESTAMP(date)>" . $date);
	}

	//Real request for many project
	public static function requestForManyProjects($query){

		$connexion = Database::getInstance()->getConnexion();

		$tab = array();
		$projects = $connexion->query($query);

		while($project = $projects->fetchObject('Project')) {
			Request::hydrateProject($project);
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
	public static function requestForProject(){
		$connexion = Database::getInstance()->getConnexion();

		$tab = array();
		$projects = $connexion->query("SELECT * FROM Project WHERE id='" . $id ."'");

		while($project = $projects->fetchObject('Project')) {
			Request::hydrateProject($project);
	    	return $project;
	  	}
	  	return null;
	}


	//Request for childs of project
	private static function requestForStepsOfProject($project){
		$connexion = Database::getInstance()->getConnexion();

		$stepsForProject = $connexion->query("SELECT * FROM Step WHERE projectId='". $project->id ."'");
		while($step = $stepsForProject->fetchObject('Step')){
			Request::requestForAuthorsOfStep($step);
			$project->steps[] = $step;
		}
	}

	private static function requestForToolsOfProject($project){
		$project->tools = Request::hydrate(
			$project->tools, 
			"SELECT id, name FROM Tool JOIN Tool_has_Project ON Tool_has_Project.toolId=Tool.id WHERE Tool_has_Project.projectId='" . $project->id . "'",
			'Tool');
	}

	private static function requestForMaterialsOfProject($project){
		$project->materials = Request::hydrate(
			$project->materials,
			"SELECT id, name, width, length, thickness FROM Material JOIN Material_has_Project ON Material_has_Project.materialId=Material.id WHERE Material_has_Project.projectId='" . $project->id . "'",
			'Material');
	}




	/* ************************** */
	/*		Save functions 		  */
	/* ************************** */

	public static function addToProject($projectId, $what, $id){
		$field = $what . "Id";
		$table = ucfirst($what) . "_has_Project";
		$query = "INSERT INTO `$table` (`$field`, `projectId`) VALUES ($id, $projectId);";
		try{
			Request::create($query);
		}
		catch(Exception $e){
			return $e->getCode();
		}
		return null;
	}

	public static function addAuthorToStep($authorId, $stepId){
		$query = "INSERT INTO `Step_has_Author` (`stepId`, `authorId`) VALUES ($stepId, $authorId);";
		try{
			Request::create($query);
		}
		catch(Exception $e){
			return $e->getCode();
		}
		return null;
	}

	public static function createAuthor($name, $birth){
		$query = "INSERT INTO `Author` (`name`, `birth`) VALUES ('$name', $birth);";
		return Request::create($query);
	}

	public static function createTool($name){
		$query = "INSERT INTO `Tool` (`name`) VALUES ('$name');";
		return Request::create($query);
	}

	public static function createMaterial($name, $width, $length, $thickness){
		$query = "INSERT INTO `Material` (`name`, `width`, `length`, `thickness`) VALUES ('$name', $width, $length, $thickness);";
		return Request::create($query);
	}

	private static function create($query){
		try{
			$connexion = Database::getInstance()->pdoExec($query);
		}
		catch(Exception $e){
			throw $e;
		}
	    return $connexion->lastInsertId(); 
	}


	public static function createProject($projectName){
		//Get actual time
		$datetime = new DateTime();
		$date = date("Y-m-d H:i:s", $datetime->getTimestamp());

		//Save in base
		$query = "INSERT INTO Project (name, start, date) VALUES ('" . $projectName . "', '" . $date . "', '" . $date . "')";
		$connexion = Database::getInstance()->pdoExec($query);
	    return $connexion->lastInsertId(); 
	}

	public static function createStep($projectId, $base, $text){
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
	   	$connexion = Database::getInstance()->pdoExec($query);

	    //Get id after save step
	    $id = $connexion->lastInsertId();

	    //Generate image with the id of the step
	    $image = $path . '/' . $id . '.png';
	    //$realPath = "http://images.documathon.tgrange.com/$projectId/$id.png";
	    $realPath = Config::$IMAGE_SERVER . "/$projectId/$id.png";
	    Tools::base64ToJpeg($base,$image);

	    //Update Step in base
	    $query = "UPDATE Step SET path='" . $realPath . "' WHERE id=" . $id;
	    $connexion = Database::getInstance()->pdoExec($query);

	    return $id;

	}


	/* ****************************** */
	/*		Hydrate functions 		  */
	/* ****************************** */

	private static function hydrateProject($project){
		Request::requestForStepsOfProject($project);
		Request::requestForMaterialsOfProject($project);
		Request::requestForToolsOfProject($project);
	}

	private static function hydrate($objectTab, $query, $class){
		$connexion = Database::getInstance()->getConnexion();

		$tabResult = $connexion->query($query);
		while($obj = $tabResult->fetchObject($class)){
			$objectTab[] = $obj;
		}

		return $objectTab;
	}
}