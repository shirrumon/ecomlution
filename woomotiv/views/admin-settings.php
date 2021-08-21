<?php
/**
 * Admin View: Settings
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="ro">
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/multi/sidebar.php'); ?>

    <div class="wrap">
        <div class="dlb_panel" data-tab="<?php echo $currentTab['slug']; ?>" >

            <?php echo $navMarkup; ?>

            <div class="dlb_panel_content">
                <form class="dlb_form" method="post" enctype="multipart/form-data">

                    <?php echo $currentTabContent; ?>

                    <p class="submit">
                        <button name="save" class="button-primary" type="submit">
                            <?php esc_html_e( 'Save changes', 'woomotiv' ); ?>
                        </button>

                    </p>

                    <input type="hidden" name="woomotiv_nonce" value="<?php echo wp_create_nonce('woomotiv')?>">

                </form>
            </div>

        </div>
    </div>
</div>

<style>
    .ro{
        display: inline-flex;
    }

    .wrap{
        margin-left: 1%;
    }
</style>