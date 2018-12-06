<div class="pre-head hidden-lg hidden-md hidden-sm">
  <div class="container">
    <div class="row">
      <div class="col-sm-7 col-xs-5"> 
        <ul class="social-icons" style="text-align: left !important">
          <li>
            <a href="https://www.facebook.com/FrenosAimar/" target="_blank" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
          </li> 
          <li>
            <a href="https://www.instagram.com/aimar_repuestos/" target="_blank" class="social-icon">
              <i class="fab fa-instagram"></i>
            </a>
          </li>     
          <li>
            <a href="https://wa.me/543564586460" target="_blank" class="social-icon">
              <i class="fab fa-whatsapp"></i>
            </a>
          </li>  
          <li class="hidden-lg hidden-md hidden-sm">
            <a href="tel:3564437442" class="social-icon">
              <i class="fa fa-phone"></i>
            </a>
          </li>      
        </ul>
      </div>
      <div class="col-sm-5 col-xs-7 text-right ingresoS">
        <?php if(isset($_SESSION["user"]["id"])) { ?> 
          <a href="<?php echo BASE_URL ?>/usuarios" >
            <b><i class="fa fa-user"></i> <?= $_SESSION["user"]["nombre"] ?></b>
          </a><br><br>
        <?php } else { ?>
          <a href="<?php echo BASE_URL ?>/usuarios" >
            <b><i class="fa fa-user"></i>  INGRESAR COMO USUARIO</b>
          </a>
        <?php } ?>

        <?php if(isset($_SESSION["carrito"][0])) { ?> 
          <a href="<?php echo BASE_URL ?>/carrito" >
            <b><i class="fa fa-shopping-cart"></i> VER CARRITO</b>
          </a>
        <?php } ?>

      </div>
    </div>
  </div>
</div>
<div class="pre-head hidden-xs">
  <div class="container">
    <div class="row">
      <div class="col-sm-7 col-xs-12"> 
        <ul class="social-icons" style="text-align: left !important">
          <li>
            <a href="https://www.facebook.com/FrenosAimar/" target="_blank" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
          </li> 
          <li>
            <a href="https://www.instagram.com/aimar_repuestos/" target="_blank" class="social-icon">
              <i class="fab fa-instagram"></i>
            </a>
          </li>     
          <li>
            <a href="https://wa.me/543564586460" target="_blank" class="social-icon">
              <i class="fab fa-whatsapp"></i>
            </a>
          </li>    
          <li style="padding-left: 10px">Castelli 2260, San Francisco, Córdoba</li>       
        </ul>
      </div>
      <div class="col-sm-5 col-xs-12 text-right ingresoS">
        <?php if(isset($_SESSION["user"]["id"])) { ?> 
          <a href="<?php echo BASE_URL ?>/usuarios" >
            <b><i class="fa fa-user"></i> <?= $_SESSION["user"]["nombre"] ?></b>
          </a>
        <?php } else { ?>
          <a href="<?php echo BASE_URL ?>/usuarios" >
            <b><i class="fa fa-user"></i>  INGRESAR COMO USUARIO</b>
          </a>
        <?php } ?>

        <?php if(isset($_SESSION["carrito"][0])) { ?> 
          <a href="<?php echo BASE_URL ?>/carrito" >
            <b><i class="fa fa-shopping-cart"></i> VER CARRITO</b>
          </a>
        <?php } ?>

      </div>
    </div>
  </div>
</div>
<div class="mast-head">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="mast-head-wrap">
          <div class="mast-head-left">
            <h1 class="site-logo">
              <a href="<?php echo BASE_URL ?>/index.php">
                <img src="<?php echo BASE_URL ?>/images/logo.png" width="200" />
              </a>
            </h1>                 
          </div>
          <div class="mast-head-right">
            <nav class="nav">
              <ul class="navigation">
                <li>
                  <a class="<?php if(strpos(CANONICAL,"index")) { echo "actived"; } ?>" href="<?php echo BASE_URL ?>/index">home</a>
                </li>
                <li>
                  <a class="<?php if(strpos(CANONICAL,"empresa")) { echo "actived"; } ?>" href="<?php echo BASE_URL ?>/c/empresa">empresa</a>
                </li>
                <li>
                  <a class="<?php if(strpos(CANONICAL,"productos")) { echo "actived"; } ?>" href="<?php echo BASE_URL ?>/productos">productos</a>
                </li>                
                <li>
                  <a class="<?php if(strpos(CANONICAL,"redes")) { echo "actived"; } ?>" href="<?php echo BASE_URL ?>/redes">comunidad</a>
                </li>                
                <li>
                  <a class="<?php if(strpos(CANONICAL,"contacto")) { echo "actived"; } ?>" href="<?php echo BASE_URL ?>/contacto">contacto</a>
                </li>
                <li class="hidden-md hidden-lg">
                  <a class="<?php if(strpos(CANONICAL,"usuarios")) { echo "actived"; } ?>" href="<?php echo BASE_URL ?>/usuarios"><b>ingreso de usuarios</b></a>
                </li> 
              </ul>
              <!-- #navigation -->
            </nav>
            <!-- #nav -->
            <div id="mobilemenu">
            </div> 
            <a href="#mobilemenu" title="Open Mobile Menu" class="mobile-menu-trigger">
              <i class="fa fa-navicon"></i>
            </a> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>