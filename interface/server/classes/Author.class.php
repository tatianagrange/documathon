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
 * Author
 *
 * This class define an author like it can use on the Server
 *
 * @author  Tatiana Grange
 * @since   0.1
 */
class Author {
	/***************
    *  Attributes  *
    ****************/
    public $id;
    public $name;
    public $birth;

    /****************
    *  Constructor  *
    *****************/
	public function __construct(){
    	$this->id = intval($this->id);
    	
        if($this->birth != null){
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, $this->birth);
            $this->birth = $date->getTimestamp();
        }
    }


    /**************
    *  Accessors  *
    ***************/
    public function getId(){
        return $this->id;
    }  

    public function setId($id){
    	$this->id = $id;
    }

    public function getName(){
        return $this->name;
    }  

    public function setName($name){
    	$this->name = $name;
    }

    public function getBirth(){
        return $this->birth;
    }  

    public function setBirth($birth){
        $this->birth = $birth;
    }

    /**************
    *  Functions  *
    ***************/

    /**
    *   This function return the object Author.
    */
    function getAge(){
    	if($this->birth == null)
    		return null;

		$t = time();
		$age = ($this->birth < 0) ? ( $t + ($this->birth * -1) ) : $t - $this->birth;
		return floor($age/31536000);
	}


    public function createHTML(){
        $html = "<p>" . utf8_encode($this->name);
        if($this->birth != null)
            $html .= " - " . $this->getAge();
        $html .= "</p>";
        return $html;
    }
}
