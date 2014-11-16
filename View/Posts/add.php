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
<div class="row">
    <form action="<?= LINK_PREFIX ?>/Posts/add" method="post">
        <div class="row">
            <div class="large-12 columns">
                <label>Başlık
                    <input id="title" name="title" type="text" placeholder="Başlık"/>
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
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                        <?php endforeach; ?>
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
    <iframe id="form_target" name="form_target" style="display:none"></iframe>
    <form id="my_form" action="<?= LINK_PREFIX ?>/Files/add" method="post" target="form_target" method="post"
          enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden;display:none;">
        <input name="image" type="file" onchange="$('#my_form').submit();this.value='';">
    </form>
</div>
<div class="row">
    <h2>Media Gallery</h2>
</div>
<div class="row">
    <div class="large-4 columns">
        <form action="<?= LINK_PREFIX ?>/Files/add" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="large-12 columns">
                    <label>Dosya
                        <input type="file" id="file" name="file"/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="large-8 columns">
        <?php
        for ($i = 0; $i < count($files); $i++) {
            ?>
            <div class="large-3 columns media">
                <img class="image_list_element" src="<?= FILE_PREFIX ?>/images/<?= $files[$i]['filename'] ?>"
                     alt="<?= $files[$i]['id'] ?>"/><br/>
                <a href="<?= LINK_PREFIX ?>/Files/Delete/<?= $files[$i]['id'] ?>">Sil</a>
            </div>
        <?php
        }
        ?>
    </div>
</div>