var json;
$(document).ready(function (e) {
	console.log("ready1: ");

	readDB();
	populateBOM_TreeTable();
	expand_collapse_TreeTable();
});

$(document).on('click', '.editable', function() {
	var range, selection;
	if (window.getSelection && document.createRange) {
		selection = window.getSelection();
		range = document.createRange();
		range.selectNodeContents(this);
		selection.removeAllRanges();
		selection.addRange(range);
	} else if (document.selection && document.body.createTextRange) {
		range = document.body.createTextRange();
		range.moveToElementText(this);
		range.select();
	}
});

var cc=0;
var findChildren = function (tr) {
        var depth = tr.data('depth');
        var x=tr.nextUntil(function (){
			return parseInt($(this).attr('data-depth'))<= depth;   // 'return true' is continue, 'return false' is exit
        });		
        return x;		
};
$(document).on('click', '#BOM_table .toggle', function () {
        var el = $(this);
        var tr = el.closest('tr'); //Get <tr> parent of toggle button
        var children = findChildren(tr);

        //Remove already collapsed nodes from children so that we don't
        //make them visible. 
        //(Confused? Remove this code and close Item 2, close Item 1 
        //then open Item 1 again, then you will understand)
        var subnodes = children.filter('.tbexpand');
        subnodes.each(function () {
            var subnode = $(this);
            var subnodeChildren = findChildren(subnode);
            children = children.not(subnodeChildren);
        });

        //Change icon and hide/show children
        if (tr.hasClass('tbcollapse')) {
            tr.removeClass('tbcollapse').addClass('tbexpand');
            children.hide();
        } else {
            tr.removeClass('tbexpand').addClass('tbcollapse');
            children.show();
        }
        return children;
});

function get_json_from_mongodb(urlname){
//	alert('ready: ' + jsonFileName);
    $.ajax({
		type: "GET",
        async: false,
		url: urlname, 
        dataType: "json",
        success: function(data) {
	        from_ajax_data=data;
         //   console.log(data);
			//alert(jsonFileName + " read success");
        },
	    error: function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
	    }
    }).done(function(msg){
		//alert(jsonFileName + " read OK!: ");
    });
}
function CRUD_io_to_mongodb(urlname,to_db){
    $.ajax({
        type: "POST",
 		cache:false,
        async: false,
        url: urlname,
		data: {data: JSON.stringify(to_db)},
		dataType: 'json',
        success: function(data) {		 
		  console.log('mongodb update success: ',data); 
		  json=data;
		 // json=JSON.parse(data);
        },
        error: 	function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error)}
	}).done(function( msg ) {
        console.log(" msg : " + msg );
	//	alert("Data Saved: " + modelJsonFileName + " msg : " + msg);
    });	
}


