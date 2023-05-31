<?php
    namespace Models\Articles;
    use Models\ActiveRecordEntity;
    use Models\Users\User;
    use Services\Db;
    class Article extends ActiveRecordEntity
    {   

        protected $title;
        protected $text;
        protected $authorId;
        protected $createdAt;
        
        public static function getTableName():string {
            return 'articles';
        }
        public function getAuthorId() {
            return $this->authorId;
        }
        public function getTitle() {
            return $this->title;
        }
        public function getText() {
            return $this->text;
        }
        public function getCreatedAt() {
            return $this->createdAt;
        }

        
        public function getAuthor():User {
            return User::getById($this->authorId);
        }

        public function setTitle(string $title) {
            $this->title = $title;
        }


        public function setText(string $text) {
            $this->text = $text;
        }

        public function setAuthorId(int $id) {
            $this->authorId = $id;
        }

    }