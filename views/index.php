<a href="/posts/create">Add</a>
<form>
    <select id="search" name="search" required>
        <option value="Milo">Milo</option>
        <option value="Misty">Misty</option>
        <option value="Cody">Cody</option>
        <option value="Multiple">Multiple</option>
    </select>
    <input type="submit" value="Search">
    <a href="/">Clear</a>
</form>
<section class="posts">
    <?php

    foreach($posts as $i => $post){

        echo '<div class="post"><a href="./posts/create?id='.$post['id'].'"><img src="/images/'.$post['url'].'"></img></a></div>';
    }

    ?>
</section>