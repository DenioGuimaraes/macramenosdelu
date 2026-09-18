<?php

class ProdutoController extends Controller
{
    /**
     * Página da peça.
     * Aceita /produto/{slug} e também ?url=produto&slug={slug}.
     */
    public function index(string $slug = ''): void
    {
        $slug = trim($slug !== '' ? $slug : (string) ($_GET['slug'] ?? ''));

        $productModel = $this->model('Product');
        $product = $slug !== '' ? $productModel->findBySlug($slug) : null;

        if ($product === null || $product['status'] !== 'ativo') {
            http_response_code(404);

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
