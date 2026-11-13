<?php
require 'conexion.php';
include 'header.php';
?>

<section class="productos">
  <h2 class="titulo-seccion">Productos destacados</h2>

  <div class="slideshow-container">
    <div class="mySlides fade">
      <div class="numbertext"> 1 / 5 </div>
      <div class="divImagen"><img class="imagenCarrusel" src="img/Remeras Nacionales - Halo Lunar/Almendra - simbolo.WEBP"/></div>
      <div class="text">Remera de Almendra</div>
    </div>
    <div class="mySlides fade">
      <div class="numbertext"> 2 / 5 </div>
      <div class="divImagen"> <img class="imagenCarrusel" src="img/Remeras Nacionales - Halo Lunar/Charly - Modern Clix.WEBP"/></div>
      <div class="text">Remera de Clics Modernos</div>
    </div>
    <div class="mySlides fade">
      <div class="numbertext"> 3 / 5 </div>
      <div class="divImagen"> <img class="imagenCarrusel" src="img/Remeras Nacionales - Halo Lunar/Sumo - After Chabón.WEBP"/></div>
      <div class="text">Remera de After Chabón</div>
    </div>
    <div class="mySlides fade">
      <div class="numbertext"> 4 / 5 </div>
      <div class="divImagen"><img class="imagenCarrusel" src="img/Remeras Nacionales - Halo Lunar/Spinetta - Un mañana.WEBP"/></div>
      <div class="text">Remera de Un Mañana</div>
    </div>
    <div class="mySlides fade">
      <div class="numbertext"> 5 / 5 </div>
      <div class="divImagen"><img class="imagenCarrusel" src="img/Remeras Nacionales - Halo Lunar/Virus - Locura.WEBP"/></div>
      <div class="text">Remera de Virus</div>
    </div>
  </div>

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>

  <br>

  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span class="dot" onclick="currentSlide(4)"></span>
    <span class="dot" onclick="currentSlide(5)"></span>
  </div>
</section>

<div style="text-align: center; margin-top: 30px;">
    <h2>Indumentaria Musiquera</h2>
    <p>Mostrale tus gustos al mundo</p>
</div>

<script src="js/app.js"></script>

<?php include 'footer.php'; ?>
