<div id="main-home">
    <div class="jumbotron jumbotron-fluid">
        <?php include_once __DIR__."/_logo.php"?>
        <h1>Animal Sanctuary</h1>
        <p class="lead">Milos mission provides safe haven for rescued animals until we find them a new forever home</p>
    </div>
    <section class="mh-40 p-5">
        <p class="lead">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid beatae, omnis quod ipsam in rerum asperiores fugit ipsum,
            atque aut temporibus earum. Corrupti odit voluptate amet quia error vel facilis! Lorem ipsum dolor sit amet consectetur
            adipisicing elit. Magnam voluptatem quidem consequatur totam ipsam rem officiis, dolorum maiores sequi sint quas nam eum
            vero doloremque suscipit error molestiae minima explicabo?
        </p>
    </section>
    <section id="animals" class="p-5 bg-primary">
        <h1 class="text-center p-4">Animals needing homes</h1>
        <div>
            <?php
            foreach($animals as $i => $animal){
                echo '<div class="card">';
                echo '<img src="/images/'.$animal['image'].'"></img>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
    <section class="mh-40 p-5">
        <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero tempore aperiam ex facilis assumenda voluptatem natus ipsam,
            quia cum. Debitis nemo tempora velit cupiditate architecto fugiat culpa assumenda vero sunt. Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Aliquam saepe amet aliquid facilis. Perspiciatis ratione aliquid cupiditate iusto deserunt
            dolore dolorem id, possimus alias fugiat sequi reprehenderit quos amet commodi.
        </p>
    </section>
    <footer class="mh-40 bg-secondary">

    </footer>
</div>
