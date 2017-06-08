<?php
//https://www.sitepoint.com/mongodb-indexing-1/
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");*/
	session_start();

	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);

//	$json['log']['company_id']=$_SESSION['company_id'];
	$json['log']['username']=$_SESSION['username'];
	$json['log']['company_id']=$_SESSION['company_id'];
//	$mongo_company__id=new MongoId($_SESSION['mongo_company__id']);
//	$mongo_user__id=new MongoId($_SESSION['mongo_user__id']);
    
//	$connection = new MongoClient();
	$connection = new MongoClient("mongodb://localhost", 
				array("username" => "admin", "password" => "mongotest"));
	
    $Cmaster = $connection->BOM->master;
    $Ctransaction = $connection->BOM->transaction;
/*> db.collection.insertOne( { "_id" : 123, "food": [ "apple", "mango", "banana", "mango" ] } )
{ "acknowledged" : true, "insertedId" : 123 }
> db.collection.aggregate( [ { "$project": { "matchedIndex": { "$indexOfArray": [ "$food", "mango" ] } } } ] )
{ "_id" : 123, "matchedIndex" : 1 }

var food = db.getCollection('yourCollection').findOne({_id: '123'}).food;
    print('Index of mango: ' + food.indexOf('mango'));
*/
	$json['log']['date']=new MongoDate();
	$mongo_l_id=new MongoId($json['mongo_l_id']);
	$mongo_m_id=new MongoId($json['mongo_m_id']);			

	switch($json['CRUD']){
		case 'read' :
			$cursor=$Ctransaction->findOne(
				(object)['_id' => $mongo_m_id]		
			);
			$json['level1']=$cursor;
			break;
		case 'create':
			$cursor=$Cmaster->findOne(
				(object)['_id' => $mongo_l_id]		
			);
			$array_loc=0;
			foreach ($cursor['sub'] as $key => $value ){
				if ($value['_id']==$mongo_m_id){ 
					$json['m_id_found']=$array_loc; 
					break;
				}
				else $array_loc++;
			}
			$json['array_loc']=$array_loc+1;
			$json['created']=$json['log']['date'];
			
			$json['new_input_mongoid']=new MongoId();
			$json['new_output_mongoid']=new MongoId();
			$json['l_id']=$cursor['l_id'];

			$date=new MongoDate();
			$json['log']['date']=$date;			
			
			$doc=array(
               // "BOM_id" => $json['l_id'] . '@' . $json['m_id'],
                "l_id" => $json['l_id'], 'm_id'=>$json['m_id'],'name'=>$json['name'],'unit'=>$json['unit'],'spec'=>$json['spec'],
				'created'=>$date,
				"mongo_l_id"=>$mongo_l_id,
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
			$Ctransaction->insert($doc);
			
			$json['new_transaction_m_id']=$doc['_id'];			
			$Cmaster->update(
				(object)['_id' => $mongo_l_id],
				(object)['$push' => 
					(object)['sub' => 
						(object)[
							'$each'=>[
										(object)['_id'=>$doc['_id'], 'm_id'=>$json['m_id'],'name'=>$json['name'],'created'=>$date,
												'unit'=>$json['unit'],'spec'=>$json['spec'],'state'=>$json['node_state'],
													'logs'=>[$json['log']] ] 
									],
							'$position'=>$json['array_loc']
						]
					]
				]
			);
			
		//	$json['transaction_id']=$insertResult->getInsertedId($insertResult);
			break;
		case 'update':
			if($json['target_key']=='id'){
				$target='sub.$.m_id';
				$Cmaster->update(
					(object)[ '_id' => $mongo_l_id, 'sub._id'=>$mongo_m_id ],
					(object)[ '$set' => (object)[$target => $json['cur_m_id']],
							'$push' => (object)['sub.$.logs'=>$json['log']] ]					
				);
				//$prev_BOM_id=$json['l_id'] . '@' . $json['m_id'];
				//$new_BOM_id=$json['l_id'] . '@' . $json['cur_m_id'];
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)[ '$set' => (object)['m_id' => $json['cur_m_id']] ]					
				);
				
			}else{  // name, unit, spec update
				//db.getCollection('master').update({'l_id':'B1', 'sub.m_id':'B100'},{$set:{'sub.$.name':'new_coil'}})
				$target='sub.$.' . $json['target_key'];
				$Cmaster->update(
					(object)[ '_id' => $mongo_l_id, 'sub._id'=>$mongo_m_id ],
					(object)[ '$set' => (object)[$target => $json['cur']],
							'$push' => (object)['sub.$.logs'=>$json['log']] ]					
				);				
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)[ '$set' => (object)[$json['target_key'] => $json['cur']] ]					
				);
			}
			break;
		case 'remove':
				$target='sub.$.removed';
				$Cmaster->update(
					(object)[ '_id' => $mongo_l_id, 'sub._id'=>$mongo_m_id ],
					(object)[ '$set' => (object)[$target => $json['log']['date']],
							'$push' => (object)['sub.$.logs'=>$json['log']] ]					
				);
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)[ '$set' => (object)['removed' => $json['log']['date']] ]					
				);
			break;
			
		case 'expand_collapse':	
			$cursor=$Cmaster->findOne(
					(object)['_id' => $mongo_l_id]		
			);
			$array_loc=0;
			foreach ($cursor['sub'] as $key => $value ){
				if ($value['_id']==$mongo_m_id){ 
					$json['m_id_found']=$array_loc; 
					break;
				}
				else $array_loc++;
			}
			$json['array_loc']=$array_loc;
			
			$target='sub.' . $array_loc . '.state';
			$Cmaster->update(
				(object)['_id' => $mongo_l_id],
				(object)['$set' => (object)[$target => $json['node_state']] 	]
			);
			break;
			

	}
	echo json_encode($json);

 ?> 
    
    
    
    

    
        

    
    
    
    
    
    
    
    
    