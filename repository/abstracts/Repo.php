<?php


namespace app\repository\abstracts;


use app\database\Connection;
use app\database\QueryBuilder\abstracts\iQueryBuilder;

abstract class Repo implements iRepo {

    protected iQueryBuilder $db;
    protected Connection $dbConnections;

    public function __construct(){
        $this->dbConnections = Connection::getInstance();
        $this->db = $this->setQueryBuilder();
    }

    public function findMenu($menu){
        switch ($menu){
            case 'adminMain':
                return [
                    ['url' => '/admin', 'icon' => 'home', 'page' => 'Home'],
                    ['url' => '/admin/animal/browse', 'icon' => 'paw', 'page' => 'Animals'],
                    ['url' => '/admin/owner/browse', 'icon' => 'user-friends', 'page' => 'Owners'],
                    ['url' => '/admin/media/browse', 'icon' => 'photo-video', 'page' => 'Media'],
                    ['url' => '/admin/room/browse', 'icon' => 'warehouse', 'page' => 'Rooms'],
                    ['url' => '/admin/user/browse', 'icon' => 'user', 'page' => 'Users'],
                    ['url' => '/admin/rehoming/browse', 'icon' => 'house-user', 'page' => 'Rehomings'],
                    ['url' => '/admin/logout', 'icon' => 'sign-out-alt', 'page' => 'Logout'],
                ];
            case 'adminDashboard':
                return [
                    ['url' => '/admin/animal',
                        'icon' => 'paw',
                        'title' => 'Animals',
                        'links' => [
                            ['/admin/animal/browse', 'Browse all animals'],
                            ['admin/animal/browse?searchColumn=animal_status&searchValue=Waiting', 'Browse animals waiting for homes'],
                            ['/admin/animal/details', 'Create new animal'],
                            ['admin/animal/browse?searchColumn=animal_status&searchValue=Rehomed', 'Browse rehomed animals']
                        ]
                    ], [
                        'url' => '/admin/owner',
                        'icon' => 'user-friends',
                        'title' => 'Owners',
                        'links' => [
                            ['/admin/owner/browse', 'Browse all owners'],
                            ['admin/owner/browse?searchColumn=owner_status&searchValue=New', 'Browse owners waiting for home check'],
                            ['/admin/owner/details', 'Create new owner'],
                            ['admin/owner/browse?searchColumn=owner_status&searchValue=Rehomed', 'Browse owners who have rehomed animal'],
                        ]
                    ], [
                        'url' => '/admin/media',
                        'icon' => 'photo-video',
                        'title' => 'Media',
                        'links' => [
                            ['/admin/media/browse', 'Browse all media'],
                            ['admin/media/browse?searchColumn=media_type&searchValue=Image', 'Browse all images'],
                            ['admin/media/browse?searchColumn=media_type&searchValue=Video', 'Browse all videos'],
                            ['/admin/media/details', 'Create new media'],
                        ]
                    ], [
                        'url' => '/admin/room',
                        'icon' => 'warehouse',
                        'title' => 'Rooms',
                        'links' => [
                            ['/admin/room/browse', 'Browse all rooms'],
                            ['/admin/room/details', 'Create new rooms'],
                        ]
                    ], [
                        'url' => '/admin/rehoming',
                        'icon' => 'house-user',
                        'title' => 'Rehomings',
                        'links' => [
                            ['/admin/rehoming/browse', 'Browse all rehoming'],
                            ['/admin/rehoming/details', 'Create new rehoming'],
                        ]
                    ], [
                        'url' => '/admin/user',
                        'icon' => 'user',
                        'title' => 'Users',
                        'links' => [
                            ['/admin/user/browse', 'Browse all users'],
                            ['/admin/user/details', 'Create new user'],
                        ]
                    ]
                ];
        }

    }

}
