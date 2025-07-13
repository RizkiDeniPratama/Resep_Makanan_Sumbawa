<?php
// Header template untuk website Resep Sumbawa
// File ini berisi struktur HTML head dan navigation yang akan digunakan di semua halaman

// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include file koneksi database
require_once __DIR__ . '/../config/koneksi.php';

// Fungsi untuk menentukan halaman aktif (untuk highlighting menu)
function isActivePage($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page ? 'active' : '';
}

// Ambil keyword pencarian jika ada
$searchKeyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// Ambil kategori untuk dropdown
try {
    $stmtKategori = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori");
    $kategoriList = $stmtKategori->fetchAll();
} catch(PDOException $e) {
    $kategoriList = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Kumpulan resep makanan tradisional khas Sumbawa. Temukan resep sepat, barongko, singang, dan masakan tradisional Sumbawa lainnya.">
    <meta name="keywords" content="resep sumbawa, makanan tradisional, sepat, barongko, singang, kuliner nusantara">
    <meta name="author" content="Tim Resep Sumbawa">
    
    <!-- Open Graph Meta Tags untuk social media -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? escape($pageTitle) . ' - ' : ''; ?>Resep Sumbawa">
    <meta property="og:description" content="Kumpulan resep makanan tradisional khas Sumbawa">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="/assets/images/logo-og.jpg">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($pageTitle) ? escape($pageTitle) . ' - ' : ''; ?>Resep Sumbawa">
    <meta name="twitter:description" content="Kumpulan resep makanan tradisional khas Sumbawa">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="/assets/css/style.css" as="style">
    <link rel="preload" href="/assets/js/script.js" as="script">
    
    <!-- Title -->
    <title><?php echo isset($pageTitle) ? escape($pageTitle) . ' - ' : ''; ?>Resep Sumbawa - Kuliner Tradisional Nusantara</title>
    
    <!-- Structured Data untuk SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Resep Sumbawa",
        "description": "Kumpulan resep makanan tradisional khas Sumbawa",
        "url": "<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/cari_resep.php?keyword={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
</head>
<body>
    <!-- Skip to main content untuk accessibility -->
    <a href="#main-content" class="sr-only">Skip to main content</a>
    
    <!-- Header -->
<header class="modern-header">
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- Logo di kiri -->
            <a href="/index.php" class="logo-modern">
                <div class="logo-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="18" fill="#f39c12" stroke="#fff" stroke-width="2"/>
                        <path d="M12 20c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8-8-3.6-8-8z" fill="#fff"/>
                        <circle cx="20" cy="20" r="3" fill="#f39c12"/>
                    </svg>
                </div>
                <span class="logo-text">Resep Sumbawa</span>
            </a>
            
            <!-- Navigation Menu dan Search di kanan -->
            <div class="nav-right">
                <ul class="nav-menu-modern">
                    <li><a href="/index.php" class="nav-link <?php echo isActivePage('index.php'); ?>">Beranda</a></li>
                    <li><a href="/cari_resep.php" class="nav-link <?php echo isActivePage('cari_resep.php'); ?>">Resep</a></li>
                    <li><a href="/tentang_kami.php" class="nav-link <?php echo isActivePage('tentang_kami.php'); ?>">Tentang</a></li>
                </ul>
                
                <!-- Search Form di Navigation -->
                <form class="nav-search-form" action="/cari_resep.php" method="GET">
                    <input 
                        type="text" 
                        name="keyword" 
                        placeholder="Cari resep..."
                        value="<?php echo escape($searchKeyword); ?>"
                        class="nav-search-input"
                    >
                    <button type="submit" class="nav-search-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="Toggle Mobile Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
    
    <!-- Hero Section (hanya tampil di halaman utama) -->
    <?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
    <section class="hero-section">
        <div class="hero-background">
            <!-- Background image akan ditambahkan via CSS -->
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    Lebih dari sekedar<br>
                    buku masak biasa
                </h1>
                <p class="hero-subtitle">
                    Pelajari cara membuat hidangan tradisional Sumbawa favorit Anda
                </p>
                
                <!-- Hero Search -->
                <div class="hero-search">
                    <form action="/cari_resep.php" method="GET" class="hero-search-form">
                        <div class="search-input-group">
                            <input 
                                type="text" 
                                name="keyword" 
                                placeholder="Saya ingin membuat..."
                                value="<?php echo escape($searchKeyword); ?>"
                                class="hero-search-input"
                            >
                            <select name="kategori" class="hero-search-select">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($kategoriList as $kategori): ?>
                                    <option value="<?php echo $kategori['id_kategori']; ?>">
                                        <?php echo escape($kategori['nama_kategori']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="hero-search-btn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</header>
    
    <!-- Main Content -->
    <main id="main-content">
