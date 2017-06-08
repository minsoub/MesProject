<!DOCTYPE html>
<html>
<head>
  <title>RES2</title>
  
  <script type="text/javascript">
		var timerStart = Date.now();
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  
  <script src="vendors/jsoneditor/dist/jsoneditor.js"></script>  
  <link href="vendors/jsoneditor/dist/jsoneditor.css" rel="stylesheet" type="text/css">

  <link href="vendors/jQuery-contextMenu-master/dist/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
  <script src="vendors/jQuery-contextMenu-master/dist/jquery.contextMenu.js" type="text/javascript"></script>
  <script src="vendors/jQuery-contextMenu-master/dist/jquery.ui.position.min.js" type="text/javascript"></script>

  <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  
	<link rel="stylesheet" type="text/css" href="vendors/katex/katex.min.css">
	<script type="text/javascript" src="vendors/katex/katex.min.js"></script>
	<script src="vendors/glpk.js/dist/glpk.min.js"></script>
 
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
 
  <script src="main26.js"> </script>
  <link rel="stylesheet" type="text/css" href="css/main.css"> 
  <link rel="stylesheet" type="text/css" href="css/res.css"> 
 <!-- <link rel="stylesheet" type="text/css" href="css/treeview.css"> -->
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
          <li><a href="#tLevels">Technology</a></li>		 
          <li><a href="#varTree">Variable/Constraint</a></li>		 
          <li><a href="#lp">View LP/Get Optimal</a></li>		 
          <li><a href="#solTree">View/Save Solution</a></li>		 
          <li><a href="#viewers">JSON Viewers</a></li>		 

     <!--     <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">LP<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#lpViewer">Viewer</a></li>
              <li><a href="#vairables">Variables</a></li>
              <li><a href="#constraint">Contraints</a></li>
            </ul>		  
		 </li>
		 
          <li><a href="#section3">Section 3</a></li>
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Section 4 <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#section41">Section 4-1</a></li>
              <li><a href="#section42">Section 4-2</a></li>
            </ul>
          </li>-->
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
        <a data-toggle="collapse"  href="#general">General</a>
      </h4>
    </div>
    <div id="general" class="panel-collapse collapse in">
      <div class="panel-body">
	    <?php include('general1.php'); ?>
      </div>
    </div>
  </div>
  <div><span class="excelRange"></span>  : input 'constant number[<i>or</i> excel one row range]'</div>
 <div><span class="excelMatrixRange"></span>  : input 'excel single row[<i>or</i> multiple rows range]'</div>
 <div><span class="excelSolutionAddress"></span>  : input 'excel cell address'</div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#eLevels">Energy Levels(Energy Forms)</a>
      </h4>
    </div>
    <div id="eLevels" class="panel-collapse collapse in">
		<div class="panel-body">
			<ul id="tree_for_el_ef">
				<li class="energyLevels"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
						<span contenteditable class="name editable">car energy</span>
						<span class="label">l_id</span><span class="id">1</span>
						<span class="aligh_loc_el">
							<span class="label">loc x</span><span contenteditable class="locX editable">10</span>
							<span class="label">loc y</span><span contenteditable class="locY editable">10</span>
						</span>
						<span class="aligh_button">
							<input type="button" value="Add" class="el_button el_after" onclick="add_el_after(this)">
							<input type="button" value="Remove" class="el_button" onclick="remove_el(this)">
						</span>
					<ul>
						<li class="ef">
								<span contenteditable class="name editable">oil</span>
								<span class="label">f_id</span><span class="id">1</span>
								<span class="aligh_check">
									<span class="label">load region</span><input type="checkbox" class="hasLoadRegion"/>
									<span class="label">eq</span><input type="checkbox" class="eq"/>
								</span>
								<span class="aligh_loc">
									<span class="label">loc x</span><span contenteditable class="locX editable">10</span>
									<span class="label">loc y</span><span contenteditable class="locY editable">10</span>
								</span>
								<span class="aligh_button">
									<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
									<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
								</span>
						</li>
						<li  class="ef">
								<span contenteditable class="name editable">bio ethanl</span>
								<span class="label">f_id</span><span class="id">2</span>
								<span class="aligh_check">
									<span class="label">load region</span><input type="checkbox" class="hasLoadRegionC"/>
									<span class="label">eq</span><input type="checkbox" class="eqC"/>
								</span>
								<span class="aligh_loc">
									<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
									<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
								</span>
								<span class="aligh_button">
									<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
									<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
								</span>
						</li>
						<li  class="ef">
								<span contenteditable class="name editable">electricity</span>
								<span class="label">f_id</span><span class="id">3</span>
								<span class="aligh_check">
									<span class="label">load region</span><input type="checkbox" class="hasLoadRegionC"/>
									<span class="label">eq</span><input type="checkbox" class="eqC"/>
								</span>
								<span class="aligh_loc">
									<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
									<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
								</span>
								<span class="aligh_button">
									<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
									<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
								</span>
						</li>
					</ul>
				</li>
				<li class="energyLevels"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
						<span contenteditable class="name editable">blended energy</span>
						<span class="label">l_id</span><span class="id">2</span>
						<span class="aligh_loc_el">
							<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
							<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
						</span>
						<span class="aligh_button">
							<input type="button" value="Add" class="el_button el_after" onclick="add_el_after(this)">
							<input type="button" value="Remove" class="el_button" onclick="remove_el(this)">
						</span>
					<ul>
						<li  class="ef">
								<span contenteditable class="name editable">bio ethanol</span>
								<span class="label">f_id</span><span class="id">4</span>
								<span class="aligh_check">
									<span class="label">load region</span><input type="checkbox" class="hasLoadRegionC"/>
									<span class="label">eq</span><input type="checkbox" class="eqC"/>
								</span>
								<span class="aligh_loc">
									<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
									<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
								</span>
								<span class="aligh_button">
									<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
									<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
								</span>
						</li>
					</ul>
				</li>
				<li class="energyLevels"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
						<span contenteditable class="name editable">car demand</span>
						<span class="label">l_id</span><span class="id">3</span>
						<span class="aligh_loc_el">
							<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
							<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
						</span>
						<span class="aligh_button">
							<input type="button" value="Add" class="el_button el_after" onclick="add_el_after(this)">
							<input type="button" value="Remove" class="el_button" onclick="remove_el(this)">
						</span>
					<ul>
						<li  class="ef"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
								<span contenteditable class="name editable">km per year</span>
								<span class="label">f_id</span><span class="id">5</span>
								<span class="aligh_check">
									<span class="label">load region</span><input type="checkbox" class="hasLoadRegionC"/>
									<span class="label">eq</span><input type="checkbox" class="eqC"/>
								</span>
								<span class="aligh_loc">
									<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
									<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
								</span>
								<span class="aligh_button">
									<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
									<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
								</span>
								<ul>
									<li class="demand">	
										<div style="display:table;width=80%;">									
											<div style="float:left;">
												<div class="excelLabel">excel range </div>
												<div class="excelRange">F20:AO20 </div>
											</div>
											<div class="ts1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.      
											</div>
										</div>									
									</li>
								</ul>
						</li>
						<li  class="ef"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
								<span contenteditable class="name editable">TOE</span>
								<span class="label">f_id</span><span class="id">6</span>
								
								<span class="aligh_check">
									<span class="label">load region</span><input type="checkbox" class="hasLoadRegionC"/>
									<span class="label">eq</span><input type="checkbox" class="eqC"/>
								</span>
								<span class="aligh_loc">
									<span class="label">loc x</span><span contenteditable class="loc editable">10</span>
									<span class="label">loc y</span><span contenteditable class="loc editable">10</span>
								</span>
								<span class="aligh_button">
									<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
									<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
								</span>
								<ul>
									<li class="demand">										
										<div style="display:table;">									
											<div style="float:left;">
												<div class="excelLabel">excel range </div>
												<div class="excelRange">F20:AO20 </div>
											</div>
											<div class="ts1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.      
											</div>
										</div>									
									</li>
								</ul>
						</li>
					</ul>
				</li>
			</ul>	    
		</div>
    </div>
	
	
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#tLevels">
        Technology</a>
      </h4>
    </div>
	
	
  <div id="tLevels" class="panel-collapse collapse in">
		<div class="panel-body">
			<button class="pure-button pure-button-primary" onclick="save_tech(this)">Save Technologies</button>			
			<ul id="tree_for_tech">
				<li class="techLevelLi el"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
						<span contenteditable class="name editable">car energy</span>
						<span class="label">tl_id</span><span class="id">1</span>
						<span class="aligh_loc_el" style="margin-left:20px;">
							<span class="label">loc x</span><span contenteditable class="locX editable">10</span>
							<span class="label">loc y</span><span contenteditable class="locY editable">10</span>
						</span>
						<span class="aligh_button">
							<input type="button" value="Add" class="el_button el_after" onclick="add_el_after(this)">
							<input type="button" value="Remove" class="el_button" onclick="remove_el(this)">
						</span>
					<ul class="techUl">
						<li class="techLi ef"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
							<span contenteditable class="name editable">oil</span>
							<span class="label">t_id</span><span class="id">1</span>								
							<span class="aligh_loc">
								<span class="label">loc x</span><span contenteditable class="locX editable">10</span>
								<span class="label">loc y</span><span contenteditable class="locY editable">10</span>
							</span>
							<span class="aligh_button">
								<input type="button" value="Add" class="ef_button ef_after" onclick="add_ef_after(this)">
								<input type="button" value="Remove" class="ef_button" onclick="remove_ef(this)">
							</span>
							<ul class="capacityUl">
								<li  class="capacityLi" style="margin-top:5px"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
									<span class="label" style="font-size:15px">capacity</span><br>
									<span class="label"  style="margin-left:40px;">first year</span> <span contenteditable class="year editable">2015</span>
									<span class="label">last year</span> <span contenteditable class="year editable">2055</span>
									<span class="label">plant factor[0,1]</span> <span contenteditable class="year editable">1</span>
									<span class="label">lifetime</span> <span contenteditable class="year editable">10</span>
									<ul  class="investmentCostUl">
										<li class="investmentCostLi demand"  style="margin-top:5px"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
											<span class="label" style="font-size:15px">investment cost</span>
											<ul  class="investmentCostTableUl">
												<table class="demand" width=80%>
													<tr><td align="left" width=20%><span class="excelLabel">excel range </span></td>
														<td align="left" rowspan="2" width=80%><span class="ts1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.      
														</span></td>
													</tr>
													<tr><td align="left"><span contenteditable class="excelRange editable">F20:AO20</span></td> 
													</tr>
												</table>
											</ul>											
										</li>
										<li class="fixedCostLi demand"  style="margin-top:5px"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
											<span class="label" style="font-size:15px">fixed O&amp;M  cost</span>
											<ul  class="fixedCostTableUl">
												<table class="demand" width=80%>
													<tr><td align="left" width=20%><span class="excelLabel">excel range </span></td>
														<td align="left" rowspan="2" width=80%><span class="ts1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.      
														</span></td>
													</tr>
													<tr><td align="left"><span contenteditable class="excelRange editable">F20:AO20</span></td> 
													</tr>
												</table>
											</ul>											
										</li>
										<li class="historicCapTableLi"  style="margin-top:5px"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
											<span class="label" style="font-size:15px">historic capacity</span>
											<ul class="historicCapTableUl">
												<table class="histCap" width=80%>
													<tr><td>year</td><td align="left"><span contenteditable class="excelRange editable histYear">F20:AO20</span>
														<td>2004</td><td>2005</td><td>2006</td><td>2007</td><td>2008</td><td>2009</td><td>2010</td><td>2011</td><td>2012</td><td>2013</td><td>2014</td>
													</tr>
													<tr><td>capacity</td><td align="left"><span contenteditable class="excelRange editable histCap">F20:AO20</span>
														<td>2004000</td><td>200005</td><td>2006000</td><td>200007</td><td>9992008</td><td>299009</td><td>299010</td><td>992011</td><td>992012</td><td>992013</td><td>992014</td>
													</tr>
												</table>
											</ul>											
										</li>
									</ul>
								</li>
								<li  class="activityLi" style="margin-top:5px"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
									<span class="label" style="font-size:15px">activity</span>
									<span class="label">a_id</span><span class="id">1</span>
									<span class="aligh_button">
										<input type="button" value="Add" class="act_button act_after" onclick="add_ef_after(this)">
										<input type="button" value="Remove" class="act_button" onclick="remove_ef(this)">
									</span>									
										<ul class="ioUl">
											<li  class="mainInputLi" data-type="mainInput">
												<span class="mylabel">main input</span> 
												<span class="mymargin"><span class="select_ef context-menu-one btn btn-neutral"> <i class="fa fa-caret-square-o-right"  style="font-size:12px;"></i></span>
												<span class="year">1.0</span></span>
												<span class="aligh_button">
													<input type="button" value="Add" class="io_button io_after" onclick="add_input(this)">
												</span>
											</li>
											<li  class="otherInputLi"  data-type="otherInput"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
														<span class="mylabel">other input(on by button)</span>														
														<span class="mymargin"><span class="select_ef context-menu-one btn btn-neutral"> 
																	<i class="fa fa-caret-square-o-right"  style="font-size:12px;"></i></span></span>
														<span class="aligh_button">
															<input type="button" value="Add" class="io_button io_after" onclick="add_input(this)">
															<input type="button" value="Remove" class="io_button io_before" onclick="add_input(this)">
														</span>
														<ul>		<table class="demand" width=80%>
																	<tr><td align="left" width=20%><span class="excelLabel">excel range </span></td>
																		<td align="left" rowspan="2" width=80%><span class="ts1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.      
																		</span></td>
																	</tr>
																	<tr><td align="left"><span contenteditable class="excelRange editable">F20:AO20</span></td> 
																	</tr>
																</table>
														</ul>											
											</li>
											
											
										</ul>												
								</li>
							</ul>
						</li>
						
					</ul>
				</li>
				
			</ul>	    
		</div>
    </div>
   </div>


    <div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"> <a data-toggle="collapse" href="#RESViewer">RES</a>  </h4>
		</div>
 
		<div id="RESViewer" class="panel-collapse collapse in">
			<div class="panel-body">
				<button class="pure-button pure-button-primary" onclick="draw_res(this)">Draw RES</button>
				 <span> RES supports pan and zoom, and you can move technology. </span>
				<div id="svgContainer">
	<!--		<svg  id="RES" width="2000" height="2000" xmlns="http://www.w3.org/2000/svg">
						<defs>
							<marker id="markerArrow" markerWidth="12" markerHeight="12" refX="2" refY="5" orient="auto">
								<path d="M2,2 L2,8 L8,5 L2,2" style="fill: #000000;" />
							</marker>
						</defs>
					
						<g transform="translate(50,200)">
							<g transform="translate(0,0)">
								<rect class="tech"  x="0" y="0" width="100" height="30"/>
								<text class="tech"  x="50" y="19">oil</text>								
								<g>
									<rect class="tech_id"  x="0" y="0" width="15" height="15"/>
									<text class="tech_id"  x="7.5" y="10">1</text>
								</g>
								<g transform="translate(100,0)">
									<line x1="0" y1="15" x2="42" y2="15" stroke="#000" stroke-width="1" marker-end="url(#markerArrow)" />
									<text class="arrow_label"  x="15" y="10">1</text>
								</g>
							</g>
							<g transform="translate(0,100)">
								<rect class="tech"  x="0" y="0" width="100" height="30"/>
								<text class="tech"  x="50" y="19">bio ethanol</text>								
								<g>
									<rect class="tech_id"  x="0" y="0" width="15" height="15"/>
									<text class="tech_id"  x="7.5" y="10">2</text>
								</g>
								<g transform="translate(100,0)">
									<line x1="0" y1="15" x2="57" y2="15" stroke="#000" stroke-width="1" marker-end="url(#markerArrow)" />
									<text class="arrow_label"  x="15" y="10">1</text>
								</g>
							</g>
							<g transform="translate(0,200)">
								<rect class="tech"  x="0" y="0" width="100" height="30"/>
								<text class="tech"  x="50" y="19">electricity</text>								
								<g>
									<rect class="tech_id"  x="0" y="0" width="15" height="15"/>
									<text class="tech_id"  x="7.5" y="10">3</text>
								</g>
								<g transform="translate(100,0)">
									<line x1="0" y1="15" x2="72" y2="15" stroke="#000" stroke-width="1" marker-end="url(#markerArrow)" />
									<text class="arrow_label"  x="15" y="10">1</text>
								</g>
							</g>
						</g>
						
						<g transform="translate(200,30)">
							<text class="el"  x="0" y="0">energy(1)</text>
							<g transform="translate(0,15)">
								<text class="ef"  x="0" y="0">oil(1)</text>
								<line class="ef"  x1="0" y1="5" x2="0" y2="560"/>
							</g>
							<g transform="translate(15,30)">
								<text class="ef"  x="0" y="0">bio ethanol(2)</text>
								<line class="ef"  x1="0" y1="5" x2="0" y2="560"/>
							</g>
							<g transform="translate(30,45)">
								<text class="ef"  x="0" y="0">electricity(3)</text>
								<line class="ef"  x1="0" y1="5" x2="0" y2="560"/>
							</g>
						</g>
						
						<g transform="translate(300,200)">
							<g transform="translate(0,100)">
								<rect class="tech"  x="0" y="0" width="100" height="30"/>
								<text class="tech"  x="50" y="19">oil</text>								
								<g>
									<rect class="tech_id"  x="0" y="0" width="15" height="15"/>
									<text class="tech_id"  x="7.5" y="10">1</text>
								</g>
								<g>
									<g transform="translate(100,0)">
										<line x1="0" y1="15" x2="92" y2="15" stroke="#000" stroke-width="1" marker-end="url(#markerArrow)" />
										<text class="arrow_label"  x="40" y="10">1</text>
									</g>
									<g transform="translate(-85,0)">
										<line x1="0" y1="5" x2="77" y2="5" stroke="#000" stroke-width="1" marker-end="url(#markerArrow)" />
										<text class="arrow_label"  x="45" y="0">1</text>
									</g>
									<g transform="translate(-70,0)">
										<line x1="0" y1="25" x2="62" y2="25" stroke="#000" stroke-width="1" marker-end="url(#markerArrow)" />
										<text class="arrow_label"  x="30" y="20">1</text>
									</g>
								</g>
							</g>
						</g>
						
						<g transform="translate(500,30)">
							<text class="el"  x="0" y="0">blended energy(2)</text>
							<g transform="translate(0,15)">
								<text class="ef"  x="0" y="0">bio ethanol(1)</text>
								<line class="ef"  x1="0" y1="5" x2="0" y2="560"/>
							</g>
						</g>

					</svg>-->
				</div>
			</div>
		</div>
	</div>				
   
   
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"> <a data-toggle="collapse" href="#varTree">Variable/Constraint</a>  </h4>
		</div>
 
		<div id="varTree" class="panel-collapse collapse in">
			<div class="panel-body">
				<button class="pure-button pure-button-primary" onclick="save_var(this)">Save Variables</button>			
			
				<ul>
					<li class="varLi ef"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px">variables</span>
										<span class="math">...</span>
						<ul id="tree_for_variable">
							<li class="var"> 
											<span contenteditable class="name editable" style="margin-right:10px;">dummy1</span>	
											LaTeX <span contenteditable class="teXeq editable">v_1</span>	
											<span class="label">v_id</span><span class="id">1</span>
											<span class="label">ts</span><input type="checkbox" name="is_ts_var"/>
											<span class="math equation">v_i^t, t=2015,2016,\cdots,2050</span>
										<span class="aligh_button">
											<input type="button" value="Add" class="ef_button ef_after" onclick="add_var(this)">
											<input type="button" value="Remove" class="ef_button" onclick="remove_var(this)">
										</span>
										
										
							</li>
						</ul>
					</li>
				</ul>
				
				
				<button class="pure-button pure-button-primary" onclick="save_const(this)">Save Constraints</button>			
			
				<ul>
					<li id="short_type1_constaintLi" class="el"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px">Type 1(lower bound/upper bound/equal)</span>
						<ul id="short_type1_constaintUl">
							<li class="short_type1 constraint ef" style="margin-bottom:20px;"> 
									<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
									<span class="label" style="font-weight:normal;font-size:15px;">Constraint for activity/input</span>								
									<span class="select_menu context-menu-two btn btn-neutral">select technolgies and variables
										<i class="fa fa-caret-square-o-right"  style="font-size:12px;"></i>
									</span>
									<ul>
										<table width="80%" style="margin-left:40px;margin-top:10px;font-size:10px;">
										<thead>
										<tr><td align="left" style="min-width:140px;border-right:1px solid black;">technology</td>
											<td style="border-right:1px solid black; border-bottom:1px solid black;" colspan="2">lower bound
												<span class="type1TexEq lbound"  style="font-weight:normal;margin-left:3px;">...</span>
											</td>
											<td style="border-right:1px solid black;border-bottom:1px solid black;" colspan="2">upper bound
												<span class="type1TexEq ubound"  style="font-weight:normal;margin-left:3px;">...</span>
											</td>
											<td style="border-bottom:1px solid black;" colspan="3">equal
												<span class="type1TexEq eqbound"  style="font-weight:normal;margin-left:3px;">...</span>
											</td>
										 </tr>
										</thead>
										<tbody>
										<tr style="border-bottom:1px solid black;"><td align="left" style="border-right:1px solid black;">name</td>
											<td>RHS</td>
											<td style="border-right:1px solid black;">add to LP</td>
											<td>RHS</td>
											<td style="border-right:1px solid black;">add to LP</td>
											<td>year
												<span id="short1_year" class="type1TexEq"  style="font-weight:normal;margin-left:3px;">...</span>
												<script>
													katex.render("\\displaystyle (T' \\subseteq T)", short1_year);
												</script> 											
											</td>
											<td>RHS</td>
											<td>add to LP</td>
										 </tr>
										<tr><td align="left" class="techVarName" style="border-right:1px solid black;">middle(5)</td>
											<td><span class="excelRange" contenteditable>f1</span></td>
											<td style="border-right:1px solid black;"><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td style="border-right:1px solid black;"><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
										</tr>
										<tr><td align="left" class="techVarName" style="border-right:1px solid black;">plug-in(6)/city(1)</td>
											<td><span class="excelRange" contenteditable>f1</span></td>
											<td style="border-right:1px solid black;"><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td style="border-right:1px solid black;"><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
										</tr>
										<tr><td align="left" class="techVarName" style="border-right:1px solid black;">elec car(7)</td>
											<td><span class="excelRange" contenteditable>f1</span></td>
											<td style="border-right:1px solid black;"><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td style="border-right:1px solid black;"><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td><span class="excelRange" contenteditable>f5</span></td>
											<td><input name="addToLP" style="margin-left:1px;" type="checkbox"></td>
										</tr>
										</tbody>
										</table>
									</ul>
							</li>
						</ul>
					</li>
				
					
					<li id="type1_constaintLi" class="el"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px">Type 1(yearly)</span>
									   <span class="titleTexEq"  style="font-weight:normal;margin-left:15px;">...</span>									  
						<ul id="type1_constaintUl">
							<li class="constraint ef"> 
								<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
								<span contenteditable class="name editable">car efficiency</span>
								<span class="label" style="font-weight:normal;">c1_id</span><span class="id">1</span>								
									<label style="font-weight:normal;margin-left:15px;">add to LP
										<input name="addToLP" style="margin-left:1px;" type="checkbox">
									</label>								
									<span class="aligh_button">
										<input type="button" value="Add" class="ef_button ef_after" onclick="add_type1(this)">
										<input type="button" value="Remove" class="ef_button" onclick="remove_type1(this)">
									</span>
								<ul>
								<!--<form id="c1_id1">-->
								<form>
									<span class="select_menu context-menu-two btn btn-neutral">select technolgies and variables
										<i class="fa fa-caret-square-o-right"  style="font-size:12px;"></i>
									</span>
										<span class="excelLabel">matrix excel range </span>
										<span contenteditable class="excelMatrixRange editable" data-type="excelMatrixRange">F35:AO38</span> 
									<ul>
										<span class="checkGroup">
											<label  style="font-weight:normal;margin-left:15px;" class="pure-radio">
												<input type="radio" name="activityOrCapacity" value="activity" checked>
												activity
											</label>
											<label style="font-weight:normal;" class="pure-radio">
												<input type="radio" name="activityOrCapacity" value="capacity">
												capacity
											</label>
										</span>
										<span class="checkGroup">
											<label style="font-weight:normal;margin-left:15px;" class="pure-radio">
												<input type="radio" name="ioRadio" value="input" checked>
												input
											</label>
											<label style="font-weight:normal;" class="pure-radio">
												<input type="radio" name="ioRadio" value="output">
												output
											</label>
										</span>
										<span class="checkGroup" style="margin-left:10px;"> 
											<label style="font-weight:normal;margin-left:15px;" class="pure-radio">
												<input type="radio" name="eqType" value="le" checked>
												<span style="margin-right:10px;">&le;</span>
											</label>
											<label style="font-weight:normal;" class="pure-radio" style="margin-left:15px;">
												<input type="radio" name="eqType" value="eq">
												<span style="margin-right:10px;">=</span>											
											</label>
											<label style="font-weight:normal;" class="pure-radio" style="margin-left:15px;">
												<input type="radio" name="eqType" value="ge">
												<span style="margin-right:10px;">&ge;</span>											
											</label>
										</span>
										
										<!--<input type="button" value="Reload" class="ef_button ef_matrix_reload" onclick="reload_matrix_range(this)">-->
										<table width="80%" class="histCap paramMatrix" style="margin-left:40px;margin-top:10px;"><tbody>
										<tr><td align="left" style="font-size:1.2em;">technology</td><td style="font-size:1.2em;">variable</td>
										      <td>2015(t=1)</td>	<td>2016(t=2)</td>	<td>2017(t=3)</td>	<td>2018(t=4)</td>	<td>2019(t=5)</td>	<td>2020(t=6)</td>	<td>2021(t=7)</td>	<td>2022(t=8)</td>	<td>2023(t=9)</td>	<td>2024(t=10)</td>	<td>2025(t=11)</td>	<td>2026(t=12)</td>	<td>2027(t=13)</td>	<td>2028(t=14)</td>	<td>2029(t=15)</td>	<td>2030(t=16)</td>	<td>2031(t=17)</td>	<td>2032(t=18)</td>	<td>2033(t=19)</td>	<td>2034(t=20)</td>	<td>2035(t=21)</td>	<td>2036(t=22)</td>	<td>2037(t=23)</td>	<td>2038(t=24)</td>	<td>2039(t=25)</td>	<td>2040(t=26)</td>	<td>2041(t=27)</td>	<td>2042(t=28)</td>	<td>2043(t=29)</td>	<td>2044(t=30)</td>	<td>2045(t=31)</td>	<td>2046(t=32)</td>	<td>2047(t=33)</td>	<td>2048(t=34)</td>	<td>2049(t=35)</td>	<td>2050(t=36)</td>										  
										 </tr>
										<tr><td align="left" class="techVarName">middle(5)</td><td><span class="math equation">x_5^t</span></td><td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td></tr>
										<tr><td align="left" class="techVarName">plug-in(6)/city(1)</td><td><span class="math equation">x_{(6,1)}^t</span></td><td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td></tr>
										<tr><td align="left" class="techVarName">variable/dummy1(1)</td><td><span class="math equation">z_1^t</span></td><td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td></tr>
										<tr><td align="left" class="techVarName">RHS</td><td><span class="math equation">b^t</span></td><td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td></tr>
										</tbody></table>
									</ul>
								</form>	
								</ul>
							</li>
						</ul>
					</li>
					<li id="type2_constaintLi" class="el"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px" class="constTypeName">Type 2(cummulative)</span>
									   <span id="mykatex2" class="titleTexEq"  style="font-weight:normal;margin-left:15px;">...</span>									
						<ul id="type2_constaintUl">
						</ul>
					</li>
					<li id="type3_constaintLi" class="el"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px">Type 3(time series)</span>
									   <span class="titleTexEq"  style="font-weight:normal;margin-left:15px;">...</span>									  
						<ul id="type3_constaintUl">
							<li class="constraint ef"> 
								<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
								<span contenteditable class="name editable">middle prodcution</span>
								<span class="label" style="font-weight:normal;">c3_id</span><span class="id">1</span>								
									<label style="font-weight:normal;margin-left:15px;">add to LP
										<input name="addToLP" style="margin-left:1px;" type="checkbox">
									</label>								
									<span class="aligh_button">
										<input type="button" value="Add" class="ef_button ef_after" onclick="add_type1(this)">
										<input type="button" value="Remove" class="ef_button" onclick="remove_type1(this)">
									</span>
								<ul>
									<!--<form id="c3_id1">-->
									<form>
										<span class="select_menu context-menu-two btn btn-neutral">select technolgies and variables
											<i class="fa fa-caret-square-o-right"  style="font-size:12px;"></i>
										</span>
											<span class="excelLabel">matrix excel range </span>
											<span contenteditable class="excelMatrixRange editable" data-type="excelMatrixRange">F35:AO38</span> 
										<ul>
											<span class="checkGroup">
												<label  style="font-weight:normal;margin-left:15px;" class="pure-radio">
													<input type="radio" name="activityOrCapacity" value="activity" checked>
													activity
												</label>
												<label style="font-weight:normal;" class="pure-radio">
													<input type="radio" name="activityOrCapacity" value="capacity">
													capacity
												</label>
											</span>
											<span class="checkGroup">
												<label style="font-weight:normal;margin-left:15px;" class="pure-radio">
													<input type="radio" name="ioRadio" value="input" checked>
													input
												</label>
												<label style="font-weight:normal;" class="pure-radio">
													<input type="radio" name="ioRadio" value="output">
													output
												</label>
											</span>
											<span class="checkGroup" style="margin-left:10px;"> 
												<label style="font-weight:normal;margin-left:15px;" class="pure-radio">
													<input type="radio" name="eqType" value="le" checked>
													<span style="margin-right:10px;">&le;</span>
												</label>
												<label style="font-weight:normal;" class="pure-radio" style="margin-left:15px;">
													<input type="radio" name="eqType" value="eq">
													<span style="margin-right:10px;">=</span>											
												</label>
												<label style="font-weight:normal;" class="pure-radio" style="margin-left:15px;">
													<input type="radio" name="eqType" value="ge">
													<span style="margin-right:10px;">&ge;</span>											
												</label>
											</span>
											
											<!--<input type="button" value="Reload" class="ef_button ef_matrix_reload" onclick="reload_matrix_range(this)">-->
											<table width="80%" class="histCap paramMatrix" style="margin-left:40px;margin-top:10px;"><tbody>
											<tr><td align="left" style="font-size:1.2em;">technology</td>
													<td align="center" style="font-size:1.2em;"><span  style="display:inline;" class="math equation">|S_i|</span></td>
													<td align="center" style="font-size:1.2em;"><span  style="display:inline;" class="math equation">S_i</span></td>
													<td colspan="2"  align="center" style="font-size:1.2em;">initial</td>
													<td style="font-size:1.2em;">variable</td>
											      <td>2015(t=1)</td>	<td>2016(t=2)</td>	<td>2017(t=3)</td>	<td>2018(t=4)</td>	<td>2019(t=5)</td>	<td>2020(t=6)</td>	<td>2021(t=7)</td>	<td>2022(t=8)</td>	<td>2023(t=9)</td>	<td>2024(t=10)</td>	<td>2025(t=11)</td>	<td>2026(t=12)</td>	<td>2027(t=13)</td>	<td>2028(t=14)</td>	<td>2029(t=15)</td>	<td>2030(t=16)</td>	<td>2031(t=17)</td>	<td>2032(t=18)</td>	<td>2033(t=19)</td>	<td>2034(t=20)</td>	<td>2035(t=21)</td>	<td>2036(t=22)</td>	<td>2037(t=23)</td>	<td>2038(t=24)</td>	<td>2039(t=25)</td>	<td>2040(t=26)</td>	<td>2041(t=27)</td>	<td>2042(t=28)</td>	<td>2043(t=29)</td>	<td>2044(t=30)</td>	<td>2045(t=31)</td>	<td>2046(t=32)</td>	<td>2047(t=33)</td>	<td>2048(t=34)</td>	<td>2049(t=35)</td>	<td>2050(t=36)</td>										  
											 </tr>
											<tr><td align="left" class="techVarName">middle(5)</td>
												<td><span contenteditable class="noOfS_i editable cost">5</span></td>
												<td><span contenteditable class="S_i editable cost">-1</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">x_5^{0}=</span></td>
												<td><span contenteditable   style="display:inline;" class="initVarValue editable cost">0:20000</span></td>
												<td><span class="math equation">t</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">middle(5)</td>
												<td></td>
												<td><span contenteditable class="S_i editable cost">0</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">x_5^{-1}=</span></td>
												<td><span contenteditable  style="display:inline;" class="initVarValue editable cost"></span></td>
												<td><span class="math equation">t-1</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">middle(5)</td>
												<td></td>
												<td><span contenteditable class="S_i editable cost">1</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">x_5^{-1}=</span></td>
												<td><span contenteditable  style="display:inline;" class="initVarValue editable cost"></span></td>
												<td><span class="math equation">t-1</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">middle(5)</td>
												<td></td>
												<td><span contenteditable class="S_i editable cost">2</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">x_5^{-1}=</span></td>
												<td><span contenteditable  style="display:inline;" class="initVarValue editable cost"></span></td>
												<td><span class="math equation">t-1</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">middle(5)</td>
												<td></td>
												<td><span contenteditable class="S_i editable cost">3</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">x_5^{-1}=</span></td>
												<td><span contenteditable  style="display:inline;" class="initVarValue editable cost"></span></td>
												<td><span class="math equation">t-1</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">plug-in(6)/city(1)</td>
												<td><span contenteditable class="noOfS_i editable cost">1</span></td>
												<td><span contenteditable class="S_i editable cost">0</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">x_{(6,1)}^{0}=</span></td>
												<td><span contenteditable   style="display:inline;" class="initVarValue editable cost">0:20000</span></td>
												<td><span class="math equation">t</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">variable/dummy1(1)</td>
												<td><span contenteditable class="noOfS_i editable cost">1</span></td>
												<td><span contenteditable class="S_i editable cost">0</span></td>
												<td style="min-width:30px;max-width:50px;"><span  style="display:inline;" class="math equation">z_1^0=</span></td>
												<td><span contenteditable  style="display:inline;" class="initVarValue editable cost">0:100</span></td>
												<td><span class="math equation">z^t</span></td>
												<td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td>
											</tr>
											<tr><td align="left" class="techVarName">RHS</td><td></td><td></td><td  style="min-width:30px;max-width:50px;"></td><td></td><td><span class="math equation">b^t</span></td><td style="border: 1px solid black; border-image: none;">84212.38784</td><td style="border: 1px solid black; border-image: none;">84967.17824</td><td style="border: 1px solid black; border-image: none;">85721.96864</td><td style="border: 1px solid black; border-image: none;">86476.75904</td><td style="border: 1px solid black; border-image: none;">87231.54944</td><td style="border: 1px solid black; border-image: none;">87986.33984</td><td style="border: 1px solid black; border-image: none;">88440.4224</td><td style="border: 1px solid black; border-image: none;">88894.50496</td><td style="border: 1px solid black; border-image: none;">89348.58752</td><td style="border: 1px solid black; border-image: none;">89802.67008</td><td style="border: 1px solid black; border-image: none;">90256.73216</td><td style="border: 1px solid black; border-image: none;">90353.23392</td><td style="border: 1px solid black; border-image: none;">90449.73568</td><td style="border: 1px solid black; border-image: none;">90546.23744</td><td style="border: 1px solid black; border-image: none;">90642.7392</td><td style="border: 1px solid black; border-image: none;">90739.23072</td><td style="border: 1px solid black; border-image: none;">90797.8752</td><td style="border: 1px solid black; border-image: none;">90856.51968</td><td style="border: 1px solid black; border-image: none;">90915.16416</td><td style="border: 1px solid black; border-image: none;">90973.80864</td><td style="border: 1px solid black; border-image: none;">91032.46336</td><td style="border: 1px solid black; border-image: none;">90703.59552</td><td style="border: 1px solid black; border-image: none;">90374.72768</td><td style="border: 1px solid black; border-image: none;">90045.85984</td><td style="border: 1px solid black; border-image: none;">89716.992</td><td style="border: 1px solid black; border-image: none;">89388.11392</td><td style="border: 1px solid black; border-image: none;">88714.5472</td><td style="border: 1px solid black; border-image: none;">88040.98048</td><td style="border: 1px solid black; border-image: none;">87367.41376</td><td style="border: 1px solid black; border-image: none;">86693.84704</td><td style="border: 1px solid black; border-image: none;">86020.25984</td><td style="border: 1px solid black; border-image: none;">85194.86464</td><td style="border: 1px solid black; border-image: none;">84369.46944</td><td style="border: 1px solid black; border-image: none;">83544.07424</td><td style="border: 1px solid black; border-image: none;">82718.67904</td><td style="border: 1px solid black; border-image: none;">81893.27872</td></tr>
										</tbody></table>
										</ul>
									</form>	
								</ul>
							</li>
						</ul>
					</li>
					
					
				</ul>
				
				
			</div>
		</div>
	</div>
   
   
   
  </div>  
 </div>
			<!--	<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
						70%
					</div>
				</div>-->
