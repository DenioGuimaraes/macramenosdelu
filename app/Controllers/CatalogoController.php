<?php

class CatalogoController extends Controller
{
    public function index(): void
    {
        $categorySlug = trim((string) ($_GET['cat'] ?? ''));

        $categoryModel = $this->model('Category');
        $productModel = $this->model('Product');

        $this->view('catalogo/index', [
            'title'        => 'Nossa Loja — Macramê Nós de Lu',
            'categories'   => $categoryModel->active(),
            'products'     => $productModel->published($categorySlug !== '' ? $categorySlug : null),
            'activeSlug'   => $categorySlug,
        ]);
    }
}
