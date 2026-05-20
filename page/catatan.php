<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Catatan Keuangan';
require _DIR_('library/header/user');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://storage1.membergens.site/assets/css/ids-loader.css" type="text/css" media="all" /> 
</head>
<body>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,600&display=swap');
    body {
      background:white;
      font-family: 'Poppins';
    }
    .card {
      border-radius: 5px;
      border:0.5px solid #ebebeb;
      box-shadow: 1px 1px 1px #d3d3d3;
      padding: 10px;
    }
    .judul-masuk {
      font-size: 12px;
      opacity: 0.6;
      margin-bottom: 0;
    }
    .jumlah {
      font-size: 12px;
      opacity: 0.9;
      font-weight: 410;
      margin-bottom: 0;
    }
    .button {
      border:none;
      outline: none;
      border-radius: 5px;
      box-shadow: 1px 1px 1px #d3d3d3;
      color:white;
      padding: 5px;
      font-size: 12px;
      width: 100%;
    }
    .keluar {
      background:#5e17eb;
    }
    .masuk {
      background:#5e17eb;
    }
    .btn-list {
      border-radius: 5px;
      border:none;
      outline: none;
      padding: 5px;
      font-size: 12px;
      background: #f2f2f296;
    }
    .active {
      background:#3E00A3;
      color:white;
      transition: 500ms all;
    }
    .detail {
      font-size: 12px;
      opacity:0.9;
      margin-bottom: 0;
      font-weight: 410;
    }
    .tgl {
      font-size: 11px;
      opacity: 0.7;
      margin-bottom: 0;
    }
    .pemasukan {
      color:#009e69;
      text-transform: capitalize;
    }
    .pengeluaran {
      text-transform: capitalize;
      color:salmon;
    }
    .formData {
      outline:none;
      border-radius:5px;
      border:1.5px solid #5e17eb;
      width: 100%;
      padding: 6px;
      margin-top: 10px;
      font-size: 13px;
      transition: 500ms;
    }
    .formData:focus {
      border:1.5px solid #5e17eb;
      transition: 500ms;
    }
    .close {
      color: #aaaaaa;
      float: right;
      font-size: 17px;
      font-weight: bold;
      margin-top:-10px;
    }
    .simpan {
      background:#00b386;
      color: white;
      margin-top: 12px;
    }
    .header-text {
      font-size: 8px;
      font-weight: 410;
      color:white;
      margin-bottom: 0;
    }
  </style>

  <div style="margin-top:60px"></div>
  <div class="container">
    <div class="row g-2 mt-4">
      <div class="col">
        <div class="card text-center">
          <p class="judul-masuk">Pemasukan</p>
          <p class="jumlah" id="totalPemasukan"></p>
          <p class="d-none" id="hideMasuk"></p>
        </div>
      </div>
      <div class="col">
        <div class="card text-center">
          <p class="judul-masuk">Pengeluaran</p>
          <p class="jumlah" id="totalPengeluaran"></p>
          <p class="d-none" id="hideKluar"></p>
        </div>
      </div>
      <div class="card text-center">
        <p class="judul-masuk">Selisih</p>
        <p class="jumlah" id="selisih">Loading...</p>
      </div>
      <div class="col text-center">
         <button onclick="document.getElementById('myModalInsert').style.display = 'block'; $('#tipe').val('pemasukan')" class="button masuk mt-3">Catat Pemasukan</button>
      </div>
      <div class="col text-center">
         <button onclick="document.getElementById('myModalInsert').style.display = 'block'; $('#tipe').val('pengeluaran')" class="button keluar mt-3">Catat Pengeluaran</button>
      </div>
    </div>
    
  </div>
  
  
  <div class="container mt-4">
    <div class="row g-2 text-center">
      <div class="col">
        <button onclick="viewData()" class="btn-list w-100" id="list-masuk">Riwayat Catatan</button>
      </div>
      <div class="col">
        <button onclick="viewPengingat()" class="btn-list w-100" id="list-pengingat">Catat Pengingat Yuk</button>
      </div>
    </div>
  </div>
  
  <div id="datalist" class="container mt-4">
  </div>
  
  <div class="container mt-4" id="showBtnP"></div>
  <div id="datapengingat" class="container mt-2">
    
  </div>
  
  <div id="myModal" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail">Edit Data</p>
        </div>
        <div class="col-1">
           <span class="close">×</span>
        </div>
      </div>
      <hr>
      <input class="formData" id="editJudul">
      <input class="formData" id="editJumlah">
      <input class="d-none" id="noneId">
      <input class="d-none" id="noneTipe">
      <button class="button simpan" onclick="editData()">Simpan</button>
    </div>
  </div>
  <div id="myAlert" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail" id="dataAlert"></p>
        </div>
        <div class="col-1">
           <span class="close" onclick="document.getElementById('myAlert').style.display = 'none'">×</span>
        </div>
      </div>
    </div>
  </div>
  <div id="myModalInsert" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail">Masukan data</p>
        </div>
        <div class="col-1">
           <span class="close" onclick="document.getElementById('myModalInsert').style.display = 'none'">×</span>
        </div>
      </div>
      <hr>
      <form>
        <input id="tipe" class="d-none" readonly>
        <p id="falseToInsert" class="detail text-danger"></p>
        <input id="insertJudul" class="formData" placeholder="Masukan judul">
        <input id="insertJumlah" class="formData" placeholder="Masukan jumlah" type="number">
        <button type="reset" onclick="insertData()" class="button simpan">Simpan</button>
      </form>
    </div>
  </div>
  <div id="alertDelete" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail">Konfirmasi</p>
        </div>
      </div>
      <hr>
      <p class="detail">Apakah anda yakin akan menghapus data <span id="dataJud"></span></p>
      <p class="d-none" id="dataId"></p>
      <button onclick="document.getElementById('alertDelete').style.display = 'none'" class="button mt-3" style="color:black">Tidak</button>
      <button onclick="deleteData('yes'); document.getElementById('alertDelete').style.display = 'none'" class="button active mt-2">Ya</button>
    </div>
  </div>
  <div id="alertDeleteP" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail">Konfirmasi</p>
        </div>
      </div>
      <hr>
      <p class="detail">Apakah anda yakin akan menghapus data <span id="pSubj"></span></p>
      <p class="d-none" id="dataPId"></p>
      <button onclick="document.getElementById('alertDeleteP').style.display = 'none'" class="button mt-3" style="color:black">Tidak</button>
      <button onclick="deleteDataP('yes'); document.getElementById('alertDeleteP').style.display = 'none'" class="button active mt-2">Ya</button>
    </div>
  </div>
  
  <div id="modalPengingatInsert" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail">Masukan Data</p>
        </div>
        <div class="col-1">
           <span class="close" onclick="document.getElementById('modalPengingatInsert').style.display = 'none'">×</span>
        </div>
      </div>
      <hr>
      <form>
       <p id="falseToInsertP" class="detail text-danger"></p>
      <input class="formData" id="judulP" placeholder="Masukan Subjek">
      <textarea class="formData" id="contentP" style="height:100px" placeholder="Masukan Pesan / catatan"></textarea>
     
      <button type="reset" class="button simpan" onclick="insertP();">Simpan</button>
      </form>
    </div>
  </div>
  
  <div id="editP" class="modal">
    <div class="modal-content">
      <div class="row g-0">
        <div class="col">
          <p class="detail">Edit Data</p>
        </div>
        <div class="col-1">
           <span class="close" onclick="document.getElementById('editP').style.display = 'none'">×</span>
        </div>
      </div>
      <hr>
      <form>
      <input class="formData" id="editjdP" placeholder="Masukan Subjek">
      <textarea class="formData" id="editcntP" style="height:100px" placeholder="Masukan Pesan / catatan"></textarea>
      
     
      <button type="reset" class="button simpan" onclick="editP(); document.getElementById('editP').style.display = 'none'">Simpan</button>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
   viewData()
   function closeAlert(){
     setTimeout(function(){
       document.getElementById("myAlert").style.display = "none"
     },1000)
   }
   $("#list-masuk").css('background', '#00cba4d8')
   $("#list-masuk").css('color', 'white')
   $("#list-masuk").css('transition', '400ms all')
   $(".btn-list").css('box-shadow', '1px 1px 1px #d9d9d9')
      
    $("#list-masuk").click(function(){
      $("#list-masuk").css('background', '#00cba4d8')
      $("#list-masuk").css('color', 'white')
      $("#list-pengingat").css('background', '')
      $("#list-pengingat").css('color', '')
      $("#datalist").css('display', 'block')
      $("#datapengingat").css('display', 'none')
      $("#showBtnP").css('display', 'none')
    })
    $("#list-pengingat").click(function(){
      $("#list-masuk").css('background', '')
      $("#list-masuk").css('color', '')
      $("#list-pengingat").css('color', 'white')
      $("#list-pengingat").css('background', '#00cba4d8')
      $("#list-pengingat").css('transition', '400ms all')
      $("#datalist").css('display', 'none')
      $("#datapengingat").css('display', 'block')
      $("#showBtnP").css('display', 'block')
    })
 function closeDataFalse(){
   setTimeout(function(){
     document.getElementById('falseToInsertP').textContent = ''
     document.getElementById('falseToInsert').textContent = ''
   },1000)
 }
 getJumlahMasuk() 
 getJumlahKeluar()
 getKalkulasi()
