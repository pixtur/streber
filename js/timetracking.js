/**
 * all jquery-functions, no special relation
 *
 * is been called on load
 *
 * included by:
 *
 * @author     Tino Beirau
 * @uses:
 * @usedby:
 */

/**
* global variables
*/
var onLoadFunctions= new Array();
var ajax_edits= new Array();


function TimeTracking(html_canvas_element) {
    this.canvas= html_canvas_element;
    this.container = undefined;
    this.days = 3;
    this.timeBlocks = {};
    this.context= undefined;
    
    this.renderTimeblock= function( block ) {
        var c= this.context;
        c.fillStyle = "#dddd00";
        c.fillRect(0, 0, 100, 40);        
    }
    
    this.start_time_today = undefined;
    this.end_time_today = undefined;
    
    this.DATE_WIDTH = 180;
    this.DAY_HEIGHT= 20;
    this.TIMELINE_HEIGHT = 20;

    this.NUM_DAYS_SHOWN = 4;    
    this.FIRST_HOUR = 7;
    this.LAST_HOUR = 25;
    
    this.daysSinceToday =  function(t) {
        return Math.floor((t - this.start_time_today) / (60*60*24));        
    }
    
    this.xFromTime = function(t)  {
        
        t -= this.daysSinceToday(t) *60*60*24;
                
        var _width= (this.canvas.width - this.DATE_WIDTH);
        var _ratio= (t - this.start_time_today) / (this.end_time_today - this.start_time_today); 
        return _width * _ratio + this.DATE_WIDTH;
    }
    
    this.updateCurrentTime = function() 
    {        
        var x = window.timetracker.xFromTime(Date.now() / 1000 + 2*60*60);
        $('.currentTime').css('left', x );
    }
    
    this.updateCanvas = function() 
    {
        this.canvas.width=$("body").width();
        this.updateCurrentTime();
        // get the canvas context and assign it to 'c' for ease of use
        this.context= this.canvas.getContext('2d');
        this.canvas.width=  width=$("body").width();
        this.canvas.height= this.NUM_DAYS_SHOWN * this.DAY_HEIGHT + this.TIMELINE_HEIGHT;
//        this.context.scale(1,1);
        
        // c.fillStyle = "#dddddd";
        // c.fillRect(0, 0, this.canvas.width-2, 400);
        
        this.context.strokeStyle = "rgba(0, 0, 0,0.25)";
        this.context.lineWidth=0.5;
        this.context.font = "lighter 13px Helvetica";
        this.context.fillStyle = "#aaa";
        
        // Horizontal Lines (days)
        for(var i=0; i <= this.NUM_DAYS_SHOWN; ++i) {
            this.context.beginPath();
            var y= Math.floor(i * this.DAY_HEIGHT)+0.6;
            this.context.moveTo(0,y );
            this.context.lineTo(this.canvas.width, y);
            this.context.stroke();
            
            if( i < this.NUM_DAYS_SHOWN) {
                var d3= new Date( new Date().getTime() + 24*60*60*1000* (i+1-this.NUM_DAYS_SHOWN));
                this.context.fillText(d3.toLocaleDateString(), 10, y + this.DAY_HEIGHT - 5);                
            }
        }
        
        
        // Vertical Lines (hours)
        var hours = this.LAST_HOUR - this.FIRST_HOUR;
        this.context.textAlign = "center";
        for(var i=0; i <= hours; ++i) {
            this.context.beginPath();
            var x= this.xFromTime( (i + this.FIRST_HOUR) * 60*60 );
            //var x= (this.canvas.width - this.DATE_WIDTH) / hours * i + this.DATE_WIDTH;
            this.context.moveTo(x,0 );
            this.context.lineTo(x, this.canvas.height - this.TIMELINE_HEIGHT);
            this.context.stroke();
            
            this.context.fillText(i + this.FIRST_HOUR, x, this.canvas.height- 3);
        }

        
        // create timeblocks
        this.container.innerHTML="";
        for( var key in this.timeBlocks) {
            this.createTimeblock( this.timeBlocks[key])
        }
    }
    
    this.createTimeblock = function(b) 
    {        
        var d = this.daysSinceToday(b.start);
        if(d > 0 || d <= -this.NUM_DAYS_SHOWN) {
            return;
        }

        var x1= this.xFromTime(b.start);
        var x2= this.xFromTime(b.start + b.duration);

        var blockElement = $("<a href='" + b.id +  "' class=timeblock>" + b.title + "</a>");
        blockElement.css('top',(this.canvas.height - (-d+1) * this.DAY_HEIGHT - this.TIMELINE_HEIGHT + 1 )+"px");
        blockElement.css('left',x1+"px");
        blockElement.css('width',Math.floor(x2-x1)+"px");
        $(this.container).append(blockElement);
    }
    
    this.init = function() 
    {
        window.timetracker = this; //very evil hack

        var start= new Date();
        start.setMinutes(0);
        start.setHours(this.FIRST_HOUR);
        start.setSeconds(0);
        this.start_time_today = start/1000 + 2*60*60;


        var e= new Date();
        e.setMinutes(0);
        e.setHours(this.LAST_HOUR);
        e.setSeconds(0);
        this.end_time_today = e/1000 + 2*60*60;
        
        
        var canvas = document.getElementById("myCanvas");
        if (canvas && canvas.getContext){
            this.canvas = canvas;
        } 
        
        this.container = $('.container')[0];

        this.updateCanvas();
        $.ajax({
          url: "./index.php?go=ajaxUserEfforts",
          cache: false,
          dataType: "JSON",
          context:this,
        }).done(function( data ) {
            this.timeBlocks = data;
            this.updateCanvas();
        });

        $(window).resize(function(e) {
            window.timetracker.updateCanvas();
        });
        
        // Set time to update time indicator
        setInterval(this.updateCurrentTime, 5000);
        
        
    }
    this.init();
}

