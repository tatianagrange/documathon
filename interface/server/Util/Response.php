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
 * Response
 *
 * This class is use to return an object in the output of the api
 *
 * @author  Tatiana Grange
 * @since   0.1
 */
class Response {

    /***************
    *  Attributes  *
    ****************/
    public $datas;
    public $status;
    public $error;
    public $msg;


    /****************
    *  Constructor  *
    *****************/
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

    /**************
    *  Accessors  *
    ***************/
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

    public function toSuccess(){
        $this->setStatus(200);
        $this->setError(false);
        $this->msg = "SUCCES";
    }

    public function toError($error = 404){
        $this->setStatus($error);
        $this->setError(false);
        $this->msg = "ERROR";
    }


    /**************
    *  Functions  *
    ***************/
    public function getForId($id, $function){
        $id = htmlentities($id);
        $this->toError();
            
        if(!Errors::checkIfIsInt(array($id), $this))
            return;

        $object = Errors::getObjectForId($id, Request::getInstance()->$function($id), $this);

        if($object){
            $this->toSuccess();
            return $object;
        }

        return null;

    }

    public function makeResponseForGetId($id, $function, $isCreation = false){
        $id = htmlentities($id);
        $this->toError();
            
        if(!$isCreation &&!Errors::checkIfIsInt(array($id), $this))
            return;

        if($isCreation){
            $object = Errors::getObjectForId($id, Save::getInstance()->$function($id), $this);
        }
        else{
            $object = Errors::getObjectForId($id, Request::getInstance()->$function($id), $this);
        }

        if($object){
            $this->toSuccess();
            $this->setArray($object);
            echo json_encode($this);
        }
    }

    public function makeResponseForAdd($method, $what, $projectId, $id= null, $base = null, $text = null){
        $this->toError(4210);

        $projectId = htmlentities($projectId);
        $what = htmlentities($what);
        $id = htmlentities($id);

        if(!Errors::checkIfIsInt($id == null ? array($projectId) : array($projectId, $id), $this))
            return;

        switch($what){
            case 'step':
                $text = htmlentities($text);
                $this->makeResponseForCreateStep($method, $base, $text, $projectId);
                break;
            case 'tool':
            case 'material':
                $this->makeResponseForAddToProject($projectId,$what,$id, $method);
                break;
            default:
                $this->toError(4206);
                $this->addMessage("This action doesn't exist.");
                break;
        }

        echo json_encode($this);
    }

    public function makeResponseForAddToProject($projectId, $what, $id, $method){
        switch($method){
            case "GET":
                $state = Save::getInstance()->addToProject($projectId, $what, $id);
                if($state != null){
                    $this->toError($state);
                    $this->addMessage(($state == 4208) ? "The id $id is already associated to the project $projectId" : "This id doesn't exist");
                }
                else{
                    $this->toSuccess();
                    $this->addMessage("The $what have been had");
                }
                break;
            case "POST":
                $this->toError(4209);
                $this->addMessage("The action $what is a GET request");
                break;
        }
    }

    public function makeResponseForCreateStep($method, $base = null, $text = null, $projectId = null){
        switch($method){
            case "GET":
                $this->toError(4207);
                $this->addMessage("The action step have to be posted with 'base64' parameter");
                break;
            case "POST":
                if($base == null){
                    $this->toError(4207);
                    $this->addMessage("The action step have to be posted with 'base64' parameter");
                }else{
                    if($text == null)
                        $text = "";
                    $this->toSuccess();
                    $this->datas = Save::getInstance()->createStep($projectId, $base, $text);
                    $this->addMessage("The data is the id of the step");
                }
                break;
        }
    }

}
?>
