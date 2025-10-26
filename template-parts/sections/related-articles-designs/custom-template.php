<?php echo section_carousel_open('enable_articles_carousel', 'article-carousel');?>

    <?php foreach($articles as $article): ?>

        <div class="ac-item-wrapper <?php echo $classes;?>">
           <div class="article-col">
                        <div class="single-article">
                            <div class="img-holder">
                                <img src="<?php echo $article['featured_img'];?>" alt="<?php echo $article['title'];?>">
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
                                    <a href="<?php echo $article['link'];?>"><?php echo $article['title'];?></a>
                                </h2>
                                
                                <div class="article-desc">
                                    <?php echo $article['excerpt'];?>
                                </div>
                                
                                <div class="read-more-btn">
                                    <a href="<?php echo $article['link'];?>">
                                    <div class="icon-box">
                                        <svg width="32px" height="10px" viewBox="0 0 16.933 6.351" xmlns="http://www.w3.org/2000/svg"><path d="M13.493.006a.79.79 0 00-.53 1.382l-.001.002 1.108.997H.793a.794.794 0 100 1.588H14.07l-1.108.997.002.003a.79.79 0 00-.265.588c0 .438.356.794.794.794.204 0 .389-.08.53-.207l.001.002 2.646-2.38-.002-.003c.161-.145.265-.354.265-.588s-.104-.442-.265-.588l.002-.002L14.024.21l-.002.002a.79.79 0 00-.529-.206z"/></svg>
                                    </div>
                                    Continue Reading
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
      </div>
    <?php endforeach;?>

<?php echo section_carousel_close('enable_articles_carousel');?>

<style>


.related-articles-section{
	
	--articles-color-1: <?php ekwa_get_value('articles-color-1','#a87945');?>;
     --articles-color-2: <?php ekwa_get_value('articles-color-2','#002f6d');?>;
     --articles-color-3: <?php ekwa_get_value('articles-color-3','#333333');?>;
    --articles-text-color: <?php ekwa_get_value('articles-text-color','#000');?>;
    --articles-heading-color: <?php ekwa_get_value('articles-heading-color','#000');?>;
    background: <?php theme_mod_echo('articles-bg', '#ffffff');?>;
    padding-top: <?php  theme_mod_echo('section_paddings', 40);?>px;
    padding-bottom: <?php  theme_mod_echo('section_paddings', 40);?>px;
		
}
.related-articles-section h2{
    color: var(--articles-heading-color);
}
.article-col{
    margin-bottom: 30px;
}
.single-article .img-holder{
    position: relative;
    display: block;
    overflow: hidden;
}
.single-article .img-holder:after{
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
.single-article .img-holder img{
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
.single-article .text-holder {
    position: relative;
    display: block;
    border: 1px solid #eeeeee;
    padding: 30px 30px 22px;
    color: var(--articles-text-color);
}
.single-article .text-holder .meta-box{
    position: relative;
}
.single-article .text-holder .meta-box .author{
    position: absolute;
    top: -42px;
    right: 0;
}
.single-article .text-holder .meta-box .author a{
    background: var(--articles-color-2);
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
.single-article .text-holder .meta-box .date .icon-box, .blog-role .single-article .text-holder .read-more-btn .icon-box{
    display: inline;
}
.single-article .text-holder .meta-box .date .icon-box > svg{
    height: 20px;
    width: 20px;
    fill: var(--articles-text-color);
    margin-top: -4px;
    margin-right: 4px;
}
.single-article .text-holder .article-title{
    margin-top: 15px;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 700;
    width: 100%;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
}
.single-article .text-holder .article-title a{
    color: var(--articles-color-2);
    transition: color 500ms ease;
}
.single-article .text-holder .article-desc{
    margin-bottom: 20px;
}
.single-article .text-holder .read-more-btn .icon-box > svg{
    height: 10px;
    width: 32px;
    fill: var(--articles-color-2);
    margin-top: -4px;
    margin-right: 4px;
    transition: fill 500ms ease;
}
.single-article .text-holder .read-more-btn a{
    color: var(--articles-color-2);
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    transition: color 500ms ease;
}
.single-article:hover .img-holder:after{
    transform: scaleY(1);
    transition: .5s ease;
}
.single-article:hover .img-holder img{
    transform: scale(1.2, 1.2);
}
.single-article:hover .meta-box .author a{
    background: var(--articles-color-1);
}
.single-article:hover .read-more-btn a, .blog-role .single-article .article-title a:hover{
    color: var(--articles-color-1);
}
.single-article:hover .read-more-btn .icon-box > svg{
    fill: var(--articles-color-1);
}

.navigation-paging .page-numbers.current, .blog-role .navigation-paging .page-numbers:hover{
    color: #fff;
    background: var(--articles-color-2);
    border-color: var(--articles-color-2);
    transition: all 500ms ease;
}
.invisible{
    visibility: visible !important;
    opacity: 1;
}

@media screen and (max-width: 835px){
    .article-col{
        margin-bottom: 20px;
    }
} 
</style>