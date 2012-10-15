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


function TimeTrackingTable(html_canvas_element) {
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



function TimeTrackingForm() {

    var ttf = this;
    
    /*
    * Gather fields
    */
    ttf.$projectInput= $("input.project");    
    if(ttf.$projectInput.length != 1) {
        console.warn("Couldn't find project field");
        return;
    }
    
    ttf.$projectId= $("#effort_project_id");    
    if(ttf.$projectId.length != 1) {
        console.warn("Couldn't find project id field");
        return;
    }

    ttf.$taskId= $("#effort_task_id");    
    if(ttf.$projectId.length != 1) {
        console.warn("Couldn't find task id field");
        return;
    }
    
    ttf.$taskInput= $("input.task");    
    if(ttf.$taskInput.length != 1) {
        console.warn("Couldn't find task field");
        return;
    }
    
    ttf.$startTime= $("input#effort_start");    
    if(ttf.$startTime.length != 1) {
        console.warn("Couldn't find start time field");
        return;
    }
    ttf.$duration= $("input#effort_duration");    
    if(ttf.$duration.length != 1) {
        console.warn("Couldn't find duration field");
        return;
    }

    ttf.$endTime= $("input#effort_end");    
    if(ttf.$endTime.length != 1) {
        console.warn("Couldn't find end time field");
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
            if( ttf.$projectId.val() != value) {
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
    
    // this.getTimeFieldStatus= function( $f ) {
    //     if($f.val() )
    //     
    // }
    
    /**
    * Timer function to update duration fields
    */
    this.updateTimeFields= function() 
    {
        var startTimeSeconds= getTimeFromString( $startTime.val() );
        var endTimeSeconds =  getTimeFromString( $endTime.val() );

        if( startTimeSeconds != 0) {
            if ($endTime.data('isNow')) {
                var duration = Data.now()/1000 - startTimeSeconds;
                if ( duration > 0) {
                    $duration.val( parseInt(duration)+"".toHHMMSS() );  
                }
            }
        }
    }
    
    this.getTimeSecondsFromString = function( str )
    {
        var match_hours = /^\s*(\d+):?(\d*)\s*(am|pm)?\s*$/;
        if( match_hours.exec(str )) {
            var hours = RegExp.$1 * 1;
            var minutes = RegExp.$2 * 1;
            var ampm = RegExp.$3;
            if( ampm =='pm' || ampm=='PM' && hours <= 12) {
                hours+= 12;
            }

            var t= new Date();
            t.setMinutes(0);
            t.setHours(0);
            t.setSeconds(0);
            t *= 0.001;
            t += hours * 60 * 60 + minutes * 60;
            return t;
        }
        return 0;
    }

    this.getDurationFromString = function( str )
    {
        if( str.match(/^\s*(\d+):?(\d*)\s*$/ ) ) {
            var hours = RegExp.$1 * 1;
            var minutes = RegExp.$2 * 1;
            
            return hours * 60 * 60 + minutes * 60;
        }
        
        var h = str * 1.0;
        if( h != 0) {
            return h * 60 * 60;
        }    
        return 0;
    }




    
    this.getTimeStringFromSeconds = function( s ) 
    {
        d= new Date(s*1000);
        var hours = d.getHours();
        var minutes = d.getMinutes();
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        return hours + ":" + minutes;
    }
    
    this.setEndToNow = function() {
        ttf.$endTime.addClass('now');
        ttf.$endTime.val('');
        ttf.$endTime.attr('placeholder','now');
    }

    /**
    * events for start time
    */
    if(ttf.$startTime.val() == '') {
        s= Date.now()*0.001;
        ttf.$startTime.val( ttf.getTimeStringFromSeconds(s) );        
        
    }
    
    ttf.$startTime.click(function(event) {
        ttf.$startTime.select();
        return false;
    });
    
    ttf.$startTime.blur(function(event){
        var v = ttf.$startTime.val();
        if( v!='') {
            var s = ttf.getTimeSecondsFromString(v);
            ttf.$startTime.val( ttf.getTimeStringFromSeconds(s) );
        }        
        ttf.updateDuration();
    });
    
    
    /**
    * events for end time
    */
    ttf.$endTime.click(function(event) {
        ttf.$endTime.removeClass('now');        
        ttf.$endTime.select();
        $
        return false;
    });
    
    ttf.$endTime.blur(function(event){
        if( ttf.$endTime.val()=='' || ttf.$endTime.val() == 'now') {
            ttf.setEndToNow();
        }
        else {
            var s = ttf.getTimeSecondsFromString(ttf.$endTime.val());
            ttf.$endTime.val( ttf.getTimeStringFromSeconds(s) );
        }
        ttf.updateDuration();
    });
    

    ttf.$duration.blur(function(event){
        var d = ttf.getDurationFromString( ttf.$duration.val() );
        var st = ttf.getDurationFromString( ttf.$startTime.val() );
        var et = ttf.getDurationFromString( ttf.$startTime.val() );
        var now = Date.now() * 0.001;
        if( d > 0) {
            if( st == 0 && et == 0) {
                ttf.$startTime.val( ttf.getTimeStringFromSeconds( now - d ));
            }
            else if ( st == 0) {
                ttf.$startTime.val( ttf.getTimeStringFromSeconds( et - d ));                
                ttf.$duration.val('');
            }
            else {
                ttf.$endTime.val( ttf.getTimeStringFromSeconds(  d + ttf.getTimeSecondsFromString( ttf.$startTime.val()) ));
                ttf.$duration.val('');
            }
        }
        ttf.updateDuration();        
    });

    /**
    * For precise storage we store time in seconds after 1970 but only show hh:mm for current time
    */
    this.setTimeSeconds= function($element, seconds) {
        $element.data('seconds', seconds);
        $element.val( getTimeStringFromSeconds(seconds) );
    }
    this.getTimeSeconds= function($element) {
        return $element.data('seconds');
    }
    
    
    /**
    * Timer to update duration
    */
    this.updateDuration = function() {
        var st = ttf.getTimeSecondsFromString( ttf.$startTime.val() );
                        
        var et;
        if( ttf.$endTime.val() == '') {
            et = Date.now() * 0.001;
        } 
        else {
            et= ttf.getTimeSecondsFromString( ttf.$endTime.val() );
        }
        if( st > 0 ) {
            ttf.$duration.attr('placeholder', ttf.getDurationStringFromSeconds( et-st));            
        }
        else {
            ttf.$duration.attr('placeholder', '???');                
        }
    }    
    setInterval(this.updateDuration, 1000);
    
    
    this.getDurationStringFromSeconds= function(s) {
        var s= parseInt(s);
        if(s < 60 ) {
            return s+"s";
        }
        else {
            var seconds = s % 60;
            var minutes = (s/60) % 60 << 0;
            var hours = s / 60 / 60 << 0;
            
            seconds = seconds < 10 ? "0"+seconds : seconds; 
            minutes = minutes < 10 ? "0"+minutes : minutes; 

            hours   = hours   < 10 ? "0"+hours   : hours  ; 
            return hours + ":" + minutes;                
        } 
    }
    
}


