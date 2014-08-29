<?php

function isValidTimeStamp($timestamp)
{
    return ((string) (int) $timestamp === $timestamp) && ($timestamp <= PHP_INT_MAX)&& ($timestamp >= ~PHP_INT_MAX);
}

function isCorrect($data){
	return $data != null;
}

function listFonctionality($tab, $code){
	//Make a response
	$response = new Response($tab,$code,false);
	$response->addMessage("This is not the correct use of this route.");

	//Send sesponse
	echo json_encode($response);
}