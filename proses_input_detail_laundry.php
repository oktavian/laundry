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
	
	
	$id_barang  = $_POST['id_barang'];
	$jumlah     = $_POST['jumlah'];
	$total		= $_POST['total'];
	//$tanggal    = date("d-m-Y");
	
	//membuat id detail laundry
	/*
	$stid = oci_parse($koneksi,"SELECT * FROM (select * from detail_laundry ORDER BY id_laundry DESC) suppliers2 
									WHERE rownum <= 1 ORDER BY rownum DESC");
		
		oci_execute($stid);
		$baris = oci_fetch_array($stid);
		$lastid = $baris['ID_DETAIL'];
		
		//membuat ID 
		if($lastid==""){
			$id_detail = "D-".$id_laundry."-1";
		}else{
			$pisah    = explode("-",$lastid);
			$terahkir = (int) $pisah[3]; 
			$no_urut  = $terahkir+1;
			$id_detail  = "D-".$id_laundry."-".$no_urut;
		}
	*/
	$id_detail = $id_laundry."_".$id_barang."-".$_SESSION['tambah'];
	

	//check tabel laundry -> id_laundry yang dikirm -> sudah ada atau belum;
	if((!isset($_SESSION['id_laundry']) && !isset($_SESSION['id_tamu'])) OR ($_SESSION['id_laundry']=="" && $_SESSION['id_tamu']=="")){
	
		//masukan ke tabel laundry untuk pertama kali
		$masukan_laundry = "INSERT into laundry (id_laundry, id_pegawai, id_cek) 
							VALUES ('$id_laundry','$id_pegawai','$id_cek')";
							
		$kirim_laundry    = oci_parse($koneksi,$masukan_laundry);
		oci_execute($kirim_laundry);

		//kalau sukses masuk -> langsung commit
		if($kirim_laundry){
			oci_commit($koneksi);
		}else{
			echo "salah insert di tabel laundry";
		}			
	}else{
		$kirim_laundry = true;
	}
	
	//jika sudah masuk laundry -> masukan ke detail laundry untuk pertama kali
	if($kirim_laundry){
		
		//inisialisasi id tamu dan id laundry
		$_SESSION['id_tamu']    = $id_cek;
		$_SESSION['nama_tamu']  = $nama_tamu;
		$_SESSION['id_laundry'] = $id_laundry;  
		
		//masukan database ke tabel detail laundry (benar)
		$query = "INSERT into detail_laundry(id_detail, id_laundry, id_barang,jumlah,total_laundry) 
				  VALUES ('$id_detail','$id_laundry','$id_barang',$jumlah,$total)";	
				  		  
		$kirim = oci_parse($koneksi,$query);	
		if($kirim){			
			$exec = oci_execute($kirim);
			oci_commit($koneksi);
			header("location:home.php?berhasil=tambah");
		}else{
			echo "salah insert di detail laundry";
		}		  
	}else{
		echo "kirim laundry lolos";
	}	
?>