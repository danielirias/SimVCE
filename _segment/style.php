<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

<?php
$fileVersion = date("Y").date("m").date("d").'-'.date("H").date("i").date("s");

echo
    '<!--STYLESHEET-->
    <!--=================================================-->

    <!--Open Sans Font [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" />

    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/bootstrap.min.css"/>

    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/style.css?v='.$fileVersion.'"/>
 
    <!--Nifty Premium Icon [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/css-loaders.css"/>

    <!--Font Awesome [ OPTIONAL ]-->
	<link rel="stylesheet" href="'.getWebDomain().'res/css/font-awesome.min.css"/>

    <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/plugins/pace/pace.min.css"/>
    
    <!--Nestable List [ OPTIONAL ]-->
    <link href="'.getWebDomain().'res/plugins/nestable-list/nestable-list.min.css" rel="stylesheet">
    
	 <!--DataTables [ OPTIONAL ]-->
    <link rel="stylesheet" href="'.getWebDomain().'res/plugins/datatables/media/css/dataTables.bootstrap.css"/>
	<link rel="stylesheet" href="'.getWebDomain().'res/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css"/>
	
    <!--Switchery [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/plugins/switchery/switchery.min.css"/>

    <!--Bootstrap Select [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/plugins/bootstrap-select/bootstrap-select.min.css"/>

    <!--Select2 [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/plugins/select2/css/select2.min.css"/>
	
	<!--Summernote [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/plugins/summernote/summernote.min.css"/>
	
	<!--MACY MASONRY [ OPTIONAL ]-->
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/macy.css"/>
	
	<!--LightGallery [ OPTIONAL ]-->
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/lightgallery.css"/>
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/lg-transitions.css"/>
	
	<!-- PERIOD, DATE-TIME PICKER [ OPTIONAL ]-->
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/jquery.periodpicker.css"/>
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/jquery.datetimepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/jquery.timepicker.css"/>
	
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/daterangepicker.css"/>
		
	<!-- FORM VALIDATION [ OPTIONAL ] -->
	<link rel="stylesheet" href="'.getWebDomain().'res/plugins/formvalidation/css/formValidation.min.css"/>
	
	<!-- SWEET ALERT [ OPTIONAL ]-->
    <link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/plugins/sweetalert2/sweetalert2.min.css"/>
	
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/cropper.min.css"/>
	<link rel="stylesheet" type="text/css" href="'.getWebDomain().'res/css/filepicker.css"/>';
?>


<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>

<!--Font Awesome [ OPTIONAL ]-->
<script src="https://kit.fontawesome.com/b1e57d18ca.js" crossorigin="SameSite"></script>

<link rel="icon" href="<?php echo getWebDomain(); ?>res/img/favicon.ico">