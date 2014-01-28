<?php
	session_start();
	include "konfigurasi/koneksi.php";
		
	//pilih laundry
	$pilih_laundry = "SELECT*FROM laundry WHERE id_laundry = '$id_lon'";
	$kirim_pilihan = oci_parse($koneksi,$pilih_laundry);
	oci_execute($kirim_pilihan);
	
	$dt_laundry = oci_fetch_array($kirim_pilihan);
	$status     = $dt_laundry['STATUS'];
	
	
	
	
	
	//seleksi all data tabel laundry 
	$ambil_laundry = "SELECT l.id_laundry AS id_laundry, 
						c.nama_cek AS nama_cek, 
						d.id_barang AS id_barang, 
						d.jumlah AS jumlah,
						d.total_laundry AS total_laundry,
						j.nama_barang AS nama_barang, 
						j.harga_persatuan,
						l.status AS status
						FROM laundry l, cek_in c, detail_laundry d, jenis_barang j
						WHERE c.id_cek = l.id_cek 
						AND l.id_laundry = d.id_laundry
						AND j.id_barang = d.id_barang order by id_laundry
					 ";
	
	$kirim_laundry = oci_parse($koneksi,$ambil_laundry);
	oci_execute($kirim_laundry);
	
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Pembayaran</title>
		<?php include "konfigurasi/header.php"; ?>
	</head>
	<body>
	<div class="container" style="border: 1px solid black;">
		<?php include "konfigurasi/navigasi.php"; ?>
		<hr>
		
		<div class="row">
		<form action="cetak_laundry.php" method="POST">
		<h3 align="center">Cari Data Laundry</h3>
		<table style="margin:0 auto;">
			<tr>
				<td>Id Laundry</td>
				<td>:</td>
				<td>
				<input type="text" name="id_laundry" id="id_laundry" value="" />
				<input type="hidden" name="status" id="status" value="" />
				<input type="hidden" name="tamu" id="tamu" value="" />
				</td>
			</tr>
			<tr>
				<td>Total</td>
				<td>:</td>
				<td><input type="text" name="total_bayar" id="total_bayar" value="" /></td>
			</tr>
			<tr>
				<td>Cetak</td>
				<td>:</td>
				<td>
					<select name="cetak" id="cetak">
						<option value="">-- silahkan pilih --</option>
						<option value="cetak">Cetak Kwitansi</option>
						<option value="bayar">Bayar</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3"><input type="submit" value="submit" /></td>
			</tr>
		</table>
		</form>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php 
					$notif = $_GET['notif'];
					
						if($notif=="sudah"){
							echo "<h1 align=center>Kuitansi Sudah Pernah Di cetak sebelumnya</h1>";
						}elseif($notif=="lunas"){
							echo "<h1 align=center>Tamu Sudah Melunasinya</h1>";
						}elseif($notif=="beres"){
							echo "<h1 align=center>Selamat Anda Telah Melengkapi Pembayaran</h1>";
						}elseif($notif=="dulu"){
							echo "<h1 align=center>Cetak Kwitansi Dulu</h1>";
						}elseif($notif=="kosong"){
							echo "<h1 align=center>Lengkapi Form Terlebih Dahulu</h1>";
						}
				?>
			</div>
		</div>
		<br>
		<div class="row">
			<table border="1" style="margin: 10px auto; width:100%;" id="tbl_pembayaran">
			<thead>
				<tr>
					<th>NO.</th>
					<th>ID LAUNDRY</th>
					<th>NAMA TAMU</th>
					<th>JENIS BARANG</th>
					<th>HARGA</th>
					<th>JUMLAH</th>
					<th>TOTAL</th>
					<th>STATUS</th>
				</tr>
			</thead>
			<tbody>	
			<?php
				$no = 1;
				while($data = oci_fetch_array($kirim_laundry)){ ?>	
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $data['ID_LAUNDRY']; ?></td>
					<td><?php echo $data['NAMA_CEK']; ?></td>
					<td><?php echo $data['NAMA_BARANG']; ?></td>
					<td><?php echo $data['HARGA_PERSATUAN']; ?></td>
					<td><?php echo $data['JUMLAH']; ?></td>
					<td><?php echo $data['TOTAL_LAUNDRY']; ?></td>
					<td><?php echo $data['STATUS']; ?></td>
				</tr>
			<?php } ?>
			<tbody>	
			</table>
		</div>
	</div>
	</body>
</html>