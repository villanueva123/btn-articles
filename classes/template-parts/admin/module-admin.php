<div id="module-actions-row">
    <a id="<?php echo $tab_data; ?>-toggle" href="#" class="page-title-action wpat-toggle-add-new-form" role="button" aria-expanded="false">
        <span class="upload"><?php echo $tab_text; ?></span>
    </a>
</div>

<div class="wpat-add-new-form-wrap" aria-hidden="true">
   <div class="wpat-add-new-form-wrap-inner">
		<fieldset id="<?php echo $tab_data; ?>-form" method="post" class="wpat-add-new-form"></fieldset>
	</div>
</div>

<fieldset class="wpat-admin-form wpat-post-type" data-screen="<?php echo $this->post_type; ?>">
    <div id="module-settings-table" class="wpat_admin_table wpat_tabbed_table">
        <div class="wpat_option_tabs"></div>
        <div class="wpat_option_panels"></div>
    </div>
</fieldset>