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
<h2>Kullanıcılar</h2>
<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Kullanıcı Adı</th>
        <th>E-posta</th>
        <th>İşlemler</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user):
        ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['username'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><a href="<?= LINK_PREFIX ?>/Users/Edit/<?= $user['id'] ?>">Güncelle</a> <a
                    href="<?= LINK_PREFIX ?>/Users/Delete/<?= $user['id'] ?>">Sil</a></td>
        </tr>
    <?php
    endforeach;
    ?>
    </tbody>
</table>