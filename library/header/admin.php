<!doctype html>
<html lang="id">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title><?= isset($_CONFIG['title_add']) ? $_CONFIG['title'].' :: '.$_CONFIG['title_add'] : $_CONFIG['title'] ?></title>
        
        <meta name="description" content="<?= $_CONFIG['description'] ?>">
        <meta name="keywords" content="<?= $_CONFIG['keyword'] ?>">
        <meta name="author" content="Afdhalul Ichsan Yourdan, Rifqi Galih Nur Ikhsan">
        
        <meta name="robots" content="<?= $_META['robots'] ?>">
        <meta name="revisit-after" content="<?= $_META['revisit'] ?>">
        <meta name="msvalidate.01" content="<?= $_META['bing_site'] ?>">
        <meta name="google-site-verification" content="<?= $_META['google_site'] ?>">
        
        <meta name="Geo.Placename" content="<?= $_META['geo_placename'] ?>">
        <meta name="Geo.Country" content="<?= $_META['geo_country'] ?>">
        
        <meta property="og:title" content="<?= $_CONFIG['title'] ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?= base_url() ?>">
        <meta property="og:image" content="<?= $_CONFIG['banner'] ?>">
        <meta property="og:image:type" content="image/png">
        <meta property="og:description" content="<?= $_CONFIG['description'] ?>">
        <meta property="og:site_name" content="<?= $_CONFIG['title'] ?>">
        <meta property="og:locale" content="id_ID">
        <meta property="fb:pages" content="291448691554058">
        <meta property="fb:admins" content="100022982940138">
        <meta property="twitter:card" content="Summary">
        <meta property="twitter:url" content="<?= base_url() ?>">
        <meta property="twitter:title" content="<?= $_CONFIG['title'] ?>">
        <meta property="twitter:image" content="<?= $_CONFIG['banner'] ?>">
        <meta property="twitter:creator" content="@RGsann">
        
        <!-- Custom Meta -->
        <meta name="DeviceType" content="<?= $device ?>">
        <meta name="UserAgent" content="<?= $user_agent ?>">
        <meta name="IpAddress" content="<?= client_ip() ?>">
        <meta name="Rating" content="General">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= assets('mobile/').$_CONFIG['icon'] ?>" type="image/png">
        <!-- CSS Files -->
        <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= assets('css/typography.css') ?>">
        <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
        <link rel="stylesheet" href="<?= assets('css/responsive.css') ?>">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        
        <!-- JS Files -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $_META['google_tagmanager'] ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= $_META['google_tagmanager'] ?>');
        </script>
        
        <!-- Start Script Morris Chart -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>
    <body class="sidebar-main-active right-column-fixed">
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
         <div class="iq-sidebar">
            <div class="iq-sidebar-logo d-flex justify-content-between">
               <a href="<?= base_url() ?>" class="header-logo">
                  <img src="<?= $_CONFIG['icon'] ?>" class="img-fluid rounded-normal" alt="">
                  <div class="logo-title font-size-21 font-weight-500">
                     <span class="text-danger text-uppercase"><?= $_CONFIG['title'] ?></span>
                  </div>
               </a>
               <div class="iq-menu-bt-sidebar">
                  <div class="iq-menu-bt align-self-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                        <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="sidebar-scrollbar">
<!-- Menu -->
<? require _DIR_('library/header/menu-admin'); ?>
<!-- Menu END -->
            </div>
         </div>
         <!-- TOP Nav Bar -->
         <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-menu-bt d-flex align-items-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
                        <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
                     </div>
                     <div class="iq-navbar-logo d-flex justify-content-between">
                        <a href="<?= base_url() ?>" class="header-logo">
                           <div class="pt-2 pl-2 logo-title">
                              <span class="text-danger text-uppercase"><?= $_CONFIG['title'] ?></span>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="navbar-breadcrumb">
                     <p class="mb-0"><span class="text-danger">Hi Admin <?= $data_user['name'] ?>,</span> Senang Bertemu Denganmu Lagi</p>
                  </div>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto navbar-list">
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
         <!-- TOP Nav Bar END -->
         
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">