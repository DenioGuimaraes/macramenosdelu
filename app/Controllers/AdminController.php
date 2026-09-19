<?php

/**
 * ============================================================
 * AdminController
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Painel administrativo (/admin).
 * Acesso restrito por login; o site público não expõe links.
 * ============================================================
 */

class AdminController extends Controller
{
    private const MAX_UPLOAD_BYTES = 10 * 1024 * 1024;

    private const IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private const VIDEO_TYPES = ['video/mp4', 'video/webm'];

    // ========================================================
    // Autenticação
    // ========================================================

    public function index(): void
    {
        $this->guard();
        $this->dashboard();
    }

    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('admin');
        }

        $error = null;
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');

            if (!Auth::csrfValid($_POST['csrf_token'] ?? null)) {
                $error = 'Sessão expirada. Tente novamente.';
            } else {
                $user = $this->model('AdminUser')->verifyPassword($email, $password);

                if ($user === null) {
                    $error = 'E-mail ou senha inválidos.';
                } else {
                    Auth::login($user);
                    $this->redirect('admin');
                }
            }
        }

        $this->bareView('admin/login', [
            'title' => 'Painel — Macramê Nós de Lu',
            'error' => $error,
            'email' => $email,
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('admin/login');
    }

    // ========================================================
    // Dashboard
    // ========================================================

    public function dashboard(): void
    {
        $this->guard();

        $products = $this->model('Product');
        $orders = $this->model('Order');
        $activity = $this->model('ActivityLog');

        $this->adminView('admin/dashboard', [
            'title'          => 'Dashboard — Painel',
            'pageTitle'      => 'Dashboard',
            'pageSubtitle'   => 'Visão geral do catálogo e das operações',
            'activeMenu'     => 'dashboard',
            'totalProducts'  => $products->countAll(),
            'activeProducts' => $products->countByStatus('ativo'),
            'pausedProducts' => $products->countByStatus('pausado'),
            'pendingOrders'  => $orders->countByStatus('pendente'),
            'lowStock'       => $products->lowStock(3),
            'recentActivity' => $activity->recent(6),
        ]);
    }

    // ========================================================
    // Produtos
    // ========================================================

    public function produtos(): void
    {
        $this->guard();

        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        $term = trim((string) ($_GET['busca'] ?? ''));
        $categoryId = ($_GET['categoria'] ?? '') !== '' ? (int) $_GET['categoria'] : null;

        $this->adminView('admin/produtos', [
            'title'          => 'Produtos — Painel',
            'pageTitle'      => 'Produtos',
            'pageSubtitle'   => 'Catálogo da Macramê Nós de Lu',
            'activeMenu'     => 'produtos',
            'products'       => $productModel->search($term, $categoryId),
            'mediaByProduct' => $productModel->allMediaGrouped(),
            'categories'     => $categoryModel->all(),
            'totalProducts'  => $productModel->countAll(),
            'activeProducts' => $productModel->countByStatus('ativo'),
            'pausedProducts' => $productModel->countByStatus('pausado'),
            'searchTerm'     => $term,
            'categoryId'     => $categoryId,
        ]);
    }

    public function produtoSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $productModel = $this->model('Product');
        $data = Product::sanitizeInput($_POST);
        $id = (int) ($_POST['id'] ?? 0);

        if ($data['name'] === '') {
            Auth::flash('Informe o nome do produto.', 'error');
            $this->redirect('admin/produtos');
        }

        // O estoque é gerenciado na tela própria; preserva o valor atual na edição.
        if ($id > 0 && !isset($_POST['stock_qty'])) {
            $existing = $productModel->find($id);
            $data['stock_qty'] = (int) ($existing['stock_qty'] ?? 0);
        }

        if ($id > 0) {
            $productModel->update($id, $data);
            $this->log('produto', $id, 'atualizado', 'Produto atualizado: ' . $data['name']);
            Auth::flash('Produto atualizado com sucesso.');
        } else {
            $id = $productModel->create($data);
            $this->log('produto', $id, 'criado', 'Produto adicionado: ' . $data['name']);
            Auth::flash('Produto adicionado com sucesso.');
        }

        $this->storeProductMedia($productModel, $id);

        $this->redirect('admin/produtos');
    }

    public function produtoStatus(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $productModel = $this->model('Product');
            $status = $productModel->toggleStatus($id);
            $product = $productModel->find($id);

            $this->log(
                'produto',
                $id,
                $status,
                ($product['name'] ?? 'Produto') . ' agora está ' . $status
            );

            Auth::flash('Status atualizado para ' . $status . '.');
        }

        $this->redirect('admin/produtos');
    }

    public function produtoExcluir(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $productModel = $this->model('Product');
            $product = $productModel->find($id);

            foreach ($productModel->media($id) as $media) {
                $this->removeUploadedFile($media['file_path']);
            }

            $productModel->delete($id);
            $this->log('produto', null, 'excluido', 'Produto excluído: ' . ($product['name'] ?? '#' . $id));
            Auth::flash('Produto excluído.');
        }

        $this->redirect('admin/produtos');
    }

    public function midiaExcluir(): void
    {
        $this->guard();
        $this->requirePost();

        $mediaId = (int) ($_POST['media_id'] ?? 0);

        if ($mediaId > 0) {
            $productModel = $this->model('Product');
            $media = $productModel->findMedia($mediaId);

            if ($media !== null) {
                $this->removeUploadedFile($media['file_path']);
                $productModel->deleteMedia($mediaId);
                Auth::flash('Mídia removida.');
            }
        }

        $this->redirect('admin/produtos');
    }

    // ========================================================
    // Categorias
    // ========================================================

    public function categorias(): void
    {
        $this->guard();

        $categoryModel = $this->model('Category');

        $this->adminView('admin/categorias', [
            'title'        => 'Categorias — Painel',
            'pageTitle'    => 'Categorias',
            'pageSubtitle' => 'Organize o catálogo por tipo de peça',
            'activeMenu'   => 'categorias',
            'categories'   => $categoryModel->withProductCount(),
        ]);
    }

    public function categoriaSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $categoryModel = $this->model('Category');

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim((string) ($_POST['name'] ?? ''));
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($name === '') {
            Auth::flash('Informe o nome da categoria.', 'error');
            $this->redirect('admin/categorias');
        }

        if ($id > 0) {
            $categoryModel->update($id, $name, $sortOrder, $isActive);
            Auth::flash('Categoria atualizada.');
        } else {
            $categoryModel->create($name, $sortOrder);
            Auth::flash('Categoria criada.');
        }

        $this->log('categoria', $id ?: null, 'salva', 'Categoria salva: ' . $name);
        $this->redirect('admin/categorias');
    }

    public function categoriaExcluir(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model('Category')->delete($id);
            $this->log('categoria', null, 'excluida', 'Categoria excluída #' . $id);
            Auth::flash('Categoria excluída.');
        }

        $this->redirect('admin/categorias');
    }

    // ========================================================
    // Estoque
    // ========================================================

    public function estoque(): void
    {
        $this->guard();

        $productModel = $this->model('Product');

        $this->adminView('admin/estoque', [
            'title'        => 'Estoque — Painel',
            'pageTitle'    => 'Estoque',
            'pageSubtitle' => 'Quantidades disponíveis por produto',
            'activeMenu'   => 'estoque',
            'products'     => $productModel->stockList(),
        ]);
    }

    public function estoqueSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $productModel = $this->model('Product');
        $quantities = $_POST['stock'] ?? [];

        if (is_array($quantities)) {
            foreach ($quantities as $productId => $quantity) {
                $productModel->updateStock((int) $productId, (int) $quantity);
            }

            $this->log('estoque', null, 'atualizado', 'Estoque atualizado');
            Auth::flash('Estoque atualizado.');
        }

        $this->redirect('admin/estoque');
    }

    // ========================================================
    // Pedidos
    // ========================================================

    public function pedidos(): void
    {
        $this->guard();

        $orderModel = $this->model('Order');

        $this->adminView('admin/pedidos', [
            'title'        => 'Pedidos — Painel',
            'pageTitle'    => 'Pedidos',
            'pageSubtitle' => 'Contatos e vendas registradas manualmente',
            'activeMenu'   => 'pedidos',
            'orders'       => $orderModel->all(),
            'pending'      => $orderModel->countByStatus('pendente'),
        ]);
    }

    public function pedidoSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $name = trim((string) ($_POST['customer_name'] ?? ''));

        if ($name === '') {
            Auth::flash('Informe o nome do cliente.', 'error');
            $this->redirect('admin/pedidos');
        }

        $this->model('Order')->create([
            'customer_name' => $name,
            'contact'       => trim((string) ($_POST['contact'] ?? '')),
            'channel'       => in_array($_POST['channel'] ?? '', ['whatsapp', 'shopee', 'site', 'outro'], true)
                ? $_POST['channel']
                : 'whatsapp',
            'status'        => 'pendente',
            'total'         => (float) str_replace(',', '.', (string) ($_POST['total'] ?? '0')),
            'notes'         => trim((string) ($_POST['notes'] ?? '')),
        ]);

        $this->log('pedido', null, 'criado', 'Pedido registrado: ' . $name);
        Auth::flash('Pedido registrado.');
        $this->redirect('admin/pedidos');
    }

    public function pedidoStatus(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);
        $status = (string) ($_POST['status'] ?? '');

        if ($id > 0 && $this->model('Order')->updateStatus($id, $status)) {
            Auth::flash('Pedido atualizado.');
        }

        $this->redirect('admin/pedidos');
    }

    public function pedidoExcluir(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model('Order')->delete($id);
            Auth::flash('Pedido excluído.');
        }

        $this->redirect('admin/pedidos');
    }

    // ========================================================
    // Página Sobre
    // ========================================================

    public function sobre(): void
    {
        $this->guard();

        $this->adminView('admin/sobre', [
            'title'        => 'Sobre — Painel',
            'pageTitle'    => 'Sobre',
            'pageSubtitle' => 'Imagem e textos da página institucional',
            'activeMenu'   => 'sobre',
            'settings'     => $this->model('Setting')->map(),
        ]);
    }

    public function sobreSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $settingModel = $this->model('Setting');

        $textKeys = [
            'about_text_1',
            'about_text_2',
            'about_sustainability_title',
            'about_sustainability_text',
        ];

        foreach ($textKeys as $key) {
            if (array_key_exists($key, $_POST)) {
                $settingModel->set($key, trim((string) $_POST[$key]));
            }
        }

        $currentImage = trim((string) ($settingModel->get('about_image') ?? ''));

        if (!empty($_POST['remove_about_image'])) {
            if ($currentImage !== '') {
                $this->removeUploadedFile($currentImage);
            }

            $settingModel->set('about_image', '');
        } else {
            $file = $_FILES['about_image'] ?? null;

            if (is_array($file) && ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                $path = $this->storeUpload($file, 'sobre', self::IMAGE_TYPES);

                if ($path !== null) {
                    if ($currentImage !== '') {
                        $this->removeUploadedFile($currentImage);
                    }

                    $settingModel->set('about_image', $path);
                } else {
                    Auth::flash('A imagem enviada não é válida ou excede o tamanho permitido.', 'error');
                    $this->redirect('admin/sobre');
                }
            }
        }

        $this->log('sobre', null, 'atualizada', 'Conteúdo da página Sobre atualizado');
        Auth::flash('Conteúdo da página Sobre atualizado.');
        $this->redirect('admin/sobre');
    }

    // ========================================================
    // Conteúdo da Home
    // ========================================================

    public function home(): void
    {
        $this->guard();

        $this->adminView('admin/home', [
            'title'        => 'Home — Painel',
            'pageTitle'    => 'Home',
            'pageSubtitle' => 'Textos exibidos na página inicial',
            'activeMenu'   => 'home',
            'settings'     => $this->model('Setting')->map(),
            'heroCarousel' => $this->model('HeroCarouselItem')->all(),
        ]);
    }

    public function homeSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $settingModel = $this->model('Setting');

        $keys = [
            'header_ticker_message',
            'home_hero_title',
            'home_hero_subtitle',
            'home_hero_cta',
            'home_brand_bar',
            'home_welcome',
        ];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $_POST)) {
                continue;
            }

            $settingModel->set($key, trim((string) $_POST[$key]));
        }

        $this->log('home', null, 'atualizada', 'Conteúdo da home atualizado');
        Auth::flash('Conteúdo da home atualizado.');
        $this->redirect('admin/home');
    }

    public function homeHeroUpload(): void
    {
        $this->guard();
        $this->requirePost();

        $mediaType = ($_POST['media_type'] ?? '') === 'video' ? 'video' : 'image';
        $field = $mediaType === 'video' ? 'video' : 'image';
        $allowed = $mediaType === 'video' ? self::VIDEO_TYPES : self::IMAGE_TYPES;

        $carouselModel = $this->model('HeroCarouselItem');
        $uploaded = 0;

        foreach ($this->normalizeFiles($_FILES[$field] ?? null) as $file) {
            $path = $this->storeUpload($file, 'hero', $allowed);

            if ($path !== null) {
                $carouselModel->create($mediaType, $path, $carouselModel->nextOrder());
                $uploaded++;
            }
        }

        if ($uploaded === 0) {
            Auth::flash('Nenhum arquivo válido foi enviado.', 'error');
        } else {
            $this->log('hero_carousel', null, 'upload', "{$uploaded} mídia(s) adicionada(s) ao carrossel");
            Auth::flash($uploaded === 1 ? 'Mídia adicionada ao carrossel.' : "{$uploaded} mídias adicionadas ao carrossel.");
        }

        $this->redirect('admin/home');
    }

    public function homeHeroMover(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);
        $direction = ($_POST['direction'] ?? '') === 'up' ? 'up' : 'down';

        $moved = $this->model('HeroCarouselItem')->move($id, $direction);

        Auth::flash(
            $moved ? 'Ordem atualizada.' : 'Não foi possível mover este item.',
            $moved ? 'success' : 'error'
        );

        $this->redirect('admin/home');
    }

    public function homeHeroExcluir(): void
    {
        $this->guard();
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);
        $carouselModel = $this->model('HeroCarouselItem');
        $item = $carouselModel->find($id);

        if ($item !== null) {
            $this->removeUploadedFile($item['file_path']);
            $carouselModel->delete($id);
            Auth::flash('Item removido do carrossel.');
        }

        $this->redirect('admin/home');
    }

    // ========================================================
    // Links
    // ========================================================

    public function links(): void
    {
        $this->guard();

        $this->adminView('admin/links', [
            'title'        => 'Links — Painel',
            'pageTitle'    => 'Links',
            'pageSubtitle' => 'Canais exibidos no rodapé e na página de contato',
            'activeMenu'   => 'links',
            'links'        => $this->model('SiteLink')->all(),
        ]);
    }

    public function linksSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $linkModel = $this->model('SiteLink');
        $rows = $_POST['links'] ?? [];

        if (is_array($rows)) {
            foreach ($rows as $id => $row) {
                $linkModel->update(
                    (int) $id,
                    trim((string) ($row['label'] ?? '')),
                    trim((string) ($row['url'] ?? '')),
                    trim((string) ($row['display'] ?? '')),
                    isset($row['is_active']) ? 1 : 0
                );
            }

            $this->log('links', null, 'atualizados', 'Links do site atualizados');
            Auth::flash('Links atualizados.');
        }

        $this->redirect('admin/links');
    }

    // ========================================================
    // Usuários / senha
    // ========================================================

    public function usuarios(): void
    {
        $this->guard();

        $this->adminView('admin/usuarios', [
            'title'        => 'Usuários — Painel',
            'pageTitle'    => 'Usuários',
            'pageSubtitle' => 'Acesso ao painel administrativo',
            'activeMenu'   => 'usuarios',
            'users'        => $this->model('AdminUser')->all(),
        ]);
    }

    public function senhaAlterar(): void
    {
        $this->guard();
        $this->requirePost();

        $userModel = $this->model('AdminUser');
        $user = Auth::user();

        $current = (string) ($_POST['current_password'] ?? '');
        $new = (string) ($_POST['new_password'] ?? '');
        $confirm = (string) ($_POST['confirm_password'] ?? '');

        if ($userModel->verifyPassword($user['email'], $current) === null) {
            Auth::flash('Senha atual incorreta.', 'error');
            $this->redirect('admin/usuarios');
        }

        if (strlen($new) < 6) {
            Auth::flash('A nova senha deve ter ao menos 6 caracteres.', 'error');
            $this->redirect('admin/usuarios');
        }

        if ($new !== $confirm) {
            Auth::flash('A confirmação não confere com a nova senha.', 'error');
            $this->redirect('admin/usuarios');
        }

        $userModel->updatePassword((int) $user['id'], $new);
        $this->log('usuario', (int) $user['id'], 'senha', 'Senha do painel alterada');
        Auth::flash('Senha alterada com sucesso.');
        $this->redirect('admin/usuarios');
    }

    public function perfilSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $name = trim((string) ($_POST['name'] ?? ''));
        $user = Auth::user();

        if ($name !== '') {
            $this->model('AdminUser')->updateName((int) $user['id'], $name);

            $user['name'] = $name;
            Auth::login($user);

            Auth::flash('Nome atualizado.');
        }

        $this->redirect('admin/usuarios');
    }

    // ========================================================
    // Configurações
    // ========================================================

    public function configuracoes(): void
    {
        $this->guard();

        $this->adminView('admin/configuracoes', [
            'title'        => 'Configurações — Painel',
            'pageTitle'    => 'Configurações',
            'pageSubtitle' => 'Informações gerais da loja',
            'activeMenu'   => 'configuracoes',
            'settings'     => $this->model('Setting')->map(),
        ]);
    }

    public function configuracoesSalvar(): void
    {
        $this->guard();
        $this->requirePost();

        $settingModel = $this->model('Setting');

        $keys = [
            'store_name',
            'store_tagline',
            'store_email',
            'store_whatsapp',
            'low_stock_threshold',
        ];

        foreach ($keys as $key) {
            $settingModel->set($key, trim((string) ($_POST[$key] ?? '')));
        }

        $this->log('configuracoes', null, 'atualizadas', 'Configurações atualizadas');
        Auth::flash('Configurações salvas.');
        $this->redirect('admin/configuracoes');
    }

    // ========================================================
    // Apoio
    // ========================================================

    private function guard(): void
    {
        if (!Auth::check()) {
            $this->redirect('admin/login');
        }
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin');
        }

        if (!Auth::csrfValid($_POST['csrf_token'] ?? null)) {
            Auth::flash('Sessão expirada. Faça login novamente.', 'error');
            $this->redirect('admin/login');
        }
    }

    private function log(string $entity, ?int $id, string $action, string $description): void
    {
        $this->model('ActivityLog')->record($entity, $id, $action, $description);
    }

    /**
     * Salva imagens e vídeos enviados no formulário de produto.
     */
    private function storeProductMedia(Product $productModel, int $productId): void
    {
        $order = $productModel->nextMediaOrder($productId);

        foreach ($this->normalizeFiles($_FILES['images'] ?? null) as $file) {
            $path = $this->storeUpload($file, 'produtos', self::IMAGE_TYPES);

            if ($path !== null) {
                $productModel->addMedia($productId, 'image', $path, $order++);
            }
        }

        foreach ($this->normalizeFiles($_FILES['videos'] ?? null) as $file) {
            $path = $this->storeUpload($file, 'produtos', self::VIDEO_TYPES);

            if ($path !== null) {
                $productModel->addMedia($productId, 'video', $path, $order++);
            }
        }
    }

    /**
     * Converte a estrutura de $_FILES para uma lista simples.
     */
    private function normalizeFiles($files): array
    {
        if (!is_array($files) || !isset($files['name'])) {
            return [];
        }

        if (!is_array($files['name'])) {
            return [$files];
        }

        $list = [];

        foreach ($files['name'] as $index => $name) {
            if ($files['error'][$index] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $list[] = [
                'name'     => $name,
                'type'     => $files['type'][$index],
                'tmp_name' => $files['tmp_name'][$index],
                'error'    => $files['error'][$index],
                'size'     => $files['size'][$index],
            ];
        }

        return $list;
    }

    /**
     * Move um arquivo enviado para public/uploads e devolve o caminho relativo.
     */
    private function storeUpload(array $file, string $folder, array $allowedMime): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] <= 0 || $file['size'] > self::MAX_UPLOAD_BYTES) {
            return null;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!in_array($mime, $allowedMime, true)) {
            return null;
        }

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            'video/mp4'  => 'mp4',
            'video/webm' => 'webm',
        ];

        $targetDir = PUBLIC_PATH . '/uploads/' . $folder;

        if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            return null;
        }

        $filename = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $extensions[$mime];

        if (!move_uploaded_file($file['tmp_name'], $targetDir . '/' . $filename)) {
            return null;
        }

        return 'uploads/' . $folder . '/' . $filename;
    }

    /**
     * Remove um arquivo enviado anteriormente (caminho relativo a /public).
     */
    private function removeUploadedFile(?string $relativePath): void
    {
        if ($relativePath === null || !str_starts_with($relativePath, 'uploads/')) {
            return;
        }

        $fullPath = PUBLIC_PATH . '/' . $relativePath;

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
