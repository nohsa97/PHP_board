<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?
        class Car {
            public $model;
            public $pay;
            public $speed;

            public function __construct(){
                $this->model = "람보르기니";
                $this->pay = 300;
                $this->speed = 150;
            }

            public function setModel(string $input)  {
                $this-> model = $input;
                    
            }
        }

        class CarSetting {
            private $model;
            private $pay;
            private $Car; 

            public function __construct(string $inputModel, int $inputPay) {
                $this->model = $inputModel;
                $this->pay = $inputPay;
                $this->Car = new Car();
            }

            public function showModel() :string {
                return $this->model;
            }
        }

        class Motor extends Car {
            public $by = "이륜";

            // public function __construct(){
            //     $this->model = "말파";
            //     $this -> by = "이륜";
            // }
        }

        $newCar = new Car();
        $newMotor = new Motor();

        echo $newCar->model."<br>";
        echo $newMotor->model;
        echo $newMotor->by."<br>";

        $newCar->setModel("바이크");
        $newCarSetting = new CarSetting("볼라레",5000);
        echo $newCar->model;
        echo $newCarSetting->showModel();
    ?>
</body>
</html>