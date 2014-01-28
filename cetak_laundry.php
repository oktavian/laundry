<?php
	session_start();
	include "konfigurasi/koneksi.php";
	
	$nama_pegawai = $_SESSION['user'];
	$id_pegawai   = $_SESSION['pegawai'];
		
	$id_laundry  = $_POST['id_laundry'];
	$total_bayar = $_POST['total_bayar'];
	$status		 = $_POST['status'];
	$cetak	     = $_POST['cetak'];
	$id_tamu	 = $_POST['tamu'];
	$tanggal     = date("d-m-Y");
	$jam		 = date("H:i:s");
	
	//ambil tamu 
	$ambil_tamu = "SELECT*FROM cek_in WHERE id_cek = '$id_tamu'";
	$kirim_tamu = oci_parse($koneksi,$ambil_tamu);
	oci_execute($kirim_tamu);
	$dt_tamu = oci_fetch_array($kirim_tamu);
	//mendefinisikan tamu
	$nama_tamu = $dt_tamu['NAMA_CEK'];
	$no_telp   = $dt_tamu['NO_TELP'];
	$alamat	   = $dt_tamu['ALAMAT'];
	
	//mengambil detail laundry by id laundry
	$ambil_laundry = "SELECT d.*, b.* FROM detail_laundry d, jenis_barang b 
						WHERE d.id_laundry = '$id_laundry'
						AND d.id_barang = b.id_barang";
	$kirim_laundry = oci_parse($koneksi,$ambil_laundry);
	oci_execute($kirim_laundry);
	
	
	if($cetak=="cetak" && $status=="belum lunas"){

	$stid = oci_parse($koneksi,"SELECT * FROM (select * from billing ORDER BY no_billing DESC) suppliers2 
									WHERE rownum <= 1 ORDER BY rownum DESC");
		
		oci_execute($stid);
		$baris = oci_fetch_array($stid);
		$lastid = $baris['NO_BILLING'];
		
		//membuat ID 
		if($lastid==""){
			$no_billing = "B-001";
		}else{
			$pisah    = explode("-",$lastid);
			$terahkir = (int) $pisah[1];
			$no_urut  = $terahkir+1;
			//echo $no_urut;
			$no_billing  = "B-".sprintf("%03s", $no_urut);
		}
	
	//perbaharui tabel billing by ID BILLING
	$insert_billing = "INSERT into billing(no_billing,id_laundry,total) VALUES('$no_billing','$id_laundry','$total_bayar')";
	$kirim_query    = oci_parse($koneksi,$insert_billing);
	oci_execute($kirim_query);
	
	if($kirim_query){
		$query_pertama = "berhasil";
	}
	
	//update status laundry, karena sudah mencetak kuitansi
	$update_status_laundry = "UPDATE laundry SET status = 'sudah di cetak' WHERE id_laundry = '$id_laundry'";
	$kirim_query_update    = oci_parse($koneksi,$update_status_laundry);
	oci_execute($kirim_query_update);
	
	if($kirim_query_update){
		$query_kedua = "berhasil";
	}
	
	
	if($query_pertama=="berhasil" && $query_kedua=="berhasil"){
		oci_commit($koneksi);
		/*
		// Fungsi header dengan mengirimkan raw data excel
		header("Content-type: application/vnd-ms-excel");
		// Mendefinisikan nama file ekspor "hasil-export.xls"
		header("Content-Disposition: attachment; filename=hasil-export.xls");
		*/
		// Tambahkan table
		include 'blm_cetak.php';
		
	}else{
		echo "ada yang salah";
	}
	
	}elseif($cetak=="cetak" && $status=="sudah di cetak"){
		header("location:pembayaran.php?notif=sudah");
	
	}elseif($cetak=="bayar" && $status=="sudah di cetak"){
	
		//
		$bayar = "update laundry set status='lunas' where id_laundry='$id_laundry'";
		$sent_status = oci_parse ($koneksi,$bayar);
		oci_execute($sent_status);
	
		//lunasi pembayaran (minta uang nya!!!!!) dan update ke table billing -> tgl bayar
		$update_tgl = "UPDATE billing SET tgl_bayar = '$tanggal' WHERE id_laundry = '$id_laundry'";
		$kirim_tgl  = oci_parse($koneksi,$update_tgl);
		oci_execute($kirim_tgl);
		if($kirim_tgl){
			header("location:pembayaran.php?notif=beres");
		}
	
	}elseif($cetak=="bayar" && $status=="lunas"){
		//tak cetak - tapi harus bayar
		header("location:pembayaran.php?notif=lunas");
	}elseif($cetak=="bayar" && $status=="belum lunas"){
		//tak cetak - tapi harus bayar
		header("location:pembayaran.php?notif=dulu");
	}elseif(($id_laundry=="" && $total_bayar=="") OR $cetak==""){
		header("location:pembayaran.php?notif=kosong");
	}
	
	
		
	

?>