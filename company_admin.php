<!DOCTYPE html>
<html lang="en">
<head>
  <title>MES 회사 관리자 main</title>
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
    <li><a data-toggle="tab" href="#add_project">프로젝트등록</a></li>
    <li><a data-toggle="tab" href="#change_password">비밀번호변경</a></li>
  </ul>

  <div class="tab-content">
    <div id="login" class="tab-pane fade  in active">
		<h3>회사 관리자 login</h3>
		<form class="pure-form pure-form-aligned" id="admin_login">
			<fieldset>
                <div class="pure-control-group">
                    <label for="admin_id">admin id(이메일)</label>
                    <input id="admin_id" type="text" placeholder="Username">
                </div>

                <div class="pure-control-group">
                    <label for="admin_password">비밀번호</label>
                    <input id="admin_password" type="password" placeholder="Password">
                </div>

                <div class="pure-control-group">
                    <label for="company_id">회사코드</label>
                    <input id="company_id" type="text">
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
	
    <div id="change_password" class="tab-pane fade">
		<h3>회사 관리자 password 변겅</h3>
		<form class="pure-form pure-form-aligned" id="admin_login">
			<fieldset>
                <div class="pure-control-group">
                    <label for="admin_password_old">기존 비밀번호</label>
                    <input id="admin_password_old" type="text" placeholder="Username">
                </div>

                <div class="pure-control-group">
                    <label for="admin_password_new">새 비밀번호</label>
                    <input id="admin_password_new" type="password" placeholder="Password">
                </div>

                <div class="pure-control-group">
                    <label for="admin_password_new1">새 비밀번호 재입력</label>
                    <input id="admin_password_new1" type="text">
                </div>
				
      
                <div class="pure-controls">
                    <button type="submit" class="pure-button pure-button-primary">Submit</button>
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

$(function (){
	$('#admin_login').on('submit', function (e) { //Form submit with AJAX passing form data to PHP without page refresh
		e.preventDefault();
	
		var to_db={admin_id:$('#admin_id').val(), admin_password:$('#admin_password').val(),
					company_id:$('#company_id').val(), CRUD:'login', log:{type:'login'}};
		ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_admin_CRUD.php',to_db);	
		console.log('json',json);
	})
});
</script>


</body>
</html>