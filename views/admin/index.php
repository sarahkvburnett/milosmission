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
            ['admin/animals?searchColumn=status&searchItem=Waiting', 'Browse animals waiting for homes'],
            ['/admin/animals/details', 'Create new animal'],
            ['admin/animals?searchColumn=status&searchItem=Rehomed', 'Browse rehomed animals']
        ]
    ];

    $ownersCard = [
        'url' => '/admin/owners',
        'icon' => 'user-friends',
        'title' => 'Owners',
        'links' => [
            ['/admin/owners', 'Browse all owners'],
            ['admin/owners?searchColumn=status&searchItem=New', 'Browse owners waiting for home check'],
            ['/admin/owners/details', 'Create new owner'],
            ['admin/owners?searchColumn=status&searchItem=Rehomed', 'Browse owners who have rehomed animal'],
        ]
    ];

    $mediaCard = [
        'url' => '/admin/media',
        'icon' => 'photo-video',
        'title' => 'Media',
        'links' => [
            ['/admin/media', 'Browse all media'],
            ['admin/media?searchColumn=type&searchItem=Image', 'Browse all images'],
            ['admin/media?searchColumn=type&searchItem=Video', 'Browse all videos'],
            ['/admin/media/details', 'Create new media'],
        ]
    ];

    $roomsCard = [
        'url' => '/admin/rooms',
        'icon' => 'warehouse',
        'title' => 'Rooms',
        'links' => [
            ['/admin/rooms', 'Browse all rooms'],
            ['/admin/rooms/details', 'Create new rooms'],
        ]
    ];

    $rehomingsCard = [
        'url' => '/admin/rehomings',
        'icon' => 'house-user',
        'title' => 'Rehomings',
        'links' => [
            ['/admin/rehomings', 'Browse all rehoming'],
            ['/admin/rehomings/details', 'Create new rehoming'],
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
        $rehomingsCard,
        $usersCard
    ];
?>

<div id="admin-home">
        <?php
            foreach($cards as $card){
                createIndexCard($card['url'], $card['icon'], $card['title'], $card['links']);
            }
        ?>
    </div>
</div>
