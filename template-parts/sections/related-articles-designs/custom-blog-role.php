<section id="blog-area" class="blog-role invisible">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 top-heading-content">
                <?php  if(is_search()): ?>
                 <h1>
                 <?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'ekwa' ), '<span>' . get_search_query() . '</span>' );
					?>
                    </h1>
                <?php else:?>
                <h1>Latest From Our Blog</h1>
                <?php endif;?>
            </div>
        </div>
        
        <div class="row">
            
            <!--		Start 		-->
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <div class="col-lg-4 article-col">
                        <div class="single-article">
                            <div class="img-holder">
                                <?php the_post_thumbnail('full'); ?>
                            </div>
                            
                            <div class="text-holder">
                                <div class="meta-box">
                                    <div class="author">
                                        <a href="<?php echo get_page_slug_by_id(get_theme_mod('author_page'));?>">By <?php the_author(); ?></a></a>
                                    </div>
                                    <div class="date">
                                        <div class="icon-box">
                                            <svg width="20px" height="20px" viewBox="0 0 25.135 23.336" xmlns="http://www.w3.org/2000/svg"><switch transform="translate(-.662 -1.56) scale(.26458)"><g><path d="M86.8 13.2H72.9v-4c0-1.8-1.5-3.3-3.3-3.3s-3.3 1.5-3.3 3.3v4H33.8v-4c0-1.8-1.5-3.3-3.3-3.3s-3.3 1.5-3.3 3.3v4h-14C7.3 13.2 2.5 18 2.5 23.8v59.6c0 5.9 4.8 10.7 10.7 10.7h73.6c5.9 0 10.7-4.8 10.7-10.7V23.8c0-5.8-4.8-10.6-10.7-10.6zm4.1 70.2c0 2.2-1.8 4-4.1 4H13.2c-2.2 0-4.1-1.8-4.1-4V41h81.7v42.4zm0-49.1H9.1V23.8c0-2.2 1.8-4 4.1-4h13.9v4c0 1.8 1.5 3.3 3.3 3.3s3.3-1.5 3.3-3.3v-4h32.5v4c0 1.8 1.5 3.3 3.3 3.3s3.3-1.5 3.3-3.3v-4h13.9c2.2 0 4.1 1.8 4.1 4v10.5z"/><path d="M24.7 61h7.7c.9 0 1.7-.8 1.7-1.7v-5.5c0-.9-.8-1.7-1.7-1.7h-7.7c-.9 0-1.7.8-1.7 1.7v5.5c-.1.9.7 1.7 1.7 1.7zM46.2 61h7.7c.9 0 1.7-.8 1.7-1.7v-5.5c0-.9-.8-1.7-1.7-1.7h-7.7c-.9 0-1.7.8-1.7 1.7v5.5c-.1.9.7 1.7 1.7 1.7zM67.6 61h7.7c.9 0 1.7-.8 1.7-1.7v-5.5c0-.9-.8-1.7-1.7-1.7h-7.7c-.9 0-1.7.8-1.7 1.7v5.5c0 .9.8 1.7 1.7 1.7zM24.7 76.6h7.7c.9 0 1.7-.8 1.7-1.7v-5.5c0-.9-.8-1.7-1.7-1.7h-7.7c-.9 0-1.7.8-1.7 1.7v5.5c-.1.9.7 1.7 1.7 1.7zM46.2 76.6h7.7c.9 0 1.7-.8 1.7-1.7v-5.5c0-.9-.8-1.7-1.7-1.7h-7.7c-.9 0-1.7.8-1.7 1.7v5.5c-.1.9.7 1.7 1.7 1.7zM67.6 76.6h7.7c.9 0 1.7-.8 1.7-1.7v-5.5c0-.9-.8-1.7-1.7-1.7h-7.7c-.9 0-1.7.8-1.7 1.7v5.5c0 .9.8 1.7 1.7 1.7z"/></g></switch></svg>
                                        </div>
                                        <?php the_date('F jS, Y'); ?>
                                    </div>
                                </div>
                                
                                <h2 class="article-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="article-desc">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <div class="read-more-btn">
                                    <a href="<?php the_permalink(); ?>">
                                    <div class="icon-box">
                                        <svg width="32px" height="10px" viewBox="0 0 16.933 6.351" xmlns="http://www.w3.org/2000/svg"><path d="M13.493.006a.79.79 0 00-.53 1.382l-.001.002 1.108.997H.793a.794.794 0 100 1.588H14.07l-1.108.997.002.003a.79.79 0 00-.265.588c0 .438.356.794.794.794.204 0 .389-.08.53-.207l.001.002 2.646-2.38-.002-.003c.161-.145.265-.354.265-.588s-.104-.442-.265-.588l.002-.002L14.024.21l-.002.002a.79.79 0 00-.529-.206z"/></svg>
                                    </div>
                                    Continue Reading
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php endwhile; ?>
                
                <div class="navigation-paging">
                    <?php ekwa_pagination(); ?>
                </div>
                
            <?php endif; ?>
            
        </div>
        
    </div>
</section>

