<select name="carbrand">
    <option>Chevrolet</option>
    <option>Ford</option>
    <option selected>Peugeot</option>
    <option>Fiat</option>
</select>

<select name="favoritergps[]" multiple>
    <option>The Witcher II</option>
    <option selected>Baldur's Gate II</option>
    <option>The Elder Scrolls III</option>
    <option>Torchlight II</option>
    <option>Fallout New Vegas</option>
    <option>Anachronox</option>
</select>

<label><input type="checkbox" name="cb-html5" checked> HTML5</label>
<label><input type="checkbox" name="cb-css3" checked> CSS3</label>
<label><input type="checkbox" name="cb-javascript"> Javascript</label>


<label><input type="radio" name="course" value="pottery"> Pottery</label>
<label><input type="radio" name="course" value="gardening" checked> Gardening</label>
<label><input type="radio" name="course" value="painting"> Painting</label>

<?php
return array(
    'option_1' => array('Blue sky', 'checked'),
    'option_2' => 'Red sun',
    'option_3' => 'Green grass',
    'option_4' => 'White sand',
);

return array(
    'option_1' => array(
        'label'     => 'Blue sky',
        'id'        => 'favorite_color',
        'class'     => '',
        'type'      => 'checkbox',
        'name'      => 'blue-sky',
        'value'     => null,
        'checked'   => true,
        'required'  => true,
        'disabled'  => false,
        'autofocus' => false,
    ),
    'option_2' => array(
        'label'     => '',
        'id'        => '',
        'class'     => '',
        'type'      => '',
        'name'      => '',
        'value'     => null,
        'checked'   => false,
        'required'  => false,
        'disabled'  => false,
        'autofocus' => false,
    ),
    'option_3' => array(
        'label'     => 'Green grass',
        'id'        => 'favorite_color',
        'class'     => '',
        'type'      => 'checkbox',
        'name'      => 'green-grass',
        'value'     => null,
        'checked'   => false,
        'required'  => false,
        'disabled'  => false,
        'autofocus' => false,
    ),
    'option_4' => array(
        'label'     => 'White sand',
        'id'        => 'favorite_color',
        'class'     => '',
        'type'      => 'checkbox',
        'name'      => 'white-sand',
        'value'     => null,
        'checked'   => false,
        'required'  => false,
        'disabled'  => true,
        'autofocus' => false,
    ),
);

function sandbox_toggle_header_callback($args) {
     
    // First, we read the options collection
    $options = get_option('sandbox_theme_display_options');
     
    // Next, we update the name attribute to access this element's ID in the context of the display options array
    // We also access the show_header element of the options collection in the call to the checked() helper function
    $html = '<input type="checkbox" id="show_header" name="sandbox_theme_display_options[show_header]" value="1" ' . checked(1, $options['show_header'], false) . '/>'; 
     
    // Here, we'll take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="show_header"> '  . $args[0] . '</label>'; 
     
    echo $html;
     
} // end sandbox_toggle_header_callback