<?php
 
 header("Content-type: application/vnd-ms-excel");
// header("Content-type: application/octet-stream");
 
header("Content-Disposition: attachment; filename=$title.xls");
 
header("Pragma: no-cache");
 
header("Expires: 0");
 
?>
 
<table border="1" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Nama Perusahaan</th>
            <th>Alamat</th>
            <th>Bidang Usaha</th>
            <th>Email</th>
           </tr>
      </thead>
      <tbody>
           <?php $i=1; foreach($perusahaan as $key => $value) { ?>
           <tr>
                <td><?=$i++?></td>
                <td>'<?=$value['kd_perusahaan']?>'</td>
                <td><?=$value['nama_perusahaan']?></td>
                <td><?=$value['alamat']?></td>
                <td><?=$value['bidang_usaha']?></td>
                <td><?=$value['email']?></td>
           </tr>
           <?php } ?>
      </tbody>
 </table>