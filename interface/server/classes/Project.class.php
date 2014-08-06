<?php
/**
 * Documathon - How to make and share documentation about a project
 *
 * @author      Tatiana Grange <contact@tgrange.com>
 * @copyright   2014 Tatiana Grange
 * @link        TO DO
 * @license     http://opensource.org/licenses/MIT
 * @version     0.1
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
 * Project
 *
 * This class define a project
 *
 * @author  Tatiana Grange
 * @since   0.1
 */


class Project {
	/***************
    *  Attributes  *
    ****************/
    public $mId;
    public $mDate;
    public $mName;

    public $mSteps;
    public $mAuthors;

    /****************
    *  Constructor  *
    *****************/
	public function __construct($date, $name, $id = null){
    	$this->mId = $id;
    	$this->mName = $name;
        $this->mDate = $date;
    }


    /**************
    *  Accessors  *
    ***************/
    public function getId(){
        return $this->mId;
    }  

    public function setId($id){
    	$this->mId = $id;
    }

    public function getName(){
        return $this->mName;
    }  

    public function setName($name){
    	$this->mName = $name;
    }

    public function getDate(){
        return $this->mDate;
    }  

    public function setDate($date){
        $this->mDate = $date;
    }

    /**************
    *  Functions  *
    ***************/

	/**
	*	This function is used to return all authors who documented the project
	*/
	function requestForAuthors(){
		if($this->mAuthors == null){
            //Make request
            $this->mAuthors = array();
        }

        return $this->mAuthors;
	}

    /**
    *   This function is used to return all authors who documented the project
    */
    function requestForSteps(){
        if($this->mSteps == null){
            //Make request
            $this->mSteps = array();
        }

        return $this->mSteps;
    }
}