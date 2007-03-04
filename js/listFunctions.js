/**
 * all jquery-functions, which are related to lists
 *
 * is been called on load
 *
 * included by:
 *
 * @author     Tino Beirau
 * @uses:
 * @usedby:     lists
 */

function listFunctions()
{

    /**
    * and even rows
    *
    * since this take up too much client CPU power
    * lists are already rendered with odd/even class
    *

    $('table.list tr:even').addClass('even');
    $('table.list tr:odd').addClass('odd');
    */


    var selected_rows= new Array();
    var last_row= false;

    /**
    * hover of rows
    */
    /*$('table.list').find('tr.trow').hover
    (
        function(){ $(this).addClass('hover'); },
        function(){ $(this).removeClass('hover'); }
    );
    */


    /**
    * prevent normal links from being overwritten by row toggling
    */
    $('table.list a').click
    (
        function(e)
        {
            document.location.href= this.href;
            return false
        }
    );

    $('table.list input[@type=checkbox]').each(function(){
        //   td         tr
        this.parentNode.parentNode['checkbox_obj']= this;
        this['table_row']= this.parentNode.parentNode;
        if(this.checked) {
            $(this.table_row).addClass('selected');
            selected_rows.push(this.table_row);
        }
    });


    /**
    * click on rows
    */
    $('table.list.selectable tr').click
    (
        function(e)
        {
            var table= this.parentNode.parentNode;

            /**
            * add the line to selection if CTRL or ALT pressed
            */
            if ( e.ctrlKey || e.altKey) {
                if(this.checkbox_obj.checked) {
                    this.checkbox_obj.checked= false;
                    $(this).removeClass('selected');
                    new_rows= Array();

                    for(var i=0; i < selected_rows.length; i++) {
                        if(selected_rows[i] != this) {
                            new_rows.push(selected_rows[i]);
                        }
                    }
                    selected_rows= new_rows;

                }
                else {
                    this.checkbox_obj.checked= true;
                    $(this).addClass('selected');
                    selected_rows.push(this);
                    last_row= this;
                }
            }
            /**
            * select range
            */
            else if(e.shiftKey) {
                if(last_row != false) {
                    var inside_selection= false;
                    var inside_rows= new Array();
                    var table_row= this;

                    $(table).find('tr').each(
                        function()
                        {
                            if(this == last_row || this == table_row) {
                                if(inside_selection) {
                                    inside_selection = false
                                }
                                else {
                                    inside_selection = true;
                                }
                            }
                            if(inside_selection) {
                                inside_rows.push(this);
                            }
                        }
                    );
                }
                for(var i=0; i < inside_rows.length; i++) {
                    $(inside_rows[i]).addClass('selected');
                    inside_rows[i].checkbox_obj.checked=true;
                    selected_rows.push(inside_rows[i]);
                }
                last_row= table_row;
            }

            /**
            * deselect all other rows
            */
            else {
                var was_selected = this.checkbox_obj.checked;

                last_row= this;

                var num_selected= selected_rows.length;

                for(var i=0; i < selected_rows.length; i++) {
                    row= selected_rows[i];
                    $(row).removeClass('selected');
                    row.checkbox_obj.checked = false;
                }

                /**
                * select new line
                */
                if(was_selected && num_selected == 1)
                {
                    this.checkbox_obj.checked= false;
                    $(this).removeClass('selected');
                    selected_rows= new Array();
                }
                else {
                    this.checkbox_obj.checked= true;
                    $(this).addClass('selected');

                    selected_rows= new Array(this);
                }
                /**
                * show sideboard
                */
                if(g_enable_sideboard) {
                    arr= /\btasks_(\d+)_chk\b/.exec(this.checkbox_obj.id);
                    if(arr) {
                        id=1*arr[1];
    
                        $.post('index.php?go=taskAjax',{
                            go: 'taskAjax',
                            tsk: id
                        }, function(str) {
                            $('#sideboard').html(str);
                            $('#sideboard').addClass('sideboardOn');                        
                            $('#outer').addClass('sideboardOn');
                            $('#sideboard div.wiki.editable').each(function() {
                                aj= new AjaxEdit(this);
                                ajax_edits.push(aj);
                                this.ajax_edit= aj;
                            });
                        });
                    }
                }
            }
        }
    );


    /**
    * prevent clicks on checkbox to be overwritten by single row select
    */
    $('table.list input[@type=checkbox]').click
    (
        function(e)
        {
            e.stopPropagation();

            if(this.checked)
            {
               $(this.parentNode.parentNode).addClass('selected');
               selected_rows.push(this.parentNode.parentNode);
            }
            else {
               $(this.parentNode.parentNode).removeClass('selected');
            }

        }
    );


    /**
    * "toggle all checkboxes"-function on top of table
    */
    $('table.list th.select_col a').click
    (
        function()
        {
            selected_rows= new Array();

            //     td         tr         tbody      table
            $(this.parentNode.parentNode.parentNode.parentNode).find('tr').each(function()
			{
                if(this['checkbox_obj'])
				{
                    if(this.checkbox_obj.checked)
					{
					    this.checkbox_obj.checked= false;
                        $(this).removeClass('selected');
                        selected_rows.shift; // here shift works, because jquery runs from Top to Button
					}
					else
					{
						this.checkbox_obj.checked= true;
	                    $(this).addClass('selected');
	                    selected_rows.push(this);
					}
                }
            });
        }
    );


}