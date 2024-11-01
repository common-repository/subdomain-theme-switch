<?php 
$subdomain_name ='';
if($_POST['form_hidden'] == 'Y') {
	//Form data sent
	$subdomain_theme = $_POST['subdomain_theme'];
	update_option('subdomain_theme', $subdomain_theme);
	$subdomain_name = $_POST['subdomain_name'];
	update_option('subdomain_name', $subdomain_name);
	$subdomain_path = $_POST['subdomain_path'];
	update_option('subdomain_path', $subdomain_path);
	?>
	<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
	<?php
} else {
	$subdomain_theme = get_option('subdomain_theme');
	$subdomain_name = get_option('subdomain_name');	
	$subdomain_path = get_option('subdomain_path');	
}

	
?>
<style>
.input[type="text"] {
	width: 19%;
	}
</style>

<div class="wrap">
	<?php    echo "<h2>" . __( 'Sub-domain theme switch' ) . "</h2>"; ?>
	<br />
	<form name="mobiletheme_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    Sub-domain name: <input type="text" name="subdomain_name" value="<?php echo $subdomain_name;?>" width="40%" /> (http://mobile.test.com/ enter  mobile only)<br /><br />
    Sub-domain Path: <input type="text" name="subdomain_path" value="<?php echo $subdomain_path;?>" width="40%" /> (http://mobile.test.com/ enter url )<br /><br />
    
 
<?php
  $themes = get_themes();
  $default_theme = get_current_theme();
  
  if (count($themes) >= 1) {
      $theme_names = array_keys($themes);
      natcasesort($theme_names); 
      $html = 'Sub-domain theme: <select name="subdomain_theme">' . "\n";
      foreach ($theme_names as $theme_name) {              
          if (($subdomain_theme == $theme_name) || (($subdomain_theme == '') && ($theme_name == $default_theme))) {
              $html .= '<option value="' . $theme_name . '" selected="selected">' . htmlspecialchars($theme_name) . '</option>' . "\n";
          } else {
              $html .= '<option value="' . $theme_name . '">' . htmlspecialchars($theme_name) . '</option>' . "\n";
          }
      }
      $html .= '</select>' . "\n\n";
  }
  echo $html;
 
   ?>
		<input type="hidden" name="form_hidden" value="Y">
		<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Update Options') ?>" />
		</p>
	
		</form>
        
</div>