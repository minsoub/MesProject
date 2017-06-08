<?php
// Start the session
	session_start();

	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);
	$date=new MongoDate();

	$connection = new MongoClient("mongodb://localhost", 
				array("username" => $json['id0'], "password" => $json['password0']));
	$Cusers = $connection->login->selectCollection("users");
	$CuserLogs = $connection->login->selectCollection("logs");
	$cursor_company=$Cusers->findOne(
//		(object)['name' => '경성' ]		
		(object)['company_id' => $json['company_id'] ]		
	);
	if ($cursor_company){
		$json['cursor_company_exist']=$cursor_company;
		$cursor_user=$Cusers->findOne(
			(object)['company_id' => $json['company_id'] , 'users.username'=>$json['id1']  ]		
		);
		$json['cursor_user']=$cursor_user;
	
		if (!$json['cursor_user']){
			$hash = password_hash($json['password1'], PASSWORD_DEFAULT);	
			$json['hash'] = $hash;
			
			$cursor_company=$Cusers->findOne(
				(object)['company_id' => $json['company_id'] ]		
			);
			$json['cursor_company']=$cursor_company;
			$new_user_log=array(
				'company_mongo_id'=>$cursor_company['_id'],
                "company_name" => $cursor_company['name'], 'company_id' => $cursor_company['company_id'],
				'created'=>$date,
                "username" => $json['id1'],
                "logs" => [ 
                    (object)[
                        "type" => "created",
                        "date" => $date
                    ]					
                ]
			);
			$CuserLogs->insert($new_user_log);			
			$json['new_user_document_mongo_id']=$new_user_log['_id'];			
			
			$new_user=array(
				"_id"=>$json['new_user_document_mongo_id'], "username" => $json['id1'], "password" => $hash,
				"created" => $date
			);
			
			$Cusers->update(
				(object)['company_id' => $json['company_id'] ],
				(object)[ '$push' => (object)['users'=>$new_user] ]					
			);
			
		}else $json['user_exist']=$json['id1'];
	}else  $json['cursor_company_not_exist']=$cursor_company;

	echo json_encode($json);

?>
