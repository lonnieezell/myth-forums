<?php namespace App\Core;

use App\Theme\MetaCollection;
use CodeIgniter\View\View;
use Config\Services;

trait ThemeTrait
{
    /**
     * The name of the theme's folder.
     *
     * @var string
     */
    protected $theme = 'default';

    /**
     * @var View
     */
    protected $renderer;

    /**
     * @var MetaCollection
     */
    protected $meta;

    /**
     * Stores a single var to be available to views during $this->render() calls.
     *
     * @param string $key
     * @param null   $value
     * @param string $context	The escaping context that should be used.
     *
     * @return $this
     */
    protected function setVar(string $key, $value = null, string $context = 'html')
    {
        $renderer = $this->getRenderer();

        $renderer->setVar($key, $value, $context);

        return $this;
    }

    /**
     * A simple method to allow the use of layouts and views.
     *
     * @param string $view
     * @param array  $data
     *
     * @return string
     */
    public function render(string $view, array $data = [])
    {
        $data['meta'] = $this->meta;

        return $this->renderView($view, $data, ['saveData' => true]);
    }

    /**
     * Same as the global view() helper, but uses our instance of the
     * renderer so we can render themes.
     *
     * @param string $name
     * @param array  $data
     * @param array  $options
     *
     * @return string
     */
    protected function renderView(string $name, array $data = [], array $options = [])
    {
        $renderer = $this->getRenderer();

        $saveData = null;
        if (array_key_exists('saveData', $options) && $options['saveData'] === true)
        {
            $saveData = (bool)$options['saveData'];
            unset($options['saveData']);
        }

        return $renderer->setData($data, 'raw')
            ->render($name, $options, $saveData);
    }

    /**
     * Gets an instance of our theme-based renderer and caches it locally.
     *
     * @return ThemedView|\CodeIgniter\View\View
     */
    protected function getRenderer()
    {
        if ($this->renderer !== null)
        {
            return $this->renderer;
        }

        $path = ROOTPATH ."themes/{$this->theme}";

        $this->renderer = Services::renderer($path, null, false);

        return $this->renderer;
    }
}
