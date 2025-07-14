// JavaScript untuk website Resep Sumbawa
// File ini berisi fungsi-fungsi interaktif untuk meningkatkan user experience

// Tambahkan fungsi untuk mobile menu dan search toggle
function initMobileMenu() {
  const mobileToggle = document.querySelector(".mobile-menu-toggle")
  const navMenu = document.querySelector(".nav-menu-modern")

  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener("click", () => {
      mobileToggle.classList.toggle("active")
      navMenu.classList.toggle("active")
    })

    // Close menu when clicking on a link
    const navLinks = navMenu.querySelectorAll(".nav-link")
    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        mobileToggle.classList.remove("active")
        navMenu.classList.remove("active")
      })
    })
  }
}

function initSearchToggle() {
  const searchToggle = document.querySelector(".search-toggle")

  if (searchToggle) {
    searchToggle.addEventListener("click", () => {
      // Create search overlay if it doesn't exist
      let searchOverlay = document.querySelector(".search-overlay")

      if (!searchOverlay) {
        searchOverlay = document.createElement("div")
        searchOverlay.className = "search-overlay"
        searchOverlay.innerHTML = `
          <div class="search-overlay-content">
            <h3 style="margin-bottom: 1rem; color: #2c3e50;">Cari Resep</h3>
            <form action="/cari_resep.php" method="GET">
              <input 
                type="text" 
                name="keyword" 
                placeholder="Masukkan nama resep atau bahan..."
                style="width: 100%; padding: 1rem; border: 2px solid #e9ecef; border-radius: 8px; font-size: 1rem; margin-bottom: 1rem;"
                autofocus
              >
              <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="close-search" style="background: #95a5a6; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer;">
                  Batal
                </button>
                <button type="submit" style="background: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer;">
                  Cari
                </button>
              </div>
            </form>
          </div>
        `
        document.body.appendChild(searchOverlay)

        // Add close functionality
        const closeBtn = searchOverlay.querySelector(".close-search")
        closeBtn.addEventListener("click", () => {
          searchOverlay.classList.remove("active")
        })

        // Close on overlay click
        searchOverlay.addEventListener("click", (e) => {
          if (e.target === searchOverlay) {
            searchOverlay.classList.remove("active")
          }
        })
      }

      searchOverlay.classList.add("active")
    })
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // Fungsi yang dijalankan setelah DOM selesai dimuat

  // Inisialisasi semua fungsi
  initMobileMenu()
  initSearchToggle()
  initSearchForm()
  initImageLazyLoading()
  initSmoothScrolling()
  initBackToTop()
  initRecipeCardAnimations()
  initFormValidation()
})

// Fungsi untuk menangani form pencarian
function initSearchForm() {
  const searchForm = document.querySelector(".search-form")
  const searchInput = document.querySelector('.search-form input[name="keyword"]')

  if (searchForm && searchInput) {
    // Tambahkan placeholder yang berubah-ubah
    const placeholders = ["Cari resep favorit...", "Sepat, Barongko, Singang...", "Masakan tradisional Sumbawa..."]

    let placeholderIndex = 0

    // Ganti placeholder setiap 3 detik
    setInterval(() => {
      placeholderIndex = (placeholderIndex + 1) % placeholders.length
      searchInput.placeholder = placeholders[placeholderIndex]
    }, 3000)

    // Validasi form sebelum submit
    searchForm.addEventListener("submit", (e) => {
      const keyword = searchInput.value.trim()

      if (keyword.length < 2) {
        e.preventDefault()
        alert("Masukkan minimal 2 karakter untuk pencarian")
        searchInput.focus()
        return false
      }
    })

    // Auto-suggest (simulasi - bisa dikembangkan dengan AJAX)
    searchInput.addEventListener("input", function () {
      const keyword = this.value.trim()

      if (keyword.length >= 2) {
        // Di sini bisa ditambahkan AJAX untuk auto-suggest
        console.log("Searching for:", keyword)
      }
    })
  }
}

// Fungsi untuk lazy loading gambar (mengoptimalkan loading)
function initImageLazyLoading() {
  // Cek apakah browser mendukung Intersection Observer
  if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target

          // Ganti src dengan data-src
          if (img.dataset.src) {
            img.src = img.dataset.src
            img.classList.remove("lazy")
            img.classList.add("loaded")
            observer.unobserve(img)
          }
        }
      })
    })

    // Observe semua gambar dengan class 'lazy'
    const lazyImages = document.querySelectorAll("img.lazy")
    lazyImages.forEach((img) => imageObserver.observe(img))
  }
}

// Fungsi untuk smooth scrolling pada anchor links
function initSmoothScrolling() {
  const anchorLinks = document.querySelectorAll('a[href^="#"]')

  anchorLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href")
      const targetElement = document.querySelector(targetId)

      if (targetElement) {
        e.preventDefault()

        targetElement.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })
}

