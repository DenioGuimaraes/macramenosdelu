<?php

/**
 * ============================================================
 * Seed inicial — Macramê Nós de Lu
 * ============================================================
 *
 * Executar a partir da raiz do projeto:
 *   D:\XAMPP\php\php.exe database/seed.php
 *
 * O script é idempotente: pode ser executado novamente sem
 * duplicar registros.
 * ============================================================
 */

require_once __DIR__ . '/../bootstrap.php';

$pdo = Database::connection();

echo "Semeando dados iniciais...\n";

// ------------------------------------------------------------
// Administrador
// ------------------------------------------------------------

$adminEmail = 'macramenosdelu@gmail.com';
$adminPassword = '123456';

$statement = $pdo->prepare('SELECT id FROM admin_users WHERE email = ? LIMIT 1');
$statement->execute([$adminEmail]);

if ($statement->fetchColumn() === false) {
    $insert = $pdo->prepare(
        'INSERT INTO admin_users (name, email, password_hash) VALUES (?, ?, ?)'
    );
    $insert->execute([
        'Luzia',
        $adminEmail,
        password_hash($adminPassword, PASSWORD_DEFAULT),
    ]);

    echo "  - Administrador criado ({$adminEmail}).\n";
} else {
    echo "  - Administrador já existente.\n";
}

// ------------------------------------------------------------
// Categorias
// ------------------------------------------------------------

$categories = ['Bolsas', 'Chinelos', 'Sandálias', 'Acessórios', 'Casa'];
$order = 1;

foreach ($categories as $name) {
    $slug = Model::slugify($name);

    $check = $pdo->prepare('SELECT id FROM categories WHERE slug = ? LIMIT 1');
    $check->execute([$slug]);

    if ($check->fetchColumn() === false) {
        $insert = $pdo->prepare(
            'INSERT INTO categories (name, slug, sort_order) VALUES (?, ?, ?)'
        );
        $insert->execute([$name, $slug, $order]);

        echo "  - Categoria criada: {$name}.\n";
    }

    $order++;
}

// ------------------------------------------------------------
// Links do site
// ------------------------------------------------------------

$links = [
    ['whatsapp', 'WhatsApp', 'https://wa.me/5521997175714', 'WhatsApp', 1],
    ['shopee', 'Shopee', 'http://localhost/macramenosdelu/public/index.php?url=contato#', 'Shopee', 2],
    ['email', 'E-mail', 'mailto:macramenosdelu@gmail.com', 'macramenosdelu@gmail.com', 3],
    ['instagram', 'Instagram', 'https://www.instagram.com/macramenosdelu', '@macramenosdelu', 4],
    ['tiktok', 'TikTok', 'https://www.tiktok.com/@macramenosdelu', '@macramenosdelu', 5],
];

foreach ($links as [$key, $label, $url, $display, $sortOrder]) {
    $check = $pdo->prepare('SELECT id FROM site_links WHERE link_key = ? LIMIT 1');
    $check->execute([$key]);

    if ($check->fetchColumn() === false) {
        $insert = $pdo->prepare(
            'INSERT INTO site_links (link_key, label, url, display, sort_order)
             VALUES (?, ?, ?, ?, ?)'
        );
        $insert->execute([$key, $label, $url, $display, $sortOrder]);

        echo "  - Link criado: {$label}.\n";
    }
}

// ------------------------------------------------------------
// Configurações padrão
// ------------------------------------------------------------

$settings = [
    'store_name'          => 'Macramê Nós de Lu',
    'store_tagline'       => 'Cada nó, uma história!',
    'store_email'         => 'macramenosdelu@gmail.com',
    'store_whatsapp'      => '5521997175714',
    'low_stock_threshold' => '3',
    'home_hero_title'     => 'Macramê Nós de Lu',
    'home_hero_subtitle'  => 'Cada nó, uma história — peças artesanais feitas à mão para trazer aconchego e personalidade ao seu lar.',
    'home_hero_cta'       => 'Conhecer a loja',
    'home_brand_bar'      => 'Inspiração em cada fio',
    'home_welcome'        => 'Bem-vindo ao nosso espaço dedicado à arte do macramê. Aqui você encontra peças pensadas para decorar, presentear e emocionar — sempre com o toque humano do trabalho manual.',
];

$insertSetting = $pdo->prepare(
    'INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
     ON DUPLICATE KEY UPDATE setting_value = setting_value'
);

foreach ($settings as $key => $value) {
    $insertSetting->execute([$key, $value]);
}

echo "  - Configurações padrão aplicadas.\n";
echo "\nConcluído.\n";
echo "Acesse: http://localhost/macramenosdelu/index.php?url=admin\n";
echo "E-mail: {$adminEmail} | Senha: {$adminPassword}\n";
