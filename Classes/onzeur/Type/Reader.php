<?php
declare(strict_types=1);

namespace onzeur\Type;

class Reader implements Irender{
    private $source;
    private $donnees;
    public function __construct($source=null){
        $this->source = $source;
        if ($source != null){
            $this->donnees = yaml_parse_file($source);
        }
    }
    public function getAlbums(){
        if ($this->donnees == null){
            return null;
        }
        $albums = array();
        foreach ($this->donnees as $key => $value) {
            $album = new Album($value["title"],array(),strval($value["releaseYear"]),$value["img"]);
            $albums[] = $album;
        }
        return $albums;
    }

    public function render(){
        echo '<div class="reader" style="border:1px solid black;">';
        echo '<h1>Reader</h1>';
        echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
        echo '<input type="file" name="fileToUpload" id="fileToUpload"/>';
        echo '<input type="submit" value="Upload Image" name="submit">';
        echo '</form>';
        echo '</div>';
        echo $this->source;
    }
}
?>