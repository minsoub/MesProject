<?php

		echo "start" . "<br>";
    $port=32769; // 27017
		$connection = new MongoClient("mongodb://cat.ks.ac.kr:32769");//"mongodb://cat.ks.ac.kr:" . $port,
		echo "conn=" . $connection . "<br>";
/*	

	try {
//	$connection = new MongoClient(); 
		$date=new MongoDate();
		$Dmaster=$connection->selectDB("cat_test_db");
		$Ccompany = $Dmaster->selectCollection("company");
		$json['stats_Dmaster']=$Dmaster->command(array('dbStats' => 1));  // for db.stats()
		$json['stats_Ccompany']=$Dmaster->command(array( 'collStats' => 'company' )); // for db.collection.stats()
		
		$new_user=array(
				"id"=>'new_user_document_mongo_id', "username" => 'aaa', "password" => 'bbb', "created" => $date
		);
	}catch (MongoConnectionException  $e) {
		$json['MongoException']['errorMessage']=$e->getMessage();
		$json['MongoException']['errorCode']=$e->getCode();
	}
	echo json_encode($json);*/
 
?>
