<?php 
    class Cat {
        private $name;
        private $color;
        private $weight;

        public function __construct(string $name, string $color, int $weight) {
            $this->name = $name;
            $this->weight = $weight;
            $this->color = $color;
        }

        public function sayHello() {
            echo 'Hello, my name is '.$this->name." and I'm ".$this->color." color";
        }

        public function getColor() {
            return $this->color;
        }
    }

    $cat = new Cat("Murka", "black", "2.15");
    $cat->sayHello();
    echo '<br>getColor() - '.$cat->getColor();
?> 