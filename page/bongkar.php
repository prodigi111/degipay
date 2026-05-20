<?php 
require '../RGShenn.php';
require _DIR_('library/session/user'); 
?>
<!doctype html>
<html lang="en">
    <head> 
       <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <title>Bongkar Koin</title>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> 
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"       integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />  
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">    
       <style type="text/css" media="all">
  body {
    font-family: 'Baloo Bhaijaan 2', cursive !important;    
   background: #f1f1f1;
}
.box{
   background: #3E00A3;
   color: #3E00A3;
   border-radius: 10px;
   padding: 15px;   
   margin-top: 15px;
   box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
}
.box-menu-account{
   display:flex;
}
.img-profil img{
   margin-right:15px;
   width:40px;
}
.text-profil{
   width:100%;
}
.text-profil h5{
  font-size: 14px;
  font-weight: 400;
  color:black;
  margin-bottom:0px;
  margin-top:3px;
}
.text-profil p{
  font-size:15px;
  color: #2196f3;
  font-weight:bold;
  margin-bottom:0px;
}
.notice img{
  width: 25px;
  margin-top:6px;
}
#saldo_user{
   margin-bottom:0px;
   font-weight:bold;
   font-size:17px;
}
.box-rupiah{
   padding:10px;
   background:aliceblue;
   margin-top:25px;
   border-radius: 10px;
}
.header-img{
  height:50px;
}
.bg-produk{
   background:white;
   padding-top:20px;
   padding-bottom: 15px;
   border-radius: 7px;
   box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
   width:100%;
}
.footer h5{
   font-weight: 400;
   font-size: 12px;
   margin-top:8px;
   color:black;
}
.text-opt{
   width: 100%;
   color:black;
   border-right:2px solid #2196f3;
}
a{text-decoration:none;}
.text-opt h5{
   margin-top:6px;
   font-size: 15px;
   font-weight:bold;
   color:black;
}
.text-opt p{
   margin-bottom:0px;
   background: white;
   border-radius:5px;
   color:black;
}
.rate{
  width: 66px;
  text-align:center;
}
.rate h6{
  margin-top:48%;
  padding-left:10px;
  font-size: 16px;
  opacity:.7;
}
.help{
   float:right;
   margin-top:-20px;
}
#saldo_user{
   font-size: 18px;
   padding-bottom:0px;
   padding-top:3px;
}
.apklogo{
   width: 100px;
   margin-top:15px;
}
.csku{
  position:absolute;
  right:10px;
  top:15px;
  width: auto;
  border:none;
  background: transparent;
}
.csku img{
  width:20px;
  }
</style>
         </head>
          <body>
<div style="margin-top:30px;"></div>
	<div class="container">
<div class="box-form-bongkar">
<center>
<p style="margin-bottom:0px;">Saldo Anda</p>
<h5 id="saldo_user"><?= currency($data_user['balance']) ?></h5>
</center>
</div>
</div>
</br>

<div style="display:flex;">
<div class="nemaproduk" style="width:100%;">  
<p style="font-weight:bold;margin-left:15px;margin-bottom:5px;">
   Bongkar koin
</p>
</div>
<a href="#">    
<div class="tutor" style="display:flex;margin-right:15px;">
<i class="fas fa-question-circle"style="margin-right:10px;color:red;font-size:17px;"></i> 
</div>
</a>
</div>
<!-- PRODUK -->
      <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <style>
 .imgform img{
    width:25px;
    margin-top:6px;
    margin-right:10px;
    }
 input{
       width:100% !important;
       border:none ! important;
       box-shadow : none !important;
       background:transparent !important;
       margin-top:2px;
       font-weight: bold !important;
       }
select{
       width:100% !important;
       border:none ! important;
       box-shadow : none !important;
       background:transparent !important;
       width:300px !important;
       font-weight: bold !important;
       }       
.box-form-bongkar{
      background: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
}       
label{
      margin-top:10px;
      }
      </style>

	<div class="container">
<div class="box-form-bongkar">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="panel panel-success">
				<div class="panel-body">
					<div class="form-group">
						<label>Nama Penggunaan</label>
						<div style="display:flex;border:1px solid grey;padding-left:10px;border-radius:10px;">
						   <div class="imgform">
						      <img src="https://087882444486design.files.wordpress.com/2022/10/1177568.png" alt="">
						   </div>
						   <div class="textform">
						<input type="text" name="name" 
