<?php

class ContatoController extends Controller
{
    public function index(): void
    {
        $this->view('contato/index', [
            'title' => 'Contato - Macramê Nós de Lu'
        ]);
    }
}
