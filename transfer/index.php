<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');
$page = 'Transfer Bank';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-deposit">

        <div class="section service">

        <form method="POST" action="konfirmasi-transfer" id="konfirmasi">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="wide-block-service">
                
            <? require _DIR_('library/session/result-mobile') ?>

                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                        <div class="icon-box bg-primary">
                                <ion-icon name="business-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper"> 
                                        <form id="cek-rekening-form" method="get" action="">
                                        <label class="label">Bank Tujuan</label>
                                        <select class="form-select" id="codebank" name="codebank">
                                            <option selected disabled>Nama Bank</option>
                                            <option value="567">ALLO BANK INDONESIA</option>
                                            <option value="040">BANGKOK BANK</option>
                                            <option value="116">BANK ACEH SYARIAH</option>
                                            <option value="947">BANK ALADIN SYARIAH</option>
                                            <option value="531">BANK AMAR INDONESIA</option>
                                            <option value="061">BANK ANZ INDONESIA</option>
                                            <option value="037">BANK ARTHA GRAHA INTERNASIONAL</option>
                                            <option value="137">BANK BANTEN</option>
                                            <option value="014">BANK BCA</option>
                                            <option value="536">BANK BCA SYARIAH</option>
                                            <option value="133">BANK BENGKULU</option>
                                            <option value="459">BANK BISNIS INTERNASIONAL</option>
                                            <option value="110">BANK BJB</option>
                                            <option value="425">BANK BJB SYARIAH</option>
                                            <option value="009">BANK BNI</option>
                                            <option value="057">BANK BNP PARIBAS INDONESIA</option>
                                            <option value="002">BANK BRI</option>
                                            <option value="451">BANK BSI</option>
                                            <option value="200">BANK BTN</option>
                                            <option value="213">BANK BTPN</option>
                                            <option value="547">BANK BTPN SYARIAH</option>
                                            <option value="076">BANK BUMI ARTA</option>
                                            <option value="054">BANK CAPITAL INDONESIA</option>
                                            <option value="036">BANK CCB INDONESIA</option>
                                            <option value="022">BANK CIMB NIAGA</option>
                                            <option value="950">BANK COMMONWEALTH</option>
                                            <option value="949">BANK CTBC INDONESIA</option>
                                            <option value="011">BANK DANAMON</option>
                                            <option value="046">BANK DBS INDONESIA</option>
                                            <option value="501">BANK DIGITAL BCA</option>
                                            <option value="111">BANK DKI</option>
                                            <option value="562">BANK FAMA INTERNASIONAL</option>
                                            <option value="161">BANK GANESHA</option>
                                            <option value="087">BANK HSBC INDONESIA</option>
                                            <option value="945">BANK IBK INDONESIA</option>
                                            <option value="164">BANK ICBC INDONESIA</option>
                                            <option value="513">BANK INA PERDANA</option>
                                            <option value="555">BANK INDEX SELINDO</option>
                                            <option value="095">BANK J TRUST INDONESIA</option>
                                            <option value="542">BANK JAGO</option>
                                            <option value="472">BANK JASA JAKARTA</option>
                                            <option value="113">BANK JATENG</option>
                                            <option value="114">BANK JATIM</option>
                                            <option value="123">BANK KALBAR</option>
                                            <option value="124">BANK KALTIMTARA</option>
                                            <option value="441">BANK KB BUKOPIN</option>
                                            <option value="521">BANK KB BUKOPIN SYARIAH</option>
                                            <option value="484">BANK KEB HANA</option>
                                            <option value="121">BANK LAMPUNG</option>
                                            <option value="131">BANK MALUKU MALUT</option>
                                            <option value="008">BANK MANDIRI</option>
                                            <option value="564">BANK MANDIRI TASPEN</option>
                                            <option value="157">BANK MASPION INDONESIA</option>
                                            <option value="097">BANK MAYAPADA</option>
                                            <option value="553">BANK MAYORA</option>
                                            <option value="426">BANK MEGA</option>
                                            <option value="506">BANK MEGA SYARIAH</option>
                                            <option value="151">BANK MESTIKA DHARMA</option>
                                            <option value="048">BANK MIZUHO INDONESIA</option>
                                            <option value="485">BANK MNC INTERNASIONAL</option>
                                            <option value="147">BANK MUAMALAT INDONESIA</option>
                                            <option value="548">BANK MULTIARTA SENTOSA</option>
                                            <option value="118">BANK NAGARI</option>
                                            <option value="503">BANK NATIONALNOBU</option>
                                            <option value="490">BANK NEO COMMERCE</option>
                                            <option value="128">BANK NTB SYARIAH</option>
                                            <option value="130">BANK NTT</option>
                                            <option value="145">BANK NUSANTARA PARAHYANGAN</option>
                                            <option value="028">BANK OCBC NISP</option>
                                            <option value="033">BANK OF AMERICA</option>
                                            <option value="069">BANK OF CHINA (HONG KONG)</option>
                                            <option value="146">BANK OF INDIA INDONESIA</option>
                                            <option value="526">BANK OKE INDONESIA</option>
                                            <option value="019">BANK PANIN</option>
                                            <option value="517">BANK PANIN DUBAI SYARIAH</option>
                                            <option value="132">BANK PAPUA</option>
                                            <option value="013">BANK PERMATA</option>
                                            <option value="167">BANK QNB INDONESIA</option>
                                            <option value="494">BANK RAYA INDONESIA</option>
                                            <option value="047">BANK RESONA PERDANIA</option>
                                            <option value="119">BANK RIAU KEPRI</option>
                                            <option value="523">BANK SAHABAT SAMPOERNA</option>
                                            <option value="498">BANK SBI INDONESIA</option>
                                            <option value="152">BANK SHINHAN INDONESIA</option>
                                            <option value="153">BANK SINARMAS</option>
                                            <option value="126">BANK SULSELBAR</option>
                                            <option value="134">BANK SULTENG</option>
                                            <option value="135">BANK SULTRA</option>
                                            <option value="127">BANK SULUTGO</option>
                                            <option value="045">BANK SUMITOMO MITSUI INDONESIA</option>
                                            <option value="120">BANK SUMSEL BABEL</option>
                                            <option value="117">BANK SUMUT</option>
                                            <option value="023">BANK UOB INDONESIA</option>
                                            <option value="566">BANK VICTORIA INTERNATIONAL</option>
                                            <option value="405">BANK VICTORIA SYARIAH</option>
                                            <option value="212">BANK WOORI SAUDARA</option>
                                            <option value="129">BPD BALI</option>
                                            <option value="112">BPD DIY</option>
                                            <option value="115">BPD JAMBI</option>
                                            <option value="122">BPD KALSEL</option>
                                            <option value="125">BPD KALTENG</option>
                                            <option value="688">BPR KARYAJATNIKA SADAYA</option>
                                            <option value="600">BPR SUPRA ARTAPERSADA</option>
                                            <option value="031">CITIBANK</option>
                                            <option value="067">DEUTSCHE BANK AG.</option>
                                            <option value="032">JP MORGAN CHASE BANK N.A.</option>
                                            <option value="016">MAYBANK INDONESIA</option>
                                            <option value="042">MUFG BANK</option>
                                            <option value="520">PRIMA MASTER BANK</option>
                                            <option value="535">SEABANK INDONESIA</option>
                                            <option value="050">STANDARD CHARTERED BANK</option>
                                        </select>
                                    </div>
                                    <span id="check-bank"></span>
                                </div>
                            </div>
                        </div>
                    </li> 
                    <li>
                        <div class="item"> 
                        <div class="icon-box bg-primary">
                                <ion-icon name="card-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">No Rekening</label>
                                        <input type="number" class="form-control" placeholder="1122334455" id="accountnumber" name="account" onInput="checkBank()"/>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div> 
                                   <span id="check-bank"></span>
                                </div>
                            </div>
                        </div> 
                                <button type="submit" class="btn btn-primary" name="cek-rekening-form" id="cek-rekening-form">Cek Rekening</button>
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                                </form>
                    </li>  
                     <?php 
                        if(isset($_GET['cek-rekening-form'])){
                        $codebank = $_GET['codebank'];
                        $accountnumber = $_GET['accountnumber'];
    
                        // Menampilkan notifikasi "Processing, mohon tunggu..." sebagai popup
                        echo '<script>document.getElementById("processingPopup").classList.add("active");</script>';
    
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,"https://api-rekening.lfourr.com/getBankAccount?bankCode=$codebank&accountNumber=$accountnumber");
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            
                        $result = curl_exec($ch);
                            curl_close($ch);
                        $res = json_decode($result, true);
    
                        // Mengecek apakah data ditemukan
                        if($res["status"] === true) {
                            $data = $res["data"];
                        }
    
                        // Menghapus notifikasi "Processing, mohon tunggu..." setelah mendapatkan hasil
                            echo '<script>document.getElementById("processingPopup").classList.remove("active");</script>';
                        }
                        ?>
                    
                    <li>
                        <div class="item"> 
                        <div class="icon-box bg-primary">
                                <ion-icon name="person-circle-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Atas Nama</label>  
                                        <input type="text" class="form-control" placeholder="Atas Nama" name="name"/> 
                                        <?php if(isset($_GET['cek-rekening-form']) && $res["status"] === true) { ?>
                                        <input type="text" class="form-control" placeholder="<?php echo $data["accountname"]; ?>" name="name"/> 
                                        <?php } elseif(isset($_GET['cek-rekening-form']) && $res["status"] === false) { ?> 
                                        <input type="text" class="form-control" placeholder="Nama Tidak Ditemukan" name="name"/> 
                                         <?php } ?>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                    <span id="check-bank"></span>
                                </div>
                            </div>
                        </div>
                    </li> 
                    
                    <li>
                        <div class="item">
                        <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nominal</label>
                                        <input type="number" class="form-control" placeholder="10.000" name="nominal" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

        </div>
        
    </div>
        
        <div class="m-2">
            <h4 class="text-center mt-2">Pilih Nominal Cepat</h4>
            <div class="row text-center">
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('10000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 10.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('25000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 25.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('50000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 50.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('100000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 100.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('250000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 250.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('500000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 500.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
        </div>
      
            <div class="form-button-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg" name="konfirmasi">Lanjutkan</a>
            </div>
        </form>

        </div>
    </div>
    <!-- * App Capsule -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        function checkBank() {
            
            $.ajax({
            url: "<?= ajaxlib('check-bank.php') ?>",
            data: 'rek='+$("#rek").val(),,
            type: "POST",
            success:function(data){
            $("#check-bank").html(data);
         },
            error:function (){}
         });
        }
    </script>

<?php require _DIR_('library/footer/user') ?>