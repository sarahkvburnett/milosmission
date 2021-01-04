<div id="admin-browse">
    <h1 class="h1 text-center"><?php echo $title?></h1>
    <?php if(!empty($fields)):?>
        <form id="search" action="<?php echo $actions['details']?>" method="get" class="bg-light">
            <select name="searchColumn" id="searchColumn">
                <?php foreach ($searchables as $option) {
                    echo '<option value="' . $option . '">' . ucwords($option) . '</option>';
                }
                ?>
            </select>
            <input type="text" name="searchItem" value="<?php echo $search['item'] ?>" placeholder="Search">
            <?php if(isset($_GET['searchItem'])):?>
                <a href="<?php echo $actions['browse']?>" class="btn btn-dark">Clear</a>
            <?php else:?>
                <button class="btn btn-dark"><i class="fas fa-search"></i> Search</button>
            <?php endif?>
        </form>
    <?php endif ?>
    <div id="buttons" class="text-right my-3">
        <a class="btn btn-primary" href="<?php echo $actions['details']?>">Create New</a>
    </div>

    <div class="table-responsive">
        <table class="table bg-white">
            <?php if(!empty($fields)):?>
                <?php
                $columns = $fields[0];
                ?>
                <tr>
                    <?php
                    foreach($columns as $key => $value){
                        echo '<th>'.ucwords($key).'</th>';
                    }
                    ?>
                    <th></th>
                </tr>
                <?php
                foreach($fields as $i => $field){
                    echo '<tr>';
                    foreach($field as $key => $value){
                        if ($key === 'image') {
                            echo '<td><img class="img-fluid img-thumbnail" src="/images/'.$value.'"></img></td>';
                        }
                        else {
                            echo '<td>'.$value.'</td>';
                        }
                    }
                    echo '<td class="text-right"><a class="btn btn-primary" href="'.$actions['details'].'?id='.$field['id'].'">Edit</a></td>';
                    echo'</tr>';
                }
                ?>
            <?php else: ?>
                <th class="text-center py-5">None found</th>
            <?php endif ?>
        </table>
    </div>

</div>