// Fungsi untuk tombol back to top
function initBackToTop() {
  // Buat tombol back to top
  const backToTopBtn = document.createElement("button")
  backToTopBtn.innerHTML = "↑"
  backToTopBtn.className = "back-to-top"
  backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
        display: none;
        z-index: 1000;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    `

  document.body.appendChild(backToTopBtn)

  // Show/hide tombol berdasarkan scroll position
  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
      backToTopBtn.style.display = "block"
    } else {
      backToTopBtn.style.display = "none"
    }
  })

  // Scroll to top saat diklik
  backToTopBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    })
  })

  // Hover effect
  backToTopBtn.addEventListener("mouseenter", function () {
    this.style.background = "#2980b9"
    this.style.transform = "scale(1.1)"
  })

  backToTopBtn.addEventListener("mouseleave", function () {
    this.style.background = "#3498db"
    this.style.transform = "scale(1)"
  })
}

// Fungsi untuk animasi recipe cards
function initRecipeCardAnimations() {
  const recipeCards = document.querySelectorAll(".recipe-card")

  // Intersection Observer untuk animasi saat scroll
  if ("IntersectionObserver" in window) {
    const cardObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = "1"
            entry.target.style.transform = "translateY(0)"
          }
        })
      },
      {
        threshold: 0.1,
      },
    )

    recipeCards.forEach((card, index) => {
      // Set initial state
      card.style.opacity = "0"
      card.style.transform = "translateY(20px)"
      card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`

      cardObserver.observe(card)
    })
  }

  // Tambahkan efek hover yang lebih interaktif
  recipeCards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-10px) scale(1.02)"
    })

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0) scale(1)"
    })
  })
}

// Fungsi untuk validasi form
function initFormValidation() {
  const forms = document.querySelectorAll("form")

  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = this.querySelectorAll("[required]")
      let isValid = true

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false
          field.style.borderColor = "#e74c3c"

          // Hapus error styling setelah user mulai mengetik
          field.addEventListener(
            "input",
            function () {
              this.style.borderColor = ""
            },
            { once: true },
          )
        }
      })

      if (!isValid) {
        e.preventDefault()
        alert("Mohon lengkapi semua field yang wajib diisi")
      }
    })
  })
}

// Fungsi utility untuk format angka
function formatNumber(num) {
  return new Intl.NumberFormat("id-ID").format(num)
}

// Fungsi untuk copy text ke clipboard
function copyToClipboard(text) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(() => {
      showNotification("Teks berhasil disalin!")
    })
  } else {
    // Fallback untuk browser lama
    const textArea = document.createElement("textarea")
    textArea.value = text
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand("copy")
    document.body.removeChild(textArea)
    showNotification("Teks berhasil disalin!")
  }
}

// Fungsi untuk menampilkan notifikasi
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.textContent = message
  notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === "success" ? "#27ae60" : type === "error" ? "#e74c3c" : "#3498db"};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 5px;
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `

  document.body.appendChild(notification)

  // Hapus notifikasi setelah 3 detik
  setTimeout(() => {
    notification.style.animation = "slideOut 0.3s ease"
    setTimeout(() => {
      document.body.removeChild(notification)
    }, 300)
  }, 3000)
}

// Tambahkan CSS untuk animasi notifikasi
const style = document.createElement("style")
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`
document.head.appendChild(style)

// Fungsi untuk print halaman
function printPage() {
  window.print()
}

// Fungsi untuk share (jika browser mendukung Web Share API)
function shareRecipe(title, url) {
  if (navigator.share) {
    navigator
      .share({
        title: title,
        url: url,
      })
      .then(() => {
        console.log("Berhasil dibagikan")
      })
      .catch((error) => {
        console.log("Error sharing:", error)
      })
  } else {
    // Fallback: copy URL ke clipboard
    copyToClipboard(url)
  }
}

// Event listener untuk keyboard shortcuts
document.addEventListener("keydown", (e) => {
  // Ctrl/Cmd + K untuk focus ke search
  if ((e.ctrlKey || e.metaKey) && e.key === "k") {
    e.preventDefault()
    const searchInput = document.querySelector(".search-form input")
    if (searchInput) {
      searchInput.focus()
    }
  }

  // Escape untuk close modal/dropdown (jika ada)
  if (e.key === "Escape") {
    // Close any open modals or dropdowns
    const openModals = document.querySelectorAll(".modal.show")
    openModals.forEach((modal) => {
      modal.classList.remove("show")
    })
  }
})

// Fungsi untuk deteksi dark mode preference
function detectDarkMode() {
  if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
    document.body.classList.add("dark-mode")
  }

  // Listen untuk perubahan
  window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", (e) => {
    if (e.matches) {
      document.body.classList.add("dark-mode")
    } else {
      document.body.classList.remove("dark-mode")
    }
  })
}

// Inisialisasi dark mode detection
detectDarkMode()

// Service Worker registration (untuk PWA - opsional)
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("/sw.js")
      .then((registration) => {
        console.log("ServiceWorker registration successful")
      })
      .catch((error) => {
        console.log("ServiceWorker registration failed")
      })
  })
}

// Export fungsi untuk digunakan di file lain
window.ResepSumbawa = {
  copyToClipboard,
  showNotification,
  printPage,
  shareRecipe,
  formatNumber,
}
