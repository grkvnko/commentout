<?php
namespace Commentout\Controllers;

abstract class Controller
{
    public function render($view, $data = [])
    {
        require_once 'app/views/' . $view . '.php';
    }

    public function model($model)
    {
        $model = 'Commentout\Models\\'.$model;
        return new $model;
    }
}