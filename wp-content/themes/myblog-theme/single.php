<?php get_header(); ?>

<article>
    <h1><?php the_title();?></h1>
    <?php the_content();?>
</article>

<?php get_sidebar();?>

<?php get_footer();?>