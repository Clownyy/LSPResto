<section class="content-header">
	<h1>Transaksi
		<small>Transaction</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href=""></a></li>
		<li>Transaction</li>
		<li class="active">Sales</li>
	</ol>
</section>
<section class="content">
	<?php $this->load->view('messages'); ?>
	<div class="row">
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Pesanan</h3>
				</div>
				<div class="box-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Barcode</th>
								<th>Tanggal</th>
								<th>Pemesan</th>
								<th>Keterangan</th>
								<th>Status Order</th>
							</tr>
						</thead>
						<tbody>
							<tr></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Pilih Pesanan Pelanggan</h3>
				</div>
				<div class="box-body table-responsive">
					<form action="<?=base_url('transaction/cartStore')?>" method="post">
						<div class="form-group">
							<label>Nama User</label>
							<input type="hidden" name="user_id" value="<?=$this->session->userdata('userid')?>">
							<select class="form-control" id="product" name="item_id">
								<option value="">--</option>
							</select>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								<table>
									<tr>
										<td style="font-size: 20pt" width="200">Nomor Meja</td>
										<td style="font-size: 20pt"><b>: </b></td>
										<td style="font-size: 20pt"><b id="stok"></b></td>
									</tr>
									<tr>
										<td style="font-size: 20pt" width="200">Harga</td>
										<td style="font-size: 20pt"><b>: Rp.</b></td>
										<td style="font-size: 20pt"><b id="price" name="harga"></b></td>
									</tr>
									<tr>
										<td colspan="3" style="font-size: 15pt"><i>Sudah termasuk PPN</i></td>
									</tr>
								</table>
							</div>
							<div class="panel-footer text-right">
								<button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Checkout</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script>
	$('#product').change(function(){
		var selected =  $(this).val()
		$.ajax({
			url : "<?=base_url('stock/getdataitem/"+selected+"')?>",
			type: "GET",
			success: function(data){
				var apa = JSON.parse(data)
				$('#stok').html(apa.stock)
				$('#price').html(apa.price)
			}
		})
	})
</script>