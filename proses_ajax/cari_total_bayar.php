<?php
	session_start();
	include "../konfigurasi/koneksi.php";
	
	$id_laundry = $_POST['id_laundry'];
	
	$cari_laundry  = "SELECT * FROM laundry WHERE id_laundry = '$id_laundry'";
	$kirim_laundry = oci_parse($koneksi,$cari_laundry); 
	oci_execute($kirim_laundry);
	
	$data = oci_fetch_array($kirim_laundry);
	$id_laundry = $data['ID_LAUNDRY'];
	$jumlah     = $data['TOTAL_BAYAR'];
	$status     = $data['STATUS'];
	$id_cek     = $data['ID_CEK'];
	
	$arr = array('laundry'=>$id_laundry,'bayar'=>$jumlah,'status'=>$status,'id_cek'=>$id_cek);
	echo json_encode($arr);

	
	
?>