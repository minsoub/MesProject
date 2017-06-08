<?php
//header('Content-Type: text/plain');
    include('prettyPrint.php');
    
	$collectionName=$_GET['collection'];    
    
	//$connection = new MongoClient();
	$connection = new MongoClient("mongodb://localhost", 
				array("username" => "admin", "password" => "mongotest"));
    $collection = $connection->BOM->selectCollection($collectionName);
 
 //   echo "<h2>master collection</h2>";
    $cursor=$collection->find();
   /* foreach ($cursor as $id => $value )
    {
        echo "$id:<br>";
        var_dump( $value );
    	echo "<br><br>";
    }*/
	
/*	if ($collectionName=='transaction'){
		$collection->ensureIndex((object)['input._id' => -1]);// index on "-1" descending, "1" ascending
	}	*/

    $json=json_encode(iterator_to_array($cursor, false), JSON_UNESCAPED_UNICODE);
//    $ttt = prettyPrintToBrowser($json);
//   echo $ttt;
	echo $json;  // for jQuery ajax success:	
 ?> 
    
    
    
    

    
    
    

    
    
    
    
    
    
    
    
    