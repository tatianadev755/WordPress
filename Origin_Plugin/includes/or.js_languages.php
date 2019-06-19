<script type="text/javascript">
var or_js_languages = {
acc:'<?php _e( 'Access Denied!', 'originbuilder' ); ?>',
save:'<?php _e( 'Save Changes', 'originbuilder' ); ?>',
cancel:'<?php _e( 'Cancel', 'originbuilder' ); ?>',
sure:'<?php _e( 'Are you sure?', 'originbuilder' ); ?>',i01:'<?php _e( 'The changes you made will be lost if you navigate away from this page.', 'originbuilder' ); ?>',i02:'<?php _e( 'Add Elements', 'originbuilder' ); ?>',i03:'<?php _e( 'Search by Name', 'originbuilder' ); ?>',i04:'<?php _e( 'Sorry! No Web Storage support.', 'originbuilder' ); ?>',i05:'<?php _e( 'Your clipboard is currently empty, please copy elements before pasting.', 'originbuilder' ); ?>',i06:'<?php _e( 'No items selected', 'originbuilder' ); ?>',i07:'<?php _e( 'Select one method', 'originbuilder' ); ?>',i08:'<?php _e( 'Push to selected Section', 'originbuilder' ); ?>',i09:'<?php _e( 'Replace selected Section', 'originbuilder' ); ?>',i10:'<?php _e( 'These fields cannot be empty', 'originbuilder' ); ?>',i11:'<?php _e( 'Title', 'originbuilder' ); ?>',i12:'<?php _e( 'Category', 'originbuilder' ); ?>',i13:'<?php _e( 'Whoops, looks like something went wrong.', 'originbuilder' ); ?>',i14:'<?php _e( 'Are you sure? You did not upload screenshot.', 'originbuilder' ); ?>',i15:'<?php _e( 'The screenshot helps you easily know the contents of section.', 'originbuilder' ); ?>',i16:'<?php _e( 'Are you sure? All sections of this profile will also be deleted.', 'originbuilder' ); ?>',i17:'<?php _e( 'Please enter the new name', 'originbuilder' ); ?>',i18:'<?php _e( 'File type must be .mini', 'originbuilder' ); ?>',i19:'<?php _e( 'The File APIs are not fully supported in this browser.', 'originbuilder' ); ?>',i20:'<?php _e( 'Error! Data structure has been broken.', 'originbuilder' ); ?>',i21:'<?php _e( 'Processing...', 'originbuilder' ); ?>',i22:'<?php _e( 'Successful', 'originbuilder' ); ?>',i23:'<?php _e( 'Are you sure? Once it is deleted, you can not able to restore.', 'originbuilder' ); ?>',i24:'<?php _e( 'Undo Delete', 'originbuilder' ); ?>',i25:'<?php _e( 'Attribute Name', 'originbuilder' ); ?>',i26:'<?php _e( 'Add New', 'originbuilder' ); ?>',i27:'<?php _e( 'Box Style', 'originbuilder' ); ?>',i28:'<?php _e( 'CSS Code', 'originbuilder' ); ?>',i29:'<?php _e( 'or Box - HTML Code', 'originbuilder' ); ?>',i30:'<?php _e( 'or Box - CSS Code', 'originbuilder' ); ?>',i31:'<?php _e( 'Notice:CSS must contain selectors.', 'originbuilder' ); ?>',i32:'<?php _e( 'Beautifier', 'originbuilder' ); ?>',i33:'<?php _e( 'Search Results:', 'originbuilder' ); ?>',i34:'<?php _e( 'The key you entered was not found.', 'originbuilder' ); ?>',i35:'<?php _e( 'Content Saving...', 'originbuilder' ); ?>',i36:'<?php _e( 'Push your content', 'originbuilder' ); ?>',i37:'<?php _e( 'Notice:The content below is the latest that you copied.', 'originbuilder' ); ?>',i38:'<?php _e( 'Your ClipBoard is currently empty. Please copy row or element before pasting!', 'originbuilder' ); ?>',i39:'<?php _e( 'Could not find mapping for this element.', 'originbuilder' ); ?>',i40:'<?php _e( 'Storage of row in profile.', 'originbuilder' ); ?>',i41:'<?php _e( 'Could not find mapping for this element.', 'originbuilder' ); ?>',i42:'<?php _e( 'Set number of columns per row.', 'originbuilder' ); ?>',i43:'<?php _e( 'Could not find mapping for this element.', 'originbuilder' ); ?>',i44:'<?php _e( 'Notice:Do not include selectors. Example:', 'originbuilder' ); ?> <span style="color:green"> color:red; </span> , <span style="text-decoration:line-through;color:red"> #id{color:red;} </span>',i45:'<?php _e( 'Could not find mapping for this element.', 'originbuilder' ); ?>',i46:'<?php _e( 'Choose Images', 'originbuilder' ); ?>',i47:'<?php _e( '', 'originbuilder' ); ?>',i48:'<?php _e( 'Error:Post ID not found.', 'originbuilder' ); ?>',i49:'<?php _e( 'Error:Post type not found.', 'originbuilder' ); ?>',i50:'<?php _e( 'The data has been updated to live view (ESC to close)', 'originbuilder' ); ?>',i51:'<?php _e( 'Please save or submit first!', 'originbuilder' ); ?>',i52:'<?php _e( 'Live Preview', 'originbuilder' ); ?>',i53:'<?php _e( '\nOrigin Bulider Warning: \n\nThe content is empty. Are you sure that you want to save the empty content?\n', 'originbuilder' ); ?>',i54:'<?php _e( '\norigincomposer Warning: \n\nMaximum 10 columns. Could not double the column\n', 'originbuilder' ); ?>',
}
</script>
<div style="display:none;" id="or-storage-prepare">
	<div id="or-css-box-test"></div>
</div>
<div id="or-ui-handle-image">
<svg xmlns="http://www.w3.org/2000/svg" width="90" height="52" viewBox="0 0 90 52"  >
  <defs>
    <style>
      .cls-1 {
        fill: none;
        stroke: #000;
        stroke-width: 2px;
      }
    </style>
  </defs>
  <rect id="Rounded_Rectangle_3" data-name="Rounded Rectangle 3" class="cls-1" x="1" y="1" width="88" height="50" rx="5" ry="5"/>
</svg>
 </div>
<img   src="<?php echo or_URL; ?>/assets/images/drag-copy.png" id="or-ui-handle-image-copy" />

 <div id="or-undo-deleted-element" style="display:none;">
	<a href="javascript:void(0)" class="do-action">
		<i class="sl-action-undo"></i> <?php //_e('Restore deleted items', 'originbuilder'); ?>
		<span class="amount">0</span>
	</a>	
	<div id="drop-to-delete"><span></span></div>
	<i class="sl-close"></i>	
</div> 