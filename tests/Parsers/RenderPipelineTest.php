<?php namespace Test\Parsers;

use Myth\Parsers\RenderPipeline;

class RenderPipelineTest extends \CIUnitTestCase
{
    /**
     * @var RenderPipeline
     */
    protected $pipeline;

    public function setUp(): void
    {
        parent::setUp();

        $this->pipeline = new RenderPipeline();
    }

    public function testRenderMarkdown()
    {
        $source = "Hello\nWorld";

        $expected = "<p>Hello\nWorld</p>";

        $this->assertEquals($expected, $this->pipeline->render($source, 'Markdown'));
    }

    public function testRenderBBCode()
    {
        $source = "Hello [b]World[/b]";

        $expected = "Hello <strong>World</strong>";

        $this->assertEquals($expected, $this->pipeline->render($source, 'BBCode'));
    }

    public function testAtMentions()
    {
        $source = 'Hello @user1 World';

        $expected = 'Hello <a href="/forum/members/user1">@user1</a> World';

        $this->assertEquals($expected, $this->pipeline->render($source, 'BBCode'));
    }

    public function testHashtags()
    {
        $source = 'Hello #foo World';

        $expected = 'Hello <a href="/forum/hashtag/foo">#foo</a> World';

        $this->assertEquals($expected, $this->pipeline->render($source, 'BBCode'));
    }
}
