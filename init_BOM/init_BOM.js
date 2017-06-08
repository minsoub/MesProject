// load('C:\\xampp\\htdocs\\RES2\\MES\\init_BOM\\init_BOM.js')
print('test');
//dbname='BOM1';
//db = connect("localhost:27017/"+dbname);  /*conn = new Mongo()    db = conn.getDB("BOM")  //use BOM;*/

{
    "_id" : ObjectId("57a83b0897352492698e1ef0"),
    "name" : "?? ??",
    "l_id" : "B1",
    "state" : "expanded",
    "sub" : [ 
        {
            "m_id" : "B100",
            "_id" : ObjectId("57b53650c9884922239436a2"),
            "name" : "coil1",
            "quantity" : "EA",
            "unit" : "4m*10m",
            "state" : "expanded"
        }
    ]
}
//db.master.drop()
/*db.users.insertOne(
   {
      name: "sue",
	  myid : ObjectId(),
      age: 19,
      status: "P"
   }
)
db.master.insertOne({"test":"zzz"});*/
/*db.master.insertOne{
	{
        "_id" : ObjectId(),
        "name" : "备涝 前格",
        "l_id" : "B1",
        "state" : "expanded",
        "sub" : [ 
            {
                "m_id" : "B100",
                "_id" : ObjectId(),
                "name" : "coil1",
                "quantity" : "EA",
                "unit" : "4m*10m",
                "state" : "expanded"
            }
        ]
	}		
}

doc=db.master.findOne({});
_id_0=doc._id;
_id_1=doc.sub[0]._id;

//db.transaction.drop()
db.transaction.insertOne{
	{
        "_id" : ObjectId(),
		"_id_0" : _id_0,
		"_id_1" : _id_1,
        "BOM_id" : "B1@B100",
        "inventory" : 10464,
		"init_inventory":{"date":new Date(), "inventory" : 10464}
        "state" : [ 
            "expanded", 
            "expanded"
        ],
        "input" : [ 
            {
                "_id" : ObjectId(),
                "date" : ISODate("2016-08-18T10:37:46.000+09:00"),
                "quantity" : 100,
                "logs" : [ 
                    {
                        "type" : "created",
                        "quantity" : 100,
                        "date" : "2016-08-18 10:37:46"
                    }, 
                    {
                        "type" : "changed",
                        "quantity_to" : 100,
                        "date" : "2016-08-18 10:37:52"
                    }
                ]
            }
        ],
        "output" : [ 
            {
                "_id" : ObjectId(),
                "date" : ISODate("2016-08-16T18:59:07.000+09:00"),
                "quantity" : 12,
                "logs" : [ 
                    {
                        "type" : "created",
                        "quantity" : 0,
                        "date" : "2016-08-16 18:59:07"
                    }, 
                    {
                        "type" : "changed",
                        "quantity_to" : 12,
                        "date" : "2016-08-17 11:13:57"
                    }
                ]
            }
        ]
	}
}
*/
/*
print('test');

x=db.getCollectionInfos().forEach( 
	function(myColl) { print( "user: " + myColl.name ); } 
);
db.users.insertOne(
   {
      name: "sue",
	  myid : ObjectId(),
      age: 19,
      status: "P"
   }
)
db.users.insertMany(
   [
     { name: "bob", age: 42, status: "A", },
     { name: "ahn", age: 22, status: "A", },
     { name: "xi", age: 34, status: "D", }
   ]
)*/
/*
{
    "_id" : ObjectId("57a70cc420e8a7010751f82e"),
    "name" : "备涝 前格",
    "l_id" : "B1",
    "state" : "expanded",
    "sub" : [ 
        {
            "_id" : ObjectId("57b95108b92d07cf726058ad"),
            "m_id" : "B100",
            "name" : "coil1",
            "quantity" : "EA",
            "unit" : "4m*10m",
            "state" : "expanded"
        }
    ]
}*/