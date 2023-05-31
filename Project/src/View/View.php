<?php 

namespace VIEW;

class View {
    private $templatesPath;
    public function __construct(string $templatesPath) {
        $this->templatesPath = $templatesPath;

    }

    public function renderHTML($templateName, array $vars, int $code = 200) {
        extract($vars);
        http_response_code($code);
        include $this->templatesPath.'/'.$templateName;
    }

}

?>