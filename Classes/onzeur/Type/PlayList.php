<?php
declare(strict_types=1);

namespace onzeur\Type;


class PlayList extends Sortie
{
    const PATH = "data/images/covers/";
    public function __construct(Utilisateur|Artiste|array $artiste, string $nom, ?string $cover,array $listeTitres = [], int $id = null,)
    {
        $date  = date('d-m-Y');
        parent::__construct($artiste, $nom, $listeTitres, $date, $cover, 4, $id);
    }
    public function render()
    {
        echo '<a class="sortie" href="sortie.php?id=' . parent::getID() . '">';
        $image = self::PATH . $this->cover;
        echo '<img src="' . (($image != self::PATH && file_exists($image)) ? self::PATH . str_replace("%", "%25", $this->cover) : self::PATH . 'null.png') . '"/>';
        echo "<p>" . $this->nom . "</p>";
        $splitNameSpace = explode("\\", get_class($this));
        $splitNameSpace = end($splitNameSpace);
        echo "<p>" . $this->date . " • " . $splitNameSpace . "</p>";

        echo '</a>';
    }
    public function renderDetail()
    {
        $this->render();
    }
}
