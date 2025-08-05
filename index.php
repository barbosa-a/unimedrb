<?php
  $seguranca = true;  
  include_once "./gerenciar-site/config/config.php";
  include_once "./gerenciar-site/config/conexao.php";
  include_once "./gerenciar-site/lib/lib_site.php";

  $contato = contatos($conn);
  $redesocial = redesSociais($conn);
  $banner = bannerSingle($conn);
  $info1 = ads($conn, 'Anúncio 01');
  $info2 = ads($conn, 'Anúncio 02');
  $info3 = ads($conn, 'Anúncio 03');
  $sobre = sobre($conn);
  $sobreImg = sobreBannerSingle($conn);
  $destaque = destaque($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Unimed Rio Branco - Conheça o Plano Participativo</title>
  <meta name="description" content="O plano Participativo é o produto ideal para quem procura uma assistência médica de qualidade, com 86% de satisfação pelos clientes.
  Com ele, você garante acesso completo a todos os nossos serviços, pagando uma mensalidade reduzida e coparticipação somente quando o plano for utilizado.
  Um plano de saúde que permite mais controle financeiro e economia para você, sua família e seus colaboradores.
  ">
  <meta name="keywords" content="Unimedrb, Unimed Rio Branco, Plano de saúde, plano corporativo">

  <!-- Favicons -->
  <link href="assets/img/favicon-unimed.png" rel="icon">
  <link href="assets/img/favicon-unimed.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Unimed Rio Branco
  * Template URL: https://plano.unimedrb.com.br
  * Updated: 04/08/2025
  * Author: Company cloud
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:<?php echo $contato['enderecoEmail'] ?>" target="_blank"><?php echo $contato['enderecoEmail'] ?></a></i>
          <i class="bi bi-whatsapp d-flex align-items-center ms-4"><a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $contato['numeroWpp']); ?>" target="_blank"><span><?php echo $contato['numeroWpp'] ?></span></a></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <?php echo $redesocial['status_facebook'] == 'Ativo' ? '<a href="'.$redesocial['facebook'].'" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>' : '' ?>
          <?php echo $redesocial['status_instagram'] == 'Ativo' ? '<a href="'.$redesocial['instagram'].'" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>' : '' ?>
          <?php echo $redesocial['status_linkedin'] == 'Ativo' ? '<a href="'.$redesocial['linkedin'].'" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>' : '' ?>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="assets/img/unimed.png" alt=""> 
          <!--<h1 class="sitename">Medilab</h1>-->
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#home" class="active">Home<br></a></li>
            <li><a href="#unimed">Quem somos</a></li>
            <li><a href="#empreendedor">Empreendedor</a></li>
            <li><a href="#services">Vantagens</a></li>            
            <li><a href="#faq">FAQ</a></li>
            <li><a href="#contact">Contato</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="#appointment">Faça uma simulação</a>

      </div>

    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="home" class="hero section light-background">

      <img src="<?php echo pg . $banner['arquivo'] ?>" alt="Imagem" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2><?php echo $banner['titulo'] ?></h2>
          <p><?php echo $banner['obs'] ?></p>
        </div><!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3><?php echo $banner['card_titulo'] ?></h3>
              <p>
                <?php echo $banner['card_desc'] ?>
              </p>
              <div class="text-center">
                <a href="#appointment" class="more-btn"><span>Faça uma simulação</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4><?php echo $info1['titulo'] ?></h4>
                    <p><?php echo $info1['legenda'] ?></p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-heart-pulse-fill"></i>
                    <h4><?php echo $info2['titulo'] ?></h4>
                    <p><?php echo $info2['legenda'] ?></p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                    <i class="bi bi-building-fill"></i>
                    <h4><?php echo $info3['titulo'] ?></h4>
                    <p><?php echo $info3['legenda'] ?></p>
                  </div>
                </div><!-- End Icon Box -->

              </div>
            </div>
          </div>
        </div><!-- End  Content-->

      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="unimed" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="<?php echo pg . $sobreImg['arquivo'] ?>" class="img-fluid" alt="Imagem">
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3><?php echo $sobre['titulo'] ?></h3>
            <?php echo $sobre['sobre'] ?>
            
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="empreendedor" class="stats section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 gx-5">          

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3><?php echo $destaque['titulo'] ?></h3>
            <?php echo $destaque['descricao'] ?>
            
          </div>

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="<?php echo pg . $destaque['arquivo'] ?>" class="img-fluid" alt="Imagem">
          </div>

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Vantagem</h2>
        <p>Vantagens exclusivas para saúde</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
              <div class="icon">
                <i class="fas fa-credit-card"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Desconto</h3>
              </a>
              <p>Desconto nas principais redes de farmácia da região</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-heartbeat"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Saúde</h3>
              </a>
              <p>Plataforma que reúne ferramentas para promover o autocuidado e a saúde emocional.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-ambulance"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Urgência</h3>
              </a>
              <p>Atendimento de urgência e emergência em todo o território nacional.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-user-md"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Consultas</h3>
              </a>
              <p>Consultas online por telemedicina.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-hospital"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Unidades</h3>
              </a>
              <p>Unidades próprias com serviços com selo de qualidade.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-hospital-user"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Atendimento</h3>
              </a>
              <p>Atendimento 24h para orientações.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->

    <!-- Appointment Section -->
    <section id="appointment" class="appointment section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Faça uma simulação</h2>
        <p>Preencha o formulário e faça seu cadastro para CNPJ</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form id="formDataSimulacao" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group mt-3">
              <label for="Qual cidade reside">Qual cidade reside</label>
              <select name="city" id="city" class="form-select" required="">
                <option value="">Selecione um município</option>
                <option value="Acrelândia">Acrelândia</option>
                <option value="Assis Brasil">Assis Brasil</option>
                <option value="Brasiléia">Brasiléia</option>
                <option value="Bujari">Bujari</option>
                <option value="Capixaba">Capixaba</option>
                <option value="Cruzeiro do Sul">Cruzeiro do Sul</option>
                <option value="Epitaciolândia">Epitaciolândia</option>
                <option value="Feijó">Feijó</option>
                <option value="Jordão">Jordão</option>
                <option value="Mâncio Lima">Mâncio Lima</option>
                <option value="Manoel Urbano">Manoel Urbano</option>
                <option value="Marechal Thaumaturgo">Marechal Thaumaturgo</option>
                <option value="Plácido de Castro">Plácido de Castro</option>
                <option value="Porto Acre">Porto Acre</option>
                <option value="Porto Walter">Porto Walter</option>
                <option value="Rio Branco">Rio Branco</option>
                <option value="Rodrigues Alves">Rodrigues Alves</option>
                <option value="Santa Rosa do Purus">Santa Rosa do Purus</option>
                <option value="Senador Guiomard">Senador Guiomard</option>
                <option value="Sena Madureira">Sena Madureira</option>
                <option value="Tarauacá">Tarauacá</option>
                <option value="Xapuri">Xapuri</option>
              </select>
            </div>
            <div class="col-md-6 form-group mt-3">
              <label for="Possui assistência médica?">Possui assistência médica?</label>
              <select name="assMed" id="assMed" class="form-select" required="">
                <option value="">Selecione...</option>
                <option value="Sim">Sim</option>
                <option value="Não">Não</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 form-group mt-3">
              <label for="Sexo">Sexo</label>
              <select name="sexo" id="sexo" class="form-select" required="">
                <option value="">Selecione...</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
              </select>
            </div>
            <div class="col-md-4 form-group mt-3">
              <label for="Faixa Etária">Faixa Etária</label>
              <select name="faixaEtaria" id="faixaEtaria" class="form-select" required="">
                <option value="">Selecione...</option>
                <option value="00 - 18">00 - 18</option>
                <option value="19 - 23">19 - 23</option>
                <option value="24 - 28">24 - 28</option>
                <option value="29 - 33">29 - 33</option>
                <option value="34 - 38">34 - 38</option>
                <option value="39 - 43">39 - 43</option>
                <option value="44 - 48">44 - 48</option>
                <option value="49 - 53">49 - 53</option>
                <option value="54 - 58">54 - 58</option>
                <option value="59+">59+</option>
              </select>
            </div>
            <div class="col-md-4 form-group mt-3">
              <label for="Quantidade">Quantidade</label>
              <input type="number" name="qtd" class="form-control" id="qtd" placeholder="Quantidade" required="" autocomplete="off">
            </div>
          </div>
          
          <div class="mt-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Sua solicitação de simulação foi enviada com sucesso. Obrigado!</div>
            <div class="text-center"><button type="button" id="btnViewModal" data-bs-toggle="modal" data-bs-target="#mdSimulacao" disabled>Faça uma simulação</button></div>
          </div>
        </form>

      </div>

      <!-- Modal cadastrar simulação -->
      <div class="modal fade" id="mdSimulacao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Preencha o formulário para confirmar seu interesse</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="row g-3" id="formDataDadosPessoais">
                <div class="col-md-6">
                  <label for="Nome da empresa" class="form-label">Nome da empresa</label>
                  <input type="text" class="form-control" id="nomeEmpresa" name="nomeEmpresa" required>
                </div>
                <div class="col-md-6">
                  <label for="CNPJ" class="form-label">CNPJ</label>
                  <input type="number" class="form-control" id="cnpf" name="cnpj" required>
                </div>
                <div class="col-12">
                  <label for="E-mail" class="form-label">E-mail</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="E-mail principal" required>
                </div>
                <div class="col-md-6">
                  <label for="Nome Contato" class="form-label">Nome Contato</label>
                  <input type="text" class="form-control" id="nomeContato" name="nomeContato" placeholder="Nome completo" required>
                </div>
                <div class="col-md-6">
                  <label for="Telefone" class="form-label">Telefone</label>
                  <input type="number" class="form-control" id="tel" name="tel" placeholder="Número com DDD" required>
                </div>
                
                <div class="col-12">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-green" id="btnSendSimulacao">Enviar</button>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>

    </section><!-- /Appointment Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Perguntas frequentes</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <?php foreach (faq($conn) as $key => $faq) { ?>
              
                <div class="faq-item <?php echo $key == 0 ? "faq-active" : "" ?>">
                  <h3><?php echo $faq['pergunta'] ?></h3>
                  <div class="faq-content">
                    <p><?php echo $faq['resposta'] ?></p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

              <?php } ?>
              

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contato de Vendas</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-2"></div>

          <div class="col-lg-4">

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-whatsapp flex-shrink-0"></i>
              <div>
                <h3>Atendimento por WhatsApp</h3>
                <p>
                  <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $contato['numeroWpp']); ?>" target="_blank"><?php echo $contato['numeroWpp'] ?></a>
                </p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-4">

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Atendimento por E-mail</h3>
                <p>
                  <a href="mailto:<?php echo $contato['enderecoEmail'] ?>" target="_blank"><?php echo $contato['enderecoEmail'] ?></a>
                </p>
              </div>
            </div><!-- End Info Item -->

          </div><!-- End Contact Form -->

          <div class="col-lg-2"></div>

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Unimed Rio Branco</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Desensolvido por <a href="https://companycloud.com.br" target="_blank">Company Cloud</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>