<?php

require "cfig.php";

?>

<!DOCTYPE html>

<html lang="en">
<head>
  <base href="./">
  <title>DnsDev - Gestor Integral</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="DNS-Adm">
  <meta name="author" content="Dennys Mejia">
  <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
  <title>Comsitec</title>
  <link rel="shortcut icon" href="csteclgo-64.png">
  <link href='assets/css/2.1.4_boxicons.min.css' rel='stylesheet'>
  <link href='assets/css/bootstrap.min.css' rel='stylesheet'>

  <script src="assets/js/jquery-3.6.4.min.js"></script>  



  <meta name="robots" content="noindex">
</head>
<body class="bdystle" style="overflow: hidden;">
<!-- <body class="c-app c-dark-theme flex-row align-items-center"> -->
<?php include "css_lgin.php"; ?>

<div class="container-fluid ">
  <div class="row">
    <div class="col-md-6 dns_ctinerlgo">
      <div class="dns_lgo">
        <img class="img-fluid" style="width:400px;" src="imges/lgos/bgcomswhite.png">
      </div>
    </div>
    <div class="col-md-6 dns_ctinerlgin">
      <div id="sq">
        <div class="circ1"></div>
        <div class="circ2"></div>
        <div class="circ3"></div>
      </div>

        <div class="dns_ttlelogin">
          Gestor Integral
        </div>
        <div class="col-8 col-md-10 col-lg-8 dns_cardlgin  ">
            <div class="dns_iputbox ">
              <i class='bx bxs-user-rectangle'></i>
              <input type="text" id="coduser" name="coduser"  placeholder="Usuario" required>
            </div>
            <div class="dns_iputbox">
              <i class='bx bxs-lock-alt' ></i>
              <input type="password" id="pword" name="pword"  placeholder="Contraseña" required>
            </div>
            <div id="box_btnlgin" class="dns_btnlginbox">
              <button type="submit" id="btnlgin">Iniciar&nbsp;Sesión</button>
            </div>
        </div>

      <div class="wave" >
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;" class="wave a" >
          <path d="M0.00,49.98 C172.40,174.19 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: rgba(11, 42, 143, 0.9);"></path>
        </svg>
      </div>
      <div class="wave" >
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;" class="wave b" >
          <path d="M503.67,94.25 C133.46,163.33 163.37,-74.48 -1.41,49.84 L-4.22,154.45 L502.54,155.44 Z" style="stroke: none; fill: rgba(0, 68, 255, 0.62);"></path>
        </svg>
      </div>
      <div class="wave" >
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;" class="wave c" >
          <path d="M-9.31,85.38 C101.30,175.17 123.30,-29.09 322.51,49.84 L669.01,170.23 L0.00,150.00 Z" style="stroke: none; fill: rgba(11, 42, 143, 0.5);"></path>
        </svg>
      </div>

    </div>
  </div>
</div>
<script type="text/javascript" src="assets/js/dnsv2.js"></script>

</body>
</html>