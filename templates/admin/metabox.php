<div class="form-field">
    <table id="article-content-sub-heading"  class="form-table">
        <tbody>
            <tr>
                <th>
                    <label for="<?php echo $sub_heading_key?>"><?php _e('Sub Heading', 'btn-articles'); ?></label>
                </th>
                <td class="field-right">
                    <?php
                    $sub_heading_args = [
                        'type'      => 'input',
                        'subtype'	  => 'text',
                        'id'	  => $sub_heading_key,
                        'name'	  => $sub_heading_key,
                        'value_type'=>'normal',
                        'wp_data' => 'post_meta',
                        'post_id'=> $post_id
                      ];
                    echo $this->render_field_setting($sub_heading_args);
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="form-field">
    <table id="article-content-<?php echo $sponsored_content_key?>"  class="form-table">
        <tbody>
            <tr>
                <th>
                    <label for="<?php echo $sponsored_content_key?>"><?php _e('Sponsored Content', 'btn-articles'); ?></label>
                </th>
                <td class="field-right">

                  <select class="sponsored-content-selector" name="<?php echo $sponsored_content_key;?>">
                    <option value="">Select Sponsored Content</option>
                    <?php
                      foreach( $sponsored_selector_data as $option ){
                            $id = $option['value'];
                            $selected = ($id == $sponsored_content)? 'selected': '';
                            echo "<option value=\"{$id}\" {$selected}>{$option['title']}</option>";
                      }
                    ?>
                  </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>
