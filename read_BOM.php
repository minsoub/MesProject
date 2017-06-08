<?php
//header('Content-Type: text/plain');
    include('prettyPrint.php');
    
    
    $connection = new MongoClient();
    $master = $connection->BOM->master;
    $transaction = $connection->BOM->transaction;

    echo "<h2>master collection</h2>";
    $cursor=$master->find();
   /* foreach ($cursor as $id => $value )
    {
        echo "$id:<br>";
        var_dump( $value );
    	echo "<br><br>";
    }*/
    $json=json_encode(iterator_to_array($cursor, false), JSON_UNESCAPED_UNICODE);
    $ttt = prettyPrintToBrowser($json);
    echo $ttt;
    
    echo "<br><h2>transaction collection</h2>";
    $cursor=$transaction->find();
    foreach ($cursor as $id => $value )
    {
        echo "$id:<br>";
        var_dump( $value );
    	echo "<br><br>";
	}
?> 
    
    
    
    

    
    
    

    
    
    
    
    
    
    
    
    