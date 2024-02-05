<?php class DateSQL{
    private $year, $month,$day;

    public function __construct($day,$year,$month){
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function getString(){
        return $this->day . '/' . $this->month . '/' . $this->year;
    }
    public function year(){
        return $this->year;

    }
    public function month(){
        return $this->month;}

    public function day(){
        return $this->day;
    }
}

?>