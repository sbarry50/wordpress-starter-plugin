$options = get_option('plugin_options');
$items = array("Red", "Green", "Blue", "Orange", "White", "Violet", "Yellow");
echo "<select id='drop_down1' name='plugin_options[dropdown1]'>";
foreach($items as $item) {
    $selected = ($options['dropdown1']==$item) ? 'selected="selected"' : '';
    echo "<option value='$item' $selected>$item</option>";
}
echo "</select>";
