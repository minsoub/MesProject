<!DOCTYPE html>
<html>
<head>
  <title>login</title>
  
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<!--<body data-spy="scroll" data-target=".navbar" data-offset="50">-->
<body>
<?php
	if (!isset($_SESSION['_id'])){
		echo "<h1>mongo _id not exist</h1>";
	}else echo "<h1>mongo _id exist</h1>";
?>

<h1> Welcom MES!!!</h1>
<form class="pure-form pure-form-aligned">
    <fieldset>
        <div class="pure-control-group">
            <label for="id1">사용자명</label>
            <input id="id1" type="text" placeholder="Username">
        </div>

        <div class="pure-control-group">
            <label for="password">비밀번호</label>
            <input id="password" type="password" placeholder="Password">
        </div>

        <div class="pure-control-group">
            <label for="company_id">회사코드</label>
            <input id="company_id" type="text" placeholder="abcd" value="abcd">
        </div>
		
  
        <div class="pure-controls">
    <!--        <label for="cb" class="pure-checkbox">
                <input id="cb" type="checkbox"> I've read the terms and conditions
            </label>
!-->
            <button type="submit" id="loginButton" class="pure-button pure-button-primary" onclick="login_user(this)">Submit</button>
        </div>
    </fieldset>
</form>		
<script>
function ajax_CRUD_mongodb(urlname,to_db){
    $.ajax({
        type: "POST",
 		cache:false,
        async: false,
        url: urlname,
		data: {data: JSON.stringify(to_db)},
		dataType: 'json',
        success: function(data) {		 
		//  console.log('mongodb update success: ',data); 
		  json=data; 
		 // json=JSON.parse(data);
        },
        error: 	function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error)}
	}).done(function( msg ) {
      //  console.log(" ajax done msg : ", msg );
	//	alert("Data Saved: " + modelJsonFileName + " msg : " + msg);
    });	
}

function login_user(btn){
	var to_db={username:$('#id1').val(), password:$('#password').val(), company_id:$('#company_id').val(), 
				log:{type:'login'}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_user_login.php',to_db);	
	console.log('json',json);
	if (json.hasOwnProperty('cursor_company_not_exist')){
		alert('회사코드 "'+$('#company_id').val()+'" 가 존재하지 않습니다.');
	}else if (json.user_not_exist){
		alert('사용자 id "'+$('#id1').val()+'" 가 존재하지 않습니다.');
	}else if (!json.is_login_success) { 
		alert('사용자 id "'+$('#id1').val()+'" 의 password가 맞지않습니다.');
	}else{ 
		console.log('사용자 id "'+$('#id1').val()+'" 의 lgoin success : _id=');
//		window.location.href = 'http://localhost/RES2/MES/MES.php';
		//$(location).attr('href','http://localhost/RES2/MES/MES.php');
	}
}

$('#loginButton').click(function() {
	if (json.hasOwnProperty('is_login_success')){
		if (json.is_login_success){
			var url='http://localhost/RES2/MES/MES.php';
//			var url='http://localhost/RES2/MES/MES.php?_id='+json._id['$id'];
			window.location.href = url;
//			window.location.assign(url);
			return false;
		}
	}
});
</script>

</body>
</html>
