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

<form action="add.php" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Başlık
        <input type="text" placeholder="large-12.columns" />
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>İçerik
        <textarea placeholder="small-12.columns"></textarea>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>Kategoriler
        <select>
            <?php foreach ($categories as $category):?>
                <option value="<?=$category['id']?>"><?=$category['title']?></option>
            <?php endforeach:?>
        </select>
      </label>
    </div>
  </div>
</form>
