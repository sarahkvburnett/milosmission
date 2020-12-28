<a href="/">Back</a>
<h1>
    <?php if(isset($_GET['id'])):?>
    Edit Image
    <?php else: ?>
    Add Image
    <?php endif ?>
</h1>
<form action="/posts/create" method="post" novalidate>
    <?php include __DIR__."/../_errors.php"?>
    <label for="labels">Labels</label>
    <select id="label" name="label">
        <option value="Milo">Milo</option>
        <option value="Misty">Misty</option>
        <option value="Cody">Cody</option>
        <option value="Multiple">Multiple</option>
    </select>
    <label for="url">File path</label>
    <input name="url" id="url" required></input>
    <label for="caption">caption</label>
    <textarea id="caption" name="caption" required></textarea>
    <?php if(isset($_GET['id'])):?>
        <input type="submit" value="Update"></input>
    <?php else: ?>
        <input type="submit" value="Create"></input>
    <?php endif ?>
</form>
<?php if(isset($_GET['id'])):?>
    <form action="/posts/delete" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
        <input type="submit" value="Delete"></input>
    </form>
<?php endif ?>