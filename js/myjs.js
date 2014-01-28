$(document).ready(function(){
	
//mencari harga barang
	$('#id_barang').change(function(){
		var n_brg = $(this).val();
		
		$.ajax({ url: 'proses_ajax/cari_harga.php',
			 data: {id_barang: n_brg},
			 type: 'post',
			 success: function(output) {
				 
				 $('#harga').val(output);
				 
			}
		});
		
	});
	
//cari total harga	
	$('#jumlah').keyup(function(){
		
		var jml   = $(this).val();
		var h_brg = $('#harga').val();
		
		$.ajax({ url: 'proses_ajax/cari_total_harga.php',
			 data: {hrg_barang: h_brg, jumlah: jml},
			 type: 'post',
			 success: function(output) {
				 
				 $('#total').val(output);
				 
				 
			}
		});
		
	});
	
	
//generate tabel
    $('#tbl_pembayaran').dataTable({
		 "sPaginationType":"full_numbers"
	});

	$('#tbl_pembayaran_filter input').addClass('cari_nilai'); 
	
	
	$('.cari_nilai').keyup(function(){
		var nilai = $(this).val();
			
		$.ajax({ 
			dataType: "json",
			url: 'proses_ajax/cari_total_bayar.php',
			 data: {id_laundry: nilai},
			 type: 'post',
			 cache: false,
			 success: function(data) {
				 
				 $('#id_laundry').val(data.laundry);
				 $('#total_bayar').val(data.bayar);
				 $('#status').val(data.status);
				 $('#tamu').val(data.id_cek);
				 //alert(output[0]);
				 
			}
		});		
		
	});
	
	
	
});