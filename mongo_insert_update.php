<?php
$connection = new MongoClient();
$collection = $connection->myphp->collectionTest;

$doc = array(
    "name" => "MongoDB111",
    "type" => "database",
    "count" => 1,
    "info" => (object)array( "x" => 203, "y" => 102),
    "versions" => array("0.9.7", "0.9.8", "0.9.9")
);
$doc['_id'] = new MongoId();

$collection->insert( $doc );

echo "id=" . $doc['_id'] . "<br>";
var_dump($collection->findOne(array("_id" => $doc['_id'])));
echo "<br><br>";

$collection->insert(array("firstname" => "Bob", "lastname" => "Jones" ));
$newdata = array('$set' => array("address" => "1 Smith Lane"));
$collection->update(array("firstname" => "Bob"), $newdata);

var_dump($collection->findOne(array("firstname" => "Bob")));

/*
//push
$filter = array('_id'=>$id));
$update = array('$push'=>array('done_by'=>'2'));
$q->update($filter,$update);

//addToSet
$q = $conn->server->gameQueue;
$id = new MongoId("4d0b9c7a8b012fe287547157");
$q->update(array("_id"=>$id),array('$addToSet' => array("done_by","2")));*/


//C:\mongodb\bin>mongoimport --db test --collection restaurants --drop --file c:/data/db/downloads/primer-dataset.json




?> 