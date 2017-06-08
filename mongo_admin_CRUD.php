<?php
	session_start();

	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);
	try {
		$connection = new MongoClient();
		$Dmaster=$connection->selectDB("master");
		$Ccompany = $Dmaster->selectCollection("company");
		$Cuser = $Dmaster->selectCollection("user");

		$json['log']['date']=new MongoDate();
		//$mongo_l_id=new MongoId($json['mongo_l_id']);

		switch($json['CRUD']){
			case 'login' :
				$cursor=$Ccompany->findOne(
					(object)['company_id' => $json['company_id']		
				);
				$user=$cursor->findOne((object)['users.username'=> $json['admin_id']);
				$json['level0']=$cursor;
				break;
		}
	}catch (MongoConnectionException  $e) {
		$json['MongoException']['errorMessage']=$e->getMessage();
		$json['MongoException']['errorCode']=$e->getCode();
	}
	echo json_encode($json);

 ?> 
    
    
    
    

    
        

    
    
    
    
    
    
    
    
    