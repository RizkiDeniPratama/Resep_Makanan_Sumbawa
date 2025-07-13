CREATE TABLE pengguna (
    id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin') DEFAULT 'admin'
);

CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

CREATE TABLE resep (
    id_resep INT AUTO_INCREMENT PRIMARY KEY,
    nama_resep VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    waktu_memasak INT,
    porsi INT DEFAULT 2,
    gambar VARCHAR(255),
    id_kategori INT,
    id_pengguna INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori),
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna)
);

CREATE TABLE bahan (
    id_bahan INT AUTO_INCREMENT PRIMARY KEY,
    nama_bahan VARCHAR(100) NOT NULL
);

CREATE TABLE resep_bahan (
    id_resep_bahan INT AUTO_INCREMENT PRIMARY KEY,
    id_resep INT,
    id_bahan INT,
    takaran VARCHAR(100) NOT NULL,
    kelompok VARCHAR(100),
    urutan INT DEFAULT NULL,
    FOREIGN KEY (id_resep) REFERENCES resep(id_resep),
    FOREIGN KEY (id_bahan) REFERENCES bahan(id_bahan)
);

CREATE TABLE langkah_memasak (
    id_langkah INT AUTO_INCREMENT PRIMARY KEY,
    id_resep INT,
    nomor_urutan INT NOT NULL,
    deskripsi_langkah TEXT NOT NULL,
    FOREIGN KEY (id_resep) REFERENCES resep(id_resep)
);

-- Data Pengguna
INSERT INTO pengguna (nama, email, password, role) VALUES
('Admin Utama', 'admin@sumbawa.com', '$2y$10$gKmZkufbaryKgVz2HVtbau/VP9Bk7zlvfYFJ8z3cHgfH62DtQSfLm', 'admin');

-- Data Kategori
INSERT INTO kategori (nama_kategori) VALUES
('Hidangan Utama'),
('Sayuran'),
('Jajanan');

-- Data Bahan (Total 69)
INSERT INTO bahan (nama_bahan) VALUES
('Terong lalap'),
('Terong ungu'),
('Ikan favorit kalian'),
('Bawang putih'),
('Ketumbar bubuk'),
('Lada bubuk'),
('Garam'),
('Bawang merah'),
('Cabai rawit'),
('Kemiri'),
('Tomat'),
('Belimbing wuluh'),
('Jeruk purut'),
('Daun ruku'),
('Micin'),
('Beras ketan hitam'),
('Air'),
('Kelapa setengah tua'),
('Pisang kepok'),
('Telur'),
('Kacang tanah sangrai'),
('Gula pasir'),
('Santan kental'),
('Vanili'),
('Kerupuk kulit'),
('Tulang iga sapi'),
('Nangka muda'),
('Serbuk koya'),
('Kaldu bubuk sapi'),
('Minyak goreng'),
('Jahe'),
('Laos'),
('Jintan'),
('Kapulaga'),
('Cengkeh'),
('Bunga duri'),
('Pala'),
('Bunga lawang'),
('Kayu manis'),
('Daun salam'),
('Kunyit'),
('Sereh'),
('Ayam kampung'),
('Asam jawa'),
('Jeruk nipis'),
('Ikan kakap merah'),
('Cabai merah keriting'),
('Penyedap'),
('Daging sapi'),
('Jeroan'),
('Hati sapi'),
('Wijen hitam'),
('Daun jeruk purut'),
('Kacang panjang'),
('Daun pepaya'),
('Kelapa parut'),
('Cabai keriting'),
('Ikan tongkol'),
('Cabai hijau besar'),
('Kaldu jamur'),
('Wortel'),
('Saledri'),
('Daun bawang pree'),
('Udang'),
('Daun pisang'),
('Daun lontar kering'),
('Mie kuda/mie konde');

