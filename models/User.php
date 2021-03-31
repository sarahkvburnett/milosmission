<?php


namespace app\models;

use app\models\abstracts\Model;

class User extends Model {

    protected string $table = 'users';
    protected string $idColumn = 'user_id';
    protected string $className = 'User';
    protected string $name = 'user';

    //todo confirm password missing from details

   protected array $rules = [
       'user_firstname' => ['required' => "Please add a firstname"],
       'user_lastname' => ['required' => "Please add a lastname"],
       'user_email' => ['required' => "Please add an email"],
       'user_password' => ['required' => "Please add a password"],
       'user_confirmpassword' => ['required' => "Please confirm your password", 'match:user_password|user_confirmpassword' => "Your passwords do not match"]
   ];

   protected array $labels = [
        'user_id' => 'ID',
        'user_firstname' => 'First Name',
        'user_lastname' => 'Last Name',
        'user_email' => 'Email',
        'user_password' => 'Password'
    ];

    protected array $columns = [
        'user_id', 'user_firstname', 'user_lastname', 'user_email'
    ];

    protected array $types = [
        'user_id' => 'hidden',
        'user_password' => 'password',
        'user_confirmpassword' => 'password',
        'user_email' => 'email'
    ];

    protected array $searchables = [
        'user_id', 'user_email'
    ];

    function setCounts() {
        // TODO: Implement setCounts() method.
    }
}
