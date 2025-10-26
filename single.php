<?php get_header(); ?>

<style>
/* Single Post Premium Layout */
.ekwa-single-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px;
}

.ekwa-single-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 40px;
    align-items: start;
    max-width: 1300px;
    margin: 0 auto;
}

.ekwa-single-container {
    width: 100%;
    min-width: 0;
}

.ekwa-single-article {
    background: var(--color_invert);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
}

.ekwa-single-header {
    text-align: center;
    padding: 50px 40px 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.ekwa-single-category {
    display: inline-block;
    background: var(--color_two);
    color: var(--color_invert);
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
    text-decoration: none;
}

.ekwa-single-title {
    font-size: 42px;
    line-height: 1.3;
    margin-bottom: 25px;
    font-weight: 700;
    color: var(--color_headings);
}

.ekwa-single-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    font-size: 14px;
    color: var(--color_text);
    opacity: 0.8;
}

.ekwa-single-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.ekwa-single-meta-item svg {
    width: 16px;
    height: 16px;
    fill: var(--color_two);
}

.ekwa-single-author-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ekwa-single-author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid var(--color_two);
}

.ekwa-single-author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ekwa-single-author-name {
    font-weight: 600;
    color: var(--color_text);
}

.ekwa-single-featured-image {
    width: 100%;
    overflow: hidden;
    position: relative;
	padding: 30px;
}

.ekwa-single-featured-image img {
    display: block;
	width: 100%;
	height: auto;
}

.ekwa-single-content {
    padding: 50px 40px;
}

.ekwa-single-content p {
    line-height: 1.8;
    margin-bottom: 20px;
    color: var(--color_text);
    font-size: 18px;
}

.ekwa-single-content h2,
.ekwa-single-content h3,
.ekwa-single-content h4 {
    color: var(--color_headings);
    margin-top: 35px;
    margin-bottom: 20px;
    font-weight: 700;
}

.ekwa-single-content h2 {
    font-size: 32px;
}

.ekwa-single-content h3 {
    font-size: 26px;
}

.ekwa-single-content h4 {
    font-size: 22px;
}

.ekwa-single-content ul,
.ekwa-single-content ol {
    margin: 20px 0 20px 30px;
    line-height: 1.8;
}

.ekwa-single-content li {
    margin-bottom: 10px;
    color: var(--color_text);
}

.ekwa-single-content a {
    /* color: var(--color_link); */
    transition: color 0.3s ease;
}

.ekwa-single-content a:hover {
    color: var(--color_link_hover);
}

.ekwa-single-content blockquote {
    border-left: 4px solid var(--color_two);
    padding: 20px 30px;
    margin: 30px 0;
    background: rgba(0, 0, 0, 0.02);
    font-style: italic;
    color: var(--color_text);
}

.ekwa-single-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 25px 0;
}

.ekwa-single-back-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    margin-top: 30px;
    background: var(--color_two);
    color: var(--color_invert);
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    border: 2px solid var(--color_two);
}

.ekwa-single-back-link:hover {
    background: transparent;
    color: var(--color_two);
    transform: translateX(-5px);
}

.ekwa-single-back-link svg {
    width: 18px;
    height: 18px;
    fill: currentColor;
    transition: transform 0.3s ease;
}

.ekwa-single-back-link:hover svg {
    transform: translateX(-3px);
}

.ekwa-single-footer {
    padding: 30px 40px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.ekwa-single-tags {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.ekwa-single-tags-label {
    font-weight: 600;
    color: var(--color_text);
}

.ekwa-single-tag {
    display: inline-block;
    padding: 6px 14px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 6px;
    color: var(--color_text);
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.ekwa-single-tag:hover {
    background: var(--color_two);
    color: var(--color_invert);
    border-color: var(--color_two);
}

.ekwa-single-share {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ekwa-single-share-label {
    font-weight: 600;
    color: var(--color_text);
}

.ekwa-single-share-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.05);
    color: var(--color_text);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.ekwa-single-share-btn:hover {
    background: var(--color_two);
    color: var(--color_invert);
    transform: translateY(-3px);
}

.ekwa-single-share-btn svg {
    width: 18px;
    height: 18px;
    fill: currentColor;
}

.ekwa-single-author-box {
    margin-top: 50px;
    padding: 35px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    display: flex;
    gap: 25px;
    align-items: flex-start;
}

.ekwa-single-author-box-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--color_two);
    flex-shrink: 0;
}

.ekwa-single-author-box-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ekwa-single-author-box-content h3 {
    font-size: 22px;
    margin-bottom: 10px;
    color: var(--color_headings);
    font-weight: 700;
}

.ekwa-single-author-box-content p {
    color: var(--color_text);
    line-height: 1.7;
    opacity: 0.8;
}

.ekwa-single-navigation {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.ekwa-single-nav-link {
    flex: 1;
    padding: 25px;
    background: var(--color_invert);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: block;
}

.ekwa-single-nav-link:hover {
    border-color: var(--color_two);
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
}

.ekwa-single-nav-label {
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 600;
    color: var(--color_two);
    margin-bottom: 8px;
    display: block;
}

.ekwa-single-nav-title {
    color: var(--color_headings);
    font-size: 18px;
    font-weight: 600;
    line-height: 1.4;
}

.ekwa-single-comments {
    margin-top: 50px;
    padding: 40px;
    background: var(--color_invert);
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
}

/* Sidebar Styles */
.ekwa-single-sidebar {
    position: sticky;
    top: 20px;
}

.ekwa-sidebar-widget {
    background: var(--color_invert);
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.ekwa-sidebar-widget h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--color_headings);
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--color_two);
}