function readDB(){
	var urlname='http://localhost/RES2/MES/mongo_read_collection.php?collection=master';
	get_json_from_mongodb(urlname);	  
	BOM_master=from_ajax_data;
//	console.log(BOM_master);
	urlname='http://localhost/RES2/MES/mongo_read_collection.php?collection=transaction';
	get_json_from_mongodb(urlname);	  
	BOM_transaction=from_ajax_data;
//	console.log(BOM_transaction);
};
function populateBOM_TreeTable(){
	$("#BOM_table").find('tbody>tr').remove();
	var cur_tr=$("#BOM_table").find('tr').eq(0);
	var loc=0;
	var node_state;

	for (var i = 0; i < BOM_master.length; i++){
		var first_tr=$(cur_tr);
		var level0=BOM_master[i];
		node_state=(level0.state=='collpased')?'tbexpand':'tbcollapse';
		$(cur_tr).after('<tr data-depth="0" class="'+node_state+' level0">'
					   +'<td><span class="toggle"></span><span contenteditable class="name editable">'+level0.name+'</span></td>'
					   +'<td><span contenteditable class="id editable">'+level0.l_id+'</span></td>'
                       +'   <td></td><td></td><td></td>'
					   +'<td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>'
					   +'<td><input type="button" value="Remove" class="l_button" onclick="remove_lm(this)"></td>'
                     +'</tr>');
		cur_tr=$(cur_tr).next();
		for (var j=0;j<level0.sub.length;j++){
			var level1=level0.sub[j];
			node_state=(level1.state=='collapsed')?'tbexpand':'tbcollapse';
			var disabled='';
			if (level0.sub.length==1) disabled='disabled';
            $(cur_tr).after('<tr data-depth="1" data-l_id="'+level0.l_id+'" class="'+node_state+' level1">'
							+'<td><span class="toggle"></span><span contenteditable class="name editable">'+level1.name+'</span></td>'
							+'<td><span contenteditable class="id editable">'+level1.m_id+'</span></td>'
							+'<td>'+level1.unit+'</td><td>'+level1.quantity+'</td><td></td>'
							+'<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>'
							+'<td><input type="button" value="Remove" class="m_button" onclick="remove_lm(this)" '+disabled+'></td>'
						  +'</tr>');
			cur_tr=$(cur_tr).next();
			if (BOM_transaction[loc].BOM_id==(level0.l_id+'@'+level1.m_id)){
                 $(cur_tr).after('<tr data-depth="2" class="level2 tr_inventory">'
                        		+'     <td>재고량</td>'
                        		+'      <td></td><td></td><td></td>'
                        		+'     <td><span class="inventory">'+BOM_transaction[loc].inventory+'</span></td>'
                        		+' </tr>');
				cur_tr=$(cur_tr).next();
				node_state=(BOM_transaction[loc].state[0]=='collapsed')?'tbexpand':'tbcollapse';
                $(cur_tr).after('<tr data-depth="2" class="'+node_state+' level2 tr_input">'
								+'	   <td><span class="toggle"></span>입고('+BOM_transaction[loc].BOM_id+')</td>	'					 
                        		+'     <td></td>'
								+'       <td></td><td></td><td></td>'
								+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
                        		+' </tr>');
				cur_tr=$(cur_tr).next();
				for (var k=0;k<BOM_transaction[loc].input.length;k++){
					var cur=BOM_transaction[loc].input[k];
					var now = new Date(cur.date.sec*1000);
					var dateTime=getWorldTime(now,+0).split(' ');

                    $(cur_tr).after('    <tr data-depth="3" class="tbcollapse level3">'
                        			+'     <td><input type="date" value="'+dateTime[0]+'"></td>'
                            		+'      <td></td><td></td><td></td>'
                        			+'     <td><span contenteditable class="quantity editable">'+cur.quantity+'</span></td>'
									+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
						    		+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>'
									+'</tr>');
					cur_tr=$(cur_tr).next();
				}				
 				node_state=(BOM_transaction[loc].state[1]=='collapsed')?'tbexpand':'tbcollapse';
                $(cur_tr).after('<tr data-depth="2" class="'+node_state+' level2 tr_output">'
								+'	   <td><span class="toggle"></span>출고('+BOM_transaction[loc].BOM_id+')</td>	'					 
                        		+'     <td></td>'
								+'       <td></td><td></td><td></td>'
								+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
                        		+' </tr>');
				cur_tr=$(cur_tr).next();
				for (var k=0;k<BOM_transaction[loc].output.length;k++){
					var cur=BOM_transaction[loc].output[k];
					var now = new Date(cur.date.sec*1000);
					var dateTime=getWorldTime(now,+0).split(' ');

                    $(cur_tr).after('    <tr data-depth="3" class="tbcollapse level3">'
                        			+'     <td><input type="date" value="'+dateTime[0]+'"></td>'
                            		+'      <td></td><td></td><td></td>'
                        			+'     <td><span contenteditable class="quantity editable">'+cur.quantity+'</span></td>'
									+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
						    		+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>'
									+'</tr>');
					cur_tr=$(cur_tr).next();
				}				
				loc++;
   			}else{
				alert('mongo db error! loc=' + loc);
			}
			
		}
	}	
}

function expand_collapse_TreeTable(){
	var tr_expands=$('#BOM_table').find('tr.tbexpand');
    tr_expands.filter('.level2').each(function(){
         var subnode = $(this);
         var subnodeChildren = findChildren(subnode);
		subnodeChildren.hide();
	});
    tr_expands.filter('.level1').each(function(){
         var subnode = $(this);
         var subnodeChildren = findChildren(subnode);
		subnodeChildren.hide();
	});
    tr_expands.filter('.level0').each(function(){
         var subnode = $(this);
         var subnodeChildren = findChildren(subnode);
		subnodeChildren.hide();
	});	
}

