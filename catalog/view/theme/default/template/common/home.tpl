<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Suluguni</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/x-icon" href="img/loog.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Place favicon.ico in the root directory -->

  <!-- CSS here -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/animate.min.css" />
  <link rel="stylesheet" href="css/magnific-popup.css" />
  <link rel="stylesheet" href="fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="font-flaticon/flaticon.css" />
  <link rel="stylesheet" href="css/dripicons.css" />
  <link rel="stylesheet" href="css/slick.css" />
  <link rel="stylesheet" href="css/meanmenu.css" />
  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <style>
    #translate_button {
      background-color: #4d504d !important;
      color: #f2eaea !important;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 15px;
      border-radius: 50px;
    }

    #translate_button:hover {
      background-color: #45a049 !important;
    }
  </style>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Suluguni",
    "url": "https://suluguni.com.ua",
    "logo": "https://suluguni.com.ua/img/loog.png"
  }
  </script>

  <script>
    function loadGoogleTranslate() {
      if (!document.getElementById('google_translate_script')) {
        var script = document.createElement('script');
        script.id = 'google_translate_script';
        script.type = 'text/javascript';
        script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateInit';
        document.body.appendChild(script);
      } else {
        googleTranslateInit();
      }
      document.getElementById('translate_button').style.display = 'none';
    }

    function googleTranslateInit() {
      if (!document.getElementById('google_translate_element').querySelector('.skiptranslate')) {
        new google.translate.TranslateElement({
          pageLanguage: 'uk',
          includedLanguages: 'ru,uk,ka,en',
          layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
      }
    }
  </script>

  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fff;
      margin: 20% auto;
      padding: 20px;
      border-radius: 10px;
      width: 80%;
      max-width: 400px;
      text-align: center;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
      font-size: 18px;
    }

    .close-btn {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close-btn:hover {
      color: #000;
    }
  </style>



</head>

<body>


  <nav id="top">
    <div class="container">

    </div>
  </nav>

  <!-- header -->
  <header class="header-area">

    <div id="header-sticky" class="menu-area">
      <div class="container">
        <div class="second-menu">
          <div class="row align-items-center">


            <!-- 1 main menu -->

            <div class="col-xl-8 col-lg-8 text-center">
              <div class="main-menu">
                <nav id="mobile-menu">
                  <p class="h6 delivery-text">
                    <a href="https://suluguni.com.ua/dostavka" class="delivery-link">БЕЗКОШТОВНА ДОСТАВКА ВІД 10 КГ</a>
                  </p>
                  <style>
                    @media (max-width: 992px) {
                      p.h6 {
                        display: none;
                      }
                    }
                  </style>

                  <ul>

                    <li class="zeroee">відео</a></li>

                    <li><a href="https://suluguni.com.ua/pro_nas.html">про нас</a></li>
                    </li>
                    <li class="has-sub">
                      <a href="#services">наша продукція</a>
                    </li>
                    <!-- <li class="has-sub"></li> -->
                    <li><a href="#about" class="scroll-btn" style="color: #50C878;">Чому саме ми?</a></li>

                    <li><a href="#footer">Контакти</a></li>
                    <li class="has-sub">
                      <a href="https://suluguni.com.ua/dostavka">Доставка</a>
                    </li>

                    <li><a href="blog.html">блог</a></li>

                    <li><a href="video.html">відео</a></li>


                    <li><a href="tel:+380979505099" class="delivery-link " style="color: #3399ff;">
                        <i>
                          <img src="/img/icon/result (3).png" alt="Kyivstar"
                            style="height: 30px; vertical-align: middle; margin-right: 5px;">
                        </i> +380979505099
                      </a>
                    </li>
                    <li><a href="tel:+380939505099" class="delivery-link" style="color: #c2b941;">
                        <i>
                          <img src="/img/icon/result (4).png" alt="Life"
                            style="height: 30px; vertical-align: middle; margin-right: 5px;">
                        </i> +380939505099
                      </a>
                    </li>
                    <li><a href="tel:+380669505099" class="delivery-link" style="color: #c02e2e;">
                        <i>
                          <img src="/img/icon/result (5).png" alt="Vodafone"
                            style="height: 30px; vertical-align: middle; margin-right: 5px;">
                        </i> +380669505099
                      </a>
                    </li>

                  </ul>

                </nav>
              </div>
            </div>

            <!-- 1 main menu end -->


            <!-- Переводчик -->
            <div id="google_translate_element">
              <button id="translate_button" onclick="loadGoogleTranslate()">Укр</button>
            </div>
            <div class="shippingmob">
              <p class="delivery-text">
                <span>БЕЗКОШТОВНА ДОСТАВКА ВІД g10 КГ</span>
              </p>
            </div>
            <div class="shipping">
              <p class="h5 delivery-text">
                <span>БЕЗКОШТОВНА ДОСТАВКА ВІД 10 КГ</span>

              </p>
              <style>
                /* По умолчанию скрываем на десктопе (шире 992px) */
                p.h5 {
                  display: none;
                }

                @media (min-width: 768px) and (max-width: 991.98px) {
                  p.h5 {
                    display: block;
                  }
                }
              </style>


            </div>

            <div class="col-12">
              <div class="mobile-menu"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- header-end -->
  <div class="container">
    <div class="row">
      <?php echo $column_left; ?>
      <?php if ($column_left && $column_right) { ?>
      <?php $class = 'col-sm-6'; ?>
      <?php } elseif ($column_left || $column_right) { ?>
      <?php $class = 'col-sm-9'; ?>
      <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
      <?php } ?>
      <div id="content" class="<?php echo $class; ?>">
        <?php echo $content_top; ?>
        <?php echo $content_bottom; ?>
      </div>
      <?php echo $column_right; ?>
    </div>
  </div>
  <!-- main-area -->
  <main>
    <!-- slider-area -->
    <section id="home" class="slider-area slider-four fix p-relative">
      <div>


        <div id="pc-slider" class="d-none d-xl-flex"
          style="position: relative; width: 100%; height: 800px; overflow: hidden;">
          <div class="single-slider slider-bg active-slide"
            style="background-image: url('img/slider/Slider1777laptop.jpg'); background-size: cover; background-position: center;">
          </div>
          <div class="single-slider slider-bg" style="background-image: url('/img/slider/3.jpg');"></div>
          <div class="single-slider slider-bg" style="background-image: url('/img/slider/4.jpg');"></div>
          <div class="single-slider slider-bg" style="background-image: url('/img/slider/6.jpg');"></div>

          <a href="https://suluguni.com.ua/" style="position: absolute; top: 20px; left: 20px; z-index: 10;">
            <img class="logoS" src="img/logo/LogoSuluguni.png" alt="logo" />
          </a>
        </div>


        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const pcSlides = document.querySelectorAll('#pc-slider .single-slider');
            let currentSlide = 0;

            if (pcSlides.length > 0) {
              // Показуємо перший слайд одразу
              pcSlides[currentSlide].classList.add('active-slide');

              // Через 4 секунди — переходимо до наступного слайду
              setTimeout(() => {
                pcSlides[currentSlide].classList.remove('active-slide');
                currentSlide = (currentSlide + 1) % pcSlides.length;
                pcSlides[currentSlide].classList.add('active-slide');

                // Далі звичайна зміна кожні 2 секунди
                setInterval(() => {
                  pcSlides[currentSlide].classList.remove('active-slide');
                  currentSlide = (currentSlide + 1) % pcSlides.length;
                  pcSlides[currentSlide].classList.add('active-slide');
                }, 10000);
              }, 12000); // перший слайд показується 4 секунди
            }
          });
        </script>



        <!-- LAPTOP -->

        <div id="laptop-slider" class="d-none d-lg-flex d-xl-none"
          style="position: relative; width: 100%; height: 500px; overflow: hidden;">

          <div class="single-slider slider-bg active-slide"
            style="background-image: url('img/slider/Slider1777laptop.jpg'); background-size: cover; background-position: center;">
          </div>



          <div class="single-slider slider-bg"
            style="background-image: url('img/slider/3.jpg'); background-size: cover; background-position: center;">
          </div>

          <div class="single-slider slider-bg"
            style="background-image: url('img/slider/4.jpg'); background-size: cover; background-position: center;">
          </div>



          <div class="single-slider slider-bg"
            style="background-image: url('img/slider/6.jpg'); background-size: cover; background-position: center;">
          </div>



          <a href="https://suluguni.com.ua/" style="position: absolute; top: 20px; left: 20px; z-index: 10;">
            <img class="logoS" src="img/logo/LogoSuluguni.png" alt="logo" />
          </a>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const laptopSlides = document.querySelectorAll('#laptop-slider .single-slider');
            let currentLaptop = 0;

            // Показати перший слайд одразу
            if (laptopSlides.length > 0) {
              laptopSlides[currentLaptop].classList.add('active-slide');

              // Затримка 4 сек для першого слайду
              setTimeout(() => {
                laptopSlides[currentLaptop].classList.remove('active-slide');
                currentLaptop = (currentLaptop + 1) % laptopSlides.length;
                laptopSlides[currentLaptop].classList.add('active-slide');

                // Потім кожні 2 секунди
                setInterval(() => {
                  laptopSlides[currentLaptop].classList.remove('active-slide');
                  currentLaptop = (currentLaptop + 1) % laptopSlides.length;
                  laptopSlides[currentLaptop].classList.add('active-slide');
                }, 10000);
              }, 12000); // 4 секунди на перший слайд
            }
          });
        </script>


        <!-- TABLET -->

        <div id="tablet-slider" class="d-none d-md-flex d-lg-none" style="position: relative;">
          <div class="single-slider slider-bg active-slide"
            style="background-image: url('img/slider/Slider1777tablet.jpg');">
          </div>


          <div class="single-slider slider-bg" style="background-image: url('img/slider/3.jpg');"></div>

          <div class="single-slider slider-bg" style="background-image: url('img/slider/4.jpg');"></div>

          <div class="single-slider slider-bg" style="background-image: url('img/slider/6.jpg');"></div>

          <div class="logo-wrapper" style="position: absolute; top: 20px; left: 20px; z-index: 10;">
            <a href="https://suluguni.com.ua/">
              <img class="logoS" src="img/logo/LogoSuluguni.png" alt="logo" />
            </a>
          </div>

          <div class="container" style="position: relative; z-index: 10;">
            <div class="row justify-content-center align-items-center">
              <div class="col-md-7">
                <div class="slider-content">
                  <div class="slider-btn mt-30">
                    <a href="#services" class="btn ss-btn active mr-15 smoth-scroll">
                      Наша продукція <i class="fal fa-long-arrow-right"></i>
                    </a>
                  </div>
                  <div class="slider-btn mt-30">
                    <a href="#about" class="btn ss-btn active mr-15 smoth-scroll">
                      Чому саме ми? <i class="fal fa-long-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-5"></div>
            </div>
          </div>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const tabletSlides = document.querySelectorAll('#tablet-slider .single-slider');
            let currentTablet = 0;

            if (tabletSlides.length > 0) {
              // Показуємо перший слайд
              tabletSlides[currentTablet].classList.add('active-slide');

              // Затримка 4 сек тільки для першого слайду
              setTimeout(() => {
                tabletSlides[currentTablet].classList.remove('active-slide');
                currentTablet = (currentTablet + 1) % tabletSlides.length;
                tabletSlides[currentTablet].classList.add('active-slide');

                // Потім звичайна зміна кожні 2 секунди
                setInterval(() => {
                  tabletSlides[currentTablet].classList.remove('active-slide');
                  currentTablet = (currentTablet + 1) % tabletSlides.length;
                  tabletSlides[currentTablet].classList.add('active-slide');
                }, 10000);
              }, 12000); // Пауза 4 сек на першому
            }
          });
        </script>

        <!-- mob -->

        <div id="mobile-slider" class="d-flex d-md-none"
          style="position: relative; width: 100%; height: 450px; overflow: hidden;">

          <!-- Слайд 1 -->
          <div class="single-slider slider-bg active-slide"
            style="background-image: url('img/slider/Slider1777tablet.jpg'); background-size: cover; background-position: center;">
            <div class="container">
              <div class="row justify-content-center align-items-center">
                <div class="col-12">
                  <div class="slider-content s-slider-content mt-60">
                    <div class="slider-btn-group d-flex mt-30">
                      <a href="#services" class="btn ss-btn active mr-15 smoth-scroll">Продукція
                        <i class="fal fa-long-arrow-right"></i>
                      </a>
                      <a href="#about" class="btn ss-btn active smoth-scroll">Про нас
                        <i class="fal fa-long-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Слайд 4 -->
          <div class="single-slider slider-bg"
            style="background-image: url('img/slider/3.jpg'); background-size: cover; background-position: center;">
          </div>

          <!-- Слайд 5 -->
          <div class="single-slider slider-bg"
            style="background-image: url('img/slider/4.jpg'); background-size: cover; background-position: center;">
          </div>



          <!-- Слайд 7 -->
          <div class="single-slider slider-bg"
            style="background-image: url('img/slider/6.jpg'); background-size: cover; background-position: center;">
          </div>



          <!-- <div class="logo-wrapper" style="position: absolute; top: 20px; left: 20px; z-index: 10;">
                    <a href="https://suluguni.com.ua/">
                      <img class="logoS" src="img/logo/LogoSuluguni.png" alt="logo" />
                    </a>
                  </div> -->

        </div>

        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('#mobile-slider .single-slider');
            let current = 0;
            const interval = 10000; // 5 секунд на слайд

            function showSlide(index) {
              slides.forEach(slide => slide.classList.remove('active-slide'));
              slides[index].classList.add('active-slide');
            }

            function nextSlide() {
              current = (current + 1) % slides.length;
              showSlide(current);
            }

            setInterval(nextSlide, interval);
          });
        </script>


        <!-- oooooooo -->
        <!-- іконки зліва пром бігл -->
        <div class="fixed-icons">
          <div class="vertical-text"><a href="https://suluguniko.com.ua/" class="vertical-text" target="_blank"
              rel="nofollow">МИ НА ПЛАТФОРМІ</a></div>
          <a href="https://suluguniko.com.ua/" target="_blank" rel="nofollow">
            <img src="/img/icon/result.png" alt="Prom.ua">
          </a>
          <a href="https://suluguniko.com.ua/" target="_blank" rel="nofollow">
            <img src="/img/icon/result2.png" alt="Bigl.ua">
          </a>

          <div class="vertical-text">
            <a href="https://suluguni.com.ua/dostavka" class="delivery-link">ЦІНИ ДЛЯ ОПТ. ПОКУПЦІВ</a>
          </div>

        </div>


        <!-- Іконки справа  -->
        <div class="fixed-icons-right">
          <!-- <div class="vertical-text"><a href="https://suluguniko.com.ua/" class="vertical-text" target="_blank"
              rel="nofollow">Ми на
              платформі</a></div> -->

          <a href="https://www.instagram.com/p/DHsqp3HooYI/?igsh=azFodTVqaWh5bXc3" target="_blank"
            rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50">
              <path fill="#E1306C"
                d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 5a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-2.75a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z" />
            </svg>
          </a>

          <a href="https://t.me/suluguniCOMua" target="_blank" rel="noopener noreferrer">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill="#0088cc"
                d="M9.44 14.97L9.16 19.55C9.62 19.55 9.83 19.34 10.06 19.11L12.31 17.1L16.81 20.38C17.69 20.86 18.28 20.62 18.51 19.58L21.92 4.62L21.93 4.61C22.2 3.46 21.56 2.98 20.71 3.29L2.53 10.44C1.43 10.86 1.44 11.46 2.31 11.73L7.17 13.26L17.73 6.44C18.22 6.12 18.66 6.29 18.27 6.62L9.44 14.97Z" />
            </svg>
          </a>



          <a href="viber://chat?number=%2B380955065488" target="_blank" rel="noopener noreferrer">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill="#7360F2"
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.5 13c-.27.63-1.14 1.4-2.04 1.46-.9.06-1.96-.44-3.22-1.5-1.26-1.06-2.04-2.18-2.5-3.03-.46-.85-.66-1.6-.67-2.06-.02-.46.09-.83.34-1.06.25-.23.61-.33 1.03-.17.42.16 1.43.72 1.73.87.3.15.5.23.58.38.08.15.08.29.02.43-.06.14-.25.45-.34.58-.09.13-.18.26-.26.34-.08.08-.16.18-.15.3.01.12.09.39.22.65.13.26.38.61.64.92.26.3.48.5.64.64.16.14.28.2.34.2.06 0 .14-.06.23-.14.09-.08.36-.41.44-.54.08-.13.18-.14.3-.1.12.04.78.37 1.1.52.32.15.46.23.52.34.06.11.06.67-.21 1.3z" />
            </svg>
          </a>

        </div>

        <!-- Каталог -->

        <section id="services" class="services-area services-bg p-relative fix pt-120bet pt-120 pb-90"
          style="background: #000">
          <div class="container">
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="section-title mb-50 wow fadeInLeft animated text-center" data-animation="fadeInLeft"
                  data-delay=".4s">
                  <h3>Наша продукція</h3>
                </div>
              </div>
              <!-- section1 -->
              <div class="container pt-120 pb-90">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-4">
                    <aside class="sidebar services-sidebar">
                      <div class="sidebar-widget categories">
                        <div class="widget-content">
                          <ul class="services-categories">
                            <li><a href="#Suluguni">Cулугуні</a></li>
                            <li><a href="#Maslosolod">Масло солодковершкове</a></li>



                            <li><a href="#Novinka">Новий асортимент (новинка)</a></li>
                          </ul>
                        </div>
                      </div>
                    </aside>
                  </div>


                  <div class="col-lg-8 col-md-12 col-sm-12">
                    <!-- section 1 -->
                    <section id="Suluguni" class="service-section">
                      <h2 class="cat-bottom">Сулугуні</h2>

                      <div class="row">
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".2s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/suluguni/syr-cheder" target="_blank"><img
                                  src="img/icon/0-02-05-3a2e6edc78b3ef2bf057709aec344b286e0b228e3072cade626d89dc29680841_f2c38315f2f2523d-500x500.jpg"
                                  alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/suluguni/syr-cheder" target="_blank">Чедер</a>
                              </h3>

                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center active mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".4s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/suluguni/mocarella-dlya-picy-hacharuri-naturalna"
                                target="_blank"><img
                                  src="img/icon/0-02-05-ec60883f9a58324aea5f62d5c56c5e977e5a9b537ec4f8251cf30818dbcb847a_34176660f60b3629-500x500.jpg"
                                  alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/suluguni/mocarella-dlya-picy-hacharuri-naturalna"
                                  target="_blank">Моцарелла</a>
                              </h3>

                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".6s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/suluguni/syr-suluguni-kopchenyj-naturalnyj"
                                target="_blank"><img
                                  src="img/icon/0-02-05-aa19e220587913fac9275901296de3117ca531db417bd94b982693e5854016bc_5d11e369d9cd6e14-500x500.jpg"
                                  alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/suluguni/syr-suluguni-kopchenyj-naturalnyj"
                                  target="_blank">Сулугуні</a>
                              </h3>

                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".8s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/suluguni/brynza-bila-naturalna-syr-imeretynskyj"
                                target="_blank"><img
                                  src="img/icon/0-02-05-e7b59084b595120461e0426bd597ec9a82b181d62d455232a4b6d6d78d77ed35_3612455678b9dc3c-500x500.jpg"
                                  alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/suluguni/brynza-bila-naturalna-syr-imeretynskyj"
                                  target="_blank">Бринза</a>
                              </h3>

                            </div>
                          </div>
                        </div>
                      </div>





                      <div class="slider-btn btncateg" data-animation="fadeInUp" data-delay=".4s">
                        <a href="https://suluguni.com.ua/Suluguni" target="_blank"
                          class="btn ss-btn active mr-15 smoth-scroll">переглянути всі <i
                            class="fal fa-long-arrow-right"></i></a>
                      </div>
                    </section>

                    <!-- section 2 -->

                    <section id="Maslosolod" class="service-section">
                      <h2 class="cat-bottom">Масло солодковершкове</h2>

                      <div class="row">
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".6s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/maslo-solodkovershkove/maslo-vershkove-naturalne-82-5-0-3gr"
                                target="_blank"><img src="img/icon/masloversh0.3.jpg" alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/maslo-solodkovershkove/maslo-vershkove-naturalne-82-5-0-3gr"
                                  target="_blank">Масло
                                  вершкове 82,5%
                                  (0,3гр)</a>
                              </h3>

                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".8s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/maslo-solodkovershkove/maslo-vershkove-82-5"
                                target="_blank"><img src="img/icon/5386722007137249770-500x500.jpg" alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/maslo-solodkovershkove/maslo-vershkove-82-5"
                                  target="_blank">МАСЛО
                                  ВЕРШКОВЕ 82.5%</a>
                              </h3>

                            </div>
                          </div>
                        </div>

                      </div>

                    </section>

                    <section id="Novinka" class="service-section">
                      <h2 class="cat-bottom">Новий асортимент (новинка)</h2>

                      <div class="row">
                        <div class="col-lg-3 col-md-6">
                          <div class="s-single-services text-center mb-30 wow fadeInUp animated"
                            data-animation="fadeInUp" data-delay=".2s">
                            <div class="services-icon">
                              <a href="https://suluguni.com.ua/syry-kozyni/syr-kozynyj-naturalnyj-vytrymka-1-6m"
                                target="_blank"><img src="img/icon/sirkoziniy.jpg" alt="img" /></a>
                            </div>
                            <div class="second-services-content">
                              <h3>
                                <a href="https://suluguni.com.ua/syry-kozyni/syr-kozynyj-naturalnyj-vytrymka-1-6m"
                                  target="_blank">Сир козиний</a>
                              </h3>

                            </div>
                          </div>
                        </div>

                      </div>

                    </section>
                  </div>
                </div>
              </div>
              <!-- newslater-aread-end -->
            </div>
        </section>

        <script>
          document.querySelectorAll('a[href="#services"]').forEach(link => {
            link.addEventListener('click', function (e) {
              e.preventDefault();
              const targetEl = document.querySelector('#services');

              if (targetEl) {
                const sectionTop = targetEl.getBoundingClientRect().top + window.scrollY;
                const offset = window.innerHeight / 3; // половина экрана
                window.scrollTo({
                  top: sectionTop - offset,
                  behavior: 'smooth'
                });
              }
            });
          });
        </script>
        <!-- services-three-area -->

        <!-- Про нас -->
        <section id="about" class="about-area about-p pt-120 pb-120 p-relative" style="background: #000">
          <div class="container">
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="about-title second-atitle pb-25">
                  <h5>Чому саме ми?</h5>

                </div>
                <h3>Сироваріння - наш фах і наше покликання ось уже 10 років </h3>
                <br>

                <div class="about-content3">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="green">
                        <li>
                          Виробництво розташоване у Вінницькій області, де сири створюються невеликими партіями задля
                          збереження максимальної
                          свіжості та стабільності смаку.
                        </li>
                        <li>
                          <strong style="color: rgb(205 186 186);">Свіже молоко</strong> - постачається як від місцевих
                          мешканців,
                          так і від перевірених фермерських
                          господарств
                          - забезпечує
                          неперевершений смак та якість нашої продукції (сулугуні, бринза, моцарела, класичне та
                          топлене
                          вершкове масло тощо).
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <br>
                <br>
                <br>

                <h3>Зроблено в Україні: оптимальне співвідношення ціни та якості</h3>
                <br>

                <div class="about-content3">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="green">
                        <li>
                          Нашу продукцію обирають за стабільно високу якість, натуральність і доступну ціну.
                        </li>
                        <li>
                          Свіже молоко, оригінальні рецепти та відсутність домішок - ось рецепт нашого успіху.
                        </li>
                        <li>Ми відкриті до співпраці як з <strong style="color: rgb(205 186 186);">великими
                            замовниками</strong>,
                          так і з індивідуальними сім'ями, які
                          цінують якісний та натуральний
                          український продукт.</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <br>
                <br>
                <br>

                <h3>Сири на будь-який смак!</h3>
                <br>

                <div class="about-content3">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="green">
                        <li>
                          Наш асортимент налічує більше 30-ти позицій, орієнтованих на різні види бізнесу: HoReCa,
                          виробництва, магазини та
                          приватні замовники.
                        </li>
                        <li>
                          Запрошуємо Вас особисто ознайомитись з різноманіттям нашої продукції, скориставшись цим
                          <a href="https://suluguni.com.ua/suluguni" style="color: #3399ff;">посиланням</a>.
                        </li>
                        <li>Компанія SulugunKo постійно працює над розширенням асортименту: на досягнутому ми не
                          зупиняємось!</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <br>




              <div class="col-lg-6 col-md-12 col-sm-12 pl-60">
                <div class="about-title second-atitle pb-25">
                  <h3>Доставка: оперативність та гнучкі механізми співпраці</h3>
                  <br>


                  <div class="about-content3">
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="green">
                          <li>
                            Дбаємо про свіжість та якість нашої продукції під час транспортування, тому оперативно
                            відправляємо замовлення Новою
                            Поштою по Україні, використовуючи вакуумне пакування та (за потреби) заморожування
                            продуктів.
                          </li>
                          <li>
                            У столиці діє наш <strong style="color: rgb(205 186 186);">власний Розподільчий
                              Центр</strong>, забезпечуючи оперативну та якісну логістику.
                            Окрім того, як виробники, ми
                            маємо можливість контролювати наявність продукції на складі, а отже - працювати без затримок
                            у постачанні.
                          </li>
                          <li>Для великих оптових замовлень (від 10 кг) по Києву та поблизу Києва <strong
                              style="color: rgb(205 186 186);">товар доставляється
                              безкоштовно</strong>
                            спеціалізованим рефрижератором. Для закладів HoReCa у Києві та поблизу Києва при замовленні
                            від 5 кг діють спеціальні
                            умови доставки.</li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <br>
                  <br>
                  <br>

                  <h3>Ми дбаємо, щоб досвід співпраці з нами був приємним, легким і, звісно, смачним!</h3>

                  <br>

                  <div class="about-content3">
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="green">
                          <li>
                            Ми не продаємо сир "аби продати", натомість допомагаємо своїм клієнтам зробити оптимальний
                            вибір з урахуванням
                            асортименту, ціни, доставки, адаптації об’ємів й фасування, рекомендацій щодо зберігання
                            тощо.
                          </li>
                          <li>
                            Для постійних клієнтів діють індивідуальні умови, <strong
                              style="color: rgb(205 186 186);">знижки</strong> та
                            консультації напряму з сироваром.
                            та
                            консультації напряму з сироваром.
                          </li>



                          </li>


                        </ul>
                      </div>
                    </div>
                  </div>

                  <br>

                  <h3>Телефонуйте! Будемо раді поспілкуватись!</h3>


                  <div class="slider-btn mt-20">
                    <a href=" https://suluguni.com.ua/suluguni" class="btn ss-btn smoth-scroll">НАША ПРОДУКЦІЯ <i
                        class="fal fa-long-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <script>
          function scrollToAbout(offsetFraction = 0) {
            const targetEl = document.querySelector('#about');
            if (targetEl) {
              const sectionTop = targetEl.getBoundingClientRect().top + window.scrollY;
              const offset = window.innerHeight * offsetFraction;
              window.scrollTo({
                top: sectionTop - offset,
                behavior: 'smooth'
              });
            }
          }

          // 1. Обробка кліків всередині сторінки
          document.querySelectorAll('a[href="#about"]').forEach(link => {
            link.addEventListener('click', function (e) {
              e.preventDefault();
              scrollToAbout(1 / 3); // відступ — третина екрану
            });
          });

          // 2. Обробка переходу з іншої сторінки
          window.addEventListener('DOMContentLoaded', () => {
            if (window.location.hash === '#about') {
              setTimeout(() => {
                scrollToAbout(1 / 3);
              }, 100); // невелика затримка, щоб все завантажилось
            }
          });
        </script>

        <!-- <script>
          document.querySelectorAll('a[href="#about"]').forEach(link => {
            link.addEventListener('click', function (e) {
              e.preventDefault();
              const targetEl = document.querySelector('#about');

              if (targetEl) {
                const sectionTop = targetEl.getBoundingClientRect().top + window.scrollY;
                const offset = window.innerHeight / 3; // половина экрана
                window.scrollTo({
                  top: sectionTop - offset,
                  behavior: 'smooth'
                });
              }
            });
          });
        </script> -->
        <!-- about-area-end про нас-->


        <!-- gallery-area-end -->
  </main>
  <!-- main-area-end -->
  <!-- footer -->
  <footer id="footer" class="footer-bg footer-p" style="background: #131819">
    <div class="footer-top pt-70 pb-40">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-xl-3 col-lg-3 col-sm-6 logof">
            <div class="footer-widget mb-30">
              <div class="f-widget-title"><img src="img/logo/footerlogo.png" alt="img" />
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-sm-6">
            <div class="footer-widget mb-30">
              <div class="f-widget-title">
                <h2>Інформація</h2>
              </div>
              <div class="footer-link">
                <ul>
                  <li><a href="https://suluguni.com.ua">На початок</a></li>
                  <li><a href="https://suluguni.com.ua/pro_nas.html"> Про нас</a></li>
                  <li><a href="https://suluguni.com.ua/delivery"> Доставка </a></li>
                  <li><a href="#footer"> Контакти</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-xl-2 col-lg-2 col-sm-6">
            <div class="footer-widget mb-30">
              <div class="f-widget-title">
                <h2>Наші контакти</h2>
              </div>
              <div class="f-contact">
                <ul>

                  <li>
                    <i class="icon fal fa-phone"></i>
                    <span>+38066950-50-99<br /> </span>
                  </li>
                  <li>
                    <i class="icon fal fa-phone"></i>
                    <span>+38097950-50-99<br /> </span>
                  </li>
                  <li>
                    <i class="icon fal fa-phone"></i>
                    <span>+38093950-50-99<br /> </span>
                  </li>
                  <li>
                    <i class="icon fal fa-envelope"></i>
                    <span style="font-size: 10px;">
                      <a href="gourmet044@gmail.com">suluguni.com.ua@gmail.com</a>
                    </span>
                  </li>
                  <li>
                    <i class="icon fal fa-map-marker-check"></i>
                    <span>РЦ м.Київ, 02000,<br />
                      м. Васильківська</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-sm-6">
            <div class="footer-widget mb-30">
              <div class="f-widget-title">
                <h2>швидкий звязок</h2>
              </div>
              <div class="f-contact">
                <ul>
                  <li>
                    <a href="https://www.instagram.com/p/DHsqp3HooYI/?igsh=azFodTVqaWh5bXc3" target="_blank"
                      rel="noopener noreferrer">
                      <style>
                        .instagram-icon {
                          width: 54px;
                          height: 54px;
                        }
                      </style>
                      <svg class="instagram-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                          <linearGradient id="instaGradientMobile" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#f09433" />
                            <stop offset="25%" stop-color="#e6683c" />
                            <stop offset="50%" stop-color="#dc2743" />
                            <stop offset="75%" stop-color="#cc2366" />
                            <stop offset="100%" stop-color="#bc1888" />
                          </linearGradient>
                        </defs>
                        <path fill="url(#instaGradientMobile)"
                          d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 5a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-2.75a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z" />
                      </svg>
                    </a>
                    <span>
                      <a href="https://www.instagram.com/p/DHsqp3HooYI/?igsh=azFodTVqaWh5bXc3" target="_blank"
                        rel="noopener noreferrer">Instagram</a>
                    </span>

                  </li>
                  <li>
                    <a href="https://t.me/suluguniCOMua" target="_blank" rel="noopener noreferrer">
                      <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#0088cc"
                          d="M9.44 14.97L9.16 19.55C9.62 19.55 9.83 19.34 10.06 19.11L12.31 17.1L16.81 20.38C17.69 20.86 18.28 20.62 18.51 19.58L21.92 4.62L21.93 4.61C22.2 3.46 21.56 2.98 20.71 3.29L2.53 10.44C1.43 10.86 1.44 11.46 2.31 11.73L7.17 13.26L17.73 6.44C18.22 6.12 18.66 6.29 18.27 6.62L9.44 14.97Z" />
                      </svg>
                    </a>
                    <span>
                      <a href="https://t.me/suluguniCOMua" target="_blank" rel="noopener noreferrer">Telegram</a>
                    </span>

                  </li>
                  <li>
                    <a href="viber://chat?number=%2B380955065488" target="_blank" rel="noopener noreferrer">
                      <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#7360F2"
                          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.5 13c-.27.63-1.14 1.4-2.04 1.46-.9.06-1.96-.44-3.22-1.5-1.26-1.06-2.04-2.18-2.5-3.03-.46-.85-.66-1.6-.67-2.06-.02-.46.09-.83.34-1.06.25-.23.61-.33 1.03-.17.42.16 1.43.72 1.73.87.3.15.5.23.58.38.08.15.08.29.02.43-.06.14-.25.45-.34.58-.09.13-.18.26-.26.34-.08.08-.16.18-.15.3.01.12.09.39.22.65.13.26.38.61.64.92.26.3.48.5.64.64.16.14.28.2.34.2.06 0 .14-.06.23-.14.09-.08.36-.41.44-.54.08-.13.18-.14.3-.1.12.04.78.37 1.1.52.32.15.46.23.52.34.06.11.06.67-.21 1.3z" />
                      </svg>
                    </a>
                    <span>
                      <a href="viber://chat?number=%2B380955065488" target="_blank" rel="noopener noreferrer">Viber</a>
                    </span>

                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-sm-6">
            <div class="footer-widget mb-30">
              <div class="f-widget-title">
                <h2>ми в соц.мережах</h2>
              </div>
              <div class="f-contact">
                <ul>
                  <li>
                    <a href="https://www.instagram.com/p/DHsqp3HooYI/?igsh=azFodTVqaWh5bXc3" target="_blank"
                      rel="noopener noreferrer">
                      <svg width="50" height="50" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <style>
                          .instagram-icon {
                            width: 54px;
                            height: 54px;
                          }
                        </style>
                        <svg class="instagram-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <defs>
                            <linearGradient id="instaGradientMobile" x1="0%" y1="0%" x2="100%" y2="100%">
                              <stop offset="0%" stop-color="#f09433" />
                              <stop offset="25%" stop-color="#e6683c" />
                              <stop offset="50%" stop-color="#dc2743" />
                              <stop offset="75%" stop-color="#cc2366" />
                              <stop offset="100%" stop-color="#bc1888" />
                            </linearGradient>
                          </defs>
                          <path fill="url(#instaGradientMobile)"
                            d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 5a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-2.75a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z" />
                        </svg>
                    </a>
                    <span>
                      <a href="https://www.instagram.com/p/DHsqp3HooYI/?igsh=azFodTVqaWh5bXc3" target="_blank"
                        rel="noopener noreferrer">Instagram</a>
                    </span>
                  </li>

                  <li>
                    <a href="https://www.facebook.com/share/15R1jdB7SF/?mibextid=wwXIfr" target="_blank"
                      rel="noopener noreferrer">
                      <svg width="50" height="50" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#1877F2"
                          d="M22 12.07C22 6.55 17.52 2 12 2S2 6.55 2 12.07c0 5.02 3.66 9.18 8.44 9.93v-7.03H7.9v-2.9h2.54V9.64c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.23.2 2.23.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.86h2.78l-.44 2.9h-2.34v7.03C18.34 21.25 22 17.09 22 12.07z" />
                      </svg>
                    </a>
                    <span>
                      <a href="https://www.facebook.com/share/15R1jdB7SF/?mibextid=wwXIfr" target="_blank"
                        rel="noopener noreferrer">Facebook</a>
                    </span>
                  </li>
                  <li>
                    <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer">
                      <svg width="50" height="50" viewBox="0 0 24 24" fill="#FF0000" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 15l6-4-6-4v8zm12-3c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                      </svg>
                    </a>
                    <span>
                      <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer">YouTube</a>
                    </span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright-wrap">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">Copyright © 2025. All rights reserved.</div>
        </div>
      </div>
    </div>
  </footer>
  <!-- footer-end -->
  <!-- JS here -->
  <script src="js/vendor/modernizr-3.5.0.min.js"></script>
  <script src="js/vendor/jquery-3.6.0.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/one-page-nav-min.js"></script>
  <script src="js/slick.min.js"></script>
  <script src="js/ajax-form.js"></script>
  <script src="js/paroller.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/js_isotope.pkgd.min.js"></script>
  <script src="js/imagesloaded.min.js"></script>
  <script src="js/parallax.min.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/jquery.scrollUp.min.js"></script>
  <script src="js/jquery.meanmenu.min.js"></script>
  <script src="js/parallax-scroll.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/element-in-view.js"></script>
  <script src="js/main.js"></script>
  <!-- <script>
    window.onload = function () {
      // Показать окно через 3 секунды
      setTimeout(function () {
        const modal = document.getElementById("freeDeliveryModal");
        modal.style.display = "block";

        // Скрыть окно через 10 секунд после его появления
        setTimeout(function () {
          modal.style.display = "none";
        }, 10000); // 1000 мс = 10 секунд

      }, 1000); // Показываем через 3 секунды
    };

    document.addEventListener("DOMContentLoaded", function () {
      // Закрытие по крестику
      document.querySelector(".close-btn").onclick = function () {
        document.getElementById("freeDeliveryModal").style.display = "none";
      };

      // Закрытие при клике вне окна
      window.onclick = function (event) {
        const modal = document.getElementById("freeDeliveryModal");
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };
    });
  </script> -->
  <!-- <script>
    window.onload = function () {
      // Проверка: только если ширина экрана меньше 768px (мобильные устройства)
      if (window.innerWidth < 768) {
        // Показать окно через 3 секунды
        setTimeout(function () {
          const modal = document.getElementById("freeDeliveryModal");
          modal.style.display = "block";

          // Автоматически скрыть через 10 секунд
          setTimeout(function () {
            modal.style.display = "none";
          }, 10000); // 10 секунд

        }, 3000); // Показать через 3 секунды
      }
    };

    document.addEventListener("DOMContentLoaded", function () {
      // Закрытие по крестику
      document.querySelector(".close-btn").onclick = function () {
        document.getElementById("freeDeliveryModal").style.display = "none";
      };

      // Закрытие при клике вне окна
      window.onclick = function (event) {
        const modal = document.getElementById("freeDeliveryModal");
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };
    });
  </script> -->

  <!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modal = document.getElementById('freeDeliveryModal');
      var closeBtn = modal.querySelector('.close-btn');

      // Показати через 2 секунди
      setTimeout(function () {
        modal.style.display = 'block';

        // Закрити автоматично через 5 секунд після відкриття
        setTimeout(function () {
          modal.style.display = 'none';
        }, 5000);

      }, 2000);

      // Закрити по кліку на хрестик
      if (closeBtn) {
        closeBtn.onclick = function () {
          modal.style.display = 'none';
        };
      }

      // Закрити по кліку поза вікном
      window.onclick = function (e) {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      };
    });
  </script> -->
  <script>
    function getOffsetFraction() {
      // Якщо екран вузький — менший відступ
      return window.innerWidth <= 768 ? 1 / 5 : 1 / 3;
    }

    function scrollToAbout() {
      const targetEl = document.querySelector('#about');
      if (targetEl) {
        const sectionTop = targetEl.getBoundingClientRect().top + window.scrollY;
        const offset = window.innerHeight * getOffsetFraction();
        window.scrollTo({
          top: sectionTop - offset,
          behavior: 'smooth'
        });
      }
    }

    // Клік у межах сторінки
    document.querySelectorAll('a[href="#about"]').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        scrollToAbout();
      });
    });

    // Перехід з іншої сторінки
    window.addEventListener('DOMContentLoaded', () => {
      if (window.location.hash === '#services') {
        setTimeout(scrollToAbout, 100);
      }
    });
  </script>
  <script>
    function getOffsetFraction() {
      // Якщо екран вузький — менший відступ
      return window.innerWidth <= 768 ? 1 / 5 : 1 / 3;
    }

    function scrollToAbout() {
      const targetEl = document.querySelector('#services');
      if (targetEl) {
        const sectionTop = targetEl.getBoundingClientRect().top + window.scrollY;
        const offset = window.innerHeight * getOffsetFraction();
        window.scrollTo({
          top: sectionTop - offset,
          behavior: 'smooth'
        });
      }
    }

    // Клік у межах сторінки
    document.querySelectorAll('a[href="#services"]').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        scrollToAbout();
      });
    });

    // Перехід з іншої сторінки
    window.addEventListener('DOMContentLoaded', () => {
      if (window.location.hash === '#services') {
        setTimeout(scrollToAbout, 100);
      }
    });
  </script>
</body>

</html>
