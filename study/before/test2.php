<?

class Rectangle
{
    protected $width = 0;
    protected $height = 0;

    // public function render(int $area): void
    // {
    //     // ...
    // }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getArea(): int
    {
        return $this->width * $this->height;
    }
}

class Square extends Rectangle
{
    public function setWidth(int $width): void
    {
        $this->width = $this->height = $width;
    }

    public function setHeight(int $height): void
    {
        $this->width = $this->height = $height;
    }
}

/**
 * @param Rectangle[] $rectangles
 */
function renderLargeRectangles(array $rectangles): void
{
    foreach ($rectangles as $rectangle) {
        $rectangle->setWidth(4);
        $rectangle->setHeight(5);
        $area = $rectangle->getArea(); // 땡: 20이어야 하는 데, 정사각형에 25를 return할 것입니다.
        echo $area;
        // $rectangle->render($area);
    }
}

$rectangles = [new Rectangle(), new Rectangle(), new Square()];
renderLargeRectangles($rectangles);

?>