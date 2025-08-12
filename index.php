<?php include 'header.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!-- En-tête du bandeau -->
<section class="main-banner">
  <div class="tp-banner-container">
    <div class="tp-banner">
      <ul>
        <!-- SLIDE -->
        <li data-transition="random" data-slotamount="7" data-masterspeed="300"  data-saveperformance="off" > 
          <!-- IMAGE PRINCIPALE --> 
          <img src="images/hmsab.jpg" alt="slider" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"> 
          
          <!-- COUCHE N°1 -->
          <div class="tp-caption sfl tp-resizeme" 
               data-x="center" data-hoffset="0" 
               data-y="center" data-voffset="-120" 
               data-speed="800" 
               data-start="800" 
               data-easing="Power3.easeInOut" 
               data-splitin="chars" 
               data-splitout="none" 
               data-elementdelay="0.03" 
               data-endelementdelay="0.4" 
               data-endspeed="300"
               style="z-index: 5; font-size:50px; font-weight:500; color:#FFFFFF; max-width: auto; max-height: auto; white-space: nowrap;">
            Système de Gestion Hospitalière
          </div>
          
          <!-- COUCHE N°2 -->
          <div class="tp-caption sfr tp-resizeme" 
               data-x="center" data-hoffset="0" 
               data-y="center" data-voffset="-60" 
               data-speed="800" 
               data-start="1000" 
               data-easing="Power3.easeInOut" 
               data-splitin="chars" 
               data-splitout="none" 
               data-elementdelay="0.03" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               style="z-index: 6; font-size:40px; color:#FFFFFF; font-weight:500; white-space: nowrap;">
            Nous prenons soin de votre santé
          </div>
          
          <!-- COUCHE N°3 -->
          <div class="tp-caption sfb tp-resizeme" 
               data-x="center" data-hoffset="0" 
               data-y="center" data-voffset="0" 
               data-speed="800" 
               data-start="1200" 
               data-easing="Power3.easeInOut" 
               data-splitin="none" 
               data-splitout="none" 
               data-elementdelay="0.1" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               style="z-index: 7; font-size:22px; color:#FFFFFF; font-weight:500; max-width: auto; max-height: auto; white-space: nowrap;">
            Meilleurs services d'hospitalité dans votre ville
          </div>
          
          <!-- COUCHE N°4 -->
          <div class="tp-caption lfb tp-resizeme scroll" 
               data-x="center" data-hoffset="0" 
               data-y="center" data-voffset="120"
               data-speed="800" 
               data-start="1300"
               data-easing="Power3.easeInOut" 
               data-elementdelay="0.1" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               data-scrolloffset="0"
               style="z-index: 8;">
            <a href="patientappointment.php" class="btn">Réserver Maintenant</a> 
          </div>
        </li>
        
        <!-- SLIDE -->
        <li data-transition="random" data-slotamount="7" data-masterspeed="300"  data-saveperformance="off" > 
          <!-- IMAGE PRINCIPALE --> 
          <img src="images/abcd.jpg" alt="slider" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"> 
          
          <!-- COUCHE N°1 -->
          <div class="tp-caption sfl tp-resizeme" 
               data-x="left" data-hoffset="400" 
               data-y="center" data-voffset="-100" 
               data-speed="800" 
               data-start="800" 
               data-easing="Power3.easeInOut" 
               data-splitin="chars" 
               data-splitout="none" 
               data-elementdelay="0.03" 
               data-endelementdelay="0.4" 
               data-endspeed="300"
               style="z-index: 5; font-size:40px; font-weight:500; color:#FFFFFF; max-width: auto; max-height: auto; white-space: nowrap;">
            Meilleur Centre de Diagnostic
          </div>
          
          <!-- COUCHE N°2 -->
          <div class="tp-caption sfr tp-resizeme" 
               data-x="left" data-hoffset="400" 
               data-y="center" data-voffset="-40" 
               data-speed="800" 
               data-start="800" 
               data-easing="Power3.easeInOut" 
               data-splitin="chars" 
               data-splitout="none" 
               data-elementdelay="0.03" 
               data-endelementdelay="0.4" 
               data-endspeed="300"
               style="z-index: 5; font-size:55px; font-weight:500; color:#FFFFFF; max-width: auto; max-height: auto; white-space: nowrap;">
            Soins et Guérison
          </div>
          
          <!-- COUCHE N°3 -->
          <div class="tp-caption sfb tp-resizeme" 
               data-x="left" data-hoffset="400" 
               data-y="center" data-voffset="30" 
               data-speed="800" 
               data-start="1400" 
               data-easing="Power3.easeInOut" 
               data-splitin="none" 
               data-splitout="none" 
               data-elementdelay="0.1" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               style="z-index: 7; font-size:16px; color:#FFFFFF; font-weight:500; line-height:26px; max-width: auto; max-height: auto; white-space: nowrap;">
            Performance diagnostique améliorée et satisfaction accrue des patients <br> et des médecins ravis.
          </div>
          
          <!-- COUCHE N°4 -->
          <div class="tp-caption lfb tp-resizeme scroll" 
               data-x="left" data-hoffset="400" 
               data-y="center" data-voffset="140"
               data-speed="800" 
               data-start="1600"
               data-easing="Power3.easeInOut" 
               data-elementdelay="0.1" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               data-scrolloffset="0"
               style="z-index: 8;">
            <a href="contactus.php" class="btn">CONTACTEZ-NOUS</a> 
          </div>
        </li>
        
        <!-- SLIDE -->
        <li data-transition="random" data-slotamount="7" data-masterspeed="300"  data-saveperformance="off" > 
          <!-- IMAGE PRINCIPALE --> 
          <img src="images/hmsabc.jpg" alt="slider" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"> 
          
          <!-- COUCHE N°2 -->
          <div class="tp-caption sfb tp-resizeme" 
               data-x="center" data-hoffset="0" 
               data-y="center" data-voffset="-80" 
               data-speed="800" 
               data-start="800" 
               data-easing="Power3.easeInOut" 
               data-elementdelay="0.1" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               data-scrolloffset="0"
               style="z-index: 6; font-size:40px; color:white; font-weight:500; white-space: nowrap;">
            Bienvenue dans notre centre de recherche
          </div>
          
          <!-- COUCHE N°3 -->
          <div class="tp-caption sfb tp-resizeme text-center" 
               data-x="center" data-hoffset="0" 
               data-y="center" data-voffset="-10" 
               data-speed="800" 
               data-start="1000" 
               data-easing="Power3.easeInOut" 
               data-elementdelay="0.1" 
               data-endelementdelay="0.1" 
               data-endspeed="300" 
               data-scrolloffset="0"
               style="z-index: 7; font-size:20px; font-weight:500; line-height:26px; color:white; max-width: auto; max-height: auto; white-space: nowrap;">
            Nous travaillons dans un environnement convivial et efficace avec les dernières <br>
            technologies et partageons notre expertise.
          </div>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- Contenu -->
