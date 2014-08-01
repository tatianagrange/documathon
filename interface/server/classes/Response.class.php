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
 * Response
 *
 * This class is use to return an object in the output of the api
 *
 * @author  Tatiana Grange
 * @since   0.1
 */
class Response {

    public $datas;
    public $status;
    public $error;
    public $msg;

	public function __construct($mDatas, $mStatus = 200, $mError = false){
    	$this->datas = $mDatas;
    	$this->status = $mStatus;
    	$this->error = $mError;
    	if($mError){
    		$this->msg = "ERROR";
    	}
    	else{
    		$this->msg = "SUCCES";
    	}
    }

    public function getDatas(){
        return $this->datas;
    }

    public function getDatasAt($integer){
    	if(is_array($this->datas))
        	return $this->datas[$integer];
        return null;
    }

    public function setArray($mDatas){
    	$this->datas = $mDatas;
    }

    public function setArrayAt($integer, $with){
    	if(is_array($this->datas))
    		$this->datas[$integer] = $with;
    }

    public function getStatus(){
    	return $this->status;
    }

    public function setStatus($mStatus){
    	$this->status = $mStatus;
    }

    public function getError(){
    	return $this->error;
    }

    public function setError($mError){
    	$this->error = $mError;
    }

    public function addMessage($mMessage){

    	$this->msg = $this->msg . " | " . $mMessage;
    }
}
?>