function rubah(angka) {
   var reverse = angka.toString().split('').reverse().join(''),
   ribuan = reverse.match(/\d{1,3}/g)
   ribuan = ribuan.join('.').split('').reverse().join('')
   return "Rp" + ribuan
}
    function viewData() {
      $.ajax({
         url: "https://filehtml.cintamadigital.site/catatan.php?action=get_data_email&email={{email_user}}",
         method: "GET",
         timeout: 0,
         beforeSend:function(){
           $("#datalist").html(`<center><div id="load" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></center>`)
         },
         success:function(response){
            //console.log(response.message)
            if(response.message == 'No Data Found'){
              $("#datalist").html(`<div class="text-center"><img width="300" src="https://cdn.genspedia.com/upload/images (2).jpeg" alt=""></div>`)
              return false
            }else{
            setTimeout(function(){
            var datas = response.data
            for (let i = 0; i < datas.length; i++ ){
            //console.log(datas[i]['judul'])
            var judul  = datas[i]['judul']
            var jumlah = datas[i]['jumlah']
            var tipe   = datas[i]['tipe']
            var id     = datas[i]['id']
            var tanggal     = datas[i]['waktu']
            //console.log(id) 
           $("#datalist").append(`<div class="card mt-1">
      <div class="row">
        <div class="col">
          <p class="detail">`+judul+`</p>
          <small class="tgl">`+tanggal+`</small>
        </div>
        <div class="col text-end">
          <p class="detail `+tipe+`">`+tipe+" "+rubah(jumlah)+`</p>
          <div class="row text-end">
            <div class="col"></div>
            <div class="col-2">
              <i onclick="viewModal('`+judul+`', '`+jumlah+`', '`+id+`', '`+tipe+`')" class="bi bi-pencil-square"></i>
            </div>
            <div class="col-3">
              <i onclick="viewAlertDelete('`+judul+`', '`+id+`')" class="bi bi-trash"></i>
            </div>
          </div>
        </div>
      </div>
    </div>`)
            }
      $("#load").css('display', 'none')      
          },1000)
         }
         }
      })
    }
    function getJumlahMasuk(){
      $.ajax({
        url: "https://filehtml.cintamadigital.site/catatan.php?action=get_jumlah&email={{email_user}}&tipe=pemasukan",
        beforeSend:function(){
          $("#totalPemasukan").html('Loading')
        },
        success:function(response){
          //console.log(response)
          var jumlah = response.data
         // console.log(jumlah)
          if(jumlah[0]['jumlah'] == null){
            $("#totalPemasukan").html(rubah(0))
            $("#hideMasuk").html(0)
          }else{
          $("#totalPemasukan").html(rubah(jumlah[0]['jumlah']))
          $("#hideMasuk").html(jumlah[0]['jumlah'])
          }
        }
      })
    }
    function getJumlahKeluar(){
      $.ajax({
        url: "https://filehtml.cintamadigital.site/catatan.php?action=get_jumlah&email={{email_user}}&tipe=pengeluaran",
        beforeSend:function(){
          $("#totalPengeluaran").html('Loading')
        },
        success:function(response){
         // console.log(response)
          var jumlah = response.data
          if(jumlah[0]['jumlah'] == null){
            $("#totalPengeluaran").html(rubah(0))
            $("#hideKluar").html(0)
          }else{
          $("#totalPengeluaran").html(rubah(jumlah[0]['jumlah']))
          $("#hideKluar").html(jumlah[0]['jumlah'])
          }
        }
      })
    }
    function getKalkulasi(){
      setTimeout(function(){
        var totalMasuk = $("#hideMasuk").html()
        var totalKeluar = $("#hideKluar").html()
        console.log(totalKeluar)
        var selisih = (parseInt(totalMasuk)-parseInt(totalKeluar))
        let text = ""+selisih+"";
        let result = text.substring(0, 1);
       // console.log(result)
        
        if(result == "-"){
          var mins = "-"
          var jums = rubah(selisih)
          $("#selisih").html(mins+jums)
        }else if(totalKeluar == "0" || totalMasuk == "0"){
          var jums = rubah(selisih)
          $("#selisih").html(jums)
        }else{
          var plus = "+"
          var jums = rubah(selisih)
          $("#selisih").html(plus+jums)
        }
      },1000)
    }
    
    function viewAlertDelete(dataJu, datId){
      document.getElementById('alertDelete').style.display = 'block'
      $("#dataJud").html(dataJu)
      $("#dataId").html(datId)
    }
    function insertData(){
      closeDataFalse()
      var tipe = $("#tipe").val()
      var judul  = $("#insertJudul").val()
      var jumlah = $("#insertJumlah").val()
      
      var form = new FormData();
       form.append("jumlah", jumlah);
       form.append("tipe", tipe);
       form.append("judul", judul);
       form.append("email", "{{email_user}}");
       
       if(judul == ""){
         document.getElementById("falseToInsert").textContent = 'Lengkapi data terlebih dahulu'
         return false
       }else if(jumlah == ""){
         document.getElementById("falseToInsert").textContent = 'Lengkapi data terlebih dahulu'
         return false
       }else{
         document.getElementById("falseToInsert").textContent = ''
       $.ajax({
         url: "https://filehtml.cintamadigital.site/catatan.php?action=insert_data_catatan",
         method: "POST",
         timeout: 0,
         processData: false,
         mimeType: "multipart/form-data",
         contentType: false,
         data: form,
         success:function(response){
            //console.log(response)
            viewData()
            getKalkulasi()
            getJumlahMasuk()
            getJumlahKeluar()
            document.getElementById('myModalInsert').style.display = "none";
            document.getElementById("myAlert").style.display = "block"
            document.getElementById("dataAlert").innerHTML = '<div class="detail">Data Berhasil di-tambahkan</div>'
            closeAlert()
         }
       })
       }
    }
    function editData(){
      var id = $("#noneId").val()
      var tipe = $("#noneTipe").val()
      var judul  = $("#editJudul").val()
      var jumlah = $("#editJumlah").val()
      
      var form = new FormData();
       form.append("jumlah", jumlah);
       form.append("tipe", tipe);
       form.append("judul", judul);
       form.append("email", "{{email_user}}");

       $.ajax({
         url: "https://filehtml.cintamadigital.site/catatan.php?action=update_data_catatan&id="+id,
         method: "POST",
         timeout: 0,
         processData: false,
         mimeType: "multipart/form-data",
         contentType: false,
         data: form,
         success:function(response){
            //console.log(response)
            viewData()
            getKalkulasi()
            getJumlahMasuk()
            getJumlahKeluar()
            modal.style.display = "none";
            document.getElementById("myAlert").style.display = "block"
            document.getElementById("dataAlert").innerHTML = '<div class="detail">Data Berhasil di-update</div>'
            closeAlert()
         }
       })
    }
    function deleteData(confirm){
      var id = $("#dataId").html()
      if(confirm == 'no'){
        return false
      }else if(confirm == 'yes'){
      $.ajax({
         url: "https://filehtml.cintamadigital.site/catatan.php?action=delete_data_catatan&id="+id,
         method: "GET",
         timeout: 0,
         success:function(response){
          //  console.log(response)
            viewData()
            getKalkulasi()
            getJumlahMasuk()
            getJumlahKeluar()
            document.getElementById("myAlert").style.display = "block"
            document.getElementById("dataAlert").innerHTML = '<div class="detail">Data Berhasil di hapus</div>'
            closeAlert()
         }
      })
     }
    }
    function viewModal(judul, jumlah, id, tipe){
      modal.style.display = "block"
      $("#editJudul").val(judul)
      $("#editJumlah").val(jumlah)
      $("#noneId").val(id)
      $("#noneTipe").val(tipe)
    }
    function viewPengingat() {
      $.ajax({
         url: "https://filehtml.cintamadigital.site/pengingat.php?action=get_data&email={{email_user}}",
         method: "GET",
         timeout: 0,
         beforeSend:function(){
           $("#datapengingat").html(`<center><div id="loader" class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></center>`)
         },
         success:function(response){
         //  console.log(response)
           // console.log(response.message)
            if(response.message == 'No Data Found'){
              $("#showBtnP").html(`<button class="button active" onclick="viewModalPengingat()">Catat Pengingat</button>`)
              $("#datapengingat").html(`<div class="text-center"><img width="300" src="https://cdn.genspedia.com/upload/images (2).jpeg" alt=""></div>`)
              return false
            }else{
            setTimeout(function(){
            var datas = response.data
            for (let i = 0; i < datas.length; i++ ){
            //console.log(datas[i]['judul'])
          var judul  = datas[i]['judul']
          var content = datas[i]['content']
          var id  = datas[i]['id']
          var tanggal = datas[i]['waktu']
           // console.log(id) 
           $("#showBtnP").html(`<button class="button active" onclick="viewModalPengingat()">Catat Pengingat</button>`)
           $("#datapengingat").append(`<div class="card mt-1">
      <div class="row">
        <div class="col">
          <p class="detail">`+judul+`</p>
        </div>
        <div class="col text-end">
          <p class="tgl">`+tanggal+`</p>
          <div class="row text-end">
            <div class="col"></div>
            <div class="col-2">
              <i onclick="viewEditP('`+judul+`', '`+content+`','`+id+`')" class="bi bi-pencil-square"></i>
            </div>
            <div class="col-3">
              <i onclick="alertDelP('`+judul+`','`+id+`')" class="bi bi-trash"></i>
            </div>
          </div>
        </div>
      </div>
     <p class="detail tgl mt-2">`+content+`</p>
    </div>`)
            }
      $("#loader").css('display', 'none')      
          },1000)
         }
         }
      })
    }
    function viewModalPengingat(){
      document.getElementById("modalPengingatInsert").style.display = "block"
      $("#editJudul").val(judul)
      $("#editJumlah").val(jumlah)
      $("#noneId").val(id)
      $("#noneTipe").val(tipe)
    }
    function insertP(){
      closeDataFalse()
      var judul  = $("#judulP").val()
      var content = $("#contentP").val()
      
      var form = new FormData();
       form.append("judul", judul);
       form.append("content", content);
       form.append("email", "{{email_user}}"); 
       if(judul == ""){
         document.getElementById('falseToInsertP').textContent = 'Lengkapi data terlebih dahulu' 
         return false
       }else if(content == ""){
         document.getElementById('falseToInsertP').textContent = 'Lengkapi data terlebih dahulu' 
         return false
       }else{
         document.getElementById('falseToInsertP').textContent = ''
       $.ajax({
         url: "https://filehtml.cintamadigital.site/pengingat.php?action=insert_data",
         method: "POST",
         timeout: 0,
         processData: false,
         mimeType: "multipart/form-data",
         contentType: false,
         data: form,
         success:function(response){
           // console.log(response)
            viewPengingat()
            getKalkulasi()
            getJumlahMasuk()
            getJumlahKeluar()
            document.getElementById('modalPengingatInsert').style.display = "none"
            document.getElementById("myAlert").style.display = "block"
            document.getElementById("dataAlert").innerHTML = '<div class="detail">Data Berhasil di-tambahkan</div>'
            closeAlert()
         }
       })
       }
    }
    
    function editP(){
      var judul  = $("#editjdP").val()
      var content = $("#editcntP").val()
      var id = $("#idP").val()
      
      var form = new FormData();
       form.append("judul", judul);
       form.append("content", content);
       $.ajax({
         url: "https://filehtml.cintamadigital.site/pengingat.php?action=edit_data&id="+id,
         method: "POST",
         timeout: 0,
         processData: false,
         mimeType: "multipart/form-data",
         contentType: false,
         data: form,
         success:function(response){
           // console.log(response)
            viewPengingat()
            getKalkulasi()
            getJumlahMasuk()
            getJumlahKeluar()
            document.getElementById('myModalInsert').style.display = "none";
            document.getElementById("myAlert").style.display = "block"
            document.getElementById("dataAlert").innerHTML = '<div class="detail">Data Berhasil di ubah</div>'
            closeAlert()
         }
       })
    }
    function viewEditP(judul, content, id){
      document.getElementById('editP').style.display = "block"
      $("#editjdP").val(judul)
      $("#editcntP").val(content)
      $("#idP").val(id)
    }
    function alertDelP(dataJu, datId){
      document.getElementById('alertDeleteP').style.display = 'block'
      $("#pSubj").html(dataJu)
      $("#dataPId").html(datId)
    }
    function deleteDataP(confirm){
      var id = $("#dataPId").html()
      if(confirm == 'no'){
        return false
      }else if(confirm == 'yes'){
      $.ajax({
         url: "https://filehtml.cintamadigital.site/pengingat.php?action=delete_data&id="+id,
         method: "GET",
         timeout: 0,
         success:function(response){
           // console.log(response)
            viewPengingat()
            getKalkulasi()
            getJumlahMasuk()
            getJumlahKeluar()
            document.getElementById("myAlert").style.display = "block"
            document.getElementById("dataAlert").innerHTML = '<div class="detail">'+response.message+'</div>'
            closeAlert()
         }
      })
     }
    }
    
    var modal = document.getElementById("myModal") 
   
    
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
       modal.style.display = "none";
       document.getElementById("myAlert").style.display = "none"
    }

     window.onclick = function(event) {
       if (event.target == modal) {
          modal.style.display = "none"
       }
     }
    //insert data catatan 
      // edit data catatan 
    
// Get the <span> element that closes the modal
  
  </script>
 <div style="margin-bottom:100px"></div>
</body>
</html>
<?php require _DIR_('library/footer/user') ?>