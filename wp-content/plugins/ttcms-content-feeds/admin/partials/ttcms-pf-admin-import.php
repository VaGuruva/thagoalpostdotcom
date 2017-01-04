<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Import XML Entities</h2>
	<br class="clear"/>

	<form id="planet-feed-form" name="planet-feed" method="post" class="validate" enctype="multipart/form-data" action="?action=import-upload">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
		<input type="hidden" name="action" value="import-upload">
		<?php wp_nonce_field($this->template->form['action'], '_wpnonce_' . $this->template->form['action']); ?>

		<table class="form-table">
			<tbody>



			<tr class="">
				<th scope="row" valign="top"><label for="planet_post_type"><?php _e('File to upload (XML)'); ?></label></th>
				<td>
					<section>
						<input type="file" name="fileToUpload" id="fileToUpload">

					</section>
				</td>
			</tr>


			</tbody>
		</table>
		<?php echo submit_button('Upload'); ?>
	</form>
	<form id="planet-feed-form" name="planet-feed" method="post" class="validate" enctype="multipart/form-data" action="?action=import-historical-results">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
		<input type="hidden" name="action" value="import-historical-results">
		<?php wp_nonce_field($this->template->form['action'], '_wpnonce_' . $this->template->form['action']); ?>
		<table class="form-table">
			<tbody>



			<tr class="">
				<th scope="row" valign="top"><label for="planet_post_type"><?php _e('Import historical results'); ?></label></th>

			</tr>


			</tbody>
		</table>
		<?php echo submit_button('Import'); ?>
	</form>

</div>

