 // context menu data objects
var cMenu = new Object( );

// position and display context menu
function showContextMenu(evt) {
    // hide any existing menu just in case
    hideContextMenus( );
    evt = (evt) ? evt : ((event) ? event : null);
    if (evt) {
        var elem = (evt.target) ? evt.target : evt.srcElement;
         if (elem.nodeType == 3) {
            elem = elem.parentNode;
        }

        var table_id="";
        if(elem.tagName == 'TD') {
            var par= elem.parentNode;
            table_id= cMenu.table_id= par.parentNode.parentNode.id;
            cMenu.tr_id= par.id;
        }

        //--- look for menu-defintion ----
        for (var i in cMenu.menus) {

            if(elem && table_id == i) {

            //alert("table_id="+elem.tagName);
            //if (elem && table_id == "tasks") {

                var menu = document.getElementById(cMenu.menus[table_id].menuID);

               /* var list_elem= document.getElementById(cMenu[table_id].menuID+"_items");
                alert(list_elem);
                var children= list_elem.childNodes;

                while(list_elem.hasChildNodes()) {
                      var knoten= list_elem.firstChild;
                    alert ("knoten="+knoten);
                    list_elem.removeChild(knoten);
                }
                */

                //alert("menu is now"+menu);
                // turn on IE mouse capture
                if (menu.setCapture) {
                    menu.setCapture( );
                }
                // position menu at mouse event location
                var left, top;
                if (evt.pageX) {
                    left = evt.pageX;
                    top = evt.pageY;
                //} else if (evt.offsetX || evt.offsetY) {
                //    left = evt.offsetX;
                //    top = evt.offsetY;
                } else if (evt.clientX) {
                    left = evt.clientX;
                    top = evt.clientY;
                }
                menu.style.display="block";
                menu.style.left = left + "px";
                menu.style.top = top + "px";
                menu.style.visibility = "visible";
                if (evt.preventDefault) {
                    evt.preventDefault( );
                }
                evt.returnValue = false;
            }
        }
    }
}

// retrieve URL from cMenu object related to chosen item
function getMenuItem(tdElem) {
    var div = tdElem.parentNode.parentNode.parentNode.parentNode;
    var index = tdElem.parentNode.rowIndex;
    for (var i in cMenu.menus) {
        if (cMenu.menus[i].menuID == div.id) {
            cMenu.cur_item=cMenu.menus[i].items[index];
            cMenu.cur_menu=cMenu.menus[i];
            return cMenu.menus[i].items[index];
        }
    }
    return "";
}

// navigate to chosen menu item
function execMenu(evt) {
    evt = (evt) ? evt : ((event) ? event : null);
    if (evt) {
        var elem = (evt.target) ? evt.target : evt.srcElement;
        if (elem.nodeType == 3) {
            elem = elem.parentNode;
        }
        if (elem.className == "menuItemOn") {
            var item=getMenuItem(elem);

            //--- submit-actions for one of more items ---------
            if(item.type == 'submit') {
                var num_selected= getNumSelected(cMenu.table_id);
                //alert("exec!"+ item +","+cMenu.table_id +","+cMenu.tr_id);

                if(!num_selected) {
                    checkbox= document.getElementById(cMenu.tr_id+"_chk");
                    checkbox.checked=1;
                }

                if(item.go) {
                    document.my_form.go.value=item.go;
                }
                document.my_form.submit();
            }
        //    location.href = getHref(elem);
        }
        hideContextMenus( );
    }
}

function getNumSelected(table_id) {
    var counter=0;
    //alert("table_id="+table_id);
    var checkboxes=document.getElementsByTagName('input');
    for(i in checkboxes) {
        //alert("c="+ checkboxes[i] +" c.id="+checkboxes[i].id);
        c=checkboxes[i];
        if(c.id && c.id.indexOf(table_id)!=-1) {
            //alert("checkbox:"+c);
            counter+= c.checked;
        }
    }
    //alert("num checkboxes="+counter);
    return counter;
}

// hide all context menus
function hideContextMenus( ) {
    if (document.releaseCapture) {
        // turn off IE mouse event capture
        document.releaseCapture( );
    }
    for (var i in cMenu.menus) {
        //alert("hide="+cMenu.menus[i].menuID);
        var div = document.getElementById(cMenu.menus[i].menuID);
        //alert("div="+div);
        div.style.visibility = "hidden";
    }
}

// rollover highlights of context menu items
function toggleHighlight(evt) {
    evt = (evt) ? evt :
 ((event) ? event : null);
    if (evt) {
        var elem = (evt.target) ? evt.target : evt.srcElement;
        if (elem.nodeType == 3) {
            elem = elem.parentNode;
        }
        if (elem.className.indexOf("menuItem") != -1) {
            elem.className = (evt.type == "mouseover") ? "menuItemOn" : "menuItem";
        }
    }
}

// set tooltips for menu-capable and lesser browsers
function setContextTitles( ) {
    var cMenuReady = (document.body.addEventListener ||
        typeof document.oncontextmenu != "undefined")
    var spans = document.body.getElementsByTagName("span");
    for (var i = 0; i < spans.length; i++) {
        if (spans[i].className == "contextEntry") {
            if (cMenuReady) {
                var menuAction = (navigator.userAgent.indexOf("Mac") != -1) ?
                    "Click and hold " : "Right click ";
                spans[i].title = menuAction + "to view relevant links"
            } else {
                spans[i].title = "Relevant links available with other browsers " +
                "(IE5+/Windows, Netscape 6+)."
                spans[i].style.cursor = "default";
            }
        }
    }
}

// bind events and initialize tooltips
function initContextMenus( ) {
    if (document.body.addEventListener) {
        // W3C DOM event model
        document.body.addEventListener("contextmenu", showContextMenu, true);
        document.body.addEventListener("click", hideContextMenus, true);
    } else {
        // IE event model
        document.body.oncontextmenu = showContextMenu;
    }
    // set intelligent tooltips
    setContextTitles( );

}

/*
function addMenu(table,menu_div) {
    cMenu.menus[table]={menuID:menu_div};
    //alert("addMenu="+table+","+menu_div);
}
*/


 function SelectJump() {
    var welcherLink = document.Springen.URLs.selectedIndex;
    document.Springen.URLs.selectedIndex = "0";
    if(welcherLink > "0"){
       top.location.href = document.Springen.URLs.options[welcherLink].value;
    }
 }
