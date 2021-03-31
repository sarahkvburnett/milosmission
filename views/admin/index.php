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
        'url' => '/admin/animal',
        'icon' => 'paw',
        'title' => 'Animals',
        'links' => [
            ['/admin/animal/browse', 'Browse all animals'],
            ['admin/animal/browse?searchColumn=animal_status&searchValue=Waiting', 'Browse animals waiting for homes'],
            ['/admin/animal/details', 'Create new animal'],
            ['admin/animal/browse?searchColumn=animal_status&searchValue=Rehomed', 'Browse rehomed animals']
        ]
    ];

    $ownersCard = [
        'url' => '/admin/owner',
        'icon' => 'user-friends',
        'title' => 'Owners',
        'links' => [
            ['/admin/owner/browse', 'Browse all owners'],
            ['admin/owner/browse?searchColumn=owner_status&searchValue=New', 'Browse owners waiting for home check'],
            ['/admin/owner/details', 'Create new owner'],
            ['admin/owner/browse?searchColumn=owner_status&searchValue=Rehomed', 'Browse owners who have rehomed animal'],
        ]
    ];

    $mediaCard = [
        'url' => '/admin/media',
        'icon' => 'photo-video',
        'title' => 'Media',
        'links' => [
            ['/admin/media/browse', 'Browse all media'],
            ['admin/media/browse?searchColumn=media_type&searchValue=Image', 'Browse all images'],
            ['admin/media/browse?searchColumn=media_type&searchValue=Video', 'Browse all videos'],
            ['/admin/media/details', 'Create new media'],
        ]
    ];

    $roomsCard = [
        'url' => '/admin/room',
        'icon' => 'warehouse',
        'title' => 'Rooms',
        'links' => [
            ['/admin/room/browse', 'Browse all rooms'],
            ['/admin/room/details', 'Create new rooms'],
        ]
    ];

    $rehomingsCard = [
        'url' => '/admin/rehoming',
        'icon' => 'house-user',
        'title' => 'Rehomings',
        'links' => [
            ['/admin/rehoming/browse', 'Browse all rehoming'],
            ['/admin/rehoming/details', 'Create new rehoming'],
        ]
    ];

    $usersCard = [
        'url' => '/admin/user',
        'icon' => 'user',
        'title' => 'Users',
        'links' => [
            ['/admin/user/browse', 'Browse all users'],
            ['/admin/user/details', 'Create new user'],
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
