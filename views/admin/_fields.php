<?php
switch($inputs[$key] ?? null){
    case 'select':
        echo '<select id="'.$key.'" name="'.$key.'" class="col-sm-9">';
        foreach($options[$key] as $option){
            echo '<option value="'.$option.'">'.$option.'</option>';
        }
        echo '</select>';
        break;
    case 'file':
        echo '<div class="col-sm-9 p-0">';
        echo '<input type="'.$inputs[$key].'" name="'.$key.'" value="'.$value.'"></input>';
        if ($key === 'image') {
            echo '<img class="img-fluid img-thumbnail" src="/images/'.$value.'"></img>';
        }
        echo '</div>';
        break;
    default:
    echo '<input class="col-sm-9" name="'.$key.'" value="'.$value.'"></input>';
    break;
}
