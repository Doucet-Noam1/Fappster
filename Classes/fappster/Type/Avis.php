<?php
declare(strict_types=1);

namespace fappster\Type;

include_once 'BD.php';
abstract class Avis
{
    public static function getCoeur(bool $favori)
    {
        return '<svg height="64px" width="64px" viewBox="-15 -20 501.701 501.701" class="' . ($favori ? 'filledheart' : 'empty') . '">
        <path fill="red" d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1   c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3   l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4   C471.801,124.501,458.301,91.701,433.601,67.001z"/>
        </svg>';
    }
    public static function getEtoiles(?int $note): array
    {
        $note = $note ?? 0;
        $etoile = '<svg height="64px" width="64px" viewBox="-1 0 49.94 49.94" class="filledstar"><path fill="gold" d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757  c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042  c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685  c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528  c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956  C22.602,0.567,25.338,0.567,26.285,2.486z"/></svg>';
        $etoileVide = str_replace('filledstar', 'empty', $etoile);
        return array_merge(array_fill(0, $note, $etoile), array_fill(0, 5 - $note, $etoileVide));
    }
}