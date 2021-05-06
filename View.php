<?php


namespace app\core;


class View
{
    public string $title = '';

    /**
     * Render specified view with layout, introduce parameters
     * @param string $view
     * @param array $params
     * @return array|false|string|string[]
     */
    public function renderView(string $view, array $params = [])
    {
        // Get view content
        $viewContent = $this->renderOnlyView($view, $params);
        // Get layout content
        $layoutContent = $this->layoutContent();
        // Replace the slot in layout by view content, then return
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Write the controller's layout to buffer;
     * return the buffer
     * @return false|string
     */
    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout ?? Application::$app->layout;
        // Start writing into buffer
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * Return the specified view as a string,
     * create new variables from array $params
     * @param string $view
     * @param array $params
     * @return false|string
     */
    protected function renderOnlyView(string $view, array $params)
    {
        // For each element in array $params create a
        // variable with the name as a key of array and
        // value as a value
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        // Start buffering, render the view with the
        // specified name, then return buffer
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    /**
     * Render the content with the layout
     * @param string $viewContent
     * @return array|false|string|string[]
     */
    public function renderContent(string $viewContent)
    {
        // Get layout content
        $layoutContent = $this->layoutContent();
        // Replace the slot in layout by view content, then return
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}