<h1 align="center">IMAP DOWNLOADED FILE</h1>
<table border="1" align="center">
    <tr>
        <th>Sr No</th>
        <th>File Name</th>
    </tr>
    <?php
    $srNo = 1;
    foreach($files as $file){
        echo "<tr>";
        echo "<td>".$srNo."</td>";
        echo "<td>".$file."</td>";
        echo "</tr>";
    
        $srNo++;
    
    }
    ?>
</table>