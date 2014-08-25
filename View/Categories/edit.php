/*
*
* Adminlerin kategorileri düzenlediği sayfa
*
* Kategori ekleme işlemi ile neredeyse aynı formu kullanıyoruz.
* Ancak formda eski değerleri görebilmemiz için bu sayfaya $category değişkeninin
* hazır olarak gelmesi gerekiyor. ONları da inputların içine value olarak ekliyoruz.
*
* @author Midori Kocak 2014
*
*/

<form action="edit.php" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Başlık
        <input id="title" name="title" type="text" placeholder="large-12.columns" value="<?=$category['title']?>"/>
      </label>
    </div>
  </div>
  <div class="row">
      <div class="large-12 columns">
          <button type="submit">Submit</button>
      </div>
  </div>
</form>
