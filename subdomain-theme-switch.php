<?php
/*
Plugin Name: Sub-domain theme switch 
Plugin URI: http://www.admirecreation.com/
Description: This plugin detects if your site is being viewed by a mobile browser and switches to an different, selectable theme. 
Version: 0.1
Author: Bijaya Kumar Oli
Author URI: http://www.admirecreation.com/
*/

$subdomain='';
session_start();

$userSubdomain =  get_option('subdomain_name');
$subdomain_path = get_option('subdomain_path');	
$siteurl_main = site_url();

if(!isset($_SESSION[$mobilethemeswitch]) || $_SESSION[$mobilethemeswitch] != 'on')
	$_SESSION[$mobilethemeswitch] = "off";

//mobile browsers
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$iemobile = ( strpos($_SERVER['HTTP_USER_AGENT'],"iemobile") || strpos($_SERVER['HTTP_USER_AGENT'],"IEMobile") );

if ((($iphone || $android || $palmpre || $ipod || $berry !== FALSE || $iemobile) === true) && $_SESSION[$mobilethemeswitch] == "off" )  { 

$_SESSION[$mobilethemeswitch] = "on";

header("Location: ".$subdomain_path);

exit;
}


//print_r($_SERVER['HTTP_HOST']);

$url = $_SERVER['SCRIPT_URI'];
$url = $_SERVER['HTTP_HOST'];
$parsedUrl = parse_url($url);
$host = explode('.', $parsedUrl['host']);
$host = explode('.', $url);
$subdomain = $host[0];

if((($subdomain==$userSubdomain) && $subdomain != "" || $_SESSION[$mobilethemeswitch] == "on") && $_SESSION[$mobilethemeswitch] != "off" ){
    
        define('WP_HOME',$subdomain_path);
        define('WP_SITEURL',$subdomain_path);
}else{    
       define('WP_HOME',$siteurl_main);
       define('WP_SITEURL',$siteurl_main);
    
}




if ((($iphone || $android || $palmpre || $ipod || $berry !== FALSE || $iemobile) === true || $subdomain==$userSubdomain) && $subdomain != ""  ) { 
	add_filter('stylesheet', 'subdomainTheme');
	add_filter('template', 'subdomainTheme');
} 

function subdomainTheme(){
	$subdomain_theme =  get_option('subdomain_theme');
    $themes = get_themes();
	foreach ($themes as $theme_data) {
	  if ($theme_data['Name'] == $subdomain_theme) {
	      return $theme_data['Stylesheet'];
	  }
	}	
}

function sdts_admin_actions() { 
	if (current_user_can('manage_options'))  {
		add_theme_page("Subdomain theme", "Subdomain theme", 'manage_options', "subdomain-theme-switch", "sdts_show_admin");
	}
} 


function sdts_show_admin(){
	include('subdomain-theme-switch-admin.php'); 
}

add_action('admin_menu', 'sdts_admin_actions'); 
?>