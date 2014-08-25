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

<form action="edir.php" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Başlık
        <input type="text" placeholder="large-12.columns" value="<?=$post['title']?>"/>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>İçerik
        <textarea placeholder="small-12.columns">value="<?=$post['content']?>"</textarea>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>Kategoriler
        <select>
            <?php foreach ($categories as $category):?>
                <option value="<?=$category['id']?>"
                    
                    <?php
                    if($category['id']==$post['category_id']){
                        echo " selected "
                    }
                    ?>
                    
                    ><?=$category['title']?></option>
            <?php endforeach:?>
        </select>
      </label>
    </div>
  </div>
</form>
