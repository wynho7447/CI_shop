<!-- CSS Page Style -->    
<link rel="stylesheet" href="<?php echo base_url();?>template/front/assets/css/pages/feature_timeline2.css">
<div class="container content">     
        <div class="row">
            <!-- Begin Sidebar Menu -->
            <div class="col-md-3">
                <h2>
                    <?php echo translate('blog_categories'); ?>
                </h2>
                <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                    <?php
                        $b = $this->db->get('blog_category')->result_array();
                        foreach ($b as $row) {
                    ?>
                    <!-- Typography -->
                    <li class="list-group-item list-toggle">                   
                        <a href="<?php echo base_url(); ?>index.php/home/blog/<?php echo $row['blog_category_id']; ?>"><?php echo $row['name']; ?></a>
                    </li>
                    <!-- End Typography -->
                    <?php
                        }
                    ?>
                </ul>
                <div class="sdbar posts margin-bottom-20">
                    <h4 class="text_color center_text mr_top_0"><?php echo translate('latest_blogs'); ?></h4>
                    <?php
                        $i = 0;
                        $this->db->limit(5);
                        $this->db->order_by('blog_id','desc');
                        $a = $this->db->get('blog')->result_array();
                        foreach ($a as $row2) {
                        $now = $this->db->get_where('blog',array('blog_id'=>$row2['blog_id']))->row();             
                    ?>
                    <dl class="dl-horizontal">
                        <dt>
                            <a href="<?php echo $this->crud_model->blog_link($now->blog_id); ?>">
                                <img src="<?php echo $this->crud_model->file_view('blog',$now->blog_id,'','','thumb','src','','one'); ?>" alt="" />
                            </a>
                        </dt>
                        <dd>
                            <p>
                                <a href="<?php echo $this->crud_model->blog_link($now->blog_id); ?>">
                                    <?php echo $now->title; ?>
                                </a>
                            </p>
                            <p>
                                <span>
                                    <?php echo currency().$now->date; ?>
                                </span>
                            </p>
                        </dd>
                    </dl>
                    <?php	
                        }
                    ?>
                </div>
                
                <div class="sdbar posts margin-bottom-20">
                    <h4 class="text_color center_text mr_top_0"><?php echo translate('most_viewed_blogs'); ?></h4>
                    <?php
                        $i = 0;
                        $this->db->limit(5);
                        $this->db->order_by('number_of_view','desc');
                        $a = $this->db->get('blog')->result_array();
                        foreach ($a as $row2) {
                        $now = $this->db->get_where('blog',array('blog_id'=>$row2['blog_id']))->row();             
                    ?>
                    <dl class="dl-horizontal">
                        <dt>
                            <a href="<?php echo $this->crud_model->blog_link($now->blog_id); ?>">
                                <img src="<?php echo $this->crud_model->file_view('blog',$now->blog_id,'','','thumb','src','','one'); ?>" alt="" />
                            </a>
                        </dt>
                        <dd>
                            <p>
                                <a href="<?php echo $this->crud_model->blog_link($now->blog_id); ?>">
                                    <?php echo $now->title; ?>
                                </a>
                            </p>
                            <p>
                                <span>
                                    <?php echo currency().$now->date; ?>
                                </span>
                            </p>
                        </dd>
                    </dl>
                    <?php	
                        }
                    ?>
                </div>
                
            </div>
            <!-- End Sidebar Menu -->

            <!-- Begin Content -->
            <div class="col-md-9">
                <ul class="timeline-v2">
                <?php
                    foreach ($blogs as $row) {
                        $day = date('l',strtotime($row['date']));
                        if($this->crud_model->file_view('blog',$row['blog_id'],'','','thumb','src','','') !== ''){
                ?>
                    <li>
                        <a href="<?php echo $this->crud_model->blog_link($row['blog_id']); ?>">
                            <time class="cbp_tmtime" datetime="">
                                <span>
                                    <?php echo $row['date']; ?>
                                </span>
                                <span>
                                    <?php echo $day; ?>
                                </span>
                            </time>
                            <i class="cbp_tmicon rounded-x hidden-xs"></i>
                            <div class="cbp_tmlabel" style="color:black;">
                                <h2><?php echo $row['title']; ?></h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img class="img-responsive" src="<?php echo $this->crud_model->file_view('blog',$row['blog_id'],'','','thumb','src','',''); ?>" alt=""> 
                                        <div class="md-margin-bottom-20"></div>
                                    </div>
                                    <div class="col-md-8">    
                                        <?php echo $row['summery']; ?>
                                    </div>
                                </div>        
                            </div>
                        </a>
                    </li>
                <?php
                    } else {
                ?>    
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/home/blog_view/<?php echo $row['blog_id']; ?>">
                            <time class="cbp_tmtime" datetime="">
                                <span>
                                    <?php echo $row['date']; ?>
                                </span>
                                <span>
                                    <?php echo $day; ?>
                                </span>
                            </time>
                            <i class="cbp_tmicon rounded-x hidden-xs"></i>
                            <div class="cbp_tmlabel">
                                <h2><?php echo $row['title']; ?></h2>
                                <?php echo $row['summery']; ?>
                            </div>
                        </a>
                    </li>
                <?php
                        }
                    }
                ?>    
                </ul>
            </div>
            <!-- End Content -->
            <center>
                <?php echo $this->pagination->create_links(); ?>
            </center>
        </div>          
    </div>