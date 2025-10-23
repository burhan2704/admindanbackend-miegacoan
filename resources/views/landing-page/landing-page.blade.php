<!doctype html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-wide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="core-template/assets/"
  data-template="front-pages"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Mie Gacoan | Transformasi Digital Bisnis Anda Dimulai di Sini</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/miegacoan.ico') }}" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="core-template/assets/vendor/fonts/remixicon/remixicon.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="core-template/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="core-template/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="core-template/assets/css/demo.css" />
    <link rel="stylesheet" href="core-template/assets/vendor/css/pages/front-page.css" />
    <!-- Vendors CSS -->

    <link rel="stylesheet" href="core-template/assets/vendor/libs/nouislider/nouislider.css" />
    <link rel="stylesheet" href="core-template/assets/vendor/libs/swiper/swiper.css" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="core-template/assets/vendor/css/pages/front-page-landing.css" />

    <!-- Helpers -->
    <script src="core-template/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!-- <script src="core-template/assets/vendor/js/template-customizer.js"></script> -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="core-template/assets/js/front-config.js"></script>
    <style>
      .hide-wa-menu {
        right: -100% !important;
      }

      .show-wa-menu {
        transition: all .5s;
      }

      .wa-off-hover {
        right: 1em;
      }

      .wa-on-hover {
        right: 0%;
      }

      @media (max-width: 858px){
        .wa-off-hover {
          right: 1em !important;
        }
      }
    </style>
  </head>

  <body>
    <script src="core-template/assets/vendor/js/dropdown-hover.js"></script>
    <script src="core-template/assets/vendor/js/mega-dropdown.js"></script>

    <!-- Navbar: Start -->
    <nav class="layout-navbar container shadow-none py-0">
      <div class="navbar navbar-expand-lg landing-navbar border-top-0 px-4 px-md-8">
        <!-- Menu logo wrapper: Start -->
        <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-6">
          <!-- Mobile menu toggle: Start-->
          <button
            class="navbar-toggler border-0 px-0 me-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="tf-icons ri-menu-fill ri-24px align-middle"></i>
          </button>
          <!-- Mobile menu toggle: End-->
          <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo">
              <span style="color: #666cff">
                <img src="{{ asset('images/logo/miegacoan.png') }}" alt="Mie Gacoan Logo" style="height: 40px; width: auto;">
              </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2 ps-1">Mie Gacoan</span>
          </a>
        </div>
        <!-- Menu logo wrapper: End -->
        <!-- Menu wrapper: Start -->
        <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
          <button
            class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="tf-icons ri-close-fill"></i>
          </button>
          <ul class="navbar-nav me-auto p-4 p-lg-0">
            <li class="nav-item">
              <a class="nav-link fw-medium" aria-current="page" href="{{ route('landing-page') }}#Beranda">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="{{ route('landing-page') }}#Layanan">Layanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="{{ route('landing-page') }}#Portofolio">Portofolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium text-nowrap" href="{{ route('landing-page') }}#HubungiKami">Hubungi Kami</a>
            </li>
          </ul>
        </div>
        <div class="landing-menu-overlay d-lg-none"></div>
        <!-- Menu wrapper: End -->
        <!-- Toolbar: Start -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">

          <!-- navbar button: Start -->
          <li>
            <a
              href="{{ url("login")}}"
              class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4"
              target="_blank"
              ><span class="tf-icons ri-user-line me-md-1"></span
              ><span class="d-none d-md-block">Login</span></a
            >
          </li>
          <!-- navbar button: End -->
        </ul>
        <!-- Toolbar: End -->
      </div>
    </nav>
    <!-- Navbar: End -->

    <!-- Sections:Start -->

    <div data-bs-spy="scroll" class="scrollspy-example">
      <!-- Hero: Start -->
      <section id="Beranda" class="section-py landing-hero position-relative">
        <img
          src="core-template/assets/img/front-pages/backgrounds/hero-bg-light.png"
          alt="hero background"
          class="position-absolute top-0 start-0 w-100 h-100 z-n1"
          data-speed="1"
          data-app-light-img="front-pages/backgrounds/hero-bg-light.png"
          data-app-dark-img="front-pages/backgrounds/hero-bg-dark.png" />
        <div class="container">
         <div class="hero-text-box text-center">
          <h3 class="text-primary hero-title fs-2">
            Transformasi Digital Bisnis Anda Dimulai di Sini
          </h3>
          <h2 class="h6 mb-8">
            Kelola seluruh operasional bisnis secara <strong>lebih efisien</strong>, <strong>lebih cerdas</strong>, dan <strong>lebih terintegrasi</strong> dengan solusi ERP dari <strong>PT Motiva Teknologi Nusantara</strong>.
            Dapatkan visibilitas real-time, otomatisasi proses, dan laporan yang siap bantu ambil keputusan tepat—kapan saja.
          </h2>
          <a href="#HubungiKami" class="btn btn-lg btn-primary shadow-sm">
            Coba Demo Gratis Sekarang
          </a>
        </div>

          <div class="position-relative hero-animation-img">
            <a href="#" target="_blank">
              <div class="hero-dashboard-img text-center">
                <img
                  src="core-template/assets/img/front-pages/landing-page/fix-miegacoan.png"
                  alt="hero dashboard"
                  class="animation-img"
                  data-speed="2"
                  data-app-light-img="front-pages/landing-page/fix-miegacoan.png"
                  data-app-dark-img="front-pages/landing-page/fix-miegacoan.png" />
              </div>
              <div class="position-absolute hero-elements-img">
                <img
                  src="core-template/assets/img/front-pages/landing-page/hero-elements-light.png"
                  alt="hero elements"
                  class="animation-img"
                  data-speed="4"
                  data-app-light-img="front-pages/landing-page/hero-elements-light.png"
                  data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
              </div>
            </a>
          </div>
        </div>
      </section>
      <!-- Hero: End -->

      <!-- Useful features: Start -->
      <section id="Layanan" class="section-py landing-features">
        <div class="container">
          <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
            <img
              src="core-template/assets/img/front-pages/icons/section-tilte-icon.png"
              alt="ikon judul"
              class="me-3" />
            <span class="text-uppercase">Semua yang Anda Butuhkan untuk Memulai Digitalisasi Bisnis</span>
          </h6>

          <h5 class="text-center mb-2">
            <span class="display-5 fs-4 fw-bold">Solusi lengkap</span> untuk memulai transformasi digital Anda
          </h5>

          <p class="text-center fw-medium mb-4 mb-md-12">
            Bukan sekadar kumpulan fitur, sistem dari <strong>PT Motiva Teknologi Nusantara</strong> adalah aplikasi siap pakai yang dirancang untuk membantu bisnis Anda tumbuh lebih cepat, efisien, dan terintegrasi.
          </p>

          {{-- <div class="features-icon-wrapper row gx-0 gy-12 gx-sm-6 mt-n4 mt-sm-0">
            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="features-icon mb-4">
                <img src="core-template/assets/img/front-pages/icons/laptop-charging.png" alt="kode berkualitas" />
              </div>
              <h5 class="mb-2">Kode Berkualitas</h5>
              <p class="features-icon-description">
                Struktur kode yang rapi dan mudah dipahami oleh tim developer Anda.
              </p>
            </div>

            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="features-icon mb-4">
                <img src="core-template/assets/img/front-pages/icons/transition-up.png" alt="pembaruan rutin" />
              </div>
              <h5 class="mb-2">Pembaruan Berkala</h5>
              <p class="features-icon-description">
                Nikmati pembaruan gratis selama 12 bulan, termasuk penambahan modul dan fitur baru.
              </p>
            </div>

            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="features-icon mb-4">
                <img src="core-template/assets/img/front-pages/icons/edit.png" alt="starter kit" />
              </div>
              <h5 class="mb-2">Siap Pakai</h5>
              <p class="features-icon-description">
                Mulai proyek Anda dengan cepat tanpa perlu menghapus fitur yang tidak dibutuhkan.
              </p>
            </div>

            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="features-icon mb-4">
                <img src="core-template/assets/img/front-pages/icons/3d-select-solid.png" alt="api ready" />
              </div>
              <h5 class="mb-2">Siap Integrasi API</h5>
              <p class="features-icon-description">
                Ubah endpoint dan lihat data Anda langsung tampil hanya dalam hitungan detik.
              </p>
            </div>

            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="features-icon mb-4">
                <img src="core-template/assets/img/front-pages/icons/lifebelt.png" alt="dukungan teknis" />
              </div>
              <h5 class="mb-2">Dukungan Teknis</h5>
              <p class="features-icon-description">
                Tim support kami siap membantu Anda dengan dokumentasi dan panduan implementasi.
              </p>
            </div>

            <div class="col-lg-4 col-sm-6 text-center features-icon-box">
              <div class="features-icon mb-4">
                <img src="core-template/assets/img/front-pages/icons/google-docs.png" alt="dokumentasi lengkap" />
              </div>
              <h5 class="mb-2">Dokumentasi Lengkap</h5>
              <p class="features-icon-description">
                Panduan jelas dan contoh kode lengkap untuk memudahkan Anda memulai.
              </p>
            </div>
          </div> --}}

           <!-- Grid Layanan -->
    <div class="row gy-5 text-center">
      <!-- Strategi & Perencanaan IT -->
      <div class="col-md-6 col-lg-4">
        <div class="mb-3">
                    <i class="ri-road-map-line ri-42px text-primary"></i>

        </div>
        <h5 class="fw-semibold mb-3">Strategi & Perencanaan IT</h5>
        <ul class="list-unstyled text-start d-inline-block">
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Audit & Analisis Kebutuhan IT</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Penyusunan Rencana Strategis</li>
          <li><i class="ri-check-line text-success me-2"></i> Evaluasi Vendor & Teknologi</li>
        </ul>
      </div>

      <!-- Pengembangan Perangkat Lunak -->
      <div class="col-md-6 col-lg-4">
        <div class="mb-3">
          <i class="ri-code-box-line ri-42px text-primary"></i>
        </div>
        <h5 class="fw-semibold mb-3">Pengembangan & Kustomisasi</h5>
        <ul class="list-unstyled text-start d-inline-block">
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Aplikasi Web Kustom</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Aplikasi Mobile (iOS & Android)</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Integrasi Sistem</li>
          <li><i class="ri-check-line text-success me-2"></i> Modernisasi Aplikasi</li>
        </ul>
      </div>

      <!-- Implementasi Proyek -->
      <div class="col-md-6 col-lg-4">
        <div class="mb-3">
          <i class="ri-projector-line ri-42px text-primary"></i>
        </div>
        <h5 class="fw-semibold mb-3">Implementasi & Manajemen Proyek</h5>
        <ul class="list-unstyled text-start d-inline-block">
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Manajemen End-to-End</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Implementasi Sistem Enterprise</li>
          <li><i class="ri-check-line text-success me-2"></i> Pelatihan & Adopsi Pengguna</li>
        </ul>
      </div>

      <!-- Keamanan IT -->
      <div class="col-md-6 col-lg-4">
        <div class="mb-3">
          <i class="ri-shield-check-line ri-42px text-primary"></i>
        </div>
        <h5 class="fw-semibold mb-3">Keamanan & Standar IT</h5>
        <ul class="list-unstyled text-start d-inline-block">
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Audit Keamanan</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Implementasi Solusi Keamanan</li>
          <li><i class="ri-check-line text-success me-2"></i> Kepatuhan Regulasi</li>
        </ul>
      </div>

      <!-- Solusi ERP -->
      <div class="col-md-6 col-lg-4">
        <div class="mb-3">
          <i class="ri-database-2-line ri-42px text-primary"></i>
        </div>
        <h5 class="fw-semibold mb-3">Solusi ERP Terintegrasi</h5>
        <ul class="list-unstyled text-start d-inline-block">
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Manajemen Keuangan</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Manajemen Rantai Pasok</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Manajemen Produksi</li>
          <li><i class="ri-check-line text-success me-2"></i> Manajemen SDM</li>
        </ul>
      </div>

      <!-- Konsultasi TI -->
      <div class="col-md-6 col-lg-4">
        <div class="mb-3">
          <i class="ri-customer-service-2-line ri-42px text-primary"></i>
        </div>
        <h5 class="fw-semibold mb-3">Konsultasi TI</h5>
        <ul class="list-unstyled text-start d-inline-block">
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Analisis Kebutuhan Bisnis</li>
          <li class="mb-2"><i class="ri-check-line text-success me-2"></i> Desain Arsitektur Sistem</li>
          <li><i class="ri-check-line text-success me-2"></i> Roadmap Transformasi Digital</li>
        </ul>
      </div>
    </div>
        </div>

      </section>
      <!-- Useful features: End -->

      <!-- Section WA Start -->
      <section>
        <div class="wa-off-hover" id="waOff" style="position: fixed; bottom: 2em; z-index: 1000;">
          <img src="images/wa-off-hover.png" alt="">
        </div>
        <div class="wa-on-hover" id="waOn" style="position: fixed; bottom: 2em; z-index: 1000; cursor: pointer;">
          <img src="images/wa-on-hover.png" alt="">
        </div>
      </section>
      <!-- Section WA End -->

      <!-- Ulasan Pelanggan: Start -->
      <section id="Portofolio" class="section-py bg-body landing-reviews">
        <div class="container">
          <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
            <img
              src="core-template/assets/img/front-pages/icons/section-tilte-icon.png"
              alt="ikon judul"
              class="me-3" />
            <span class="text-uppercase">Ulasan pelanggan</span>
          </h6>
          <h5 class="text-center mb-2"><span class="display-5 fs-4 fw-bold">Cerita sukses</span> dari klien kami</h5>
          <p class="text-center fw-medium mb-4 mb-md-12">Lihat bagaimana solusi kami membantu bisnis tumbuh dan berkembang.</p>
        </div>

        <div class="swiper-reviews-carousel overflow-hidden mb-12 pt-4">
          <div class="swiper" id="swiper-reviews">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8">
                    <div class="mb-4">
                      <img
                        src="core-template/assets/img/front-pages/branding/adv.png"
                        alt="logo klien"
                        class="client-logo img-fluid" />
                    </div>
                    <h6>
                      “Saya belum pernah menggunakan sistem yang sefleksibel dan seterintegrasi seperti solusi dari Motiva.
                      Sangat membantu dalam mengelola operasional bisnis.”
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Eka Santosa</h6>
                      <p class="mb-0 small">CEO Advista Group</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8 h-100">
                    <div class="mb-4">
                      <img
                        src="core-template/assets/img/front-pages/branding/ats.png"
                        alt="logo klien"
                        class="client-logo img-fluid" />
                    </div>
                    <h6>
                      Semua kebutuhan pengelolaan data bisnis sudah terpenuhi, sistemnya sangat memudahkan untuk pengambilan keputusan yang cepat dan akurat.
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-half-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Sarah Anjani</h6>
                      <p class="mb-0 small">Founder Atlas Konsultan</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 3 -->
              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8 h-100">
                    <div class="mb-4">
                      <img src="core-template/assets/img/front-pages/branding/pingu.png" alt="logo klien" class="client-logo img-fluid" />
                    </div>
                    <h6>
                      Platform ini mengubah cara kami menangani pengajuan dan verifikasi. Proses yang sebelumnya memakan waktu berhari-hari, kini selesai dalam hitungan menit.
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Yudha Pratama</h6>
                      <p class="mb-0 small">COO Pingu Finance</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 4 -->
              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8 h-100">
                    <div class="mb-4">
                      <img src="core-template/assets/img/front-pages/branding/pb.png" alt="logo klien" class="client-logo img-fluid" />
                    </div>
                    <h6>
                      Fitur analitiknya luar biasa. Kami bisa melihat data real-time dan membuat keputusan strategis lebih cepat dari sebelumnya.
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-half-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Dian Lestari</h6>
                      <p class="mb-0 small">Direktur PB Group</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 5 -->
              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8 h-100">
                    <div class="mb-4">
                      <img src="core-template/assets/img/front-pages/branding/kmm.png" alt="logo klien" class="client-logo img-fluid" />
                    </div>
                    <h6>
                      Kami berhasil memangkas biaya operasional hingga 30% setelah menerapkan sistem ini. Solusi yang benar-benar relevan dan efisien!
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Sigit Harjo</h6>
                      <p class="mb-0 small">Manager Operasional KMM</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 6 -->
              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8 h-100">
                    <div class="mb-4">
                      <img src="core-template/assets/img/front-pages/branding/kds.png" alt="logo klien" class="client-logo img-fluid" />
                    </div>
                    <h6>
                      Support tim Motiva sangat responsif dan solutif. Kami merasa tidak hanya membeli produk, tapi juga mendapat mitra strategis.
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Ratih Anggraini</h6>
                      <p class="mb-0 small">CEO Karya Digital Sejahtera</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 7 -->
              <div class="swiper-slide">
                <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8 h-100">
                    <div class="mb-4">
                      <img src="core-template/assets/img/front-pages/branding/gr.png" alt="logo klien" class="client-logo img-fluid" />
                    </div>
                    <h6>
                      Kami bisa fokus pada pengembangan bisnis karena proses administrasi kini berjalan otomatis. Sangat direkomendasikan!
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-half-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Andi Gunawan</h6>
                      <p class="mb-0 small">Owner GR Enterprise</p>
                    </div>
                  </div>
                </div>
              </div>


            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

        <div class="container">
          <div class="swiper-logo-carousel pt-lg-4 mt-12">
            <div class="swiper" id="swiper-clients-logos">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/adv.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/adv.png"
                    data-app-dark-img="front-pages/branding/adv.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/ats.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/ats.png"
                    data-app-dark-img="front-pages/branding/ats.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/pingu.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/pingu.png"
                    data-app-dark-img="front-pages/branding/pingu.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/pb.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/pb.png"
                    data-app-dark-img="front-pages/branding/pb.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/kmm.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/kmm.png"
                    data-app-dark-img="front-pages/branding/kmm.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/kds.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/kds.png"
                    data-app-dark-img="front-pages/branding/kds.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="core-template/assets/img/front-pages/branding/gr.png"
                    alt="logo klien"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/gr.png"
                    data-app-dark-img="front-pages/branding/gr.png" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Ulasan Pelanggan: End -->



      <!-- Fun facts: Start -->
      <section id="landingFunFacts" class="section-py landing-fun-facts py-12 my-4">
        <div class="container">
          <div class="row gx-0 gy-6 gx-sm-6">
            <div class="col-md-3 col-sm-6 text-center">
              <span class="badge rounded-pill bg-label-hover-primary fun-facts-icon mb-6 p-5">
                <i class="tf-icons ri-user-smile-line ri-42px"></i>
              </span>
              <h2 class="fw-bold mb-0 fun-facts-text">20+</h2>
              <h6 class="mb-0 text-body">Klien Aktif</h6>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
              <span class="badge rounded-pill bg-label-hover-danger fun-facts-icon mb-6 p-5">
                <i class="tf-icons ri-time-line ri-42px"></i>
              </span>
              <h2 class="fw-bold mb-0 fun-facts-text">7+</h2>
              <h6 class="mb-0 text-body">Tahun Pengalaman</h6>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
              <span class="badge rounded-pill bg-label-hover-warning fun-facts-icon mb-6 p-5">
                <i class="tf-icons ri-check-double-line ri-42px"></i>
              </span>
              <h2 class="fw-bold mb-0 fun-facts-text">50+</h2>
              <h6 class="mb-0 text-body">Proyek Terselesaikan</h6>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
              <span class="badge rounded-pill bg-label-hover-success fun-facts-icon mb-6 p-5">
                <i class="tf-icons ri-team-line ri-42px"></i>
              </span>
              <h2 class="fw-bold mb-0 fun-facts-text">20+</h2>
              <h6 class="mb-0 text-body">Tim Profesional</h6>
            </div>
          </div>
        </div>
      </section>
      <!-- Fun facts: End -->

      <!-- Contact Us: Start -->
      <section id="HubungiKami" class="section-py bg-body landing-contact">
        <div class="container bg-icon-left position-relative">
          <img
            src="core-template/assets/img/front-pages/icons/bg-left-icon-light.png"
            alt="section icon"
            class="position-absolute top-0 start-0"
            data-speed="1"
            data-app-light-img="front-pages/icons/bg-left-icon-light.png"
            data-app-dark-img="front-pages/icons/bg-left-icon-dark.png" />
          <h6 class="text-center d-flex justify-content-center align-items-center mb-6">
            <img
              src="core-template/assets/img/front-pages/icons/section-tilte-icon.png"
              alt="section title icon"
              class="me-3" />
            <span class="text-uppercase">Hubungi Kami</span>
          </h6>
          <h5 class="text-center mb-2"><span class="display-5 fs-4 fw-bold">Solusi</span> untuk Kebutuhan Bisnis Anda</h5>
          <p class="text-center fw-medium mb-4 mb-md-12 pb-3">
            Ingin tahu lebih lanjut tentang produk kami? Tim kami siap membantu bisnis Anda berkembang.
          </p>
          <div class="row gy-6">
            <div class="col-lg-5">
              <div class="card h-100">
                <div class="bg-primary rounded-4 text-white card-body p-8">
                  <p class="fw-medium mb-1_5 tagline">Konsultasikan kebutuhan Anda</p>
                  <h4 class="text-white mb-5 title">Kami bantu Anda memilih solusi yang paling sesuai.</h4>
                  <img
                    src="core-template/assets/img/front-pages/landing-page/let’s-contact.png"
                    alt="let’s contact"
                    class="w-100 mb-5" />
                  <p class="mb-0 description">
                    Ingin sistem yang fleksibel, fitur tambahan, atau penyesuaian khusus? Kami hadir dengan tim berpengalaman yang siap membantu Anda.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="card">
                <div class="card-body">
                  <h5 class="mb-6">Sampaikan Pertanyaan Anda</h5>
                  <form>
                    <div class="row g-5">
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input type="text" class="form-control" id="basic-default-fullname" placeholder="Nama Lengkap" />
                          <label for="basic-default-fullname">Nama Lengkap</label>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            type="email"
                            class="form-control"
                            id="basic-default-email"
                            placeholder="Alamat Email Aktif" />
                          <label for="basic-default-email">Alamat Email</label>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-floating form-floating-outline">
                          <input type="number" class="form-control" id="basic-default-phone" placeholder="No. Telp/Whatsapp" />
                          <label for="basic-default-phone">Nomor Telepon</label>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-floating form-floating-outline">
                          <textarea
                            class="form-control h-px-250"
                            placeholder="Masukan Pesan Anda disini..."
                            aria-label="Message"
                            id="basic-default-message"></textarea>
                          <label for="basic-default-message">Pesan Anda</label>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Kirim Pesan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact Us: End -->
    </div>

    <!-- / Sections:End -->

    <!-- Footer: Start -->
    <footer class="landing-footer">
      <div class="footer-top position-relative overflow-hidden">
        <img
          src="core-template/assets/img/front-pages/backgrounds/footer-bg.png"
          alt="footer bg"
          class="footer-bg banner-bg-img" />
        <div class="container position-relative">
          <div class="row gx-0 gy-7 gx-sm-6 gx-lg-12">
            <div class="col-lg-5">
              <a href="#" class="app-brand-link mb-6">
                <span class="app-brand-logo demo me-2">
                  <span style="color: #666cff">
                                  <img src="{{ asset('images/logo/miegacoan.png') }}" alt="Mie Gacoan Logo" style="height: 40px; width: auto;">

                  </span>
                </span>
                <span class="app-brand-text demo footer-link fw-semibold ms-1">Mie Gacoan</span>
              </a>
              <p class="footer-text footer-logo-description mb-6">
                Sistem ERP Lengkap & Fleksibel 📊 yang Dirancang untuk Menyederhanakan Operasional Bisnis Anda.
              </p>
              <form>
                <div class="d-flex mt-2 gap-4">
                  <div class="form-floating form-floating-outline w-px-250">
                    <input type="text" class="form-control bg-transparent" id="newsletter-1" placeholder="Your email" />
                    <label for="newsletter-1">Subscribe to newsletter</label>
                  </div>
                  <button type="submit" class="btn btn-primary">Subscribe</button>
                </div>
              </form>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
              <h6 class="footer-title mb-4 mb-lg-6">Daftar Fitur</h6>
              <ul class="list-unstyled mb-0">
                <li class="mb-4">
                  <a href="#" class="footer-link">Software Manufaktur</a>
                </li>
                <li class="mb-4">
                  <a href="#" class="footer-link">Software Mobile</a>
                </li>
                <li class="mb-4">
                  <a href="#" class="footer-link">Software Garment</a>
                </li>
                <li class="mb-4">
                  <a href="#" class="footer-link">Software Finance</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
              <h6 class="footer-title mb-4 mb-lg-6">Pages</h6>
              <ul class="list-unstyled mb-0">
                <li class="mb-4">
                  <a href="{{ route('landing-page') }}#Beranda" class="footer-link">Beranda</a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('landing-page') }}#Layanan" class="footer-link">Layanan</a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('landing-page') }}#Portofolio" class="footer-link">Portofolio</a>
                </li>
                <li class="mb-4">
                  <a href="{{ route('landing-page') }}#HubungiKami" class="footer-link">Hubungi Kami</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-4">
              <h6 class="footer-title mb-4 mb-lg-6">Kata Mereka</h6>
              <p class="footer-text footer-logo-description mb-6">Baca bagaimana sistem kami membantu bisnis seperti milik Anda berkembang lebih cepat.</p>
              <a href="{{ route('landing-page') }}#Portofolio" class="footer-link text-primary">Lihat Testimoni</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer: End -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="core-template/assets/vendor/libs/popper/popper.js"></script>
    <script src="core-template/assets/vendor/js/bootstrap.js"></script>
    <script src="core-template/assets/vendor/libs/node-waves/node-waves.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="core-template/assets/vendor/libs/nouislider/nouislider.js"></script>
    <script src="core-template/assets/vendor/libs/swiper/swiper.js"></script>

    <!-- Main JS -->
    <script src="core-template/assets/js/front-main.js"></script>

    <!-- Page JS -->
    <script src="core-template/assets/js/front-page-landing.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        let showWa = false;
        const waOff = document.getElementById('waOff');
        const waOn = document.getElementById('waOn');

        const waNumber = {{ env("NO_WHATSAPP" )}};

        const toggleWaMenu = () => {
          if (showWa) {
            // Tampilkan waOn, sembunyikan waOff
            waOn.classList.remove('hide-wa-menu');
            waOn.classList.add('show-wa-menu');
            waOff.classList.remove('show-wa-menu');
            waOff.classList.add('hide-wa-menu');
          } else {
            // Tampilkan waOff, sembunyikan waOn
            waOff.classList.remove('hide-wa-menu');
            waOff.classList.add('show-wa-menu');
            waOn.classList.remove('show-wa-menu');
            waOn.classList.add('hide-wa-menu');
          }
        };

        // Saat mouse masuk ke waOff → tampilkan waOn
        waOff.addEventListener('mouseenter', () => {
          showWa = true;
          toggleWaMenu();
        });

        // Saat mouse keluar dari waOn → kembali ke waOff
        waOn.addEventListener('mouseleave', () => {
          showWa = false;
          toggleWaMenu();
        });

        // Klik ikon waOn untuk redirect ke WhatsApp
        waOn.addEventListener('click', () => {
          if (waNumber) {
            window.open(`https://api.whatsapp.com/send?phone=${waNumber}`, '_blank');
          }
        });

        // Set awal tampilan (waOff muncul)
        toggleWaMenu();
      });
    </script>
  </body>
</html>