<style>    
.blog-role{
    
    --blog-role-color-1:  <?php ekwa_get_value('articles-color-1','#a87945');?>;
    --blog-role-color-2: <?php ekwa_get_value('articles-color-2','#002f6d');?>;
    --blog-role-color-3: <?php ekwa_get_value('articles-color-3','#333333');?>;
    --blog-role-text-color: <?php ekwa_get_value('articles-text-color','#000');?>;
    padding: 50px 0px 50px 0px;
}
.blog-role .row{
    margin-right: 0px;
    margin-left: 0px;
}
.blog-role .container{
    padding-left: 0px;
    padding-right: 0px;
}
.blog-role h1{
    margin-top: 30px;
    font-size: 40px;
    font-weight: 800;
    color: var(--blog-role-color-3);
    margin-top: 0px;
    margin-bottom: 30px;
}
.blog-role a:hover, .blog-role a:focus, .blog-role a:active, .blog-role a:visited{
    text-decoration: none;
    outline: none;
    border: none;
}
.blog-role .top-heading-content{
    text-align: center;
    margin-bottom: 30px;
}
.blog-role .subtitle{
    display: block;
    font-weight: 800;
    margin: 0;
    color: var(--blog-role-color-2);
    font-size: 18px;
}
.blog-role .article-col{
    margin-bottom: 30px;
}
.blog-role .single-article .img-holder{
    position: relative;
    display: block;
    overflow: hidden;
}
.blog-role .single-article .img-holder:after{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    content: "";
    background: rgba(0, 0, 0, 0.65);
    transform: scaleX(0);
    transition: .5s ease;
}
.blog-role .single-article .img-holder img{
    transition: all 0.5s ease-in-out 0.6s;
    width: 100%;
    height: auto;
    max-width: 100%;
    border: none;
    -webkit-border-radius: 0;
    border-radius: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.blog-role .single-article .text-holder {
    position: relative;
    display: block;
    border: 1px solid #eeeeee;
    padding: 30px 30px 22px;
    color: var(--blog-role-text-color);
}
.blog-role .single-article .text-holder .meta-box{
    position: relative;
}
.blog-role .single-article .text-holder .meta-box .author{
    position: absolute;
    top: -42px;
    right: 0;
}
.blog-role .single-article .text-holder .meta-box .author a{
    background: var(--blog-role-color-2);
    color: #fff;
    padding: 12px 20px 12px;
    font-size: 12px;
    line-height: 13px;
    font-weight: 400;
    text-transform: uppercase;
    transition: all 500ms ease;
    border-radius: 6px;
    letter-spacing: 1px;
}
.blog-role .single-article .text-holder .meta-box .date .icon-box, .blog-role .single-article .text-holder .read-more-btn .icon-box{
    display: inline;
}
.blog-role .single-article .text-holder .meta-box .date .icon-box > svg{
    height: 20px;
    width: 20px;
    fill: var(--blog-role-text-color);
    margin-top: -4px;
    margin-right: 4px;
}
.blog-role .single-article .text-holder .article-title{
    margin-top: 15px;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 700;
    width: 100%;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
}
.blog-role .single-article .text-holder .article-title a{
    color: var(--blog-role-color-2);
    transition: color 500ms ease;
}
.blog-role .single-article .text-holder .article-desc{
    margin-bottom: 20px;
}
.blog-role .single-article .text-holder .read-more-btn .icon-box > svg{
    height: 10px;
    width: 32px;
    fill: var(--blog-role-color-2);
    margin-top: -4px;
    margin-right: 4px;
    transition: fill 500ms ease;
}
.blog-role .single-article .text-holder .read-more-btn a{
    color: var(--blog-role-color-2);
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    transition: color 500ms ease;
}
.blog-role .single-article:hover .img-holder:after{
    transform: scaleY(1);
    transition: .5s ease;
}
.blog-role .single-article:hover .img-holder img{
    transform: scale(1.2, 1.2);
}
.blog-role .single-article:hover .meta-box .author a{
    background: var(--blog-role-color-1);
}
.blog-role .single-article:hover .read-more-btn a, .blog-role .single-article .article-title a:hover{
    color: var(--blog-role-color-1);
}
.blog-role .single-article:hover .read-more-btn .icon-box > svg{
    fill: var(--blog-role-color-1);
}
.blog-role .navigation-paging{
    width: 100%;
    display: block;
    padding-left: 15px;
}
.blog-role .navigation-paging .page-numbers{
    position: relative;
    display: inline-block;
}
.blog-role .navigation-paging .page-numbers{
    position: relative;
    border: 2px solid #eeeeee;
    display: inline-block;
    color: var(--blog-role-color-3);
    line-height: 36px;
    margin: 0 5px 0 0;
    padding: 0 16px;
    border-radius: 6px;
}
.blog-role .navigation-paging .page-numbers.current, .blog-role .navigation-paging .page-numbers:hover{
    color: #fff;
    background: var(--blog-role-color-2);
    border-color: var(--blog-role-color-2);
    transition: all 500ms ease;
}
.blog-role.invisible{
    visibility: visible !important;
    opacity: 1;
}

@media screen and (min-width:835px) and (max-width: 1024px){
    
}
@media screen and (max-width: 835px){
    .blog-role .article-col{
        margin-bottom: 20px;
    }
    .blog-role .navigation-paging .page-numbers{
        text-align: center;
        padding-left: 15px;
        padding-right: 15px;
    }
    .blog-role .navigation-paging .page-numbers{
        margin-bottom: 10px;
    }
} 
</style>
