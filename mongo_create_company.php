<?php
// Start the session
	session_start();

	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);
    $port=32769; // 27017

	try {
//	$connection = new MongoClient(); 
		$connection = new MongoClient("mongodb://cat.ks.ac.kr:" . $port,
					array("username" => $json['mongo_admin_id'], "password" => $json['mongo_admin_password']));
	//				array("username" => "admin", "password" => "mongotest"));
		$json['stats_Dmaster']=$connection;
		$Dmaster=$connection->selectDB("master");
		$Ccompany = $Dmaster->selectCollection("company");
		$Cuser = $Dmaster->selectCollection("user");
		$json['stats_Dmaster']=$Dmaster->command(array('dbStats' => 1));  // for db.stats()
		$json['stats_Ccompany']=$Dmaster->command(array( 'collStats' => 'company' )); // for db.collection.stats()
		$json['stats_Cuser']=$Dmaster->command(array( 'collStats' => 'user' ));
		
		$cursor_company=$Ccompany->findOne(
			(object)['c_id' => $json['c_id'] ]		
		);
		if (!$cursor_company){
			$cursor_user=$Cuser->findOne(
				(object)['username' => $json['c_admin_id'] ]		
			);
			if (!$cursor_user){
				create_admin_user($Ccompany, $Cuser, $json);
				
				$db_name=$json['c_id'] . "_db";
				$Dcompany=$connection->selectDB($db_name);
				//create_init_project($Dcompany, $Ccompany, $Cuser, $json);
			}else{
				$json['cursor_username_exist']=$cursor_user;
			}
		}else{
			$json['cursor_company_exist']=$cursor_company;
		}
	}catch (MongoConnectionException  $e) {
		$json['MongoException']['errorMessage']=$e->getMessage();
		$json['MongoException']['errorCode']=$e->getCode();
	}
	echo json_encode($json);
	
	function create_admin_user($Ccompany, $Cuser, &$json){
		$new_company=array(
			"name" => $json['c_name'],
			"company_id" => $json['c_id'],
			"db_name" => $json['c_id'] . "db",
			"users" =>[],
			"project" =>[]
		);
		try{
			$Ccompany->insert($new_company);			
			$json['new_company_mongo_id']=$new_company['_id'];			
			$json['log']['date']=new MongoDate();
			$new_user=array(
				"company_mongo_id"=>$new_company['_id'],
				"company_id" => $json['c_id'],			
				"username"=> $json['c_admin_id'],
				//"password"=> password_hash($json['c_admin_password'], PASSWORD_DEFAULT),
				"is_admin" => true,
				"created" => $json['log']['date'],
				"logs" => []
			);			
			$Cuser->insert($new_user);			
			$json['new_user_mongo_id']=$new_user['_id'];			

			$filter = array('_id'=>$new_company['_id']);
			$update = array('$push'=>array('users'=>
					(object)[
							$new_user['_id'], 
							"username"=> $json['c_admin_id'],
							"password"=> password_hash($json['c_admin_password'], PASSWORD_DEFAULT),
							"is_admin" => true
					]
			));
			$Ccompany->update($filter,$update);
			$json['new_company']=$Ccompany->findOne((object)['company_id' => $json['c_id'] ]);
			$json['new_user']=$Cuser->findOne((object)[ "username"=> $json['c_admin_id'] ]);
		}catch (Exception $e) {
			$json['MongoException']['errorMessage']=$e->getMessage();
			$json['MongoException']['errorCode']=$e->getCode();
		}
	}
	
	function create_init_project($Dcompany, $Ccompany, $Cuser, &$json){
		$Cproject = $Dcompany->selectCollection("project");
		$Cmaterial = $Dcompany->selectCollection("material");
		$new_material=array(
			"io_logs" =>[
				(object)[ "type"=>"created", "user"=>$json['c_admin_id'], "date"=>$json['log']['date'], "quantity" => 0]
			],
			"from" =>[],
			"to" =>[]
		);
		try{
			$Cmaterial->insert($new_material);			
			$json['new_material_mongo_id']=$new_material['_id'];			
			
			$category_mongo_id= new MongoId(); 
			$new_project=array(
				"company_mongo_id" => $json['new_company_mongo_id'],
				"project_name" => $json['c_first_project'],
				"BOM_tree" =>[
					(object)[  
						"category_mongo_id" =>  $category_mongo_id, 
						"c_id" => "b0", "name" => "PC",
						"state" => "expanded", "created" => $json['log']['date'],              
						"materials" => [ 
							(object)[ "_id" => $json['new_material_mongo_id'], 
								"m_id" => "a1001", "name" => "CPU", "unit" => "EA","spec" => "",
								"state" => "expanded", "created" =>$json['log']['date'], "inventory" => 0,
								"logs" => []
							]
						]
					]
				],
				"process_tree" =>[],
				"worker_tree" =>[]
			);
			$Cproject->insert($new_project);			
			$json['new_project']=$new_project;			
			$json['new_material']=$new_material;			

			$filter = array('_id'=>$json['new_company_mongo_id']);
			$update = array('$push'=>array('project'=>$new_project['_id']));
			$Ccompany->update($filter,$update);

			$filter = array('_id'=>$json['new_user_mongo_id']);
			$update = array('$push'=>
							array('logs'=>
								(object)['type'=>'project_created', 'date'=>$json['log']['date'], 
										'new_project_mongo_id'=>$new_project['_id']	]));
			$Cuser->update($filter,$update);
		}catch (Exception $e) {
			$json['MongoException']['errorMessage']=$e->getMessage();
			$json['MongoException']['errorCode']=$e->getCode();
		}

	}
 
?>
