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
 * Request
 *
 * 	This class is from the Bridge.
 * 	It is use to get informations from database
 * 	This is a singleton, to keep the last query
 *
 * @author  Tatiana Grange
 * @since   0.2
 */
class Request{
	/***************
    *  Attributes  *
    ****************/
	private $query;
	private static 	$_instance = null;

	/**************
    *  Accessors  *
    ***************/
    public function getQuery(){
    	return $this->query;
    }

    /**
    *	This function is used to get only one instance of the Singleton
    */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Request();  
		}

		return self::$_instance;
	}


	/* ****************************** */
	/*		Publics functions 		  */
	/* ****************************** */

	public function requestForAllAuthors(){
		$this->query = "SELECT * FROM Author";
		return $this->requestFor('Author');
	}

	public function requestForAllTools(){
		$this->query = "SELECT * FROM Tool";
		return $this->requestFor('Tool');
	}

	public function requestForAllMaterials(){
		$this->query = "SELECT * FROM Material";
		return $this->requestFor('Material');
	}

	public function requestForAuthor($id){
		$this->query = "SELECT * FROM Author WHERE id=$id";
		return $this->requestFor('Author');
	}

	public function requestForStep($id){
		$this->query = "SELECT * FROM Step WHERE id=$id";
		return $this->requestFor('Step');
	}

	public function requestForTool($id){
		$this->query = "SELECT * FROM Tool WHERE id=$id";
		return $this->requestFor('Tool');
	}

	public function requestForMaterial($id){
		$this->query = "SELECT * FROM Material WHERE id=$id";
		return $this->requestFor('Material');
	}

	public function requestForAllProjects(){
		$this->query = "SELECT * FROM Project";
		return $this->requestForManyProjects();
	}

	public function requestForProjectsAfter($date){
		$this->query = "SELECT * FROM Project WHERE UNIX_TIMESTAMP(date)>" . $date;
        return $this->requestForManyProjects();
	}

	public function requestForProject($id){
		$connexion = Database::getInstance()->getConnexion();

		$tab = array();
		$this->query = "SELECT * FROM Project WHERE id='" . $id ."'";
		$projects = $connexion->query($this->query);

		while($project = $projects->fetchObject('Project')) {
			Hydrate::hydrateProject($project, $this);
	    	return $project;
	  	}
	  	return null;
	}

	public function requestForAuthorsOfStep($step){
		$this->query = "SELECT id, name FROM Author JOIN Step_has_Author ON Step_has_Author.authorId=Author.id WHERE Step_has_Author.stepId='" . $step->id . "'";
		$step->authors = Hydrate::hydrateWithClass($step->authors,'Author',$this);
	}

	public function requestForToolsOfProject($project){
		$this->query = "SELECT id, name FROM Tool JOIN Tool_has_Project ON Tool_has_Project.toolId=Tool.id WHERE Tool_has_Project.projectId='" . $project->id . "'";
		$project->tools = Hydrate::hydrateWithClass($project->tools,'Tool', $this);
	}

	public function requestForMaterialsOfProject($project){
		$this->query = "SELECT id, name, width, length, thickness FROM Material JOIN Material_has_Project ON Material_has_Project.materialId=Material.id WHERE Material_has_Project.projectId='" . $project->id . "'";
		$project->materials = Hydrate::hydrateWithClass($project->materials,'Material', $this);
	}


	public function requestForStepsOfProject($project){
		$connexion = Database::getInstance()->getConnexion();

		$this->query = "SELECT * FROM Step WHERE projectId='". $project->id ."'";
		$stepsForProject = $connexion->query($this->query);

		while($step = $stepsForProject->fetchObject('Step')){
			$this->requestForAuthorsOfStep($step);
			$project->steps[] = $step;
		}
	}

	/* ****************************** */
	/*		Private functions 		  */
	/* ****************************** */
	private function requestFor($class){
		$tab = array();
		$tab = Hydrate::hydrateWithClass($tab, $class, $this);

	  	if(count($tab) == 1)
	  		return $tab[0];
	  	else if(count($tab) == 0)
	  		return null;

	  	return $tab;
	}

	private function requestForManyProjects(){

		$connexion = Database::getInstance()->getConnexion();

		$tab = array();
		$projects = $connexion->query($this->query);

		while($project = $projects->fetchObject('Project')) {
			Hydrate::hydrateProject($project,$this);
	    	$tab[] = $project;
	  	}

	  	if(count($tab) == 1)
	  		return $tab[0];
	  	else if(count($tab) == 0)
	  		return null;

	  	return $tab;
	}

}
