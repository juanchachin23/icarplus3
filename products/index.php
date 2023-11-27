<style>
    #productAccordion button.btn.btn-block.text-left.font-weight-bolder:focus {
        box-shadow: none !important;
    }
    #search-field .form-control.rounded-pill{
        border-top-right-radius:0 !important;
        border-bottom-right-radius:0 !important;
        border-right:none !important
    }
    #search-field .form-control:focus{
        box-shadow:none !important;
    }
    #search-field .form-control:focus + .input-group-append .input-group-text{
        border-color: #86b7fe !important
    }
    #search-field .input-group-text.rounded-pill{
        border-top-left-radius:0 !important;
        border-bottom-left-radius:0 !important;
        border-right:left !important
    }
    #product-list .card-image-top-holder>img{
        width: 100%;
        height: 25vh;
        object-fit: cover;
        object-position: center center;
        transition:all .3s ease-in-out;
    }
    #product-list .card:hover .card-image-top-holder>img{
        transform: scale(1.2);
    }
</style>
<div class="section py-5">
    <div class="container">
        <h3 class="text-center"><b>Our Products</b></h3>
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-sm-12 mb-3">
                <div class="input-group input-group-lg" id="search-field">
                    <input type="search" class="form-control form-control-lg  rounded-pill" aria-label="Search product Field" id="search" placeholder="Search product here">
                    <div class="input-group-append">
                        <span class="input-group-text rounded-pill bg-transparent"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gx-2" id="product-list">
            <?php 
            $products = $conn->query("SELECT * FROM `product_list` where delete_flag = 0 and `status` = 1 order by `name` asc");
            while($row = $products->fetch_assoc()):
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 px-2">
                <div class="card rounded-0 ">
                    <div class="card-image-top-holder overflow-hidden">
                        <img src="<?= validate_image($row['image_path']) ?>" class="card-image-top" alt="">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['name'] ?></h5>
                        <p class="card-text truncate-3"><?= str_replace(["\n\r","\n","\r"], "<br/>", $row['description']) ?></p>
                        <div class="card-text"><span class="fa fa-tag me-2"></span> <?= format_num($row['price']) ?></div>
                        <center>
                            <button class="btn btn-primary px-5 rounded-pill btn-sm read-more" data-id="<?= $row['id'] ?>" type="button">Read More</button>
                        </center>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.read-more').click(function(){
			uni_modal("<i class='fa fa-bars'></i> Product Details","products/view_product.php?id="+$(this).attr('data-id'))
		})
        $('#search').on('input', function(){
            var _search = $(this).val().toLowerCase()
            $('#product-list .card').each(function(){
                var _text = $(this).text().toLowerCase()
                _text = _text.trim()
                if(_text.includes(_search) === false){
                    $(this).parent().toggle(false)
                }else{
                    $(this).parent().toggle(true)
                }
            })
        })
    })
</script>