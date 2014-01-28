<?php
	session_start();
	include "konfigurasi/koneksi.php";
	
	$id_laundry    = $_POST['id_laundry'];
	$tgl_transaksi = date("d-m-Y");
	$status 	   = "belum lunas";
	
	//mengambil detail laundry
	$ambil_detail_laundry = "SELECT SUM(total_laundry) AS jml FROM detail_laundry WHERE id_laundry = '$id_laundry'";
	$kirim_query 		  = oci_parse($koneksi,$ambil_detail_laundry);
	oci_execute($kirim_query);
	
	$data = oci_fetch_array($kirim_query);
	$total_bayar = $data[0];
	
	//update tabel laundry dengan status belum lunas
	
	$update_laundry = "UPDATE laundry SET tgl = '$tgl_transaksi', total_bayar = $total_bayar, status = '$status'
						WHERE id_laundry = '$id_laundry'
					  ";
					  
	$kirim_query2   = oci_parse($koneksi,$update_laundry);
	oci_execute($kirim_query2);
		
	if($kirim_query2){
		oci_commit($koneksi);
		header("location:pembayaran.php");	
	}else{
		echo "salah ";
	}
	
	
	
	
?>