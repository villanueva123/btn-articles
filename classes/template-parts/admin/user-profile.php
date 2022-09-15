<fieldset id="toolkit-profile">

  <h2 class="inline"><?php echo __('Toolkit Credit Info', 'btn-lms'); ?></h2>

  <a id="<?php echo $this->new_form_toggle_id; ?>" href="#" class="page-title-action wpat-toggle-add-new-form" role="button" aria-expanded="false">
      <span class="upload">
          <?php echo __( 'Update Credit Info', 'btn-lms' ); ?>
      </span>
  </a>

  <div class="wpat-add-new-form-wrap" aria-hidden="true">
      <div class="wpat-add-new-form-wrap-inner">
          <div id="<?php echo $this->new_form_id; ?>" class="wpat-add-new-form">
          </div>
      </div>
  </div>

  <div class="wpat_notice_wrap"></div>


  <table class="form-table">
      <tr class="user-toolkit_credits-wrap">
          <th>
              <label for="toolkit_credits">
                  <?php echo __('Current Credits', 'btn-lms'); ?>
              </label>
          </th>
          <td>
              <input type="text" name="toolkit_credits" id="toolkit_credits" value="<?php echo $this->data['credits']; ?>" class="regular-text" readonly="true">
              <button id="edit-credits-button" class="button aos-log-trigger">
                  <span class="dashicons dashicons-post-status"></span>
              </button>
          </td>
      </tr>
      <tr class="user-toolkit_renewal-wrap">
          <th>
              <label for="toolkit_renewal">
                  <?php echo __('Renewal Date', 'btn-lms'); ?>
              </label>
          </th>
          <td>
              <input type="text" name="toolkit_renewal" id="toolkit_renewal" value="<?php echo $this->renewal_date; ?>" class="regular-text" readonly="true">
              <button id="edit-renewal-button" class="button aos-log-trigger">
                  <span class="dashicons dashicons-calendar"></span>
              </button>
          </td>
      </tr>
  </table>

  <div id="toolkit-profile-log">
      <div id="toolkit-profile-log-console">
          <div id="<?php echo $this->log_window;?>"></div>
      </div>
  </div>

</fieldset>
