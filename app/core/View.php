<?php
namespace Core;

class View
{
    /**
     * Render une vue avec des variables
     *
     * @param string $view Nom du fichier vue (ex: "dashboard/index.php")
     * @param array $data Variables à passer à la vue
     */
    public static function render($view, $data = [])
    {
        // Rendre les variables accessibles dans la vue
        extract($data);

        // Résoudre chemin du fichier vue
        $file = __DIR__ . '/../../resources/views/' . $view;

        if (file_exists($file)) {
            include $file;
        } else {
            echo "<div style='color:red;padding:1rem;'>
                Erreur : Vue introuvable <strong>$view</strong>
            </div>";
        }
    }
}
