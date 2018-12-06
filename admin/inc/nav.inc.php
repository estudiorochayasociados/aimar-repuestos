<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php"><?php echo TITULO ?></a>	
	</div>
	<ul class="pull-right" style="margin:10px">			
		<a class="btn btn-default" href="index.php"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
		<a class="btn btn-default" href="index.php?op=salir"><i class="fa fa-sign-out fa-fw"></i> Salir</a>			
	</ul>
	<div class="clearfix"></div>	
	<ul class="nav navbar-top-links" style="border-top:1px solid #e1e1e1 ">		
		
		<li class="dropdown">
			<a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o fa-fw"></i> Novedades<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a href="index.php?op=verNotas"> Ver Novedades</a>
				</li>
				<li>
					<a href="index.php?op=agregarNotas"> Agregar Novedades</a>
				</li>
			</ul>
		</li> 
		<li class="dropdown">
			<a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o fa-fw"></i> Categorías<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a href="index.php?op=verCategoria"> Ver Categorías</a>
				</li>
				<li>
					<a href="index.php?op=agregarCategoria"> Agregar Categorías</a>
				</li>
			</ul>
		</li> 
		<li class="dropdown">
			<a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-newspaper-o fa-fw"></i> Rubros<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a href="index.php?op=verRubro"> Ver Rubros</a>
				</li>
				<li>
					<a href="index.php?op=agregarRubro"> Agregar Rubros</a>
				</li>
			</ul>
		</li> 
		<li class="dropdown">
			<a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-car fa-fw"></i> Marcas<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a href="index.php?op=verMarcas"> Ver Marcas</a>
				</li>
				<li>
					<a href="index.php?op=agregarMarcas"> Agregar Marcas</a>
				</li>
			</ul>
		</li>
		<li>
			<a  href="index.php?op=verContenidos"><i class="fa fa-edit fa-fw"></i> Contenidos</a>			 
		</li> 
		<li>
			<a  href="index.php?op=verPedidos"><i class="fa fa-edit fa-fw"></i> Pedidos</a>			 
		</li>
		<li>
			<a  href="index.php?op=verEnvios"><i class="fa fa-truck"></i> Envios</a>			 
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bullhorn  fa-fw"></i> Slider<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a href="index.php?op=verSlider"> Ver Sliders</a>
				</li>
				<li>
					<a href="index.php?op=agregarSlider"> Agregar Sliders</a>
				</li>
			</ul>
		</li> 
		<li >
			<a href="index.php?op=verUsuarios"><i class="fa  fa-users fa-fw"></i> Usuarios</span></a>
		</li> 
		<li class="dropdown">
			<a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-excel-o fa-fw"></i> Productos<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li>
					<a href="index.php?op=importarProductos"> Importar Productos</a>
				</li>
				<li>
					<a href="index.php?op=verificarImagenes"> Verificar imagenes</a>
				</li>
			</ul>
		</li> 
		
	</ul>
	<!-- /.navbar-top-links -->	

</nav>
