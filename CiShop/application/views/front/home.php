<!--=== home banner ===-->
<div class="container margin-bottom-20 margin-top-20">
	<?php
		$place = 'after_slider';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row){
    ?>
        <a href="<?php echo $row['link']; ?>" >
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>" 
                            style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                        </div>    
                    </div>
                </div>    
            </div>
        </a>
    <?php
        }
    ?>
</div>
<!--=== home banner ===-->


    <!--=== Collection Banner ===-->
    <div class="collection-banner"> 
        <?php
            $i = 0;
            if($vendor_system == 'ok'){
                $vendors = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
                if($vendors){
        ?>
        <!--=== Sponsors  ===-->
        <div class="container content job-partners">
            <div class="heading margin-bottom-20">
                <h2><?php echo translate('our_vendors'); ?></h2>
            </div>
        
            <ul class="list-inline owl-sponsor our-clients" id="effect-2">
                <?php
                    $i = 0;
                    foreach($vendors as $row1)
                    {
                        $i++;
                ?>
                    <li class="item <?php if($i==1){ ?>first-child<?php } ?>">
                        <a href="<?php echo $this->crud_model->vendor_link($row1['vendor_id']); ?>">
                        <figure>
                            <?php
                                if(!file_exists('uploads/vendor/logo_'.$row1['vendor_id'].'.png')){
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/vendor/logo_0.png" alt="">  
                            <?php
                                } else {
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $row1['vendor_id']; ?>.png" alt="">  
                            <?php
                                }
                            ?>
                            <div class="img-hover">
                                <h4><?php echo $row1['display_name']; ?></h4>
                            </div>
                        </figure>
                        </a>
                    </li>
                <?php
                    }
                ?>
            </ul><!--/end owl-carousel-->
        </div>
        <?php
                }
            }
        ?>
    </div>
    <!--=== End Collection Banner ===-->

<!--=== Category wise products ===-->
<div class="container" style="margin-bottom: -40px;">
    <div class="heading heading-v1 margin-bottom-20">
        <h2><?php echo translate('featured_product');?></h2>
        <p></p>
    </div>
    
    <div class="illustration-v2 margin-bottom-60">
        <ul class="list-inline owl-slider-v2">
        <?php
            foreach($featured_data as $row1)
            {
                if($this->crud_model->is_publishable($row1['product_id'])){
        ?>
        	<li class="item custom_item">
                <div class="product-img">
                    <a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>">
                        <div class="shadow" 
                            style="background: url('<?php echo $this->crud_model->file_view('product',$row1['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; 
                                background-size: 100% auto;">
                        </div>
                    </a>
                    <a class="product-review various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row1['product_id'],'quick'); ?>"><?php echo translate('quick_view');?></a>
                    <a class="add-to-cart add_to_cart" data-type='text' data-pid='<?php echo $row1['product_id']; ?>' >
                        <i class="fa fa-shopping-cart"></i>
                        <?php if($this->crud_model->is_added_to_cart($row1['product_id'])){ ?>
                            <?php echo translate('added_to_cart');?>
                        <?php } else { ?>
                            <?php echo translate('add_to_cart');?>
                        <?php } ?>
                    </a>
					<?php
                        if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row1['product_id'])){
                    ?>
                    <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock');?></div>
                    <?php
                        } else {
                            if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'discount') > 0){ 
                    ?>
                        <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;">
                            <?php 
                                if($row1['discount_type'] == 'percent'){
                                    echo $row1['discount'].'%';
                                } else if($row1['discount_type'] == 'amount'){
                                    echo currency().$row1['discount'];
                                }
                            ?>
                            <?php echo ' '.translate('off'); ?>
                        </div>
                    <?php 
                            } 
                        }
                    ?>                    
                </div>
                <div class="product-description product-description-brd">
                    <div class="overflow-h margin-bottom-5">
                        <h4 class="title-price text-center"><a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>"><?php echo $row1['title'] ?></a></h4> 
                        <div class="col-md-12"> 
                            <div class="product-price">
								<?php if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'discount') > 0){ ?>
                                    <div class="col-md-6 title-price text-center"><?php echo currency().$this->crud_model->get_product_price($row1['product_id']); ?></div>
                                    <div class="col-md-6 title-price line-through text-center"><?php echo currency().$row1['sale_price']; ?></div>
                                <?php } else { ?>
                                    <div class="col-md-12 title-price text-center"><?php echo currency().$row1['sale_price']; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"> 
                        <ul class="list-inline product-ratings col-md-12 col-sm-12 col-xs-12 tooltips text-center"
                            data-original-title="<?php echo $rating = $this->crud_model->rating($row1['product_id']); ?>"	
                                data-toggle="tooltip" data-placement="top" >
                            <?php
                                $rating = $this->crud_model->rating($row1['product_id']);
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
                        </ul>
                    </div>
                    <div class="col-md-12 text-center margin-bottom-5 gender"> 
                        <?php echo translate('vendor').' : '.$this->crud_model->product_by($row1['product_id'],'with_link'); ?>
                    </div>
                    <hr>
                    
                    <div class="col-md-6" style="margin-top:-10px;">
                        <a class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row1['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>" type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row1['product_id']; ?>' >
                            <?php if($this->crud_model->is_compared($row1['product_id'])=='yes'){ ?>
                                <?php echo translate('compared');?>
                            <?php } else {?>
                                <?php echo translate('compare');?>
                            <?php } ?>
                         </a>
                    </div>
                    <?php 
                        $wish = $this->crud_model->is_wished($row1['product_id']); 
                    ?>
                    <div class="col-md-6" style="margin-top:-10px;">
                        <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important;" data-pid='<?php echo $row1['product_id']; ?>'>
                            <?php if($wish == 'yes'){ ?>
                                <?php echo translate('wished');?>
                            <?php } else {?>
                                <?php echo translate('wish');?>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            </li>              
        <?php
                }
            }
        ?>
        </ul>
    </div>
</div>

<!--=== home banner ===-->
<div class="container margin-bottom-30">
	<?php
		$place = 'after_featured';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row){
    ?>
        <a href="<?php echo $row['link']; ?>" >
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>" 
                            style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                            
                        </div>    
                    </div>
                </div>    
            </div>
        </a>
    <?php
        }
    ?>
