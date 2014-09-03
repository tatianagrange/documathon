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
    public $id;
    public $date;           // Date is the date of the last change
    public $name;

    public $steps;

    // @since 0.2
    public $start;          // And Start is the date where the project is register
    public $materials;
    public $tools;
    public $lang;

    /****************
    *  Constructor  *
    *****************/
	public function __construct(){
        //Cast values
    	$this->id = intval($this->id);
        $this->date = $this->datetimeStringToTimestamp($this->date);
        $this->start = $this->datetimeStringToTimestamp($this->start);
        $this->steps = array();
        $this->materials = array();
        $this->tools = array();
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

    public function getDate(){
        return $this->date;
    }  

    public function setDate($date){
        $this->date = $date;
    }

    public function getStart(){
        return $this->start;
    }  

    public function setBirth($start){
        $this->start = $start;
    }

    public function getLang(){
        return $this->lang;
    }

    public function setLang($lg){
        $this->lang = $lg;
    }

    /**********************
    *  Private Functions  *
    ***********************/

    /**
    *   
    */
    private function datetimeStringToTimestamp($datetime){
        $format = 'Y-m-d H:i:s';
        $date = DateTime::createFromFormat($format, $datetime);
        return $date->getTimestamp();
    }

}