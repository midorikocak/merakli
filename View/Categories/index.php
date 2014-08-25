/*
*
* Kulllanıcılara kategorileri gösteren sayfa.
*
* Bu sayfaya ham veri $posts şeklinde ilişkili dizi halinde gelecek
* biz de dosya içerisinde istediğimiz şekilde verileri göstereceğiz.
* Dosya bize ham veriyi, taglenmiş html şeklinde göstermeye yarıyor.
*
* @author Midori Kocak 2014
*
*/

<table>
    <?php
    if(sizeof($categories>0)):
        foreach($categories as $category):
            ?>
            <tr>
                <td><?php echo $category['title']; ?></td>
            </tr>
            <?php?
        endforeach;
    endif;
    ?>
</table>


