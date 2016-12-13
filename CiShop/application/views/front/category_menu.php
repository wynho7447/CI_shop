<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/front/assets/plugins/menu/amazonmenu.css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>template/front/assets/plugins/menu/amazonmenu.js"></script>

<div class="container">
	<div class="col-md-10">
		<div class="row">
            <div class="col-lg-12" style="margin-top:10px;">
                <?php
                    echo form_open(base_url() . 'index.php/home/text_search', array(
                        'method' => 'post',
                        'role' => 'search'
                    ));
                ?>    
                    <div class="input-group input-group-lg">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-input_type dropdown-toggle custom ppy" data-toggle="dropdown"><?php echo translate('vendor');?> <span class="caret"></span></button>
                            <div class="dropdown-menu pull-right" style="min-width:102px;">
                                <div class="btn custom srt" data-val="vendor" style="display:block;" ><a href="#"><?php echo translate('vendor'); ?></a></div>
                                <div class="btn custom srt" data-val="product" style="display:block;" ><a href="#"><?php echo translate('product'); ?></a></div>
                            </div>
                            <input type="hidden" id="tryp" name="type" value="vendor">
                            <script>
                                $('.srt').click(function(){
                                    var ty = $(this).data('val');
                                    var ny = $(this).html();
                                    $('#tryp').val(ty);
                                    $('.ppy').html(ny+' <span class="caret"></span>');
                                    if(ty == 'vendor'){
                                        $('.tryu').attr('placeholder','<?php echo translate('search_vendor_by_title,_location,_address_etc.') ?>');
                                    } else if(ty == 'product'){
                                        $('.tryu').attr('placeholder','<?php echo translate('search_product_by_title,_description_etc.') ?>');
                                    }
                                });
                            </script>
                        </span>
                        <input type="text" name="query" class="form-control tryu" placeholder="<?php echo translate('search_vendor_by_title,_location,_address_etc.') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-input_type custom" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <nav id="mysidebarmenu" class="amazonmenu">
                    <ul>
                    <?php
                        $categories = $this->db->get('category')->result_array();
                        foreach($categories as $row){
                    ?>
                    <li><a href="#"><?php echo $row['category_name']; ?></a>
                        <div>
                        <div class="col-md-12">
                            <?php
                                $subs = $this->db->get_where('sub_category',array('category'=>$row['category_id']))->result_array();
                                foreach($subs as $row1){
                                    $this->db->limit(4);
                                    $this->db->order_by('product_id','desc');
                                    $products = $this->db->get_where('product',array('sub_category'=>$row1['sub_category_id']))->result_array();
                            ?>
                                <div class="col-md-12"><h3 class="text-center" style="background:#EAEAEA;"><?php echo $row1['sub_category_name']; ?></h3></div>
                                <?php
                                    foreach($products as $row2){
                                        if($this->crud_model->is_publishable($row2['product_id'])){
                                ?>
                                    <div class="col-md-3">
                                        <div class="menu_box">
                                            <div class="img_menu_box" style="background:url('<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','no','src','multi','one') ?>') no-repeat center center; background-size: 100% auto;">
                                            </div>
                                        
                                        <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                            <?php echo $row2['title']; ?>
                                        </a>
                                        <a href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>">
                                            <?php echo currency().$this->crud_model->get_product_price($row2['product_id']); ?>
                                        </a>
                                        </div>
                                    </div>
                                <?php
                                        }
                                    }
                                ?>
                            <?php
                                }
                            ?>
                        </div>
                        </div>
                    </li>
                    <?php
                        }
                    ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9" style="margin-top:10px;">
                <div class="timeline-heading">
                    <div class="carousel slide carousel-v1" id="myCarousel">
                        <div class="carousel-inner">
                            <?php
                                $i = 0;
                                $slides = $this->db->get('slides')->result_array();
                                foreach ($slides as $row) {
                                    $i++;
                            ?>
                            <div class="item <?php if($i == 1){ ?>active<?php } ?>">
                                <img class="img-responsive" src="<?php echo $this->crud_model->file_view('slides',$row['slides_id'],'','','no','src','','','.jpg') ?>" alt=""/>                                
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        
                        <div class="carousel-arrow">
                            <a data-slide="prev" href="#myCarousel" class="left carousel-control">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a data-slide="next" href="#myCarousel" class="right carousel-control">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 content mCustomScrollbar light" data-mcs-theme="minimal-dark" id="content-4"  style="background: #F5F5F5; margin-top:10px;border-radius:3px;padding-top: 3px;">
        <h3 class="heading heading-v1"><?php echo translate('todays_deal'); ?></h3>
        <div style="height:376px; overflow:auto; margin-top:10px;">
        <?php
            $i = 0;
                $this->db->limit(4);
                $most_popular = $this->db->get_where('product',array('deal'=>'ok'))->result_array();
                foreach ($most_popular as $row2){
                         
        ?>
        <div class="thumbnail">
            <a class="product-review zoomer various fancybox.ajax" data-fancybox-type="ajax" href="<?php echo $this->crud_model->product_link($row2['product_id'],'quick'); ?>">
                <span class="overlay-zoom">  
                    <img class="img-responsive thumb-product-img" src="<?php echo $this->crud_model->file_view('product',$row2['product_id'],'','','thumb','src','multi','one'); ?>" alt=""/>
                    <span class="zoom-icon"></span>                   
                </span>                                              
            </a>                    
            <div class="caption">
                <h3 class="text-center"><a class="hover-effect" href="<?php echo $this->crud_model->product_link($row2['product_id']); ?>"><?php echo $row2['title']; ?></a></h3>                        
            </div>
        </div>
        <?php  
            }
        ?>
        </div>
    </div>
</div>


<script>

jQuery(function(){
	amazonmenu.init({
		menuid: 'mysidebarmenu'
	})
})

</script>
