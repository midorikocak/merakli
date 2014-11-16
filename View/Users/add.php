<?php
/*
*
* Adminlerin yeni kullanıcı eklediği sayfa
*
* Veriyi kullanıcıdan alacak ve gerekli yerlere göndereceğiz.
*
* @author Midori Kocak 2014
*
*/  
?>
<form action="<?= LINK_PREFIX ?>/Users/Add" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Kullanıcı Adı
        <input id="username" name="username" type="text" placeholder="Kullanıcı Adı" />
      </label>
    </div>
  </div>
    <div class="row">
        <div class="large-12 columns">
            <label>E-posta Adresi
                <input id="email" name="email" type="text" placeholder="E-Posta Adresi" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Parola
                <input id="password" name="password" type="password" placeholder="Parola" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Parola Tekrarı
                <input id="password2" name="password2" type="password" placeholder="Parola Tekrarı" />
            </label>
        </div>
    </div>
  <div class="row">
      <div class="large-12 columns">
          <button type="submit">Submit</button>
      </div>
  </div>
</form>
