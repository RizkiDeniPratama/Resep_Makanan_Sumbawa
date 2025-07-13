<?php
// Halaman utama website Resep Sumbawa
// Menampilkan daftar resep dengan pagination

$pageTitle = "Beranda";
include 'includes/header.php';

// Konfigurasi pagination
$resepPerHalaman = 6; // Sesuai permintaan: 4 resep per halaman
$halamanSekarang = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halamanSekarang - 1) * $resepPerHalaman;

try {
    // Hitung total resep untuk pagination
    $stmtTotal = $pdo->query("SELECT COUNT(*) as total FROM resep");
    $totalResep = $stmtTotal->fetch()['total'];
    $totalHalaman = ceil($totalResep / $resepPerHalaman);
    
    // Query untuk mengambil resep dengan pagination
    $stmt = $pdo->prepare("
        SELECT r.*, k.nama_kategori 
        FROM resep r 
        LEFT JOIN kategori k ON r.id_kategori = k.id_kategori 
        ORDER BY r.created_at DESC 
        LIMIT :limit OFFSET :offset
    ");
    
    $stmt->bindValue(':limit', $resepPerHalaman, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $resepList = $stmt->fetchAll();
    
} catch(PDOException $e) {
    $error = "Error mengambil data resep: " . $e->getMessage();
}
?>

<div class="container">
    <!-- Hero Section -->
    <section class="hero-section" style="text-align: center; padding: 3rem 0; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px; margin-bottom: 3rem;">
        <h1 class="page-title" style="margin-bottom: 1rem; color: #2c3e50;">
            🍽️ Resep Sumbawa
        </h1>
        <p style="font-size: 1.2rem; color: #666; max-width: 600px; margin: 0 auto 2rem;">
            Jelajahi kekayaan kuliner tradisional Sumbawa. Dari sepat yang menyegarkan hingga barongko yang manis, 
            temukan cita rasa autentik Nusantara di sini.
        </p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <span style="background: #3498db; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                📊 <?php echo $totalResep; ?> Resep Tersedia
            </span>
            <span style="background: #27ae60; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                🏝️ Kuliner Sumbawa Asli
            </span>
            <span style="background: #f39c12; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                👨‍🍳 Resep Tradisional
            </span>
        </div>
    </section>

    <?php if (isset($error)): ?>
        <div class="alert alert-warning">
            <strong>Peringatan:</strong> <?php echo escape($error); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($resepList)): ?>
        <div class="alert alert-info">
            <h3>Belum Ada Resep</h3>
            <p>Saat ini belum ada resep yang tersedia. Silakan kembali lagi nanti.</p>
        </div>
    <?php else: ?>
        <!-- Daftar Resep -->
        <section class="recipes-section">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #2c3e50; font-size: 2rem;">
                🍳 Koleksi Resep Terbaru
            </h2>
            
            <div class="recipe-grid">
                <?php foreach ($resepList as $resep): ?>
                    <a href="/detail_resep.php?id_resep=<?php echo $resep['id_resep']; ?>" class="recipe-card">
                        <!-- Gambar Resep -->
                        <div class="recipe-image-container">
                            <?php if (!empty($resep['gambar']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $resep['gambar'])): ?>
                                <img 
                                    src="<?php echo escape($resep['gambar']); ?>" 
                                    alt="<?php echo escape($resep['nama_resep']); ?>"
                                    class="recipe-image"
                                    loading="lazy"
                                    onerror="this.src='/placeholder.svg?height=200&width=300&text=No+Image'"
                                >
                            <?php else: ?>
                                <img 
                                    src="/placeholder.svg?height=200&width=300&text=<?php echo urlencode($resep['nama_resep']); ?>" 
                                    alt="<?php echo escape($resep['nama_resep']); ?>"
                                    class="recipe-image"
                                    loading="lazy"
                                >
                            <?php endif; ?>
                            
                            <!-- Badge Kategori -->
                            <?php if (!empty($resep['nama_kategori'])): ?>
                                <div style="position: absolute; top: 10px; left: 10px; background: rgba(52, 152, 219, 0.9); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem;">
                                    <?php echo escape($resep['nama_kategori']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Konten Resep -->
                        <div class="recipe-content">
                            <h3 class="recipe-title">
                                <?php echo escape($resep['nama_resep']); ?>
                            </h3>
                            
                            <p class="recipe-description">
                                <?php 
                                // Potong deskripsi jika terlalu panjang
                                $deskripsi = $resep['deskripsi'];
                                if (strlen($deskripsi) > 150) {
                                    $deskripsi = substr($deskripsi, 0, 150) . '...';
                                }
                                echo escape($deskripsi); 
                                ?>
                            </p>
                            
                            <!-- Meta Information -->
                            <div class="recipe-meta">
                                <span title="Waktu Memasak">
                                    ⏱️ <?php echo $resep['waktu_memasak'] ? formatWaktu($resep['waktu_memasak']) : 'Tidak diketahui'; ?>
                                </span>
                                <span title="Porsi">
                                    👥 <?php echo $resep['porsi']; ?> porsi
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Pagination -->
        <?php if ($totalHalaman > 1): ?>
            <nav class="pagination" aria-label="Navigasi halaman">
                <?php
                // Tombol Previous
                if ($halamanSekarang > 1): ?>
                    <a href="?halaman=<?php echo $halamanSekarang - 1; ?>" aria-label="Halaman sebelumnya">
                        ← Sebelumnya
                    </a>
                <?php endif; ?>
                
                <?php
                // Nomor halaman
                $startPage = max(1, $halamanSekarang - 2);
                $endPage = min($totalHalaman, $halamanSekarang + 2);
                
                // Tampilkan halaman pertama jika tidak termasuk dalam range
                if ($startPage > 1): ?>
                    <a href="?halaman=1">1</a>
                    <?php if ($startPage > 2): ?>
                        <span>...</span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php if ($i == $halamanSekarang): ?>
                        <span class="current" aria-current="page"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php
                // Tampilkan halaman terakhir jika tidak termasuk dalam range
                if ($endPage < $totalHalaman): ?>
                    <?php if ($endPage < $totalHalaman - 1): ?>
                        <span>...</span>
                    <?php endif; ?>
                    <a href="?halaman=<?php echo $totalHalaman; ?>"><?php echo $totalHalaman; ?></a>
                <?php endif; ?>
                
                <?php
                // Tombol Next
                if ($halamanSekarang < $totalHalaman): ?>
                    <a href="?halaman=<?php echo $halamanSekarang + 1; ?>" aria-label="Halaman selanjutnya">
                        Selanjutnya →
                    </a>
                <?php endif; ?>
            </nav>
            
            <!-- Info Pagination -->
            <div style="text-align: center; margin-top: 1rem; color: #666; font-size: 0.9rem;">
                Menampilkan halaman <?php echo $halamanSekarang; ?> dari <?php echo $totalHalaman; ?> 
                (<?php echo $totalResep; ?> total resep)
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- Call to Action Section -->
    <!-- <section style="background: linear-gradient(135deg, #3498db, #2c3e50); color: white; padding: 3rem 2rem; border-radius: 15px; margin: 3rem 0; text-align: center;">
        <h2 style="margin-bottom: 1rem; font-size: 2rem;">🔍 Cari Resep Favorit Anda</h2>
        <p style="margin-bottom: 2rem; font-size: 1.1rem; opacity: 0.9;">
            Tidak menemukan resep yang Anda cari? Gunakan fitur pencarian untuk menemukan resep spesifik.
        </p>
        <a href="/cari_resep.php" class="btn" style="background: #f39c12; color: white; font-size: 1.1rem; padding: 1rem 2rem;">
            🔍 Mulai Pencarian
        </a>
    </section> -->
</div>

<!-- Schema.org structured data untuk homepage -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Resep Sumbawa",
    "description": "Kumpulan resep makanan tradisional khas Sumbawa",
    "url": "<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>",
    "mainEntity": {
        "@type": "ItemList",
        "numberOfItems": <?php echo $totalResep; ?>,
        "itemListElement": [
            <?php foreach ($resepList as $index => $resep): ?>
            {
                "@type": "Recipe",
                "position": <?php echo $index + 1; ?>,
                "name": "<?php echo escape($resep['nama_resep']); ?>",
                "url": "<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/detail_resep.php?id_resep=<?php echo $resep['id_resep']; ?>"
            }<?php echo $index < count($resepList) - 1 ? ',' : ''; ?>
            <?php endforeach; ?>
        ]
    }
}
</script>

<?php include 'includes/footer.php'; ?>
