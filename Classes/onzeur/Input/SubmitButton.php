<?php
declare(strict_types=1);
namespace onzeur\Input;

class SubmitButton{

    private $id;
    private $label;
    public function __construct(string $id,string $label){
        $this->id = $id;
        $this->label = $label;
    }

    public function render(){
        echo "<input type='submit' value=".$this->label." id=".$this->id.">";
    }
}
