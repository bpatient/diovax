/**
*Pascal Maniraho 
*Murindwaz Apps
*@todo implement video widget Object
*@todo implement comment widget functionalities as well  	
*/

/**commenting box should be in a fancybox, the same thing for message as well**/
var AjaxEnable = { 
	data: { url: '', e: '', ac: '' , i: '' ,dt :{} }, 
	init: function(data){if(data) this.data = data; if( !this.data.e && !this.data.url )throw "Missing DOM element and URL"; if( !this.data.ac ) this.data.ac = 'active'; Logger.log( this.data);return this;  },
	run: function(){ 
		var _slf = this; if( $(this.data.e).length ){ $(this.data.e).bind('change', function( e ){ 
		var _e  = e.target;  if( e.srcElement ) _e  = e.srcElement; else _e = this; e = _e; 
		if($(e).attr('class').length) _slf.data.ac = $(e).attr('class'); if($(e).attr('id').length) _slf.data.i = $(e).attr('id');
		var _d = { 'ajx' : true, ac: _slf.data.ac, i: _slf.data.i, v: (e.checked ? 1 : 0), it: e.value };
		$.ajax({ type: 'get',  dataType: 'text/html',data: _d, url: _slf.data.url , success: function(html){  console.log(html); } }) }); } return false; }};

var SelectChange = { init: function(data){ console.log(data); return false;}, change: function(){return false;} }
var Logger = {
		DBG : function( b ){ return b == true ? true : false; }
		
}


/**this snippet has to be replaced by another one, I need something that works for now*/
var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function jsddm_open()
{  jsddm_canceltimer();
   jsddm_close();
   ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

function jsddm_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{  closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

$(document).ready(function()
{  $('#account > li').bind('mouseover', jsddm_open)
   $('#account > li').bind('mouseout',  jsddm_timer)});

document.onclick = jsddm_close;

/**stands for date picker*/
function dtpck( dt ){ 
	var _dt =  { e : '', url : '' };	
	if( dt.e.length ) _dt.e = dt.e; else _dt.e = $("#datepicker");	if( dt.url.length ) _dt.url = dt.url; else _dt.url = '/assets/icons/date.png';	
	$(function( e ){ try{ _dt.e.datepicker({showOn: 'button', buttonImage: _dt.url, buttonImageOnly: true,changeMonth : true, changeYear : true}) }catch(e){ _trace(e) } })
}
