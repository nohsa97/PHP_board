<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        class student {
            private $name;
            private $age;
            private $school;
            public static $m1=10;
            public $m2;

            public function __construct($name,$age,$school) {
                $this -> name = $name;
                $this -> age = $age;
                $this -> school = $school;
                self::$m1 +=1;
                $this -> m2 = 10;
            }

            public function getName() {
                return $this->name;
            }
            
            public function getMlie() {
                $this->m1++;
                return $this->m1;
            }
        }

        $new = new student("노홍석",20,"상명");
        $new2 = new student("노홍석2",20,"상명");
        $new2 = new student("노홍석2",20,"상명");
        echo $new->m2;
        echo student::$m1;
    ?>

</body>
</html>