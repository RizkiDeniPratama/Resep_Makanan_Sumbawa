<?php
// Footer template untuk website Resep Sumbawa
// File ini berisi struktur footer yang akan digunakan di semua halaman
?>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?php echo date('Y'); ?> Resep Sumbawa. Melestarikan Kuliner Tradisional Nusantara.</p>
                <p>
                    Dibuat dengan ❤️ untuk melestarikan warisan kuliner Sumbawa | 
                    <a href="/tentang_kami.php" style="color: #f39c12;">Tim Pengembang</a>
                </p>
                <div class="footer-links" style="margin-top: 1rem;">
                    <small>
                        Website ini dibuat untuk tujuan edukasi dan pelestarian budaya kuliner tradisional Sumbawa.
                        Semua resep dikumpulkan dari berbagai sumber dan pengalaman masyarakat lokal.
                    </small>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="/assets/js/script.js"></script>
    
    <!-- Analytics (opsional - ganti dengan kode tracking yang sesuai) -->
    <script>
        // Google Analytics atau tracking lainnya bisa ditambahkan di sini
        console.log('Resep Sumbawa - Website loaded successfully');
        
        // Track page view
        if (typeof gtag !== 'undefined') {
            gtag('config', 'GA_MEASUREMENT_ID', {
                page_title: document.title,
                page_location: window.location.href
            });
        }
    </script>
    
    <!-- Schema.org structured data untuk recipe (jika di halaman detail) -->
    <?php if (isset($recipeData) && !empty($recipeData)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Recipe",
        "name": "<?php echo escape($recipeData['nama_resep']); ?>",
        "description": "<?php echo escape($recipeData['deskripsi']); ?>",
        "image": "<?php echo 'http://' . $_SERVER['HTTP_HOST'] . escape($recipeData['gambar']); ?>",
        "cookTime": "PT<?php echo $recipeData['waktu_memasak']; ?>M",
        "recipeYield": "<?php echo $recipeData['porsi']; ?> porsi",
        "recipeCategory": "Makanan Tradisional",
        "recipeCuisine": "Indonesian",
        "keywords": "resep sumbawa, makanan tradisional, <?php echo escape($recipeData['nama_resep']); ?>",
        "author": {
            "@type": "Organization",
            "name": "Resep Sumbawa"
        },
        "datePublished": "<?php echo date('c', strtotime($recipeData['created_at'])); ?>",
        "dateModified": "<?php echo date('c', strtotime($recipeData['updated_at'])); ?>"
    }
    </script>
    <?php endif; ?>
    
    <!-- PWA Manifest (opsional) -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Theme color untuk mobile browsers -->
    <meta name="theme-color" content="#2c3e50">
    <meta name="msapplication-TileColor" content="#2c3e50">
    
</body>
</html>
