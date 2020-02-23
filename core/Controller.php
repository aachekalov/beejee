<?php
namespace core;

class Controller
{
    /**
     * @var View the view object that can be used to render views
     */
    private $view;

    /**
     * @var string name (ID)
     */
    private $name;

    /**
     * @var string application base path
     */
    private $basePath;

    public function __construct($name)
    {
        $this->view = new View();
        $this->name = $name;
        $class = new \ReflectionClass($this);
        $this->basePath = dirname(dirname($class->getFileName()));
    }

    /**
     * Renders a view and applies layout if available.
     *
     * @param string $view the view name.
     * @param array $params the parameters (name-value pairs) that should be made available in the view.
     */
	function render($view, $params = [])
	{
        $viewPath = $this->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->name;
        $content = $this->view->render($view, $viewPath, $params);
        $layoutPath = $this->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
        return $this->view->renderFile($layoutPath, ['content' => $content]);
	}
}
