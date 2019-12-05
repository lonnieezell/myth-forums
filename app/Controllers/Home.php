<?php namespace App\Controllers;

use App\Core\ThemedController;
use Myth\Auth\AuthTrait;

class Home extends ThemedController
{
	public function index()
	{
		echo $this->render('welcome');
	}

	//--------------------------------------------------------------------

}
