<?php
/*
*
* Adminlerin yeni yazı eklediği sayfa
*
* Veriyi kullanıcıdan alacak ve gerekli yerlere göndereceğiz.
* Kategori seçeceğimiz için kategorilerin dizi olarak ($categories) 
* dosyaya gelmiş olması gerekiyor. Çünkü bağlantılı bilgi.
* Biz de bundan liste oluşturacağız.
*
* @author Midori Kocak 2014
*
*/
?>

<form action="/Cms/index.php/Files/add" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
      <label>Dosya
        <input type="file" id="file" name="file" />
      </label>
    </div>
  </div>
  <div class="row">
      <div class="large-12 columns">
          <button type="submit">Submit</button>
      </div>
  </div>
</form>
