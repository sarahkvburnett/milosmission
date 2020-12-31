<div class="jumbotron jumbotron-fluid p-5">
    <h1>Animal Sanctuary</h1>
    <p class="lead">Milos mission is to provide a safe haven for rescued animals until we find them a new forever home</p>
</div>
<h1 class="text-center">Animals needing homes</h1>

<section class="posts container">
    <?php
    foreach($posts as $i => $post){

        echo '<div class="post"><a href="./posts/create?id='.$post['id'].'"><img src="/images/'.$post['url'].'"></img></a></div>';
    }

    ?>
</section>
