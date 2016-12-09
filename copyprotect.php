<?php
/*
Plugin Name: WP-CopyProtect [Protect your blog posts]
Plugin URI: http://chetangole.com/blog/wp-copyprotect/
Description: This plug-in will protect your blog content [posts] from being copied. A simple plug-in developed to stop the Copy cats.
Version: 2.1.0
Author: Chetan Gole
Author URI: http://chetangole.com/
*/

/*
Copyright (C) 2010  Chetan Gole - chetangole.com

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version. (see LICENSE)
*/
function CopyProtect()
{
    $wp_CopyProtect_nrc = get_option('CopyProtect_nrc');
    $wp_CopyProtect_nts = get_option('CopyProtect_nts');
    $wp_CopyProtect_nrc_text = get_option('CopyProtect_nrc_text');
    $pos = strpos(strtolower(getenv("REQUEST_URI")), '?preview=true');

    if ($pos === false) {
        if($wp_CopyProtect_nrc == 1) { CopyProtect_no_right_click_without_message(); }
        if($wp_CopyProtect_nrc == 2) { CopyProtect_no_right_click($wp_CopyProtect_nrc_text); }
        if($wp_CopyProtect_nts == true) { CopyProtect_no_select(); }
    }
}
// No right click (with message) - Problem for copy cats NO RIGHT CLICK
function CopyProtect_no_right_click($CopyProtect_click_message)
{
?>
<script type="text/javascript">
var message="<?php echo $CopyProtect_click_message; ?>";
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}}}

if (document.layers){
document.addEventListener(onmousedown());
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}
document.oncontextmenu=new Function("alert(message);return false")
</script>

<?php
}
// No right click (without message) - Problem for copy cats NO RIGHT CLICK
function CopyProtect_no_right_click_without_message()
{
?>
<script type="text/javascript">
function clickIE4(){
if (event.button==2){
return false;
}
}
function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
return false;
}}}

if (document.layers){
	document.addEventListener(onmousedown());
	document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("return false")

</script>

<?php
}
function CopyProtect_no_select()
{
?>
<script type="text/javascript">

function disableSelection(target){
if (typeof target.onselectstart!="undefined") //For IE 
	target.onselectstart=function(){return false}
else if (typeof target.style.MozUserSelect!="undefined") //For Firefox
	target.style.MozUserSelect="none"
else //All other route (For Opera)
	target.onmousedown=function(){return false}
target.style.cursor = "default"
}
</script>
<?php
}
// No selection footer 
function CopyProtect_no_select_footer()
{
?>
<script type="text/javascript">
disableSelection(document.body)
</script>

    <?php
}


?>