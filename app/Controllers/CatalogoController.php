<?php

class CatalogoController extends Controller
{
    public function index(): void
    {
        $this->view('catalogo/index', [
            'title' => 'Nossa Loja — Macramê Nós de Lu',
        ]);
    }
}
