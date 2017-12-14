$options = get_option('plugin_options');
if($options['chkbox1']) { $checked = ' checked="checked" '; }
echo "<input ".$checked." id='plugin_chk1' name='plugin_options[chkbox1]' type='checkbox' />";
