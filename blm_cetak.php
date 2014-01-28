<html>
	<head>
		<title>baca</title>
	</head>
	<body>
<table border="1">
	<tr>
		<td>Id Pegawai</td>
		<td colspan="2">&nbsp;&nbsp; &nbsp; <?php echo $id_pegawai; ?></td>
		<td rowspan="3" colspan="2" valign="middle">&nbsp;&nbsp;&nbsp; Biling &nbsp;<?php echo $no_billing; ?></td>
	</tr>
	<tr>
		<td>Nama pegawai</td>
		<td colspan="2">&nbsp;&nbsp; &nbsp; <?php echo $nama_pegawai; ?></td>
	</tr>
	<tr>
		<td>No. Laundry</td>
		<td colspan="2">&nbsp;&nbsp; &nbsp; <?php echo $id_laundry; ?></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td>Id Cek</td>
		<td>&nbsp;&nbsp; &nbsp; <?php echo $id_tamu; ?></td>
	</tr>
	<tr>
		<td colspan="3" valign="baseline" align="center" rowspan="3">tgl : <?php echo $tanggal; ?> , <?php echo $jam; ?></td>
		<td>nama tamu</td>
		<td>&nbsp;&nbsp; &nbsp;<?php echo $nama_tamu; ?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>&nbsp;&nbsp; &nbsp; <?php echo $alamat; ?></td>
	</tr>
	<tr>
		<td>No. Hp</td>
		<td>&nbsp;&nbsp; &nbsp; <?php echo $no_telp; ?> &nbsp;</td>
	</tr>
	<tr>
		<td colspan="5" align="center">Detail Pakaian</td>
	</tr>
	<tr>
		<th width="10" align="center">&nbsp;&nbsp;&nbsp;NO.&nbsp;&nbsp;&nbsp;</th>
		<th align="center">&nbsp;&nbsp;&nbsp;JENIS BARANG&nbsp;&nbsp;&nbsp;</th>
		<th align="center">&nbsp;&nbsp;&nbsp;HARGA&nbsp;&nbsp;&nbsp;</th>
		<th align="center">&nbsp;&nbsp;&nbsp;JUMLAH&nbsp;&nbsp;&nbsp;</th>
		<th align="center">&nbsp;&nbsp;&nbsp;SUB TOTAL&nbsp;&nbsp;&nbsp;</th>
	</tr>
	<?php 
		$no = 1;
		while($dt_detail = oci_fetch_array($kirim_laundry)){ ?>
	<tr>
		<td align="center"><?php echo $no++; ?></td>
		<td align="center"><?php echo $dt_detail['NAMA_BARANG']; ?> </td>
		<td align="center"><?php echo $dt_detail['HARGA_PERSATUAN']; ?></td>
		<td align="center"><?php echo $dt_detail['JUMLAH']; ?></td>
		<td align="center"><?php echo $dt_detail['TOTAL_LAUNDRY']; ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="4" align="right">Total Bayar &nbsp;&nbsp;</td>
		<td align="center"><b><?php echo $total_bayar; ?></b></td>
	</tr>
</table>
Kembali Ke <a href="pembayaran.php">Pembayaran</a>
</body>
</html>