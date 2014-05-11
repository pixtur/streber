/**
 * javascript functions related to timetracking
 *
 * is been called on load
 *
 * included by:
 *
 * @author     Thomas Mann
 * @uses:
 * @usedby:
 */

// after loading...
$(function() {
   $('.new-task').each( function() {   
      var x= new NewTaskLine(this);
   });
});


function selectListEntry(elem)
{
   $('li.selected').removeClass('selected');
   $(elem).addClass('selected');

   $.post('index.php?go=taskAjax',{
     go: 'taskAjax',
     tsk: $(elem).data('id')
   }, function(str) {
       $('.details-container').html(str);
       $('.details-container div.wiki.editable').each(function() {
           aj= new AjaxWikiEdit(this);
           ajax_edits.push(aj);
           this.ajax_edit= aj;
       });
       $('.details-container h3.editable').each(function() {         
         aj= new AjaxTextFieldEdit(this);         
         this.ajax_edit= aj;
       });
   });
}


function NewTaskLine(dom_element) 
{
   var _self = this;
   _self.dom_element= dom_element;
   _self.ol = $(_self.dom_element).parent('div').children('ol');
   
   $(_self.dom_element).click(function(e) 
   {
      _self.activateNewTaskLine();
   });

   this.activateNewTaskLine= function()    
   {
      $(_self.ol).children('li.new-task-line').remove();            

      var block= $("<li class='new-task-line'>\
                     <input placeholder='Task Name'> \
                     <button>Add</button>\
                  </li>"); 

      _self.ol.append(block); // We have to append before setting focus...
      var order_id = $(block).index();
   
      block
         .find('input')
         .focus();

      block
         .find('button')         
         .click(function(e) {
            e.preventDefault();

            var input= $(_self.ol).find('li.new-task-line input');

            if(!input.val()) {
               console.log("name can't be empty");
               return;
            }
            
            // insert new task
            $.post('index.php',{
               go:           'taskAjaxCreateNewTask',
               name:         input.val(),
               milestone_id: $(_self.ol).parent('div').data('milestone-id'),
               project_id:   $(_self.ol).parent('div').data('project-id'),
               order_id:     order_id,               
            }, function(str) {
               console.log(str);
               _self.ol.append(str);
            });
         });      
   }
}



jQuery(function($){
   $('li')
      .click(function() 
      {
         selectListEntry(this);
      })       
      .drag("start",function( ev, dd )
      {
         $(this)
            .css("opacity", 0.1);
         selectListEntry(this);
         return $( this ).clone()
            .css("opacity", .75 )
            .addClass("proxy")
            .appendTo( this.parentNode );
      
      })
      .drag(function( ev, dd ){
         var drop = dd.drop[0],
         method = $.data( drop || {}, "drop+reorder" );
         $( dd.proxy ).css({
            top: dd.offsetY
            //left: dd.offsetX
         });
   
         
         if ( drop && ( drop != dd.current || method != dd.method ) ){   
            $( this )[ method ]( drop );
            dd.current = drop;
            dd.method = method;
            dd.update();
         }
      })
      .drag("end",function( ev, dd ){      
         var finalPosY=  $(this).position().top; 
         var e = this;
         $( dd.proxy ).animate({
            top: finalPosY
         },{
            duration: 100,
            complete: function(){
               $(this).remove();
               $(e).css("opacity",1);
            }            
         })
         $( this ).removeClass('dragging');

         $.post('index.php',{
            go: 'taskSetOrderId',
            task_id: $(e).data('id'),
            order_id: $(e).index(),
            milestone_id: $(e).parents('div.task-group').data('milestone-id'),
         }, 
         function(result) {
            console.log(result);
         });
      })
      .drop("init",function( ev, dd ){
         return !( this == dd.drag );
      });   
   $.drop({
      tolerance: function( event, proxy, target ){         
         var test = event.pageY > ( target.top + target.height / 2 );
         $.data( target.elem, "drop+reorder", test ? "insertAfter" : "insertBefore" );   
         return this.contains( target, [ event.pageX, event.pageY ] );
      }
   });
});
