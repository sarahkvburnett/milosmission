<?php
    function addMenuItem(string $url, $icon, $page){
        if ($page === 'Logout'){
            echo '<button class="list-group-item list-group-item-action" data-toggle="modal" data-target="#admin-logout"><i class="fas fa-'.$icon.' fa-2x"></i> '.$page.'</button>';
        } else {
            echo '<a href="'.$url.'" class="list-group-item list-group-item-action"><i class="fas fa-'.$icon.' fa-2x"></i> '.$page.'</a>';
        }
    }

?>

<div id="menu">
    <div class="list-group">
        <?php
        addMenuItem('/admin', 'home', 'Home');
        addMenuItem('/admin/animal/browse', 'paw', 'Animals');
        addMenuItem('/admin/owner/browse', 'user-friends', 'Owners');
        addMenuItem('/admin/media/browse', 'photo-video', 'Media');
        addMenuItem('/admin/room/browse', 'warehouse', 'Rooms');
        addMenuItem('/admin/user/browse', 'user', 'Users');
        addMenuItem('/admin/rehoming/browse', 'house-user', 'Rehomings');
        addMenuItem('/admin/logout', 'sign-out-alt', 'Logout');
        ?>
    </div>
</div>
