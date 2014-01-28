<?php
	session_start();
	include "konfigurasi/koneksi.php";
	//ambil tamu
	$ambil_tamu = "SELECT*FROM cek_in";
	$kirim_tamu = oci_parse($koneksi,$ambil_tamu);
	oci_execute($kirim_tamu,OCI_DEFAULT);

	//ambil barang
	$ambil_barang = "SELECT*FROM jenis_barang";
	$kirim_barang = oci_parse($koneksi,$ambil_barang);
	oci_execute($kirim_barang,OCI_DEFAULT);
	
	
	if((!isset($_SESSION['id_laundry']) && !isset($_SESSION['id_tamu'])) OR ($_SESSION['id_laundry']=="" && $_SESSION['id_tamu']=="")){
	
		//membuat attribut disabled
		$disable = "disabled";
		
		//mengambil database laundry
		$stid = oci_parse($koneksi,"SELECT * FROM (select * from laundry ORDER BY id_laundry DESC) suppliers2 
									WHERE rownum <= 1 ORDER BY rownum DESC");
		
		oci_execute($stid);
		$baris = oci_fetch_array($stid);
		$lastid = $baris['ID_LAUNDRY'];
		
		//membuat ID 
		if($lastid==""){
			$id_baru = "L-001";
		}else{
			$pisah    = explode("-",$lastid);
			$terahkir = (int) $pisah[1];
			$no_urut  = $terahkir+1;
			//echo $no_urut;
			$id_baru  = "L-".sprintf("%03s", $no_urut);
		}	
		
	}else{

		//membuat attribut disabled
		$disable = "";
		$id_baru = $_SESSION['id_laundry'];
		$id_tamu = $_SESSION['id_tamu'];
	}
	
	
	//menampilkan data laundry yang telah di input
	$ambil_laundry = "SELECT b.id_barang AS id_barang, b.nama_barang AS nama_barang, b.harga_persatuan AS harga,
					   d.jumlah AS jumlah, d.total_laundry AS total_laundry, d.id_detail AS id_detail
					   FROM detail_laundry d, jenis_barang b
					   WHERE d.id_laundry='$id_baru' 
					   AND d.id_barang = b.id_barang
					   ";
					 
	$kirim_query   = oci_parse($koneksi,$ambil_laundry);	
	oci_execute($kirim_query);
	
	
	
	$aksi = $_GET['aksi'];
	if($aksi=="edit"){
		$action = "proses_edit.php";
	}elseif(!isset($aksi)){
		$action = "proses_input_detail_laundry.php";
	}
	
		
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
		<?php include "konfigurasi/header.php"; ?>
	</head>
	<body>
	<div class="container" style="border: 1px solid black;">
		<?php include "konfigurasi/navigasi.php"; ?>
		<hr>
		
		<div class="row">
		<form action="<?php echo $action;?>" method="POST">
		<h3 <div class="col-lg-offset-4 align="center" style='margin-bottom:2;'>Input Data Laundry</h3>
			<div class="col-lg-offset-4 col-lg-4" style="border: 1px solid black;">
				<table cellpadding="10" cellspacing="5">
					<tr>
						<td>Tamu</td>
						<td>:</td>
						<td>
							<select name="id_cek" id="id_cek">
<?php if((isset($_SESSION['id_laundry']) && isset($_SESSION['id_tamu'])) OR ($_SESSION['id_laundry']!="" && $_SESSION['id_tamu']!="")){ ?>
									<option value="<?php echo $_SESSION['id_tamu']."_".$_SESSION['nama_tamu']; ?>" selected>
										<?php echo $_SESSION['id_tamu']." - ".$_SESSION['nama_tamu']; ?>
									</option>
								<?php }else{ ?>
								<option value="">-- silahkan pilih --</option>
								<?php while($dt_cek = oci_fetch_array($kirim_tamu,OCI_BOTH)){ ?>
										<option value="<?php echo $dt_cek['ID_CEK']."_".$dt_cek['NAMA_CEK']; ?>">
										<?php echo $dt_cek['ID_CEK']." - ".$dt_cek['NAMA_CEK']; ?>
										</option>
								<?php }} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Kode Barang</td>
						<td>:</td>
						<td>
							<select name="id_barang" id="id_barang">
							<?php if($_GET['aksi']=="edit") { ?>
								<option value="<?php echo $_GET['barang']; ?>"><?php echo $_GET['barang']." - ".$_GET['nama_barang']; ?></option>
							<?php }else { echo "<option value=>-- silahkan pilih --</option>"; }?>	
								<?php while($dt_barang = oci_fetch_array($kirim_barang,OCI_BOTH)){?>
										<option value="<?php echo $dt_barang['ID_BARANG']; ?>">
											<?php echo $dt_barang['ID_BARANG']." - ".$dt_barang['NAMA_BARANG']; ?>
										</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Harga</td>
						<td>:</td>
						<td>
							<input type="text" name="harga" id="harga" value="<?php if($_GET['aksi']=="edit"){echo $_GET['harga'];} ?>" />
						</td>
					</tr>
					<tr>
						<td>Jumlah</td>
						<td>:</td>
						<td><input type="text" name="jumlah" id="jumlah" value="<?php if($_GET['aksi']=="edit"){echo $_GET['jumlah'];} ?>" /></td>
					</tr>
					<tr>
						<td>Total</td>
						<td>:</td>
						<td>
							<input type="text" name="total" id="total" value="<?php if($_GET['aksi']=="edit"){echo $_GET['total'];} ?>" />
							<input type="hidden" name="id_laundry" id="id_laundry" value="<?php echo $id_baru; ?>" />
							<input type="hidden" name="detail" id="detail" value="<?php if($_GET['aksi']=="edit"){echo $_GET['detail'];} ?>" />
						</td>
					</tr>
					<tr>
						<input type="hidden" name="tambah" value="1" /> 
						<td colspan="3"><input type="submit" value="tambah" /></td>
					</tr>
				</table>
			</div>
			</form>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php
					$berhasil = $_GET['berhasil'];
					if($berhasil == "edit"){
						echo "<h1>Anda berhasil mengedit data</h1>";
					}elseif($berhasil=="delete"){
						echo "<h1>Anda berhasil mendelete data</h1>";
					}elseif($berhasil=="tambah"){
						echo "<h1>Anda berhasil menambah data</h1>";
					}
				
				?>	
			</div>
		</div>
		<br>
		<div class="row">
			<table border="1" style="width:100%; margin: 10px auto;">
				<tr>
					<th>No.</th>
					<th>Kode Barang</th>
					<th>Jenis Barang</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Total</th>
					<th>Aksi</th>
				</tr>
			<?php
				$no = 1;
				while($data = oci_fetch_array($kirim_query)){ ?>	
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $data['ID_BARANG']; ?></td>
					<td><?php echo $data['NAMA_BARANG']; ?></td>
					<td><?php echo $data['HARGA']; ?></td>
					<td><?php echo $data['JUMLAH']; ?></td>
					<td><?php echo $data['TOTAL_LAUNDRY']; ?></td>
					<td><a href="?aksi=edit&detail=<?php echo $data['ID_DETAIL']; ?>&barang=<?php echo $data['ID_BARANG']; ?>&nama_barang=<?php echo $data['NAMA_BARANG'];?>&harga=<?php echo $data['HARGA']; ?>&jumlah=<?php echo $data['JUMLAH']; ?>&total=<?php echo $data['TOTAL_LAUNDRY']; ?>">edit</a> 
						| <a href="proses_delete.php?aksi=delete&detail=<?php echo $data['ID_DETAIL']; ?>">delete</a>
					</td>
				</tr>
			<?php } ?>	
			</table>
			<form method="POST" action="proses_input_laundry.php" style="width: 100px; margin: 10px auto;">
				<input type="hidden" name="id_laundry" value="<?php echo $id_baru; ?>" />
				<input type="submit" value="SAVE" />
			</form>
		</div>
	</div>
	</body>
</html>