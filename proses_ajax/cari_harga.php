<?php
	include "../konfigurasi/koneksi.php";
	
	$id_barang = $_POST['id_barang'];
	$query = "SELECT*FROM jenis_barang WHERE id_barang = '$id_barang'";
	
	$kirim = oci_parse($koneksi,$query);
	oci_execute($kirim);
	$data  = oci_fetch_array($kirim);
	
	$harga = $data['HARGA_PERSATUAN'];
	
	echo $harga;
	

?>