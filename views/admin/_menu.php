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
        addMenuItem('/admin/animals', 'paw', 'Animals');
        addMenuItem('/admin/owners', 'user-friends', 'Owners');
        addMenuItem('/admin/media', 'photo-video', 'Media');
        addMenuItem('/admin/rooms', 'warehouse', 'Rooms');
        addMenuItem('/admin/users', 'user', 'Users');
        addMenuItem('/admin/logout', 'sign-out-alt', 'Logout');
        ?>
    </div>
</div>
