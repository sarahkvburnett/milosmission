<h1 class="h1 text-center">
    <?php if(isset($_GET['id'])){
        echo $titles['update'].': <span class="text-primary">'.$fields['name'].'</span>';
    } else {
        echo $titles['create'];
    }
    ?>
</h1>
<!--TODO add * for the required fields :) -->
<div>
    <a href="<?php echo $actions['browse']?>" class="btn btn-dark">Back</a>
</div>
<?php if(isset($_GET['id'])):?>
    <form action="<?php echo $actions['delete']?>" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
        <input type="submit" value="Delete" class="btn btn-danger"/>
    </form>
<?php endif ?>
<form action="<?php echo $actions['save']?>" method="post" class="bg-white mb-5 p-4 mx-auto" style="width: 70%">
    <?php
    include __DIR__."../../_errors.php";
    foreach($fields as $key => $value){
        echo '<div class="form-group row">';
        echo '<label class="col-sm-3">'.ucwords($key).'</label>';
        include __DIR__."/_fields.php";
        echo '</div>';
    }
    ?>
    <div class="text-center">
        <?php if(isset($_GET['id'])):?>
            <input type="submit" value="Update" class="btn btn-primary"></input>
        <?php else: ?>
            <input type="submit" value="Create" class="btn btn-primary"></input>
        <?php endif ?>
    </div>
</form>

