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
	
    $Ctransaction = $connection->BOM->transaction;

	if ($json['is_input']) $io_str='inputs';
	else  $io_str='outputs';
	$json['log']['date']=new MongoDate();
	$mongo_m_id=new MongoId($json['mongo_m_id']);			

	
	switch($json['CRUD']){
		case 'create':
			/*$orig_date =  $json['date'] . '  ' . $json['time'];
			$value = new MongoDate(strtotime($orig_date));
			$json['mongo_date']=$value;*/
			$value=new MongoDate();
			$json['mongo_date']=$value;

			$_id = new MongoId(); 
			$json['_id']=$_id;
			$json['created']=$value;
			
			$Ctransaction->update(
				(object)[ '_id' => $mongo_m_id ],
				(object)['$push' => 
					(object)[$io_str => 
						(object)[
							'$each'=>[
										(object)['_id'=>$_id, 'date'=>$value,'quantity'=>$json['quantity'],'created'=>$value,
													'logs'=>[$json['log']] ] 
									],
							'$position'=>$json['array_loc']
						]
					]
				]
			);
			//To use the $position modifier, it must appear with the $each modifier.
			/*db.getCollection('transaction').update(
				{'BOM_id':'B1@B100'},
				{$push:
					{
						'input':
						{ 
							$each:[
								{'date':'2016-08-08', 'quantity':1234, '_id':ObjectId(),
			                    'logs':[{'type':'created','date':'2016-08-10'} ]  } 
							  ],
			                  $position:2
						}      
					}
				}
			)*/
			break;

		case 'update':
			$target=$io_str . '.' . $json['array_loc'] . '.' . $json['target_key'];
			$target_logs=$io_str . '.'. $json['array_loc'] . '.logs';
			//db.test.find(ObjectId("4ecc05e55dd98a436ddcc47c")) 

			if ($json['target_key']=='date'){
				$orig_date =  $json['date'] . '  09:00:00';
				$value = new MongoDate(strtotime($orig_date));
				$json['mongo_date']=$value;	
				//db.getCollection('transaction').update(
				//						{'output._id':ObjectId("57b2caf24ae55f3016000033")},
				//						{'$set':{'output.$.quantity':777}})
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)[ '$set' => (object)[$target => $value],
							'$push' => (object)[$target_logs=>$json['log']] ]					
				);
			}else{
				$json['mongo_quantity']=$json['quantity'];
				$value=$json['quantity'];
//				$change_quantity=(strpos($json['quantity'], '.') === false) ? intval($json['quantity']) : floatval($json['quantity']);
				if ($json['is_input'])	$change_quantity=$json['quantity']-$json['prev_quantity'];
				else $change_quantity=$json['prev_quantity']-$json['quantity'];
				$json['change_quantity']=$change_quantity;
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)['$set' => (object)[$target => $value],
						  '$inc' =>  (object)['inventory' =>$change_quantity],
						  '$push' => (object)[$target_logs=>$json['log'] ] ]
				);
			}            
			break;
/*db.getCollection('transaction').update(
  {'BOM_id':'B1@B100'},
  {$set:{'inputs.0.quantity':1000},
   $push:{'inputs.0.logs':{'newtest':'qqq'}} }
)*/				
			
		case 'remove':
			$target_loc=$io_str . '.'. $json['array_loc'];// . '.logs';
			$target_logs=$io_str . '.'. $json['array_loc'] . '.logs';
			$target_removed=$io_str . '.' . $json['array_loc'] . '.removed';
			$target__id=$io_str . '.' . $json['array_loc'] . '._id';
			
			/*db.getCollection('transaction').update(
				{'BOM_id':'B1@B100'},
				{$set:{output.2.removed:true}}
			)*/
			$Ctransaction->update(  // set new key : 'removed'
				(object)[ '_id' => $mongo_m_id ],
				(object)['$set' => (object)[$target_removed=>true] ]
			);
			$Ctransaction->update(  // add log : 'removed'
				(object)[ '_id' => $mongo_m_id ],
				(object)['$push' =>  (object)[$target_logs=>$json['log']] ] 
			);
			/*db.getCollection('transaction').find(
				{'BOM_id':'B1@B100'},
				{'inputs':{$slice:[2,1]}}
                )*/
			/*$cursor =$Ctransaction->findOne(  // find io object
				(object)[	
					(object)['BOM_id' => $json['BOM_id']],
					(object)[$io_str => (object)['_id' => new MongoId($json['id'])]]
				]
			);*/
			//db.transaction.findOne({BOM_id:'B1@B100'}, {inputs:{$slice:[0,1]}} )
			$cursor =$Ctransaction->findOne( // find : remove target io object
				(object)[ '_id' => $mongo_m_id ],
				(object)[$io_str => (object)['$slice'=>[$json['array_loc'],1]]]				
			); 
			$json['source']=$cursor[$io_str][0];
			//$json['source']=$cursor[$io_str][0];
			$Ctransaction->update(  // push : append new cloned io object
				(object)[ '_id' => $mongo_m_id ],
				(object)['$push' => (object)[$io_str=>$json['source'] ]]
			);
			
			/*db.getCollection('transaction').update({'BOM_id':'B1@B100'},
				{'$pull':{'output':{'_id':ObjectId("57b2e3cf4ae55f701a00003f")}}}
			*/			
			$_id = new MongoId(); 
			$Ctransaction->update(  // set : new _id for remove target : 'removed'
				(object)[ '_id' => $mongo_m_id ],
				(object)['$set' => (object)[$target__id=>$_id] ]
			);

			$Ctransaction->update(          // pull : remove target io object
				(object)[ '_id' => $mongo_m_id ],
					(object)['$pull' => (object)[$io_str => (object)['_id' => $_id]]]
//					(object)['$pull' => (object)[$io_str => (object)['_id' => new MongoId($json['id'])]]]
			);


				if ($json['is_input'])	$change_quantity=-$json['source']['quantity'];
				else $change_quantity=$json['source']['quantity'];
				$json['change_quantity']=$change_quantity;
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)[ '$inc' =>  (object)['inventory' =>$change_quantity] ]
				);
			

			break;
		case 'expand_collapse':	
				if ($json['is_input']) $target='state.0';
				else $target='state.1';
//db.getCollection('transaction').update({'BOM_id':'B1@B1001'}, {$set:{'state.0':'collapsed'}})
				$Ctransaction->update(
					(object)[ '_id' => $mongo_m_id ],
					(object)[ '$set' => (object)[$target => $json['new_state']]]					
				);
			break;
	}
	echo json_encode($json);

 ?> 
    
    
    
    

    
        

    
    
    
    
    
    
    
    
    