<div id="lp" class="container">
<h1>LP</h1>
 <div class="panel-group">
   <div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"> <a data-toggle="collapse" href="#lptreeviewer">LP generation/Get Optimal</a>  </h4>
		</div>
 
		<div id="lptreeviewer" class="panel-collapse collapse in">
			<div class="panel-body">
<!--				<button id="generateLPButton" class="pure-button pure-button-primary">Generate LP treeviewer</button>-->
				<button id="generateLPButton" class="pure-button pure-button-primary" onclick="generate_lp_treeviewer(this)">Generate LP treeviewer</button>
				<button class="pure-button pure-button-primary" onclick="get_lp_optimal(this)">Get LP optimal</button>
					<progress id="html5progressbar" value="0" max="100"></progress>
					<br>
				<ul>
					<li class="ef"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px">objective function : </span>
										<span class="math">...</span>
						<ul id="lpObjUl">
							<li> 
								<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
									Investment cost : <span class="math">...</span>
									<ul>
									    <li> i=5
									    <li> i=5
									    <li> i=5
									</ul>
										
										
							</li>
							<li> 
								<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
									<span class="math">Fixed cost</span>
									<ul>
									    <li> i=5
									    <li> i=5
									    <li> i=5
									</ul>
										
										
							</li>
						</ul>
					</li>
					<li id="lpConstraintLi"><span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
							<span style="font-size:15px;">Constraints <span class="math">...</span></span>
						<ul id="lpConstraintUl">
							<li class="ef"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
							                   <span style="font-size:15px;margin-left:10px" class="const_name">Capacity Constraint : </span>
												<span class="math">...</span>
								<ul class="cap_ul">
									<li class="i_li"> 
										<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
											<span class="math">i=5</span>
										<ul class="i_ul">
											<li class="t_li"> t=1
											<li> t=2
										</ul>
										
												
									</li>
								</ul>
							</li>
							
							<li class="ef"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
							                   <span style="font-size:15px;margin-left:10px" class="const_name">Flow Conservation Constraint : </span>
												<span class="math">...</span>
								<ul class="flow_ul">
									<li class="i_li"> 
										<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
											<span class="math">j=1</span>
										<ul class="i_ul">
											<li class="t_li"> t=1
											<li> t=2
										</ul>
										
												
									</li>
								</ul>
							</li>
							
						</ul>
					</li>
				</ul>
				<div><h1> optimal status </h1>
					<pre id="log">ppp</pre>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
 

