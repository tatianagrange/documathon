<?php

class Errors
{
	public static function checkIfIsInt($tab, $response)
	{
		foreach($tab as $toCheck){
			if(!Tools::isInteger($toCheck)){
				$response->setError(4210);
				$response->setStatus(false);
				$response->setArray(null);
				$response->addMessage("$toCheck is not a int. Please use int value");
				echo json_encode($response);
				return false;
			}
		}
		return true;
	}

	public static function getObjectForId($id, $object, $response){
		if($object != null){
			return $object;
		}
		$response->setError(4202);
		$response->setStatus(true);
		$response->setArray(null);
		$response->addMessage("This id $id doesn't exist");
		echo json_encode($response);
		return null;
		
	}
}