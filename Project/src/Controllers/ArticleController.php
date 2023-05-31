<?php
    namespace Controllers;
    use View\View;
    use Services\Db;
    use Models\Articles\Article;
    use Models\Users\User;
    use Models\Comments\Comment;
    class ArticleController {
        private $view;
        private $db;
        public function __construct() {
            $this->view = new View(__DIR__.'/../../templates');
            $this->db = Db::getInstance();
        }
        public function show(int $id) {
            $article = Article::getById($id);
            $comments = Comment::findAllWhere('article_id', $article->getId());
            $users = User::findAll();

            if(!$article) {
                $this->view->renderHTML('errors/404.php', [], 404);
                return;
            }
            $author = $article->getAuthor();
            $this->view->renderHTML('article/show.php', ['article' => $article, 'author' => $author, 'comments' => $comments, 'users' => $users]);
        }
        public function create() {
            $users = User::findAll();
            $this->view->renderHTML('article/create.php', ['users' => $users]);
        }

        public function store() {
            
            // var_dump($_POST['author']);

            $author = User::getById($_POST['authorId']);
            $article = new Article();
            $article->setAuthorId($author->getId());
            $article->setTitle($_POST['title']);
            $article->setText($_POST['text']);
            $article->save();

            // $article = Article::getById();
            // header('localhost/labs_php/Project/www/');
            $this->view->renderHTML('article/store.php', ['article' => $article]);
        }


        public function edit(int $id) {
            $article = Article::getById($id);
            $users = User::findAll();

            $this->view->renderHTML('article/edit.php', ['article' => $article, 'users' => $users]);
        }

        public function update(int $id) {
            $article = Article::getById($id);

            $article->setTitle($_POST['title']);
            $article->setText($_POST['text']);
            $article->setAuthorId($_POST['authorId']);
            $article->save();
            
            $this->view->renderHTML('article/update.php', ['article' => $article]);
        }
        public function delete(int $id) {
            $article = Article::getById($id);
            $article->destroy();
            // $article->id = null;
            // $article-> id
            $this->view->renderHTML('article/delete.php', ['article' => $article]);
        }
    }
?>