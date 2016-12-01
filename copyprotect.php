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

// No right click (with message) - Problem for copy cats NO RIGHT CLICK
function CopyProtect_no_right_click($CopyProtect_click_message)
{
?>
<script type="text/javascript">
<!--
/*****************************************************************
***   COPY PROTECTED BY CHETANGOLE.COM/BLOG/WP-COPYPROTECT    ****
******************************************************************/
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
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}
document.oncontextmenu=new Function("alert(message);return false")
// --> 
</script>

<?php
}
// No right click (without message) - Problem for copy cats NO RIGHT CLICK
function CopyProtect_no_right_click_without_message()
{
?>
<script type="text/javascript">
<!--
/*****************************************************************
***   COPY PROTECTED BY CHETANGOLE.COM/BLOG/WP-COPYPROTECT    ****
******************************************************************/
function clickIE4(){
if (event.button==2){
return false;
}
}
function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("return false")
// --> 
</script>

<?php
}
// No selection header - Now your content is protected from copy and paste guys
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
<small>Copy Protected by <a href="http://chetangole.com/" target="_blank">Chetan</a>s <a href="http://chetangole.com/blog/wp-copyprotect/" target="_blank">WP-Copyprotect</a>.</small>
<?php
}
// Tuning your WP-CopyProtect
function CopyProtect_options_page()
{
?>
<div class="wrap">
	<h1>WP-CopyProtect <font size="2">ver 2.0.0</font></h1> 
	| <a href="http://chetangole.com/blog/wp-copyprotect/" target="_blank" title="Visit homepage of wordpress plugin WP-CopyProtect">Visit Plugin page</a> | <a href="http://chetangole.com/blog/wp-copyprotect/#donate" target="_blank" title="Donate some amount to WP-CopyProtect plugin developer to help him to develope more such plugins">Donate</a> | <a href="http://chetangole.com/blog/wp-copyprotect/#donors" target="_blank" title="Few power donors,special thanks to them">Power Donors</a> | 
	<h3>- settings page -</h3>
<?php
	if($_POST['CopyProtect_save']){
		update_option('CopyProtect_nrc',$_POST['CopyProtect_nrc']);
		update_option('CopyProtect_nts',$_POST['CopyProtect_nts']);
		update_option('CopyProtect_nrc_text',$_POST['CopyProtect_nrc_text']);

		echo '<div class="updated"><p>Settings saved</p></div>';
	}
	$wp_CopyProtect_nrc = get_option('CopyProtect_nrc');
	$wp_CopyProtect_nts = get_option('CopyProtect_nts');
	?>

	</table>
	</div>
	<?php
}

//call to function
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

function CopyProtect_footer()
{
	$wp_CopyProtect_nts = get_option('CopyProtect_nts');
	$wp_CopyProtect_credit = get_option('CopyProtect_credit');

	if($wp_CopyProtect_nts == true) { CopyProtect_no_select_footer(); }
}

function CopyProtect_adminmenu()
{
	if (function_exists('add_options_page')) {	
		add_options_page('WP-CopyProtect', 'WP-CopyProtect', 9, basename(__FILE__),'CopyProtect_options_page');
	}
}

//Commanding the Wordpress
add_action('wp_head','CopyProtect');
add_action('wp_footer','CopyProtect_footer');
add_action('admin_menu','CopyProtect_adminmenu',1);
?>