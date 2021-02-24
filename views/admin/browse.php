<div id="admin-browse">
    <?php if (!empty($counts)) {
       echo '<div id="counts" class="mb-5">';
       foreach ($counts as $name => $count){
           echo '<div class="bg-primary">
                    <a href="'.$count['url'].'"
                        <p class="lead font-weight-bold">'.$name.'</p>
                        <p>'.$count['value'].'</p>
                    </a>
                </div>';
       }
       echo '</div>';
    }?>
    <h1 class="h1 text-center"><?php echo $name?></h1>
    <form id="search" action="<?php echo $actions['browse']?>" method="get" class="bg-light">
        <select name="searchColumn" id="searchColumn">
            <?php foreach ($searchables as $option) {
                if ($option === $_GET['searchColumn']){
                    echo '<option value="'.$option.'" selected="selected">' . $labels[$option] . '</option>';
                } else {
                    echo '<option value="'.$option.'">' . $labels[$option] . '</option>';
                }
            }
            ?>
        </select>
        <input type="text" name="searchValue" value="<?php if (!empty($search)) echo $search[1] ?>" placeholder="Search">
        <?php if(isset($_GET['searchValue'])):?>
            <a href="<?php echo $actions['browse']?>" class="btn btn-dark">Clear</a>
        <?php else:?>
            <button class="btn btn-dark"><i class="fas fa-search"></i> Search</button>
        <?php endif?>
    </form>
    <div id="buttons" class="text-right my-3">
        <a class="btn btn-primary" href="<?php echo $actions['details']?>">Create New</a>
    </div>
    <div class="table-responsive">
        <table class="table bg-white">
            <?php if(!empty($fields)):?>
                <?php
                ?>
                <tr>
                    <?php
                    foreach($columns as $column){
                        echo '<th>'.$labels[$column].'</th>';
                    }
                    ?>
                    <th></th>
                </tr>
                <?php
                foreach($fields as $i => $field){
                    echo '<tr>';
                    foreach($field as $key => $value){
                        if (in_array($key, $columns)){
                            if (!$value){
                                echo '<td>-</td>';
                            }
                            else if (is_array($value)) {
                                echo '<td>';
                                foreach ($value as $item) {
                                    echo '<span class="table-badge">'.$item.'</span>';
                                }
                                echo '</td>';
                            }
                            else if ($key === "image" || $key === "preview") {
                                echo '<td><img class="img-fluid img-thumbnail" src="/images/'.$field['media_filename'].'"></img></td>';
                            }
                            else {
                                echo '<td>'.$value.'</td>';
                            }
                        }
                    }
                    echo '<td class="text-right"><a class="btn btn-primary" href="'.$actions['details'].'?id='.$field[$id].'">Edit</a></td>';
                    echo'</tr>';
                }
                ?>
            <?php else: ?>
                <th class="text-center py-5">None found</th>
            <?php endif ?>
        </table>
    </div>
</div>