<div id="lp" class="container">
<h1>Optimal</h1>
 
    <div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"> <a data-toggle="collapse" href="#solTree">View Optimal Solutions</a>  </h4>
		</div>
 
		<div id="solTree" class="panel-collapse collapse in">
			<div class="panel-body">
				<button class="pure-button pure-button-primary" onclick="populate_solution(this)">Read Optimal</button>			
				<button class="pure-button pure-button-primary" onclick="save_opt_to_excel(this)">Save Optimal to Excel</button>			
				<h3>Objective value = <span id="objValue">0.000</span></h3>
				<ul>				
					<li id="solutionTopLi" class="el"> <span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
					                   <span style="font-size:15px;margin-left:10px">View Solutions</span>
						<ul id="solutionUl">
							<li class="constraint ef"> 
								<span class="bullet"><i class="fa fa-minus-circle" style="color:green"></i></span>
								<span contenteditable class="name editable">car km</span>								
									<label style="font-weight:normal;margin-left:15px;">add to Excel
										<input name="addToExcel" style="margin-left:1px;" type="checkbox">
									</label>								
									<span class="aligh_button">
										<input type="button" value="Add" class="ef_button ef_after" onclick="add_sol(this)">
										<input type="button" value="Remove" class="ef_button" onclick="remove_sol(this)">
									</span>
								<ul>
								<!--<form id="c1_id1">-->
									<form>
										<span class="select_menu context-menu-two btn btn-neutral">select technolgies and variables
											<i class="fa fa-caret-square-o-right"  style="font-size:12px;"></i>
										</span>
											<span class="excelLabel">target excel range</span>
											<span contenteditable class="excelSolutionAddress editable" data-type="excelSolutionAddress">A1</span> 
										<ul>
											<span class="checkGroup">
												<label  style="font-weight:normal;margin-left:15px;" class="pure-radio">
													<input type="radio" name="activityOrCapacity" value="activity" checked>
													activity
												</label>
												<label style="font-weight:normal;" class="pure-radio">
													<input type="radio" name="activityOrCapacity" value="capacity">
													capacity
												</label>
											</span>
											<span class="checkGroup">
												<label style="font-weight:normal;margin-left:15px;" class="pure-radio">
													<input type="radio" name="ioRadio" value="input" checked>
													input
												</label>
												<label style="font-weight:normal;" class="pure-radio">
													<input type="radio" name="ioRadio" value="output">
													output
												</label>
											</span>
											<span class="checkGroup" style="margin-left:10px;"> 
												<label style="font-weight:normal;" class="pure-radio" style="margin-left:15px;">
													<input type="radio" name="capType" value="newCap">
													<span style="margin-right:10px;">new capacity</span>											
												</label>
												<label style="font-weight:normal;margin-left:15px;" class="pure-radio">
													<input type="radio" name="capType" value="allCap" checked>
													<span style="margin-right:10px;">all capacity</span>
												</label>
											</span>
											
											<!--<input type="button" value="Reload" class="ef_button ef_matrix_reload" onclick="reload_matrix_range(this)">-->
											<table width="80%" class="histCap paramMatrix" style="margin-left:40px;margin-top:10px;"><tbody>
											<tr><td align="left" style="font-size:1.2em;">technology</td><td style="font-size:1.2em;">variable</td>
											      <td>2015(t=1)</td>	<td>2016(t=2)</td>	<td>2017(t=3)</td>	<td>2018(t=4)</td>	<td>2019(t=5)</td>	<td>2020(t=6)</td>	<td>2021(t=7)</td>	<td>2022(t=8)</td>	<td>2023(t=9)</td>	<td>2024(t=10)</td>	<td>2025(t=11)</td>	<td>2026(t=12)</td>	<td>2027(t=13)</td>	<td>2028(t=14)</td>	<td>2029(t=15)</td>	<td>2030(t=16)</td>	<td>2031(t=17)</td>	<td>2032(t=18)</td>	<td>2033(t=19)</td>	<td>2034(t=20)</td>	<td>2035(t=21)</td>	<td>2036(t=22)</td>	<td>2037(t=23)</td>	<td>2038(t=24)</td>	<td>2039(t=25)</td>	<td>2040(t=26)</td>	<td>2041(t=27)</td>	<td>2042(t=28)</td>	<td>2043(t=29)</td>	<td>2044(t=30)</td>	<td>2045(t=31)</td>	<td>2046(t=32)</td>	<td>2047(t=33)</td>	<td>2048(t=34)</td>	<td>2049(t=35)</td>	<td>2050(t=36)</td>										  
											 </tr>
											</tbody></table>
										</ul>
									</form>	
								</ul>
							</li>
						</ul>
					</li>
					
					
				</ul>
				
				
			</div>
		</div>
	</div>
</div>   

 
 
<div id="viewers" class="container">
<h1>Viewers</h1>
 <div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading"  id="JSONheader">
      <h4 class="panel-title">
        <a data-toggle="collapse"  href="#JSONclient" >View JSON editor : save button for updated json</a>
      </h4>
    </div>
    <div id="JSONclient" class="panel-collapse collapse in">
		<div class="panel-body">
			<h3> json editor with file : <span id="jsonSpan"> </span></h3>
			<div id="jsoneditor"></div>
	     </div>
    </div>
  </div>
 </div> 

 
</div> 

</body>
</html>
