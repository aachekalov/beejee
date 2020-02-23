<?php
namespace core;

class View
{
    /**
     * Renders a view.
     *
     * @param string $view the view name.
     * @param string $viewPath the view path.
     * @param array $params the parameters (name-value pairs) that should be made available in the view.
     */
    function render($view, $viewPath, $params = [])
    {
        $viewFile = $viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        return $this->renderFile($viewFile, $params);
    }

    /**
     * Renders a view file as a PHP script.
     *
     * @param string $viewFile the view file
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @return string the rendering result
     */
    public function renderFile($viewFile, $params = [])
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try {
            require $viewFile;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }
}
