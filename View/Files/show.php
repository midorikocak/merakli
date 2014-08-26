<?php
/*
*
* Yöneticilere verileri listeleyen sayfa
*
* Verileri bu tablo vasıtasıyla listeleyip,
* ID'ye göre silme ve düzenleme linklerini oluşturacağız.
*
* @author Midori Kocak 2014
*
*/
?>
<h2>Dosyalar</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Dosya Adı</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($files as $file):
            ?>
            <tr>
                <td><?=$file['id']?></td>
                <td><?=$file['filename']?></td>
                <td><a href="/Cms/index.php/Files/edit/<?=$file['id']?>">Güncelle</a>  <a href="/Cms/index.php/Files/delete/<?=$file['id']?>">Sil</a></td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>