var json;
$(document).ready(function (e) {
	var start=Date.now()-timerStart;
	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');
	console.log("Time start DOMready: ", dateTime[0]+' '+dateTime[1]);

	readDB();
	populateBOM_TreeTable();
	expand_collapse_TreeTable();

	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');
	console.log("Time end DOMready: ", dateTime[0]+' '+dateTime[1]);
	var end=Date.now()-timerStart;
    console.log("Time until everything loaded: ", end-start);
	
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
    var depth = tr.data('depth');
	var state;
    if (tr.hasClass('tbcollapse')) {
        tr.removeClass('tbcollapse').addClass('tbexpand');
        children.hide();
		
		state='collapsed';
    }else {
        tr.removeClass('tbexpand').addClass('tbcollapse');
        children.show();
		state='expanded';
    }
	
	switch(depth){
		case 0 :
			var mongo_setup_id=$(tr).attr('data-mongo_setup_id');
			var mongo_l_id=$(tr).attr('data-mongo_l_id');
			var to_db={CRUD:'expand_collapse', mongo_setup_id:mongo_setup_id, mongo_l_id:mongo_l_id, node_state:state};
			ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_BOM.php',to_db);		
		break;
		case 1 :
			var mongo_l_id=$(tr).attr('data-mongo_l_id');
			var mongo_m_id=$(tr).attr('data-mongo_m_id');
			var to_db={CRUD:'expand_collapse', mongo_l_id:mongo_l_id, mongo_m_id:mongo_m_id, node_state:state};
			ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_master.php',to_db);		
		break;
		case 2 :
			ids=find_io_BOM_info(tr);
			var mongo_m_id=$(tr_level1).attr('data-mongo_m_id');
			var is_input;
			if ($(tr).hasClass('tr_input')) is_input=true;
			else is_input=false;
			var to_db={CRUD:'expand_collapse', mongo_m_id:mongo_m_id, depth:depth, new_state:state, is_input:is_input, id:$(this).attr('data-mongoid')};
			ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_io1.php',to_db);		
		break;
	}


    return children;
});

