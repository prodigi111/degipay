<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Informasi Dan Layanan';
require _DIR_('library/header/user');
?>
<!doctype html> 
<html lang="en"> 
    <head> 
 <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
      <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>            
 <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
 <style>
     body{
         background: #fff;
                animation-name: fade;
  animation-duration: 2.5s;   
     }
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}     
@keyframes bell-vibrate {
  0% { transform: rotate(0); }
  2% { transform: rotate(5deg); }
  4% { transform: rotate(-5deg); }
  10% { transform: rotate(5deg); }
  15% { transform: rotate(-5deg); }
  20% { transform: rotate(0); }
  100% { transform: rotate(0); }
}   
.header-codingasik{
    margin-top:10px;
    
}
.header-codingasik p{
    font-weight:bold;
    font-size: 7vw;
    color: #000957;
    margin-bottom:0px;
}
.header-codingasik h5{
   font-size:3.5vw;
   color: black;
}
.boxinfo-codingasik1{
    background-image: linear-gradient(to right bottom, #000957, #000957, #000957, #000957, #000957);
    padding: 10px;
    border-radius: 15px;
    padding-bottom: 25px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;;
}
.boxinfo-codingasik1 img{
    width:40px;
    background: white;
    border-radius: 40px;
    padding: 4px;
}
.boxinfo-codingasik1 p{
    margin-bottom: 0px;
    color: white;
    font-weight:bold;
    font-size: 4vw;
    margin-top: 10px;
}
.boxinfo-codingasik1 h5{
    margin-bottom: 0px;
    color: white;
    font-weight: 500;
    font-size: 3.4vw;
    margin-top: 0px;
}
.boxinfo-codingasik1 button{
    float:right;
    border-radius: 40px;
    border: none;
    padding: 5px;
    font-size: 4vw;
    margin-top:10px;
    width:70px;
    font-size: 3.5vw;
    font-weight: bold;
    background-image: linear-gradient(to right bottom, #000957, #000957, #000957, #000957, #000957);
    color:white;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
         animation: 2s bell-vibrate ease-in-out infinite;
}
.boxinfo-codingasik2{
    background-image: linear-gradient(to right bottom, #000957, #000957, #000957, #000957, #000957);
    padding: 10px;
    border-radius: 15px;
    padding-bottom: 25px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
.boxinfo-codingasik2 img{
    width:40px;
    background: white;
    border-radius: 40px;
    padding: 4px;
}
.boxinfo-codingasik2 p{
    margin-bottom: 0px;
    color: white;
    font-weight:bold;
    font-size: 4vw;
    margin-top: 10px;
}
.boxinfo-codingasik2 h5{
    margin-bottom: 0px;
    color: white;
    font-weight: 400;
    font-size: 3.4vw;
    margin-top: 0px;
}
.boxinfo-codingasik2 button{
    float:right;
    border-radius: 40px;
    border: none;
    padding:5px;
    font-size: 4vw;
    margin-top:10px;
    width:70px;
    font-size: 3.5vw;
    font-weight: bold;
    background-image: linear-gradient(to right bottom, #000957, #000957, #000957, #000957, #000957);
    color:white;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
         animation: 2s bell-vibrate ease-in-out infinite;
}
#dot{
    float: right;
    height: 10px;
    width: 10px;
    background:white;
    border-radius: 40px;
    border: 1px solid aliceblue;
}
.infobox{
    background:white;
    padding-top:10px;
    padding-bottom: 20px;
}
.box-complain-codingasik{
    background: white;
    border-radius:15px;
    padding: 20px;
    margin-bottom:10px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}
.fa-wallet{
    float:left;
    font-size: 9vw;
    margin-bottom: 10px;
    margin-right:10px;
    color: #000957;
}
.fa-coins{
    float:left;
    font-size: 9vw;
    margin-bottom: 10px;
    margin-right:10px;
    color: gold;
}
.fa-id-card-alt{
    float:left;
    font-size: 9vw;
    margin-bottom: 10px;
    margin-right:10px;
    color: orangered;
}

.box-complain-codingasik h5{
    font-size: 4vw;
    font-weight:bold;
    margin-bottom: 0px;
    width:80%;
    color: #000;
    opacity:.6
    
}
.box-complain-codingasik p{
    font-size: 12px;
    font-weight: 500;  
    margin-top:0px;  
    margin-bottom: 0px;
    width:80%;
    color:black;
    opacity:.6
}
.fa-edit{
    float:right;
    margin-top: 15px;
    font-size:5vw;
    font-weight: bold;
    color:black;
    opacity:.6
    }
input{
    border-bottom: 2px solid #e0e0e0 !important;
    font-size: 3.5vw !important;
    border-top:0px !important;
    border-left:0px !important;
    border-right:0px !important;
    width:100% !important;
    border-radius:0px !important;
    margin-bottom:10px;
}
input:hover{
    border-bottom: 2px solid #3E00A3 !important;
    font-size: 3.5vw !important;
    border-top:0px !important;
    border-left:0px !important;
    border-right:0px !important;
    width:100% !important;
    border-radius:0px !important;
    box-shadow:0px 0px 0px 0px !important;
}
label{
    font-size: 3.5vw !important;
    font-weight: bold;
}
.offcanvas{
  background: #f1f1f1 !important;
}
.offcanvas-header{
    background: transparent;
}
.offcanvas-tittle{
    background: transparent;
}
.bg-header-form{
    background-image: linear-gradient(to right bottom, #000957, #000957, #000957, #000957, #000957);
    height: 200px;
}
.col-lg-6{
    background:white;
    padding: 15px;
    border-radius:15px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
.send{
    margin-top:20px;
    width:100%;
}
.panel-heading{
    border-bottom: 0px;
    border-top:0px;
    border-right:0px;
    border-left:0px;
    border-style: dashed;
}
/* with transform */ 
.text-vertikal { 

margin-right: 10px; 
color: #000957;
background:#fff;
font-size:5vw;
font-weight: bold;
padding:5px;
border-radius:100px;
padding-left:10px;
padding-right:10px;
}
.kelos{
    position:absolute;
    border: none;
    background: white;
    font-size: 6vw;
    color: red; 
    top:10px; 
    right:25px;  
}
.footer-info{
    text-align:center;
    font-size:3vw;
    margin-top:10px;
}
.text-info{
    text-align:center;
    font-size:3.2vw;
    margin-top:10px;
}
.offcanvas{ width:100% !important}
.header-codingasikx{
    background: #000957;
    color: white;
    text-align: center;
    padding: 9px;
    font-size: 15px;
    font-weight: bold;
}
a{
  text-decoration: none;
}
 </style>
 </head> 
 <body>
<div style="margin-top:60px"></div>
<div class="container text-start">
     <div class="row"> 
         <div class="col">
             <div class="boxinfo-codingasik1">
                 <div id="dot"></div>
                 <img src="https://i.ibb.co/Rc2bvqm/price-list-1.png" alt="">             
                 <p>Event</p>
                 <h5>Berbagai Event Menarik Menantimu</h5>
<a href="<?= base_url('page/event.php'); ?>">                 
    <button style="display: flex;width: auto;padding-left: 10px;padding-right: 10px;"><i class="fad fa-comments-alt"></i>Event</button>
</a>                 
             </div>
          </div> 
         <div class="col">
              <div class="boxinfo-codingasik2">
                       <div id="dot"></div>       
                 <img src="https://i.ibb.co/kgYh1w2/images.png" alt="">
                 <p>Catatan Keuangan</p>
                 <h5></h5>
<a href="<?= base_url('page/catatan'); ?>">                 
    <button style="display: flex;width: auto;padding-left: 10px;padding-right: 10px;"><i class="fad fa-users-crown"></i> Catatan </button>
</a>                 
             </div>
          </div> 
         </div> 
         </div>
</div>
<br>
<div class="container">
   <div class="box-complain-codingasik" data-bs-toggle="offcanvas" data-bs-target="#kendala-transaksi" aria-controls="offcanvasResponsive" style="display: flex;">
    <div>
       <img src="https://i.ibb.co/3yqvTQJ/3fdeff22-0d98-e36f-f505-6d4919576c81.png" alt="" style="width: 50px;margin-right: 10px;">
       </div>
       <div>
       <h5>Mengalami Kendala Transaksi?</h5>
       <p> Ajukan Komplain Sekarang Agar Kami dapat segera melakukan pengecekan  </p>     
      </div>
   </div> 
   
   <a href="<?= base_url('page/contact'); ?>">
   <div class="box-complain-codingasik">
       <i class="fas fa-coins"></i>
       <i class="fal fa-edit"></i>
       <h5>Layanan keuangan</h5>
       <p>Customer Service 7/24</p>     
   </div> 
  </a>
   
   <div class="box-complain-codingasik" data-bs-toggle="offcanvas" data-bs-target="#keamanan-akun" aria-controls="offcanvasResponsive">
       <i class="fad fa-id-card-alt"></i>
       <i class="fal fa-edit"></i>
       <h5>Keamanan Akun</h5>
       <p> Informasi seputar keamanan akun dan customisasi  </p>     
   </div> 
   </br>
 <center> 
<p style="font-size:3vw;">Transaksi Tersedia setiap Hari 24 Jam nonstop</p>		
 </center>      
</div>



<!-- KENDALA TRANSAKSI -->
<div style="width: 100%;" class="offcanvas-lg offcanvas-end" tabindex="-1" id="kendala-transaksi" aria-labelledby="offcanvasResponsiveLabel"> 
 <div class="bg-header-form">  
  <div class="offcanvas-body"> 
		<div class="col-lg-6 col-lg-offset-3">
		  		<button type="button" class="kelos" data-bs-dismiss="offcanvas" style="margin-top:10px;padding:0px;" data-bs-target="#kendala-transaksi"><i class="fad fa-times-circle"></i></button> 	  
			<div class="panel panel-success">        
			 <div class="dot2"></div>   
				<div class="panel-heading" style="text-align:center;">					    
					<p class="text-vertikal">Komplain Transaksi</p>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Nama</label>
						<div style="display:flex">					
						<input type="text" name="name" class="form-control" placeholder="Nama" id="name1" value="<?= $data_user['name'] ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label>Email</label>
						<div style="display:flex">
						<input type="email" name="email" class="form-control" placeholder="Email" id="email1" value="<?= $data_user['email'] ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label>Nomor Kontak / WhatsApp</label>
							<div style="display:flex">
						<input type="text" name="phone" class="form-control" placeholder="Nomor Kontak / WhatsApp" id="phone1" value="<?= $data_user['phone'] ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label>Pilih Produk</label>
							<div style="display:flex">
						<select name="product" class="form-control" id="product1">
						    
							<option value="">-- Pilih Produk --</option>
							<option value="Akun">Akun</option>
							<option value="TopUp Saldoku">TopUp Saldo</option>							
							<option value="Transaksi Prabayar">Transaksi Prabayar</option>		
							<option value="Transaksi Pascabayar">Transaksi Pascabayar</option>	
							<option value="Transfer">Transfer</option>			
							<option value="Voucher">Voucher</option>
        <option value="Lainnya">Lainnya</option>																																																		
						</select>
					</div>
					<div class="form-group">
						<label>Jelaskan Detail Kendala</label>
						<textarea name="description" class="form-control" rows="3" id="description1"></textarea>
					</div>
</div>																				
				</div>
			</div>
					

		
				<button class="btn btn-primary send1">Kirim</button>
		
<div class="footer-info" id="text-info1">
   Pastikan Kamu memberikan informasi yang jelas dan akurat, untuk mempermudah proses pengecekan. 
</div> 			
		</div>

			</div>

  </div>
   </div>



<!-- KENDALA DEPOSIT -->
<div style="width: 100%;" class="offcanvas-lg offcanvas-end" tabindex="-1" id="kendala-deposit" aria-labelledby="offcanvasResponsiveLabel"> 
 <div class="bg-header-form">  
  <div class="offcanvas-body"> 
		<div class="col-lg-6 col-lg-offset-3">
		  		<button type="button" class="kelos" data-bs-dismiss="offcanvas" style="margin-top:10px;padding:0px;" data-bs-target="#kendala-deposit"><i class="fad fa-times-circle"></i></button> 	  
			<div class="panel panel-success">        
			 <div class="dot2"></div>   
				<div class="panel-heading" style="text-align:center;">					    
					<p class="text-vertikal">Komplain Deposit</p>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Nama</label>
						<div style="display:flex">					
						<input type="text" name="name" class="form-control" placeholder="Nama" id="name" value="<?= $data_user['name'] ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label>Email</label>
						<div style="display:flex">
						<input type="email" name="email" class="form-control" placeholder="Email" id="email" value="<?= $data_user['email'] ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label>Nomor Kontak / WhatsApp</label>
							<div style="display:flex">
						<input type="tel" name="phone" class="form-control" placeholder="Nomor Kontak / WhatsApp" id="phone" value="<?= $data_user['phone'] ?>">
						</div>
					</div>
				 <div class="form-group">
						<label>Nominal Transfer</label>
							<div style="display:flex">
						<input type="number" name="nominal" class="form-control" placeholder="Nominal yang dikirim" id="nominal" required>
						</div>
					</div>
					<div class="form-group">
						<label>Bank Tujan</label>
							<div style="display:flex">
						<select name="product" class="form-control" id="product">
						    
							<option value="">-- Bank Tujuan --</option>
							<option value="BCA">BCA</option>
							<option value="BRI">BRI</option>
							<option value="Mandiri">Mandiri</option>
							<option value="Permata">Permata</option>							
							<option value="Dana">Dana</option>		
							<option value="OVO">OVO</option>	
							<option value="LinkAja">Link Aja</option>			
							<option value="Gopay">Gopay</option>		
							<option value="Qris">Qris</option>																																																		
						</select>
					</div>
					<div class="form-group">
						<label>Jelaskan Detail Kendala</label>
						<textarea name="description" class="form-control" rows="3" id="description"></textarea>
					</div>
</div>																				
				</div>
			</div>
					

		
				<button class="btn btn-primary send">Kirim</button>
		
<div class="footer-info" id="text-info">
   Pastikan Kamu memberikan informasi yang jelas dan akurat, untuk mempermudah proses pengecekan. 
</div> 			
		</div>

			</div>

  </div>
   </div>



<!-- KEAMANAN AKUN -->
<div class="offcanvas-lg offcanvas-end" tabindex="-1" id="keamanan-akun" aria-labelledby="offcanvasResponsiveLabel" style="height:100%;width:100%;"> 
 <div class="bg-header-form">  
  <div class="offcanvas-body"> 
		<div class="col-lg-6 col-lg-offset-3">
		  		<button type="button" class="kelos" data-bs-dismiss="offcanvas" style="margin-top:10px;padding:0px;" data-bs-target="#keamanan-akun"><i class="fad fa-times-circle"></i></button> 	
<center>
    <img src="https://codingasikdesaincode.files.wordpress.com/2022/09/images28729.png" alt="" style="width:70%;" >

	<p>Jangan pernah berikan <font style="color:red;">Password</font> & <font style="color:red;">Kode OTP</font> Kepada siapapun. Kontak Resmi pihak <?= $_CONFIG['title'] ?> Hanya Terdapat di aplikasi,jika ada yang menghubungi diluar nomor yang tertera di aplikasi mengatasnamakan <?= $_CONFIG['title'] ?>,Sudah dipastikan <b style="color:red;">Penipuan</b></p>	
</center> 			  		  



<br>

     <div class="row"> 
         <div class="col">
             <div class="boxinfo-codingasik1">
                 <div id="dot"></div>
<i class="fad fa-lock-alt"style="font-size:10vw;background:white;border-radius:100px;padding:5px;color: goldenrod"></i>       
                 <p> Keamanan </p>
                 <h5>Aktifkan Pin Anda Agar Lebih Aman </h5>
<a href="<?= base_url('account/settings?q=pin'); ?>">                 
                 <button><i class="fad fa-lock-alt"></i> Setting</button>
</a>                 
             </div>
          </div> 
         <div class="col">
              <div class="boxinfo-codingasik2">
                       <div id="dot"></div>       
  <i class="far fa-video" style="font-size:10vw;background:white;border-radius:100px;padding:5px;color:#26a69a"></i>
                 <p>Tutorial Aktivasi PIN</p>
                 <h5>Keamanan Akun Akan Terjaga 100%</h5>
<a href="#">                 
                 <button><i class="far fa-fingerprint"></i> Lihat </button>
</a>                 
             </div>
          </div> 
         </div> 
         </div>         
</div>



  </div>
   </div>





	<script type="text/javascript">
		$(document).on('click','.send', function(){
			/* Inputan Formulir */
			var input_name 			= $("#name").val(),
			    input_email 		= $("#email").val(),
			    input_phone 		= $("#phone").val(),
			    input_nominal 		= $("#nominal").val(),
			    input_product 		= $("#product").val(),
			    input_description 	= $("#description").val();

			/* Pengaturan Whatsapp */
			var walink 		= 'https://web.whatsapp.com/send',
			    phone 		= '6281902013748',
			    text 		= 'Halo saya ingin memesan ',
			    text_yes	= 'Pesanan Anda berhasil terkirim.',
			    text_no 	= 'Halo,kak {{nama_user}} Silahkan Lengkapi Form Komplain Terlebih dahulu .';

			/* Smartphone Support */
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				var walink = 'whatsapp://send';
			}

			if(input_name != "" && input_phone != "" && input_nominal != "" && input_product != "" && input_description != ""){
				/* Whatsapp URL */
				var checkout_whatsapp = walink + '?phone=' + phone + '&text=' + text + '%0A%0A' +
				    'Nama : ' + input_name + '%0A' +
				    'Alamat Email : ' + input_email + '%0A' +
				    'Nomor Kontak / Whatsapp : ' + input_phone + '%0A' +
				    'Nominal : ' + input_nominal + '%0A' +
				    'Bank Tujuan : ' + input_product + '%0A' +
				    'Catatan : ' + input_description + '%0A';

				/* Whatsapp Window Open */
				window.open(checkout_whatsapp,'_blank');
				document.getElementById("text-info").innerHTML = '<div class="alert alert-success">'+text_yes+'</div>';
			} else {
				document.getElementById("text-info").innerHTML = '<div class="alert alert-danger">'+text_no+'</div>';
			}
		});
	</script>
	<script type="text/javascript">
		$(document).on('click','.send1', function(){
			/* Inputan Formulir */
			var input_name 			= $("#name1").val(),
			    input_email 		= $("#email1").val(),
			    input_phone 		= $("#phone1").val(),
			    input_product 		= $("#product1").val(),
			    input_description 	= $("#description1").val();

			/* Pengaturan Whatsapp */
			var walink 		= 'https://web.whatsapp.com/send',
			    phone 		= '6281902013748',
			    text 		= 'Halo saya ingin memesan ',
			    text_yes	= 'Pesanan Anda berhasil terkirim.',
			    text_no 	= 'Halo,kak {{nama_user}} Silahkan Lengkapi Form Komplain Terlebih dahulu .';

			/* Smartphone Support */
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				var walink = 'whatsapp://send';
			}

			if(input_name != "" && input_phone != "" && input_product != ""){
				/* Whatsapp URL */
				var checkout_whatsapp = walink + '?phone=' + phone + '&text=' + text + '%0A%0A' +
				    'Nama : ' + input_name + '%0A' +
				    'Alamat Email : ' + input_email + '%0A' +
				    'Nomor Kontak / Whatsapp : ' + input_phone + '%0A' +
				    'Produk : ' + input_product + '%0A' +
				    'Catatan : ' + input_description + '%0A';

				/* Whatsapp Window Open */
				window.open(checkout_whatsapp,'_blank');
				document.getElementById("text-info1").innerHTML = '<div class="alert alert-success">'+text_yes+'</div>';
			} else {
				document.getElementById("text-info1").innerHTML = '<div class="alert alert-danger">'+text_no+'</div>';
			}
		});
	</script>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> 
</body> 
</html> 

<?php require _DIR_('library/footer/user') ?>