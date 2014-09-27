<?php
/*
*
* Kullanıcıların oturum açtığı sayfa.
*
* Veriyi kullanıcıdan alacak ve gerekli yerlere göndereceğiz.
*
* @author Midori Kocak 2014
*
*/

?>
<div class="row">
  <div class="small-6 large-centered columns">
      <form action="login" method="post">
        <div class="row">
          <div class="large-12 columns">
            <label>Kullanıcı adı
              <input id="username" name="username" type="text" placeholder="Kullanıcı adı" />
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
                <button type="submit">Gönder</button>
            </div>
        </div>
      </form>
  </div>
</div>