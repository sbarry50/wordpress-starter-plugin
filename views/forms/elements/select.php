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
