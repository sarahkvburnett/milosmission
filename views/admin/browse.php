<!--TODO: handle having none -->
<h1 class="h1 text-center"><?php echo $title?></h1>
<div>
    <a class="btn btn-primary" href="<?php echo $actions['create']?>">Create New</a>
</div>
<?php if(!empty($fields)):?>
    <?php
    $columns = $fields[0];
    ?>
    <form id="search" action="<?php echo $actions['get']?>" method="get" class="bg-light">
        <select name="searchColumn" id="searchColumn">
            <?php foreach ($searchables as $option) {
                echo '<option value="' . $option . '">' . ucwords($option) . '</option>';
            }
            ?>
        </select>
        <input type="text" name="searchItem" value="<?php echo $search['item'] ?>" placeholder="Search">
        <?php if(isset($_GET['searchItem'])):?>
            <a href="<?php echo $actions['get']?>" class="btn btn-dark">Clear</a>
        <?php else:?>
            <button class="btn btn-dark"><i class="fas fa-search"></i> Search</button>
        <?php endif?>
    </form>
    <table class="table table-responsive bg-white">
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
            echo '<td><a class="btn btn-primary" href="/admin/animals/details?id='.$field['id'].'">Edit</a></td>';
            echo'</tr>';
        }
        ?>
    </table>
<?php else: ?>
    None found
<?php endif ?>