</div>


<div class="parallax-team parallaxBg">
    <div class="container content">
        <div class="row">
            <?php
                echo form_open(base_url() . 'index.php/home/home_search/text', array(
                    'class' => 'sky-form',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                    'style' => 'border:none !important;'
                ));
            ?>
                <div class="col-md-3 col-sm-6" style="z-index:99">
                    
		
                    <label class="category_drop">
                        <select name='category' id='category' class="drops cd-select">
                            <option value="0"   class=""><?php echo translate('choose_category');?></option>
                            <?php
                            	$categories = $this->db->get('category')->result_array();
								foreach($categories as $row){
							?>
                            	<option value="<?php echo $row['category_id']; ?>"  class=""><?php echo ucfirst($row['category_name']); ?></option>
                            <?php
								}
							?>
                        </select>
                        <i></i>
                    </label>
                </div>
                
                <div class="col-md-3 col-sm-6" style="z-index:99">
                    <label class="sub_category_drop">
                        <select name='sub_category' onchange='get_pricerange(this.value)' class="dropss cd-select"  id='sub_category'>
                            <option value="0"><?php echo translate('choose_sub_category');?></option>
                        </select>
                        <i></i>
                    </label>
                </div>
                
                <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/range/jquery.nstSlider.css">
                 <!-- 4. Add nstSlider.js after jQuery -->
				<script src="<?php echo base_url(); ?>template/front/assets/plugins/range/jquery.nstSlider.min.js"></script>
        
                
                
                <div class="col-md-4 col-sm-6" id="range" style="margin-top: 18px;">
                    <div class="col-md-12 col-sm-12">
                        <div class="leftLabel pull-left"></div>
                        <div class="rightLabel pull-right"></div>
                    </div>
                    <?php 
						$min = round($this->crud_model->get_range_lvl("product_id !=", "", "min"));
						$max = round($this->crud_model->get_range_lvl("product_id !=", "", "max"));
					?>
                    <div class="col-md-12 col-sm-12" id="ranog">
                        <div class="nstSlider" 
                        		data-range_min="<?php echo $min; ?>" data-range_max="<?php echo $max; ?>"   
                            	data-cur_min="<?php echo $min; ?>"  data-cur_max="<?php echo $max; ?>">
                            <div class="highlightPanel"></div> 
                            <div class="bar"></div>                  
                            <div class="leftGrip"></div> 
                            <div class="rightGrip"></div> 
                        </div>
                    </div>
                </div>
                <input type="hidden" id="take_range" value="" name="range" />
                <script>
					function take_range(xmin,xmax){
						$('.nstSlider').nstSlider({
							"crossable_handles": false,
							"left_grip_selector": ".leftGrip",
							"right_grip_selector": ".rightGrip",
							"value_bar_selector": ".bar",
							"highlight": {
								"grip_class": "gripHighlighted",
								"panel_selector": ".highlightPanel"
							},
							"value_changed_callback": function(cause, leftValue, rightValue) {
								$('.leftLabel').text('<?php echo currency(); ?>'+leftValue);
								$('.rightLabel').text('<?php echo currency(); ?>'+rightValue);
								$('#take_range').val(leftValue+';'+rightValue);
							},
						});
						//$('.nstSlider').nstSlider("set_range", xmin, xmax);
						//$('.nstSlider').nstSlider("set_position", xmin, xmax);
					}
					$( document ).ready(function() {
						take_range(0,100000000);
					});
                </script>
                <div class="col-md-2 col-sm-6">
                    <button type="submit" class="btn-u btn-u-cust btn-block btn-labeled fa fa-search" value="" style="margin-top:34px;"><?php echo translate('search_product');?></button>
                </div>
            </form>
            
        </div>
    </div>