-- Data Resep
INSERT INTO resep (nama_resep, deskripsi, waktu_memasak, porsi, gambar, id_kategori, id_pengguna) VALUES
('Sepat Khas Sumbawa Barat', 'Sepat adalah kuliner khas Sumbawa yang terbuat dari ikan bakar, baik ikan air tawar maupun ikan laut yang diberi kuah asam dan bumbu khas. Kuah asam ini biasanya berasal dari belimbing wuluh atau jeruk purut yang memberikan rasa unik pada sepat. Biasanya, kuliner khas Sumbawa ini disajikan dengan nasi, sambal tomat, dan irisan mentimun. Sepat juga menjadi hidangan favorit, terutama saat bulan Ramadan.', 45, 2, '/assets/images/sepat.webp', 1, 1),
('Bongkabola Ketan Hitam', 'Nasi yang berbahan dasar beras ketan yang di masak dengan cara di aron,lalu di kukus dan setelah matang di campur dengan kelapa parut mentah yang di beri sedikit garam. Sederhana memang namun mampu membuat kita ketagihan.', 60, 2, '/assets/images/bongkabola.webp', 3, 1),
('Barongko Pisang Telur', 'Kue yang di bungkus daun pisang yang selalu menjadi favorit masyarakat sumbawa, cocok di acara hajatan ataupun untuk hantaran di hari spesial.', 60, 32, '/assets/images/barongko_pisang_telur.webp', 3, 1),
('Sepat Khas Sumbawa', 'Sepat merupakan comfort food bagi masyarakat Sumbawa. Rasanya yang asam segar, dipadukan dengan wangi dari daun kemangi, beserta bumbu2 aromatik yang dibakar, ditambah dengan renyahnya kerupuk kulit membuat sajian ini menjadi makanan sehari-hari favorit masyarakat Sumbawa. Saking gemarnya mereka mengolah ikan dengan kuah Sepat yang sangat menyegarkan ini, Sepat dijadikan menu yang wajib ada ketika berbuka puasa. Pada umumnya Sepat menggunakan belimbing wuluh, namun jika tidak punya sangat bisa diganti dengan asam jawa & jeruk nipis. Ini dia resepnya.', 40, 1, '/assets/images/sepatv2.webp', 1, 1),
('Goreng (Gulai Iga + Nangka)', 'Goreng khas sumbawa biasa juga dikenal dengan sebutan Soto Nangka. Goreng adalah salah satu jenis dari sekian banyaknya masakkan khas yang ada di Sumbawa yang berbahan dasar nangka. Biasanya Goreng sering disajikkan dalam upacara adat tertentu didaerah Sumbawa.', 120, 8, '/assets/images/gorengv2.jpg', 1, 1),
('Sioang Sira Ayam Khas Sumbawa', 'Makanan khas dari daerah Sumbawa ialah siong sira. Makanan tersebut berbahan dasar ayam kampung jantan, tapi bisa juga diganti dengan daging sapi bagian sengkel. Ayam siong sira sendiri memiliki arti yaitu ayam goreng garam.', 45, 2, '/assets/images/ayamSiongSira.webp', 1, 1),
('Ikan Bakar Sirasang', 'Rasa asin garam dipadu olahan rempah-rempah dengan rasa yang sedikit pedas membuat masakan ini menjadi masakan khas yang populer di Sumbawa. Ikan bakar sirasang yang dalam bahasa indonesianya ikan bakar garam pedas mengigit sangat populer di Sumbawa. Ikan dari sirasang ini harus benar-benar ikan yang segar, dibakar dengan dilumuri bumbu-bumbu rempah.', 30, 3, '/assets/images/sirasang.jpg', 1, 1),
('Gecok', 'Gecok adalah makanan khas Sumbawa yang terbuat dari daging sapi atau kerbau (bisa juga jeroan), Gecok seringkali menjadi bagian dari hidangan dalam acara-acara istimewa di Sumbawa.', 45, 4, '/assets/images/gecok.jpg', 1, 1),
('Pelu', 'makanan tradisional khas Sumbawa, yang terbuat dari daun pepaya atau daun singkong yang dimasak bersama kelapa parut sangrai, ikan asap atau ikan kering, dan bumbu rempah seperti cabai, bawang, dan kunyit. Rasanya gurih, sedikit pahit, dan sangat khas. Pelu biasanya disajikan sebagai lauk pendamping nasi dan sering hadir dalam acara adat maupun hidangan harian masyarakat Sumbawa.', 45, 3, '/assets/images/peluv2.webp', 2, 1),
('Manjareal', 'Manjareal merupakan kue khas Sumbawa yang terbuat dai bahan kacang tanah yang dihaluskan dengan cetakan daun lontar. Bentuk cetakannya bermacam-macam salah satunya berbentuk kemang setange. Manjareal ini disajikan langsung dengan cetakannya. Saat dimakan, teksturnya terasa padat beremah namun meleleh di mulut. Rasanya manis dengan aroma kacang yang lamat-lamat.', 60, 1, '/assets/images/manjarealv2.jpg', 3, 1),
('Singang', 'Pulau Sumbawa yang terletak di Provinsi NTB memiliki cuaca cerah yang cenderung panas. Mungkin itu salah satu hal yang mempengaruhi sehingga sebagian masakannya memiliki cita rasa agak asam segar. Salah satu makanan khas Sumbawa adalah singang. Singang bisa dibuat dari ikan, kepiting, cumi, ayam, udang. Akan tetapi bahan utamanya dan yang paling banyak di buat itu ikan.', 30, 4, '/assets/images/singang.webp', 1, 1),
('Mie Kuah Sumbawa', 'Mie ayam khas sumbawa yang rasanya itu segar dan berbeda dengan mie ayam pada umumnya. Mie Sumbawa ini salah satu Menu Favorit di acara2 kumpul2 ibu2. Selain Simple dan Mudah dibuat, Aroma Khas Kaldu Ayam nya adalah Kunci Utama dalam pembuatan Mie ini.', 50, 3, '/assets/images/mieSumbawa.jpg', 1, 1);

