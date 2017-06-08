
//$(document).on('click', '#mytable .toggle', function() {
$(document).ready(function (e) {
	console.log("ready1: ");
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
	//	console.log('cc='+(++cc));
		
		// improved by khg : search until '$(this).data('depth') <= depth'
        var x=tr.nextUntil(function (){
		//	console.log($(this).html());
			return $(this).attr('data-depth')<= depth;   // 'return true' is continue, 'return false' is exit
        });		
        return x;		
		
		// search until last row and filter '$(this).data('depth') <= depth'
        /*return tr.nextUntil($('tr').filter(function () {
			console.log($(this).html());
            return $(this).data('depth') <= depth;
        }));*/
};

$(function() {
	console.log("ready2: ");
        //Gets all <tr>'s  of greater depth
        //below element in the table
		
/*	$('input[type=date]').datepicker({
		dateFormat: 'yy-mm-dd'
	});*/

	readDB();
	populateBOM_TreeTable();

	

    $('#mytable').on('click', '.toggle', function () {

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
});

function readDB(){};
function populateBOM_TreeTable(){
	var tr_expands=$('#mytable').find('tbody>tr.tbexpand');
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


$(document).on('mousedown', 'input[type=date]', function(){
	$(this).datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
function add_l_after(btn){
	var cur_tr=$(btn).closest('tr');	
    var children = findChildren(cur_tr);
	console.log('last :'+$(children[children.length-1]).html());
	
	var last_tr=$(children[children.length-1]).closest('tr');	
	//$(cur_tr).clone().insertAfter(last_tr);
	$(last_tr).after('<tr data-depth="0" class="tbcollapse level0">'
					+'<td><span class="toggle"></span><span contenteditable class="name">A2:부품</span></td>'
                    +'     <td></td>'
					+'		<td><input type="button" value="Add" class="l_button l_after" onclick="add_l_after(this)"></td>'
					+'		<td><input type="button" value="Remove" class="l_button" onclick="remove_l(this)"></td>'
                    +'</tr>'
                    +'<tr data-depth="1" class="tbcollapse level1">'
                    +'     <td><span class="toggle"></span><span contenteditable class="name">A100:coil</span></td>'
                    +'     <td></td>'
					+'		<td><input type="button" value="Add" class="m_button m_after" onclick="add_l_after(this)"></td>'
					+'		<td><input type="button" value="Remove" class="m_button" onclick="remove_el(this)"></td>'
                    +' </tr>'
                    +' <tr data-depth="2" class="tbcollapse level2">'
                    +'     <td>재고량</td>'
                    +'     <td>0</td>'
                    +' </tr>'
                    +' <tr data-depth="2" class="tbcollapse level2">'
					+'   <td><span class="toggle"></span>입고</td>	'					 
                    +'     <td></td>'
					+'		<td><input type="button" value="Add" class="s_button s_after" onclick="add_l_after(this)"></td>'
					+'		<td><input type="button" value="Remove" class="s_button" onclick="remove_el(this)"></td>'
                    +' </tr>'
                    +' <tr data-depth="3" class="tbcollapse level3">'
                    +'    <td><input type="date"></td>'
//                    +'    <td><input type="date" value="'+today1+'"></td>'
                    +'     <td>0</td>'
                    +' </tr>'
                    +' <tr data-depth="2" class="tbcollapse level2">'
					+'   <td><span class="toggle"></span>출고</td>	'					 
                    +'     <td></td>'
                    +' </tr>'
                    +' <tr data-depth="3" class="tbcollapse level3">'
                    +'     <td>2016-07-21</td>'
                    +'     <td>0</td>'
                    +' </tr>');
	
}

