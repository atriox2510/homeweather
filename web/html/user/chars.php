<?php
session_start();

if (isset($_SESSION['loggedin'])) {
  $now = time();
  if ($now > $_SESSION['expire']) {
    session_destroy();
    exit;
    header('Location:../index.html');
  } else {
    if ($_SESSION['status'] == "Activo") {
      $nombre = $_SESSION['nombre'];
      if ($_SESSION['rol'] == 1) { //User
        //aqui estamos
      } elseif ($_SESSION['rol'] == 2) { //Admin
        header('Location:../admin/index.php');
      }
    } elseif ($_SESSION['status'] == "No Activo") {
      session_destroy();
      header('Location:../index.html');
    } elseif ($_SESSION['status'] == "En espera") {
      session_destroy();
      header('Location:../index.html');
    }
  }
} else {
  session_destroy();
  header('Location:../index.html');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>HomeWeather</title>
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/css/style-2.css">
  <link rel="shortcut icon" href="../assets/images/favicon-1.png" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script>

  </script>
</head>

<body>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img src="../assets/images/logo-panel-user.png" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../assets/images/logo-panel-mini.png" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="../assets/images/avatar.png" alt="image">
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo $nombre ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
              <div class="p-3 text-center bg-primary">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="../assets/images/avatar.png" alt="">
              </div>
              <div class="p-2">
                <h5 class="dropdown-header text-uppercase pl-2 text-dark">Opciones de Usuario</h5>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="perfil.php">
                  <span>Editar perfil</span>
                  <i class="mdi mdi-account"></i>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="clave.php">
                  <span>Cambiar contraseña</span>
                  <i class="mdi mdi-key"></i>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="configuracion.php">
                  <span>Configuraciones</span>
                  <i class="mdi mdi-settings"></i>
                </a>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="../login/logout.php">
                  <span>Cerrar Sesi&oacute;n</span>
                  <i class="mdi mdi-logout ml-1"></i>
                </a>
              </div>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="api.php">
              <span class="icon-bg"><i class="mdi mdi-web menu-icon"></i></span>
              <span class="menu-title">API</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chars.php">
              <span class="icon-bg"><i class="mdi mdi-chart-bar menu-icon"></i></span>
              <span class="menu-title">Gr&aacute;ficas</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="main-panel">
        <div class="content-wrapper">
          <!--AQUI VA EL CONTENIDO-->
          <canvas id="sensor1_myChart" style="position: relative; height: 40vh; width: 80vw;"></canvas><br><br>
          <canvas id="sensor2_myChart" style="position: relative; height: 40vh; width: 80vw;"></canvas><br><br>
          <canvas id="sensor3_myChart" style="position: relative; height: 40vh; width: 80vw;"></canvas><br><br>
          <canvas id="sensor4_myChart" style="position: relative; height: 40vh; width: 80vw;"></canvas><br><br>
          <canvas id="sensor5_myChart" style="position: relative; height: 40vh; width: 80vw;"></canvas>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <script>
            //SENSOR 1
            var sensor1_ctx = document.getElementById('sensor1_myChart')
            var sensor1_myChart = new Chart(sensor1_ctx, {
              type: 'line',
              data: {
                datasets: [{
                  label: 'SENSOR 1',
                  backgroundColor: ['#6bf1ab', '#63d69f', '#438c6c', '#509c7f', '#1f794e', '#34444c', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#0D47A1'],
                  borderColor: ['black'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            })

            let sensor1_url = 'http://localhost/api/sensor1.php?api_token=' + '<?php echo $_SESSION['api_token'] ?>';
            fetch(sensor1_url)
              .then(sensor1_response => sensor1_response.json())
              .then(sensor1_datos => sensor1_mostrar(sensor1_datos))
              .catch(sensor1_error => console.log(sensor1_error))


            const sensor1_mostrar = (sensor1_api) => {
              sensor1_api.forEach(element => {
                sensor1_myChart.data['labels'].push(element.fecha_hora)
                sensor1_myChart.data['datasets'][0].data.push(element.sensor1)
                sensor1_myChart.update()
              });
            }
          </script>
          <script>
            //SENSOR 2
            var sensor2_ctx = document.getElementById('sensor2_myChart')
            var sensor2_myChart = new Chart(sensor2_ctx, {
              type: 'line',
              data: {
                datasets: [{
                  label: 'SENSOR 2',
                  backgroundColor: ['#6bf1ab', '#63d69f', '#438c6c', '#509c7f', '#1f794e', '#34444c', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#0D47A1'],
                  borderColor: ['black'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            })

            let sensor2_url = 'http://localhost/api/sensor2.php?api_token=' + '<?php echo $_SESSION['api_token'] ?>';
            fetch(sensor2_url)
              .then(sensor2_response => sensor2_response.json())
              .then(sensor2_datos => sensor2_mostrar(sensor2_datos))
              .catch(sensor2_error => console.log(sensor2_error))


            const sensor2_mostrar = (sensor2_api) => {
              sensor2_api.forEach(element => {
                sensor2_myChart.data['labels'].push(element.fecha_hora)
                sensor2_myChart.data['datasets'][0].data.push(element.sensor2)
                sensor2_myChart.update()
              });
            }
          </script>
          <script>
            //SENSOR 3
            var sensor3_ctx = document.getElementById('sensor3_myChart')
            var sensor3_myChart = new Chart(sensor3_ctx, {
              type: 'line',
              data: {
                datasets: [{
                  label: 'SENSOR 3',
                  backgroundColor: ['#6bf1ab', '#63d69f', '#438c6c', '#509c7f', '#1f794e', '#34444c', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#0D47A1'],
                  borderColor: ['black'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            })

            let sensor3_url = 'http://localhost/api/sensor3.php?api_token=' + '<?php echo $_SESSION['api_token'] ?>';
            fetch(sensor3_url)
              .then(sensor3_response => sensor3_response.json())
              .then(sensor3_datos => sensor3_mostrar(sensor3_datos))
              .catch(sensor3_error => console.log(sensor3_error))


            const sensor3_mostrar = (sensor3_api) => {
              sensor3_api.forEach(element => {
                sensor3_myChart.data['labels'].push(element.fecha_hora)
                sensor3_myChart.data['datasets'][0].data.push(element.sensor3)
                sensor3_myChart.update()
              });
            }
          </script>
          <script>
            //SENSOR 4
            var sensor4_ctx = document.getElementById('sensor4_myChart')
            var sensor4_myChart = new Chart(sensor4_ctx, {
              type: 'line',
              data: {
                datasets: [{
                  label: 'SENSOR 4',
                  backgroundColor: ['#6bf1ab', '#63d69f', '#438c6c', '#509c7f', '#1f794e', '#34444c', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#0D47A1'],
                  borderColor: ['black'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            })

            let sensor4_url = 'http://localhost/api/sensor4.php?api_token=' + '<?php echo $_SESSION['api_token'] ?>';
            fetch(sensor4_url)
              .then(sensor4_response => sensor4_response.json())
              .then(sensor4_datos => sensor4_mostrar(sensor4_datos))
              .catch(sensor4_error => console.log(sensor4_error))


            const sensor4_mostrar = (sensor4_api) => {
              sensor4_api.forEach(element => {
                sensor4_myChart.data['labels'].push(element.fecha_hora)
                sensor4_myChart.data['datasets'][0].data.push(element.sensor4)
                sensor4_myChart.update()
              });
            }
          </script>
          <script>
            //SENSOR 5
            var sensor5_ctx = document.getElementById('sensor5_myChart')
            var sensor5_myChart = new Chart(sensor5_ctx, {
              type: 'line',
              data: {
                datasets: [{
                  label: 'SENSOR 5',
                  backgroundColor: ['#6bf1ab', '#63d69f', '#438c6c', '#509c7f', '#1f794e', '#34444c', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#0D47A1'],
                  borderColor: ['black'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            })

            let sensor5_url = 'http://localhost/api/sensor5.php?api_token=' + '<?php echo $_SESSION['api_token'] ?>';
            fetch(sensor5_url)
              .then(sensor5_response => sensor5_response.json())
              .then(sensor5_datos => sensor5_mostrar(sensor5_datos))
              .catch(sensor5_error => console.log(sensor5_error))


            const sensor5_mostrar = (sensor5_api) => {
              sensor5_api.forEach(element => {
                sensor5_myChart.data['labels'].push(element.fecha_hora)
                sensor5_myChart.data['datasets'][0].data.push(element.sensor5)
                sensor5_myChart.update()
              });
            }
          </script>
          <!--AQUI VA EL CONTENIDO-->
        </div>
      </div>
    </div>
  </div>

  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/misc.js"></script>
  <script src="../assets/js/jquery-3.1.1.js"></script>
</body>

</html>
