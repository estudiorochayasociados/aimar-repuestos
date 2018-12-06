<aside class="widget widget_categories group  ">
  <h3 class="widget-title"><?php echo $nav["certificados"][$lenguaje] ?></h3>
  <div class="certificadosImagen">
    <?php Traer_Contenidos("CERTIFICADOS SIDEBAR") ?>
  </div>
</aside> 
<aside class="widget widget_text group">
  <h3 class="widget-title"><?php echo $danos_me_gusta[$lenguaje] ?></h3>
  <div class="fb-page" data-href="https://www.facebook.com/SabemosDeFrenos/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/SabemosDeFrenos/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/SabemosDeFrenos/">Aimar Frenos</a></blockquote></div>
</aside> 
<aside class="widget widget_ci_social_widget ci-socials group">
  <h3 class="widget-title"><?php echo $nav["comunidad"][$lenguaje] ?></h3>  
  <a href="#" class="social-icon" title="Like us on Facebook.">
    <i class="fab fa-facebook-f"></i>
  </a> 
  <a href="#" class="social-icon" title="See our Dribbble shots.">
    <i class="fab fa-instagram"></i>
  </a> 
</aside>
<aside class="widget widget_ci_social_widget ci-socials group">
  <h3 class="widget-title">  <?php echo $contacto["datos"][$lenguaje]; ?></h3>  
  <?php Traer_Contenidos("contacto") ?>

</aside>