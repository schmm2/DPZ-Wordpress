<div id="footer">

    <?php
    wp_footer();

    // Get 'adress' posts
    $adress_posts = get_posts( array(
        'post_type' => 'adress',
        'posts_per_page' => -1, // Unlimited posts
        'orderby' => 'date', // Order alphabetically by name
    ));

    foreach ($adress_posts as $post_index => $post):

        $title = $post->post_title;
        $street = get_post_meta( get_the_ID(), '_dpz_contact_business_street', true );
        $city   = get_post_meta( get_the_ID(), '_dpz_contact_business_city', true );
        $phone = get_post_meta( get_the_ID(), '_dpz_contact_business_phone', true );
        $email = get_post_meta( get_the_ID(), '_dpz_contact_business_email', true );

    endforeach;

    if(!is_home() && !is_search()):?>

        <div id='footer-content' class='content-center'>
            <div id="sites">
                <h3>Seiten</h3>
                <?php
                    $options =  array(
                    'echo'              => true,
                    'theme_location'    => 'nav-header',
                    'items_wrap'        => '<ul id="%1$s">%3$s</ul>',
                    'menu_class'        => false,
                    'menu_id'           => false,
                    'container'         => false,
                    'container_class'   => false,
                    'container_id'      => false,
                    'before'            => false,
                    'after'             => false
                    );
                    wp_nav_menu($options);
                ?>
            </div>
            <div id="socialMedia">
                <h3>Social Media</h3>

                <?php
                $options =  array(
                    'echo'              => true,
                    'theme_location'    => 'nav-socialLinks',
                    'items_wrap'        => '<ul id="%1$s">%3$s</ul>',
                    'fallback_cb'     	=> false,
                    'menu_class'        => false,
                    'menu_id'           => false,
                    'container'         => false,
                    'container_class'   => false,
                    'container_id'      => false,
                    'before'            => false,
                    'after'             => false,
                    'walker'			=> new dpz_socialLink_walker_nav_menu
                );
                ?>

                <div id='socialLinks'>
                    <?php wp_nav_menu($options) ?>
                </div>
            </div>

            <div id="adress">
                <h3>Addresse</h3>
                <p>
                    <?php echo $title ?><br>
                    <?php echo $street ?><br>
                    <?php echo $city ?><br>
                </p>
                <p>
                    Telefon: <? echo $phone ?><br>
                    E-Mail: <? echo $email ?>
                </p>
            </div>

            <?php if(!is_page_template('page-contact.php')): ?>
                <div id="contactForm-container">
                    <h3>Schreib uns!</h3>
                    <? get_template_part( 'part', 'contactForm' );	?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif ?>
</div>
</body>
</html>