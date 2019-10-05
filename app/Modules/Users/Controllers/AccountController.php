<?php namespace Myth\Users\Controllers;

use App\Core\ThemedController;

class AccountController extends ThemedController
{
    /**
     * Display user account page.
     */
    public function index()
    {
        echo $this->render('users/account', [
            'user' => user()
        ]);
    }
}
