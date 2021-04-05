<?php

  $estado_inicio_sesion = 'Iniciar Sesion';
  $link_inicio_sesion = 'login';

  if(isset($_COOKIE['id_sesion']))
  {
    $estado_inicio_sesion = 'Tu horario';
    $link_inicio_sesion = 'horario';
  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->
  <meta name="description" content="Organiza tu tiempo, mejora tus horarios, crea y explora con Viscam">
  <link rel="icon" type="image/png" sizes="32x32" href="./images/reloj.jpg">
  <title>Visual CMJ | Organiza tus tiempos y administralos.</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./estilo_index.css">
  <link rel="stylesheet" href="./css/desktop.css" media="(min-width: 768px)">
</head>

<body>
  <header>
    <div class="header-logo--container">
      <table>
        <tr>
          <td>
          <img src="./images/logo_vcmj.png" alt="Visual CMJ, Logo" width="125px" height="30px">
          </td>
          <td align="right">
            <a href="<?= $link_inicio_sesion ?>"><?= $estado_inicio_sesion ?></a>
          </td>
        </tr>
      </table>
    </div>

    <div class="header-main--container animate__animated animate__fadeInDown">
      <h1 class="header-title">Visual CMJ, tu complemento perfecto para el 'Zoomestre'</h1>
      <p class="header-content--description">Con Visual CMJ podras guardar links para tus clases en linea, mejorar tus tiempos y aprovecharlos al maximo</p>
      <button class="button--start"><a href="./signup">Inscribete gratis</a></button>
    </div>
  </header>
  <main>
    <section class="first-main--section animate__animated animate__fadeInLeft">
      <div class="main-image--container">
        <figure class="image-container">
          <img src="./images/schedule_clock.svg" min-width="320" min-height="260" alt="Reloj animado">
        </figure>
      </div>

      <div class="main-numbers--container">
         <div class="main-numbers--left">
           <span class="communities-icon"></span>
           <p class="main-number">25+</p>
           <p class="main-number--description">Horarios creados</p>
         </div>
         <div class="main-numbers--right">
           <span class="message-icon"></span>
           <p class="main-number">50+</p>
           <p class="main-number--description">Personas lo recomiendan</p>
         </div>
      </div>
      <h2 align="center">"Si puedes imaginarlo, puedes programarlo" <br> -Alejandro Taboada</h2>
    </section>

    <section class="second-main--section">
      <div class="background-first--top"></div>
      <article class="article-container section-one">
        <figure class="article-image--container section-one">
          <img src="./images/illustration-grow-together.svg" min-width="320" min-height="260" alt="SVG animacion">
        </figure>
        <div class="article-content--container section-one order">
          <h2 class="article-title">Da un salto a la gestión de horarios</h2>
          <p class="article-description">Derivada de la pandemia del Sars Cov 2, los sistemas educativos han tenido que
            adapatarse a una nueva normalidad derivada de un año de emergencia sanitaria, a pesar de que lo se se podria creer
            dificilmente los sistemas educativos volveran al rol presencial en menos de un año, por lo que Visual CMJ viene como una 
            solución. <br> Planteamos crear horarios para CECyTS del IPN, Escuelas de la UNAM e independientes, centrandonos en una
            comunidad estudiantil.</p>
        </div>
      </article>
      <div class="background-first--bottom"></div>

      <section class="ready-section--container">
        <h3 class="ready-title">Mejores Horarios de 2021</h3>
        <a href="horario?TP=1000&GP=cecyt8_6im14"><button class="button--start">6IM14</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im13"><button class="button--start">6IM12</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im12"><button class="button--start">6IM10</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im11"><button class="button--start">6IM11</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im10"><button class="button--start">6IM10</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im9"><button class="button--start">6IM9</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im8"><button class="button--start">6IM8</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im5"><button class="button--start">6IM5</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im4"><button class="button--start">6IM4</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im3"><button class="button--start">6IM3</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im2"><button class="button--start">6IM2</button></a>
        <a href="horario?TP=1000&GP=cecyt8_6im1"><button class="button--start">6IM1</button></a>
        <a href="horario?TP=1000&GP=cecyt8_4im1"><button class="button--start">4IM1</button></a>
        <a href="horario?TP=1000&GP=cecyt8_2im2"><button class="button--start">2IM2</button></a>
        <a href="horario?TP=1000&GP=cecyt8_2im1"><button class="button--start">2IM1</button></a>
      </section>

      <article class="article-container middle-article">
        <figure class="article-image--container">
          <img src="./images/to_do_list.svg" min-width="320" min-height="260" alt="SVG to do">
        </figure>
        <div class="article-content--container">
          <h2 class="article-title">Recordatorios</h2>
          <p class="article-description">Con una cuenta podras ver tus recordatorios el dia siguiente de ponerlos, y se quitaran hasta que lo cambies!</p>
        </div>
      </article>

      <div class="background-second--top"></div>
      <article class="article-container section-two">
        <figure class="article-image--container section-two">
          <img src="./images/illustration-your-users.svg" min-width="320" min-height="260" alt="Comunidad svg">
        </figure>
        <div class="article-content--container section-two order">
          <h2 class="article-title">Creación de Horarios con links</h2>
          <p class="article-description">Funcion integrada del servicio de Visual CMJ, no toma mas de 15 minutos crear tu propio horario
            O bien suscribirte a uno ya hecho por la comunidad, podras crear materias y manejarlas según te sea conveniente, y con una cuenta
            de Visual CMJ podras guardar enlaces a cada materia para poder logear facil, sin olvidar que todos tus link te apareceran en una seccion de 
            Guardados.</p>
        </div>
      </article>
      <div class="background-second--bottom"></div>
    </section>

  </main>

  <div class="footer-background--top"></div>
  <footer>
    <section class="contact-form--container">
      <h2 class="contact-form--title">Tus opiniones son importantes</h2>
      <p class="contact-form--description">Esta es una version inicial del servicio, puedes enviarnos
      aqui alguna queja sobre este, nuestro equipo la revisara y trabajara en resolver tu problema. <br>
      De parte del equipo Pichos te damos un extenso agradecimiento por ser parte de Visual CMJ :)</p>
      <form action=".">
        <label for="email">
          <span>Breve Descripcion</span>
          <input type="text" id="email" name="description" placeholder="Sugerencias">
          <input type="button" value="Enviar" class="email-button">
        </label>
      </form>
    </section>
    
    <section class="about-huddle--container">
      <figure class="footer-logo">
        <h1>VISUAL CMJ</h1>
      </figure>
      <p class="about-huddle--description">Informacion de contacto.</p>
      <ul>
        <li><span class="mail-icon"></span>PichosVCMJ@gmail.com</li>
      </ul>
      <p class="attribution">
        Challenge by <a href="https://www.frontendmentor.io?ref=challenge" target="_blank" rel="noopener">Frontend Mentor</a>. 
        Coded by <a href="https://github.com/efrainhgmx" target="_blank" rel="noopener">efrainhgmx</a>.
      </p>
    </section>
  </footer>
</body>
</html>