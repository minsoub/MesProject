<?php
//https://www.sitepoint.com/mongodb-indexing-1/
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");*/
	session_start();

	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);
	$json['log']['company_id']=$_SESSION['company_id'];
	$json['log']['username']=$_SESSION['username'];
//	$mongo_company__id=new MongoId($_SESSION['mongo_company__id']);
//	$mongo_user__id=new MongoId($_SESSION['mongo_user__id']);
    
//	$connection = new MongoClient();
	$connection = new MongoClient("mongodb://localhost", 
				array("username" => "admin", "password" => "mongotest"));
    //$Csetup = $connection->BOM->setup;
//    $Cmaster = $connection->BOM->master;
  //  $Ctransaction = $connection->BOM->transaction;
	$Csetup = $connection->BOM->selectCollection("setup");
    $Cmaster = $connection->BOM->selectCollection("master");
    $Ctransaction = $connection->BOM->selectCollection("transaction");

	$json['log']['date']=new MongoDate();
	$mongo_l_id=new MongoId($json['mongo_l_id']);

	switch($json['CRUD']){
		case 'read' :
			$cursor=$Cmaster->findOne(
				(object)['_id' => $mongo_l_id]		
			);
			$json['level0']=$cursor;
			break;
		case 'create':
			$mongo_setup_id=new MongoId($json['mongo_setup_id']);
			
			$json['new_input_mongoid']=new MongoId();
			$json['new_output_mongoid']=new MongoId();

			$date=new MongoDate();
			$json['log']['date']=$date;			
			$json['created']=$json['log']['date'];
			
			$transaction=array(
                "l_id" => $json['l_id'], 'm_id'=>$json['m_id'],'name'=>$json['m_name'],'unit'=>$json['unit'],'spec'=>$json['spec'],
				'created'=>$date,
                "inventory" =>0,
                "init_inventory" =>(object)["quantity" => 0,"date" => $date],
                "state" =>["expanded", "expanded"],
                "inputs" => [ 
                    (object)[
                        "_id" => $json['new_input_mongoid'],
                        "date" => $date,
                        "quantity" => 0,
						'created'=>$date,
                        "logs" => [ 
                            (object)[
                                "type" => "created",
                                "quantity" => 0,
                                "date" => $date
                            ]
                        ]
                    ]
                ],
                "outputs" => [ 
                    (object)[
                        "_id" => $json['new_output_mongoid'],
                        "date" => $date,
                        "quantity" => 0,
						'created'=>$date,
                        "logs" => [ 
                            (object)[
                                "type" => "created",
                                "quantity" => 0,
                                "date" => $date
                            ]
                        ]
                    ]
                ]					
			);
			$Ctransaction->insert($transaction);
			$json['new_transaction_m_id']=$transaction['_id'];			
			
			$master=array(
                'name'=>$json['l_name'], 
				"l_id" => $json['l_id'], 'created'=>$date,
                "sub" => [ 
                    (object)[
                        "_id" => $json['new_transaction_m_id'],
                        "m_id" => $json['m_id'],
                        "name" => $json['m_name'],
						'unit'=>$json['unit'],'spec'=>$json['spec'],"state" =>"expanded",
						'created'=>$date,
                        "logs" => [ 
                            (object)[
                                "type" => "created",
                                "quantity" => 0,
                                "date" => $date
                            ]
                        ]
                    ]
                ],
			);
			$Cmaster->insert($master);
			$json['new_master_id']=$master['_id'];			
			
			$cursor=$Csetup->findOne(
				(object)['_id' => $mongo_setup_id]		
			);
			$array_loc=0;
			foreach ($cursor['BOM_master']['sub'] as $key => $value ){
				if ($value['_id']==$mongo_l_id){ 
					$json['l_id_found']=$array_loc; 
					break;
				}
				else $array_loc++;
			}
			$json['array_loc']=$array_loc+1;
			$Csetup->update(
				(object)['_id' => $mongo_setup_id],
				(object)['$push' => 
					(object)['BOM_master.sub' => 
						(object)[
							'$each'=>[
										(object)['_id'=>$json['new_master_id'], 'name'=>$json['l_name'], 'l_id'=>$json['l_id'],'created'=>$date,
												'state'=>'expanded',
													'logs'=>[$json['log']] ] 
									],
							'$position'=>$json['array_loc']
						]
					]
				]
			);
			break;
		case 'update':
			$mongo_setup_id=new MongoId($json['mongo_setup_id']);
			$target='BOM_master.sub.$.' . $json['target_key'];
			
				$Csetup->update(
					(object)[ '_id' => $mongo_setup_id, 'BOM_master.sub._id'=>$mongo_l_id ],
					(object)[ '$set' => (object)[$target => $json['cur']],
							'$push' => (object)['BOM_master.sub.$.logs'=>$json['log']] ]					
				);				
				$Cmaster->update(
					(object)[ '_id' => $mongo_l_id ],
					(object)[ '$set' => (object)[$json['target_key'] => $json['cur']] ]					
				);
			break;
		case 'remove':
			$mongo_setup_id=new MongoId($json['mongo_setup_id']);
				$target='BOM_master.sub.$.removed';
				$Csetup->update(
					(object)[ '_id' => $mongo_setup_id, 'BOM_master.sub._id'=>$mongo_l_id ],
					(object)[ '$set' => (object)[$target => $json['log']['date']],
							'$push' => (object)['BOM_master.sub.$.logs'=>$json['log']] ]					
				);
				$Cmaster->update(
					(object)[ '_id' => $mongo_l_id ],
					(object)[ '$set' => (object)['removed' => $json['log']['date']] ]					
				);
			break;
			
		case 'expand_collapse':	
			$mongo_setup_id=new MongoId($json['mongo_setup_id']);
			$cursor=$Csetup->findOne(
					(object)['_id' => $mongo_setup_id]		
			);
			$json['cursor']=$cursor;
			$array_loc=0;
			foreach ($cursor['BOM_master']['sub'] as $key => $value ){
				if ($value['_id']==$mongo_l_id){ 
					$json['l_id_found']=$array_loc; 
					break;
				}
				else $array_loc++;
			}
			$json['array_loc']=$array_loc;
			
			$target='BOM_master.sub.' . $array_loc . '.state';
			$Csetup->update(
				(object)['_id' => $mongo_setup_id],
				(object)['$set' => (object)[$target => $json['node_state']] 	]
			);
			break;
			

	}
	echo json_encode($json);

 ?> 
    
    
    
    

    
        

    
    
    
    
    
    
    
    
    