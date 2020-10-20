<?php
	require("conexion_inicio.inc");
	$sql=" select  nombres_usuario, ap_paterno_usuario, ap_materno_usuario,cod_perfil  from usuarios ";
	$sql.=" where cod_usuario='".$_COOKIE['usuario_global']."'";
	$resp=mysql_query($sql);
	while($dat=mysql_fetch_array($resp)){
	
		$nombres_usuario=$dat[0]; 
		$ap_paterno_usuario=$dat[1];
		$ap_materno_usuario=$dat[2];
		$cod_perfil=$dat[3];

		
	}
		
	$sql=" select  nombre_modulo, ubicacion_fisica  from modulos ";
			$sql.=" where cod_modulo=".$_GET['cod_modulo']."";
			$resp = mysql_query($sql);

			while($dat=mysql_fetch_array($resp)){																 		
				$nombre_modulo=$dat['nombre_modulo'];
	
			}
		
	$cod_modulo=$_GET['cod_modulo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta content="text/html; charset=ISO-8859-1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/icono_2.jpg"> 
  <title>Imprenta</title>

  <!-- Custom fonts for this template-->
  <link href="modulos/assets/vendor/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="modulos/assets/vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="modules.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-print"></i>
        </div>
        <div class="sidebar-brand-text mx-3">IMPRENTA <sup>2</sup></div>
      </a>

      <!-- Heading -->
      <div class="sidebar-heading">
        SELECCIONE UN ALMACEN
      </div>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
         <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?="".$nombres_usuario." ".$ap_paterno_usuario?></span>
                <img class="img-profile rounded-circle" src="images/perfil.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="salirSistema.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar Sesión
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Almacenes</h1>
          </div>

          <div class="row">
            <?php
      
      $sql=" select cod_sucursal, nombre_sucursal";
      $sql.=" from sucursales ";
      $sql.=" where cod_estado_registro=1 ";
      $sql.=" order by  cod_sucursal asc";
      $resp = mysql_query($sql);

      while($dat=mysql_fetch_array($resp)){ 
                                  
        $cod_sucursal=$dat['cod_sucursal']; 
        $nombre_sucursal=$dat['nombre_sucursal'];
      ?>
      <?php
        $sql2=" select cod_almacen, nombre_almacen ";
          $sql2.=" from almacenes";
          $sql2.=" where cod_sucursal=".$cod_sucursal;
          $resp2 = mysql_query($sql2);
          while($dat2=mysql_fetch_array($resp2)){ 
            
            $cod_almacen=$dat2['cod_almacen'];
            $nombre_almacen=$dat2['nombre_almacen']; 

            $url_mod="modulos/index.php?cod_modulo=$cod_modulo&cod_almacen_global=$cod_almacen";

      ?>
           <div class="col-xl-3 col-md-6 mb-4">
             <a href="<?=$url_mod?>" class="nav-link">  
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo $nombre_almacen;?></div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800 small">Sucursal <?=$nombre_sucursal?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
            <?php       
          }

      }
    
    ?>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Imprenta 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="modulos/assets/vendor/vendor/jquery/jquery.min.js"></script>
  <script src="modulos/assets/vendor/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="modulos/assets/vendor/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="modulos/assets/vendor/js/sb-admin-2.min.js"></script>

</body>

</html>