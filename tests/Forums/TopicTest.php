<?php namespace Test\Forums;

use Myth\Forums\Entities\Topic;

class TopicTest extends \CIUnitTestCase
{
    public function testSnippetReturnsEmptyString()
    {
        $topic = new Topic([
            'body' => null,
            'html' => null
        ]);

        $this->assertSame('', $topic->snippet());
    }

    public function testSnippetStripsHtml()
    {
        $topic = new Topic([
            'html' => '<h1>Hello World</h1> <p>What have you done for me lately.</p>'
        ]);

        $expects = 'Hello World What have you done for me lately.';

        $this->assertEquals($expects, $topic->snippet());
    }

    public function testSnippetLimitsWords()
    {
        $topic = new Topic([
            'html' => '<h1>Hello World</h1> <p>What have you done for me lately.</p>'
        ]);

        $expects = 'Hello World What&#8230;';

        $this->assertEquals($expects, $topic->snippet(3));
    }
}
