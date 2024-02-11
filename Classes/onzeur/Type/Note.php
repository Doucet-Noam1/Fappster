<?php 
declare(strict_types=1);

namespace onzeur\Type;



class Note implements Irender{
    private $album;
    private $note;
    public function __construct($album,$note){
        $this->album = $album;
        $this->note = $note;
    }
    public function render(){
        echo '<div class="note">';
        echo "<h1>".$this->album."</h1>";
        echo "<p>".$this->note."</p>";
        echo '</div>';
    }

    public function getAlbum(){
        return $this->album;
    }
    public function getNote(){
        return $this->note;
    }

}