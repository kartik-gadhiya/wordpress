<?php
/* Template Name: Loan Application Page */
/**
 * Custom page template for the multi-step loan application form.
 * Preserves the existing Finspire theme header, navigation, and footer.
 *
 * @package Finspire Child
 */

get_header();
?>

<main id="primary" class="site-main finspire-loan-page-content" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
