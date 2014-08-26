<?php
/*
*
* Yöneticilere verileri listeley sayfa
*
* Verileri bu tablo vasıtasıyla listeleyip,
* ID'ye göre silme ve düzenleme linklerini oluşturacağız.
*
* @author Midori Kocak 2014
*
*/
?>
<table>
    <thead>
        <tr>
            <th >Id</th>
            <th>Başlık</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($categories as $category):
            ?>
            <tr>
                <td><?=$category['id']?></td>
                <td><td><?=$category['title']?></td></td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>