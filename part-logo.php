<?php if (get_theme_mod( 'dpz_logo' ) || file_exists( TEMPLATEPATH . '/css/img/logo.png' ))  : ?>
    <a class='logo-link' href="<?php echo get_option('home'); ?>">
        <?php if (get_theme_mod( 'dpz_logo' )): ?>
            <img src="<?php echo get_theme_mod( 'dpz_logo' ) ?>" alt="<?php bloginfo('name'); ?>" />
        <?php elseif  ( file_exists( TEMPLATEPATH . '/css/img/logo.png' ) ): ?>

                <img src="<?php echo get_template_directory_uri(); ?>/css/img/logo.png" alt="<?php bloginfo('name'); ?>" />

        <?php endif; ?>
        <p id='logo-siteName'><?php bloginfo('name'); ?></p>
    </a>
<?php else : ?>
    <a href="<?php echo home_url(); ?>">
        <p id='logo-siteName'><?php bloginfo('name'); ?></p>
    </a>
<? endif; ?>
