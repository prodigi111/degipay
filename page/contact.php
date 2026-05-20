<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');  

 $accessApp = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
if($accessApp !== 'com.plisspa.app'):
    redirect('0', str_replace('area.', '', base_url(dialihkan)));
endif; 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bantuan</title>
  <link href="https://codingasik.my.id/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Acme&family=Caveat:wght@400;500;600;700&family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,500;1,600;1,700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Mochiy+Pop+One&family=Nerko+One&family=Open+Sans:wght@300;400;500;600;700&family=Oswald:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Secular+One&display=swap"
    rel="stylesheet">
  <!-- 
font-family: 'Acme', sans-serif;
font-family: 'Caveat', cursive;
font-family: 'Josefin Sans', sans-serif;
font-family: 'Kanit', sans-serif;
font-family: 'Mochiy Pop One', sans-serif;
font-family: 'Nerko One', cursive;
font-family: 'Open Sans', sans-serif;
font-family: 'Oswald', sans-serif;
font-family: 'Poppins', sans-serif;
font-family: 'Prompt', sans-serif;
font-family: 'Roboto', sans-serif;
font-family: 'Rubik', sans-serif;
font-family: 'Secular One', sans-serif;
 -->
  <style>
    body {
      background: #f1f1f1;
      font-family: 'Secular One', sans-serif;
    }

    .header-codingasik {
      background: #3E00A3;
      padding: 10px;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 100;
      border-radius: 0px;
      height: 70px;
    }

    h5 {
      font-size: 15px;
      font-weight: bold;
      color: white;
      margin-bottom: 5px;
      letter-spacing: 1px;
    }

    .box-codingasik {
      background: white;
      border-radius: 10px;
      padding: 0px;
      box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
      padding-top: 15px;
      padding-bottom: 15px;
      padding-right: 20px;
      padding-left: 20px;
      font-size: 14px;
      font-family: 'Josefin Sans', sans-serif;
      margin-top: 10px;
    }
    .codingasik-hub{
      display: flex;
      width: 100%;
    }
    .image-hub img{
      width: 35px;
    }
    h6{
      color: black;
      margin-top: 5px;
      margin-left: 10px;
      margin-bottom: 0px;
      font-size: 14px;
    }
    p{
      font-size: 10px;
      margin-top: 0px;
      margin-bottom: 0px;
      margin-left: 10px;
      color: grey;
    }
    .codingasik-line{
      background: #f1f1f1;
      padding: 1px;
      margin-top: 10px;
      margin-bottom: 10px;
    }
    a{
      text-decoration: none;
    }
    .image-rating img{
      background: white;
      border-radius: 7px;
      box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
      padding: 5px;
      width: 45px;
      margin-right: 0px;
      margin-bottom: 5px;
    }
    h4{
      font-size: 15px;
      margin-bottom: 0px;
      margin-top: 3px;
      font-family: 'Josefin Sans', sans-serif;
    }
    .text-rating{
      width: 100%;
    }
    .button-rating{
      width: 100%;
      text-align: center;
    }
    .button-rating button{
      font-size: 14px;
      border: none;
      background: #3E00A3;
      color: white;
      border-radius: 4px;
      font-weight: 400;
      font-family: 'Josefin Sans', sans-serif;
      margin-top: 10px;
    }
    .box-rating{
      margin-top: 15px;
      box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
      border-radius: 10px;
      background: white;
      padding: 20px;
    }
    .fas{
      color: gold;
    }
  </style>
</head>

<body>


  <div class="header-codingasik">
    <center>
      <h5>Customer Support</h5>
    </center>
    <div class="box-codingasik">
      <!-- TEXT TIME -->
      <script type="text/javascript">
        var h = (new Date()).getHours();
        var m = (new Date()).getMinutes();
        var s = (new Date()).getSeconds();
        if (h >= 8 && h < 10) document.writeln("Selamat Pagi Kak , Ada Masalah? Customer service Kami akan Membantumu.");
        if (h >= 10 && h < 15) document.writeln("Selamat siang Kak , Ada Masalah? Customer service Kami akan Membantumu.");
        if (h >= 15 && h < 18) document.writeln("Selamat sore Kak , Ada Masalah? Customer service Kami akan Membantumu.");
        if (h >= 18 && h < 22) document.writeln("Selamat malam Kak, Ada Masalah? Customer service Kami akan Membantumu.");
        if (h >= 22 || h < 8) document.writeln("Selamat malam Kak, Costumer servis Sedang Offline, jangan lupa istirahat ya.");
      </script>
    </div>



    <div class="box-codingasik">
      <div style="display: flex;">
        <a href="https://wa.me/<?= conf('bantuan-cfg',1) ?>" class="codingasik-hub">
          <div class="image-hub">
            <img src="https://cdn-icons-png.flaticon.com/128/5968/5968841.png" alt="">
          </div>
          <div class="text-hub">
            <h6>Whatsapp</h5>
              <p>Tanya Jawab</p>
          </div>
        </a>
        <div style="width: 4px;background:#f1f1f1;margin-right: 10px;margin-left: 10px;"></div>
        <a href="https://t.me/<?= conf('bantuan-cfg',2) ?>" class="codingasik-hub">
          <div class="image-hub">
            <img src="https://cdn-icons-png.flaticon.com/128/2111/2111644.png" alt="">
          </div>
          <div class="text-hub">
            <h6>Telegram</h5>
              <p>Telegram Account</p>
          </div>
        </a>
      </div>
      <div class="codingasik-line"></div>
      <div style="display: flex;">
        <a href="https://www.instagram.com/<?= conf('bantuan-cfg',4) ?>/" class="codingasik-hub">
          <div class="image-hub">
            <img src="https://cdn-icons-png.flaticon.com/128/1409/1409946.png" alt="">
          </div>
          <div class="text-hub">
            <h6>instagram</h5>
              <p>Sosial Media</p>
          </div>
        </a>
        <div style="width: 4px;background:#f1f1f1;margin-right: 10px;margin-left: 10px;"></div>
        <a href="mailto:<?= conf('bantuan-cfg',3) ?>" class="codingasik-hub">
          <div class="image-hub">
            <img src="https://cdn-icons-png.flaticon.com/512/5968/5968534.png" alt="">
          </div>
          <div class="text-hub">
            <h6>Email</h5>
              <p>Kontak Bantuan</p>
          </div>
        </a>
      </div>
   
  </div>

<center>
  <div class="box-rating">
    <div class="image-rating">
      <img src="<?= $_CONFIG['icon'] ?>" alt="">
    </div>
    <div class="text-rating">
      <h4><?= $_CONFIG['title'] ?></h4>
      <p>Product Digital</p>
    </div>

      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>



  <div class="button-rating">
    <a href="<?= conf('bantuan-cfg',5) ?>">
      <button>Beri Rating</button>
    </a>
  </div>
</div>
</center>
<img src="https://codingasik.my.id/hero-banner2.png" alt="" style="width: 100%;margin-top:20px;left:0;position:fixed;bottom:20px;z-index: -1;">

  
  </div>

  <script src="https://codingasik.my.id/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>