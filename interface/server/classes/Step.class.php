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
 * Step
 *
 * A project is made of many Step, that are define like that
 *
 * @author  Tatiana Grange
 * @since   0.1
 */
class Step {

    /***************
    *  Attributes  *
    ****************/
    public $id;
    public $path;
    public $text;
    public $projectId;

    public $authors;


    /****************
    *  Constructor  *
    *****************/
	public function __construct(){
        //Cast values
        $this->id = intval($this->id);
        $this->projectId = intval($this->projectId);
        $this->authors = array();
    }


    /**************
    *  Accessors  *
    ***************/
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        return $this->id = $id;
    }

    public function getPath(){
        return $this->path;
    }  

    public function setPath($path){
    	$this->path = $path;
    }

    public function getText(){
        return $this->text;
    }  

    public function setText($text){
        $this->text = $text;
    }

    public function getProjectId(){
        return $this->projectId;
    }  

    public function setProjectId($projectId){
        $this->projectId = $projectId;
    }

    public function createHTML(){
        $html = "<img src='$this->path' height='300' width='300'>";
        if($this->text != null){
            $tmp = utf8_encode($this->text);
            $html .= "<p>$tmp</p>";
        }
        return $html;
    }
}
?>
