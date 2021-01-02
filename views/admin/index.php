<?php
    function createIndexCard(string $url, string $icon,  string $title, array $links) {
        echo '<div class="card">';
        echo '<div class="card-header">';
        echo '<i class="fas fa-' . $icon . '"></i>';
        echo ' '.$title;
        echo '</div>';
        echo '<ul class="list-group list-group-flush">';
        foreach ($links as $link) {
            echo '<li class="list-group-item"><a href="' . $link[0] . '">' . $link[1] . '</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }

    $animalsCard = [
        'url' => '/admin/animals',
        'icon' => 'paw',
        'title' => 'Animals',
        'links' => [
            ['/admin/animals', 'Browse all animals'],
            ['/admin/animals/waiting', 'Browse animals waiting for homes'],
            ['/admin/animals/details', 'Create new animal'],
            ['/admin/animals/rehomed', 'Browse rehomed animals']
        ]
    ];

    $ownersCard = [
        'url' => '/admin/owners',
        'icon' => 'user-friends',
        'title' => 'Owners',
        'links' => [
            ['/admin/owners', 'Browse all owners'],
            ['/admin/owners/waiting', 'Browse owners waiting for home check'],
            ['/admin/animals/details', 'Create new owner'],
            ['/admin/owners/rehomed', 'Browse owners who have rehomed animal'],
        ]
    ];

    $mediaCard = [
        'url' => '/admin/media',
        'icon' => 'photo-video',
        'title' => 'Media',
        'links' => [
            ['/admin/media', 'Browse all media'],
            ['/admin/media/images', 'Browse all images'],
            ['/admin/media/videos', 'Browse all videos'],
            ['/admin/media/details', 'Create new media'],
        ]
    ];

    $roomsCard = [
        'url' => '/admin/rooms',
        'icon' => 'warehouse',
        'title' => 'Rooms',
        'links' => [
            ['/admin/rooms', 'Browse all rooms'],
            ['/admin/rooms/occupied', 'Browse occupied rooms'],
            ['/admin/rooms/vacant', 'Browse vacant rooms'],
            ['/admin/rooms/details', 'Create new rooms'],
        ]
    ];

    $usersCard = [
        'url' => '/admin/users',
        'icon' => 'user',
        'title' => 'Users',
        'links' => [
            ['/admin/users', 'Browse all users'],
            ['/admin/users/details', 'Create new user'],
        ]
    ];

    $cards = [
        $animalsCard,
        $ownersCard,
        $mediaCard,
        $roomsCard,
        $usersCard
    ];
?>

<div id="admin-home">
        <?php
            foreach($cards as $card){
                createIndexCard($card['url'], $card['icon'], $card['title'], $card['links']);
            }
        ?>
<!--        styling problem here div isn't full width -->
    </div>
</div>
