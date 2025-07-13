<?php
// Halaman detail resep
// Menampilkan informasi lengkap tentang satu resep

// Include file koneksi database
require_once 'config/koneksi.php';

// Ambil ID resep dari URL
$idResep = isset($_GET['id_resep']) ? (int)$_GET['id_resep'] : 0;

if ($idResep <= 0) {
    header('Location: /index.php');
    exit;
}

try {
    // Query untuk mengambil detail resep
    $stmt = $pdo->prepare("
        SELECT r.*, k.nama_kategori, p.nama as nama_penulis
        FROM resep r 
        LEFT JOIN kategori k ON r.id_kategori = k.id_kategori 
        LEFT JOIN pengguna p ON r.id_pengguna = p.id_pengguna
        WHERE r.id_resep = :id_resep
    ");
    $stmt->bindParam(':id_resep', $idResep, PDO::PARAM_INT);
    $stmt->execute();
    $resep = $stmt->fetch();
    
    if (!$resep) {
        header('Location: /index.php');
        exit;
    }
    
    // Query untuk mengambil bahan-bahan
    $stmtBahan = $pdo->prepare("
        SELECT rb.*, b.nama_bahan 
        FROM resep_bahan rb 
        JOIN bahan b ON rb.id_bahan = b.id_bahan 
        WHERE rb.id_resep = :id_resep 
        ORDER BY rb.urutan ASC, rb.kelompok ASC
    ");
    $stmtBahan->bindParam(':id_resep', $idResep, PDO::PARAM_INT);
    $stmtBahan->execute();
    $bahanList = $stmtBahan->fetchAll();
    
    // Kelompokkan bahan berdasarkan kelompok
    $bahanByGroup = [];
    foreach ($bahanList as $bahan) {
        $kelompok = $bahan['kelompok'] ?: 'Bahan Utama';
        $bahanByGroup[$kelompok][] = $bahan;
    }
    
    // Query untuk mengambil langkah memasak
    $stmtLangkah = $pdo->prepare("
        SELECT * FROM langkah_memasak 
        WHERE id_resep = :id_resep 
        ORDER BY nomor_urutan ASC
    ");
    $stmtLangkah->bindParam(':id_resep', $idResep, PDO::PARAM_INT);
    $stmtLangkah->execute();
    $langkahList = $stmtLangkah->fetchAll();
    
    // Set data untuk structured data di footer
    $recipeData = $resep;
    
} catch(PDOException $e) {
    $error = "Error mengambil detail resep: " . $e->getMessage();
}

$pageTitle = isset($resep) ? $resep['nama_resep'] : 'Resep Tidak Ditemukan';
include 'includes/header.php';
?>

<div class="container">
    <?php if (isset($error)): ?>
        <div class="alert alert-warning">
            <strong>Error:</strong> <?php echo escape($error); ?>
        </div>
        <div style="text-align: center; margin: 2rem 0;">
            <a href="/index.php" class="btn btn-primary">← Kembali ke Beranda</a>
        </div>
    <?php elseif (!isset($resep)): ?>
        <div class="alert alert-warning">
            <h3>Resep Tidak Ditemukan</h3>
            <p>Maaf, resep yang Anda cari tidak ditemukan atau telah dihapus.</p>
        </div>
        <div style="text-align: center; margin: 2rem 0;">
            <a href="/index.php" class="btn btn-primary">← Kembali ke Beranda</a>
        </div>
    <?php else: ?>
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" style="margin-bottom: 2rem;">
            <ol style="display: flex; list-style: none; padding: 0; background: #f8f9fa; padding: 1rem; border-radius: 5px; font-size: 0.9rem;">
                <li><a href="/index.php" style="color: #3498db; text-decoration: none;">🏠 Beranda</a></li>
                <li style="margin: 0 0.5rem; color: #666;">></li>
                <li style="color: #666;"><?php echo escape($resep['nama_resep']); ?></li>
            </ol>
        </nav>

        <!-- Detail Resep - Clean Design -->
        <article class="recipe-detail-clean">
            <!-- Gambar Resep -->
            <?php if (!empty($resep['gambar']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $resep['gambar'])): ?>
                <img 
                    src="<?php echo escape($resep['gambar']); ?>" 
                    alt="<?php echo escape($resep['nama_resep']); ?>"
                    class="recipe-detail-image-clean"
                >
            <?php else: ?>
                <img 
                    src="/placeholder.svg?height=400&width=800&text=<?php echo urlencode($resep['nama_resep']); ?>" 
                    alt="<?php echo escape($resep['nama_resep']); ?>"
                    class="recipe-detail-image-clean"
                >
            <?php endif; ?>
            
            <!-- Konten Detail -->
            <div class="recipe-detail-content">
                <!-- Judul Resep -->
                <h1 class="recipe-title-clean"><?php echo escape($resep['nama_resep']); ?></h1>
                
                <!-- Deskripsi -->
                <p class="recipe-description-clean">
                    <?php echo nl2br(escape($resep['deskripsi'])); ?>
                </p>
                
                <!-- Bahan-bahan dengan Checkbox -->
                <div class="recipe-section-clean">
                    <h2 class="section-title-clean">Bahan-Bahan</h2>
                    
                    <?php if (empty($bahanByGroup)): ?>
                        <p style="color: #666; font-style: italic;">Belum ada bahan yang tercatat untuk resep ini.</p>
                    <?php else: ?>
                        <?php foreach ($bahanByGroup as $kelompok => $bahanGroup): ?>
                            <?php if (count($bahanByGroup) > 1): ?>
                                <h3 style="color: #f39c12; font-size: 1.1rem; margin: 1.5rem 0 1rem 0; font-weight: 600;">
                                    <?php echo escape($kelompok); ?>
                                </h3>
                            <?php endif; ?>
                            
                            <ul class="ingredients-list-clean">
                                <?php foreach ($bahanGroup as $bahan): ?>
                                    <li class="ingredient-item-clean">
                                        <input type="checkbox" class="ingredient-checkbox" id="ingredient-<?php echo $bahan['id_resep_bahan']; ?>">
                                        <label for="ingredient-<?php echo $bahan['id_resep_bahan']; ?>" class="ingredient-text">
                                            <span class="ingredient-amount"><?php echo escape($bahan['takaran']); ?></span> 
                                            <?php echo escape($bahan['nama_bahan']); ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Cara Masak dengan Checkbox -->
                <div class="recipe-section-clean">
                    <h2 class="section-title-clean">Cara Masak</h2>
                    
                    <?php if (empty($langkahList)): ?>
                        <p style="color: #666; font-style: italic;">Belum ada langkah memasak yang tercatat untuk resep ini.</p>
                    <?php else: ?>
                        <ol class="steps-list-clean">
                            <?php foreach ($langkahList as $langkah): ?>
                                <li class="step-item-clean">
                                    <input type="checkbox" class="step-checkbox" id="step-<?php echo $langkah['id_langkah']; ?>">
                                    <div class="step-content">
                                        <div class="step-number">Langkah <?php echo $langkah['nomor_urutan']; ?></div>
                                        <div class="step-text">
                                            <?php echo nl2br(escape($langkah['deskripsi_langkah'])); ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="recipe-actions-clean">
                <button onclick="window.print()" class="action-btn-clean">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6,9 6,2 18,2 18,9"></polyline>
                        <path d="M6,18H4a2,2,0,0,1-2-2V11a2,2,0,0,1,2-2H20a2,2,0,0,1,2,2v5a2,2,0,0,1-2,2H18"></path>
                        <polyline points="6,14 18,14 18,22 6,22 6,14"></polyline>
                    </svg>
                    Cetak Resep
                </button>
                
                <button onclick="ResepSumbawa.copyToClipboard(window.location.href)" class="action-btn-clean">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    Salin Link
                </button>
            </div>
        </article>
        
        <!-- Navigation -->
        <div style="display: flex; justify-content: space-between; margin: 3rem 0; flex-wrap: wrap; gap: 1rem;">
            <a href="/index.php" class="btn btn-secondary">
                ← Kembali ke Beranda
            </a>
            <a href="/cari_resep.php" class="btn btn-primary">
                🔍 Cari Resep Lain
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
// Add functionality for checkboxes
document.addEventListener('DOMContentLoaded', function() {
    // Ingredient checkboxes
    const ingredientCheckboxes = document.querySelectorAll('.ingredient-checkbox');
    ingredientCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.checked) {
                label.style.textDecoration = 'line-through';
                label.style.opacity = '0.6';
            } else {
                label.style.textDecoration = 'none';
                label.style.opacity = '1';
            }
        });
    });
    
    // Step checkboxes
    const stepCheckboxes = document.querySelectorAll('.step-checkbox');
    stepCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const stepContent = this.nextElementSibling;
            if (this.checked) {
                stepContent.style.opacity = '0.6';
                stepContent.style.textDecoration = 'line-through';
            } else {
                stepContent.style.opacity = '1';
                stepContent.style.textDecoration = 'none';
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
