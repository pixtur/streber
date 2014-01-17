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

    this.NUM_DAYS_SHOWN = 6;
    this.FIRST_HOUR = 5;
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
        var d= new Date();
        var x = window.timetracker.xFromTime((Date.now() - d.getTimezoneOffset()*60*1000) / 1000);
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
        var morningOffset = 0;
        // if( Date.now() * 0.001 < this.start_time_today ) {
        //     morningOffset= -1;
        // }
        var d = this.daysSinceToday(b.start) + morningOffset;
        if(d > 0 || d <= -this.NUM_DAYS_SHOWN) {
            return;
        }

        var x1= this.xFromTime(b.start);
        var x2= this.xFromTime(b.start + b.duration);

        var blockElement = $("<a href='" + b.id +  "' class=timeblock>" + b.title + "</a>");
        blockElement.css('top',(this.canvas.height - (-d+1) * this.DAY_HEIGHT- this.TIMELINE_HEIGHT + 1 )+"px");
        blockElement.css('height', this.DAY_HEIGHT  * b.productivity / 5);
        blockElement.css('margin-top', this.DAY_HEIGHT  * (5-b.productivity) / 5);
        blockElement.css('background-color', b.color);
        blockElement.css('left',x1+"px");
        blockElement.css('width',Math.floor(x2-x1)+"px");
        blockElement.attr('title', b.tooltip);
        $(this.container).append(blockElement);
    }

    this.init = function()
    {
        window.timetracker = this; //very evil hack

        var start= new Date();
        start.setMinutes(0);
        start.setUTCHours(this.FIRST_HOUR);
        start.setSeconds(0);
        this.start_time_today = start/1000;


        var e= new Date();
        e.setMinutes(0);
        e.setUTCHours(this.LAST_HOUR);
        e.setSeconds(0);
        this.end_time_today = e/1000;


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
    ttf.$startSeconds= $("input#effort_start_seconds");
    if(ttf.$startSeconds.length != 1) {
        console.warn("Couldn't find start time seconds field");
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



    ttf.$endSeconds= $("input#effort_end_seconds");
    if(ttf.$endSeconds.length != 1) {
        console.warn("Couldn't find end time seconds field");
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
        }
    });



    this.getTimeStringFromSeconds = function( s )
    {
        var d = new Date(s*1000);
        var hours = d.getHours();
        var minutes = d.getMinutes();
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        return hours + ":" + minutes;
    }

    this.getTimeSecondsFromString = function( str , d)
    {
        var match_hours = /^\s*(\d+):?(\d*)\s*(am|pm)?\s*$/;
        if( match_hours.exec(str )) {
            var hours = RegExp.$1 * 1;
            var minutes = RegExp.$2 * 1;
            var ampm = RegExp.$3;
            if( ampm =='pm' || ampm=='PM' && hours <= 12) {
                hours+= 12;
            }

            //var t= new Date();
            d.setHours(hours);
            d.setMinutes(minutes);
            d.setSeconds(0);
            return d * 0.001;
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

    /**
    * Timer to update duration
    */
    this.updateDuration = function() {
        var st = ttf.getStartTime();
        var et = ttf.getEndTime();
        if( et == 0) {
            et = Date.now() * 0.001;
        }

        if( st > 0 ) {
            ttf.$duration.attr('placeholder', ttf.getDurationStringFromSeconds( et-st ));
        }
        else {
            ttf.$duration.attr('placeholder', '???');
        }
        
        if(et-st <= 0 ) {
            ttf.$duration.addClass('error');
        }
        else {
            ttf.$duration.removeClass('error');
          
        }
    }

    ttf.setStartTime= function(seconds) {
        var seconds = seconds << 0;
        ttf.$startSeconds.val(seconds);
        ttf.$startTime.val( ttf.getTimeStringFromSeconds(seconds) );
        ttf.updateDuration();
        
        var d = new Date( seconds * 1000);
        $('#effort_date').val( d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() );
    }
    ttf.getStartTime= function() {
        return ttf.$startSeconds.val() << 0;
    }

    ttf.setEndTime= function(seconds) {
        var seconds = seconds << 0;
        ttf.$endSeconds.val(seconds);
        ttf.$endTime.val( ttf.getTimeStringFromSeconds(seconds) );
        if( seconds ==0) {
            ttf.$endTime.addClass('now');
            ttf.$endTime.val('');
            ttf.$endTime.attr('placeholder','now');
        }
        ttf.updateDuration();
    }
    ttf.getEndTime= function() {
        return ttf.$endSeconds.val() << 0;
    }



    ttf.$startTime.click(function(event) {
        ttf.$startTime.select();
    });

    ttf.$startTime.blur(function(event){
        var v = ttf.$startTime.val();
        if( v!='') {
            var s = ttf.getTimeSecondsFromString(v, new Date(ttf.getStartTime() * 1000 ));
            ttf.setStartTime(s);
        }
    });
    
    $("#previous_date").click(function(){
      var st= ttf.getStartTime();
      
      //$('#trigger_date').html(e.date.getFullYear() + "-" + (e.date.getMonth()+1) + "-" + e.date.getDate());
      $('#trigger_date').html("1974-07-30");
            
      // var sd = new Date(st * 1000);
      // sd.setFullYear( e.date.getFullYear());
      // sd.setMonth( e.date.getMonth());
      // sd.setDate( e.date.getDate());
      // ttf.setStartTime( sd * 0.001 );
      //                   
      // var et=ttf.getEndTime();
      // var duration = (et==0) ? 60 * 60
      //                        : et - st;
      // ttf.setEndTime( sd * 0.001 + duration );
  
    });
    


    /**
    * events for end time
    */
    ttf.$endTime.click(function(event) {
        ttf.$endTime.removeClass('now');
        ttf.$endTime.select();
    });

    ttf.$endTime.blur(function(event){
        var v = ttf.$endTime.val();
        if( v=='' || v == 'now') {
            ttf.setEndTime(0);
        }
        else {
            var referenceDay= new Date( ttf.getStartTime() * 1000 );
            var sec= ttf.getTimeSecondsFromString(v, referenceDay );
            if ( sec < ttf.getStartTime()) {
                sec += 24 * 60 * 60;
            }
            ttf.setEndTime( sec );
        }
    });


    ttf.$duration.blur(function(event){
        var d = ttf.getDurationFromString( ttf.$duration.val() );
        var st = ttf.getStartTime();
        var et = ttf.getEndTime();
        var now = Date.now() * 0.001;
        if( d > 0) {
            if( st == 0 && et == 0) {
                ttf.setStartTime( now - d );
            }
            else if ( st == 0) {
                ttf.setStartTime( et - d );
                ttf.$duration.val('');
            }
            else {
                ttf.setEndTime( d + st );
                ttf.$duration.val('');
            }
        }
    });


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


    /**
    * events for start time
    */
    if(ttf.$startSeconds.val() == '') {
        ttf.setStartTime( Date.now()*0.001 );
    }
    else {
        ttf.setStartTime( ttf.$startSeconds.val() * 1 );
    }
    //ttf.updateDuration();


    /**
    * init rating
    */


    /**
    * Init calendar
    */
    xcal = Calendar.setup({
        inputField  : "effort_date",
        ifFormat    : "%Y-%m-%d",
        button      : "trigger_date",
        onUpdate: function(e) {
            var st= ttf.getStartTime();
            $('#trigger_date').html(e.date.getFullYear() + "-" + (e.date.getMonth()+1) + "-" + e.date.getDate());
            
            var sd = new Date(st * 1000);
            sd.setFullYear( e.date.getFullYear());
            sd.setMonth( e.date.getMonth());
            sd.setDate( e.date.getDate());
            ttf.setStartTime( sd * 0.001 );
                        
            var et=ttf.getEndTime();
            var duration = (et==0) ? 60 * 60
                                   : et - st;
            ttf.setEndTime( sd * 0.001 + duration );
        }
    });
}


