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
<h2>Girdiler</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Başlık</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($categories as $category):
            ?>
            <tr>
                <td><?=$category['id']?></td>
                <td><?=$category['title']?></td>
                <td><a href="<?= LINK_PREFIX ?>/Categories/Edit/<?=$category['id']?>">Güncelle</a>  <a href="<?= LINK_PREFIX ?>/Categories/Delete/<?=$category['id']?>">Sil</a></td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>