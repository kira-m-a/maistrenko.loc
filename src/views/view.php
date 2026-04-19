<?php

namespace src\views;

class view
{
    private $layout;
    private  $extraVars;

    public function setVar($name, $value){
        $this->extraVars[$name] = $value;
    }
    public function __construct($layout)
    {
        $this->layout = $layout;
    }
    public function renderHtml($viewName, array $vars = [], int $code = 200)
    {
        http_response_code($code);
        $layoutFile = "layouts/{$this->layout}.php";
        $content = $this->renderFile($viewName, $vars);
        $fileVars = ['content' => $content];
        echo $this->renderFile($layoutFile,  $fileVars);
    }
    public function renderFile(string $fileName, array $vars)
    {
        extract($vars);
        extract($this->extraVars);
        $fileName =  __DIR__ . '/' . $fileName;
        if (file_exists($fileName)) {
            ob_start();
            include $fileName;
            $buffer = ob_get_contents();
            ob_get_clean();
            return $buffer;
        } else {
            echo ":( не найден файл по пути $fileName";
        }
    }
}