<div id="content"> 
  
  <!-- Introduction -->
  <section class="p-t-b-150">
    <div class="container">
      <div class="intro-main">
        <div class="row"> 
          
          <!-- Détails de l'intro -->
          <div class="col-md-8">
            <div class="text-sec">
              <h5>Bilans de Santé</h5>
              <p>Cette application fournit des services de laboratoire clinique</p>
              <ul class="row">
                <li class="col-sm-6">
                  <h6> <i class="lnr lnr-checkmark-circle"></i> CAS D'URGENCE</h6>
                  <p>Cette application aide les hôpitaux en situation d'urgence</p>
                </li>
                <li class="col-sm-6">
                  <h6> <i class="lnr lnr-checkmark-circle"></i> MÉDECINS QUALIFIÉS</h6>
                  <p>Cette application aide les médecins qualifiés pour leur traitement</p>
                </li>
                <li class="col-sm-6">
                  <h6> <i class="lnr lnr-checkmark-circle"></i> RENDEZ-VOUS EN LIGNE</h6>
                  <p>Réservez un rendez-vous en ligne aujourd'hui !!!</p>
                </li>
                <li class="col-sm-6">
                  <h6> <i class="lnr lnr-checkmark-circle"></i> Services</h6>
                  <p>Profitez des services de cette application au bout de vos doigts</p>
                </li>
              </ul>
            </div>
          </div>
          
          <!-- Horaires d'ouverture -->
          <div class="col-md-4">
            <div class="timing"> <i class="lnr lnr-clock"></i>
              <ul>
                <li> Lundi <span>8.00 - 16.00</span></li>
                <li> Mardi <span>8.00 - 16.00</span></li>
                <li> Mercredi <span>8.00 - 16.00</span></li>
                <li> Jeudi <span>8.00 - 16.00</span></li>
                <li> Vendredi <span>8.00 - 16.00</span></li>
                <li> Samedi <span>8.00 - 16.00</span></li>
                <li> Dimanche <span>8.00 - 16.00</span></li>
              </ul>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>
  

  <!-- LISTE DES MÉDECINS -->
  <section class="p-t-b-150">
    <div class="container"> 
      
      <!-- Titre -->
      <div class="heading-block">
        <h2>Nos Services</h2>
        <hr>
        <span>Voici les services de notre hôpital</span>
      </div>
      
      <!-- Services -->
      <div class="services">
        <div class="row"> 
          
          <!-- Service -->
          <div class="col-md-4">
            <article>
              <div class="media-left"> <i class="flaticon-eye-2 icon"></i> </div>
              <div class="media-body">
                <h6>Spécialiste des Yeux</h6>
                <p>Obtenez les meilleurs soins pour les yeux</p>
              </div>
            </article>
          </div>
          
          <!-- Service -->
          <div class="col-md-4">
            <article>
              <div class="media-left"> <i class="flaticon-operating-room icon"></i> </div>
              <div class="media-body">
                <h6>Salle d'Opération</h6>
                <p>Installations de salle d'opération de classe mondiale</p>
              </div>
            </article>
          </div>
          
          <!-- Service -->
          <div class="col-md-4">
            <article>
              <div class="media-left"> <i class="flaticon-icu-monitor icon"></i> </div>
              <div class="media-body">
                <h6>Service de Soins Intensifs (USI)</h6>
                <p>Meilleure USI avec toutes les installations</p>
              </div>
            </article>
          </div>
          
          <div class="col-md-4">
            <article>
              <div class="media-left"> <i class="flaticon-stomach-2 icon"></i> </div>
              <div class="media-body">
                <h6>Problèmes d'Estomac</h6>
                <p>Nous résolvons également les problèmes d'estomac</p>
              </div>
            </article>
          </div>
          
          <!-- Service -->
          <div class="col-md-4">
            <article>
              <div class="media-left"> <i class="flaticon-doctor icon"></i> </div>
              <div class="media-body">
                <h6>Médecins Qualifiés</h6>
                <p>Nous avons les médecins les plus qualifiés</p>
              </div>
            </article>
          </div>
          
          <!-- Service -->
          <div class="col-md-4">
            <article>
              <div class="media-left"> <i class="flaticon-heartbeat icon"></i> </div>
              <div class="media-body">
                <h6>Problèmes Cardiaques</h6>
                <p>Un des meilleurs hôpitaux pour les problèmes cardiaques</p>
              </div>
            </article>
          </div>

        </div>
      </div>
    </div>
  </section>
  
</div>

<!-- Pied de page -->
<?php include 'footer.php';?>
