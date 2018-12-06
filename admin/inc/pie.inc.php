<!-- Core Scripts - Include with every page -->
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<!-- Page-Level Plugin Scripts - Dashboard -->
<script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="js/plugins/morris/morris.js"></script>
<!-- SB Admin Scripts - Include with every page -->
<script src="js/sb-admin.js"></script>
<!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
<script src="js/demo/dashboard-demo.js"></script>
<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>

<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/lang/es.js"></script>

<script language="javascript">
	$(document).ready(function() {
		$("#provincia").change(function() {
			$("#provincia option:selected").each(function() {
				elegido = $(this).val();
				$.post("../source.php", {
					elegido : elegido
				}, function(data) {
					$("#localidades").html(data);
				});
			});
		})				
	}); 


	$("textarea").each(function(){
		CKEDITOR.replace(this, {			
			customConfig: 'config.js'
		} );
	});


</script> 

</body>

</html>

