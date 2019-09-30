<?php namespace Config;

use CodeIgniter\Config\BaseConfig;
use Myth\Parsers\BBCodeParser;
use Myth\Parsers\MarkdownParser;

class Parsers extends BaseConfig
{
    public $defaultParser = 'Markdown';

    public $availableParsers = [
        'Markdown' => MarkdownParser::class,
        'BBCode' => BBCodeParser::class,
    ];
}
