<!DOCTYPE html>
<html lang="en">
<head>
  <title>회사 관리자 등록</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  <style>.not-allowed     { cursor: not-allowed; }
	.pure-form-aligned .pure-control-group label {
		width: 15em;
	}
 </style>
</head>
<body>

<div class="container">
		<h3>신규 회사/admin/project 등록</h3>
		<form class="pure-form pure-form-aligned" id="form_add_user">
             <fieldset>
                 <div class="pure-control-group">
                     <label for="c_name">회사이름</label>
                     <input id="c_name" type="text">
                 </div>
                 <div class="pure-control-group">
                     <label for="c_id">회사코드</label>
                     <input id="c_id" type="text">
                 </div>
                 <div class="pure-control-group">
                     <label for="c_admin_id">회사 admin id(이메일)</label>
                     <input id="c_admin_id" type="text">
                 </div>
         
                 <div class="pure-control-group">
                     <label for="c_admin_password">회사 admin 비밀번호</label>
                     <input id="c_admin_password" type="password">
                 </div>
                 <div class="pure-control-group">
                     <label for="c_admin_password1">회사 admin 비밀번호 재입력</label>
                     <input id="c_admin_password1" type="password">
                 </div>
               <!--  <div class="pure-control-group">
                     <label for="c_first_project">first project 이름</label>
                     <input id="c_first_project" type="text">
                 </div>-->
 		 	 	<br><br>
                 <div class="pure-control-group">
                     <label for="mongo_admin_id">mongodb 관리자 id</label>
                     <input id="mongo_admin_id" type="text">
                 </div>
         
                 <div class="pure-control-group">
                     <label for="mongo_admin_password">mongodb 관리자 비밀번호</label>
                     <input id="mongo_admin_password" type="password">
                 </div>
 		 	 		
          
                 <div class="pure-controls">
                     <button type="submit" class="pure-button pure-button-primary" onclick="add_company(this)">Submit</button>
                 </div>
             </fieldset>
		</form>		
</div>


<script>
var json;
function ajax_CRUD_mongodb(urlname,to_db){
    $.ajax({
        type: "POST",
 		cache:false,
        async: false,
        url: urlname,
		data: {data: JSON.stringify(to_db)},
		dataType: 'json',
        success: function(data) {		 
		  console.log('mongodb update success: ',data); 
	//	  alert('mongodb update success: ',data); 
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
	$('form').on('submit', function (e) { //Form submit with AJAX passing form data to PHP without page refresh
		e.preventDefault();
		var to_db={c_name:$('#c_name').val(),
		       c_id:$('#c_id').val(),
		       c_admin_id:$('#c_admin_id').val(),
		       c_admin_password:$('#c_admin_password').val(),
		       c_admin_password1:$('#c_admin_password1').val(),
		      // c_first_project:$('#c_first_project').val(),
			   mongo_admin_id:$('#mongo_admin_id').val(), 
			   mongo_admin_password:$('#mongo_admin_password').val(),
			   log:{type:'created'}};
		if ($('#c_admin_password').val()!=$('#c_admin_password1').val()){
			alert('password mismatch');
		}else{
			ajax_CRUD_mongodb('http://cat.ks.ac.kr/MES2/mongo_create_company.php',to_db);	
			console.log('json',json);
			
			if (json.hasOwnProperty('MongoException')){
				alert('MongoException : message = "'+json.MongoException.errorMessage
							+', code = "'+json.MongoException.errorCode);
			}else if (json.hasOwnProperty('cursor_company_exist')){
				alert('회사코드 "'+$('#c_id').val()+'" 가 이미 존재합니다.');
			}else{
				if (json.hasOwnProperty('cursor_username_exist')){
					alert('사용자 id "'+$('#c_admin_id').val()+'" 가 이미 존재합니다.');
				}else{
					alert('회사코드 "'+$('#c_id').val()+'" 가 추가되었습니다.');
				}
			}
		
		}
	})
});

function add_company(btn){
}
</script>


</body>
</html>