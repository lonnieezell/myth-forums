<?php namespace App\Controllers;

use App\Core\ThemedController;

class Home extends ThemedController
{
	public function index()
	{
		echo $this->render('welcome');
	}

	//--------------------------------------------------------------------

}
