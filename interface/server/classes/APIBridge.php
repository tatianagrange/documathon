<?php

require_once('conf/connection.php');

function connect(){
	// Connection au serveur
	$dns = 'mysql:host=localhost;dbname=documathon';
	$utilisateur = 'root';
	$motDePasse = 'root';
	$connection = new PDO( $dns, $utilisateur, $motDePasse );
	return $connection;
}

function getAllProjects(){
	$con = connect();
	var_dump($con);
}