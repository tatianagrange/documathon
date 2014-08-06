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
    public $mId;
    public $mPath;
    public $mAuthorId;
    public $mText;
    public $mProjectId;

    public $mAuthor;


    /****************
    *  Constructor  *
    *****************/
	public function __construct($path, $projectId, $text = null, $authorId = null, $id = null){
        $this->mId = $id;
    	$this->mPath = $path;
    	$this->mAuthorId = $authorId;
        $this->mText = $text;
        $this->mProjectId = $projectId;
    }


    /**************
    *  Accessors  *
    ***************/
    public function getId(){
        return $this->mId;
    }

    public function setId($id){
        return $this->mId = $id;
    }

    public function getPath(){
        return $this->mPath;
    }  

    public function setPath($path){
    	$this->mPath = $path;
    }

    public function getAuthorId(){
        return $this->mAuthorId;
    }  

    public function setAuthorId($authorId){
    	$this->mAuthorId = $authorId;
    }

    public function getText(){
        return $this->mText;
    }  

    public function setText($text){
        $this->mText = $text;
    }

    public function getProjectId(){
        return $this->mProjectId;
    }  

    public function setProjectId($projectId){
        $this->mProjectId = $projectId;
    }


    /**************
    *  Functions  *
    ***************/

    /**
    *   This function return the object Author.
    */
    public function requestForAuthor(){
        if($this->mAuthor == null){
            //Make request
            $this->mAuthor = null;
        }

        return $this->mAuthor;
    }
}
?>