</div>    



<div class="container margin-top-20">
	<?php
		$place = 'after_search';
        $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
        $banners = $query->result_array();
        if($query->num_rows() > 0){
            $r = 12/$query->num_rows();
        }
        foreach($banners as $row){
    ?>
        <a href="<?php echo $row['link']; ?>" >
            <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                <div class="overflow-h margin-top-5">
                    <div class="illustration-v1 illustration-img1">
                        <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>" 
                            style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                            
                        </div>    
                    </div>
                </div>    
            </div>
        </a>
    <?php
        }
    ?>
</div>  

<div class="container content">
    <div class="row">
    	<div class="col-md-12">
            <!-- Owl Carousel v2 -->
            <?php
				$n = 0;
                $category = json_decode($this->crud_model->get_type_name_by_id('ui_settings','10','value'));
                foreach($category as $row)
                {
                    $this->db->limit(9);
                    $this->db->order_by('product_id','desc');
                    $product = $this->db->get_where('product',array('category'=>$row,'status'=>'ok'))->result_array();
                    $sub_cats = $this->db->get_where('sub_category',array('category'=>$row))->result_array();
					
					if($n>4){
						$n = 0;
					}
					$n++;
					
            ?>
                <!-- Tab v1 -->               
                <div class="tab-v2 margin-bottom-30" style="background:#fff;box-shadow: 0px 0px 6px 1px #ddd;">
                    <ul class="nav nav-tabs full theme_<?php echo $n; ?>" style="background:#F9F9F9;">
                        <li>
                        	<div onClick="return false;" data-toggle="tab">
                            	<?php echo $this->crud_model->get_type_name_by_id('category',$row,'category_name'); ?>
                        	</div>
                        </li>
                        <?php
							$l = 0;
							foreach($sub_cats as $row3){
							$num_product = $this->db->get_where('product',array('sub_category'=>$row3['sub_category_id'],'status'=>'ok'))->num_rows();
								if($num_product > 0){
									$l++;
						?>
                        	<li <?php if($l == 1){ ?>class="active"<?php } ?> >
                            	<a href="#sub_<?php echo $row3['sub_category_id'] ?>" data-toggle="tab">
									<?php echo $row3['sub_category_name'] ?>
                                </a>
                            </li>
                        <?php
								}
							}
						?>
                        <li class="pull-right">
                            <div class="owl-btn next tab_hov" style="padding:5px 13px !important;">
                                <i class="fa fa-angle-right"></i>
                            </div>
                        </li>
                        <li class="pull-right">
                            <div class="owl-btn prev tab_hov" style="padding:5px 13px !important;">
                                <i class="fa fa-angle-left"></i>
                            </div>
                        </li>
                    </ul>            
                    <div class="tab-content">
                        <?php
							$a = 0;
							foreach($sub_cats as $row3){
							$num_product = $this->db->get_where('product',array('sub_category'=>$row3['sub_category_id'],'status'=>'ok'))->num_rows();
								if($num_product > 0){
								$a++;
						?>
                        <div class="tab-pane fade in <?php if($a == 1){echo 'active';} ?>" id="sub_<?php echo $row3['sub_category_id'] ?>">
                            <div class="row">
                                <div class="illustration-v2 margin-bottom-60">
                                    <ul class="list-inline owl-slider-v2">
                                        <?php
                                            $this->db->order_by('product_id','desc');
                                            $sub_product = $this->db->get_where('product',array('sub_category'=>$row3['sub_category_id'],'status'=>'ok'))->result_array();
                                            $i = 0;
                                            foreach($sub_product as $row1)
                                            {
                                                if($this->crud_model->is_publishable($row1['product_id'])){
                                                    $i++;
                                                    if($i <= 9){
                                        ?>
                                        <li class="item custom_item">
                                            <div class="product-img">
                                                <a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>">
                                                    <div class="shadow" 
                                                        style="background: url('<?php echo $this->crud_model->file_view('product',$row1['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; 
                                                            background-size: 100% auto;">
                                                    </div>
                                                </a>
                                                <a class=" product-review various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row1['product_id'],'quick'); ?>"><?php echo translate('quick_view');?></a>
                                                <a class="add-to-cart add_to_cart" data-type='text' data-pid='<?php echo $row1['product_id']; ?>' >
                                                    <i class="fa fa-shopping-cart"></i>
                                                    <?php if($this->crud_model->is_added_to_cart($row1['product_id'])){ ?>
                                                        <?php echo translate('added_to_cart');?>
                                                    <?php } else { ?>
                                                        <?php echo translate('add_to_cart');?>
                                                    <?php } ?>
                                                </a>
                                                <?php
                                                    if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'current_stock') <= 0 && !$this->crud_model->is_digital($row1['product_id'])){
                                                ?>
                                                <div class="shop-rgba-red rgba-banner" style="border-top-right-radius: 4px !important;"><?php echo translate('out_of_stock');?></div>
                                                <?php
                                                    } else {
                                                        if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'discount') > 0){ 
                                                ?>
                                                    <div class="shop-bg-green rgba-banner" style="border-top-right-radius:4px !important;">
                                                        <?php 
															$this->benchmark->mark_time();
                                                            if($row1['discount_type'] == 'percent'){
                                                                echo $row1['discount'].'%';
                                                            } else if($row1['discount_type'] == 'amount'){
                                                                echo currency().$row1['discount'];
                                                            }
                                                        ?>
                                                        <?php echo ' '.translate('off'); ?>
                                                    </div>
                                                <?php 
                                                        } 
                                                    }
                                                ?>                    
                                            </div>
                                            <div class="product-description product-description-brd">
                                                <div class="overflow-h margin-bottom-5">
                                                    <h4 class="title-price text-center"><a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>"><?php echo $row1['title'] ?></a></h4> 
                                                    <div class="col-md-12"> 
                                                        <div class="product-price">
                                                            <?php if($this->crud_model->get_type_name_by_id('product',$row1['product_id'],'discount') > 0){ ?>
                                                                <div class="col-md-6 title-price text-center"><?php echo currency().$this->crud_model->get_product_price($row1['product_id']); ?></div>
                                                                <div class="col-md-6 title-price line-through text-center"><?php echo currency().$row1['sale_price']; ?></div>
                                                            <?php } else { ?>
                                                                <div class="col-md-12 title-price text-center"><?php echo currency().$row1['sale_price']; ?></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12"> 
                                                    <ul class="list-inline product-ratings col-md-12 col-sm-12 col-xs-12 tooltips text-center"
                                                        data-original-title="<?php echo $rating = $this->crud_model->rating($row1['product_id']); ?>"	
                                                            data-toggle="tooltip" data-placement="top" >
                                                        <?php
                                                            $rating = $this->crud_model->rating($row1['product_id']);
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
                                                    </ul>
                                                </div>
                                                <div class="col-md-12 text-center margin-bottom-5 gender"> 
                                                    <?php echo translate('vendor').' : '.$this->crud_model->product_by($row1['product_id'],'with_link'); ?>
                                                </div>
                                                <hr>
                                                
                                                <div class="col-md-6" style="margin-top:-10px;">
                                                    <a class="btn-u btn-u-cust float-shadow <?php if($this->crud_model->is_compared($row1['product_id'])=='yes'){ ?>disabled<?php } else { ?>btn_compare<?php } ?>" type="button" style="padding:2px 13px !important;" data-pid='<?php echo $row1['product_id']; ?>' >
                                                        <?php if($this->crud_model->is_compared($row1['product_id'])=='yes'){ ?>
                                                            <?php echo translate('compared');?>
                                                        <?php } else {?>
                                                            <?php echo translate('compare');?>
                                                        <?php } ?>
                                                     </a>
                                                </div>
                                                <?php 
                                                    $wish = $this->crud_model->is_wished($row1['product_id']); 
                                                ?>
                                                <div class="col-md-6" style="margin-top:-10px;">
                                                    <a rel="outline-outward" class="btn-u btn-u-cust float-shadow pull-right <?php if($wish == 'yes'){ ?>btn_wished<?php } else {?>btn_wish<?php } ?>" style="padding:2px 13px !important;" data-pid='<?php echo $row1['product_id']; ?>'>
                                                        <?php if($wish == 'yes'){ ?>
                                                            <?php echo translate('wished');?>
                                                        <?php } else {?>
                                                            <?php echo translate('wish');?>
                                                        <?php } ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                                    }
                                                }
                                            }
                                        ?>    
                                    </ul>
                                 </div>
                            </div>
                        </div>
                        <?php
								}
							}
						?>
                        
                        
                    </div>
                </div>
                <!-- End Tab v1 -->  
             <?php
                }
            ?>    
        </div>
	</div>
