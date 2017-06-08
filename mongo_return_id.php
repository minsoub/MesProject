<?php
	$connection = new MongoClient();

	$json=json_decode('{}');

	$_id = new MongoId(); 
	$json['_id']=$_id;
	echo json_encode($json);
 ?> 