-- Data Resep_Bahan
INSERT INTO resep_bahan (id_resep, id_bahan, takaran, kelompok, urutan) VALUES
(1, 1, '2 buah', 'Bahan Utama', 1),    -- Terong lalap
(1, 2, '1 buah', 'Bahan Utama', 2),    -- Terong ungu
(1, 3, '2 ekor', 'Bahan Utama', 3),    -- Ikan favorit kalian
(1, 4, '3 siung', 'Bumbu Marinasi Ikan', 4), -- Bawang putih
(1, 5, '2 sdm', 'Bumbu Marinasi Ikan', 5),  -- Ketumbar bubuk
(1, 6, 'Secukupnya', 'Bumbu Marinasi Ikan', 6), -- Lada bubuk
(1, 7, 'Secukupnya', 'Bumbu Marinasi Ikan', 7), -- Garam
(1, 8, '5 butir', 'Bahan Sepat', 8),   -- Bawang merah
(1, 9, '9 buah', 'Bahan Sepat', 9),    -- Cabai rawit
(1, 10, '2 butir', 'Bahan Sepat', 10), -- Kemiri
(1, 11, '1 buah', 'Bahan Sepat', 11),  -- Tomat
(1, 12, '4 buah', 'Bahan Sepat', 12),  -- Belimbing wuluh
(1, 13, '1 buah', 'Bahan Sepat', 13),  -- Jeruk purut
(1, 14, 'Sedikit', 'Bahan Sepat', 14), -- Daun ruku
(1, 7, 'Secukupnya', 'Bumbu', 15),     -- Garam (duplikat)
(1, 15, 'Secukupnya', 'Bumbu', 16),    -- Micin
(1, 17, '2 gelas', 'Bumbu', 17),       -- Air
(2, 16, '100 gram', 'Bahan Utama', 1), -- Beras ketan hitam
(2, 7, '1/4 sdt', 'Bahan Utama', 2),   -- Garam
(2, 17, '350 ml', 'Bahan Utama', 3),   -- Air
(2, 18, '50 gram', 'Bahan Utama', 4),  -- Kelapa setengah tua
(2, 7, '1/4 sdt', 'Bahan Utama', 5),   -- Garam (duplikat)
(3, 65, '32 lembar', 'Bahan Utama', 1),-- Daun pisang
(3, 19, '10 buah', 'Bahan Utama', 2),  -- Pisang kepok
(3, 20, '10 butir', 'Bahan Utama', 3), -- Telur
(3, 21, '60 gr', 'Bahan Utama', 4),    -- Kacang tanah sangrai
(3, 22, '250 gr', 'Bahan Utama', 5),   -- Gula pasir
(3, 23, '200 ml', 'Bahan Utama', 6),   -- Santan kental
(3, 7, '1/2 sdt', 'Bahan Utama', 7),   -- Garam
(3, 24, '1/2 sdt', 'Bahan Utama', 8),  -- Vanili
(4, 3, '1/4 kg', 'Bahan Utama', 1),    -- Ikan favorit kalian
(4, 2, '1 buah', 'Bahan Utama', 2),    -- Terong ungu
(4, 25, 'Secukupnya', 'Bahan Utama', 3), -- Kerupuk kulit
(4, 8, '4 buah', 'Bahan Kuah', 4),     -- Bawang merah
(4, 10, '3 buah', 'Bahan Kuah', 5),    -- Kemiri
(4, 9, '5 buah', 'Bahan Kuah', 6),     -- Cabai rawit
(4, 11, '1 butir', 'Bahan Kuah', 7),   -- Tomat
(4, 44, '2 biji', 'Bahan Kuah', 8),    -- Asam jawa
(4, 14, '1/2 butir', 'Bahan Kuah', 9), -- Daun ruku
(4, 29, 'Secukupnya', 'Bahan Kuah', 10), -- Kaldu bubuk sapi
(4, 17, '250 ml', 'Bahan Kuah', 11),   -- Air
(4, 13, '1 butir', 'Bahan Kuah', 12),  -- Jeruk purut
(5, 26, '1 kg', 'Bahan Utama', 1),     -- Tulang iga sapi
(5, 27, '1/2 kg', 'Bahan Utama', 2),   -- Nangka muda
(5, 18, '1/2 butir kelapa', 'Bahan Utama', 3), -- Kelapa setengah tua
(5, 44, '3 sdm', 'Bahan Utama', 4),    -- Asam jawa
(5, 23, '1 1/2 liter', 'Bahan Utama', 5), -- Santan kental
(5, 8, 'Secukupnya', 'Tambahan', 6),   -- Bawang merah
(5, 7, 'Secukupnya', 'Bumbu', 7),      -- Garam
(5, 29, 'Secukupnya', 'Bumbu', 8),     -- Kaldu bubuk sapi
(5, 4, '5 siung', 'Bumbu Halus', 9),   -- Bawang putih
(5, 8, '7 butir', 'Bumbu Halus', 10),  -- Bawang merah
(5, 31, '2 ruas', 'Bumbu Halus', 11),  -- Jahe
(5, 32, '3 ruas', 'Bumbu Halus', 12),  -- Laos
(5, 10, '9 butir', 'Bumbu Halus', 13), -- Kemiri
(5, 5, '2 sdm', 'Bumbu Halus', 14),    -- Ketumbar bubuk
(5, 6, '1 sdt', 'Bumbu Halus', 15),    -- Lada bubuk
(5, 34, '7 butir', 'Bumbu Halus', 16), -- Kapulaga
(5, 35, '5 butir', 'Bumbu Halus', 17), -- Cengkeh
(5, 36, '2 buah', 'Bumbu Halus', 18),  -- Bunga duri
(5, 37, '1 buah', 'Bumbu Halus', 19),  -- Pala
(5, 38, '3 buah', 'Bumbu Halus', 20),  -- Bunga lawang
(5, 41, '3 ruas', 'Bumbu Halus', 21),  -- Kunyit
(5, 42, '1 batang', 'Bumbu Cemplung', 22), -- Sereh
(5, 40, '5 lembar', 'Bumbu Cemplung', 23), -- Daun salam
(6, 43, '1 ekor', 'Bahan Utama', 1),   -- Ayam kampung
(6, 32, '4 cm', 'Bahan Utama', 2),     -- Laos
(6, 42, '1 buah', 'Bahan Utama', 3),   -- Sereh
(6, 44, '5 buah', 'Bahan Utama', 4),   -- Asam jawa
(6, 30, 'Secukupnya', 'Bahan Utama', 5), -- Minyak goreng
(6, 14, '1 buah', 'Bahan Utama', 6),   -- Daun ruku
(6, 9, '30 buah', 'Bumbu Halus', 7),   -- Cabai rawit
(6, 8, '10 siung', 'Bumbu Halus', 8),  -- Bawang merah
(6, 4, '2 siung', 'Bumbu Halus', 9),   -- Bawang putih
(6, 5, '10 biji', 'Bumbu Halus', 10),  -- Ketumbar bubuk
(6, 6, '1/2 sdt', 'Bumbu Halus', 11),  -- Lada bubuk
(6, 41, '3 cm', 'Bumbu Halus', 12),    -- Kunyit
(6, 10, '2 buah', 'Bumbu Halus', 13),  -- Kemiri
(6, 7, 'Secukupnya', 'Bumbu Halus', 14), -- Garam
(7, 46, '500 gr', 'Bahan Utama', 1),   -- Ikan kakap merah
(7, 45, '1/2 buah', 'Bahan Utama', 2), -- Jeruk nipis
(7, 10, '3 butir', 'Bumbu Halus', 3),  -- Kemiri
(7, 4, '2 siung', 'Bumbu Halus', 4),   -- Bawang putih
(7, 8, '5 butir', 'Bumbu Halus', 5),   -- Bawang merah
(7, 31, '1 buah', 'Bumbu Halus', 6),   -- Jahe
(7, 5, '1/4 sdt', 'Bumbu Halus', 7),   -- Ketumbar bubuk
(7, 41, '1/4 sdt', 'Bumbu Halus', 8),  -- Kunyit
(7, 11, '1 buah', 'Bumbu Halus', 9),   -- Tomat
(7, 7, '1/2 sdt', 'Bumbu Halus', 10),  -- Garam
(7, 48, '1/4 sdt', 'Bumbu Halus', 11), -- Penyedap
(8, 49, '1/2 kg', 'Bahan Utama', 1),   -- Daging sapi
(8, 50, '1/2 kg', 'Bahan Utama', 2),   -- Jeroan
(8, 51, '1/2 kg', 'Bahan Utama', 3),   -- Hati sapi
(8, 30, '1/4 botol', 'Bahan Utama', 4), -- Minyak goreng
(8, 18, '1/2 butir', 'Bahan Utama', 5), -- Kelapa setengah tua
(8, 8, '1 ons', 'Bumbu Halus', 6),     -- Bawang merah
(8, 42, '4 batang', 'Bumbu Halus', 7), -- Sereh
(8, 4, '5 siung', 'Bumbu Halus', 8),   -- Bawang putih
(8, 14, '1/2 butir', 'Bumbu Halus', 9), -- Daun ruku
(8, 32, '1 potong', 'Bumbu Halus', 10), -- Laos
(8, 53, '5 buah', 'Bumbu Halus', 11),  -- Daun jeruk purut
(8, 9, '3 buah', 'Bumbu Halus', 12),   -- Cabai rawit
(8, 10, '5 biji', 'Bumbu Halus', 13),  -- Kemiri
(8, 6, '1 sdt', 'Bumbu Halus', 14),    -- Lada bubuk
(8, 56, '10 sdm', 'Bumbu Halus', 15),  -- Kelapa parut
(8, 54, '1 potong', 'Bumbu Halus', 16), -- Kacang panjang
(9, 54, '1 ikat', 'Bahan Utama', 1),   -- Kacang panjang
(9, 55, '1 bungkus', 'Bahan Utama', 2), -- Daun pepaya
(9, 56, '1 bungkus', 'Bahan Utama', 3), -- Kelapa parut
(9, 41, '1 cm', 'Bumbu', 4),           -- Kunyit
(9, 53, '5 buah', 'Bumbu', 5),         -- Daun jeruk purut
(9, 9, '10 buah', 'Bumbu', 6),         -- Cabai rawit
(9, 4, '1 siung', 'Bumbu', 7),         -- Bawang putih
(9, 8, '4 siung', 'Bumbu', 8),         -- Bawang merah
(10, 22, '1/2 kg', 'Bahan Utama', 1),  -- Gula pasir
(10, 21, '1 kg', 'Bahan Utama', 2),    -- Kacang tanah sangrai
(10, 66, '1 lembar', 'Bahan Utama', 3),-- Daun lontar kering
(11, 58, '500 gr', 'Bahan Utama', 1),  -- Ikan tongkol
(11, 8, '5 bh', 'Bahan Utama', 2),     -- Bawang merah
(11, 17, '600 ml', 'Bahan Utama', 3),  -- Air
(11, 44, '3 mata', 'Bahan Utama', 4),  -- Asam jawa
(11, 7, '1 sdt', 'Bumbu', 5),          -- Garam
(11, 22, '1 sdt', 'Bumbu', 6),         -- Gula pasir
(11, 29, '1 sdt', 'Bumbu', 7),         -- Kaldu bubuk sapi
(11, 11, '3 buah', 'Bahan Utama', 8),  -- Tomat
(11, 9, '10 buah', 'Bahan Utama', 9),  -- Cabai rawit
(11, 11, '2 buah', 'Bahan Utama', 10), -- Tomat (duplikat)
(11, 29, 'Secukupnya', 'Bahan Utama', 11), -- Kaldu bubuk sapi
(11, 30, 'Secukupnya', 'Bumbu', 12),   -- Minyak goreng
(11, 41, '2 cm', 'Bumbu Halus', 13),   -- Kunyit
(11, 7, '1 sdt', 'Bumbu Halus', 14),   -- Garam
(12, 43, '250 gram', 'Bahan Utama', 1), -- Ayam kampung
(12, 67, '1 bungkus', 'Bahan Utama', 2), -- Mie kuda/mie konde
(12, 61, '100 gram', 'Bahan Utama', 3), -- Wortel
(12, 20, '3 butir', 'Tambahan', 4),    -- Telur
(12, 62, '2 buah', 'Bahan Utama', 5),  -- Saledri
(12, 63, '7 batang', 'Bahan Utama', 6), -- Daun bawang pree
(12, 64, '2 batang', 'Bahan Utama', 7), -- Udang
(12, 17, '300 ml', 'Bahan Utama', 8),  -- Air
(12, 8, '5 siung', 'Bumbu', 9),        -- Bawang merah
(12, 4, '3 siung', 'Bumbu', 10),       -- Bawang putih
(12, 10, '2 butir', 'Bumbu', 11),      -- Kemiri
(12, 9, '3 buah', 'Bumbu', 12),        -- Cabai rawit
(12, 6, '1 sdt', 'Bumbu', 13),         -- Lada bubuk
(12, 7, '2 sdt', 'Bumbu', 14),         -- Garam
(12, 48, '1/2 sdt', 'Bumbu', 15);      -- Penyedap

