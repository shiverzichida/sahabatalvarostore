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
$public_path = '/home/lint2571/public_html';

// 1. Tarik perubahan terbaru dari GitHub ke folder repository cPanel
$output_pull = shell_exec("cd $repo_path && git pull origin main 2>&1");
echo "=== GIT PULL ===\n";
echo htmlspecialchars($output_pull) . "\n";

// 2. Salin semua file dari repository ke public_html (sesuai instruksi cpanel.yml)
if (strpos($output_pull, 'Already up to date') === false || isset($_GET['force'])) {
    echo "=== COPYING FILES ===\n";
    $output_cp = shell_exec("cp -R $repo_path/* $public_path/ 2>&1");
    $output_htaccess = shell_exec("cp $repo_path/.htaccess $public_path/ 2>&1");
    
    echo "Files copied successfully.\n";
} else {
    echo "Tidak ada file baru untuk disalin (Sudah up-to-date).\n";
}

echo "\nDeployment Selesai!";