.ekwa-sidebar-widget ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.ekwa-sidebar-widget li {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.ekwa-sidebar-widget li:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.ekwa-sidebar-widget a {
    color: var(--color_text);
    text-decoration: none;
    display: flex;
    gap: 10px;
    align-items: flex-start;
    line-height: 1.5;
    transition: color 0.3s ease;
}

.ekwa-sidebar-widget a:hover {
    color: var(--color_two);
}

.ekwa-sidebar-widget .post-date {
    font-size: 12px;
    color: var(--color_text);
    opacity: 0.6;
    display: block;
    margin-top: 5px;
}

.ekwa-sidebar-categories a,
.ekwa-sidebar-tags a {
    display: inline-block;
    padding: 8px 16px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 6px;
    margin: 0 8px 8px 0;
    font-size: 14px;
    border: 1px solid transparent;
}

.ekwa-sidebar-categories a:hover,
.ekwa-sidebar-tags a:hover {
    background: var(--color_two);
    color: var(--color_invert);
    border-color: var(--color_two);
}

@media (max-width: 1024px) {
    .ekwa-single-layout {
        grid-template-columns: 1fr;
    }

    .ekwa-single-sidebar {
        position: static;
        margin-top: 50px;
    }
}

@media (max-width: 768px) {
    .ekwa-single-wrapper {
        padding: 30px 15px;
    }

    .ekwa-single-header {
        padding: 30px 20px 20px;
    }

    .ekwa-single-title {
        font-size: 28px;
    }

    .ekwa-single-meta {
        gap: 15px;
    }

    .ekwa-single-featured-image {
        height: 300px;
    }

    .ekwa-single-content {
        padding: 30px 20px;
    }

    .ekwa-single-content p {
        font-size: 16px;
    }

    .ekwa-single-footer {
        padding: 20px;
        flex-direction: column;
        align-items: flex-start;
    }

    .ekwa-single-author-box {
        flex-direction: column;
        padding: 25px;
        text-align: center;
        align-items: center;
    }

    .ekwa-single-navigation {
        flex-direction: column;
    }

    .ekwa-single-comments {
        padding: 25px 20px;
    }
}
</style>

<div class="ekwa-single-wrapper">
    <div class="ekwa-single-layout">
        <div class="ekwa-single-container">
            <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('ekwa-single-article'); ?>>
            <header class="ekwa-single-header">
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) :
                ?>
                    <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="ekwa-single-category">
                        <?php echo esc_html( $categories[0]->name ); ?>
                    </a>
                <?php endif; ?>

                <h1 class="ekwa-single-title"><?php the_title(); ?></h1>

                <div class="ekwa-single-meta">
                    <div class="ekwa-single-author-info">
                        <div class="ekwa-single-author-avatar">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
                        </div>
                        <span class="ekwa-single-author-name"><?php the_author(); ?></span>
                    </div>

                    <div class="ekwa-single-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M152 64h144V24c0-13.3 10.7-24 24-24s24 10.7 24 24v40h40c35.3 0 64 28.7 64 64v320c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64h40V24C104 10.7 114.7 0 128 0s24 10.7 24 24v40zM48 192v256c0 8.8 7.2 16 16 16h320c8.8 0 16-7.2 16-16V192H48z"/></svg>
                        <?php echo get_the_date(); ?>
                    </div>

                    <div class="ekwa-single-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208zm0-352c-13.2 0-24 10.8-24 24v136c0 6.4 2.5 12.5 7 17l80 80c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L280 262.1V136c0-13.2-10.8-24-24-24z"/></svg>
                        <?php echo esc_html( get_the_time( 'g:i A' ) ); ?>
                    </div>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="ekwa-single-featured-image">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>

            <div class="ekwa-single-content">
                <?php the_content(); ?>

                <?php
                // Get the primary category (using Yoast if available, otherwise first category)
                $primary_cat_id = null;
                $primary_category = null;

                // Try Yoast primary category first
                if ( class_exists( 'WPSEO_Primary_Term' ) ) {
                    $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_ID() );
                    $primary_cat_id = $wpseo_primary_term->get_primary_term();
                }

                // If no Yoast primary, get first category
                if ( ! $primary_cat_id ) {
                    $categories = get_the_category();
                    if ( ! empty( $categories ) ) {
                        $primary_cat_id = $categories[0]->term_id;
                    }
                }

                // Get the category object
                if ( $primary_cat_id ) {
                    $primary_category = get_category( $primary_cat_id );
                }

                // Determine if we should show the back link
                $show_back_link = false;
                $back_link_url = '';
                $back_link_text = '';

                if ( $primary_category && $primary_category->slug !== 'uncategorized' ) {
                    // Check if primary category is 'featured' or 'featured-articles'
                    if ( in_array( $primary_category->slug, array( 'featured', 'featured-articles' ) ) ) {
                        // Find another category that's not uncategorized, featured, or featured-articles
                        $all_categories = get_the_category();
                        $alternate_category = null;

                        foreach ( $all_categories as $cat ) {
                            if ( ! in_array( $cat->slug, array( 'uncategorized', 'featured', 'featured-articles' ) ) ) {
                                $alternate_category = $cat;
                                break;
                            }
                        }

                        // Use alternate category if found
                        if ( $alternate_category ) {
                            $show_back_link = true;
                            $back_link_url = home_url( '/' . $alternate_category->slug );
                            $back_link_text = 'Back to ' . $alternate_category->name . ' Page';
                        }
                        // If only featured/featured-articles, don't show link
                    } else {
                        // Use the primary category
                        $show_back_link = true;
                        $back_link_url = home_url( '/' . $primary_category->slug );
                        $back_link_text = 'Back to ' . $primary_category->name . ' Page';
                    }
                }

                // Display the back link
                if ( $show_back_link ) :
                ?>
                    <a href="<?php echo esc_url( $back_link_url ); ?>" class="ekwa-single-back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                        <?php echo esc_html( $back_link_text ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <footer class="ekwa-single-footer">
                <?php
                $tags = get_the_tags();
                if ( $tags ) :
                ?>
                    <div class="ekwa-single-tags">
                        <span class="ekwa-single-tags-label">Tags:</span>
                        <?php foreach ( $tags as $tag ) : ?>
                            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="ekwa-single-tag">
                                <?php echo esc_html( $tag->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="ekwa-single-share">
                    <span class="ekwa-single-share-label">Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener" class="ekwa-single-share-btn" title="Share on Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener" class="ekwa-single-share-btn" title="Share on Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink() ); ?>&title=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener" class="ekwa-single-share-btn" title="Share on LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>
                    </a>
                </div>
            </footer>
        </article>

        <?php
        $author_bio = get_the_author_meta( 'description' );
        if ( $author_bio ) :
        ?>
            <div class="ekwa-single-author-box">
                <div class="ekwa-single-author-box-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                </div>
                <div class="ekwa-single-author-box-content">
                    <h3>About <?php the_author(); ?></h3>
                    <p><?php echo esc_html( $author_bio ); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <nav class="ekwa-single-navigation">
            <?php
            $prev_post = get_previous_post();
            if ( $prev_post ) :
            ?>
                <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="ekwa-single-nav-link">
                    <span class="ekwa-single-nav-label">← Previous</span>
                    <span class="ekwa-single-nav-title"><?php echo esc_html( $prev_post->post_title ); ?></span>
                </a>
            <?php else : ?>
                <div></div>
            <?php endif; ?>

            <?php
            $next_post = get_next_post();
            if ( $next_post ) :
            ?>
                <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="ekwa-single-nav-link" style="text-align: right;">
                    <span class="ekwa-single-nav-label">Next →</span>
                    <span class="ekwa-single-nav-title"><?php echo esc_html( $next_post->post_title ); ?></span>
                </a>
            <?php endif; ?>
        </nav>

        <?php
        if ( comments_open() || get_comments_number() ) :
        ?>
            <div class="ekwa-single-comments">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>
        </div><!-- .ekwa-single-container -->

        <aside class="ekwa-single-sidebar">
            <!-- Recent Posts Widget -->
            <div class="ekwa-sidebar-widget">
                <h3>Recent Articles</h3>
                <ul>
                    <?php
                    $recent_posts = wp_get_recent_posts( array(
                        'numberposts' => 5,
                        'post_status' => 'publish',
                        'post__not_in' => array( get_the_ID() )
                    ) );
                    foreach ( $recent_posts as $post ) :
                    ?>
                        <li>
                            <a href="<?php echo get_permalink( $post['ID'] ); ?>">
                                <?php echo esc_html( $post['post_title'] ); ?>
                                <span class="post-date"><?php echo get_the_date( '', $post['ID'] ); ?></span>
                            </a>
                        </li>
                    <?php endforeach; wp_reset_query(); ?>
                </ul>
            </div>

            <!-- Categories Widget -->
            <div class="ekwa-sidebar-widget ekwa-sidebar-categories">
                <h3>Categories</h3>
                <div>
                    <?php
                    $categories = get_categories( array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 10,
                        'exclude' => get_cat_ID( 'Uncategorized' )
                    ) );
                    foreach ( $categories as $category ) :
                    ?>
                        <a href="<?php echo get_category_link( $category->term_id ); ?>">
                            <?php echo esc_html( $category->name ); ?> (<?php echo $category->count; ?>)
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
    </div><!-- .ekwa-single-layout -->
</div><!-- .ekwa-single-wrapper -->

<?php get_footer(); ?>