function find_io_BOM_info(tr) {
	is_input_tr=true;
	var found_level2=false;
	array_loc=0;
    var cur = $(tr).prev();
    while(1){
	//	console.log($(this).html());
		var depth=parseInt($(cur).attr('data-depth'));
		switch(depth){
			case 2:
				if ($(cur).hasClass('tr_input')){
					tr_input=$(cur);
				}	
				if ($(cur).hasClass('tr_output')){
					if (is_input_tr) is_input_tr=false;
					tr_output=$(cur);
				}
				if ($(cur).hasClass('tr_inventory')){
					tr_inventory=$(cur);
				}
				found_level2=true;
				break;
			case 1:
				tr_level1=$(cur);
				m_id=$(cur).find('.id').eq(0).text();
				break;
		}
		if (depth==1) break;
		else{
			cur = $(cur).prev();
			if (found_level2==false) array_loc++;
		}
    }		
	l_id=$(cur).attr('data-l_id');
}
$(document).on('mousedown', 'input[type=date]', function(){
    console.log("mousedown value " + $(this).val());
	$(this).datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
$(document).on('focusin', 'input[type=date]', function(){
    console.log("focusin value " + $(this).val());
    $(this).data('val', $(this).val());
}).on('change','input[type=date]', function(){
    var prev = $(this).data('val');
    var current = $(this).val();
	if (prev!=current){
		var now = new Date();
		var dateTime=getWorldTime(now,+9).split(' ');
        var tr = $(this).closest('tr'); //Get <tr> parent of toggle button
		find_io_BOM_info(tr);
		var to_db={CRUD:'update', BOM_id:l_id+'@'+m_id, is_input:is_input_tr, array_loc:array_loc, target_key:'date', date:current,
					log:{type:'changed', date_to:current, date:dateTime[0]+' '+dateTime[1]}};
		CRUD_io_to_mongodb('http://localhost/RES2/MES/mongo_CRUD_io.php',to_db);
		//BOM.transaction.update({"BOM_id" : m_id+'@'+l_id},{$set:{"input.array_loc.date":current}})
	}
    console.log("Prev value " + prev);
    console.log("New value " + current);
});
$(document).on('focus', '#BOM_table [contenteditable]', function(){
	contents=parseInt($(this).text());
});
$(document).on('blur', '#BOM_table [contenteditable]', function(){
//	if ($(this).text()=='' || $(this).text().toUpperCase()==contents.toUpperCase()){
	if ($(this).text()=='' || parseInt($(this).text())==contents){
		$(this).text(contents);
		return;
	}else{
		var now = new Date();
		var dateTime=getWorldTime(now,+9).split(' ');
        var tr = $(this).closest('tr'); //Get <tr> parent of toggle button
		find_io_BOM_info(tr);
		var to_db={CRUD:'update', BOM_id:l_id+'@'+m_id, is_input:is_input_tr, array_loc:array_loc, 
						target_key:'quantity', quantity:parseInt($(this).text()), prev_quantity:contents, 
						log:{type:'changed',quantity_to:parseInt($(this).text()), date:dateTime[0]+' '+dateTime[1]}};
		CRUD_io_to_mongodb('http://localhost/RES2/MES/mongo_CRUD_io.php',to_db);		
		console.log('after change quantity: ',json);
		var prev_inv=parseInt($(tr_inventory).find('span.inventory').text());
		var after_inv=prev_inv+json.change_quantity;
		$(tr_inventory).find('span.inventory').text(after_inv);
	}
});


function getWorldTime(now, tzOffset) { // 24시간제
  var tz = now.getTime() + (now.getTimezoneOffset() * 60000) + (tzOffset * 3600000);
  now.setTime(tz);


  var s =
    leadingZeros(now.getFullYear(), 4) + '-' +
    leadingZeros(now.getMonth() + 1, 2) + '-' +
    leadingZeros(now.getDate(), 2) + ' ' +

    leadingZeros(now.getHours(), 2) + ':' +
    leadingZeros(now.getMinutes(), 2) + ':' +
    leadingZeros(now.getSeconds(), 2);

  return s;
}
function leadingZeros(n, digits) {
  var zero = '';
  n = n.toString();

  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++)
      zero += '0';
  }
  return zero + n;
}

