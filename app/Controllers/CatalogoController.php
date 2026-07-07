<?php

class CatalogoController extends Controller
{
    public function index(): void
    {
        $this->view('catalogo/index', [
            'title' => 'Catálogo - Macramê Nós de Lu'
        ]);
    }
}
