<?php

/**
 * ============================================================
 * HomeController
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Responsável por controlar a página inicial.
 * ============================================================
 */

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index');
    }
}
