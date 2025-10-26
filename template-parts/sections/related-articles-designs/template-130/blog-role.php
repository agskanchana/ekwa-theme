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
                                        <a href="<?php echo get_page_slug_by_id(get_theme_mod('author_page'));?>">
                                        <i class="fa-regular fa-user"></i>
                                        By <?php the_author(); ?></a></a>
                                    </div>
                                    <div class="date">
                                    <div class="icon-box">
                                        <!-- <i class="fa-solid fa-calendar-days"></i> -->
                                        </div>
                                        <?php
                                        $day = get_the_date('j'); // Day of the month without leading zeros
                                        $month = get_the_date('M'); // Three-letter month abbreviation
                                        ?>
                                        <div class="date-container">
                                        <div class="date-box">
                                            <div class="day"><?php echo $day;?></div>
                                            <div class="month"><?php echo $month;?></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="article-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="article-desc">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="read-more-btn">
                                <a class="btn" href="<?php echo get_permalink();?>">
                                    Continue Reading <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>


                <div class="navigation-paging">
                    <?php ekwa_pagination(); ?>
                </div>
                 <?php else: ?>
                    <?php  if(is_search()): ?>
                        <h2> No Results</h2>
                    <?php endif;?>
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


.blog-role  .date-container {
    display: inline-block;
    text-align: center;
    padding: 6px;
}

.blog-role  .day {
    font-size: 1rem;
    font-weight: bold;
    margin: 0;
    position: relative;
}

.blog-role  .day::after {
    content: '';
    display: block;
    width: 60%;
    height: 2px;
    background-color: grey;
    margin: 8px auto 0;
}

.blog-role  .month {
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    margin: 8px 0 0;
    letter-spacing: 0.05em;
}
.blog-role .author a{
    color: var(--blog-role-color-3);
}

.blog-role .container{
    padding-left: 30px;
    padding-right: 30px;
}
.blog-role .row{
    margin-right: 0px;
    margin-left: 0px;
}
.blog-role .row{
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
@media screen and (min-width: 992px){
    .col-lg-4 {
    flex: 0 0 33.3333333333%;
    max-width: 33.3333333333%;
    padding-left: 15px;
    padding-right: 15px;
    }
}
@media screen and (max-width: 991px){
    .blog-role .row{
        display: block;
    }
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
    padding-top: 14px;
    color: var(--blog-role-text-color);
}
.blog-role .single-article .text-holder .meta-box{
    position: relative;
display: flex;
justify-content: space-between;
align-items: center;
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
