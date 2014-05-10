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
    
/**
* global variables
*/

function selectListEntry(elem)
{

}

jQuery(function($){
   $('li')
      .click(function() 
      {
         $('li.selected').removeClass('selected');
         $(this).addClass('selected');

         $.post('index.php?go=taskAjax',{
           go: 'taskAjax',
           tsk: $(this).data('id')
         }, function(str) {
             $('.details-container').html(str);
             $('.details-container div.wiki.editable').each(function() {
                 aj= new AjaxWikiEdit(this);
                 ajax_edits.push(aj);
                 this.ajax_edit= aj;
             });
             $('.details-container h3.editable').each(function() {
               console.log(this);
               aj= new AjaxTextFieldEdit(this);
               //ajax_edits.push(aj);
               this.ajax_edit= aj;
             });

         });
      })       
      .drag("start",function( ev, dd )
      {
         $(this)
            .css("opacity", 0.1);
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
