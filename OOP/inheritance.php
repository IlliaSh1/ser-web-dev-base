<?php
    class Post
    {

        protected $title;
        protected $text;

        public function __construct(string $title, string $text) {
            $this->title = $title;
            $this->text = $text;
        }

        public function getTitle(): string {
            return $this->title;
        }


        public function setTitle($title) {
            $this->title = $title;
        }



        public function getText() {
            return $this->text;
        }



        public function setText($text): void {
            $this->text = $text;
        }
    }

    class Lesson extends Post {
        protected $homework;
        public function __construct(string $title, string $text, string $homework) {
            $this->title = $title;
            $this->text = $text;
            $this->homework = $homework;
        }


        public function getHomework(): string {
            return $this->homework;
        }
    

        public function setHomework(string $homework): void {
            $this->homework = $homework;
        }
    }

    class PaidLesson extends Lesson {
        private $price;

        public function __construct(string $title, string $text, string $homework, float $price) {
            parent::__construct($title, $text, $homework);
            $this->price = $price;
        }

        public function getPrice(): string {
            return $this->price;
        }
    

        public function setPrice(string $price): void {
            $this->price = $price;
        }
    }

    $paidLesson1 = new PaidLesson('Урок о наследовании в PHP', 'Лол, кек, чебурек', 'Ложитесь спать, утро вечера мудренее', '99.90');
    var_dump($paidLesson1); 
?>