-- Data Langkah Memasak
INSERT INTO langkah_memasak (id_resep, nomor_urutan, deskripsi_langkah) VALUES
(1, 1, 'Pertama, cuci dan bersihkan ikan, lalu marinasi ikan.'),
(1, 2, 'Bakar semua bahan sepat kecuali daun ruku, jeruk, terong lalap, dan belimbing wuluh. Bakar juga terong ungu hingga sedikit kecoklatan & empuk.'),
(1, 3, 'Lalu uleg bahan sepat yg sudah di bakar, kecuali terong lalap di potong saja dan bersihkan kulitnya. bumbui. Setelah itu didihkan Air & bakar ikan.'),
(1, 4, 'Setelah air mendidih, tuang air kedalam bumbu yang sudah di ulek, aduk2 cicipi rasa. Jika semua sudah pas letakan terong dan ikan di kuah sepat & beri perasan air jeruk purut. Lalu siap di santap.'),
(2, 1, 'Siapkan bahan-bahannya.'),
(2, 2, 'Cuci bersih dan rendam beras ketan selama 30 menit (1 jam) tiriskan.'),
(2, 3, 'Aron beras ketan dengan 350 ml air + 1/4 sdt garam hingga airnya setengah.'),
(2, 4, 'Kemudian kukus hingga matang.'),
(2, 5, 'Siapkan kelapa parut yang sudah di campur garam, setelah itu tambahkan nasi ketan dan campur merata.'),
(2, 6, 'Sajikan dan Selamat Menikmati.'),
(3, 1, 'Haluskan pisang dan blender halus kacang tanah sangrai.'),
(3, 2, 'Masukkan santan, garam dan vanili, aduk rata.'),
(3, 3, 'Tambahkan kacang tanah halus dan gula pasir, aduk rata.'),
(3, 4, 'Di wadah lain kocok telur, lalu tuang kedalam adonan pisang, aduk hingga tercampur rata.'),
(3, 5, 'Ambil 1 lembar bagan daun pisang, beri 1 sendok sayur adonan, lalu sematkan, lakukan hingga adonan habis. Tata di kukusan.'),
(3, 6, 'Panaskan tempat pengukusannya, lalu kukus selama 25-30 menit atau hingga matang, Angkat dan biarkan dingin suhu ruang.'),
(3, 7, 'Jajanan siap untuk di sajikan, biar lebih enak simpan dulu di kulkas agar dingin baru di sajikan.'),
(4, 1, 'Bersihkan ikan & bakar ikan hingga matang. Ikan dibakar tanpa bumbu apapun.'),
(4, 2, 'Bakar terong hingga matang. Setelah matang kupas kulitnya & suwir2 terong.'),
(4, 3, 'Sangrai kemiri, bawang merah, cabai rawit, serta tomat hingga terlihat agak gosong sedikit.'),
(4, 4, 'Ulek kemiri hingga halus. Tambahkan bawang merah dan cabai rawit, ulek kembali. Tambahkan garam & micin. Terakhir ulek tomat.'),
(4, 5, 'Campurkan air asam jawa, air matang, perasan jeruk nipis, jeruk purut besar, & kemangi yang disobek2. Aduk-aduk Tes rasa.'),
(4, 6, 'Masukkan ikan bakar dan suwiran terong ke dalm kuah. Sepat siap disajikan dengan kerupuk kulit.'),
(5, 1, 'Siapkan semua bahan dan juga bumbu.'),
(5, 2, 'Cuci bersih dan rebus tulang iga hingga empuk.'),
(5, 3, 'Sementara menunggu tulang empuk, sangrai semua bumbu halus, kemudian blender hingga halus.'),
(5, 4, 'Tumis bumbu halus hingga harum, masukkan bumbu Cemplung, tumis hingga matang, sisihkan.'),
(5, 5, 'Setelah tulang empuk, masukkan nangka muda, masak kembali hingga nangka empuk.'),
(5, 6, 'Kemudian tuang santan, bumbu tumis, dan juga serbuk koya, bumbui garam dan kaldu bubuk, masukkan air asam jawa.'),
(5, 7, 'Masak hingga mendidih, matikan api, jangan lupa koreksi rasa.'),
(5, 8, 'Sajikan dengan taburan bawang goreng dan pelengkap.'),
(6, 1, 'Siapkan seluruh bahan, cuci bersih ayam dan rendam dengan perasan jeruk nipis.'),
(6, 2, 'Ulek/blender semua bumbu halus, dan siapkan air perasan asam jawa.'),
(6, 3, 'Tumis bumbu yang sudah dihalus, dan tambahkan lengkuas yang telah dimemarkan/geprek.'),
(6, 4, 'Setelah harum dan cukup matang, tambakan air perasan asam jawa, tambahkan lagi dengan air sekitr 500 ml, masak sampai mendidih.'),
(6, 5, 'Masukkan ayam sampai setengah matang masukkan serai. Tambahkan garam. Koreksi rasa dan masak sampai ayam empuk.'),
(6, 6, 'Sajikan dengan taburan bawang goreng dan pelengkap.'),
(7, 1, 'Siapkan bahan dan bumbu.'),
(7, 2, 'Bersihkan ikan dari sisiknya, kemudian belah jangan sampai putus, lumuri dengan air perasan jeruk nipis, diamkan sekitar 5 menit, lalu bilas bersih, sisihkan.'),
(7, 3, 'Haluskan semua bumbu.'),
(7, 4, 'Siapkan panggangan, lapisi dengan alumunium foil atau daun pisang, oles dengan sedikit minyak goreng.'),
(7, 5, 'olesi semua bagian ikan dengan sebagian bumbu sampai rata, kemudian tutup dengan alumunium foil dan panggang dengan api kecil hingga setengah matang.'),
(7, 6, 'Kemudian olesi dengan sedikit minyak goreng, lumuri dengan sisa bumbu, panggang kembali hingga matang.'),
(7, 7, 'Angkat dan sajikan.'),
(8, 1, 'Rebus jeroan, daging dan hati, lalu diiri-iris.'),
(8, 2, 'Parut kelapa dan dibagi menjadi dua, yatu setengah dibuat santan dan setengahnya lagi disangrai dan dihaluskan.'),
(8, 3, 'Haluskan bawang merah, bawang putih, cabai rawit, kemiri, lada, dan garam, kemudian ditumis dan masukkan laos dan sereh.'),
(8, 4, 'Setelah itu masukkan santan dan kelapa yang sudah disangarai ke tumisan bumbu, aduk terus sampai kental lalu diangkat.'),
(8, 5, 'Biarkan bumbu sampai dingin dan masukkan wijen yang sudha disangrai dan dihaluskan.'),
(8, 6, 'Siapkan bahan tambahan sebagai topping yaitu bawang merah, cabai merah, dan daun jeruk yang diiris lalu digoreng.'),
(8, 7, 'Setelah itu campur semua bahan, yaitu jeroan, daging, hati, dan sebagian bumbu yang digoreng dan bumbu yang ditumis.'),
(8, 8, 'Campur dan aduk terus hingga merata, dan Gecok siap untuk dinikmati.'),
(9, 1, 'Cuci bersih sayuran kemudian potong2.'),
(9, 2, 'Ulek bumbu2 (cabe rawit, cabe keriting, bawang putih, bawang merah, kunyit dan terasi).'),
(9, 3, 'Campurkan bumbu halus yang sudah di ulek dengan kelapa.'),
(9, 4, 'Rebus air di magic com (tekan tombol untuk sop). Sambil nunggu mendidih lakukan langkah no 1-3.'),
(9, 5, 'Sambil menunggu matang, bisa goreng tahu, tempe or ikan sebagai pendamping si urap.'),
(9, 6, 'Siap dinikmati dengan nasi hangat. Hemat waktu.'),
(10, 1, 'Rendam kacang dengan air panas selama semalaman.'),
(10, 2, 'Kupas kulit kacang lalu rebus sampai masak.'),
(10, 3, 'Buat caramel dai gula pasir, masukkan kacang yang tela ditumbuk, aduk sampai rata.'),
(10, 4, 'Masukkan adonan kedalam cetakan yang terbuat dari lontar kering.'),
(10, 5, 'Jemur sampai kering.'),
(10, 6, 'Hidangkan tanpa melepaskan cetakannya.'),
(11, 1, 'Tumis Bawang merah hingga harum dan berubah warna.'),
(11, 2, 'Masukkan bumbu halus, tumis hingga bumbu halus harum dan matang.'),
(11, 3, 'Tambahkan 500 ml air dan asam jawa.'),
(11, 4, 'Jika sudah mendidih, masukkan ikan tongkol. Masak hingga ikan matang.'),
(11, 5, 'Tambahkan gula, garam dan kaldu jamur.'),
(11, 6, 'Masukkan cabai hijau besar, cabai rawit merah, dan tomat merah. Terakhir sekali masukkan daun kemangi, masak sebentar kemudian matikan api dan sajikan segera.'),
(12, 1, 'Bersihkan dan potong sayur, rebus mie dengan 250ml air.'),
(12, 2, 'Goreng ayam dan udang yang telah terlebih dahulu di lumuri garam dan lada bubuk.'),
(12, 3, 'Haluskan bumbu.'),
(12, 4, 'Rebus bagian kepala dan ceker ayam dengan air 300ml sampai mendidih tambahkan bumbu yang di haluskan, tambahkan daun saledri dan daun bawang, koreksi rasa.'),
(12, 5, 'Tata mie di piring, kemudian sayuran, ayam suir, udang goreng dan telur.'),
(12, 6, 'Siram kuah ke mie yg telah ditata tdi. Taburi bawang goreng, tambahkan kecap, saos, jeruk nipis dan cabe rawit jika suka.');