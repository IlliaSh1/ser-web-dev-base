<?php
    namespace Models\Comments;
    use Models\ActiveRecordEntity;
    use Models\Users\User;
    use Models\Articles\Article;
    use Services\Db;
    class Comment extends ActiveRecordEntity
    {   

        protected $text;
        protected $authorId;
        protected $articleId;
        protected $createdAt;

        public static function getTableName():string {
            return 'comments';
        }
        public function getText() {
            return $this->text;
        }
        public function getAuthorId() {
            return $this->authorId;
        }
        public function getArticleId() {
            return $this->articleId;
        }
        public function getCreatedAt() {
            return $this->createdAt;
        }

        
        public function getAuthor():User {
            return User::getById($this->authorId);
        }
        public function getArticle():User {
            return Article::getById($this->articleId);
        }


        public function setText(string $text) {
            $this->text = $text;
        }

        public function setAuthorId(int $id) {
            $this->authorId = $id;
        }
        public function setArticleId(int $id) {
            $this->articleId = $id;
        }

    }