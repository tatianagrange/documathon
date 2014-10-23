<?php
/**
 * Documathon - How to make and share documentation about a project
 *
 * @author      Tatiana Grange <contact@tgrange.com>
 * @copyright   2014 Tatiana Grange
 * @link        TO DO
 * @license     http://opensource.org/licenses/MIT
 * @version     0.2
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */



/**
 * Save
 *
 * 	This class is from the Bridge.
 * 	It is use to save data
 * 	This is a singleton, to keep the last query
 *
 * @author  Tatiana Grange
 * @since   0.2
 */
class Save{
	/***************
    *  Attributes  *
    ****************/
	private static 	$_instance = null;
	private $query;

	/**************
    *  Accessors  *
    ***************/
    /**
    *	This function is used to get only one instance of the Singleton
    */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Save();  
		}

		return self::$_instance;
	}


	/* ****************************** */
	/*		Publics functions 		  */
	/* ****************************** */

	// The adds functions takes tow id and associated them //
	/////////////////////////////////////////////////////////

	public function addToProject($projectId, $what, $id){
		$field = $what . "Id";
		$table = ucfirst($what) . "_has_Project";
		$this->query = "INSERT INTO `$table` (`$field`, `projectId`) VALUES ($id, $projectId);";
		try{
			$this->create();
			$this->generatePDFOnSave($projectId);
		}
		catch(Exception $e){
			return $e->getCode();
		}
		return null;
	}

	public function addAuthorToStep($authorId, $stepId){
		$this->query = "INSERT INTO `Step_has_Author` (`stepId`, `authorId`) VALUES ($stepId, $authorId);";
		try{
			$this->create();
			$step = Request::getInstance()->requestForStep($stepId);
			if($step != null)
				$this->generatePDFOnSave($step->getProjectId());
		}
		catch(Exception $e){
			return $e->getCode();
		}
		return null;
	}

	// The create functions make a new entry in one of the objects tables //
	////////////////////////////////////////////////////////////////////////

	public function createAuthor($name, $birth){
		$this->query = "INSERT INTO `Author` (`name`, `birth`) VALUES ('$name', $birth);";
		return $this->create();
	}

	public function createTool($name){
		$this->query = "INSERT INTO `Tool` (`name`) VALUES ('$name');";
		return $this->create();
	}

	public function createMaterial($name, $width, $length, $thickness){
		$this->query = "INSERT INTO `Material` (`name`, `width`, `length`, `thickness`) VALUES ('$name', $width, $length, $thickness);";
		return $this->create();
	}

	public function createProject($projectName){
		//Get actual time
		$datetime = new DateTime();
		$date = date("Y-m-d H:i:s", $datetime->getTimestamp());

		//Save in base
		$this->query = "INSERT INTO Project (name, start, date) VALUES ('" . $projectName . "', '" . $date . "', '" . $date . "')";
		$connexion = Database::getInstance()->pdoExec($this->query);
		$id = $connexion->lastInsertId();

		$this->generatePDFOnSave($id);

	    return $id; 
	}

	public function createStep($projectId, $base, $text){
	    $path = Config::$IMAGE_PATH . $projectId;

	    Tools::createFolder($path);

	    //Save Step
	    $this->query = "INSERT INTO `Step` (`path`, `text`, `projectId`) VALUES ('wait path', '" . $text . "', " . $projectId . ");";
        $connexion = Database::getInstance()->pdoExec($this->query);

	    //Get id after save step
	    $id = $connexion->lastInsertId();

	    //Generate image with the id of the step
	    $image = $path . '/' . $id . '.png';
	    //$realPath = "http://images.documathon.tgrange.com/$projectId/$id.png";
	    $realPath = Config::$IMAGE_SERVER . "/$projectId/$id.png";
	    Tools::base64ToJpeg($base,$image);

	    //Update Step in base
        $this->query = "UPDATE Step SET path='" . $realPath . "' WHERE id=" . $id;
	    $connexion = Database::getInstance()->pdoExec($this->query);

	    //Update Project update field
	    $datetime = new DateTime();
		$date = date("Y-m-d H:i:s", $datetime->getTimestamp());
	    $this->query = "UPDATE Project SET date='" . $date . "' WHERE id=" . $projectId;
	    $connexion = Database::getInstance()->pdoExec($this->query);

	    $this->generatePDFOnSave($projectId);

	    return $id;

	}

	/* ****************************** */
	/*		Private functions 		  */
	/* ****************************** */
	
	// General function //
	//////////////////////
	private function create(){
		try{
			$connexion = Database::getInstance()->pdoExec($this->query);
		}
		catch(Exception $e){
			throw $e;
		}
	    return $connexion->lastInsertId(); 
	}

	private function generatePDFOnSave($projectId){
        $object = Request::getInstance()->requestForProject($projectId);
		if($object != null)
			Tools::generatePDF($object,true);
	}
}
