<?php
	session_start();
	include "konfigurasi/koneksi.php";
	
	//ambil data data yang di inputkan
	
	$id_pegawai = $_SESSION['pegawai']; 
	$id_laundry = $_POST['id_laundry'];
	$_SESSION['tambah'] = $_SESSION['tambah']+$_POST['tambah'];
	
	//memisah dan membuat id tamu yang baru
	$cek     	= $_POST['id_cek'];
	//memisah 
	$pisah      = explode("_",$cek);
	$id_cek		= $pisah[0];
	$nama_tamu  = $pisah[1];
	
	
	$id_detail  = $_POST['detail'];
	$id_barang  = $_POST['id_barang'];
	$jumlah     = $_POST['jumlah'];
	$total		= $_POST['total'];
	
	
	//update query 
	$update_query = "UPDATE detail_laundry SET id_barang = '$id_barang', 
												jumlah=$jumlah,
												total_laundry=$total
					WHERE id_detail='$id_detail'";
					
	$kirim_query  = oci_parse($koneksi,$kirim_query);
	oci_execute($kirim_query);
	
	if($kirim_query){
		header("location: home.php?berhasil=edit");
	}
	
	

?>