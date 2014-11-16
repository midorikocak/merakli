<?php
/*
*
* Adminlerin yeni kategori eklediği sayfa
*
* Veriyi kullanıcıdan alacak ve gerekli yerlere göndereceğiz.
*
* @author Midori Kocak 2014
*
*/
?>

<form action="<?= LINK_PREFIX ?>/Categories/Add" method="post">
    <div class="row">
    <div class="large-12 columns">
      <label>Başlık
        <input id="title" name="title" type="text" placeholder="Başlık" />
      </label>
    </div>
  </div>
  <div class="row">
      <div class="large-12 columns">
          <button type="submit">Submit</button>
      </div>
  </div>
</form>