</div>


<div class="parallaxBg twitter-block margin-bottom-20" style="background:url(<?php echo base_url();?>template/front/assets/img/twitter-bg.jpg)">
    <div class="container">
        <div class="heading heading-v1 margin-bottom-20">
            <h2><?php echo translate('latest_blogs'); ?></h2>
        </div>

        <div id="carousel-example-generic-v5" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
            	<?php
					$i = 0;
					$this->db->limit(5);
					$this->db->order_by('blog_id','desc');
					$blogs = $this->db->get('blog')->result_array();
                	foreach($blogs as $row){
				?>
                <li class="<?php if($i == 0){ ?>active<?php } ?> rounded-x" data-target="#carousel-example-generic-v5" data-slide-to="<?php echo $i; ?>"></li>
            	<?php
						$i++;
					}
				?>
            </ol>

            <div class="carousel-inner" style="height:150px !important;">
            	<?php
					$i = 0;
                	foreach($blogs as $row){
				?>
                <div class="item <?php if($i == 0){ ?>active<?php } ?>">
                    <h2>
                    	<a href="<?php echo $this->crud_model->blog_link($row['blog_id']); ?>" style="color:white !important;">
                        	<?php echo $row['title']; ?>
                        </a>
                    <h2>
                    <p>
                    	<a href="<?php echo $this->crud_model->blog_link($row['blog_id']); ?>" style="color:white !important;">
                        	<?php echo $row['summery']; ?>
                        </a>
                    </p>
                </div>
                <?php
						$i++;
					}
				?>
            </div>
            
            <div class="carousel-arrow">
                <a class="left carousel-control" href="#carousel-example-generic-v5" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic-v5" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>                        
    </div>    
