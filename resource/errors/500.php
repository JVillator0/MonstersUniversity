<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/errors.css">
  <title>Error 500</title>
</head>
<body>
  
  <div class="box">
    <div class="box__ghost">
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      
      <div class="box__ghost-container">
        <div class="box__ghost-eyes">
          <div class="box__eye-left"></div>
          <div class="box__eye-right"></div>
        </div>
        <div class="box__ghost-bottom">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div class="box__ghost-shadow"></div>
    </div>
    
    <div class="box__description">
      <div class="box__description-container">
        <div class="box__description-title">Error 500!</div>
        <div class="box__description-text">Ocurrió un error interno del servidor.</div>
      </div>
      <a href="#" onclick="volver();" class="box__button">Volver</a>
    </div>
  </div>

  <script src="../../libs/jquery/jquery.min.js"></script>
  <script src="../js/errors.js"></script>
</body>
</html>