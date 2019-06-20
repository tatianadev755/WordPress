<h1>Selling Process Calculator</h1>
<hr>
<?php settings_errors( 'edd-notices' ); ?>
  <form method="post" action="options.php">
    <?php 
      global $wpdb;
      $settings = $wpdb->get_results( "SELECT * FROM wp_sp_calculator_settings WHERE id = 1" );
      $heading = $settings[0]->heading;
      $instruction = $settings[0]->instruction;
    ?>
    <h3 style="font-weight:normal;font-style:italic">Calculator Page Title: </h3>
    <input name="sp_calculator_page_heading" style="min-width:40%;max-width:350px;padding:10px;" placeholder=" Type calculator page heading here " value="<?php echo $heading; ?>" />
    <br><br>
    <input type="hidden" name="sp_calculator_settings" value="true" />
    <h3 style="font-weight:normal;font-style:italic">Calculator Instruction : </h3>
    <textarea name="sp_calculator_instruction" style="min-width:40%;max-width:350px;min-height:100px;padding:10px;" placeholder=" Type calculator instruction here "><?php echo $instruction; ?></textarea>
    <?php submit_button(); ?>
  </form>