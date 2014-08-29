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
 * Material
 *
 * This class define a material like it can use on the Server
 *
 * @author  Tatiana Grange
 * @since   0.2
 */
class Material {
	/***************
    *  Attributes  *
    ****************/
    public $id;
    public $name;
    public $width;
    public $length;
    public $thickness;

    /****************
    *  Constructor  *
    *****************/
	public function __construct(){
    	$this->id = intval($this->id);
    	$this->width = floatval($this->width);
    	$this->length = floatval($this->length);
    	$this->thickness = floatval($this->thickness);
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

    public function getWidth(){
        return $this->width;
    }  

    public function setWidth($width){
        $this->width = $width;
    }

    public function getLength(){
        return $this->length;
    }  

    public function setLength($length){
        $this->length = $length;
    }

    public function getThickness(){
        return $this->thickness;
    }  

    public function setThickness($thickness){
        $this->thickness = $thickness;
    }

    /**************
    *  Functions  *
    ***************/

	/**
	*	This function is used to return all project with the participation of the author
	*/
	function requestForProjects(){
		return array();
	}

	
}