<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Tentang Kami';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full">
            <img src="<?= assets('mobile/img/home/texture1.jpeg'); ?>" alt="image" class="imaged square w-100">
        </div>

        <div class="section full">
            <div class="wide-block pt-2">
                <p>
                    <?= $_CONFIG['description'] ?>
                </p>
            </div>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="section-title">Kontak Kami</div>
            <ul class="listview image-listview media">
                <? 
                $search = $call->query("SELECT * FROM contact WHERE level NOT IN ('developer', 'web desainer') ORDER BY name ASC");
                while($row = $search->fetch_assoc()):
                ?>
                <li>
                    <a href="<?= 'https://wa.me/'.$row['whatsapp'] ?>" class="item">
                        <div class="imageWrapper">
                            <img src="<?= $row['url_foto'] ?>" alt="image" class="imaged w64">
                        </div>
                        <div class="in">
                            <div>
                                <?= $row['name'] ?>
                                <div class="text-muted"><?= strtoupper($row['level']) ?></div>
                            </div>
                        </div>
                    </a>
                </li>
                <? endwhile ?>
            </ul>
        </div>

        <div class="section full mt-2 mb-2">
            <div class="section-title">Tim Kami</div>
            <ul class="listview image-listview media">
                <? 
                $search = $call->query("SELECT * FROM contact WHERE level NOT IN ('ceo & founder', 'admin', 'staff') ORDER BY name ASC");
                while($row = $search->fetch_assoc()):
                ?>
                <li>
                    <a href="<?= 'https://wa.me/'.$row['whatsapp'] ?>" class="item">
                        <div class="imageWrapper">
                            <img src="<?= assets('mobile/img/sample/avatar/avatar1.jpg'); ?>" alt="image" class="imaged w64">
                        </div>
                        <div class="in">
                            <div>
                                <?= $row['name'] ?>
                                <div class="text-muted"><?= strtoupper($row['level']) ?></div>
                            </div>
                        </div>
                    </a>
                </li>
                <? endwhile ?>
            </ul>
        </div>

    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>