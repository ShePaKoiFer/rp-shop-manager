<?php
class Controller {
    protected function view($template, $data = []) {
        extract($data);
        require __DIR__ . "/../../resources/views/$template.php";
    }
}
