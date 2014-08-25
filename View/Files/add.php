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

<form action="add.php" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
      <label>Dosya
        <input type="file" placeholder="large-12.columns" />
      </label>
    </div>
  </div>
</form>
