<?php
switch($type){
    case 'select':
        echo '<select id="'.$key.'" name="'.$key.'" class="col-sm-9">';
        foreach($options[$key] as $option){
            if ($option === $value){
                echo '<option value="'.$option.'" selected="selected">'.$option.'</option>';
            } else {
                echo '<option value="'.$option.'">'.$option.'</option>';
            }
        }
        echo '</select>';
        break;
    case 'file':
        echo '<div class="col-sm-9 p-0">';
        echo '<input type="file" name="'.$key.'" value="/images/'.$value.'"></input>';
        echo '</div>';
        break;
    case 'id':
        echo '<input class="col-sm-9" type="number" name="'.$key.'" value="'.$value.'" readonly></input>';
        break;
    default:
        echo '<input class="col-sm-9" type="'.$type.'" name="'.$key.'" value="'.$value.'"></input>';
        break;
}

