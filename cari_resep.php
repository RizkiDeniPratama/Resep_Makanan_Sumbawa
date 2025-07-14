<?php
// Halaman pencarian resep
// Menampilkan hasil pencarian berdasarkan keyword

// Include file koneksi database
require_once 'config/koneksi.php';

$pageTitle = "Cari Resep";
include 'includes/header.php';

// Ambil keyword pencarian dan kategori
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$kategoriId = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;
$hasSearch = !empty($keyword) || $kategoriId > 0;

// Konfigurasi pagination
$resepPerHalaman = 6;
$halamanSekarang = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halamanSekarang - 1) * $resepPerHalaman;

$resepList = [];
$totalResep = 0;
$totalHalaman = 0;

if ($hasSearch) {
    try {
        // Build query conditions
        $conditions = [];
        $params = [];
        
        if (!empty($keyword)) {
            $conditions[] = "(r.nama_resep LIKE :keyword OR r.deskripsi LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }
        
        if ($kategoriId > 0) {
            $conditions[] = "r.id_kategori = :kategori_id";
            $params[':kategori_id'] = $kategoriId;
        }
        
        $whereClause = implode(' AND ', $conditions);
        
        // Hitung total hasil pencarian
        $stmtTotal = $pdo->prepare("
            SELECT COUNT(*) as total 
            FROM resep r 
            WHERE $whereClause
        ");
        foreach ($params as $key => $value) {
            $stmtTotal->bindValue($key, $value);
        }
        $stmtTotal->execute();
        $totalResep = $stmtTotal->fetch()['total'];
        $totalHalaman = ceil($totalResep / $resepPerHalaman);
        
        // Query pencarian dengan pagination
        $orderBy = !empty($keyword) ? 
            "ORDER BY 
                CASE 
                    WHEN r.nama_resep LIKE :exact_keyword THEN 1
                    WHEN r.nama_resep LIKE :start_keyword THEN 2
                    ELSE 3
                END,
                r.created_at DESC" : 
            "ORDER BY r.created_at DESC";
            
        $stmt = $pdo->prepare("
            SELECT r.*, k.nama_kategori 
            FROM resep r 
            LEFT JOIN kategori k ON r.id_kategori = k.id_kategori 
            WHERE $whereClause
            $orderBy
            LIMIT :limit OFFSET :offset
        ");
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        if (!empty($keyword)) {
            $stmt->bindValue(':exact_keyword', $keyword);
            $stmt->bindValue(':start_keyword', $keyword . '%');
        }
        
        $stmt->bindValue(':limit', $resepPerHalaman, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $resepList = $stmt->fetchAll();
        
    } catch(PDOException $e) {
        $error = "Error dalam pencarian: " . $e->getMessage();
    }
}
?>

<div class="container">
    <!-- Header Pencarian -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 class="page-title">🔍 Cari Resep Sumbawa</h1>
        <p style="color: #666; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
            Temukan resep makanan tradisional Sumbawa favorit Anda dengan mudah
        </p>
    </div>
    
    <!-- Form Pencarian Utama -->
    <div style="max-width: 600px; margin: 0 auto 3rem;">
        <form action="/cari_resep.php" method="GET" style="display: flex; gap: 1rem; background: white; padding: 1rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <input 
                type="text" 
                name="keyword" 
                placeholder="Masukkan nama resep atau bahan..." 
                value="<?php echo escape($keyword); ?>"
                style="flex: 1; padding: 1rem; border: 2px solid #e9ecef; border-radius: 8px; font-size: 1rem; outline: none; transition: border-color 0.3s ease;"
                onfocus="this.style.borderColor='#3498db'"
                onblur="this.style.borderColor='#e9ecef'"
            >
            <select name="kategori" style="padding: 1rem; border: 2px solid #e9ecef; border-radius: 8px; font-size: 1rem; outline: none; min-width: 150px;">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategoriList as $kategori): ?>
                    <option value="<?php echo $kategori['id_kategori']; ?>" <?php echo $kategoriId == $kategori['id_kategori'] ? 'selected' : ''; ?>>
                        <?php echo escape($kategori['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button 
                type="submit" 
                style="padding: 1rem 2rem; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: bold; transition: background 0.3s ease;"
                onmouseover="this.style.background='#2980b9'"
                onmouseout="this.style.background='#3498db'"
            >
                🔍 Cari
            </button>
        </form>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-warning">
            <strong>Error:</strong> <?php echo escape($error); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($hasSearch): ?>
        <!-- Hasil Pencarian -->
        <div style="margin-bottom: 2rem;">
            <h2 style="color: #2c3e50; margin-bottom: 1rem;">
                📊 Hasil Pencarian untuk "<?php echo escape($keyword); ?>"
            </h2>
            <p style="color: #666;">
                Ditemukan <strong><?php echo $totalResep; ?></strong> resep yang sesuai dengan pencarian Anda
                <?php if ($totalHalaman > 1): ?>
                    (Halaman <?php echo $halamanSekarang; ?> dari <?php echo $totalHalaman; ?>)
                <?php endif; ?>
            </p>
        </div>
        
        <?php if (empty($resepList)): ?>
            <!-- Tidak Ada Hasil -->
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">😔</div>
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">Tidak Ada Resep Ditemukan</h3>
                <p style="color: #666; margin-bottom: 2rem;">
                    Maaf, tidak ada resep yang cocok dengan kata kunci "<strong><?php echo escape($keyword); ?></strong>".
                </p>
                
                <!-- Saran Pencarian -->
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                    <h4 style="color: #2c3e50; margin-bottom: 1rem;">💡 Tips Pencarian:</h4>
                    <ul style="text-align: left; color: #666; max-width: 400px; margin: 0 auto;">
                        <li>Coba gunakan kata kunci yang lebih umum</li>
                        <li>Periksa ejaan kata kunci</li>
                        <li>Gunakan nama bahan atau jenis masakan</li>
                        <li>Coba kata kunci seperti "sepat", "barongko", "singang"</li>
                    </ul>
                </div>
                
                <a href="/index.php" class="btn btn-primary">
                    🏠 Lihat Semua Resep
                </a>
            </div>
        <?php else: ?>
            <!-- Daftar Hasil Pencarian -->
            <div class="recipe-grid">
                <?php foreach ($resepList as $resep): ?>
                    <article class="recipe-card">
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
                                <a href="/detail_resep.php?id_resep=<?php echo $resep['id_resep']; ?>" style="text-decoration: none; color: inherit;">
                                    <?php 
                                    // Highlight keyword dalam nama resep
                                    $namaResep = $resep['nama_resep'];
                                    if (!empty($keyword)) {
                                        $namaResep = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<mark style="background: #f39c12; color: white; padding: 0.1rem 0.3rem; border-radius: 3px;">$1</mark>', $namaResep);
                                    }
                                    echo $namaResep;
                                    ?>
                                </a>
                            </h3>
                            
                            <p class="recipe-description">
                                <?php 
                                // Potong deskripsi dan highlight keyword
                                $deskripsi = $resep['deskripsi'];
                                if (strlen($deskripsi) > 150) {
                                    $deskripsi = substr($deskripsi, 0, 150) . '...';
                                }
                                
                                if (!empty($keyword)) {
                                    $deskripsi = preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<mark style="background: #f39c12; color: white; padding: 0.1rem 0.3rem; border-radius: 3px;">$1</mark>', $deskripsi);
                                }
                                echo $deskripsi;
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
                            
                            <!-- Tombol Lihat Detail -->
                            <a href="/detail_resep.php?id_resep=<?php echo $resep['id_resep']; ?>" class="btn btn-primary">
                                📖 Lihat Detail
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination untuk Hasil Pencarian -->
            <?php if ($totalHalaman > 1): ?>
                <nav class="pagination" aria-label="Navigasi halaman pencarian">
                    <?php
                    // Tombol Previous
                    if ($halamanSekarang > 1): ?>
                        <a href="?keyword=<?php echo urlencode($keyword); ?>&halaman=<?php echo $halamanSekarang - 1; ?>" aria-label="Halaman sebelumnya">
                            ← Sebelumnya
                        </a>
                    <?php endif; ?>
                    
                    <?php
                    // Nomor halaman
                    $startPage = max(1, $halamanSekarang - 2);
                    $endPage = min($totalHalaman, $halamanSekarang + 2);
                    
                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <?php if ($i == $halamanSekarang): ?>
                            <span class="current" aria-current="page"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?keyword=<?php echo urlencode($keyword); ?>&halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php
                    // Tombol Next
                    if ($halamanSekarang < $totalHalaman): ?>
                        <a href="?keyword=<?php echo urlencode($keyword); ?>&halaman=<?php echo $halamanSekarang + 1; ?>" aria-label="Halaman selanjutnya">
                            Selanjutnya →
                        </a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <!-- Halaman Awal Pencarian -->
        <div style="text-align: center;">
            <!-- Kategori Populer -->
            <section style="margin-bottom: 3rem;">
                <h2 style="color: #2c3e50; margin-bottom: 2rem;">🏷️ Kategori Populer</h2>
                <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <a href="?keyword=sepat" class="btn btn-secondary" style="background: #e74c3c;">
                        🐟 Sepat
                    </a>
                    <a href="?keyword=barongko" class="btn btn-secondary" style="background: #f39c12;">
                        🍰 Barongko
                    </a>
                    <a href="?keyword=singang" class="btn btn-secondary" style="background: #27ae60;">
                        🍲 Singang
                    </a>
                    <a href="?keyword=goreng" class="btn btn-secondary" style="background: #9b59b6;">
                        🥘 Goreng
                    </a>
                </div>
            </section>
            
            <!-- Pencarian Populer -->
            <section style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 3rem;">
                <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">🔥 Pencarian Populer</h3>
                <div style="display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap;">
                    <?php
                    $popularSearches = ['Sepat Khas Sumbawa', 'Barongko Pisang', 'Singang Ikan', 'Bongkabola', 'Manjareal', 'Pelu', 'Gecok'];
                    foreach ($popularSearches as $search): ?>
                        <a href="?keyword=<?php echo urlencode($search); ?>" 
                           style="background: #ecf0f1; color: #2c3e50; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease;"
                           onmouseover="this.style.background='#3498db'; this.style.color='white'"
                           onmouseout="this.style.background='#ecf0f1'; this.style.color='#2c3e50'">
                            <?php echo escape($search); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
            
            <!-- Tips Pencarian -->
            <section style="background: linear-gradient(135deg, #3498db, #2c3e50); color: white; padding: 2rem; border-radius: 10px;">
                <h3 style="margin-bottom: 1.5rem;">💡 Tips Pencarian Efektif</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; text-align: left;">
                    <div>
                        <h4 style="margin-bottom: 0.5rem;">🎯 Gunakan Kata Kunci Spesifik</h4>
                        <p style="opacity: 0.9; font-size: 0.9rem;">Coba "sepat ikan" atau "barongko pisang" untuk hasil yang lebih tepat</p>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 0.5rem;">🥘 Cari Berdasarkan Bahan</h4>
                        <p style="opacity: 0.9; font-size: 0.9rem;">Ketik nama bahan seperti "ikan", "pisang", atau "kelapa"</p>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 0.5rem;">⚡ Pencarian Cepat</h4>
                        <p style="opacity: 0.9; font-size: 0.9rem;">Gunakan shortcut Ctrl+K untuk langsung fokus ke kotak pencarian</p>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
