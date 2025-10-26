<?php
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    die();
}

get_header();
?>

<style>
/* Blog Roll Premium Layout */
.ekwa-blog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.ekwa-blog-header {
    text-align: center;
    margin-bottom: 60px;
    padding-bottom: 30px;
    border-bottom: 2px solid var(--color_two);
}

.ekwa-blog-header h1 {
    color: var(--color_headings);
    font-size: 48px;
    margin-bottom: 15px;
    font-weight: 700;
}

.ekwa-blog-header p {
    color: var(--color_text);
    opacity: 0.8;
    font-size: 18px;
}

.ekwa-blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 40px;
    margin-bottom: 60px;
}

.ekwa-blog-card {
    background: var(--color_invert);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.ekwa-blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    border-color: var(--color_two);
}

.ekwa-blog-card-image {
    position: relative;
    width: 100%;
    height: 240px;
    overflow: hidden;
    background: var(--color_three);
}

.ekwa-blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.ekwa-blog-card:hover .ekwa-blog-card-image img {
    transform: scale(1.1);
}

.ekwa-blog-card-category {
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--color_two);
    color: var(--color_invert);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ekwa-blog-card-content {
    padding: 30px;
}

.ekwa-blog-card-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 13px;
    color: var(--color_text);
    opacity: 0.7;
}

.ekwa-blog-card-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.ekwa-blog-card-meta svg {
    width: 14px;
    height: 14px;
    fill: var(--color_two);
}

.ekwa-blog-card h2 {
    font-size: 24px;
    line-height: 1.4;
    margin-bottom: 15px;
    font-weight: 700;
}

.ekwa-blog-card h2 a {
    color: var(--color_headings);
    text-decoration: none;
    transition: color 0.3s ease;
}

.ekwa-blog-card h2 a:hover {
    color: var(--color_two);
}

.ekwa-blog-card-excerpt {
    color: var(--color_text);
    opacity: 0.8;
    line-height: 1.7;
    margin-bottom: 20px;
}

.ekwa-blog-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.ekwa-blog-card-author {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ekwa-blog-card-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid var(--color_two);
}

.ekwa-blog-card-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ekwa-blog-card-author-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--color_text);
}

.ekwa-blog-card-read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--color_link);
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: gap 0.3s ease;
}

.ekwa-blog-card-read-more:hover {
    color: var(--color_link_hover);
    gap: 12px;
}

.ekwa-blog-card-read-more svg {
    width: 16px;
    height: 16px;
    fill: currentColor;
}

.ekwa-blog-no-posts {
    text-align: center;
    padding: 80px 20px;
}

.ekwa-blog-no-posts h2 {
    font-size: 32px;
    margin-bottom: 15px;
    color: var(--color_headings);
}

.ekwa-blog-no-posts p {
    color: var(--color_text);
    opacity: 0.7;
}

.ekwa-blog-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 60px;
}

.ekwa-blog-pagination a,
.ekwa-blog-pagination span {
    min-width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--color_two);
    border-radius: 8px;
    color: var(--color_text);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.ekwa-blog-pagination a:hover {
    background: var(--color_two);
    color: var(--color_invert);
    transform: translateY(-2px);
}

.ekwa-blog-pagination .current {
    background: var(--color_two);
    color: var(--color_invert);
}

@media (max-width: 768px) {
    .ekwa-blog-container {
        padding: 40px 15px;
    }

    .ekwa-blog-header h1 {
        font-size: 36px;
    }

    .ekwa-blog-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .ekwa-blog-card-content {
        padding: 20px;
    }

    .ekwa-blog-card h2 {
        font-size: 20px;
    }
}
</style>

<div class="ekwa-blog-container">
    <div class="ekwa-blog-header">
        <h1><?php bloginfo('name'); ?> Blog</h1>
        <p><?php bloginfo('description'); ?></p>
    </div>

    <?php if ( have_posts() ) : ?>
        <div class="ekwa-blog-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('ekwa-blog-card'); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="ekwa-blog-card-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) :
                            ?>
                                <span class="ekwa-blog-card-category"><?php echo esc_html( $categories[0]->name ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="ekwa-blog-card-content">
                        <div class="ekwa-blog-card-meta">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M152 64h144V24c0-13.3 10.7-24 24-24s24 10.7 24 24v40h40c35.3 0 64 28.7 64 64v320c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128c0-35.3 28.7-64 64-64h40V24C104 10.7 114.7 0 128 0s24 10.7 24 24v40zM48 192v256c0 8.8 7.2 16 16 16h320c8.8 0 16-7.2 16-16V192H48z"/></svg>
                                <?php echo get_the_date(); ?>
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zm0 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208-93.3 208-208 208zm0-352c-13.2 0-24 10.8-24 24v136c0 6.4 2.5 12.5 7 17l80 80c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L280 262.1V136c0-13.2-10.8-24-24-24z"/></svg>
                                <?php echo esc_html( get_the_time( 'g:i A' ) ); ?>
                            </span>
                        </div>

                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                        <div class="ekwa-blog-card-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                        </div>

                        <div class="ekwa-blog-card-footer">
                            <div class="ekwa-blog-card-author">
                                <div class="ekwa-blog-card-avatar">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 36 ); ?>
                                </div>
                                <span class="ekwa-blog-card-author-name"><?php the_author(); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="ekwa-blog-card-read-more">
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 278.6l-160 160c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25L338.8 288H32C14.33 288 .0016 273.7 .0016 256S14.33 224 32 224h306.8l-105.4-105.4c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160C451.1 245.9 451.1 266.1 438.6 278.6z"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php
        // Pagination
        $pagination = paginate_links( array(
            'type'      => 'array',
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ) );

        if ( $pagination ) :
        ?>
            <div class="ekwa-blog-pagination">
                <?php foreach ( $pagination as $page ) : ?>
                    <?php echo $page; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="ekwa-blog-no-posts">
            <h2>No Posts Found</h2>
            <p>Sorry, there are no blog posts to display at this time.</p>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
