<?php
	session_start();
	include "konfigurasi/koneksi.php";
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	

		if($username!="" && $password!=""){
		//ambil data user di database
		$query = "SELECT id_pegawai, nama_pegawai, password FROM pegawai WHERE nama_pegawai = '$username' AND password = '$password'";
		$kirim = oci_parse($koneksi, $query);
		oci_execute($kirim);
		$data = oci_fetch_array($kirim);
		
		//mencari jumlah datanya
		$id_pegawai   = $data['ID_PEGAWAI']; 
		$nama_pegawai = $data['NAMA_PEGAWAI']; 
		$password     = $data['PASSWORD']; 
		$jml_data	 = oci_num_rows($kirim);
		
		//$jml_data = $data['jumlah_data'];
		
		if($jml_data==1){
			
			$_SESSION['pegawai'] = $id_pegawai; 
			$_SESSION['user']    = $username; 
			$_SESSION['pass']    = $password; 
			
			header("location:home.php");
		}else{
			header("location:index.php");
			exit;
		}	
	}else{
		header("location:index.php");
	}
	
?>
