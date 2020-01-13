<?php namespace Myth\Forums;

use App\Core\BaseManager;
use CodeIgniter\HTTP\Request;
use Myth\Forums\Entities\Tag;
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
        $this->model->groupStart()
            ->where('parent_id', 0)
            ->orWhere('parent_id', null)
            ->groupEnd();

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

    /**
     * Populate our child tags, if any.
     *
     * @param array $parents
     *
     * @return array|mixed|Tag
     */
    public function populateChildTags(array $parents)
    {
        if (empty($parents)) return $parents;

        $ids = [];
        $wasSingle = false;

        if ($parents instanceof Tag) {
            $parents = [$parents];
            $wasSingle = true;
        }

        foreach($parents as $topic) {
            $ids[] = $topic->id;
        }

        $ids = array_unique($ids);

        $children = $this->model
            ->whereIn('parent_id', $ids)
            ->orderBy('order', 'asc')
            ->findAll();

        // Index by parent_id
        $indexedChildren = [];

        foreach($children as $child) {
            if (! isset($indexedChildren[$child->parent_id])) {
                $indexedChildren[$child->parent_id] = [];
            }

            $indexedChildren[$child->parent_id][] = $child;
        }

        foreach ($parents as $parent) {
            $parent->tags = isset($indexedChildren[$parent->id])
                ? $indexedChildren[$parent->id]
                : [];
        }

        return $wasSingle
            ? array_pop($parents)
            : $parents;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function createFromRequest(Request $request)
    {
        helper('text');

        $data = [
            'title' => $request->getVar('title'),
            'slug' => slugify($request->getVar('title')),
            'description' => $request->getVar('description'),
            'parent_id' => $request->getVar('parent_id', null),
            'order' => 0,
            'is_structural' => $request->getVar('is_structural'),
            'color' => $request->getVar('color', null),
            'icon' => $request->getVar('icon', null),
            'public' => $request->getVar('public', 0),
        ];

        return $this->model->insert($data);
    }
}
