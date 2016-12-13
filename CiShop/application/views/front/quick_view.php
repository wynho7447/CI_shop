<?php
    foreach($product_data as $row)
    {
?>
    <!--=== Shop Product ===-->
    <div class="shop-product col-md-12">
        
        <div class="col-md-5">
            <div class="ms-showcase2-template">
                <div id="slider" class="flexslider" style="overflow:hidden;">
                <?php
                    $thumbs = $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all');
                    $mains = $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','all');
                ?>
                  <ul class="slides" >
                    <?php 
                        foreach ($mains as $row1) {
                    ?>
                        <li class="zoom">
                          <img src="<?php echo $row1; ?>" class="img-responsive zoom" />
                        </li>
                    <?php 
                        }
                     ?>
                    <!-- items mirrored twice, total of 12 -->
                  </ul>
                </div>
                
                <?php
                    if(count($mains) > 1){
                ?>
                <div id="carousel" class="flexslider" style="overflow:hidden;">
                  <ul class="slides" >
                    <?php
                        $i = 0;
                        foreach ($thumbs as $row1) {
                    ?>
                        <li style="border:4px solid #fff;">
                         <a class="fancybox-button zoomer" data-rel="fancybox-button" title="<?php echo $row['title'].' ('.($i+1).')'; ?>" href="<?php echo $mains[$i]; ?>" ></a>
                          <img src="<?php echo $row1; ?>" />                          
                        </li>
                    <?php
                        $i++;
                        }
                     ?>
                     
                  </ul>
                </div>
                <script>
                    $( "#zom" ).click(function() {
                        $('.flex-active-slide').find('a').click();
                    });
                </script>
                <?php
                    } else if(count($mains) == 1) {
                ?>
                    <a class="fancybox-button zoomer fancyier" data-rel="fancybox-button" title="<?php echo $row['title']; ?>" href="<?php echo $mains[0]; ?>" ></a>
                    <script>
                        $( "#zom" ).click(function() {
                            $('.fancyier').click();
                        });
                    </script>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="col-md-7" style="border-right:1px solid #D4D4D4;">
            <div class="shop-product-heading">
                <h2><?php echo $row['title']; ?></h2>
                <div class="col-md-6 shadow-wrapper">       
                </div>
            </div><!--/end shop product social-->

            <div class="stars-ratings inp_rev list-inline" style="display:none;" data-pid='<?php echo $row['product_id']; ?>'>
                <input type="radio" class="rate_it" name="rating" data-rate="5" id="rate-5">
                <label for="rate-5"><i class="fa fa-star"></i></label>
                <input type="radio" class="rate_it" name="rating" data-rate="4" id="rate-4">
                <label for="rate-4"><i class="fa fa-star"></i></label>
                <input type="radio" class="rate_it" name="rating" data-rate="3" id="rate-3">
                <label for="rate-3"><i class="fa fa-star"></i></label>
                <input type="radio" class="rate_it" name="rating" data-rate="2" id="rate-2">
                <label for="rate-2"><i class="fa fa-star"></i></label>
                <input type="radio" class="rate_it" name="rating" data-rate="1" id="rate-1">
                <label for="rate-1"><i class="fa fa-star"></i></label>
            </div>
            
            <ul class="list-inline ratings_show product-ratings margin-bottom-10 tooltips"
                data-original-title="<?php echo $rating = $this->crud_model->rating($row['product_id']); ?>"	
                    data-toggle="tooltip" data-placement="left" >
                <?php
                    $r = $rating;
                    $i = 0;
                    while($i<5){
                        $i++;
                ?>
                <li>
                    <i class="rating<?php if($i<=$rating){ echo '-selected'; } $r--; ?> fa fa-star<?php if($r < 1 && $r > 0){ echo '-half';} ?>"></i>
                </li>
                <?php
                    }
                ?>
                <?php
                    if($this->session->userdata('user_login') == "yes"){
                ?>
                    <li class="product-review-list pull-right">
                        <span>
                            <a href="#" class='rev_show'><?php echo translate('give_a_rating');?></a>
                        </span>
                    </li>
                <?php
                    }
                ?>
            </ul><!--/end shop product ratings-->
            <script>
                $('body').on('click', '.rev_show', function(){
                    $('.ratings_show li').each(function() {
                        $(this).hide('fast');
                    });
                    $('.inp_rev').show('slow');
                });
            </script>
            
            <ul class="list-inline shop-product-prices">
            <?php if($this->crud_model->get_type_name_by_id('product',$row['product_id'],'discount') > 0){ ?>
                <li class="shop-violet"><?php echo currency().$this->crud_model->get_product_price($row['product_id']); ?></li>
                <li class="line-through"><?php echo currency().$row['sale_price']; ?></li>
            <?php } else { ?>
                <li class="shop-violet"><?php echo currency().$row['sale_price']; ?></li>
            <?php } ?>
            </ul><!--/end shop product prices-->
            <?php //echo $this->crud_model->is_added_to_cart($row['product_id'],'option'); ?>
            
            <?php
                echo form_open('', array(
                    'method' => 'post',
                    'class' => 'sky-form',
                ));
            ?>
            <?php
                $all_op = json_decode($row['options'],true);
                $all_c = json_decode($row['color']);
                    if($all_c){
            ?>
            <h3 class="shop-product-title"><?php echo translate('color');?></h3>
            <ul class="list-inline product-color margin-bottom-30">
                <?php
                    $n = 0;
                    foreach($all_c as $i => $p){
                        $c = '';
                        $n++;
                        if($a = $this->crud_model->is_added_to_cart($row['product_id'],'option','color')){
                            if($a == $p){
                                $c = 'checked';
                            }
                        } else {
                            if($n == 1){
                                $c = 'checked';
                            }
                        }
                ?>
                    <li>
                        <input type="radio" id="c-<?php echo $i; ?>" value="<?php echo $p; ?>" <?php echo $c; ?> name="color">
                        <label style="background:<?php echo $p; ?>;width:60px;height:60px;" for="c-<?php echo $i; ?>"></label>
                    </li>
                <?php
                        }
                    }
                ?>
            </ul>
            <?php
                if(!empty($all_op)){
                    foreach($all_op as $i=>$row1){
                        $type = $row1['type'];
                        $name = $row1['name'];
                        $title = $row1['title'];
                        $option = $row1['option'];
            ?>
            <h3 class="shop-product-title"><?php echo $title;?></h3>
            <div class="col-md-12 margin-bottom-10">
            <?php
                if($type == 'radio'){
            ?>
                <?php
                    foreach ($option as $op) {
                ?>
                <label class="toggle"><input type="radio" class="optional" name="<?php echo $name;?>" value="<?php echo $op;?>" <?php if($this->crud_model->is_added_to_cart($row['product_id'], 'option', $name) == $op){ echo 'checked'; } ?>  ><i></i><?php echo $op;?></label>
                <?php
                    }
                ?>
            <?php
                } else if($type == 'text'){
            ?>
                <label class="textarea textarea-resizable">
                    <textarea class="optional" rows="5" name="<?php echo $name;?>"><?php echo $this->crud_model->is_added_to_cart($row['product_id'], 'option', $name); ?></textarea>
                </label>
            <?php
                } else if($type == 'single_select'){
            ?>
                <label class="select">
                    <select name="<?php echo $name; ?>" class="optional">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php
                            foreach ($option as $op) {
                        ?>
                        <option value="<?php echo $op; ?>" <?php if($this->crud_model->is_added_to_cart($row['product_id'], 'option', $name) == $op){ echo 'selected'; } ?> ><?php echo $op; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <i></i>
                </label>
            <?php
                } else if($type == 'multi_select') {
            ?>
                <?php
                    foreach ($option as $op){
                ?>
                <label class="toggle"><input type="checkbox" class="optional" name="<?php echo $name;?>[]" value="<?php echo $op;?>" <?php if(!is_array($chk = $this->crud_model->is_added_to_cart($row['product_id'], 'option', $name))){ $chk = array(); } if(in_array($op, $chk)){ echo 'checked'; } ?>  ><i></i><?php echo $op;?></label>
                <?php
                    }
                ?>
            <?php
                }
            ?>
            </div>
            <?php
                    }
                }
            ?>

            <?php
                if(!$this->crud_model->is_digital($row['product_id'])){
            ?>
            <h3 class="shop-product-title"><?php echo translate('quantity');?></h3>
            <?php
                }
            ?>
            <div class="margin-bottom-40">

                <?php
                    if(!$this->crud_model->is_digital($row['product_id'])){
                ?>
                <span class="product-quantity sm-margin-bottom-20">
                    <button type='button' class="quantity-button" name='subtract' onclick='javascript: subtractQty();' value='-'>-</button>
                    <input type='text' class="quantity-field cart_quantity" name='qty' value="<?php if($a = $this->crud_model->is_added_to_cart($row['product_id'],'qty')){echo $a;} else {echo '1';} ?>" id='qty'/>
                    <button type='button' class="quantity-button" name='add' onclick='javascript: document.getElementById("qty").value++;' value='+'>+</button>
                </span>

                <?php
                    } else {
                ?>
                    <input type='hidden' class="quantity-field cart_quantity" name='qty' value="1" id='qty'/>
                <?php
                    }
                ?>
                <button type="button" class="btn-u btn-brd btn-brd-hover rounded btn-u-vio btn-u-xs add_to_cart btn_cart" data-type="text"  data-pid='<?php echo $row['product_id']; ?>'>
                    <i class="fa fa-shopping-cart"></i>
                    <?php if($this->crud_model->is_added_to_cart($row['product_id'])){ ?>
                        <?php echo translate('added_to_cart'); ?>
                    <?php } else { ?>
                        <?php echo translate('add_to_cart'); ?>
                    <?php } ?>
                </button>
                
                <?php 
                    $wish = $this->crud_model->is_wished($row['product_id']); 
                ?>
                <button type="button" data-pid='<?php echo $row['product_id']; ?>' 
                    class="btn-u btn-brd btn-brd-hover rounded btn-u-pink btn-u-xs <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>">
                    <i class="fa fa-heart"></i>
                    <?php if($wish == 'yes'){ ?>
                        <?php echo translate('added_to_wishlist');?>
                    <?php } else {?>
                        <?php echo translate('add_to_wishlist');?>
                    <?php } ?>
                </button>
                
            </div>
            <!--/end product quantity--> 
            </form>
        </div>
        <div id="pnopoi"></div>
    </div>
    <!--=== End Product Body ===-->

    <?php
        $discus_id = $this->db->get_where('general_settings',array('type'=>'discus_id'))->row()->value;
        $fb_id = $this->db->get_where('general_settings',array('type'=>'fb_comment_api'))->row()->value;
        $comment_type = $this->db->get_where('general_settings',array('type'=>'comment_type'))->row()->value;
    ?>

    <!--=== Content Medium ===-->
    <!--/end container-->    
    <!--=== End Content Medium ===-->

<?php
    }
?>

<script>
	
	$(document).ready(function() {
	<?php
		if(count($mains) > 1){
	?>
	  $('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 100,
		itemMargin: 5,
		asNavFor: '#slider'
	  });
	<?php
		}
	?>
	 
	  $('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#carousel"
	  });
	});
	
</script>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<script>
    $('body').on('click', '.quantity-button', function(){
        $('.add_to_cart').html('<i class="fa fa-shopping-cart"></i><?php echo translate('add_to_cart'); ?>');
    });
    $('body').on('change', '.optional', function(){
        $('.add_to_cart').html('<i class="fa fa-shopping-cart"></i><?php echo translate('add_to_cart'); ?>');
    });
</script>

<style>
    .heading_alt{
        font-size: 50px;
        font-weight: 100;
        color: #18BA9B;	
    }
</style>

