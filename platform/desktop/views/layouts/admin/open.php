<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title><?= $_CONFIG['title'].' | '.get_title(); ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= desktop_assets('css/dashlite.css?ver=2.2.0'); ?>">
    <link id="skin-default" rel="stylesheet" href="<?= desktop_assets('css/theme.css?ver=2.2.0'); ?>">
    <link id="skin-blue" rel="stylesheet" href="<?= desktop_assets('css/skins/theme-blue.css?ver=2.2.0'); ?>">
</head>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?= component('admin_sidebar'); ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?= component('admin_header'); ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">