</div>


<div class="container content">
    <div class="row">       
        <!--=== home banner ===-->
        <div class="col-md-12">
            <div class="container">
                <?php
                    $place = 'after_category';
                    $query = $this->db->get_where('banner',array('page'=>'home', 'place'=>$place, 'status' => 'ok'));
                    $banners = $query->result_array();
                    if($query->num_rows() > 0){
                        $r = 12/$query->num_rows();
                    }
                    foreach($banners as $row){
                ?>
                    <a href="<?php echo $row['link']; ?>" >
                        <div class="col-md-<?php echo $r; ?> md-margin-bottom-30">
                            <div class="overflow-h">
                                <div class="illustration-v1 illustration-img1">
                                    <div class="illustration-bg banner_<?php echo $query->num_rows(); ?>" 
                                        style="background:url('<?php echo $this->crud_model->file_view('banner',$row['banner_id'],'','','no','src') ?>') no-repeat center center; background-size: 100% auto;" >
                                        
                                    </div>    
                                </div>
                            </div>    
                        </div>
                    </a>
                <?php
                    }
                ?>
            </div>
        </div>
        
        
        <!--=== Illustration v4 ===-->
        <div class="row illustration-v4 margin-bottom-20">
            <div class="col-md-4">
                <div class="heading margin-bottom-10 margin-top-20">
                    <h2><?php echo  translate('latest_products'); ?></h2>
                </div>
				<?php
					$this->db->order_by('product_id','desc');
					$this->db->where('status','ok');
					$latest = $this->db->get('product')->result_array();
                    $i = 0;
					foreach ($latest as $row2){
                        if($this->crud_model->is_publishable($row2['product_id'])){
                            $i++;
                            if($i <= 3){

                ?>
                <div class="thumb-product">
                    <div class="thumb-product-img" style="background:url('<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;"></div>
                    <div class="thumb-product-in">
                        <h4><a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title'] ?></a></h4>
                        <span class="thumb-product-type"><?php echo $this->crud_model->get_type_name_by_id('category',$row2['category'],'category_name'); ?></span>
                    </div>
                    <ul class="list-inline overflow-h">
					<?php if($this->crud_model->get_type_name_by_id('product',$row2['product_id'],'discount') > 0){ ?>
                        <li class="thumb-product-price">
							<?php echo currency().$this->crud_model->get_product_price($row2['product_id']); ?>
                        </li>
                        <li class="thumb-product-price line-through">
							<?php echo currency().$row2['sale_price']; ?>
                        </li>
                    <?php } else { ?>
                        <li class="thumb-product-price">
							<?php echo currency().$row2['sale_price']; ?>
                        </li>
                    <?php } ?>
                        <li class="thumb-product-purchase">
                            <span data-original-title="<?php echo translate('add_to_cart'); ?>" data-toggle="tooltip" data-placement="left"  class="tooltips add-to-cart add_to_cart" data-type='icon' data-pid='<?php echo $row2['product_id']; ?>' >
                                <?php if($this->crud_model->is_added_to_cart($row2['product_id'])){ ?>
                                	<i style="color:#18ba9b" class="fa fa-shopping-cart"></i>
                                <?php } else { ?>
                                    <i class="fa fa-shopping-cart"></i>
                                <?php } ?>
                            </span> 
                            |
                            <?php if($this->crud_model->is_wished($row2['product_id'])=='yes'){ ?>
                                <span data-original-title="<?php echo translate('added_to_wishlist');?>" data-toggle="tooltip" data-placement="left" class="tooltips wished_it">
                                	<i class="fa fa-heart"></i>
                                </span>
                            <?php } else { ?>
                                <span data-original-title="<?php echo translate('add_to_wishlist');?>" data-toggle="tooltip" data-placement="left" data-pid='<?php echo $row2['product_id']; ?>' class="tooltips wish_it">
                                	<i class="fa fa-heart"></i>
                                </span>
                            <?php } ?>
                        </li>
                    </ul>    
                </div>
                <?php
                            }
                        }
					}
				?>
            </div>
            
            <div class="col-md-4">
                <div class="heading margin-bottom-10 margin-top-20">
                    <h2><?php $this->benchmark->mark_time(); echo  translate('most_sold'); ?></h2>
                </div>
				<?php
					$i = 0;
					$most_popular = $this->crud_model->most_sold_products();
                    foreach ($most_popular as $row2){
                        if($this->crud_model->is_publishable($row2['id'])){
						$i++;
						if($i <= 3){
							$now = $this->db->get_where('product',array('product_id'=>$row2['id']))->row();
                ?>
                <div class="thumb-product">
                    <div class="thumb-product-img" style="background:url('<?php echo $this->crud_model->file_view('product',$now->product_id,'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;"></div>
                    <div class="thumb-product-in">
                        <h4><a href="<?php echo $this->crud_model->product_link($now->product_id); ?>"><?php echo $now->title; ?></a></h4>
                        <span class="thumb-product-type"><?php echo $this->crud_model->get_type_name_by_id('category',$now->category,'category_name'); ?></span>
                    </div>
                    <ul class="list-inline overflow-h">
					<?php if($this->crud_model->get_type_name_by_id('product',$now->product_id,'discount') > 0){ ?>
                        <li class="thumb-product-price">
							<?php echo currency().$this->crud_model->get_product_price($now->product_id); ?>
                        </li>
                        <li class="thumb-product-price line-through">
							<?php echo currency().$now->sale_price; ?>
                        </li>
                    <?php } else { ?>
                        <li class="thumb-product-price">
							<?php echo currency().$now->sale_price; ?>
                        </li>
                    <?php } ?>
                        <li class="thumb-product-purchase">
                            <span data-original-title="Add to Cart" data-toggle="tooltip" data-placement="left"  class="tooltips add-to-cart add_to_cart" data-type='icon' data-pid='<?php echo $now->product_id; ?>' >
                                <?php if($this->crud_model->is_added_to_cart($now->product_id)){ ?>
                                	<i style="color:#18ba9b" class="fa fa-shopping-cart"></i>
                                <?php } else { ?>
                                    <i class="fa fa-shopping-cart"></i>
                                <?php } ?>
                            </span> 
                            |
                            <?php if($this->crud_model->is_wished($now->product_id)=='yes'){ ?>
                                <span data-original-title="<?php echo translate('added_to_wishlist');?>" data-toggle="tooltip" data-placement="left" class="tooltips wished_it">
                                	<i class="fa fa-heart"></i>
                                </span>
                            <?php } else { ?>
                                <span data-original-title="<?php echo translate('add_to_wishlist');?>" data-toggle="tooltip" data-placement="left" data-pid='<?php echo $now->product_id; ?>' class="tooltips wish_it">
                                	<i class="fa fa-heart"></i>
                                </span>
                            <?php } ?>
                        </li>
                    </ul>    
                </div>
                <?php
                            }
						}
					}
				?>
                
            </div>
            
            <div class="col-md-4">
                <div class="heading margin-bottom-10 margin-top-20">
                    <h2><?php echo  translate('most_viewed_products'); ?></h2>
                </div>
				<?php
                    $this->db->order_by('number_of_view','desc');
					$this->db->where('status','ok');
					$most_viewed = $this->db->get('product')->result_array();
                    $i = 0;
					foreach ($most_viewed as $row2){
                        if($this->crud_model->is_publishable($row2['product_id'])){
                            $i++;
                            if($i<=3){
                ?>
                <div class="thumb-product">
                    <div class="thumb-product-img" style="background:url('<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>') no-repeat center center; background-size: 100% auto;"></div>
                    <div class="thumb-product-in">
                        <h4><a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title'] ?></a></h4>
                        <span class="thumb-product-type"><?php echo $this->crud_model->get_type_name_by_id('category',$row2['category'],'category_name'); ?></span>
                    </div>
                    <ul class="list-inline overflow-h">
					<?php if($this->crud_model->get_type_name_by_id('product',$row2['product_id'],'discount') > 0){ ?>
                        <li class="thumb-product-price">
							<?php echo currency().$this->crud_model->get_product_price($row2['product_id']); ?>
                        </li>
                        <li class="thumb-product-price line-through">
							<?php echo currency().$row2['sale_price']; ?>
                        </li>
                    <?php } else { ?>
                        <li class="thumb-product-price">
							<?php echo currency().$row2['sale_price']; ?>
                        </li>
                    <?php } ?>
                        <li class="thumb-product-purchase">
                            <span data-original-title="<?php echo translate('add_to_cart'); ?>" data-toggle="tooltip" data-placement="left"  class="tooltips add-to-cart add_to_cart" data-type='icon' data-pid='<?php echo $row2['product_id']; ?>' >
                                <?php if($this->crud_model->is_added_to_cart($row2['product_id'])){ ?>
                                	<i style="color:#AB00FF" class="fa fa-shopping-cart"></i>
                                <?php } else { ?>
                                    <i class="fa fa-shopping-cart"></i>
                                <?php } ?>
                            </span>
                            |
                            <?php if($this->crud_model->is_wished($row2['product_id'])=='yes'){ ?>
                                <span data-original-title="<?php echo translate('added_to_wishlist');?>" data-toggle="tooltip" data-placement="left" class="tooltips wished_it">
                                	<i class="fa fa-heart"></i>
                                </span>
                            <?php } else { ?>
                                <span data-original-title="<?php echo translate('add_to_wishlist');?>" data-toggle="tooltip" data-placement="left" data-pid='<?php echo $row2['product_id']; ?>' class="tooltips wish_it">
                                	<i class="fa fa-heart"></i>
                                </span>
                            <?php } ?>
                        </li>
                    </ul>    
                </div>
                <?php
                            }
                        }
					}
				?>
            </div>
        </div><!--/end row-->

        
		<?php
            $i = 0;
			$this->benchmark->mark_time();
            $brands = json_decode($this->crud_model->get_type_name_by_id('ui_settings','13','value'));
            if($brands){
		?>
        <!--=== Sponsors ===-->
        <div class="container content">
            <div class="heading margin-bottom-20">
                <h2><?php echo translate('our_available_brands'); ?></h2>
            </div>
    
            <ul class="list-inline owl-sponsor">
            	<?php
					foreach($brands as $row1)
					{
						$brand = $this->db->get_where('brand',array('brand_id'=>$row1))->result_array();
						foreach($brand as $row)
						{
						$i++;
				?>
                        <li class="item <?php if($i==1){ ?>first-child<?php } ?>">
                            <img src="<?php echo $this->crud_model->file_view('brand',$row['brand_id'],'','','no','src','','','.png') ?>" alt="">
                        </li>
                <?php
							}
						}
					}
				?>
            </ul><!--/end owl-carousel-->
        </div>
        
	</div>
