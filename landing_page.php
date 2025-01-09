<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = htmlspecialchars($_POST['name']);
      $message = htmlspecialchars($_POST['message']);
      
      $text = "Halo nama saya " . $name . ", ingin menyampaikan suatu pesan yaitu: " . $message;

      $encoded_text = urlencode($text);

      header("Location: https://api.whatsapp.com/send?phone=6283192655757&text=$encoded_text"); 
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alzi Petshop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      scroll-padding-top: 60px;
    }

    body {
      line-height: 1.6;
    }

    header {
      position: relative;
      background: url('imgs/landing.jpg') no-repeat center center/cover;
      height: 100vh;
      color: white;
      text-align: center;
    }

    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }

    .header-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      width: 100%;
      max-width: 100%;
      padding: 0 20px;
    }

    .header h1 {
      font-size: 1.7rem;
    }

    .header p {
      font-size: 0.8rem;
    }

    .header a.btn {
      display: inline-block;
      padding: 10px 20px;
      color: white;
      border: 2px #ff6347 solid;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .header a.btn:hover {
      background: #ff6347;
    }

    .about p {
      text-align: justify;
      padding: 10px 20px;
      text-indent: 30px;
    }

    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.2);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      z-index: 3;
      padding: 10px 10px;
      backdrop-filter: blur(10px);
    }

    .navbar ul {
      display: flex;
      justify-content: space-between;
      align-items: center;
      list-style: none;
    }

    .nav-link {
      color: black;
      text-shadow: 0 0 4px rgba(255, 255, 255, 0.5);
      font-weight: bold;
    }

    .navbar .nav-link {
      text-decoration: none;
    }

    .navbar {
      color: white;
    }

    .navbar .brand-name {
      font-size: 1.3rem;
      font-weight: bold;
      color: black;
    }

    .section {
      padding: 60px 20px;
      background: #f4f4f4;
      text-align: center;
    }

    .section:nth-child(even) {
      background: #e8e8e8;
    }

    .container {
      margin: 0 auto;
    }

    .services, .produk {
      display: flex;
      justify-content: space-around;
      gap: 20px;
    }

    .service img, .produk img {
      width: 100%;
      max-width: 300px;
      border-radius: 10px;
    }

    .produk {
      display: flex;
      flex-wrap: wrap;
      justify-content: center; /* Gambar berada di tengah jika hanya ada satu gambar */
      gap: 20px;
    }

    .produk img {
      width: 100%;
      max-width: 45%;
      border-radius: 10px;
      transition: transform 0.3s;
    }

    .produk img:hover {
      transform: translateY(-10px);
    }

    @media (min-width: 768px) {
      .header h1 {
        font-size: 2.5rem;
      }

      .header p {
        font-size: 1.2rem;
      }

      .about p {
        padding: 10px 70px;
      }

      .produk {
        justify-content: center; /* Gambar tetap terpusat di layar besar */
        margin: 0 auto; /* Pastikan margin di kedua sisi kontainer gambar */
        padding: 0; /* Menghapus padding yang tidak diinginkan */
      }

      .produk img {
        max-width: 30%; /* Gambar akan lebih kecil di layar besar */
      }
    }

    footer {
      background: #333;
      color: white;
      text-align: center;
      padding: 10px 0;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      color: white;
      border: 1px #ff6347 solid;
      text-decoration: none;
      border-radius: 5px;
      
    }

    .reveal {
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.5s ease;
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top transparent-navbar">
    <div class="container">
      <a class="navbar-brand brand-name" href="#home">Alzi Petshop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">Tentang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#product">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Kontak</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="login/login_form.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="home">
    <header class="header">
      <div class="header-content">
        <h1>Selamat Datang di Alzi Petshop</h1>
        <p>Menyediakan kebutuhan terbaik untuk hewan peliharaan Anda.</p>
        <a href="#about" class="btn">Lebih Lanjut</a>
      </div>
    </header>
  </section>

  <section id="about" class="section">
    <div class="about reveal">
      <h2>Tentang Kami</h2>
      <p>Alzi Petshop adalah toko yang telah beroperasi dengan penuh dedikasi selama lebih dari 4 tahun, berfokus untuk menyediakan segala kebutuhan bagi hewan peliharaan, khususnya kucing. Sejak pertama kali dibuka, kami berkomitmen untuk memberikan produk-produk berkualitas tinggi yang tidak hanya memenuhi standar kesehatan dan kenyamanan hewan peliharaan, tetapi juga mendukung gaya hidup mereka. Kami menawarkan berbagai macam produk, mulai dari makanan bergizi yang diformulasikan khusus untuk berbagai jenis kucing, aksesoris lucu dan fungsional, peralatan yang diperlukan untuk merawat kucing kesayangan, hingga perlengkapan kebersihan yang praktis dan efektif. Tidak hanya itu, kami juga menyediakan obat-obatan yang dapat membantu menjaga kesehatan kucing, termasuk vitamin, obat cacing, dan produk-produk perawatan lainnya.</p>
      <p>Alzi Petshop selalu berusaha untuk menghadirkan berbagai inovasi dan produk terbaru guna memenuhi kebutuhan pemilik kucing yang beragam. Kami bekerja sama dengan berbagai pemasok terpercaya untuk memastikan setiap produk yang kami jual memiliki kualitas terbaik dan aman untuk kucing Anda. Dengan pengalaman yang kami miliki selama 4 tahun, kami selalu mendengarkan feedback dari pelanggan dan berusaha untuk memberikan pelayanan yang terbaik, mulai dari konsultasi tentang perawatan kucing hingga rekomendasi produk yang sesuai dengan kebutuhan spesifik hewan peliharaan Anda. Kami berkomitmen untuk menjadi tempat yang dapat diandalkan oleh para pemilik kucing, karena kami percaya bahwa kucing adalah bagian dari keluarga yang patut mendapatkan perhatian dan perawatan terbaik.</p>
    </div>
  </section>

  <section id="product" class="section">
    <div class="container reveal">
      <h2 class="mb-4">Produk Kami</h2>
      <a href="login/login_form.php">
        <div class="produk">
          <img src="imgs/lezato.jpeg" alt="">
          <img src="imgs/kandang.jpg" alt="">
          <img src="imgs/kalung.jpg" alt="">
        </div>
      </a>
    </div>
  </section>

  <section id="contact" class="section">
    <div class="container reveal">
      <h2 class="mb-4">Hubungi Kami</h2>
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm border-light">
            <div class="card-body text-center m-3">
              <i class="bi bi-geo-alt-fill fs-2 text-primary"></i>
              <h5 class="card-title">Alamat</h5>
              <p class="card-text">Perum. Patra Sriwijaya FD No.11, Kota Palembang</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm border-light">
            <div class="card-body text-center m-3">
              <i class="bi bi-envelope-fill fs-2 text-primary"></i>
              <h5 class="card-title">Email</h5>
              <p class="card-text">contact@alzipetshop.com</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm border-light">
            <div class="card-body text-center m-3">
              <i class="bi bi-telephone-fill fs-2 text-primary"></i>
              <h5 class="card-title">Telepon</h5>
              <p class="card-text">0831 6107 6087</p>
            </div>
          </div>
        </div>
      </div>

      <div class="contact-form mt-5">
        <h3 class="text-center mb-4">Kirim Pesan</h3>
        <form action="landing_page.php" method="POST">
          <div class="row" style="margin: 0 auto;">
            <div class="col-12 mb-3" style="margin: 0 auto;">
              <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" required>
            </div>
            <div class="col-12 mb-3" style="margin: 0 auto;">
              <textarea class="form-control" id="message" name="message" rows="4" placeholder="Pesan Anda" required></textarea>
            </div>
            <div class="col-12" style="margin: 0 auto;">
              <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <footer class="footer pt-4">
    <p>Create by Alzi Petshop | &copy 2024</p>
  </footer>

  <script>
    document.addEventListener("scroll", () => {
      const reveals = document.querySelectorAll(".reveal");
      const windowHeight = window.innerHeight;

      reveals.forEach((el) => {
        const revealTop = el.getBoundingClientRect().top;
        const revealBottom = el.getBoundingClientRect().bottom;

        if (revealTop < windowHeight - 100 && revealBottom > 100) {
          el.classList.add("active");
        } else {
          el.classList.remove("active");
        }
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>
</html>