var utc = new Date().toJSON().slice(0,10);
function add_l_after(btn){
	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');

	var cur_tr=$(btn).closest('tr');	
    var children = findChildren(cur_tr);
//	console.log('last :'+$(children[children.length-1]).html());
	
	var last_tr=$(children[children.length-1]).closest('tr');	
	//$(cur_tr).clone().insertAfter(last_tr);
	$(last_tr).after('<tr data-depth="0" class="tbcollapse level0">'
					+'   <td><span class="toggle"></span><span contenteditable class="name editable">undefined</span></td>             '
					+'   <td><span contenteditable class="id editable">A1</span></td>                                               '
                    +'   <td></td><td></td><td></td>                                                                                              '
					+'   <td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>            '
					+'   <td><input type="button" value="Remove" class="l_button" onclick="remove_lm(this)"></td>                    '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="1" class="tbcollapse level1">                                                               '
					+'    <td><span class="toggle"></span><span contenteditable class="name editable">undefined</span></td>               '
					+'    <td><span contenteditable class="id editable">A100</span></td>                                             '
                    +'      <td></td><td></td><td></td>                                                                                            '
					+'		<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>      '
					+'		<td><input type="button" value="Remove" class="m_button" onclick="remove_lm(this)" disabled></td>             '
                    +'   </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_inventory">                                                             '
                    +'     <td>재고량</td>                                                                                          ' 
                    +'      <td></td>   <td></td><td></td>                                                                                         '
                    +'     <td><span class="inventory">0</span></td>                                                          '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_input">                                                             '
					+'   <td><span class="toggle"></span>입고</td>						                                         '
                    +'     <td></td>                                                                                             '
                    +'      <td></td> <td></td><td></td>                                                                                           '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>      '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="3" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'" /></td>                                                       '
                    +'      <td></td> <td></td><td></td>                                                                                           '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>				'
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_output">                                                             '
					+'   <td><span class="toggle"></span>출고</td>						                                         '
                    +'     <td></td>                                                                                             '
                    +'      <td></td> <td></td><td></td>                                                                                           '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>      '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="3" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'"></td>                                                       '
                    +'      <td></td> <td></td><td></td>                                                                                           '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>				'
                    +' </tr>');
	
//  document.getElementById('resultMsg').innerHTML('<?php echo "asdasda";?>');
}

function add_m_after(btn){
	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');

	var cur_tr=$(btn).closest('tr');
	if ($(cur_tr).find('[value=Remove]').attr("disabled")){ 
        $(cur_tr).find('[value=Remove]').attr("disabled", false);
    } 

    var children = findChildren(cur_tr);

	var last_tr=$(children[children.length-1]).closest('tr');	
	//$(cur_tr).clone().insertAfter(last_tr);
	$(last_tr).after(' <tr data-depth="1" class="tbcollapse level1">                                                               '
					+'    <td><span class="toggle"></span><span contenteditable class="name editable">undefined</span></td>               '
					+'    <td><span contenteditable class="id editable">A100</span></td>                                             '
                    +'      <td></td>    <td></td><td></td>                                                                                        '
					+'		<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>      '
					+'		<td><input type="button" value="Remove" class="m_button" onclick="remove_lm(this)"></td>             '
                    +'   </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_inventory">                                                             '
                    +'     <td>재고량</td>                                                                                          ' 
                    +'      <td></td>  <td></td><td></td>                                                                                          '
                    +'     <td><span class="inventory">0</span></td>                                                          '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_input">                                                             '
					+'   <td><span class="toggle"></span>입고</td>						                                         '
                    +'     <td></td>                                                                                             '
                    +'      <td></td> <td></td><td></td>                                                                                           '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>      '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="3" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'" /></td>                                                       '
                    +'      <td></td><td></td><td></td>                                                                                            '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>				'
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_output">                                                             '
					+'   <td><span class="toggle"></span>출고</td>						                                         '
                    +'     <td></td>                                                                                             '
                    +'      <td></td> <td></td><td></td>                                                                                           '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>      '
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="3" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'"></td>                                                       '
                    +'      <td></td> <td></td><td></td>                                                                                           '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>				'
                    +' </tr>');
	
//  document.getElementById('resultMsg').innerHTML('<?php echo "asdasda";?>');
}
function add_io_after(btn){
	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');

	var cur_tr=$(btn).closest('tr');	
	$(cur_tr).after(' <tr data-depth="3" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'"></td>                                                 '
                    +'      <td></td> <td></td><td></td>                                                                       '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
 					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_s(this)"></td>				'
                   +' </tr>');
	cur_tr=$(cur_tr).next();
	find_io_BOM_info(cur_tr);
	var to_db={CRUD:'create', BOM_id:l_id+'@'+m_id, is_input:is_input_tr, 
				quantity:0, date:dateTime[0],
				log:{type:'created',quantity:0, date:dateTime[0]+' '+dateTime[1]}};
	CRUD_io_to_mongodb('http://localhost/RES2/MES/mongo_CRUD_io.php',to_db);		
	console.log('after create io: ',json);
}

