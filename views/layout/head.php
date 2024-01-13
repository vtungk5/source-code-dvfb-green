<!doctype html>
<html lang="vi" class="">
<!-- giao diện tối class=dark | giao diện sáng xóa class đi -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php'; ?>
<head>
    <?php Auth::site_check(); ?>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title><?=Site::get('title');?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name="MobileOptimized" content="320">
    <meta http-equiv="content-language" content="vi" />
    <meta name="copyright" content="TUNGMMO " />
    <meta name="author" content="TUNGMMO " />
    <meta name="keyword" content="<?=Site::get('keyword');?>" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 days" />
    <meta http-equiv="content-language" content="vi" />
    <meta name="og:title" content="<?=Site::get('title');?>">
    <meta name="og:description" content="<?=Site::get('description');?> ">
    <!--styles-->
    <link href="/assets/css/style.css?v=<?=time();?>" type="text/css" rel="stylesheet">

    <!--cdn-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"  type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    
    <!--javascript-->
    <script src="/assets/js/jquery.js"  type="text/javascript"></script>
    <script src="/assets/js/function.js?v=<?=time();?>"  type="text/javascript"></script>
    <script src="/assets/js/datatable.js"  type="text/javascript"></script>
</head>
<body>