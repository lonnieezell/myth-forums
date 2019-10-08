<?php namespace Myth\Users\Controllers;

use App\Core\ThemedController;
use App\Exceptions\DataException;
use App\Models\CountryModel;
use App\Models\UserModel;
use Myth\Users\UserManager;

class AccountController extends ThemedController
{
    /**
     * Display user account page.
     */
    public function index()
    {
        $countries = model(CountryModel::class);

        echo $this->render('users/account', [
            'user' => user(),
            'countries' => $countries->findAll(),
        ]);
    }

    /**
     * Save the current user's account settings.
     *
     * @return mixed
     */
    public function save()
    {
        $this->validate([
            'dob' => 'permit_empty|date',
            'dob_privacy' => 'permit_empty|in_list[1,2,3]',
            'website' => 'permit_empty|valid_url',
            'location' => 'permit_empty|max_length[255]',
            'bio' => 'permit_empty',
        ]);

        try
        {
            $user = user();
            $manager = new UserManager();

            $errors = $manager->saveSettings($user, $this->request->getPost());

            if ($errors !== true)
            {
                return redirect()->back()->withInput()->with('errors', $errors);
            }

            return redirect()->back()->with('message', lang('messages.resourceSaved', ['Account']));
        }
        catch (DataException $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
