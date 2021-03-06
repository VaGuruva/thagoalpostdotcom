<div class="wrap">

	<h2>Modify Push for Basket </h2>
	<br class="clear"/>

	<form id="planet-feed-form" name="planet-feed" method="get" class="validate">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
		<input type="hidden" name="action" value="update-push">
		<?php wp_nonce_field(@$this->template->form['action'], '_wpnonce_' . @$this->template->form['action']); ?>

		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row" valign="top">
					<label for="planet_is_active">Basket Active (to process XML)</label>
				</th>
				<td>
					<?php $is_active = (@$current_basket['is_active']) ? ' checked= "checked" ' : '' ?>
					<input type="checkbox" <?php echo $is_active ?> value="1" name="planet_is_active">
				</td>
			</tr>
			<tr class="post_types_row">
				<th scope="row" valign="top"><label for="planet_post_type"><?php _e('Post Type'); ?></label></th>
				<td>
					<section>
						<?php $post_types = get_post_types(array(
							'public'   => true,
							'_builtin' => false
						), 'names');
						$post_types['post'] = 'post';
						?>
						<select name="planet_post_type" id="planet_post_type" style="width:200px;">
							<option value=""><?php _e('None'); ?></option>
							<?php foreach ($post_types as $post_type): ?>
								<?php $taxonomies = get_object_taxonomies($post_type); ?>
								<?php if ( !in_array($post_type, array('page', 'attachment', 'revision', 'nav_menu_item'))  ): ?>
									<?php $post_type_object = get_post_type_object($post_type); ?>
									<option value="<?php echo $post_type; ?>"><?php echo ucwords($post_type_object->labels->name); ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</section>
					<p><?php _e('This will help determine what type of categories you would like to select.'); ?></p>
				</td>
			</tr>

			<tr class="post_type_taxonomies_row">
				<th scope="row" valign="top"><label for=""><?php _e('Post Type'); ?></label></th>
				<td>
					<section></section>
				</td>
			</tr>
			<tr class="form-field post_type_categories_row">
				<th scope="row" valign="top"><label for=""><?php _e('Post Type'); ?></label></th>
				<td>
					<section>

					</section>
					<p><?php _e('Multiple categories may be selected for each feed.
					To select another category, click on the field above and scroll to the item and select it, or
					start typing the category if you know the name.  All selected categories will be displayed in the field
					above side-by-side.  If you would like to remove a category, simply click the "x" on the right of the
					category name.'); ?></p>
				</td>
			</tr>
			</tbody>
		</table>
		<?php echo submit_button(__(@$this->template->form['submit'])); ?>
	</form>

</div>

<script type="text/javascript" src="<?php echo plugins_url('jquery.validate.min.js', __FILE__); ?>"></script>


<script type="text/javascript">
	jQuery(document).ready(function () {

		// Post Type Selection
		jQuery("form[name=planet-feed] select[name=planet_post_type]").chosen({disable_search_threshold: 10});
		jQuery('form[name=planet-feed] select[name=planet_post_type]').on('change', function (e) {
			// Run Validation
			//jQuery(this).valid();

			// Let's hide the option sections
			jQuery('tr.post_type_taxonomies_row').hide();
			jQuery('tr.post_type_categories_row').hide();

			// Now let's get the new sections
			if ('' !== jQuery(this).val()) {
				jQuery(this).parent().append(jQuery.spinner_html);
				jQuery.get(
					ajaxurl,
					{
						'action': 'get_post_type_categories',
						'post_type': jQuery(this).val()
					},
					function (response) {
						// Remove Spinner
						jQuery('tr.post_types_row span.planet-tools-spinner').remove();

						// Set all data
						row_class = (response.single === true) ? 'post_type_categories_row' : 'post_type_taxonomies_row';
						jQuery('tr.' + row_class + ' th label').empty().html(response.title);
						jQuery('tr.' + row_class + ' td section').empty().html(response.select);
						jQuery('tr.' + row_class).show();

						// Activate this shit
						if (response.single === true) {
							jQuery('tr.' + row_class + ' td select').attr('multiple', true);
							jQuery.activateCategorySelect();
						}
						else {
							jQuery.activateTaxParent();
						}
					}, 'json'
				);
			}
		});
	});
	jQuery.extend({
		spinner_html: '<span class="planet-tools-spinner"><img style="vertical-align: middle !important;" src="<?php echo plugins_url('../img/spinner.gif', __FILE__); ?>" /></span>',
		activateTaxParent: function () {
			jQuery("form[name=planet-feed] select[name=planet_taxonomy_parent]").chosen({disable_search_threshold: 10});
			jQuery('form[name=planet-feed] select[name=planet_taxonomy_parent]')
				.unbind('change')
				.on('change', function (e) {
					// Run Validation
					//jQuery(this).valid();

					// Let's remove open sections
					jQuery('tr.post_type_categories_row').hide();

					// Let's load some data
					if ('0' !== jQuery(this).val()) {
						jQuery(this).parent().append(jQuery.spinner_html);
						jQuery.get(
							ajaxurl,
							{
								'action': 'get_post_type_categories',
								'post_type': jQuery(this).attr('data-post-type'),
								'post_taxonomy': jQuery(this).val()
							},
							function (response) {
								// Remove spinner
								jQuery('tr.post_type_taxonomies_row span.planet-tools-spinner').remove();

								// Set Data
								if (response.single === true) {
									jQuery('tr.post_type_categories_row th label').empty().html(response.title);
									jQuery('tr.post_type_categories_row td section').empty().html(response.select);
									jQuery('tr.post_type_categories_row td select').attr('multiple', true);
									jQuery('tr.post_type_categories_row').show();
									jQuery.activateCategorySelect();
								}
								else {
									content = '<?php echo addslashes(__('Something went wrong while trying to get the categories')); ?>';
									jQuery('tr.post_type_categories_row th label').empty();
									jQuery('tr.post_type_categories_row td').empty().html(content);
									jQuery('tr.post_type_categories_row').show();
								}
							}, 'json'
						);
					}
				});
		},
		activateCategorySelect: function () {
			jQuery("form[name=planet-feed] select#planet_category_parent_select").chosen({disable_search_threshold: 10});
		}
	});
</script>