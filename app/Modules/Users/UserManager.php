<?php namespace Myth\Users;

use App\Core\BaseManager;
use App\Models\UserModel;

class UserManager extends BaseManager
{
    public function __construct()
    {
        $this->model = new UserModel();

        parent::__construct();
    }
}
