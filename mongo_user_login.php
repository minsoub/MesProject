<?php
// Start the session
	session_start();

	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);
	$json['log']['date']=new MongoDate();

	$connection = new MongoClient("mongodb://localhost", 
				array("username" => 'admin', "password" => 'mongotest'));
	$Cusers = $connection->login->selectCollection("users");
	$CuserLogs = $connection->login->selectCollection("logs");
	
	$cursor_company=$Cusers->findOne(
		(object)['company_id' => $json['company_id'] ]		
	);
	if ($cursor_company){
		$json['cursor_company_exist']=$cursor_company;
		// x=db.users.findOne({'company_id':'abcd', "users.username":"abc"},{_id:1, 'users':{$elemMatch:{'username':'abc'}}});
		//print(x.users[0].password);
		$cursor_user=$Cusers->findOne(
			(object)['company_id' => $json['company_id'] , 'users.username'=>$json['username']  ]	,
			(object)['_id'=>1, 'users'=>(object)['$elemMatch' => (object)['username'=>$json['username']] ] ]
		);
		$json['cursor_user']=$cursor_user;
	
		if ($json['cursor_user']){
			if (password_verify($json['password'], $cursor_user['users'][0]['password'])){
				$json['is_login_success']=true;
				$_SESSION['mongo_company__id']=$cursor_user['_id'];
				$json['mongo_company__id']=$cursor_user['_id'];
				$_SESSION['mongo_user__id']=$cursor_user['users'][0]['_id'];
				$json['mongo_user__id']=$cursor_user['users'][0]['_id'];
				$_SESSION['company_id']=$json['company_id'];
				$_SESSION['username']=$json['username'];
				$userLog_mongo_id=$cursor_user['users'][0]['_id'];
				//db.users.update(  {'company_id':'abcd', "users.username":"abc"},  {$push: {'users.$.logs':{'type':'login'}}} );
				$CuserLogs->update(
					(object)['_id' => $userLog_mongo_id  ]	,
					(object)['$push'=>(object)['logs' => $json['log']] ] 
				);
			}else $json['is_login_success']=false;
		}else $json['user_not_exist']=true;
	}else  $json['cursor_company_not_exist']=$cursor_company;

	echo json_encode($json);

?>
