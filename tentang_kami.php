<?php
// Halaman tentang kami
// Menampilkan informasi tentang tim pengembang website

$pageTitle = "Tentang Kami";
include 'includes/header.php';
?>

<div class="container">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 class="page-title">👥 Tentang Kami</h1>
        <p style="color: #666; font-size: 1.2rem; max-width: 800px; margin: 0 auto;">
            Tim yang berdedikasi untuk melestarikan dan membagikan kekayaan kuliner tradisional Sumbawa
        </p>
    </div>
    
    <!-- Konten Utama -->
    <div class="about-content">
        <!-- Visi Misi -->
        <section style="margin-bottom: 3rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div style="background: linear-gradient(135deg, #3498db, #2c3e50); color: white; padding: 2rem; border-radius: 10px;">
                    <h2 style="margin-bottom: 1rem; font-size: 1.8rem;">🎯 Visi Kami</h2>
                    <p style="line-height: 1.8; opacity: 0.95;">
                        Menjadi platform digital terdepan dalam pelestarian dan penyebaran resep makanan tradisional Sumbawa, 
                        sehingga warisan kuliner nusantara dapat terus hidup dan berkembang di era modern.
                    </p>
                </div>
                
                <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 2rem; border-radius: 10px;">
                    <h2 style="margin-bottom: 1rem; font-size: 1.8rem;">🚀 Misi Kami</h2>
                    <ul style="line-height: 1.8; opacity: 0.95; list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">✨ Mengumpulkan dan mendokumentasikan resep autentik Sumbawa</li>
                        <li style="margin-bottom: 0.5rem;">📚 Menyediakan panduan memasak yang mudah dipahami</li>
                        <li style="margin-bottom: 0.5rem;">🌍 Memperkenalkan kuliner Sumbawa ke dunia</li>
                        <li>❤️ Melestarikan warisan budaya untuk generasi mendatang</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <!-- Cerita Kami -->
        <section style="margin-bottom: 3rem; background: #f8f9fa; padding: 2rem; border-radius: 10px; border-left: 5px solid #f39c12;">
            <h2 style="color: #2c3e50; margin-bottom: 1.5rem; font-size: 2rem;">📖 Cerita Kami</h2>
            <div style="line-height: 1.8; color: #555;">
                <p style="margin-bottom: 1.5rem;">
                    <strong>Resep Sumbawa</strong> lahir dari keprihatinan kami melihat semakin pudarnya pengetahuan tentang 
                    masakan tradisional Sumbawa di kalangan generasi muda. Banyak resep turun-temurun yang hanya tersimpan 
                    dalam ingatan para ibu dan nenek, tanpa dokumentasi yang proper.
                </p>
                
                <p style="margin-bottom: 1.5rem;">
                    Berawal dari diskusi sederhana di warung kopi, kami menyadari betapa pentingnya melestarikan warisan 
                    kuliner ini dalam format digital yang mudah diakses. Dengan semangat gotong royong yang khas Indonesia, 
                    kami mulai mengumpulkan resep-resep dari berbagai sumber: ibu-ibu di pasar tradisional, chef lokal, 
                    dan dokumentasi keluarga.
                </p>
                
                <p style="margin-bottom: 1.5rem;">
                    Setiap resep yang kami publikasikan telah melalui proses verifikasi dan uji coba untuk memastikan 
                    keaslian dan kelezatannya. Kami percaya bahwa makanan bukan hanya soal rasa, tetapi juga tentang 
                    cerita, tradisi, dan identitas budaya yang harus dijaga.
                </p>
                
                <p>
                    Melalui website ini, kami berharap dapat menjadi jembatan antara tradisi dan modernitas, 
                    memungkinkan siapa saja untuk belajar dan menikmati kekayaan kuliner Sumbawa, di mana pun mereka berada.
                </p>
            </div>
        </section>
        
        <!-- Tim Pengembang -->
        <section style="margin-bottom: 3rem;">
            <h2 style="color: #2c3e50; margin-bottom: 2rem; text-align: center; font-size: 2rem;">👨‍💻 Tim Pengembang</h2>
            
            <div class="team-grid">
                <div class="team-member">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #3498db, #2c3e50); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white;">
                        👨‍💻
                    </div>
                    <h3 class="member-name">Ahmad Fauzi</h3>
                    <p class="member-role">Lead Developer & Project Manager</p>
                    <p style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                        Bertanggung jawab atas pengembangan website dan koordinasi tim. 
                        Passionate tentang teknologi dan pelestarian budaya.
                    </p>
                </div>
                
                <div class="team-member">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #e74c3c, #c0392b); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white;">
                        👩‍🍳
                    </div>
                    <h3 class="member-name">Siti Nurhaliza</h3>
                    <p class="member-role">Culinary Researcher & Content Creator</p>
                    <p style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                        Ahli kuliner yang bertugas mengumpulkan dan memverifikasi resep-resep tradisional. 
                        Lulusan Tata Boga dengan pengalaman 10+ tahun.
                    </p>
                </div>
                
                <div class="team-member">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f39c12, #e67e22); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white;">
                        🎨
                    </div>
                    <h3 class="member-name">Budi Santoso</h3>
                    <p class="member-role">UI/UX Designer & Photographer</p>
                    <p style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                        Mendesain tampilan website dan mengambil foto makanan. 
                        Memastikan pengalaman pengguna yang optimal dan visual yang menarik.
                    </p>
                </div>
                
                <div class="team-member">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #27ae60, #229954); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white;">
                        📝
                    </div>
                    <h3 class="member-name">Maya Sari</h3>
                    <p class="member-role">Content Writer & Cultural Researcher</p>
                    <p style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                        Menulis deskripsi resep dan meneliti latar belakang budaya setiap masakan. 
                        Lulusan Antropologi dengan fokus pada budaya kuliner.
                    </p>
                </div>
            </div>
        </section>
        
        <!-- Teknologi yang Digunakan -->
        <section style="margin-bottom: 3rem; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h2 style="color: #2c3e50; margin-bottom: 1.5rem; text-align: center;">⚙️ Teknologi yang Digunakan</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; text-align: center;">
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🐘</div>
                    <h4 style="color: #2c3e50; margin-bottom: 0.5rem;">PHP Native</h4>
                    <p style="color: #666; font-size: 0.9rem;">Backend development tanpa framework untuk performa optimal</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🗄️</div>
                    <h4 style="color: #2c3e50; margin-bottom: 0.5rem;">MySQL</h4>
                    <p style="color: #666; font-size: 0.9rem;">Database management system untuk menyimpan data resep</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎨</div>
                    <h4 style="color: #2c3e50; margin-bottom: 0.5rem;">CSS3</h4>
                    <p style="color: #666; font-size: 0.9rem;">Styling modern dengan responsive design</p>
                </div>
                
                <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">⚡</div>
                    <h4 style="color: #2c3e50; margin-bottom: 0.5rem;">JavaScript</h4>
                    <p style="color: #666; font-size: 0.9rem;">Interaktivitas dan user experience yang smooth</p>
                </div>
            </div>
            
            <div style="margin-top: 2rem; padding: 1.5rem; background: linear-gradient(135deg, #9b59b6, #8e44ad); color: white; border-radius: 8px; text-align: center;">
                <h4 style="margin-bottom: 1rem;">🚀 Mengapa Tanpa Framework?</h4>
                <p style="opacity: 0.95; line-height: 1.6;">
                    Kami memilih menggunakan teknologi native untuk memastikan website dapat berjalan di berbagai hosting 
                    dengan konfigurasi minimal, sehingga lebih mudah diakses dan dipelihara dalam jangka panjang.
                </p>
            </div>
        </section>
        
        <!-- Kontribusi -->
        <section style="background: linear-gradient(135deg, #2c3e50, #34495e); color: white; padding: 2rem; border-radius: 10px; text-align: center;">
            <h2 style="margin-bottom: 1.5rem; font-size: 2rem;">🤝 Bergabung dengan Kami</h2>
            <p style="margin-bottom: 2rem; opacity: 0.95; line-height: 1.8; max-width: 600px; margin-left: auto; margin-right: auto;">
                Kami selalu terbuka untuk kolaborasi! Jika Anda memiliki resep tradisional Sumbawa yang ingin dibagikan, 
                atau ingin berkontribusi dalam pengembangan website ini, jangan ragu untuk menghubungi kami.
            </p>
            
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; min-width: 200px;">
                    <h4 style="margin-bottom: 0.5rem;">📧 Email</h4>
                    <p style="opacity: 0.9;">info@resepsumbawa.com</p>
                </div>
                
                <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; min-width: 200px;">
                    <h4 style="margin-bottom: 0.5rem;">📱 WhatsApp</h4>
                    <p style="opacity: 0.9;">+62 812-3456-7890</p>
                </div>
                
                <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 8px; min-width: 200px;">
                    <h4 style="margin-bottom: 0.5rem;">📍 Lokasi</h4>
                    <p style="opacity: 0.9;">Sumbawa Besar, NTB</p>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
