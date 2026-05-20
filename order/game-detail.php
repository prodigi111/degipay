<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('-',' ',filter($_GET['s'])) : '';

$search_cat = $call->query("SELECT * FROM category WHERE name = '$get_s' AND type IN ('games', 'voucher-game')");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('order/games')));
$data_cat = $search_cat->fetch_assoc();
$operator = strtolower($data_cat['name']);

$list_zoneid = ['mobile legend', 'lifeafter credits', 'ragnarok m: eternal love', 'tom and jerry : chase', 'knights of valour', 'scroll of onmyoji'];

if($data_cat['type'] == 'games'):
    $label = 'ID Game';
    $text = $data_cat['detect'] == 'true' ? '</b>, Layanan Akan Muncul Setelah Nickname Ditemukan.' : '</b>, Layanan Akan Muncul Setelah Mengetikkan ID Game.';
    $alert = 'ID Game Di Isi Dengan ID Game <b>'.ucwords($operator).$text;
    $type = 'text';
    else:
        $label = 'Nomor HP';
        $alert = 'Masukkan Nomor HP Dengan Benar, Layanan Akan Muncul Setelah Mengetikkan Nomor HP Di Atas 4 Angka.';
        $type = 'number';
        endif;
        
require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : ucwords($operator);
require _DIR_('library/header/user');
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">
        <div class="section service" style="background-color: #000957;border-color:#000957;
