<!DOCTYPE html>
<html lang="en">
<head>
  <title>MES main</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  <style>.not-allowed     { cursor: not-allowed; }
 </style>
</head>
<body>

<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#login">관리자 login</a></li>
    <li><a class="not-allowed" href="#add_user">사용자등록</a></li>
    <li><a data-toggle="tab" href="#add_project">프로젝트 등록</a></li>
  </ul>

  <div class="tab-content">
    <div id="login" class="tab-pane fade  in active">
		<h3>관리자 login</h3>
		<form class="pure-form pure-form-aligned">
			<fieldset>
                <div class="pure-control-group">
                    <label for="name">사용자명</label>
                    <input id="name" type="text" placeholder="Username">
                </div>

                <div class="pure-control-group">
                    <label for="password">비밀번호</label>
                    <input id="password" type="password" placeholder="Password">
                </div>

                <div class="pure-control-group">
                    <label for="company_id">프로젝트(공정)</label>
                    <input id="company_id" type="text" placeholder="abcd">
                </div>

                <div class="pure-control-group">
                    <label for="company_id">회사코드</label>
                    <input id="company_id" type="text" placeholder="abcd">
                </div>
				
      
                <div class="pure-controls">
                    <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </div>
			</fieldset>
		</form>		
    </div>
	
    <div id="add_user" class="tab-pane fade">
		<h3>사용자 등록</h3>
		<form class="pure-form pure-form-aligned" id="form_add_user">
             <fieldset>
                 <div class="pure-control-group">
                     <label for="id">신규사용자 id</label>
                     <input id="id1" type="text" placeholder="Username" value="abc">
                 </div>
         
                 <div class="pure-control-group">
                     <label for="password1">신규사용자 비밀번호</label>
                     <input id="password1" type="password" placeholder="Password" value="abc">
                 </div>
 		 	 	<br><br>
                 <div class="pure-control-group">
                     <label for="id0">관리자 id</label>
                     <input id="id0" type="text" placeholder="admin" value="admin">
                 </div>
         
                 <div class="pure-control-group">
                     <label for="password0">비밀번호</label>
                     <input id="password0" type="password" placeholder="Password" value="mongotest">
                 </div>
                 <div class="pure-control-group">
                     <label for="company_id">회사코드</label>
                     <input id="company_id" type="text" placeholder="abcd" value="abcd">
                 </div>
 		 	 		
          
                 <div class="pure-controls">
                     <button type="submit" class="pure-button pure-button-primary" onclick="add_user(this)">Submit</button>
                 </div>
             </fieldset>
		</form>		
    </div>
    <div id="add_project" class="tab-pane fade">
      <h3>MES 프로젝트(공정) 등록</h3>
		<form class="pure-form pure-form-aligned" id="form_add_project">
             <fieldset>
                 <div class="pure-control-group">
                     <label for="project_name">프로젝트(공정) 이름</label>
                     <input id="project_name" type="text" placeholder="Username" value="abc">
                 </div>
         
 		 	 	<br><br>
                 <div class="pure-control-group">
                     <label for="id0">관리자 id</label>
                     <input id="id0" type="text" placeholder="admin" value="admin">
                 </div>
         
                 <div class="pure-control-group">
                     <label for="password0">비밀번호</label>
                     <input id="password0" type="password" placeholder="Password" value="mongotest">
                 </div>
                 <div class="pure-control-group">
                     <label for="company_id">회사코드</label>
                     <input id="company_id" type="text" placeholder="abcd" value="abcd">
                 </div>
 		 	 		
          
                 <div class="pure-controls">
                     <button type="submit" class="pure-button pure-button-primary" onclick="add_project(this)">Submit</button>
                 </div>
             </fieldset>
		</form>		
    </div>
  </div>
</div>


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

function add_user(btn){
	var to_db={id0:$('#id0').val(), id1:$('#id1').val(), password0:$('#password0').val(), password1:$('#password1').val(),
				company_id:$('#company_id').val(), log:{type:'created'}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_adduser.php',to_db);	
	console.log('json',json);
	if (json.hasOwnProperty('cursor_company_not_exist')){
		alert('회사코드 "'+$('#company_id').val()+'" 가 존재하지 않습니다.');
	}else if (!json.hasOwnProperty('hash')){
		alert('사용자 id "'+$('#id1').val()+'" 가 이미 존재합니다.');
	}else alert('사용자 id "'+$('#id1').val()+'" 가 추가되었습니다.');
}
</script>


</body>
</html>