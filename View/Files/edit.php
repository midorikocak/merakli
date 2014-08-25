/*
*
* Adminlerin yeni yazıları düzenlediği sayfa
*
* Yazı ekleme işlemi ile neredeyse aynı formu kullanıyoruz.
* Ancak formda eski değerleri görebilmemiz için bu sayfaya $post değişkeninin
* hazır olarak gelmesi gerekiyor.
*
* @author Midori Kocak 2014
*
*/

<form action="add.php" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="large-12 columns">
      <label>Dosya
        <input type="file" placeholder="large-12.columns"/>
      </label>
    </div>
  </div>
</form>
