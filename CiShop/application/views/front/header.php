<body class="header-fixed">
<div class="wrapper">
    <div class="header-<?php echo $theme_color; ?> header-sticky header-fixed">
        <div class="topbar-v3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Topbar Navigation -->
                        <ul class="left-topbar">
                            <li>
                            	<?php
									if($set_lang = $this->session->userdata('language')){} else {
										$set_lang = $this->db->get_where('general_settings',array('type'=>'language'))->row()->value;
									}
								?>
                                <a>Language (<?php echo $set_lang; ?>)</a>
                                <ul class="language">
                                	<?php
                                    	$fields = $this->db->list_fields('language');
										foreach ($fields as $field)
										{
											if($field !== 'word' && $field !== 'word_id'){
									?>
                                    	<li <?php if($set_lang == $field){ ?>class="active"<?php } ?> >
                                        	<a class="set_langs" data-href="<?php echo base_url(); ?>index.php/home/set_language/<?php echo $field; ?>">
												<?php echo $field; ?> 
												<?php if($set_lang == $field){ ?>
                                                	<i class="fa fa-check"></i>
												<?php } ?>
                                            </a>
                                        </li>
                                    <?php
											}
										}
									?>
                                </ul>
                            </li>   
                        </ul><!--/end left-topbar-->
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-inline right-topbar pull-right" id="loginsets">
                        </ul>
                    </div>
                </div>
            </div><!--/container-->
                
        </div>
        <!-- End Topbar v3 -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('.set_langs').on('click',function(){
                    var lang_url = $(this).data('href');                                    
                    $.ajax({url: lang_url, success: function(result){
                        location.reload();
                    }});
                });
            });
        </script>
        <!-- Navbar -->
        <div class="navbar navbar-default mega-menu" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only"><?php echo translate('toggle_navigation');?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home/">
                        <img id="logo-header" src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Logo" class="img-responsive" style="width:250px;">
                    </a>
                </div>
                
                    <ul class="list-inline shop-badge badge-lists badge-icons pull-right" id="added_list">
                    </ul>
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <!-- Badge -->
                    <!-- End Badge -->
                    <ul class="nav navbar-nav">
                        <!-- Home -->
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/home/" class="dropdown-toggle" >
                                <?php echo translate('home'); ?>
                            </a>
                        </li>
                        <!-- End Home -->
                        <!-- Featured -->
                        <li class="dropdown mega-menu-fullwidth">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown" 
                            	data-toggle="dropdown">
                                	<?php echo translate('featured_product');?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="container">
                                            <div class="row illustration-v2">
                                                
                                                <?php
													$this->db->order_by('product_id','desc');
													$this->db->limit(3);
                                                	$featured = $this->db->get_where('product',array('featured'=>'ok'))->result_array();
													foreach($featured as $row){
												?>
                                                 <div class="col-md-3">
                                                    <div class="menu_box">
                                                        <div class="img_menu_box" style="background:url('<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one') ?>') no-repeat center center; background-size: 100% auto; height:200px;">
                                                        </div>
                                                    
                                                    <a href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">
                                                        <?php echo $row['title']; ?>
                                                    </a>
                                                    
                                                    <a href="<?php echo $this->crud_model->product_link($row['product_id']); ?>">
                                                        <?php echo currency().$this->crud_model->get_product_price($row['product_id']); ?>
                                                    </a>
                                                    </div>
                                                </div>
                                                <?php
													}
												?>
                                                <div class="col-md-3 md-margin-bottom-30">
                                                    <div class="overflow-h">
                                                        <a href="<?php echo base_url(); ?>index.php/home/featured_item">
                                                            <div class="illustration-v1 illustration-img1">
                                                                <div class="illustration-bg">
                                                                    <div class="illustration-ads ad-details-v1" >
                                                                            <div class="btn-u btn-u-sea"><?php echo translate('see_more');?> <i class="fa fa-arrow-circle-right"></i></div>
                                                                    </div>    
                                                                </div>    
                                                            </div>
                                                        </a>
                                                    </div>    
                                                </div>
                                            </div><!--/end row-->
                                        </div><!--/end container-->
                                    </div><!--/end mega menu content-->  
                                </li>
                            </ul><!--/end dropdown-menu-->
                        </li>
                        <!-- End Featured -->

                        <!-- Books -->
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                <?php echo translate('blog'); ?>
                            </a>
                            <ul class="dropdown-menu ">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/blog/all" >
                                        <?php echo translate('all_blogs'); ?>
                                    </a>
                                </li>
                                <?php
                                    $bcats = $this->db->get('blog_category')->result_array();
                                    foreach ($bcats as $row) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/home/blog/<?php echo $row['blog_category_id']; ?>" >
                                        <?php echo $row['name']; ?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
                        
                        <!-- Home -->
                        <li class="dropdown">
                            <a href="<?php echo base_url(); ?>index.php/home/compare/" class="dropdown-toggle" >
                                <?php echo translate('compare'); ?> (<span id="compare_num"><?php echo $this->crud_model->compared_num(); ?></span>)
                            </a>
                        </li>
                        <!-- End Home -->
                        
                        <!-- Home -->
                        <li class="dropdown">
                            <a href="<?php echo base_url(); ?>index.php/home/contact/" class="dropdown-toggle" >
                                <?php echo translate('contact'); ?>
                            </a>
                        </li>
                        <!-- End Home -->

                        <!-- Home -->
                        <li class="dropdown">
                            <a href="<?php echo base_url(); ?>index.php/home/store_locator/" class="dropdown-toggle" >
                                <?php echo translate('vendor_locator'); ?>
                            </a>
                        </li>
                        <!-- End Home -->
						<?php
                        	$pages = $this->db->get_where('page',array('status'=>'ok'))->result_array();
							foreach($pages as $row1){
						?>
                        <!-- Home -->
                        <li class="dropdown">
                            <a href="<?php echo base_url(); ?>index.php/home/page/<?php echo $row1['parmalink']; ?>" class="dropdown-toggle" >
                                <?php echo translate($row1['page_name']); ?>
                            </a>
                        </li>
                        <!-- End Home -->
                        <?php
                        	}
						?>
                    </ul>
                </div><!--/navbar-collapse-->
            </div>    
        </div>            
        <!-- End Navbar -->
    </div>
    <!--=== End Header style1 ===-->
<style>

div.shadow {
    max-height:300px;
    min-height:300px;
    overflow:hidden;
	-webkit-transition: all .4s ease;
	-moz-transition: all .4s ease;
	-o-transition: all .4s ease;
	-ms-transition: all .4s ease;
	transition: all .4s ease;
}
.shadow:hover {
	background-size: 110% auto !important;
}

.custom_item{
    border: 1px solid #ccc;
    border-radius: 4px !important;
    transition: all .2s ease-in-out;
    margin-top:10px !important;	
}
.custom_item:hover{
    webkit-transform: translate3d(0, -5px, 0);
    -moz-transform: translate3d(0, -5px, 0);
    -o-transform: translate3d(0, -5px, 0);
    -ms-transform: translate3d(0, -5px, 0);
    transform: translate3d(0, -5px, 0);
    border:1px solid #AB00FF;
}
.tab_hov{
    transition: all .5s ease-in-out;	
}
.tab_hov:hover{
    opacity:0.7;
    transition: all .5s ease-in-out;
}
.tab_hov:active{
    opacity:0.7;
}
.ppy a{
    color: white;
}
</style>