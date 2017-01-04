<div class="wrap">

	<h2>Add Push Basket </h2>
	<br class="clear"/>

	<form id="planet-feed-form" name="planet-push" method="get" class="validate">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
		<input type="hidden" name="action" value="add-push">
		<?php wp_nonce_field(@$this->template->form['action'], '_wpnonce_' . @$this->template->form['action']); ?>

		<table class="form-table">
			<tbody>
			<tr class="post_types_row">
				<th scope="row" valign="top"><label for="planet_post_type"><?php _e('Basket Display Name'); ?></label></th>
				<td>
					<input name="name" type="text" id="name" value="" class="regular-text">
					<p><?php _e('Basket display name for easy reference.'); ?></p>
				</td>
			</tr>			
			<tr class="post_types_row">
				<th scope="row" valign="top"><label for="planet_post_type"><?php _e('TTCMS Basket ID'); ?></label></th>
				<td>
					<input name="ttcms_id" type="text" id="ttcms_id" value="" class="regular-text">
					<p><?php _e('This is the basket ID from TTCMS that we will map.'); ?></p>
				</td>
			</tr>
			</tbody>
		</table>
		<?php echo submit_button(__(@$this->template->form['submit'])); ?>
	</form>

</div>

<script type="text/javascript" src="<?php echo plugins_url('jquery.validate.min.js', __FILE__); ?>"></script>