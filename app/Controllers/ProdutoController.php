<?php

class ProdutoController extends Controller
{
    public function index(): void
    {
        $slug = trim((string) ($_GET['slug'] ?? ''));

        $productModel = $this->model('Product');
        $product = $slug !== '' ? $productModel->findBySlug($slug) : null;

        if ($product === null || $product['status'] !== 'ativo') {
            $this->view('produto/nao-encontrado', [
                'title' => 'Peça não encontrada — Macramê Nós de Lu',
            ]);

            return;
        }

        $this->view('produto/index', [
            'title'   => $product['name'] . ' — Macramê Nós de Lu',
            'product' => $product,
            'media'   => $productModel->media((int) $product['id']),
        ]);
    }
}
