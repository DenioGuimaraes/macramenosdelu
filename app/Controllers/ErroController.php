<?php

class ErroController extends Controller
{
    public function index(): void
    {
        http_response_code(404);

        $this->view('erro/404', [
            'title' => 'Página não encontrada — Macramê Nós de Lu',
        ]);
    }
}
