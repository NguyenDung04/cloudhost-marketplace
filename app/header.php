<?php require $_SERVER['DOCUMENT_ROOT'].'/core/db.php';?>
<meta charset=UTF-8>
<meta name=viewport content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv=X-UA-Compatible content="ie=edge">
<meta name=title content="<?=$ketnoi->site('title');?>">
<meta name=description content="<?=$ketnoi->site('description');?> ">
<meta name=keywords content="<?=$ketnoi->site('keywords');?>">
<meta name=robots content="index, follow">
<link href=<?=$ketnoi->site('favicon');?> rel="shortcut icon" type=image/x-icon>
<meta name=googlebot content="index, follow">
<meta name=google content=notranslate>
<meta name=generator content="<?=$ketnoi->site('title');?>">
<meta name=application-name content="<?=$ketnoi->site('title');?>">
<meta property=og:image content=<?=$ketnoi->site('banner');?>>
<meta property=og:image:secure_url content=<?=$ketnoi->site('banner');?>>
<meta property=og:image:type content=image/png>
<meta property=og:image:alt content="<?=$ketnoi->site('title');?>">
<meta property=og:site_name content="<?=$ketnoi->site('title');?>">
<meta property=og:description content="<?=$ketnoi->site('title');?>">
<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="/assets/libs/sweetalert2/sweetalert2.min.css" />
<style>
	.nav-link::after {
	display: none !important;
	content: none !important;
	}
	.breadcrumb-item+.breadcrumb-item::before {
	content: none !important;
	}
	.img-bg {
	background-image: url(https://mannatthemes.com/dastone-bs5/default/assets/images/extra/card/owl.jpg);
	background-position: 0 20%;
	background-repeat: no-repeat;
	background-size: cover;
	height: 180px
	}
	.pricing-content li::before {
	content: none !important;
	}
	.btn-check:checked+.option-card {
	border: 2px solid #0d6efd;
	box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
	}
	.circle-value {
	width: 40px;
	height: 40px;
	line-height: 40px;
	border-radius: 50%;
	background: #fff;
	box-shadow: 0 0 10px rgba(13, 110, 253, .2);
	text-align: center;
	font-weight: bold;
	}
	.os-card {
	cursor: pointer;
	transition: all 0.2s ease-in-out;
	}
	.btn-check:checked+.os-card {
	border: 2px solid #0d6efd;
	box-shadow: 0 0 8px rgba(13, 110, 253, .3);
	}
	.os-card:hover {
	border-color: #0d6efd;
	}
	.page-item.disabled .page-link {
	pointer-events: none !important;
	/* chặn mọi click */
	cursor: not-allowed;
	/* con trỏ thành dấu cấm */
	opacity: 0.6;
	/* làm mờ nhẹ */
	user-select: none;
	/* không chọn được text */
	box-shadow: none !important;
	/* bỏ hiệu ứng shadow */
	}
</style>
<!-- CropperJS CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<!-- CropperJS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<style>
	.nav-link::after {
	display: none !important;
	content: none !important;
	}
	.breadcrumb-item + .breadcrumb-item::before {
	content: none !important;
	}
	.img-bg {
	background-image: url(/core/upload/images/bgr.jpg);
	background-position: 0 20%;
	background-repeat: no-repeat;
	background-size: cover;
	height: 180px
	}
	.pricing-content li::before {
	content: none !important;
	}
	.btn-check:checked + .option-card {
	border: 2px solid #0d6efd;  
	box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
	}
	.circle-value {
	width: 40px;
	height: 40px;
	line-height: 40px;
	border-radius: 50%;
	background: #fff;
	box-shadow: 0 0 10px rgba(13,110,253,.2);
	text-align: center;
	font-weight: bold;
	}
	.os-card {
	cursor: pointer;
	transition: all 0.2s ease-in-out;
	}
	.btn-check:checked + .os-card {
	border: 2px solid #0d6efd;
	box-shadow: 0 0 8px rgba(13,110,253,.3);
	}
	.os-card:hover {
	border-color: #0d6efd;
	}
</style>