<?php namespace Myth\Users;

use App\Core\BaseManager;
use App\Entities\User;
use App\Models\UserModel;

class UserManager extends BaseManager
{
    public function __construct()
    {
        $this->model = new UserModel();

        parent::__construct();
    }

    /**
     * Saves the settings values for this user.
     *
     * @param User  $user
     * @param array $post
     *
     * @return bool
     */
    public function saveSettings(User $user, array $post)
    {
        $data = [
            'parser' => $post['parser'] ?? null,
            'dob' => $post['dob'] ?? null,
            'dob_privacy' => $post['dob_privacy'] ?? null,
            'website' => $post['website'] ?? null,
            'location' => $post['location'] ?? null,
            'country' => $post['country'] ?? null,
            'bio' => $post['bio'] ?? null,
            'auto_subscribe' => isset($post['auto_subscribe']),
            'show_online' => isset($post['show_online']),
            'allow_pm' => isset($post['allow_pm']),
        ];

        $data = array_filter($data, function($item) {
            return $item !== null;
        });

        return db_connect()->table('user_settings')
            ->where('user_id', $user->id)
            ->set($data)
            ->update();
    }

    public function findWithStats(string $username)
    {
        $select = "users.*, 
            (select count('id') from topics where author_id = users.id) as topicCount,
            (select count('id') from posts where author_id = users.id) as postCount
        ";

        return $this->model
            ->select($select)
            ->where('username', $username)
            ->first();
    }
}
