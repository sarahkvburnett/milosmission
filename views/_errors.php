<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error?></div>
        <?php endforeach ?>
    </div>
<?php endif; ?>