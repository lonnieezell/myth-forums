<?php namespace Test\Forums;

use CodeIgniter\Test\CIDatabaseTestCase;
use Myth\Forums\TagManager;

class TagManagerTest extends CIDatabaseTestCase
{
    protected  $refresh = true;

    protected $namespace = 'App';

    /**
     * @var TagManager
     */
    protected $manager;

    public function setUp(): void
    {
        parent::setUp();

        $this->manager = new TagManager();
    }

    /**
     * @@expectedException  \App\Exceptions\DataException
     */
    public function testFindThrowsWhenNotFound()
    {
        $this->manager->find(123);
    }

    public function testFindSuccess()
    {
        $tag = $this->createTag();

        $found = $this->manager->find($tag->id);

        $this->assertEquals($tag->title, $found->title);
        $this->assertEquals($tag->slug, $found->slug);
        $this->assertEquals($tag->description, $found->description);
        $this->assertEquals($tag->parent_id, $found->parent_id);
        $this->assertEquals($tag->order, $found->order);
        $this->assertEquals($tag->is_structural, $found->is_structural);
    }


    protected function createTag(array $props = [])
    {
        $defaults = [
            'title' => 'Tag A',
            'slug' => 'tag-a',
            'description' => 'Some description.',
            'parent_id' => null,
            'order' => 0,
            'is_structural' => 0
        ];

        $props = array_merge($defaults, $props);

        $id = $this->manager->model->insert($props);

        return $this->manager->model->find($id);
    }
}
