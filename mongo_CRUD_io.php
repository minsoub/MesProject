<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");*/
	$stringData = $_POST["data"];
	$json = json_decode($stringData,true);
    
	$connection = new MongoClient();
    $collection = $connection->BOM->transaction;

	switch($json['CRUD']){
		case 'create':
			if ($json['is_input']) $io_str='input';
			else  $io_str='output';
			/*$orig_date =  $json['date'] . '  ' . $json['time'];
			$value = new MongoDate(strtotime($orig_date));
			$json['mongo_date']=$value;*/
			$value=new MongoDate();
			$json['mongo_date']=$value;

			$_id = new MongoId(); 
			
			$collection->update(
				(object)['BOM_id' => $json['BOM_id']],
				(object)['$push' => 
					(object)[$io_str => 
						(object)[
							'$each'=>[
										(object)['_id'=>$_id, 'date'=>$value,'quantity'=>$json['quantity'],
													'logs'=>[$json['log']] ] 
									],
							'$position'=>0
						]
					]
				]
			);
/*			$collection->update(
				array('BOM_id' => $json['BOM_id']),
				array('$push' => 
					array($io_str => 
						array(
							'$each'=>array(
										array('date'=>$json['date'],'quantity'=>$json['quantity'],
													'logs'=>array($json['log']) ) 
									),
							'$position'=>0
						)
					)
				)
			);*/
			break;
			/*db.getCollection('transaction').update(
				{'BOM_id':'B1@B100'},
				{$push:
					{
						'input':
						{ 
							$each:[
								{'date':'2016-08-08', 'amount':1234, 
			                    'logs':[{'type':'created','date':'2016-08-10'} ]  } 
							  ],
			                  $position:0
						}      
					}
				}
)			
			*/

		case 'update':
			if ($json['is_input']) $io_str='input.';
			else  $io_str='output.';
			$target=$io_str . $json['array_loc'] . '.' . $json['target_key'];
			$target_logs=$io_str . $json['array_loc'] . '.logs';
			//db.test.find(ObjectId("4ecc05e55dd98a436ddcc47c")) 

			if ($json['target_key']=='date'){
				$orig_date =  $json['date'] . '  09:00:00';
				$value = new MongoDate(strtotime($orig_date));
				$json['mongo_date']=$value;	
				//db.getCollection('transaction').update(
				//						{'output._id':ObjectId("57b2caf24ae55f3016000033")},
				//						{'$set':{'output.$.quantity':777}})
				$collection->update(
					(object)[ 'BOM_id' => $json['BOM_id'], 'output._id'=>ObjectId("57b2caf24ae55f3016000033")],
					array( '$set' => array($target => $value),
							'$push' => array($target_logs=>$json['log']))					
				);
			}else{
				$json['mongo_quantity']=$json['quantity'];
				$value=$json['quantity'];
//				$change_amount=(strpos($json['quantity'], '.') === false) ? intval($json['quantity']) : floatval($json['quantity']);
				if ($json['is_input'])	$change_amount=$json['quantity']-$json['prev_quantity'];
				else $change_amount=$json['prev_quantity']-$json['quantity'];
				$json['change_amount']=$change_amount;
				$collection->update(
					array('BOM_id' => $json['BOM_id']),
					array('$set' => array($target => $value),
						  '$inc' => array('inventory' =>$change_amount),
						  '$push' => array($target_logs=>$json['log']))
				);
			}            
			break;
/*db.getCollection('transaction').update(
  {'BOM_id':'B1@B100'},
  {$set:{'input.0.quantity':1000},
   $push:{'input.0.logs':{'newtest':'qqq'}} }
)*/				
	}
	echo json_encode($json);
// $   Acts as a placeholder to update the first element that matches the query condition in an update.				
//The positional $ operator identifies an element in an array to update without explicitly specifying 
//  the position of the element in the array.

 ?> 
    
    
    
    

    
        

    
    
    
    
    
    
    
    
    