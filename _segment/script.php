<?php
echo
    '<!--jQuery [ REQUIRED ]-->
	<script src="'.getWebDomain().'res/js/jquery-3.5.1.min.js"></script>

	<!--BootstrapJS [ RECOMMENDED ]-->
	<script src="'.getWebDomain().'res/js/bootstrap.min.js"></script>
	
	<!--NiftyJS [ RECOMMENDED ]-->
	<script src="'.getWebDomain().'res/js/nifty.min.js?version='.$fileVersion.'"></script>

	<!--Masked Input [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/plugins/masked-input/jquery.maskedinput.min.js"></script>

	<!--Form validation [ OPTIONAL ]-->
    <script src="'.getWebDomain().'res/plugins/formvalidation/js/FormValidation.min.js"></script>
    <script src="'.getWebDomain().'res/plugins/formvalidation/js/plugins/AutoFocus.min.js"></script>
    <script src="'.getWebDomain().'res/plugins/formvalidation/js/plugins/Bootstrap3.min.js"></script>
    <script src="'.getWebDomain().'res/plugins/formvalidation/js/zxcvbn.js"></script>
    <script src="'.getWebDomain().'res/js/form-validation.js?version='.$fileVersion.'"></script>
    <script src="'.getWebDomain().'res/plugins/formvalidation/js/plugins/Recaptcha.min.js"></script>
    <script src="'.getWebDomain().'res/plugins/formvalidation/js/plugins/Recaptcha3.min.js"></script>
     
	<!--Switchery [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/plugins/switchery/switchery.min.js"></script>
 
	<!--Bootstrap Select [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/plugins/bootstrap-select/bootstrap-select.min.js"></script>
 
	<!--Bootstrap Tags Input [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

    <!--Nestable List [ OPTIONAL ]-->
    <script src="'.getWebDomain().'res/plugins/nestable-list/jquery.nestable.js"></script>
    
	<!--Operador y Controlador AJAX [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/js/operator.js?version='.$fileVersion.'"></script>
	<script src="'.getWebDomain().'res/js/ajaxController.js?version='.$fileVersion.'"></script>

	<!--DataTables [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/plugins/datatables/media/js/jquery.dataTables.js"></script>
	<script src="'.getWebDomain().'res/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
	<script src="'.getWebDomain().'res/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="'.getWebDomain().'res/plugins/datatables/RowGroup-1.1.2/js/dataTables.rowGroup.min.js?version='.$fileVersion.'"></script>
	
	<!--Numeral JS [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/js/numeral.js"></script>

	<!-- MACY MASONRY [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/js/macy.js"></script>
	
	<script src="'.getWebDomain().'res/js/animatescroll.js"></script>
	
	<!-- LIGHT GALLERY [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/js/lightgallery.js"></script>
	<script src="'.getWebDomain().'res/js/transition.js"></script>
	<script src="'.getWebDomain().'res/js/lg-zoom.js"></script>
	<script src="'.getWebDomain().'res/js/lg-share.js"></script>
	<script src="'.getWebDomain().'res/js/lg-thumbnail.js"></script>
	<script src="'.getWebDomain().'res/js/lg-fullscreen.js"></script>
	
	<!-- PERIOD, DATE-TIME PICKER [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/js/jquery.periodpicker.full.min.js"></script>
	<script src="'.getWebDomain().'res/js/jquery.timepicker.min.js"></script>
	<script src="'.getWebDomain().'res/js/jquery.datetimepicker.full.min.js"></script>    
	<script src="'.getWebDomain().'res/plugins/momentjs/moment.min.js"></script>
	
	<!--Select2 [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/plugins/select2/js/select2.min.js"></script>
	
	<!--Match Height [ OPTIONAL ]-->
    <script src="'.getWebDomain().'res/plugins/jquery-match-height/jquery-match-height.min.js"></script>
    
    <!--Sticky elements [ OPTIONAL ]-->
    <script src="'.getWebDomain().'res/js/jquery.sticky.js"></script>
    
     <!--Bootstrap Wizard [ OPTIONAL ]-->
    <script src="'.getWebDomain().'res/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    
    <script type="text/javascript" src="'.getWebDomain().'res/js/daterangepicker.min.js"></script>
    
    <!-- SWEET ALERT [ OPTIONAL ]-->
    <script src="'.getWebDomain().'res/plugins/sweetalert2/sweetalert2.min.js"></script>
     
    <!-- FILE UPLOADER [ OPTIONAL ]-->
	<script src="'.getWebDomain().'res/js/cropper.min.js"></script>
	<script src="'.getWebDomain().'res/js/filepicker.js"></script>
	<script src="'.getWebDomain().'res/js/filepicker-ui.js"></script>
	<script src="'.getWebDomain().'res/js/filepicker-drop.js"></script>
	<script src="'.getWebDomain().'res/js/filepicker-crop.js"></script>
	<script src="'.getWebDomain().'res/js/filepicker-camera.js"></script>';

?>

<script>
	$(document).keypress(
	  function(event){
		if (event.which == '13') {
		  event.preventDefault();
		}
	});
</script>