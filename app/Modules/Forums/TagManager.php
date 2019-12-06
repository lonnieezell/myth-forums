<?php namespace Myth\Forums;

use App\Core\BaseManager;
use Myth\Forums\Models\TagModel;

class TagManager extends BaseManager
{
    public function __construct()
    {
        $this->model = model(TagModel::class);

        parent::__construct();
    }

    /**
     * Scope method to get all parent tags in the system.
     *
     * @return $this
     */
    public function parents()
    {
        $this->model->whereNull('parent_id');

        return $this;
    }

    /**
     * Scope method to only return structural, or primary, tags.
     *
     * @return $this
     */
    public function primary()
    {
        $this->model->where('is_structural', 1);

        return $this;
    }

    /**
     * Scope method to only return non-structural, or secondary, tags.
     *
     * @return $this
     */
    public function secondary()
    {
        $this->model->where('is_structural', 0);

        return $this;
    }
}