value="<?= $data_user['name'] ?>" class="form-control" placeholder="Nama" id="name" style="width:100%;" readonly>
						   </div>
					    	</div>
					</div>
					
					
					<div class="form-group">
						<label>Email</label>
							<div style="display:flex;border:1px solid grey;padding-left:10px;border-radius:10px;">
						   <div class="imgform">
						      <img src="https://087882444486design.files.wordpress.com/2022/10/1177437.png" alt="">
						   </div>
						   <div class="textform">
						<input type="email" name="email" value="<?= $data_user['email'] ?>" class="form-control" placeholder="Email" id="email" readonly>
						</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<label>Jumlah Bongkar</label>
					<div style="display:flex;border:1px solid grey;padding-left:10px;border-radius:10px;">
						   <div class="imgform">
						      <img src="https://coderasikcode.files.wordpress.com/2022/10/images-2022-10-12t223054.094.jpeg" alt="">
						   </div>
						   <div class="textform">						
						<input type="Text" name="phone" class="form-control" placeholder="Contoh 10B" id="phone">
						</div>
						</div>
					</div>
					


<div class="form-group">
						<label>Jenis Pembayaran</label>
										<div style="display:flex;border:1px solid grey;padding-left:10px;border-radius:10px;">
						   <div class="imgform">
						      <img src="https://087882444486design.files.wordpress.com/2022/10/1061440.png" alt="">
						   </div>
						   <div class="textform">	
						<select name="product" class="form-control" id="product">
							<option value="">-- Pilih Pembayaran --</option>
							<option value="SaldoPanPay">Saldo <?= $_CONFIG['title'] ?></option>
						</select>
						</div>
						</div>
					</div>
					
						</div>
						</div>
					</div>
					</br>
					<div class="form-group">
						<button class="btn btn-success  send">Request Bongkar</button>
					</div>

					<div id="text-info"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
  <div class="boxinformasi">

  </div>
</div>



	<script type="text/javascript">
		$(document).on('click','.send', function(){
			/* Inputan Formulir */
			var input_name 			= $("#name").val(),
			    input_email 		= $("#email").val(),
			    input_phone 		= $("#phone").val(),
      input_namebank 		= $("#namebank").val(),
			    input_product 		= $("#product").val(),
			    input_description 	= $("#description").val();

			/* Pengaturan Whatsapp */
			var walink 		= 'https://web.whatsapp.com/send',
			    phone 		= '6281264896262',
			    text 		= 'Halo Bossku, saya ingin Bongkar Koin HDI ',
			    text_yes	= 'Pesanan Anda berhasil terkirim.',
			    text_no 	= 'Mohon Isi Semua Data';

			/* Smartphone Support */
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				var walink = 'whatsapp://send';
			}

			if(input_name != "" && input_phone != "" && input_product != ""){
				/* Whatsapp URL */
				var checkout_whatsapp = walink + '?phone=' + phone + '&text=' + text + '%0A%0A' +
				    '*Nama* : ' + input_name + '%0A' +
				    '*Email* : ' + input_email + '%0A' +
				    '*Jumlah Bongkar* : ' + input_phone + '%0A' +
       '*Bank* : ' + input_product + '%0A';

				/* Whatsapp Window Open */
				window.open(checkout_whatsapp,'_blank');
				document.getElementById("text-info").innerHTML = '<div class="alert alert-success">'+text_yes+'</div>';
			} else {
				document.getElementById("text-info").innerHTML = '<div class="alert alert-danger">'+text_no+'</div>';
			}
		});
	</script>
</body>
</html>









</br>
                    <div id="saldo_user"></div>						
        <script type="text/javascript">
          function rubah(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return "Rp."+ribuan;
          }
          document.getElementById("saldo_user").innerText=rubah(document.getElementById("saldo_user").textContent);
          console.log("Powered By QiosScript");
    console.info("Telegram UserName = KiosSceipt");                                console.log("Gunakan Console ini dengan baik tanpa merugikan orang lain atau pihak lain");
                                    console.info("Powered QiosScript");
                                    console.info("Username Telegram Owner = @Qiosscript");              console.info("SERVER : [NORMAL][200] ;");
        </script>
        
               <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> </body> </html> 