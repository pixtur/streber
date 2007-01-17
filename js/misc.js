/**
 * all jquery-functions, no special relation
 *
 * is been called on load
 *
 * included by:
 *
 * @author:     Tino Beirau
 * @uses:
 * @usedby:
 */

var onLoadFunctions= new Array();

function misc()
{

    $("#sideboard").click(function(){
      $(this).hide("slow");
      return false;
    });

    /**
    * visual effects
    *
    *  - hideBlock
    *  - showBlock
    */

    // show Block
    $("div.block.closed h2.table_name").click
    (

        function()
        {
            myHeadName= this.parentNode.parentNode.id;
            myHead= document.getElementById(this.parentNode.parentNode.id);
            //alert(myHeadName);
            myBodyName= myHeadName.replace(/_short/, "_long");
            //alert(myBodyName);
            myBody= document.getElementById(myBodyName);
            myHead.style.display = 'none';
            myBody.style.display = 'block';
            /*$(myBody).slideDown("fast");*/

            return false;
        }
    );

    // hide Block
    $("div.block.opened h2.table_name").click
    (
        function()
        {
            myHeadName= this.parentNode.parentNode.id;
            myHead= document.getElementById(this.parentNode.parentNode.id);
            //alert(myHeadName);
            myBodyName= myHeadName.replace(/_long/, "_short");
            //alert(myBodyName);
            myBody= document.getElementById(myBodyName);
            myHead.style.display = 'none';
            myBody.style.display = 'block';
            /*$(myHead).slideUp("fast");*/
            //$(myBody).slideDown("fast");

            return false;
        }
    );


	/*******************************************************
    * Form - visual effects
    *
    */

	/**
	* chose between current or next project in notes on person dialog
	* show and hide project list / project input field
	*/
    $('body.taskNoteOnPersonEdit #new_project').click
    (
        function(e)
        {
            if(this.checked)
            {
            	$('div.form #proj_list').slideUp('300');
				$('div.form #proj_new_input').slideDown('300');
            }
            else
			{
               	$('div.form #proj_new_input').slideUp('300');
				$('div.form #proj_list').slideDown('300');
            }
        }
    );


    /**
    * toggle between different tabgroups
    */
    TabGroup = {
      init: function() {
        $('div.tabgroup').each(function(){
          var f = TabGroup.click;
          var group = this;
          $('.tab_header', group).each(function(){
            this.group = group;
            $(this).click(f);
            //$('#'+this.id+'-body').hide();
            $('#'+this.id+'-body').addClass('Hidden');
          }).filter(':first').trigger('click');
        });
        $('.tabgroup ul li:first').addClass('Active');
        $('.tabgroup div:first').removeClass('Hidden');
      },
      click: function(e) {
        //alert("click("+this.id+")");
        //alert("removeHidden from"+ tab);

        var tab = $('#'+this.id+'-body').get(0);

        $('.tab_header', this.group).each(function(){
          $(this).removeClass('Active');
          //$('#'+this.id+'-body').hide();
          $('#'+this.id+'-body').addClass('Hidden');
        });
        $(this).addClass('Active');
        //$(tab).show();

        $(tab).removeClass('Hidden');
        //this.blur();
        e.preventDefault();
      }
    };
    TabGroup.init();


    /**
    * in taskEdit hide and show tabs depending on task category
    */
    TaskEditTabs = {
        init:function() {
            $('select#task_category').change(function(e) {
                switch(this.value) {

                    //--- task ---
                    case '0':
                        $('div.tabgroup li#task').show();
                        $('div.tabgroup li#bug').hide();
                        $('div.tabgroup li#timing').show();
                        $('div.tabgroup li#task').trigger('click');
                        break;

                    //--- bug ---
                    case '1':
                        $('div.tabgroup li#task').show();
                        $('div.tabgroup li#bug').show();
                        $('div.tabgroup li#timing').show();
                        $('div.tabgroup li#task').trigger('click');
                        break;

                    //--- documentation ---
                    case '2':
                        $('div.tabgroup li#task').hide();
                        $('div.tabgroup li#bug').hide();
                        $('div.tabgroup li#timing').hide();
                        $('div.tabgroup li#description').trigger('click');
                        break;

                    //--- folder ---
                    case '3':
                        $('div.tabgroup li#task').show();
                        $('div.tabgroup li#bug').hide();
                        $('div.tabgroup li#timing').show();
                        $('div.tabgroup li#description').trigger('click');
                        break;

                   //--- event ---
                    case '4':
                        $('div.tabgroup li#task').show();
                        $('div.tabgroup li#bug').hide();
                        $('div.tabgroup li#timing').show();
                        $('div.tabgroup li#description').trigger('click');
                        break;

                   //--- milestone ---
                    case '10':
                        $('div.tabgroup li#task').show();
                        $('div.tabgroup li#bug').hide();
                        $('div.tabgroup li#timing').show();
                        $('div.tabgroup li#description').trigger('click');
                        break;

                  //--- version ---
                    case '11':
                        $('div.tabgroup li#task').show();
                        $('div.tabgroup li#bug').hide();
                        $('div.tabgroup li#timing').show();
                        $('div.tabgroup li#description').trigger('click');
                        break;
                }
            });
        }
    }
    TaskEditTabs.init();
    $('select#task_category').trigger('change');
    
    /**
    * call onload functions 
    */
    for(i=0; i < onLoadFunctions.length; i++) {
        onLoadFunctions[i]();        
    }
}