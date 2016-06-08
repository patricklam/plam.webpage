/*
Alternating row color script by Joost de Valk ( http://www.joostdevalk.nl/ ) to add alternating row classes to a table.
Copyright (c) 2006 Joost de Valk.
*/

/* Don't change anything below this unless you know what you're doing */
addEvent(window, "load", alternate_init);

function alternate_init() {
	// Find all tables with class sortable and make them sortable
	if (!document.getElementsByTagName) return;
	tbls = document.getElementsByTagName("table");
	for (ti=0;ti<tbls.length;ti++) {
		thisTbl = tbls[ti];
		if (((' '+thisTbl.className+' ').indexOf("alternate_rows") != -1) && (thisTbl.id)) {
			alternate(thisTbl);
		}
	}
}

function addEvent(elm, evType, fn, useCapture)
// addEvent and removeEvent
// cross-browser event handling for IE5+,	NS6 and Mozilla
// By Scott Andrew
{
	if (elm.addEventListener){
		elm.addEventListener(evType, fn, useCapture);
		return true;
	} else if (elm.attachEvent){
		var r = elm.attachEvent("on"+evType, fn);
		return r;
	} else {
		alert("Handler could not be removed");
	}
} 

function replace(s, t, u) {
  /*
  **  Replace a token in a string
  **    s  string to be processed
  **    t  token to be found and removed
  **    u  token to be inserted
  **  returns new String
  */
  i = s.indexOf(t);
  r = "";
  if (i == -1) return s;
  r += s.substring(0,i) + u;
  if ( i + t.length < s.length)
    r += replace(s.substring(i + t.length, s.length), t, u);
  return r;
}

function alternate(table) {
	// Take object table and get all it's tbodies.
	var tableBodies = table.getElementsByTagName("tbody");
	// Loop through these tbodies
	for (var i = 0; i < tableBodies.length; i++) {
		// Take the tbody, and get all it's rows
		var tableRows = tableBodies[i].getElementsByTagName("tr");
		// Loop through these rows
		for (var j = 0; j < tableRows.length; j++) {
			// Check if j is even, and apply classes for both possible results
			if ( (j % 2) == 0  ) {
				if (tableRows[j].className == 'odd' || !(tableRows[j].className.indexOf('odd') == -1) ) {
					tableRows[j].className = replace(tableRows[j].className, 'odd', 'even');
				} else {
					tableRows[j].className += " even";
				}
			} else {
				if (tableRows[j].className == 'even' || !(tableRows[j].className.indexOf('even') == -1) ) {
					tableRows[j].className = replace(tableRows[j].className, 'even', 'odd');
				}
				tableRows[j].className += " odd";
			} 
		}
	}
}
