<?php

class Tools
{

	public static function isValidTimeStamp($timestamp)
	{
	    return ((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX)&& ($timestamp >= ~PHP_INT_MAX);
	}

	public static function isCorrect($data){
		return $data != null;
	}

	public static function listFonctionality($tab, $code){
		//Make a response
		$response = new Response($tab,$code,false);
		$response->addMessage("This is not the correct use of this route.");

		//Send sesponse
		echo json_encode($response);
	}

	public static function base64ToJpeg($base64, $file) {
		file_put_contents($file, base64_decode($base64));
	}

}