function ajax_get_json_from_mongodb(urlname){
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


function readDB(){
	var urlname='http://localhost/RES2/MES/mongo_read_collection.php?collection=setup';
	ajax_get_json_from_mongodb(urlname);	  
	BOM_setup=from_ajax_data;
};
function populateBOM_TreeTable(){
	$("#BOM_table").find('tbody').empty();
	var is_first_row=true;
	var cur_tr;
	var loc=0;
	var node_state;

	var no_of_active_level0=0;
	var mongo_setup_id=BOM_setup[0]._id;
	for (var i = 0; i < BOM_setup[0].BOM_master.sub.length; i++){
		if (BOM_setup[0].BOM_master.sub[i].hasOwnProperty('removed')) continue;
		else no_of_active_level0++;
	}
	
	
	for (var i = 0; i < BOM_setup[0].BOM_master.sub.length; i++){
		if (BOM_setup[0].BOM_master.sub[i].hasOwnProperty('removed')) continue;
		var cur_l=BOM_setup[0].BOM_master.sub[i];
		var to_db={CRUD:'read', mongo_l_id:cur_l._id['$id']};
		ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_BOM.php',to_db);		
		var level0=json.level0;			
		
		node_state=(cur_l.state=='collapsed')?'tbexpand':'tbcollapse';
		var disabled='';
		if (no_of_active_level0==1) disabled='disabled';
		if (is_first_row){
			$("#BOM_table>tbody").append('<tr data-depth="0"  data-mongo_setup_id="'+mongo_setup_id['$id']+'"   data-mongo_l_id="'+level0._id['$id']
					   +'"   class="'+node_state+' level0">'
					   +'<td><span class="toggle"></span><span contenteditable class="name editable">'+level0.name+'</span></td>'
					   +'<td><span contenteditable class="id editable">'+level0.l_id+'</span></td>'
                       +'   <td></td><td></td><td></td>'
					   +'<td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>'
					   +'<td><input type="button" value="Remove" class="l_button" onclick="remove_l(this)" '+disabled+'></td>'
                     +'</tr>');
			cur_tr=$("#BOM_table>tbody").find('tr').eq(0);	
			is_first_row=false;
		}else{
			$(cur_tr).after('<tr data-depth="0"  data-mongo_setup_id="'+mongo_setup_id['$id']+'"   data-mongo_l_id="'+level0._id['$id']
					   +'"   class="'+node_state+' level0">'
					   +'<td><span class="toggle"></span><span contenteditable class="name editable">'+level0.name+'</span></td>'
					   +'<td><span contenteditable class="id editable">'+level0.l_id+'</span></td>'
                       +'   <td></td><td></td><td></td>'
					   +'<td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>'
					   +'<td><input type="button" value="Remove" class="l_button" onclick="remove_l(this)" '+disabled+'></td>'
                     +'</tr>');
			cur_tr=$(cur_tr).next();
		}
		
		var no_of_active_level1=0;
		for (var j=0;j<level0.sub.length;j++){
			if (level0.sub[j].hasOwnProperty('removed')) continue;
			else no_of_active_level1++;
		}
		
		for (var j=0;j<level0.sub.length;j++){
			var to_db={CRUD:'read', mongo_l_id:level0._id['$id'], mongo_m_id:level0.sub[j]._id['$id']};
			ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_master.php',to_db);		
			var level1=json.level1;			
			if (level1.hasOwnProperty('removed')) continue;
			
			node_state=(level0.sub[j].state=='collapsed')?'tbexpand':'tbcollapse';
			var disabled='';
			if (no_of_active_level1==1) disabled='disabled';
            $(cur_tr).after('<tr data-depth="1" data-l_id="'+level0.l_id+'" data-m_id="'+level1.m_id
							+'"  data-mongo_l_id="'+level0._id['$id']+'"  data-mongo_m_id="'+level1._id['$id']+'"   class="'+node_state+' level1">'
							+'<td><span class="toggle"></span><span contenteditable class="name editable">'+level1.name+'</span></td>'
							+'<td><span contenteditable class="id editable">'+level1.m_id+'</span></td>'
							+'<td><span contenteditable class="unit editable">'+level1.unit+'</span></td>'
							+'<td><span contenteditable class="spec editable">'+level1.spec+'</span></td><td></td>'
							+'<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>'
							+'<td><input type="button" value="Remove" class="m_button" onclick="remove_m(this)" '+disabled+'></td>'
						  +'</tr>');
			cur_tr=$(cur_tr).next();
			
			//if (BOM_transaction[loc].BOM_id==(level0.l_id+'@'+level1.m_id)){
                 $(cur_tr).after('<tr data-depth="2" class="level2 tr_inventory">'
                        		+'     <td>재고량</td>'
                        		+'      <td></td><td></td><td></td>'
                        		+'     <td><span class="inventory">'+level1.inventory+'</span></td>'
                        		+' </tr>');
				cur_tr=$(cur_tr).next();
				node_state=(level1.state[0]=='collapsed')?'tbexpand':'tbcollapse';
                $(cur_tr).after('<tr data-depth="2" class="'+node_state+' level2 tr_input">'
								+'	   <td><span class="toggle"></span>입고('+level0.l_id+'@'+level1.m_id+')</td>	'					 
                        		+'     <td></td>'
								+'       <td></td><td></td><td></td>'
								+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
                        		+' </tr>');
				cur_tr=$(cur_tr).next();
				for (var k=0;k<level1.inputs.length;k++){
					var cur=level1.inputs[k];
					if (cur.hasOwnProperty('removed')) continue;
					var now = new Date(cur.date.sec*1000);
					var dateTime=getWorldTime(now,+9).split(' ');

                    $(cur_tr).after('    <tr data-depth="3" data-mongoid="'+cur._id['$id']+'" class="tbcollapse level3">'
                        			+'     <td><input type="date" value="'+dateTime[0]+'">'+dateTime[1]+'</td>'
                            		//+'      <td>'+cur._id.$id+'</td><td></td><td></td>'
                            		+'      <td>'+cur._id['$id']+'</td><td></td><td></td>'
                        			+'     <td><span contenteditable class="quantity editable">'+cur.quantity+'</span></td>'
									+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
						    		+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>'
									+'</tr>');
					cur_tr=$(cur_tr).next();
				}				//ObjectId("57b2caf24ae55f3016000033")
 				node_state=(level1.state[1]=='collapsed')?'tbexpand':'tbcollapse';
                $(cur_tr).after('<tr data-depth="2" class="'+node_state+' level2 tr_output">'
								+'	   <td><span class="toggle"></span>출고('+level0.l_id+'@'+level1.m_id+')</td>	'					 
                        		+'     <td></td>'
								+'       <td></td><td></td><td></td>'
								+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
                        		+' </tr>');
				cur_tr=$(cur_tr).next();
				for (var k=0;k<level1.outputs.length;k++){
					var cur=level1.outputs[k];
					if (cur.hasOwnProperty('removed')) continue;
					var now = new Date(cur.date.sec*1000);
					var dateTime=getWorldTime(now,+9).split(' ');

                    $(cur_tr).after('    <tr data-depth="3" data-mongoid="'+cur._id['$id']+'"  class="tbcollapse level3">'
                        			+'     <td><input type="date" value="'+dateTime[0]+'">'+dateTime[1]+'</td>'
                            		+'      <td>'+cur._id['$id']+'</td><td></td><td></td>'
                        			+'     <td><span contenteditable class="quantity editable">'+cur.quantity+'</span></td>'
									+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>'
						    		+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>'
									+'</tr>');
					cur_tr=$(cur_tr).next();
				}				
				loc++;
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
	var m_id, l_id;
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
	return [l_id,m_id];
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
		var mongo_m_id=$(tr_level1).attr('data-mongo_m_id');
		var to_db={CRUD:'update', mongo_m_id:mongo_m_id, is_input:is_input_tr, array_loc:array_loc, target_key:'date', date:current, id:$(this).attr('data-mongoid'),
					log:{type:'changed', date_to:current}};
		ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_io1.php',to_db);
		//BOM.transaction.update({"BOM_id" : m_id+'@'+l_id},{$set:{"input.array_loc.date":current}})
	}
    console.log("Prev value " + prev);
    console.log("New value " + current);
});
$(document).on('focus', '#BOM_table [contenteditable]', function(){
	contents=$(this).text();
});
$(document).on('blur', '#BOM_table [contenteditable]', function(){
//	if ($(this).text()=='' || $(this).text().toUpperCase()==contents.toUpperCase()){
	if ($(this).text()=='' || parseInt($(this).text())==contents){
		$(this).text(contents);
		return;
	}else{
		var depth=parseInt($(this).closest('tr').attr('data-depth'));
		var now = new Date();
		var dateTime=getWorldTime(now,+9).split(' ');
        var tr = $(this).closest('tr'); //Get <tr> parent of toggle button
		if (depth==3){
			ids=find_io_BOM_info(tr);
			var mongo_m_id=$(tr_level1).attr('data-mongo_m_id');
			var to_db={CRUD:'update', depth:depth, mongo_m_id:mongo_m_id, is_input:is_input_tr, array_loc:array_loc, id:$(this).attr('data-mongoid'),
						target_key:'quantity', quantity:parseInt($(this).text()), prev_quantity:parseInt(contents), 
						log:{type:'changed',quantity_to:parseInt($(this).text())}};
			ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_io1.php',to_db);		
			console.log('after change quantity: ',json);
			var prev_inv=parseInt($(tr_inventory).find('span.inventory').text());
			var after_inv=prev_inv+json.change_quantity;
			$(tr_inventory).find('span.inventory').text(after_inv);
		}else if (depth==1){
			var l_id=$(tr).attr('data-l_id');
			var m_id=$(tr).attr('data-m_id');
			var mongo_l_id=$(tr).attr('data-mongo_l_id');
			var mongo_m_id=$(tr).attr('data-mongo_m_id');
			if ($(this).hasClass('name') || $(this).hasClass('unit') || $(this).hasClass('spec')){
				var target;
				if ($(this).hasClass('name')) target='name';
				else if ($(this).hasClass('unit')) target='unit';
				else target='spec';
				var to_db={CRUD:'update', depth:depth, id:$(tr).attr('data-mongoid'), l_id:l_id, m_id:m_id, mongo_l_id:mongo_l_id, mongo_m_id:mongo_m_id,
						target_key:target, prev:contents, cur:$(this).text(),
						log:{type:'changed',target:target, current:$(this).text(), prev:contents}};
				ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_master.php',to_db);						
			}else if ($(this).hasClass('id')){
				var to_db={CRUD:'update', depth:depth, id:$(tr).attr('data-mongoid'), l_id:l_id, m_id:m_id, mongo_l_id:mongo_l_id, mongo_m_id:mongo_m_id,
						target_key:'id', prev_m_id:contents, cur_m_id:$(this).text(),
						log:{type:'changed',m_id_to:$(this).text(), prev_m_id:contents}};
				ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_master.php',to_db);						
				$(tr).attr('data-m_id',$(this).text());
			}
		}else if (depth==0){
			var mongo_l_id=$(tr).attr('data-mongo_l_id');
			var mongo_setup_id=$(tr).attr('data-mongo_setup_id');
			if ($(this).hasClass('name')) target='name';
			else target='l_id';
			var to_db={CRUD:'update', depth:depth, mongo_setup_id:mongo_setup_id, mongo_l_id:mongo_l_id,
						target_key:target, prev:contents, cur:$(this).text(),
						log:{type:'changed',target:target, current:$(this).text(), prev:contents}};
			ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_BOM.php',to_db);						
		}
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
	if ($(cur_tr).find('[value=Remove]').attr("disabled")){ 
        $(cur_tr).find('[value=Remove]').attr("disabled", false);
    } 
	
	var mongo_setup_id=$(cur_tr).attr('data-mongo_setup_id');
	var mongo_l_id=$(cur_tr).attr('data-mongo_l_id');
	var cur_l_name=$(cur_tr).find('.name').text()+'1';
	var cur_l_id=$(cur_tr).find('.id').text()+'1';
	var cur_m_name=$(cur_tr).next().find('.name').text()+'1';
	var cur_m_id=$(cur_tr).next().find('.id').text()+'1';
	var cur_unit=$(cur_tr).next().find('.unit').text();
	var cur_spec=$(cur_tr).next().find('.spec').text();
	var to_db={CRUD:'create', mongo_setup_id:mongo_setup_id, mongo_l_id:mongo_l_id, 
				l_name:cur_l_name, l_id:cur_l_id, m_name:cur_m_name, m_id:cur_m_id, unit:cur_unit, spec:cur_spec, node_state:'expanded',
				log:{type:'created'}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_BOM.php',to_db);		

    var children = findChildren(cur_tr);
//	console.log('last :'+$(children[children.length-1]).html());
	
	var last_tr=$(children[children.length-1]).closest('tr');	
	//$(cur_tr).clone().insertAfter(last_tr);
	var node_state=(json.node_state=='collapsed')?'tbexpand':'tbcollapse';
	$(last_tr).after('<tr data-depth="0"  data-mongo_setup_id="'+mongo_setup_id+'"  data-mongo_l_id="'+json.new_master_id['$id']
					+'"   class="'+node_state+' level0">'
					+'<td><span class="toggle"></span><span contenteditable class="name editable">'+cur_l_name+'</span></td>'
					+'<td><span contenteditable class="id editable">'+cur_l_id+'</span></td>'
                    +'   <td></td><td></td><td></td>                                                                                              '
					+'   <td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>            '
					+'   <td><input type="button" value="Remove" class="l_button" onclick="remove_l(this)"></td>                    '
                    +' </tr>                                                                                                     '
					+'<tr data-depth="1" data-l_id="'+json.l_id+'" data-m_id="'+json.m_id
					+'"  data-mongo_l_id="'+json.new_master_id['$id']+'"  data-mongo_m_id="'+json.new_transaction_m_id['$id']
					+'"   class="'+node_state+' level1">'
					+'<td><span class="toggle"></span><span contenteditable class="name editable">'+cur_m_name+'</span></td>'
					+'<td><span contenteditable class="id editable">'+json.m_id+'</span></td>'
					+'<td><span contenteditable class="unit editable">'+cur_unit+'</span></td>'
					+'<td><span contenteditable class="spec editable">'+cur_spec+'</span></td><td></td>'
					+'<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>'
					+'<td><input type="button" value="Remove" class="m_button" onclick="remove_m(this)"></td>'
					+'</tr>'
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
					+' <tr data-depth="3"  data-mongoid="'+json.new_input_mongoid+'" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'" /></td>                                                       '
                    +'      <td></td><td></td><td></td>                                                                                            '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>				'
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_output">                                                             '
					+'   <td><span class="toggle"></span>출고</td>						                                         '
                    +'     <td></td>                                                                                             '
                    +'      <td></td> <td></td><td></td>                                                                                           '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>      '
                    +' </tr>                                                                                                     '
					+' <tr data-depth="3"  data-mongoid="'+json.new_output_mongoid+'" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'"></td>                                                       '
                    +'      <td></td> <td></td><td></td>                                                                                           '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>				'
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
	
	var mongo_l_id=$(cur_tr).attr('data-mongo_l_id');
	var mongo_m_id=$(cur_tr).attr('data-mongo_m_id');
	var cur_name=$(cur_tr).find('.name').text()+'1';
	var cur_id=$(cur_tr).find('.id').text()+'1';
	var cur_unit=$(cur_tr).find('.unit').text();
	var cur_spec=$(cur_tr).find('.spec').text();
	var to_db={CRUD:'create', mongo_l_id:mongo_l_id, mongo_m_id:mongo_m_id, 
				name:cur_name, m_id:cur_id, unit:cur_unit, spec:cur_spec, node_state:'expanded',
				log:{type:'created'}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_master.php',to_db);		

    var children = findChildren(cur_tr);
	var last_tr=$(children[children.length-1]).closest('tr');	
	var node_state=(json.node_state=='collapsed')?'tbexpand':'tbcollapse';
     $(last_tr).after('<tr data-depth="1" data-l_id="'+json.l_id+'" data-m_id="'+cur_id
					+'"  data-mongo_l_id="'+mongo_l_id+'"  data-mongo_m_id="'+json.new_transaction_m_id['$id']
					+'"   class="'+node_state+' level1">'
					+'<td><span class="toggle"></span><span contenteditable class="name editable">'+cur_name+'</span></td>'
					+'<td><span contenteditable class="id editable">'+cur_id+'</span></td>'
					+'<td><span contenteditable class="unit editable">'+cur_unit+'</span></td>'
					+'<td><span contenteditable class="spec editable">'+cur_spec+'</span></td><td></td>'
					+'<td><input type="button" value="Add" class="m_button m_after" onclick="add_m_after(this)"></td>'
					+'<td><input type="button" value="Remove" class="m_button" onclick="remove_m(this)"></td>'
					+'</tr>'
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
					+' <tr data-depth="3"  data-mongoid="'+json.new_input_mongoid+'" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'" /></td>                                                       '
                    +'      <td></td><td></td><td></td>                                                                                            '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>				'
                    +' </tr>                                                                                                     '
                    +' <tr data-depth="2" class="tbcollapse level2 tr_output">                                                             '
					+'   <td><span class="toggle"></span>출고</td>						                                         '
                    +'     <td></td>                                                                                             '
                    +'      <td></td> <td></td><td></td>                                                                                           '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>      '
                    +' </tr>                                                                                                     '
					+' <tr data-depth="3"  data-mongoid="'+json.new_output_mongoid+'" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'"></td>                                                       '
                    +'      <td></td> <td></td><td></td>                                                                                           '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>				'
                    +' </tr>');
	
//  document.getElementById('resultMsg').innerHTML('<?php echo "asdasda";?>');
}
function add_io_after(btn){
	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');
	var cur_tr=$(btn).closest('tr');	
	append_io_tr_after(cur_tr,dateTime);
}
function append_io_tr_after(cur_tr, dateTime){	
	$(cur_tr).after(' <tr data-depth="3" class="tbcollapse level3">                                                             '
                    +'     <td><input type="date" value="'+dateTime[0]+'"></td>                                                 '
                    +'      <td></td> <td></td><td></td>                                                                       '
                    +'     <td><span contenteditable class="quantity editable">0</span></td>                                  '
 					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_io_after(this)"></td>		'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_io(this)"></td>				'
                   +' </tr>');
	cur_tr=$(cur_tr).next();
	find_io_BOM_info(cur_tr);
	var mongo_m_id=$(tr_level1).attr('data-mongo_m_id');
	var to_db={CRUD:'create', mongo_m_id:mongo_m_id, is_input:is_input_tr, array_loc:array_loc, quantity:0,
				log:{type:'created',quantity:0}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_io1.php',to_db);		
	console.log('after create io: ',json);
	$(cur_tr).find('tr').eq(0).attr('data-mongoid',json._id['$id']);
	$(cur_tr).find('td').eq(1).text(json._id['$id']);
	$(cur_tr).find('span.quantity').eq(0).trigger( "click" );
	//document.forms['myform'].elements['mytextfield'].focus();
}

function remove_l(btn){
	var cur_tr=$(btn).closest('tr');
	var prev_tr=$(cur_tr).prev();
    var depth = cur_tr.data('depth');
	var mongo_setup_id=$(cur_tr).attr('data-mongo_setup_id');
	var mongo_l_id=$(cur_tr).attr('data-mongo_l_id');
	var is_first_l=false;
	var no_of_first_l=0;
	var tbody=$(cur_tr).closest('tbody');

    var children = findChildren(cur_tr);
	$(children).remove();
	$(cur_tr).remove();

	var first_tr=$(tbody).find('tr').eq(0);
	var cur=first_tr;
	while($(cur).length){
		if (parseInt($(cur).attr('data-depth'))==0){
			no_of_first_l++;
		}
		if (no_of_first_l>=2) break;
		cur=$(cur).next();
	}	
		
 	if (no_of_first_l==1){
		$(first_tr).find('[value=Remove]').attr('disabled','disabled');
	}
	
	var to_db={CRUD:'remove', mongo_setup_id:mongo_setup_id, mongo_l_id:mongo_l_id, log:{type:'removed'}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_BOM.php',to_db);		
}
function remove_m(btn){
	var cur_tr=$(btn).closest('tr');
	var prev_tr=$(cur_tr).prev();
    var depth = cur_tr.data('depth');
	var mongo_l_id=$(cur_tr).attr('data-mongo_l_id');
	var mongo_m_id=$(cur_tr).attr('data-mongo_m_id');
	var l_id=$(cur_tr).attr('data-l_id');
	var m_id=$(cur_tr).attr('data-m_id');
	
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
		
		var to_db={CRUD:'remove', mongo_l_id:mongo_l_id, mongo_m_id:mongo_m_id, l_id:l_id, m_id:m_id, log:{type:'removed'}};
		ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_master.php',to_db);		
		
	}
}
function remove_io(btn){
	var now = new Date();
	var dateTime=getWorldTime(now,+9).split(' ');

	var cur_tr=$(btn).closest('tr');	
	find_io_BOM_info(cur_tr);
	var mongo_m_id=$(tr_level1).attr('data-mongo_m_id');
	var to_db={CRUD:'remove', mongo_m_id:mongo_m_id, is_input:is_input_tr, array_loc:array_loc, id:$(cur_tr).attr('data-mongoid'),
				date:dateTime[0],time:dateTime[1],
				log:{type:'removed', date:dateTime[0]+' '+dateTime[1]}};
	ajax_CRUD_mongodb('http://localhost/RES2/MES/mongo_CRUD_io1.php',to_db);		
	
	$(cur_tr).remove();
	
		var prev_inv=parseInt($(tr_inventory).find('span.inventory').text());
		var after_inv=prev_inv+json.change_quantity;
		$(tr_inventory).find('span.inventory').text(after_inv);
}