function initTimetrackingForm() 
{        
    var ttf = this;
    
    /*
    * Gather fields
    */
    ttf.$projectInput= $("input.project");    
    if($projectInput.length == 0) {
        console.warn("Couldn't find project field");
        return;
    }
    
    ttf.$projectId= $("#effort_project_id");    
    if($projectId.length == 0) {
        console.warn("Couldn't find project id field");
        return;
    }

    ttf.$taskId= $("#effort_task_id");    
    if($projectId.length == 0) {
        console.warn("Couldn't find task id field");
        return;
    }
    
    ttf.$taskInput= $("input.task");    
    if($taskInput.length == 0) {
        console.warn("Couldn't find task field");
        return;
    }
    
    
    /*
    * Setup project autocomplete search (should actually be preloaded...)
    */
    var ac= new $.Ninja.Autocomplete(ttf.$projectInput, {
        get:function (q, callback) {
            $.ajax({
                url: 'index.php',
                dataType: 'json',
                data: {
                    go: 'ajaxUserProjects',
                    q: q
                },
                success: function (data) {
                    var rich_value_map = {};

                    values= $.map(data, function (item) {
                      rich_value_map[item.name]= item.id;
                      return item.name;
                    });
                    ttf.$projectInput.data('rich-values', rich_value_map);
                    callback(values);
                },

            error: function (request, status, message) {
              $.ninja.error(message);
            }
          });
        },
        select:function() {
            var value = ttf.$projectInput.data('rich-values')[ this.$element.val() ];
            if( $projectId.val() != value) {
                ttf.$projectId.val( value );
                ttf.$taskInput.val('');
                ttf.$taskId.val(0);
                console.log('set project_id:' + value);                
            }
        }
    });

    /*
    * Setup Task autocomplete search (should actually be preloaded...)
    */
    var ac= new $.Ninja.Autocomplete(ttf.$taskInput, {
        get:function (q, callback) {
            $.ajax({
                url: 'index.php',
                dataType: 'json',
                data: {
                    go: 'ajaxUserTasks',
                    q: q,
                    prj: ttf.$projectId.val()
                },
                success: function (data) {
                    var rich_value_map = {};

                    values= $.map(data, function (item) {
                      rich_value_map[item.name]= item.id;
                      return item.name;
                    });
                    ttf.$taskInput.data('rich-values', rich_value_map);
                    callback(values);
                },

            error: function (request, status, message) {
              $.ninja.error(message);
            }
          });
        },
        select:function() {
            var value = ttf.$taskInput.data('rich-values')[ this.$element.val() ];
            ttf.$taskId.val( value );            
            console.log('task-id:' + value);
        }
    });
}


