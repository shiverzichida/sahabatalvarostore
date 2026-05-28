<?php
/**
 * Auto-deployment script for Sahabat Alvaro Store
 * Triggers git pull and copies files to public_html automatically on GitHub push
 */

// Keamanan: Ganti token ini dengan token rahasia pilihan Anda jika diperlukan
$secret_token = 'sahabatalvaro_secure_deploy_2026';

// Validasi Token
if (!isset($_GET['token']) || $_GET['token'] !== $secret_token) {
    header('HTTP/1.1 403 Forbidden');
    die('Akses ditolak. Token tidak valid.');
}

echo "Memulai auto-deployment...\n\n";

// Path repository dan path public_html Anda
$repo_path = '/home/lint2571/repositories/sahabatalvarostore';
$public_path = '/home/lint2571/public_html/sahabatalvaro.store';

// 1. Tarik perubahan terbaru dari GitHub ke folder repository cPanel
$output_pull = '';
if (!isset($_GET['skip_pull'])) {
    $output_pull = shell_exec("cd $repo_path && git pull origin main 2>&1");
    echo "=== GIT PULL ===\n";
    echo htmlspecialchars($output_pull) . "\n";
} else {
    echo "=== GIT PULL SKIPPED ===\n";
    $output_pull = 'Already up to date'; // bypass file copy checks if pull is skipped
}

// 2. Salin semua file dari repository ke public_html (sesuai instruksi cpanel.yml)
if (strpos($output_pull, 'Already up to date') === false || isset($_GET['force']) || isset($_GET['clear_cache'])) {
    echo "=== COPYING FILES ===\n";
    $output_cp = shell_exec("cp -R $repo_path/* $public_path/ 2>&1");
    $output_htaccess = shell_exec("cp $repo_path/.htaccess $public_path/ 2>&1");
    
    echo "Files copied successfully.\n";

    // Clear Laravel Cache
    echo "=== CLEARING CACHE ===\n";
    $output_cache = shell_exec("php $public_path/artisan route:clear 2>&1");
    $output_cache .= shell_exec("php $public_path/artisan view:clear 2>&1");
    $output_cache .= shell_exec("php $public_path/artisan config:clear 2>&1");
    $output_cache .= shell_exec("php $public_path/artisan cache:clear 2>&1");
    echo htmlspecialchars($output_cache) . "\n";
} else {
    echo "Tidak ada file baru untuk disalin (Sudah up-to-date).\n";
    if (isset($_GET['clear_cache']) || isset($_GET['migrate'])) {
        echo "=== CLEARING CACHE ===\n";
        $output_cache = shell_exec("php $public_path/artisan route:clear 2>&1");
        $output_cache .= shell_exec("php $public_path/artisan view:clear 2>&1");
        $output_cache .= shell_exec("php $public_path/artisan config:clear 2>&1");
        $output_cache .= shell_exec("php $public_path/artisan cache:clear 2>&1");
        echo htmlspecialchars($output_cache) . "\n";
    }
}

// 3. Jalankan Migrasi Database jika ada parameter &migrate=1
if (isset($_GET['migrate'])) {
    echo "=== RUNNING DATABASE MIGRATIONS ===\n";
    $output_migrate = shell_exec("php $public_path/artisan migrate --force 2>&1");
    echo htmlspecialchars($output_migrate) . "\n";
}

echo "\nDeployment Selesai!";
