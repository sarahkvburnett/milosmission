<div id="main-home">
    <div id="main"></div>
    <section id="intro" class="p-5">
        <div class="lead">
            <h1>Animal Sanctuary</h1>
            <p class="lead">Milos mission provides safe haven for rescued animals until we find them a new forever home. </p>
        </div>
    </section>
    <section id="animals" class="p-5 bg-primary">
        <h1 class="text-center p-4">Animals needing homes</h1>
        <div>
            <?php
            foreach($animals as $i => $animal){
                echo '<div class="card">';
                echo '<img src="/images/'.$animal['media_filename'].'"></img>';
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
