

	<section id="blog-area" class="blog-single invisible">
		<div class="container">
		    <div class="row">
			<div class="col-lg-8 content-col">
			    
			    <?php /* The loop */ ?>
			    <?php while ( have_posts() ) : the_post(); ?>
				<?php
					$siteurl = get_option( 'siteurl' )."/";
					$categories = get_the_category();
					$category = $categories[0];
					$category_slug =  $category->slug;
					$cat_name = $category->name;
				?>
				<div class="top-box">
					<div class="date-wrapper">
					    <h3 class="date"><?php the_time('d'); ?></h3>
					    <div class="borders"></div>
					    <p class="month"><?php the_time('M'); ?></p>
					</div>
					<div class="title-holder-wrapper">
					    <div class="title-holder">
						<h1 class="title"><?php the_title(); ?></h1>
					    </div>
					    <div class="meta-box">
						<ul class="meta-info">
						    <li>
							<a href="<?php echo get_page_slug_by_id(get_theme_mod('author_page'));?>">
							<svg width="22px" height="22px" viewBox="0 0 19.927 19.65" xmlns="http://www.w3.org/2000/svg"><defs><clipPath id="a"><path d="M423.15 514.62v55.9h28.377c.028-.594.097-1.22.215-1.875.05-.282.066-.573.152-.846.34-1.07.663-2.15 1.123-3.174.828-1.838 2.187-4.11 3.434-5.771.861-1.148 3.12-3.763 4.09-4.9 2.16-2.197 2.3-2.456 4.65-4.395.635-.523 1.313-.991 1.96-1.498.726-.567 1.458-1.213 2.214-1.752.29-.207.595-.392.892-.588.319-.146.64-.29.957-.437-.12.052-.253.117-.332.129-.116.017.172-.16.258-.239.173-.158.334-.333.52-.476.73-.564 1.327-.953 2.056-1.442 1.424-.743 1.391-.739.97-.494-.423.245-1.235.732-1.366.957-.697 1.192-.907 2.606-1.36 3.91-2.026 5.838 3.08 1.058 6.99-1.863V514.62zm55.801 37.896c-.068.04-.158.04-.22.09-.956.758-1.056 1.057-2.102 1.72-.367.233-.757.425-1.145.62-.076.069-.133.127-.388.33-.518.41-1.022.837-1.543 1.242-.466.362-.958.688-1.416 1.059-1.79 1.443-1.873 1.614-3.528 3.261-.125.147-3.138 3.669-3.422 4.031-.776.993-1.683 2.425-2.25 3.51-.251.482-.48.981-.642 1.5-.066.21-.11.425-.153.64h5.438c2.892-2.7 5.963-5.004 9.502-7.439.49-.336 1.206-.797 1.869-1.228zm-3.05 2.188c-.218.074-.271.111-.376.207l.375-.207z" fill="red"/></clipPath></defs><path d="M4.498 13.18l-2.276.16-2.17 5.344c-.237.555.318 1.137.874.926l5.635-1.905.106-2.329-2.328.133zM18.309 6.01l1.217-1.217c.529-.529.529-1.376 0-1.905L17.066.401a1.341 1.341 0 00-1.906 0l-1.217 1.217z"/><path transform="translate(-109.18 -133.773) scale(.26458)" d="M462.45 514.62l-10.6 10.602-16.6 16.5-12.102 12.1 8.602-.6-.4 8.899 8.798-.399-.398 8.8 12.1-12.2 16.5-16.6 10.6-10.602zm-.8 10.4c.5 0 1 .2 1.4.6.8.8.8 2 0 2.8l-23.4 23.4c-.4.4-.899.6-1.399.6s-1-.2-1.4-.6c-.8-.8-.8-2 0-2.8l23.4-23.4c.4-.4.898-.6 1.398-.6zm4.8 4.9c.5 0 1 .2 1.4.6.8.8.8 2 0 2.8l-23.4 23.4c-.4.4-.9.6-1.4.6s-1-.2-1.4-.6c-.8-.8-.8-2 0-2.8l23.4-23.4c.4-.4.9-.6 1.4-.6z" clip-path="url(#a)"/></svg>
							<?php the_author(); ?>
							</a>
						    </li>
						    <li>
							<svg width="22px" height="22px" viewBox="0 0 2.924 3.925" xmlns="http://www.w3.org/2000/svg"><path d="M.07.008a.07.07 0 00-.07.07v3.785a.07.07 0 00.07.07h2.784a.07.07 0 00.07-.07V1.41H1.59a.07.07 0 01-.07-.07V.008zm1.59.04v1.223h1.223zM.67 2.007a.092.092 0 01.093.092.092.092 0 01-.093.093.092.092 0 01-.092-.093.092.092 0 01.092-.092zm.445.022h1.159a.07.07 0 010 .14H1.115a.07.07 0 010-.14zm-.445.527a.092.092 0 01.093.092.092.092 0 01-.093.093.092.092 0 01-.092-.093.092.092 0 01.092-.092zm.445.022h1.159a.07.07 0 010 .14H1.115a.07.07 0 010-.14zm-.445.526a.092.092 0 01.093.093.092.092 0 01-.093.092.092.092 0 01-.092-.092.092.092 0 01.092-.093zm.438.023a.07.07 0 01.007 0h1.159a.07.07 0 010 .14H1.115a.07.07 0 01-.007-.14z" color="#000"/></svg>
							<?php the_category(', '); ?>
						    </li>
						</ul>
					    </div>
					    
					    <div class="Addthis">
						<div class="addthis_inline_share_toolbox"></div>
						<script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51e6d1fd01772270"></script> 
					    </div>
					    
					</div>
				    </div>
				    
				    <div class="single-post-image">
					<div class="image-box">
					    <?php the_post_thumbnail('full'); ?>
					</div>
				    </div>
				    
				    <div class="blog-content">
					<?php the_content(); ?>
					<div class="back-btn-wrapper">
								<?php
								$siteurl = get_option( 'siteurl' )."/";
								$categories = get_the_category();
								$category = $categories[0];
								$category_slug =  $category->slug;
								$cat_name = $category->name;				
								if($category_slug !="featured-articles"){
								  $category_slug = str_replace("articles-", "", $category_slug);
								  echo '<a class="backto-link" href="'.$siteurl.''.$category_slug.'"> <i class="fas fa-arrow-left"></i>  Back to '.$cat_name.' Page</a>';
								}else{
									echo '<a class="backto-link" href="'.$siteurl.'"><i class="fas fa-arrow-left"></i>  Back to Home Page</a>';
								}
								
								
								?>
							</div>
				    </div>

				
			    <?php endwhile; ?>
			
			</div>
			
			<div class="col-lg-4 sidebar-col">
			    <div class="sidebar-wrapper">
				
				<?php if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
                        <aside id="secondary" class="sidebar widget-area" role="complementary">
                                <?php dynamic_sidebar( 'sidebar-1' ); ?>
                        </aside><!-- .sidebar .widget-area -->
                <?php endif; ?>
				
			    </div>
			</div>
		    </div>
		</div>
	</section>
	
	<style>
		.blog-single{
            
            
			--blog-single-color-1: <?php ekwa_get_value('articles-color-1','#002f6d');?>;
			--blog-single-color-2: <?php ekwa_get_value('articles-color-2','#a87945');?>;
			--blog-single-color-3: <?php ekwa_get_value('articles-color-3','#002f6d');?>;
			--blog-single-text-color: <?php ekwa_get_value('articles-text-color','#000');?>;
			--blog-single-link-hover-color: <?php ekwa_get_value('articles-color-3','#002f6d');?>;
			/*font-family: 'Rubik', sans-serif;*/
			background: #fff;
			padding: 85px 0 93px;
			color: var(--blog-single-text-color);
			font-size: 16px;
			font-weight: 400;
			line-height: 24px;
		    }
			.blog-single .row{
				display: flex;
				flex-wrap: wrap;
				margin-right: -15px;
				margin-left: -15px;
			}

			@media screen and (min-width: 991px){
				.col-lg-8 {
					flex: 0 0 66.6666666667%;
					max-width: 66.6666666667%;
				}
				.col-lg-4 {
				flex: 0 0 33.3333333333%;
				max-width: 33.3333333333%;
				}
				.content-col{
					padding-right: 40px;
				}
			}
			@media screen and (max-width: 991px){
				.blog-single .row{
					display: block;
				}
			}
		
	
		    .blog-single .container{
			padding-left: 30px;
			padding-right: 30px;
		    }
		    .blog-single h1, .blog-single h2, .blog-single h3, .blog-single h4{
			/*font-family: 'Poppins', sans-serif;*/
			font-weight: 700;
			color: var(--blog-single-color-3);
		    }
		    .blog-single h1{
			color: var(--blog-single-color-3);
			font-size: 30px;
			line-height: 40px;
			font-weight: 700;
			margin: 0;
		    }
		    .blog-single a:hover, .blog-single a:focus, .blog-single a:active, .blog-single a:visited{
			text-decoration: none;
			outline: none;
			border: none;
		    }
		    .blog-single .content-col .top-box{
			position: relative;
			display: block;
			overflow: hidden;
			padding-left: 70px;
		    }
		    .blog-single .content-col .top-box .date-wrapper{
			position: absolute;
			top: 0;
			left: 0;
			width: 70px;
			height: 75px;
			border: 1px solid #eeeeee;
			text-align: center;
			display: block;
			padding: 11px 0;
		    }
		    .blog-single .content-col .top-box .date-wrapper .date{
			line-height: 20px;
			margin: 0 0 6px;
			font-size: 24px;
		    }
		    .blog-single .content-col .top-box .date-wrapper .month{
			color: var(--blog-single-color-3);
			font-size: 14px;
			font-weight: 500;
			line-height: 14px;
			margin: 10px 0 0;
		    }
		    .blog-single .content-col .top-box .date-wrapper .borders{
			height: 1px;
			width: 50px;
			display: block;
			background: #eeeeee;
			margin: 0 auto;
		    }
		    .blog-single .content-col .top-box .title-holder-wrapper{
			display: block;
			padding-left: 30px;
		    }
		    .blog-single .content-col .top-box .meta-box{
			position: relative;
			display: block;
		    }
		    .blog-single .content-col .top-box .meta-box .meta-info{
			display: block;
			overflow: hidden;
			padding: 20px 0 0px;
			margin: 0;
		    }
		    .blog-single .content-col .top-box .meta-box .meta-info li{
			display: inline-block;
			float: left;
			line-height: 20px;
			margin-right: 20px;
		    }
		    .blog-single .content-col .top-box .meta-box .meta-info li a > svg, .blog-single .content-col .top-box .meta-box .meta-info li > svg{
			height: 22px;
			width: 22px;
			fill: var(--blog-single-color-2);
			margin-top: -5px;
			margin-right: 4px;
		    }
		    .blog-single .content-col .top-box .meta-box .meta-info li a{
			color: var(--blog-single-color-3);
			text-transform: uppercase;
			transition: color 500ms ease;
		    }
		    .blog-single .content-col .top-box .meta-box .meta-info li a:hover{
			color: var(--blog-single-link-hover-color);
		    }
		    .blog-single .content-col .single-post-image{
			position: relative;
			display: block;
			margin-top: 40px;
			margin-bottom: 44px;
		    }
		    .blog-single .content-col .single-post-image .image-box{
			float: left;
			margin-right: 20px;
			margin-bottom: 10px;
		    }
		    .blog-single .content-col .single-post-image img{
			max-width: 100%;
			height: auto;
		    }
		    .blog-single .content-col .blog-content a:hover{
			color: var(--blog-single-color-2);
		    }
		    .blog-single .content-col .blog-content h2{
			font-size: 22px;
			margin-top: 30px;
			margin-bottom: 15px;
		    }
		    .blog-single .content-col .blog-content p>img {
			float: right;
			margin-left: 15px;
		    }
		    .blog-single .content-col .blog-content ul{
			margin: 0;
			padding: 0;
			padding-left: 15px;
		    }
		    .blog-single .content-col .blog-content ul li{
			padding: 6px 0px;
		    }
		    .blog-single .content-col .Addthis{
			margin-top: 20px;
			margin-bottom: 0px;
		    }
		    .blog-single .sidebar-col .screen-reader-text{
			display: none;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .widget{
			position: relative;
			display: block;
			overflow: hidden;
			margin-bottom: 60px;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .search-form .search-submit:hover{
			background: var(--blog-single-color-2);
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .search-form .search-submit:hover > .search-form label:before{
			fill: #fff;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper h2{
			position: relative;
			display: block;
			overflow: hidden;
			border-top: 2px solid var(--blog-single-color-1);
			background: #f5f5f5;
			padding: 16px 40px 17px;
			margin-bottom: 0px;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper h2{
			font-size: 20px;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .widget_categories ul{
			position: relative;
			display: block;
			border: 1px solid #eeeeee;
			padding: 12px 39px 11px;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .widget_categories ul li{
			position: relative;
			display: block;
			color: #222222;
			line-height: 46px;
			border-bottom: 1px solid #e9e9e9;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .widget_categories ul li:last-child{
			border-bottom: none;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper ul li a{
			position: relative;
			display: inline-block;
			color: var(--blog-single-color-3);
			font-size: 15px;
			font-weight: 400;
			/*font-family: 'Rubik', sans-serif;*/
			transition: color 500ms ease;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper ul li a:hover{
			color: var(--blog-single-link-hover-color);
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul{
			position: relative;
			display: block;
			overflow: hidden;
			padding-top: 30px;
			border: 1px solid #eeeeee;
			padding: 30px 39px 22px !important;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li{
			position: relative;
			display: block;
			margin-bottom: 32px;
			padding-bottom: 0px;
			padding-left: 0px;
			min-height: 100px;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li:hover .img-box .overlay, .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li:hover .img-box .overlay > svg{
			opacity: 1;
			visibility: visible;
			transition: all 500ms ease;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li:hover .img-box .overlay > svg{
			fill: var(--blog-single-color-2);
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li .img-box{
			position: absolute;
			top: -14px;
			left: 0;
			width: 80px;
			height: 88px;
			display: block;
			overflow: hidden;
			border-radius: 0px;
			background-size: cover;
			background-position: center center;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li .img-box .overlay > svg{
			height: 20px;
			width: 20px;
			fill: #fff;
			z-index: 999;
			position: absolute;
			top: 40%;
			left: 0;
			right: 0;
			margin: 0 auto;
			opacity: 0;
			visibility: hidden;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li .img-box .overlay{
			display: block;
			height: 100%;
			width: 100%;
			background: rgba(0,0,0, 0.65);
			position: relative;
			opacity: 0;
			visibility: hidden; 
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li .meta-info{
			position: absolute;
			top: 0px;
			right: 0;
			width: 100%;
			padding-left: 95px;
			display: block;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li .meta-info .rp-publish-date{
			margin-bottom: 8px;
		    }
		    .blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul li .meta-info .rp-publish-date > svg{
			height: 16px;
			width: 16px;
			fill: var(--blog-single-color-2);
			margin-top: -3px;
			margin-right: 5px;
		    }
		    .blog-single.invisible{
			visibility: visible !important;
			opacity: 1;
		    }
		    
		    @media screen and (min-width:835px) and (max-width: 1024px){
			.blog-single .sidebar-col .sidebar-wrapper .recent-posts-extended .rpwe-ul{
			    padding: 30px 29px 22px;
			}
		    }
		    @media screen and (max-width: 835px){
			.blog-single .content-col{
			    margin-bottom: 60px;
			}
			.blog-single .content-col .blog-content ul{
			    column-count: 1;
			}
			.blog-single .content-col .top-box .date-wrapper{
			    position: relative;
			    margin-bottom: 35px;
			}
			.blog-single .content-col .top-box, .blog-single .content-col .top-box .title-holder-wrapper{
			    padding-left: 0px;
			}
		    }
			.back-btn-wrapper{
				margin-top: 30px;
			}
			.back-btn-wrapper a{
				font-weight: bold;
				color: var(--blog-single-text-color);
			}
	</style>