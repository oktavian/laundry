<?php
	include "../konfigurasi/koneksi.php";
	
	$hrg_barang = $_POST['hrg_barang'];
	$jumlah 	= $_POST['jumlah'];
	
	/*
	$query = "SELECT*FROM jenis_barang WHERE id_barang = '$id_barang'";
	$kirim = oci_parse($koneksi,$query);
	oci_execute($kirim);
	$data  = oci_fetch_array($kirim);
	$harga = $data['HARGA_PERSATUAN'];
	*/
	
	$total_barang = $hrg_barang*$jumlah;
	echo $total_barang;
	

?>