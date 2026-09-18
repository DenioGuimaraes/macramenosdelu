<?php

class ContatoController extends Controller
{
    public function index(): void
    {
        $this->view('contato/index', [
            'title' => 'Fale com a gente — Macramê Nós de Lu',
        ]);
    }
}
