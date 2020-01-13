<?php namespace Myth\Forums\Controllers\Admin;

use App\Core\AdminController;
use App\Exceptions\DataException;
use Myth\Forums\TagManager;

class TagController extends AdminController
{
    /**
     * @var TagManager
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new TagManager();
    }

    /**
     * Manage tags
     */
    public function list()
    {
        $primaryTags = $this->tags->parents()->primary()->all();

        echo $this->render('admin/forum/tags', [
            'primaryTags' => $this->tags->populateChildTags($primaryTags),
            'secondaryTags' => $this->tags->parents()->secondary()->all(),
        ]);
    }

    /**
     * Create a new tag
     */
    public function create()
    {
        echo $this->render('admin/forum/tag_form', [
            'pageType' => 'create',
            'tagType' => $this->request->getVar('type'),
            'tags' => $this->tags->parents()->primary()->all(),
        ]);
    }

    /**
     * Edit an existing tag.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function edit(int $id)
    {
        try {
            $tag = $this->tags->find($id);

            echo $this->render('admin/forum/tag_form', [
                'pageType' => 'edit',
                'tag' => $tag,
                'tagType' => $tag->typeString(),
                'tags' => $this->tags->parents()->primary()->all(),
            ]);
        }
        catch (DataException $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Save/create an existing tag
     *
     * @param int|null $id
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function save(int $id = null)
    {
        try
        {
            if (empty($id))
            {
                $this->tags->createFromRequest($this->request);
            }
            else
            {
                $tag = $this->tags->find($id);
                $tag->fill($this->request->getPost());

                // Our public toggle doesn't show when off...
                $tag->public = $this->request->getPost('public');

                $this->tags->updateInstance($tag);
            }

            return redirect('forum-admin-tags')->with('message', lang('Messages.resourceSaved', ['Tag']));
        }
        catch(DataException $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
