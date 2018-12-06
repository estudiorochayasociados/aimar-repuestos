<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<?php 
	include("inc/header.inc.php");
	?>
	<title>Comunidad Digital - Aimar Repuestos</title>
</head>
<body>
	<div id="page">
		<header class="header">
			<?php include("inc/nav.inc.php"); ?>
		</header>
		<div class="page-hero">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h1 class="page-title text-uppercase">
							comunidad
						</h1>
					</div>
				</div>
			</div>
		</div>
		<main class="main">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-xs-12">
						<article class="entry">
							<style>
							.powered-by {
								display: none !important;
								opacity: 0 !important;
							}
						</style>
						<!-- Place <div> tag where you want the feed to appear -->
							<div id="curator-feed"><a href="https://curator.io" target="_blank" class="crt-logo crt-tag">Powered by Curator.io</a></div>
							<!-- The Javascript can be moved to the end of the html page before the </body> tag -->
							<script type="text/javascript">
								/* curator-feed */
								(function(){
									var i, e, d = document, s = "script";i = d.createElement("script");i.async = 1;
									i.src = "https://cdn.curator.io/published/e35a0040-f3b6-4478-ba3d-1352ec86d5cc.js";
									e = d.getElementsByTagName(s)[0];e.parentNode.insertBefore(i, e);
								})();
							</script>
							<style>
							#curator-feed .crt-logo{
								position: absolute;
								right: 900000px;
							}
						</style>
					</article>
				</div> 
			</div>
		</div>
	</main>
	<?php include("inc/footer.inc.php"); ?>
</body>
</html>