<?php
// Start the session
	session_start();
//	$_id=$_GET['_id'];
//	if (!$_SESSION['_id']){
	$mongo_user__id=new MongoId($_SESSION['mongo_user__id']);
//	print_r($mongo_setup_id);
//	echo "<h1>mongo_company__id=" . $mongo_user__id->{'$id'}  . "</h1>";
	if (!isset($_SESSION['mongo_user__id'])){
		session_destroy();
		header('Location: http://localhost/RES2/MES/loginHTML.php');
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>MES</title>
  
  <script type="text/javascript">
		var timerStart = Date.now();
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" media="all" /> 
  <!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>-->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>  
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  
  <script src="../vendors/jsoneditor/dist/jsoneditor.js"></script>  
  <link href="../vendors/jsoneditor/dist/jsoneditor.css" rel="stylesheet" type="text/css">

  <link href="../vendors/jQuery-contextMenu-master/dist/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
  <script src="../vendors/jQuery-contextMenu-master/dist/jquery.contextMenu.js" type="text/javascript"></script>
  <script src="../vendors/jQuery-contextMenu-master/dist/jquery.ui.position.min.js" type="text/javascript"></script>

  <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  

 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
 
 <script src="MES3.js"> </script>
 <link rel="stylesheet" type="text/css" href="MES.css"> 
</head>
<!--<body data-spy="scroll" data-target=".navbar" data-offset="50">-->
<body style="position:relative;" data-spy="scroll" data-target="#navbar-example">
<div id="navbar-example">
<nav  class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#home">Bottom-up</a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="#home">General</a></li>		 
          <li><a href="#BOM">BOM 관리</a></li>		 
          <li><a href="#varTree">작업자 관리</a></li>		 
          <li><a href="#lp">Process 관리</a></li>		 
        </ul>
      </div>
    </div>
  </div>
</nav>    
</div>


<div style="padding-top:60px;" id="home" class="container">



 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse"  href="#general">BOM 관리</a>
      </h4>
    </div>
    <div id="general" class="panel-collapse collapse in">
		<div class="panel-body">
			<table id="BOM_table" class="table table-striped">
				<thead>
					<tr>     <th>품명</th><th>품목코드</th><th>단위</th><th>규격</th><th>수량</th><th>추가</th><th>삭제</th></tr>
				</thead>
				<tbody>
				<!-- 구입 품목, 부품,  반제품,  제품 -->
                    <tr data-depth="0" class="tbcollapse level0">
					<td><span class="toggle"></span><span contenteditable class="name editable">구입 품목</span></td>
					<td><span contenteditable class="id editable">A1</span></td>
                       <td></td><td></td><td></td>
					<td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>
					<td><input type="button" value="Remove" class="l_button" onclick="remove_lm(this)"></td>
                     </tr>
                     <tr data-depth="1" class="tbexpand level1">
					<td><span class="toggle"></span><span contenteditable class="name editable">coil</span></td>
					<td><span contenteditable class="id editable">A100</span></td>
                          <td></td><td></td><td></td>
							<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>
							<td><input type="button" value="Remove" class="m_button" onclick="remove_lm(this)" disabled></td>
                     </tr>
                     <tr data-depth="2" class="tbcollapse level2 tr_inventory">
                         <td>재고량</td>
                          <td></td><td></td><td></td>
                         <td><span class="inventory">1200</span></td>
                     </tr>
                     <tr data-depth="2" class="tbcollapse level2 tr_input">
					   <td><span class="toggle"></span>입고</td>						 
                         <td></td>
                          <td></td><td></td><td></td>
							<td><input type="button" value="Add" class="s_button s_after" onclick="add_s_after(this)"></td>
                     </tr>
                     <tr data-depth="3" class="tbcollapse level3">
                         <td><input type="date" value="2016-07-25"></td>
                          <td></td><td></td><td></td>
                         <td><span contenteditable class="quantity editable">1000</span></td>
							<td><input type="button" value="Add" class="s_button s_after" onclick="add_s_after(this)"></td>
							<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>
                     </tr>
                     <tr data-depth="3" class="tbcollapse level3">
                         <td><input type="date" value="2016-07-20"></td>
                          <td></td><td></td><td></td>
                         <td><span contenteditable class="quantity editable">1000</span></td>
							<td><input type="button" value="Add" class="s_button s_after" onclick="add_s_after(this)"></td>
							<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>
                     </tr>
                     <tr data-depth="2" class="tbcollapse level2 tr_output">
					   <td><span class="toggle"></span>출고</td>						 
                         <td></td>
                          <td></td><td></td><td></td>
							<td><input type="button" value="Add" class="s_button s_after" onclick="add_s_after(this)"></td>
                     </tr>
                     <tr data-depth="3" class="tbcollapse level3">
                         <td><input type="date" value="2016-07-25"></td>
                          <td></td><td></td><td></td>
                         <td><span contenteditable class="quantity editable">1000</span></td>
							<td><input type="button" value="Add" class="s_button s_after" onclick="add_s_after(this)"></td>
							<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>
                     </tr>
                     <tr data-depth="3" class="tbcollapse level3">
                         <td><input type="date" value="2016-07-20"></td>
                          <td></td><td></td><td></td>
                         <td><span contenteditable class="quantity editable">1000</span></td>
							<td><input type="button" value="Add" class="s_button s_after" onclick="add_s_after(this)"></td>
							<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>
                     </tr>
					 
				</tbody>
			</table>      
		</div>
    </div>
  </div>

  <?php 
	$mongo_company__id=new MongoId($_SESSION['mongo_company__id']);
	$mongo_user__id=new MongoId($_SESSION['mongo_user__id']);
//	print_r($mongo_setup_id);
	echo "<h1>company_id=" . $_SESSION['company_id']  . "</h1>";
	echo "<h1>mongo_company__id=" . $mongo_company__id->{'$id'}  . "</h1>";
	echo "<h1>mongo_user__id=" . $mongo_user__id->{'$id'}  . "</h1>";
?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#BOMa">BOM 관리</a>
      </h4>
    </div>
    <div id="BOMa" class="panel-collapse collapse in">
		<div class="panel-body">
	    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vulputate, dolor et molestie tempor, lacus magna fringilla libero, et faucibus ex lorem sit amet ex. Donec vitae lacus at libero feugiat faucibus. Quisque egestas urna non dolor pretium ornare ut et metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce maximus venenatis elit, in elementum quam vulputate eu. Nunc euismod urna sem, at ultrices orci cursus et. Maecenas rhoncus porttitor augue vitae pretium. Nam sodales tellus ex, nec rhoncus libero accumsan nec. Donec condimentum et velit convallis semper. Vivamus elementum congue mauris in ultrices. Vivamus eu diam at felis luctus posuere eget cursus purus. Proin mauris dolor, egestas non interdum sit amet, elementum ac turpis. Suspendisse potenti. Praesent eu dolor sit amet nibh maximus pretium id ac sem. 
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vulputate, dolor et molestie tempor, lacus magna fringilla libero, et faucibus ex lorem sit amet ex. Donec vitae lacus at libero feugiat faucibus. Quisque egestas urna non dolor pretium ornare ut et metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce maximus venenatis elit, in elementum quam vulputate eu. Nunc euismod urna sem, at ultrices orci cursus et. Maecenas rhoncus porttitor augue vitae pretium. Nam sodales tellus ex, nec rhoncus libero accumsan nec. Donec condimentum et velit convallis semper. Vivamus elementum congue mauris in ultrices. Vivamus eu diam at felis luctus posuere eget cursus purus. Proin mauris dolor, egestas non interdum sit amet, elementum ac turpis. Suspendisse potenti. Praesent eu dolor sit amet nibh maximus pretium id ac sem. 
		</div>
	</div>
  </div>
 </div>
</div> 

</body>
</html>
