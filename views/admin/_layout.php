<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodyMistyMilo</title>
        <link href="/styles/app.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <header class="bg-primary px-4 d-flex justify-content-center align-items-center" style="height: 15vh">
            <img src="/images/logo.png" style="max-height: 100%"/>
        </header>
        <div class="d-flex" style="min-height: 85vh">
            <aside class="bg-primary" style="flex: 0 0 300px">
                <?php include __DIR__."/_menu.php"?>
            </aside>
            <div class="p-5" style="width: 100%">
                <?php echo $content?>
            </div>
        </div>
    </body>
</html>

<!-- need position fixed on the menu -->