</div>

             
<script>
	$(document).ready(function() {
		$('.drops').dropdown();
		$('.dropss').dropdown();
	});

	$('body').on('click','.category_drop .cd-dropdown li', function(){
		var category = $(this).data('value');
		var list1 = $('.sub_category_drop');
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/home/others/get_sub_by_cat/'+category,
			beforeSend: function() {
				list1.html('');
			},
			success: function(data) {
				var res = ""
					+" <select name='sub_category' onchange='get_pricerange(this.value)' class='dropss cd-select'  id='sub_category'>"
					+" 	<option value='0'><?php echo translate('choose_sub_category');?></option>"
					+ data
					+" </select>"
				list1.html(res);
				$('body .dropss').dropdown();
			},
			error: function(e) {
				console.log(e)
			}
		});
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/home/others/get_home_range_by_cat/'+category,
			beforeSend: function() {
			},
			success: function(data) {
				var myarr = data.split("-");
				var res = 	''
							+'<div class="nstSlider" '
							+'	data-range_min="'+myarr[0]+'" data-range_max="'+myarr[1]+'" '  
							+'	data-cur_min="'+myarr[0]+'"  data-cur_max="'+myarr[1]+'">'
							+'<div class="highlightPanel"></div> '
							+'<div class="bar"></div>   '               
							+'<div class="leftGrip"></div> '
							+'<div class="rightGrip"></div>' 
							+'</div>';
				$('.nstSlider').remove();
				$('#ranog').html(res);
				take_range(myarr[0],myarr[1]);
			},
			error: function(e) {
				console.log(e)
			}
		});
	});
	$('body').on('click','.sub_category_drop .cd-dropdown li', function(){
		var sub_category = $(this).data('value');
		var list2 = $('#range');
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/home/others/get_home_range_by_sub/'+sub_category,
			beforeSend: function() {
			},
			success: function(data) {
				var myarr = data.split("-");
				var res = 	''
							+'<div class="nstSlider" '
							+'	data-range_min="'+myarr[0]+'" data-range_max="'+myarr[1]+'" '  
							+'	data-cur_min="'+myarr[0]+'"  data-cur_max="'+myarr[1]+'">'
							+'<div class="highlightPanel"></div> '
							+'<div class="bar"></div>   '               
							+'<div class="leftGrip"></div> '
							+'<div class="rightGrip"></div>' 
							+'</div>';
				$('.nstSlider').remove();
				$('#ranog').html(res);
				take_range(myarr[0],myarr[1]);
			},
			error: function(e) {
				console.log(e)
			}
		});
	});
	function filter(){}
</script>
