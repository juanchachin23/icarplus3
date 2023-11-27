<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `inventory_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="inventory-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name ="product_id" value="<?php echo isset($product_id) ? $product_id : (isset($_GET['product_id']) ? $_GET['product_id'] : '') ?>">
		<div class="form-group">
			<label for="quantity" class="control-label">Quantity</label>
			<input type="number" name="quantity" id="quantity" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($quantity) ? $quantity : 0; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="stock_date" class="control-label">Stock-In Date</label>
			<input type="date" name="stock_date" id="stock_date" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($stock_date) ? date("Y-m-d", strtotime($stock_date)) : ""; ?>" max="<?= date("Y-m-d") ?>"  required/>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#inventory-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_inventory",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body,.modal").scrollTop(0);
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
					}
				}
			})
		})

	})
</script>