function remove_lm(btn){
	var cur_tr=$(btn).closest('tr');
	var prev_tr=$(cur_tr).prev();
    var depth = cur_tr.data('depth');
	
    var children = findChildren(cur_tr);
	$(children).remove();
	$(cur_tr).remove();

	if (depth==1){
		var parent_tr=prev_tr;
		//console.log($(parent_tr).find('td').eq(0).html());
		if ($(parent_tr).attr('data-depth')!=0){
			while(1){
				if (parseInt($(parent_tr).attr('data-depth')) >= depth){   // 'return true' is continue, 'return false' is exit
					parent_tr=$(parent_tr).prev();
					//console.log($(parent_tr).find('td').eq(0).html());
				}else break;
			}	
		}
		var gens = findChildren(parent_tr);
		var children=$(gens).filter(function(){
			return parseInt($(this).attr('data-depth'))==1;
		});
		
 		if ($(children).length==1){
			$(children).find('[value=Remove]').attr('disabled','disabled');
		}
	}
}
function remove_s(btn){
	var cur_tr=$(btn).closest('tr');	
	$(cur_tr).remove();
}

$(document).on('focus', '#tree_for_el_ef [contenteditable],#tree_for_tech [contenteditable],'
						+'#tree_for_variable [contenteditable]', function() {
	contents=$(this).text();
});
$(document).on('blur', '#tree_for_el_ef [contenteditable],#tree_for_tech [contenteditable],'
						+ '#tree_for_variable [contenteditable]', function() {
	var dataType=$(this).data('type');
	var isTech=$(this).closest('#tree_for_tech').length?true:false;

	var arr_l_id=parseInt($(this).closest('.energyLevels').find('.id').html())-1;	
	if (dataType=='name' || dataType=='demandRange'){
		if ($(this).text()=='' || $(this).text().toUpperCase() ==contents.toUpperCase()){
			$(this).text(contents);
			return;
		}			
	}
	if($(this).closest('li').hasClass('var')){
		var is_ts=$(this).closest('li.var').find('.is_ts_var').is(':checked');
		var years=json.general.lyear-json.general.fyear+1;
		var eq = (is_ts)?$(this).text()+'^t, t=1,2,\\cdots,'+years:$(this).text();
		el=$(this).closest('li').find('.math').get(0);
		katex.render(eq,el);
		return;
	}
	
	
	if (!isTech){
		if ($(this).closest('li').hasClass('energyLevels')){
			json.energyLevels[arr_l_id][dataType]=$(this).text();	
			changed_el_ef("change_el_name",arr_l_id, -1);
			make_contextmenu();
			//json_editor_update();
			return;
		}
		if ($(this).closest('li').hasClass('ef') || $(this).closest('li').hasClass('demand')){
			var  f_id=parseInt($(this).closest('.ef').find('.id').html());
			for (var i=0;i<json.energyLevels[arr_l_id].energyForms.length;i++){
				var cur_f_id=json.energyLevels[arr_l_id].energyForms[i].f_id;
				if (cur_f_id==f_id){
					arr_f_id=i;
					break;
				}
			}
			if (dataType=="demandRange"){
				if (isNaN($(this).text())){
					var ts=getExcelRange($(this).text()).split(',');
					var cur_td=$(this).closest('td').next().next();
					
					var i=0;
					while($(cur_td).is('td')){
						if (ts.length<=i){
							$(cur_td).text(ts[ts.length-1]);
						}else{
							$(cur_td).text(ts[i]);
						}
						i++;
						cur_td=$(cur_td).next();
					}				
					json.energyLevels[arr_l_id].energyForms[arr_f_id].demand['excelRange']=$(this).text();
					json.energyLevels[arr_l_id].energyForms[arr_f_id].demand['ts']=ts.toString();			
				}else {
					json.energyLevels[arr_l_id].energyForms[arr_f_id].demand=$(this).text();
					var cur_td=$(this).closest('td').next().next();
					
					var i=0;
					while($(cur_td).is('td')){
						$(cur_td).text($(this).text());
						i++;
						cur_td=$(cur_td).next();
					}				
				}
			}else {
				json.energyLevels[arr_l_id].energyForms[arr_f_id][dataType]=$(this).text();						
				changed_el_ef("change_ef_name",arr_l_id, arr_f_id);
				make_contextmenu();
			}				
			//json_editor_update();
			return;
		}		
	}
	
	if ($(this).closest('li').hasClass('techLevelLi')){
		json.techLevels[arr_l_id][dataType]=$(this).text();
		//json_editor_update();
		return;
	}
	if ($(this).closest('li').hasClass('techLi') || $(this).closest('li').hasClass('capacityLi')
		|| $(this).closest('li').hasClass('investmentCostLi') || $(this).closest('li').hasClass('fixedCostLi') || $(this).closest('li').hasClass('varCostLi')
		|| $(this).closest('li').hasClass('otherInputLi') || $(this).closest('li').hasClass('mainOutputLi') || $(this).closest('li').hasClass('otherOutputLi')
		|| $(this).closest('li').hasClass('histCapLi')
		|| $(this).closest('li').hasClass('histCapYearRange') || $(this).closest('li').hasClass('histCapCapRange')){
		var t_id=parseInt($(this).closest('.techLi').find('.id').html());
		var arr_t_id;
		for (var i=0;i<json.techLevels[arr_l_id].techs.length;i++){
				var cur_t_id=json.techLevels[arr_l_id].techs[i].t_id;
				if (cur_t_id==t_id){
					arr_t_id=i;
					break;
				}
		}
		if (dataType=='name'){
			json.techLevels[arr_l_id].techs[arr_t_id][dataType]=$(this).text();
			//json_editor_update();
			return;
		}

		if (dataType=="invCostRange" || dataType=="fixedCostRange" || dataType=='varCostRange' 
			|| dataType=='histCapYearRange' || dataType=='histCapCapRange'){
			var cur_td=$(this).closest('td').next().next();
			if ($(this).text()==''){
				while($(cur_td).is('td')){
					$(cur_td).text('');
					cur_td=$(cur_td).next();
				}	
			}else{
				var ts_string=getExcelRange($(this).text());
				var ts=ts_string.split(',');
				if(!(dataType=='histCapYearRange' || dataType=='histCapCapRange')){
					var i=0;
					while($(cur_td).is('td')){
						if (ts.length<=i){
							$(cur_td).text(ts[ts.length-1]);
						}else{
							$(cur_td).text(ts[i]);
						}
						i++;
						cur_td=$(cur_td).next();
					}				
				}else{
					var table=$(this).closest('table');
					if (dataType=='histCapYearRange'){
						$(table).find('tr').remove();
						var	firstRow='<tr><td><span contenteditable data-type="histCapYearRange" class="excelRange editable cost">'
											+$(this).text()+'</span></td><td>year</td>';
						var secondRow='<tr><td>'
								+'<span contenteditable data-type="histCapCapRange" class="excelRange editable cost"></span></td><td>historic capacity</td>';
						
						for (var k=0;k<ts.length;k++){
							firstRow += '<td style="border: 1px solid black;">' + ts[k] + '</td>';
							secondRow += '<td style="border: 1px solid black;"></td>';
						}
						firstRow+='</tr>';
						secondRow+='</tr>';
						table.append(firstRow);
						table.append(secondRow);
						alert('input the next "capacity excelRange"');
					}else{
						var i=0;
						while($(cur_td).is('td')){
							if (ts.length<=i){
								$(cur_td).text(ts[ts.length-1]);
							}else{
								$(cur_td).text(ts[i]);
							}
							i++;
							cur_td=$(cur_td).next();
						}				
					}
				}
			}
		}else if(dataType=="inputValueRange" || dataType=="outputValueRange"){
			var a_id=parseInt($(this).closest('.activityLi').find('.id').html())-1;
			var cur_td=$(this).closest('td').next().next();
			var otherInput_id,output_id;
			if (dataType=="inputValueRange"){
				otherInput_id=parseInt($(this).closest('.otherInputLi').find('.id').html())-1;		
			}else{
				if ($(this).closest('li').hasClass('otherOutputLi')){
					output_id=parseInt($(this).closest('.otherOutputLi').find('.id').html())-1;					
				}else{
					output_id=0;
				}
			} 
			if ($(this).text()==''){
				var i=0;
				while($(cur_td).is('td')){
					$(cur_td).text('');
					i++;
					cur_td=$(cur_td).next();
				}	
			}else{
				var ts=getExcelRange($(this).text()).split(',');
				
				var i=0;
				while($(cur_td).is('td')){
					if (ts.length<=i){
						$(cur_td).text(ts[ts.length-1]);
					}else{
						$(cur_td).text(ts[i]);
					}
					i++;
					cur_td=$(cur_td).next();
				}				
			}
		} 
		else json.techLevels[arr_l_id].techs[arr_t_id][dataType]=$(this).text();			
		//json_editor_update();
		return;		
	}
});
