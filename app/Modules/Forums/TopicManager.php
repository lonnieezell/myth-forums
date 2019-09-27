<?php namespace Myth\Forums;

class TopicManager
{
    public function __construct()
    {
        $this->model = new TopicModel();
    }
}
