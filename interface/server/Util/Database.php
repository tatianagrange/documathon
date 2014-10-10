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
 * Database
 *
 * 	This class is a singleton to access to the batabase with
 *	only one connexion.
 *
 * @author  Tatiana Grange
 * @since   0.2
 */

class Database{
	/***************
    *  Attributes  *
    ****************/
	private static 	$_instance = null;
	private 		$connexion = null;

	/****************
    *  Constructor  *
    *****************/
	private function __construct() {
		$this->connexion = $this->connect();
	}

	/**************
    *  Accessors  *
    ***************/

    /**
    *	This function is used to get only one instance of the Singleton
    */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Database();  
		}

		return self::$_instance;
	}

	public function getConnexion(){
		return $this->connexion;
	}

	/**************
    *  Functions  *
    ***************/
	/**
	*	This function is used to be connected to the database
	*/
	private function connect(){
		$dns = Config::$DNS;
		$utilisateur = Config::$USER;
		$motDePasse = Config::$PASSWORD;

		try
		{
            $this->connexion = new PDO( $dns, $utilisateur, $motDePasse );
            $this->connexion->exec("SET CHARACTER SET utf8");
		    $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		}
		catch(Exception $e)
		{
	        echo 'Erreur : '.$e->getMessage().'<br />';
	        echo 'N° : '.$e->getCode();
	        die;
		}
		return $this->connexion;
	}

	/**
	*	This function is to used to make an exec on the connexion object
	*	This function make the difference between two type of mysql error
	*	1062 -> Duplicate entry
	*	1452 -> The id doesn't exist
	*/
	public function pdoExec($query){
		try { 
			$stmt = $this->connexion->prepare($query);
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

		return $this->connexion;
	}
}
