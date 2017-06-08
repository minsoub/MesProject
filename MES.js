
//$(document).on('click', '#mytable .toggle', function() {
$(document).ready(function (e) {
	console.log("ready1: ");
});

$(function() {
	console.log("ready2: ");

    $('#mytable').on('click', '.toggle', function () {
        //Gets all <tr>'s  of greater depth
        //below element in the table
        var findChildren = function (tr) {
            var depth = tr.data('depth');
            return tr.nextUntil($('tr').filter(function () {
                return $(this).data('depth') <= depth;
            }));
        };

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