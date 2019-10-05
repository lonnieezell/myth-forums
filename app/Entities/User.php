<?php namespace App\Entities;

use CodeIgniter\Entity;

class User extends \Myth\Auth\Entities\User
{
    const DOB_DISPLAY_BOTH = 1;
    const DOB_DISPLAY_NONE = 2;
    const DOB_DISPLAY_AGE = 3;

    /**
     * Maps names used in sets and gets against unique
     * names within the class, allowing independence from
     * database column names.
     *
     * Example:
     *  $datamap = [
     *      'db_name' => 'class_name'
     *  ];
     */
    protected $datamap = [];

    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts = [
        'active'           => 'boolean',
        'force_pass_reset' => 'boolean',
    ];

    /**
     * User Settings cache.
     *
     * @var array
     */
    protected $settings;

	/**
	 * Automatically hashes the password when set.
	 *
	 * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
	 *
	 * @param string $password
	 */
	public function setPassword(string $password)
	{
        $config = config('Auth');

        if (
            (defined('PASSWORD_ARGON2I') && $config->hashAlgorithm == PASSWORD_ARGON2I)
                ||
            (defined('PASSWORD_ARGON2ID') && $config->hashAlgorithm == PASSWORD_ARGON2ID)
            )
        {
            $hashOptions = [
                'memory_cost' => $config->hashMemoryCost,
                'time_cost'   => $config->hashTimeCost,
                'threads'     => $config->hashThreads
                ];
        }
        else
        {
            $hashOptions = [
                'cost' => $config->hashCost
                ];
        }

        $this->attributes['password_hash'] = password_hash(
            base64_encode(
                hash('sha384', $password, true)
            ),
            $config->hashAlgorithm,
            $hashOptions
        );
	}

    /**
     * Generates a secure hash to use for password reset purposes,
     * saves it to the instance.
     *
     * @return $this
     * @throws \Exception
     */
	public function generateResetHash()
	{
		$this->attributes['reset_hash'] = bin2hex(random_bytes(16));
		$this->attributes['reset_start_time'] = date('Y-m-d H:i:s');

		return $this;
	}

    /**
     * Generates a secure random hash to use for account activation.
     *
     * @return $this
     * @throws \Exception
     */
	public function generateActivateHash()
	{
		$this->attributes['activate_hash'] = bin2hex(random_bytes(16));

		return $this;
	}

	/**
	 * Bans a user.
	 *
	 * @param string $reason
	 *
	 * @return $this
	 */
	public function ban(string $reason)
	{
		$this->attributes['status'] = 'banned';
		$this->attributes['status_message'] = $reason;

		return $this;
	}

	/**
	 * Removes a ban from a user.
	 *
	 * @return $this
	 */
	public function unBan()
	{
		$this->attributes['status'] = $this->status_message = '';

		return $this;
	}

	/**
	 * Checks to see if a user has been banned.
	 *
	 * @return bool
	 */
	public function isBanned(): bool
	{
		return isset($this->attributes['status']) && $this->attributes['status'] === 'banned';
	}

    /**
     * Returns the user's permissions, automatically
     * json_decoding them into an associative array.
     *
     * @return array|mixed
     */
    public function getPermissions()
    {
        return ! empty($this->permissions)
            ? json_decode($this->permissions, true)
            : [];
	}

    /**
     * Stores the permissions, automatically json_encoding
     * them for saving.
     *
     * @param array $permissions
     *
     * @return $this
     */
    public function setPermissions(array $permissions = null)
    {
        if (is_array($permissions))
        {
            $this->permissions = json_encode($permissions);
        }

        return $this;
	}

    /**
     * Avatar URL. Provides default imange through Gravatar
     * if none has been set locally.
     *
     * @param int $size
     *
     * @return mixed
     */
    public function avatar(int $size=120)
    {
        // If they've uploaded one here - use it!
        if (! empty($this->attributes['avatar'])) {
            return $this->attributes['avatar'];
        }

        // Otherwise, use gravatar
        $url = 'https://www.gravatar.com/avatar/';

        $hash = md5(trim(mb_strtolower($this->email)));

        $url .= $hash ."?s={$size}&d=wavatar";

        return $url;
	}

    /**
     * Returns the URL to this users profile.
     *
     * @return string
     */
    public function link()
    {
        return base_url('/members/'. $this->username);
	}

    /**
     * Returns a user-specific setting.
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function setting(string $key)
    {
        if ($this->settings === null)
        {
            $this->settings = db_connect()->table('user_settings')
                ->where('user_id', $this->id)
                ->get()
                ->getResultArray();

            if (! empty($this->settings))
            {
                $this->settings = array_pop($this->settings);
            }
        }

        return $this->settings[$key];
	}
}
