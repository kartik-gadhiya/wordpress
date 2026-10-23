<?php
/**
 * Footer Main File.
 *
 * @package FINSPIRE
 * @author  Themekalia
 * @version 1.0
 */
 $options = finspire_WSH()->option(); 
global $wp_query;
$page_id = ( $wp_query->is_posts_page ) ? $wp_query->queried_object->ID : get_the_ID();
?>

        <div class="clearfix"></div>
    
        <?php finspire_template_load( 'templates/footer/footer.php', compact( 'page_id' ) );?>
    
	
    <?php if( $options->get( 'show_scroltop' ) != true ):?>
    <button class="scroll-top scroll-to-target" data-target="html">
		<i class="flaticon-up"></i>
	</button>
	<?php endif; ?>

    </div>
    <!--End main-page-wrapper-->

<?php wp_footer(); ?>
</body>
</html>
