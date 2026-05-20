<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="<?= desktop_url(); ?>" class="logo-link">
                    <img class="logo-light logo-img" src="<?= desktop_assets('images/logo.png'); ?>" srcset="<?= desktop_assets('images/logo2x.png 2x'); ?>" alt="logo">
                    <img class="logo-dark logo-img" src="<?= desktop_assets('images/logo-dark.png'); ?>" srcset="<?= desktop_assets('images/logo-dark2x.png 2x'); ?>" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-search ml-3 ml-xl-0">
                <em class="icon ni ni-search"></em>
                <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search anything">
            </div><!-- .nk-header-news -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar">
                                    <div class="user-avatar">
                                        <span><?= alias(user('name')); ?></span>
                                    </div>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-status text-primary"><?= user('level'); ?></div>
                                    <div class="user-name dropdown-indicator"><?= user('name'); ?></div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span><?= alias(user('name')); ?></span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text"><?= user('name'); ?></span>
                                        <span class="sub-text"><?= user('email'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="<?= desktop_url('profile'); ?>"><em class="icon ni ni-user-alt"></em><span>Lihat Akun</span></a></li>
                                    <li><a href="#"><em class="icon ni ni-setting-alt"></em><span>Pengaturan Akun</span></a></li>
                                    <li><a href="#"><em class="icon ni ni-activity-alt"></em><span>Aktivitas Login</span></a></li>
                                    <?php if(user('level') === 'Admin'): ?>
                                    <li><a href="<?= desktop_url('admin'); ?>"><em class="icon ni ni-user-c"></em><span>Admin Panel</span></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="<?= desktop_url('logout'); ?>"><em class="icon ni ni-signout"></em><span>Keluar</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>