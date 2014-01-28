<script>
	$(document).ready(function(){
		setInterval(function(){
			$('#divjam').load('jam.php?acak='+Math.random());
		},100); //refresh 1 detik
	});
</script>

<div class="row">
			<div class="col-lg-12">
				<ul id="menu">
					<li><a href="home.php">Laundry</a></li>
					<li><a href="pembayaran.php">Pembayaran</a></li>
					<li><a href="proses_logout.php">Logout</a></li>
					<div class="clear"></div>
				</ul>
			</div>
		</div>
			<div class="col-lg-3">
				<h4>Selamat Datang, <?php echo $_SESSION['user']; ?></h4>
				<?php if(isset($id_baru)){?>
				<h4>No. Laundry : <?php echo $id_baru; ?></h4>
				<?php } ?>
				<!-- No. Laundry : <input type="text" name="no_laundry" value="" /> -->
				
			</div>
			<div class="col-lg-9" style="text-align:right">
				<p><?php echo date("Y-m-d"); ?></p>
				<div style="text-align: right;" id="divjam"></div>
			</div>