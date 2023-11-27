<?php 
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `transaction_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="update_status-form">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <div class="form-group mb-3">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0">
                <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Pending</option>
                <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>On-Progress</option>
                <option value="2" <?= isset($status) && $status == 2 ? "selected" : "" ?>>Done</option>
                <option value="3" <?= isset($status) && $status == 3 ? "selected" : "" ?>>Paid</option>
                <option value="4" <?= isset($status) && $status == 4 ? "selected" : "" ?>>Cancelled</option>
            </select>
        </div>
    </form>
</div>
<script>
	$(document).ready(function(){
		$('#update_status-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=update_status",
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
                            $("html, body, .modal").scrollTop(0);
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