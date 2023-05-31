<?php
    namespace Controllers;
    use View\View;
    use Services\Db;
    use Models\Articles\Article;
    use Models\Users\User;
    use Models\Comments\Comment;
    // FIX ALL FOR LOGINED USER
    class CommentController {
        private $view;
        private $db;
        public function __construct() {
            $this->view = new View(__DIR__.'/../../templates');
            $this->db = Db::getInstance();
        }
        public function create() {
            $users = User::findAll();
            $this->view->renderHTML('article/create.php', ['users' => $users]);
        }

        public function store() {

            $author = User::getById($_POST['authorId']);
            $comment = new Comment();
            $comment->setArticleId($_POST['articleId']);
            $comment->setAuthorId(/*$author->getId()*/1);
            $comment->setText($_POST['text']);
            $res = $comment->save();

            // header('localhost/labs_php/Project/www/');
            $this->view->renderHTML('comment/store.php', ['comment' => $comment]);
        }

        // public function show(int $id) {
        //     $article = Article::getById($id);
        //     // var_dump($article[0]);
            
        //     if(!$article) {
        //         $this->view->renderHTML('errors/404.php', [], 404);
        //         return;
        //     }
        //     $author = $article->getAuthor();
        //     $this->view->renderHTML('article/show.php', ['article' => $article, 'author' => $author]);
        // }

        public function edit(int $id) {
            $comment = Comment::getById($id);
            $users = User::findAll();

            $this->view->renderHTML('comment/edit.php', ['comment' => $comment, 'users' => $users]);
        }

        public function update(int $id) {
            $comment = Comment::getById($id);

            $comment->setText($_POST['text']);
            $comment->setAuthorId($_POST['authorId']);
            $comment->save();
            $this->view->renderHTML('comment/update.php', ['comment' => $comment]);
            
        }
        public function delete(int $id) {
            $comment = Comment::getById($id);
            $comment->destroy();
            $this->view->renderHTML('comment/delete.php', ['comment' => $comment]);
        }
    }
?>