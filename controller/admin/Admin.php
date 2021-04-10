<?php


namespace app\controller\admin;


use app\classes\FailedValidation;
use app\classes\Request;
use app\classes\Router;
use app\controller\abstracts\Controller;

class Admin extends Controller {

    public function admin(Router $router){
        $this->cards = [
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
        $router->sendResponse('/admin/index', $this->getData());
    }

    //todo - this doesn't work with api
    public function login(Router $router){
        $request = Request::getInstance();
        if ($request->hasPost()) {
            $user = $request->getPost();
            try {
                if (!isset($user['user_email'])) throw new FailedValidation(["Please enter your email address"]);
                if (!isset($user['user_password'])) throw new FailedValidation(["Please enter your password"]);
                $dbUser = $this->repo->findUserByEmail($user['user_email']);
                if (!$dbUser) throw new FailedValidation(["Email address not found"]);
                $authHash = $this->genAuthHash($user);
                setcookie("auth-user", $authHash, time() + (86400 * 30));
                $router->redirect('/admin');
                return;
            } catch (FailedValidation $e) {
                $this->errors = $e->getErrors();
            }
        }
        $router->sendResponse('/admin/login', $this->getData());
    }

    public function logout(Router $router){
        setcookie("auth-user", "", time() - 3600);
        $router->redirect('/');
    }

    //todo you copied this from user model bro
    public function genAuthHash($user){
        $auth = $user['user_email'].$user['user_password'];
        return password_hash($auth, PASSWORD_DEFAULT);
    }

}
