<?php include 'header.php';?>

<!-- Content -->
<div id="content"> 
  <!-- Contact Us -->
  <section class="p-t-b-150" style="background-image:url('images/contactus.jpg');background-repeat: no-repeat;background-size: 100%;"> 
    <!-- CONTACT FORM -->
    <div class="container"> 
      <!-- Tittle -->
      <div class="heading-block">
        <h4 style="font-weight:500;">ENTRER EN CONTACT</h4>
        <hr>
        <span>Envoyez votre avis</span> 
      </div>
      <div class="contact">
        <div class="contact-form"> 
          <!-- FORM  -->
          <form role="form" id="contact_form" class="contact-form" method="post" onSubmit="return false">
            <div class="row">
              <div class="col-md-6">
                <ul class="row">
                  <li class="col-sm-12">
                    <label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="*Nom">
                    </label>
                  </li>
                  <li class="col-sm-12">
                    <label>
                      <input type="text" class="form-control" name="email" id="email" placeholder="*E-mail">
                    </label>
                  </li>
                  <li class="col-sm-12">
                    <label>
                      <input type="text" class="form-control" name="company" id="company" placeholder="Téléphone">
                    </label>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="row">
                  <li class="col-sm-12">
                    <label>
                      <input type="text" class="form-control" name="website" id="website" placeholder="Service">
                    </label>
                  </li>
                  <li class="col-sm-12">
                    <label>
                      <textarea class="form-control" name="message" id="message" rows="5" placeholder="*Message"></textarea>
                    </label>
                  </li>
                  <li class="col-sm-12 no-margin">
                    <button type="submit" value="submit" class="btn" id="btn_submit" onClick="location.href='index.php'">ENVOYER LE MESSAGE</button>
                  </li>
                </ul>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  
  <!-- MAP -->
  <section class="map-block margin-top-100">
    <div class="map-wrapper" id="map-canvas" data-lat="23.740051" data-lng="90.371239" data-zoom="13" data-style="1"></div>
    <div class="markers-wrapper addresses-block"> 
      <a class="marker" data-rel="map-canvas" data-lat="23.740051" data-lng="90.371239" data-string="Hôpital Médical"></a> 
    </div>
  </section>
</div>
<!-- Footer -->

<?php include 'footer.php';?>
