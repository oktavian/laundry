<?php
	session_start();
	include "konfigurasi/koneksi.php";
	
	//ambil id detail yang ingin di delete
	$aksi = $_GET['aksi'];
	$detail = $_GET['detail'];
	
	$delete_query = "DELETE FROM detail_laundry WHERE id_detail = '$detail'";
	$kirim_query  = oci_parse($koneksi,$delete_query);
	oci_execute($kirim_query);
	if($kirim_query){
		header("location:home.php?berhasil=delete");
	}
	
?>