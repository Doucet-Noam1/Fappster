<?php
declare(strict_types=1);
namespace onzeur\Input;

class FileChoserField{
    private $id;
    private $label;
    public function __construct(string $id,string $label){
        $this->id = $id;
        $this->label = $label;
    }

    public function render(){
        echo '<label for="avatar">'.$this->label." : </label></br>";
        echo '<input type="file" name="avatar" accept="audio/mp3"/></br>';
    }
}