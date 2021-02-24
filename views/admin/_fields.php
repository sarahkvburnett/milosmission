<?php
switch($type){
    case 'select':
        echo '<select id="'.$key.'" name="'.$key.'" class="col-sm-9">';
        echo '<option value="">-- Please select --</option>';
        foreach($options[$key] as $option){
            if ($option['value'] === $value){
                echo '<option value="'.$option['value'].'" selected="selected">'.$option['label'].'</option>';
            } else {
                echo '<option value="'.$option['value'].'">'.$option['label'].'</option>';
            }
        }
        echo '</select>';
        break;
    case 'file':
        echo '<div class="col-sm-9 p-0" id="img-uploader">';
        echo '<input type="file" name="'.$key.'" value="/images/'.$value.'"></input>';
        echo '<img class="img" src="/images/'.$value.'">';
        echo '</div>';
        break;
        case 'readonly':
        echo '<input class="col-sm-9" type="text" name="'.$key.'" value="'.$value.'" readonly></input>';
        break;
    case 'checkbox':
        echo '<div class="col-sm-9 checkbox">';
        foreach($options[$key] as $option){
            $checked = false;
            if (in_array($option['label'], $fields['animals'])){
                $checked = true;
            }
            echo '<div>';
            if ($checked === true){
                echo '<input type="checkbox" name="'.$key.'[]" value="'.$option['value'].'" id="'.$option['value'].'" checked/>';
            } else {
                echo '<input type="checkbox" name="'.$key.'[]" value="'.$option['value'].'" id="'.$option['value'].'"/>';
            }
            echo '<label for="'.$option['value'].'">'.$option['label'].'</label>';
            echo '</div>';
        }
        echo '</div>';
        break;
    default:
        echo '<input class="col-sm-9" type="'.$type.'" name="'.$key.'" value="'.$value.'"></input>';
        break;
}
?>

<script>
    document.querySelector('#img-uploader input').onchange = function(e){
        document.querySelector('#img-uploader img').src = window.URL.createObjectURL(e.target.files[0]);
    }
</script>
