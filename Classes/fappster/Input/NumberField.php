<?php
declare(strict_types=1);
namespace fappster\Input;

class NumberField{

    private $id;
    private $label;

    public function __construct(string $id,string $label,){
        $this->id = $id;
        $this->label = $label;
    }

    public function render(){
        echo "<label for=".$this->id.">".$this->label." : </label></br>";
        echo "<input type='number' name=".$this->id." id=".$this->id."></br>";
    }
}