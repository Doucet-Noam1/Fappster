<?php
declare(strict_types=1);
namespace fappster\Input;
abstract class Input{
    protected string $label;

    protected string $id;

    public function __construct( string $label,string $id){
        $this->label = $label;
        $this->id = $id;
    }
    public abstract function render();
}

abstract class ChampInput extends Input{
    protected string $placeholder;

    public function __construct(string $placeholder, string $id,string $label){
        parent::__construct($label, $id);
        $this->placeholder = $placeholder;
    }

    public abstract function render();
}



class PasswordInput extends ChampInput{
    public function __construct(string $placeholder, string $id,string $label){
        parent::__construct($placeholder, $id,$label);
    }

    public function render(){
        echo "<label for=".$this->id.">".$this->label." : </label>";
        echo "<input type='password' id=".$this->id." placeholder=".$this->placeholder."></br>";
    }
}

class NumberInput extends Input{

    private int $min;
    private int $max;

    public function __construct(string $placeholder, string $id,string $label,int $min=0,int $max=100){
        parent::__construct($placeholder, $id,$label);
        $this->min = $min;
        $this->max = $max;
    }

    public function render(){
        echo "<label for=".$this->id.">".$this->label." : </label></br>";
        echo "<input type='number' min=".$this->min." max=".$this->max." name=".$this->id." id=".$this->id." placeholder=".$this->placeholder."></br>";
    }
}


?>