">
            <div class="wide-block-service">
                <form id="myForm">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label"><?= $label ?></label>
                                        <input type="<?= $type ?>" class="form-control" placeholder="Masukkan <?= $label ?> Terlebih Dahulu" name="data" id="data" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <? if(in_array($operator, ['mobile legend'])) : ?>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Zone ID</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Zone ID" name="data2" id="data2" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <? elseif(in_array($operator, ['ragnarok m: eternal love', 'tom and jerry : chase'])) : ?>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Server</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Server" name="data2" id="data2" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <? elseif($operator == 'lifeafter credits') : ?>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper not-empty">
                                        <label class="label">Server</label>
                                        <select class="form-control custom-select" name="data2" id="data2" required>
                                            <option value="">Pilih Server</option>
                                            <option value="MiskaTown">MiskaTown</option>
                                            <option value="SandCastle">SandCastle</option>
                                            <option value="MouthSwamp">MouthSwamp</option>
                                            <option value="RedwoodTown">RedwoodTown</option>
                                            <option value="Obelisk">Obelisk</option>
                                            <option value="FallForest">FallForest</option>
                                            <option value="MountSnow">MountSnow</option>
                                            <option value="NancyCity">NancyCity</option>
                                            <option value="CharlesTown">CharlesTown</option>
                                            <option value="SnowHighlands">SnowHighlands</option>
                                            <option value="Santopany">Santopany</option>
                                            <option value="LevinCity">LevinCity</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <? elseif($operator == 'knights of valour') : ?>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper not-empty">
                                        <label class="label">Server</label>
                                        <select class="form-control custom-select" name="data2" id="data2" required>
                                            <option value="">Pilih Server</option>
                                            <option value="800090">Google Play</option>
                                            <option value="800092">App Store</option>
                                            <option value="800089">Huawei AppGallery</option>
                                            <option value="160856">Oppo App Market</option>
                                            <option value="160861">Vivo App Market</option>
                                            <option value="160860">Xiaomi App Market</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <? elseif($operator == 'scroll of onmyoji') : ?>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper not-empty">
                                        <label class="label">Server</label>
                                        <select class="form-control custom-select" name="data2" id="data2" required>
                                            <option value="">Pilih Server</option>
                                            <option value="3">S1-Taman sakura</option>
                                            <option value="4">S2-Akademi Mitama/S3-Gunung roh</option>
                                            <option value="6">S4-Ketiadaan/S5-Kosong/S6-Stargate</option>
                                            <option value="9">S7-Realm Takdir/S8-Reruntuhan/S9-Kuil Cahaya</option>
                                            <option value="12">S10-Pavilion langit/S11-Taman impian/S12-Hutan diam</option>
                                            <option value="15">S13-Jalur Langit/S14-Pencarian Buluh/S15-Misteri Elf</option>
                                            <option value="18">S16-Hutan roh iblis/S17-Laut dalam/S18-Kuil Beruang</option>
                                            <option value="21">S19-Domain kegelapan/S20-Distorsi/S21-Kenshi</option>
                                            <option value="24">S22-Uzume/S23-Fujin/S24-Inari</option>
                                            <option value="27">S25-Shikoku/S26-Okami/S27-Nagi</option>
                                            <option value="30">S28-Kojiki/S29-Raijin/S30-Suijin</option>
                                            <option value="33">S31-Susanoo/S32-Orochi/S33-Tenjin</option>
                                            <option value="36">S34-Otohime/S35-Ame/S36-Kaguya</option>
                                            <option value="39">S37-Hana/S38-Kojin/S39-Mikoto</option>
                                            <option value="42">S40-Jizo/S41-Konoha/S42-Aizen</option>
                                            <option value="45">S43-Kannon/S44-Ebisu/S45-Danau berkabut</option>
                                            <option value="48">S46-Gunung monster/S47-Kota Bulan/S48-Hutan Ajaib</option>
                                            <option value="51">S49-Balai Bumi/S50-Oiwa/S51-Sazae Oni</option>
                                            <option value="54">S52-Yama Uba/S53-Hannya/S54-Namanari</option>
                                            <option value="57">S55-Ikiryo/S56-Chunari/S57-Honnari</option>
                                            <option value="60">S58-Ubume/S59-Nure Onna/S60-Nukekubi</option>
                                            <option value="63">S61-Rokurkubi/S62-Ubagabi/S63-Hone Onna</option>
                                            <option value="66">S64-Akashita/S65-Kiyohime/S66-Obake</option>
                                            <option value="69">S67-Kamaitaichi/S68-Kekkai</option>
                                            <option value="71">S69-Isonade/S70-Masakatsu</option>
                                            <option value="73">Yasumori/Mototsuna</option>
                                            <option value="75">Kagemori</option>
                                            <option value="76">Terukage</option>
                                            <option value="77">Mitsuhide</option>
                                            <option value="78">Nobutomo</option>
                                            <option value="79">Yoshihisa</option>
                                            <option value="80">Morinari</option>
                                            <option value="81">Shigetsuna</option>
                                            <option value="82">Yurei</option>
                                            <option value="83">Aokage</option>
                                            <option value="84">Muratsugu</option>
                                            <option value="85">Arima</option>
                                            <option value="86">Hisamasa</option>
                                            <option value="87">Nagaharu</option>
                                            <option value="88">Morichika</option>
                                            <option value="89">Shigezane</option>
                                            <option value="90">Masamune</option>
                                            <option value="91">Toshikatsu</option>
                                            <option value="92">S90-Fusahide</option>
                                            <option value="93">S91-Ujisato</option>
                                            <option value="94">S92-Naomasa</option>
                                            <option value="95">S93-Tsunenaga</option>
                                            <option value="96">S94-Hattori</option>
                                            <option value="97">S95-Hideharu</option>
                                            <option value="98">S96-Kennyo</option>
                                            <option value="99">S97-Masatoshi</option>
                                            <option value="100">S98-Tsuneoki</option>
                                            <option value="101">S99-Isshiki</option>
                                            <option value="102">S100-Imagawa</option>
                                            <option value="103">S101-Hiroie</option>
                                            <option value="104">S102-Yukinaga</option>
                                            <option value="105">S103-Hisamichi</option>
                                            <option value="106">S104-Matsudaira</option>
                                            <option value="107">S105-Hatobo</option>
                                            <option value="108">S106-Nageki</option>
                                            <option value="109">S107-Kappa</option>
                                            <option value="110">S108-Ryuo</option>
                                            <option value="111">S109-Nozuchi</option>
                                            <option value="112">S110-Yosei</option>
                                            <option value="113">S111-Ushirogami</option>
                                            <option value="114">S112-Tsurube</option>
                                            <option value="115">S113-Tsukuyomi</option>
                                            <option value="116">S114-Momonji</option>
                                            <option value="117">S115-Suzaku</option>
                                            <option value="118">S116-Seiryuu</option>
                                            <option value="119">S117-Byakko</option>
                                            <option value="120">S118-Genbu</option>
                                            <option value="121">S119-Shiryo</option>
                                            <option value="122">S120-Kahaku</option>
                                            <option value="123">S121-Rojinbi</option>
                                            <option value="124">S122-Onryo</option>
                                            <option value="125">S123-Kasha</option>
                                            <option value="126">S124-Tenko</option>
                                            <option value="127">S125-Nue</option>
                                            <option value="128">S126-Yuki-Onna</option>
                                            <option value="129">S127-Mononoke</option>
                                            <option value="130">S128-Okiku</option>
                                            <option value="131">S129-Kodama</option>
                                            <option value="132">S130-Issie</option>
                                            <option value="133">S131-Hakano</option>
                                            <option value="134">S132-Gyuki</option>
                                            <option value="135">S133-Funayurei</option>
                                            <option value="136">S134-Dodomeki</option>
                                            <option value="137">S135-Kosagi</option>
                                            <option value="138">S136-Kirin</option>
                                            <option value="139">S137-Amesu</option>
                                            <option value="140">S138-Akubozu</option>
                                            <option value="141">S139-Yuuki</option>
                                            <option value="142">S140-Supia</option>
                                            <option value="143">S141-Onisuzume</option>
                                            <option value="144">S142-Nyoromo</option>
                                            <option value="145">S143-Kishi</option>
                                            <option value="146">S144-Utsudon</option>
                                            <option value="147">S145-Nashi</option>
                                            <option value="148">S146-Myuu</option>
                                            <option value="149">S147-Kabuto</option>
                                            <option value="150">S148-Iibui</option>
                                            <option value="151">S149-Azumao</option>
                                            <option value="152">S150-Rakki</option>
                                            <option value="153">S151-Ebiwara</option>
                                            <option value="154">S152-Tama</option>
                                            <option value="155">S153-Jugon</option>
                                            <option value="156">S154-Koiru</option>
                                            <option value="157">S155-Gyaropu</option>
                                            <option value="158">S156-Uindie</option>
                                            <option value="159">S157-Soma</option>
                                            <option value="160">S158-Rokon</option>
                                            <option value="161">S159-Korata</option>
                                            <option value="162">S160-Catapi</option>
                                            <option value="163">S161-Suripu</option>
                                            <option value="164">S162-Hitokage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <? endif; ?>
                </ul>
                </form>
                <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                <ul class="nav nav-tabs style1 mt-1" role="tablist" id="tabpanel">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#Server1" role="tab">
                            Server 1
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Server2" role="tab">
                            Server 2
                        </a>
                    </li>
                </ul>
                <? endif; ?>
            </div>
        </div>
        
        <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="Server1" role="tabpanel">
                <? if($data_cat['code'] == 'MOBILE LEGEND' || $data_cat['code'] == 'FREE FIRE' || $data_cat['code'] == 'PUBG MOBILE') : ?>
                <div class="wide-block">
                    <ul class="nav nav-tabs lined" role="tablist" id="tab-list">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#Diamonds" role="tab">
                                Diamonds
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#Packages" role="tab">
                                Membership
                            </a>
                        </li>
                    </ul>
                </div>
                <? endif; ?>
                
                <div class="section mt-2 mb-1">
                    
                    <? require _DIR_('library/session/result-mobile') ?>
                    
                    <div class="alert alert-info text-center fade show mb-2" role="alert" id="info-alert">
                        <small>
                            <?= $call->query("SELECT * FROM provider WHERE code != 'X'")->fetch_assoc()['info'] ?>
                        </small>
                    </div>
                    
                    <div class="alert alert-warning text-left fade show mb-2" role="alert"><?= $alert ?></div>
                </div>
            
                <? if($data_cat['code'] == 'MOBILE LEGEND' || $data_cat['code'] == 'FREE FIRE' || $data_cat['code'] == 'PUBG MOBILE') : ?>
                <div class="tab-content mt-2">
                    <div class="tab-pane fade show active" id="Diamonds" role="tabpanel">
                        <div class="section rgs-list-layanan">
                            <?php
                            $search = $call->query("SELECT * FROM srv WHERE brand = '".$data_cat['code']."' AND provider = 'DIGI' AND type = 'games' AND kategori = 'Umum' ORDER BY price ASC");
                            if($search->num_rows == FALSE) { ?>
                            <div class="alert alert-danger text-left fade show" role="alert">
                                Tidak Ada Layanan Yang Tersedia!
                            </div>
                            <? } ?>
                            <div class="row rgs-show">
                                <? 
                                while($row = $search->fetch_assoc()) {
                                ?>
                                <div class="col-12 mb-2">
                                    <? if($row['status'] == 'available') : ?>
                                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                    <? else: ?>
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? endif ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Packages" role="tabpanel">
                        <div class="section rgs-list-layanan">
                            <?php
                            $search = $call->query("SELECT * FROM srv WHERE brand = '".$data_cat['code']."' AND provider = 'DIGI' AND type = 'games' AND kategori = 'Membership' ORDER BY price ASC");
                            if($search->num_rows == FALSE) { ?>
                            <div class="alert alert-danger text-left fade show" role="alert">
                                Tidak Ada Layanan Yang Tersedia!
                            </div>
                            <? } ?>
                            <div class="row rgs-show2">
                                <? 
                                while($row = $search->fetch_assoc()) {
                                ?>
                                <div class="col-12 mb-2">
                                    <? if($row['status'] == 'available') : ?>
                                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                    <? else: ?>
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? endif ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="section rgs-list-layanan">
                    <?php
                    $search = $call->query("SELECT * FROM srv WHERE type IN ('games', 'voucher-game') AND brand = '$operator' AND provider = 'DIGI' ORDER BY price ASC");
                    if($search->num_rows == FALSE) { ?>
                    <div class="alert alert-danger text-left fade show" role="alert">
                        Tidak Ada Layanan Yang Tersedia!
                    </div>
                    <? } ?>
                        <div class="row rgs-show">
                            <? 
                            while($row = $search->fetch_assoc()) {
                            ?>
                            <div class="col-12 mb-2">
                                <? if($row['status'] == 'available') : ?>
                                <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                                <? else: ?>
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endif ?>
                        <?php } ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="Server2" role="tabpanel">
                <? if($data_cat['code'] == 'MOBILE LEGEND' || $data_cat['code'] == 'FREE FIRE' || $data_cat['code'] == 'PUBG MOBILE') : ?>
                <div class="wide-block">
                    <ul class="nav nav-tabs lined" role="tablist" id="tab-list1">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#Diamonds1" role="tab">
                                Diamonds
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#Packages1" role="tab">
                                Membership
                            </a>
                        </li>
                    </ul>
                </div>
                <? endif; ?>
                
                <div class="section mt-2 mb-1">
                    <? require _DIR_('library/session/result-mobile') ?>
                    
                    <div class="alert alert-info text-center fade show mb-2" role="alert" id="info-alert1">
                        <small>
                            <?= $call->query("SELECT * FROM provider WHERE code = 'X'")->fetch_assoc()['info'] ?>
                        </small>
                    </div>
                    
                    <div class="alert alert-warning text-left fade show mb-2" role="alert">LAYANAN AKAN MUNCUL SETELAH MENGETIK ID GAME</div>
                </div>
            
                <? if($data_cat['code'] == 'MOBILE LEGEND' || $data_cat['code'] == 'FREE FIRE' || $data_cat['code'] == 'PUBG MOBILE') : ?>
                <div class="tab-content mt-2">
                    <div class="tab-pane fade show active" id="Diamonds1" role="tabpanel">
                        <div class="section rgs-list-layanan">
                            <?php
                            $search = $call->query("SELECT * FROM srv WHERE brand = '".$data_cat['code']."' AND provider = 'X' AND type = 'games' AND kategori = 'Umum' ORDER BY price ASC");
                            if($search->num_rows == FALSE) { ?>
                            <div class="alert alert-danger text-left fade show" role="alert">
                                Tidak Ada Layanan Yang Tersedia!
                            </div>
                            <? } ?>
                            <div class="row rgs-show">
                                <? 
                                while($row = $search->fetch_assoc()) {
                                ?>
                                <div class="col-12 mb-2">
                                    <? if($row['status'] == 'available') : ?>
                                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                    <? else: ?>
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? endif ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Packages1" role="tabpanel">
                        <div class="section rgs-list-layanan">
                            <?php
                            $search = $call->query("SELECT * FROM srv WHERE brand = '".$data_cat['code']."' AND provider = 'X' AND type = 'games' AND kategori = 'Membership' ORDER BY price ASC");
                            if($search->num_rows == FALSE) { ?>
                            <div class="alert alert-danger text-left fade show" role="alert">
                                Tidak Ada Layanan Yang Tersedia!
                            </div>
                            <? } ?>
                            <div class="row rgs-show2">
                                <? 
                                while($row = $search->fetch_assoc()) {
                                ?>
                                <div class="col-12 mb-2">
                                    <? if($row['status'] == 'available') : ?>
                                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                    <? else: ?>
                                        <div class="card">
                                            <div class="card-body p-0" align="right">
                                                <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                            </div>
                                            <div class="card-body" style="padding:5px 15px 15px">
                                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                                <div class="row">
                                                    <div class="col-12 text-left">
                                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? endif ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="section rgs-list-layanan">
                    <?php
                    $search = $call->query("SELECT * FROM srv WHERE type IN ('games', 'voucher-game') AND brand = '$operator' AND provider = 'X' ORDER BY price ASC");
                    if($search->num_rows == FALSE) { ?>
                    <div class="alert alert-danger text-left fade show" role="alert">
                        Tidak Ada Layanan Yang Tersedia!
                    </div>
                    <? } ?>
                        <div class="row rgs-show">
                            <? 
                            while($row = $search->fetch_assoc()) {
                            ?>
                            <div class="col-12 mb-2">
                                <? if($row['status'] == 'available') : ?>
                                <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                                <? else: ?>
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endif ?>
                        <?php } ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        
        <div class="section mt-2 mb-1">
            <? require _DIR_('library/session/result-mobile') ?>
            
            <div class="alert alert-info text-center fade show mb-2" role="alert" id="info-alert">
                <small>
                    <?= $call->query("SELECT * FROM provider WHERE code != 'X'")->fetch_assoc()['info'] ?>
                </small>
            </div>
                    
            <div class="alert alert-warning text-left fade show mb-2" role="alert"><?= $alert ?></div>
        </div>
        
        <? if($data_cat['code'] == 'MOBILE LEGEND' || $data_cat['code'] == 'FREE FIRE' || $data_cat['code'] == 'PUBG MOBILE') : ?>
            <div class="tab-content mt-2">
                <div class="tab-pane fade show active" id="Diamonds" role="tabpanel">
                    <div class="section rgs-list-layanan">
                        <?php
                        $search = $call->query("SELECT * FROM srv WHERE brand = '".$data_cat['code']."' AND type = 'games' AND kategori = 'Umum' ORDER BY price ASC");
                        if($search->num_rows == FALSE) { ?>
                        <div class="alert alert-danger text-left fade show" role="alert">
                            Tidak Ada Layanan Yang Tersedia!
                        </div>
                        <? } ?>
                        <div class="row rgs-show">
                            <? 
                            while($row = $search->fetch_assoc()) {
                            ?>
                            <div class="col-12 mb-2">
                                <? if($row['status'] == 'available') : ?>
                                <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                                <? else: ?>
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endif ?>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Packages" role="tabpanel">
                    <div class="section rgs-list-layanan">
                        <?php
                        $search = $call->query("SELECT * FROM srv WHERE brand = '".$data_cat['code']."' AND type = 'games' AND kategori = 'Membership' ORDER BY price ASC");
                        if($search->num_rows == FALSE) { ?>
                        <div class="alert alert-danger text-left fade show" role="alert">
                            Tidak Ada Layanan Yang Tersedia!
                        </div>
                        <? } ?>
                        <div class="row rgs-show2">
                            <? 
                            while($row = $search->fetch_assoc()) {
                            ?>
                            <div class="col-12 mb-2">
                                <? if($row['status'] == 'available') : ?>
                                <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                                <? else: ?>
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endif ?>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="section rgs-list-layanan">
                <?php
                $search = $call->query("SELECT * FROM srv WHERE type IN ('games', 'voucher-game') AND brand = '$operator' ORDER BY price ASC");
                if($search->num_rows == FALSE) { ?>
                <div class="alert alert-danger text-left fade show" role="alert">
                    Tidak Ada Layanan Yang Tersedia!
                </div>
                <? } ?>
                        <div class="row rgs-show">
                            <? 
                            while($row = $search->fetch_assoc()) {
                            ?>
                            <div class="col-12 mb-2">
                                <? if($row['status'] == 'available') : ?>
                                <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                                <? else: ?>
                                    <div class="card">
                                        <div class="card-body p-0" align="right">
                                            <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                        </div>
                                        <div class="card-body" style="padding:5px 15px 15px">
                                            <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                            <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endif ?>
                        <?php } ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
    <!-- * App Capsule -->
<? endif ?>   
<?php require _DIR_('library/footer/user') ?>

<script type="text/javascript">
$(document).ready(function() {
    
<? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
    $("#tabpanel").hide();
    $("#tab-list1").hide();
    $("#info-alert1").hide();
<? endif ?>

<? if($data_cat['code'] == 'MOBILE LEGEND' || $data_cat['code'] == 'FREE FIRE') : ?>
    $(".rgs-show").hide();
    $(".rgs-show2").hide();
    $("#tab-list").hide();
    $("#info-alert").hide();
<? else: ?>
    $("#info-alert").hide();
    $(".rgs-show").hide();
<? endif ?>
    
    $('input[name="data"],input[name="data2"],select[name="data2"]').change(function(){
        var rDetect = '<?= $data_cat['detect'] ?>';
        var shennZone = <?= json_encode($list_zoneid) ?>;
        var target = $("#data").val();
        var target2 = $("#data2").val();
        var operator = '<?= $operator ?>';
        
        if(rDetect == 'true') {
            if(shennZone.includes(operator) == true && target != '' && target2 != '') {
                var postdata = 'category=' + operator + '&target=' + target + '&target2=' + target2;
                validasi(postdata);
            } else if(shennZone.includes(operator) == false && target != '') {
                var postdata = 'category=' + operator + '&target=' + target;
                validasi(postdata);
            }
        }
    });
    
    $('input[name="data"]').keyup(function(){
        var target = $("#data").val();
        
        if(target.length <= 4) {
            $(".rgs-show").hide();
            $("#info-alert").hide();
            <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                $("#tabpanel").hide();
                $("#tab-list1").hide();
                $("#info-alert1").hide();
            <? endif ?>
        } else {
            $(".rgs-show").show();
            $("#info-alert").show();
            <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                $("#tabpanel").show();
                $("#tab-list1").show();
                $("#info-alert1").show();
            <? endif ?>
        }
        
    });
    function validasi(postdata){
        
        $.ajax({
            url: '<?= ajaxlib('check-nick') ?>',
            data: postdata,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {
                Swal.fire({title:"Harap Tunggu...", showConfirmButton:false, allowOutsideClick:false});
            },
        
            
            success: function(shenn) {
                if(shenn.result == false){
                    Swal.fire('Ups...',' ' + shenn.message,'error');
                    $("#myForm").trigger("reset");
                    $(".rgs-show").hide();
                    $(".rgs-show2").hide();
                    $("#tab-list").hide();
                    $("#info-alert").hide();
                    <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                        $("#tab-list1").hide();
                        $("#tabpanel").hide();
                        $("#info-alert1").hide();
                    <? endif ?>
                    
                } else {
                    Swal.fire('Sukses !',"Player Id ditemukan",'success');
                    $("#displayname").val(decodeURI(shenn.data));
                    $(".rgs-show").show();
                    $(".rgs-show2").show();
                    $("#tab-list").show();
                    $("#info-alert").show();
                    <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                        $("#tab-list1").show();
                        $("#tabpanel").show();
                        $("#info-alert1").show();
                    <? endif ?>
                }
    		} 
    	});
    };
});

function ConfirmModal(link) {
    var target = $("#data").val();
    var target2 = $("#data2").val();
    target2 == '' || !target2 ? modalKonfirmasi('Konfirmasi Transaksi', link + target) : modalKonfirmasi('Konfirmasi Transaksi', link + target + '=' + target2);
}
</script>