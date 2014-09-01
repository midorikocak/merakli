<?php
/*
*
* Adminlerin kullanıcıları düzenlediği sayfa
*
* Kullanıcı ekleme işlemi ile neredeyse aynı formu kullanıyoruz.
* Ancak formda eski değerleri görebilmemiz için bu sayfaya $user değişkeninin
* hazır olarak gelmesi gerekiyor.
*
* @author Midori Kocak 2014
*
*/
?>

<form action="/Cms/index.php/Users/edit/<?=$user['id']?>" method="post">
    <div class="row">
        <div class="large-12 columns">
            <label>Kullanıcı Adı
                <input id="username" name="username" type="text" placeholder="Kullanıcı Adı" value="<?=$user['username']?>" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>E-posta Adresi
                <input id="email" name="email" type="text" placeholder="E-Posta Adresi" value="<?=$user['email']?>" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Parola
                <input id="password" name="password" type="password" placeholder="Parola" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Parola Tekrarı
                <input id="password2" name="password2" type="password" placeholder="Parola Tekrarı" />
            </label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <button type="submit">Submit</button>
        </div>
    </div>
</form>