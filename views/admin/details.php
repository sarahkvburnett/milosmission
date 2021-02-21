<div id="admin-details">
    <h1 class="h1 text-center">
        <?php if(isset($_GET['id'])){
            echo 'Update '.$title;
//            todo get name back
            if (isset($fields['name'])){
                echo ': <span class="text-primary">'.$fields['name'].'</span>';
            }
        } else {
            echo 'Create New '.$title;
        }
        ?>
    </h1>
    <div id="buttons" class="d-flex justify-content-between mx-auto my-3">
        <a href="<?php echo $actions['browse']?>" class="btn btn-dark">Back</a>
        <button class="btn btn-danger" data-toggle="modal" data-target="#admin-delete">Delete</button>
    </div>
    <form action="<?php echo $actions['details']?>" method="post" enctype="multipart/form-data" class="bg-white mb-5 p-4 mx-auto">
        <?php
        include __DIR__."../../_errors.php";
        foreach($fields as $key => $value){
            $type = $types[$key] ?? 'text';
                echo '<div class="form-group row">';
                if ($type !== 'hidden') {
                    echo '<label class="col-sm-3">' .$labels[$key]. '</label>';
                }
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
    <?php if(isset($_GET['id'])):?>
        <div id="admin-delete" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="<?php echo $actions['delete']?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
                            <input type="submit" value="Delete" class="btn btn-danger"/>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif?>
    <?php if(isset($media)) {
        echo '<div id="media" class="bg-white mb-5 p-4 mx-auto d-flex flex-wrap justify-content-center">';
        foreach ($media as $item){
            echo '<p><img width="250" class="img-fluid img-thumbnail m-1" src="/images/'.$item['media_filename'].'"/></p>';
        }
        echo '</div>';
    }?>
</div>
