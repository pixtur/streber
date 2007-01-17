/**************************************************
 * DragSlider
 * 2005-05-16
 * thomas@pixtu.de / orignal concept by www.youngpup.net
 * sometimes fired off the handle, not the root.
 **************************************************/

 /*
    Thursday, January 01, 1970 02:00:00

 */
 function string2UTC(str) {
    var year=2005;
    var month=1;
    var day=1;
    var hour=12;
    var min=0;
    var sec=0;
    var my_date;

    var check=/\b(\d?\d)\.(\d?\d)\.(\d\d\d\d)\b/;
    arr=check.exec(str);
    if(arr) {
        day=1*arr[1];
        month=1*arr[2]-1;
        year=1*arr[3];
        return Date.UTC(year, month, day, hour, min, sec);
    }
    check=/\b(\d\d\d\d)-(\d\d)-(\d\d)\s*(\d\d):(\d\d):(\d\d)\b/;
    arr=check.exec(str);
    if(arr) {
        year=1*arr[1];
        month=1*arr[2]-1;
        day=1*arr[3];
        hour=1*arr[4];
        min=1*arr[5];
        sec=1*arr[6];
        return Date.UTC(year, month, day, hour, min, sec);
    }

    dateObj=new Date(Date.parse(str));
    if(!isNaN(1*dateObj)) {
        if(dateObj.getSeconds()==0 && dateObj.getMilliseconds()==0 && dateObj.getMinutes()==0 && dateObj.getHours()==0) {
            dateObj.setHours(12);
        }
        return 1*dateObj;
    }
    return 0;
}

 var DragSlider = {

	obj : null,

	init : function(o, field,type,speed)
	{
		if(typeof o == 'string') {
			o=document.all ? document.all[o] : document.getElementById(o);
		}
		if(typeof field=='string') {
			o.field=document.all ? document.all[field] : document.getElementById(field);
		}
		o.onmousedown	= DragSlider.start;

		o.type = type && type != null ? type : null; ;
		o.root =  o ;
		o.speed = speed && speed != null ? speed : 10 ;

		o.root.onDragStart	= new Function();
		o.root.onDragEnd	= new Function();
		o.root.onDrag		= new Function();
	},

	start : function(e)
	{
		var o = DragSlider.obj = this;
		e = DragSlider.fixE(e);
		var y = parseInt(o.root.style.top);
		var x = parseInt(o.root.style.left);
		o.root.onDragStart(x, y);

		o.startMouseX= o.lastMouseX	= e.clientX;
		o.startMouseY= o.lastMouseY	= e.clientY;

		document.onmousemove	= DragSlider.drag;
		document.onmouseup		= DragSlider.end;
        if(o.type=='datetime') {
            o.speed=20;
            tmpDate=new Date(string2UTC(o.field.value));
            tmpDate.setSeconds(0);
            tmpDate.setMinutes( Math.floor(tmpDate.getMinutes()/30)*30);

            o.orgValue= 1*tmpDate;
            //alert("1# o.orgVlaue="+o.orgValue);
        }
        else if(o.type=='time') {
            o.speed=20;
            var str= o.field.value;
            var numbers=str.split(":");
            var hour=0;
            var min=0;
            var sec=0;
            if(numbers.length==2) {
                hour= 1*numbers[0];
                min=1*numbers[1];
            }
            else if(numbers.length==3) {
                hour= 1*numbers[0];
                min=1*numbers[1];
                sec=1*numbers[2];
            }

            o.orgValue= (hour-1)*60*60*1000+ min*60*1000+ sec*1000;

        }
        else {
    		o.orgValue= o.field ? 1*o.field.value : 0;
        }
        //alert("2# o.orgValue "+o.orgValue);
		return false;
	},

	drag : function(e)
	{
		e = DragSlider.fixE(e);
		var o = DragSlider.obj;

		var ey	= e.clientY;
		var ex	= e.clientX;
		var y = parseInt(o.root.style.top);
		var x = parseInt(o.root.style.left);
		var nx, ny;

		nx = x + ((ex - o.lastMouseX) * (o.hmode ? 1 : -1));
		ny = y + ((ey - o.lastMouseY) * (o.vmode ? 1 : -1));

		DragSlider.obj.lastMouseX	= ex;
		DragSlider.obj.lastMouseY	= ey;

        var org_value=0;
        if(o.type=='datetime') {
            //cur_value= Date.parse(o.field.value);
    		cur_value=o.orgValue+ Math.floor((o.lastMouseX-o.startMouseX)/o.speed)*1000*30*60;
            //alert("cur_value="+cur_value);
            var date=new Date(cur_value);
            o.field.value=date.toLocaleString();
        }
        else if(o.type=='time') {

            var mouse_dist=Math.floor((o.lastMouseX-o.startMouseX)/o.speed);
            var dyn_factor= (mouse_dist/7)*(mouse_dist/7)+1;
    		var cur_value=o.orgValue+ mouse_dist*1000*1*60*dyn_factor;
            var date=new Date(cur_value);
            if(dyn_factor > 6) {
                date.setMinutes(0);
            }
            //alert("cur_value="+cur_value);
            //alert("date="+date);
            o.field.value=date.getHours()+":"+date.getMinutes();
        }
        else {
    		org_value= o.field ? 1*o.field.value : 0;
    		o.field.value=org_value+ Math.floor((o.lastMouseX-o.startMouseX)/o.speed);
        }

		DragSlider.obj.root.onDrag(nx, ny);
		return false;
	},

	end : function()
	{
		var o = DragSlider.obj;

		document.onmousemove = null;
		document.onmouseup   = null;
        if(o.field.onChange) {
            o.field.onChange();
        }
		DragSlider.obj.root.onDragEnd(	parseInt(DragSlider.obj.root.style.left),
									parseInt(DragSlider.obj.root.style.top));

		o.field.select();
		DragSlider.obj = null;
	},

	fixE : function(e)
	{
		if (typeof e == 'undefined') e = window.event;
		if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
		if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
		return e;
	}
};