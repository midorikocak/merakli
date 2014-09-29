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
<form action="<?= LINK_PREFIX ?>/Posts/add" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Başlık
        <input id="title" name="title" type="text" placeholder="Başlık" />
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>İçerik
        <textarea id="content" name="content" placeholder="İçerik"></textarea>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>Kategoriler
        <select id="category" name="category">
            <?php foreach ($categories as $category):?>
                <option value="<?=$category['id']?>"><?=$category['title']?></option>
            <?php endforeach;?>
        </select>
      </label>
    </div>
  </div>
  <div class="row">
      <div class="large-12 columns">
          <button type="submit">Submit</button>
      </div>
  </div>
</form>
