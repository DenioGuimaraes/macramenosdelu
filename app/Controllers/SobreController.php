<?php

class SobreController extends Controller
{
    public function index(): void
    {
        $this->view('sobre/index', [
            'title' => 'Sobre - Macramê Nós de Lu'
        ]);
    }
}
