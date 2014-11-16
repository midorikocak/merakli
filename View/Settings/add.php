<?php
/*
*
* Siteye ilk ayarların eklendiği sayfa
*
* Veriyi kullanıcıdan alacak ve gerekli yerlere göndereceğiz.
*
* @author Midori Kocak 2014
*
*/  
?>
<form action="<?= LINK_PREFIX ?>/Settings/add" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Site Başlığı
        <input id="title" name="title" type="text" placeholder="Site Başlığı" />
      </label>
    </div>
  </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Site Açıklaması
                <input id="description" name="description" type="text" placeholder="Site Açıklaması" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Site Altbilgi
                <input id="copyright" name="copyright" type="text" placeholder="Site Altbilgisi" />
            </label>
        </div>
    </div>
  <div class="row">
      <div class="large-12 columns">
          <button type="submit">Submit</button>
      </div>
  </div>
</form>
