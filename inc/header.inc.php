        <?php 
        include("PHPMailer/class.phpmailer.php");
        include("admin/dal/data.php"); 
        $_SESSION["carrito"] = isset($_SESSION["carrito"]) ? $_SESSION["carrito"] : array();
        
        $canonical = CANONICAL;
        $autor = TITULO;
        $made = EMAIL;
        $pais = META_PAIS;
        $place = META_PLACE;
        $position = META_POSITION;
        $copy = META_COPY;
        ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127300251-4"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-127300251-4');
      </script>

      
      <meta charset="utf-8"/>
      <meta name="author" lang="es" content="<?php echo $autor; ?>" />
      <link rel="author" href="<?php echo $made; ?>" rel="nofollow" />
      <meta name="copyright" content="<?php echo $copy; ?>" />
      <link rel="canonical" href="<?php echo $canonical; ?>" />
      <meta name="distribution" content="global" />
      <meta name="robots" content="all" />
      <meta name="rating" content="general" />
      <meta name="content-language" content="es-ar" />
      <meta name="DC.identifier" content="<?php echo $canonical; ?>" />
      <meta name="DC.format" content="text/html" />
      <meta name="DC.coverage" content="<?php echo $pais; ?>" />
      <meta name="DC.language" content="es-ar" />
      <meta http-equiv="window-target" content="_top" />
      <meta name="robots" content="all" />
      <meta http-equiv="content-language" content="es-ES" />
      <meta name="google" content="notranslate" />
      <meta name="geo.region" content="AR-X" />
      <meta name="geo.placename" content="<?php echo $place; ?>" />
      <meta name="geo.position" content="<?php echo $position; ?>" />
      <meta name="ICBM" content="<?php echo $position; ?>" />
      <meta content="public" name="Pragma" />
      <meta http-equiv="pragma" content="public" />
      <meta http-equiv="cache-control" content="public" />
      <meta property="og:url" content="<?php echo $canonical; ?>" />
      <meta charset="utf-8">
      <meta content="IE=edge" http-equiv="X-UA-Compatible">
      <meta content="width=device-width, initial-scale=1" name="viewport">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      
      
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      
      
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700%7CMontserrat:700&subset=latin,greek' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/css/base.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/css/flexslider.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/css/mmenu.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/css/magnific.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/lightbox/lightbox.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/style.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="shortcut icon" href="#">
      <link rel="apple-touch-icon" href="#">
      <link rel="apple-touch-icon" sizes="72x72" href="#">
      <link rel="apple-touch-icon" sizes="114x114" href="#">

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/4788560.js"></script>
<!-- End of HubSpot Embed Code -->

      <!-- Facebook Pixel Code -->
      <!-- Facebook Pixel Code -->
      <!-- Facebook Pixel Code -->
      <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
              n.callMethod.apply(n,arguments):n.queue.push(arguments)};
              if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
              n.queue=[];t=b.createElement(e);t.async=!0;
              t.src=v;s=b.getElementsByTagName(e)[0];
              s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '2156147308039897');
              fbq('track', 'PageView');
          </script>
          <noscript><img height="1" width="1" style="display:none"
              src="https://www.facebook.com/tr?id=2156147308039897&ev=PageView&noscript=1"
              /></noscript>
              <!-- End Facebook Pixel Code -->
              <!-- Begin Inspectlet Asynchronous Code -->
<script type="text/javascript">
(function() {
window.__insp = window.__insp || [];
__insp.push(['wid', 512850986]);
var ldinsp = function(){
if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js?wid=512850986&r=' + Math.floor(new Date().getTime()/3600000); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
setTimeout(ldinsp, 0);
})();
</script>
<!-- End Inspectlet Asynchronous Code -->
