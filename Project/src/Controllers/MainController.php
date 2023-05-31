<?php
    namespace Controllers;
    use Models\Articles\Article;
    use View\View;
    use Services\Db;
    class MainController {
        private $view;
        private $db;
        public function __construct() {
            $this->view = new View(__DIR__.'/../../templates');
            // $this->db = new Db();
            $this->db = Db::getInstance();
        }

        public function main() {

            $articles = array_reverse(Article::findAll());
            // var_dump($articles);
            
            $this->view->renderHtml('main/main.php', ['articles' => $articles]);
        }

        public function sayHello(string $name) {
            $this->view->renderHtml('main/hello.php', ['page_title' => "Страница приветствия", 'name' => $name]);
        }
        public function sayBye(string $name) {
            echo 'Пока, '.$name;
        }
    }
?>