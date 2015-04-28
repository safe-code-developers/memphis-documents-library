<?php
function mdocs_the_list($att=null) {
	global $post, $current_cat_array, $parent_cat_array;
	ob_start();
	if(is_admin()) $page_type = 'dashboard';
	else $page_type = 'site';
	$is_read_write = mdocs_check_read_write();
	if($is_read_write) {
		$site_url = site_url();
		$upload_dir = wp_upload_dir();	
		$mdocs = get_option('mdocs-list');
		$cats =  get_option('mdocs-cats');
		$current_cat = mdocs_get_current_cat($att);
		if(isset($att['cat']) && $att['cat'] != 'All Files'  && !isset($_GET['mdocs-cat'])) {
			foreach($cats as $cat) {
				if($att['cat'] == $cat['name']) { $current_cat = $cat['slug']; break; }
			}
			mdocs_list_header(false);
		} elseif(isset($att['cat']) && $att['cat'] == 'All Files') { $current_cat = 'all'; mdocs_list_header(false); }
		elseif(!isset($att['cat'])) mdocs_list_header();
		$permalink = get_permalink($post->ID);
		if(preg_match('/\?page_id=/',$permalink) || preg_match('/\?p=/',$permalink)) {
			$mdocs_get = $permalink.'&mdocs-cat=';
		} else $mdocs_get = $permalink.'?mdocs-cat=';
		mdocs_get_children_cats(get_option('mdocs-cats'),$current_cat);
		$mdocs_sort_type = get_option('mdocs-sort-type');
		$mdocs_sort_style = get_option('mdocs-sort-style');
		if(isset($_COOKIE['mdocs-sort-type'])) $mdocs_sort_type = $_COOKIE['mdocs-sort-type'];
		if(isset($_COOKIE['mdocs-sort-range'])) $mdocs_sort_style = $_COOKIE['mdocs-sort-range'];
		if($mdocs_sort_style == 'desc') $mdocs_sort_style_icon = ' <i class="fa fa-chevron-down"></i>';
		else $mdocs_sort_style_icon = ' <i class="fa fa-chevron-up"></i>';
	?>
	<div class="mdocs-container">	
		<?php if(isset($att['header'])) echo '<p>'.__($att['header']).'</p>'; ?>
		<?php
		$mdocs = mdocs_array_sort($mdocs, $mdocs_sort_type, $mdocs_sort_style);
		$count = 0;
		if(get_option('mdocs-list-type') == 'small') echo '<table class="table table-hover table-condensed mdocs-list-table">';
		?>
		<tr class="hidden-sm hidden-xs">
		<th class="mdocs-sort-option" data-sort-type="name" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Name','mdocs'); ?><?php if($mdocs_sort_type == 'name') echo $mdocs_sort_style_icon; ?></th>
		<?php if(get_option('mdocs-show-downloads')) { ?>
		<th class="mdocs-sort-option" data-sort-type="downloads" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Downloads','mdocs'); ?><?php if($mdocs_sort_type == 'downloads') echo $mdocs_sort_style_icon; ?></th><?php } ?>
		<?php if(get_option('mdocs-show-version')) { ?>
		<th class="mdocs-sort-option" data-sort-type="version" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Version','mdocs'); ?><?php if($mdocs_sort_type == 'version') echo $mdocs_sort_style_icon; ?></th><?php } ?>
		<?php if(get_option('mdocs-show-author')) { ?>
		<th class="mdocs-sort-option" data-sort-type="owner" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Owner','mdocs'); ?><?php if($mdocs_sort_type == 'owner') echo $mdocs_sort_style_icon; ?></th><?php } ?>
		<?php if(get_option('mdocs-show-update')) { ?>
		<th class="mdocs-sort-option" data-sort-type="modified" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Last Modified','mdocs'); ?><?php if($mdocs_sort_type == 'modified') echo $mdocs_sort_style_icon; ?></th><?php } ?>
		<?php if(get_option('mdocs-show-ratings')) { ?>
		<th class="mdocs-sort-option" data-sort-type="rating" data-current-cat="<?php echo $current_cat; ?>" data-permalink="<?php echo $permalink; ?>"><?php _e('Rating','mdocs'); ?><?php if($mdocs_sort_type == 'rating') echo $mdocs_sort_style_icon; ?></th><?php } ?>
		</tr>
		<?php
		// SUB CATEGORIES
		if(isset($current_cat_array['children']) && !isset($att['cat'])) $num_cols = mdocs_get_subcats($current_cat_array, $parent_cat_array);
		//else $num_cols = mdocs_get_subcats($current_cat_array, $parent_cat_array, false);
		foreach($mdocs as $index => $the_mdoc) {
			if($the_mdoc['cat'] == $current_cat || $current_cat == 'all') {
				if($the_mdoc['file_status'] == 'public' || is_admin()) {
					$count ++;
					$mdocs_post = get_post($the_mdoc['parent']);
					$mdocs_desc = apply_filters('the_content', $mdocs_post->post_excerpt);
					
					if(get_option('mdocs-list-type') == 'small') {
						mdocs_file_info_small($the_mdoc, $page_type, $index, $current_cat); 
					} else {
						$user_logged_in = is_user_logged_in();
						$mdocs_hide_all_files = get_option( 'mdocs-hide-all-files' );
						$mdocs_hide_all_files_non_members = get_option( 'mdocs-hide-all-files-non-members' );
						if($mdocs_hide_all_files_non_members && $user_logged_in == false) $show_files = false;
						elseif($mdocs_hide_all_files == false ) $show_files = true;
						else $show_files = false;
						if( $show_files) {
							?>
							<div class="mdocs-post">
								<?php mdocs_file_info_large($the_mdoc, 'site', $index, $current_cat); ?>
								<div class="mdocs-clear-both"></div>
								<?php mdocs_social($the_mdoc); ?>
							</div>
							<div class="mdocs-clear-both"></div>
							<?php mdocs_des_preview_tabs($the_mdoc); ?>
							<div class="mdocs-clear-both"></div>
							</div>
							<?php
						}
					}
				}
			} 
		}
		if($count == 0) {
			?><tr><td colspan="<?php echo $num_cols; ?>"><p class="mdocs-nofiles" ><?php _e('No files found in this folder.','mdocs'); ?></p></td></tr><?php
		}
		if(get_option('mdocs-list-type') == 'small') echo '</table></div>';
	} else mdocs_errors(__('Unable to create the directory "mdocs" which is needed by Memphis Documents Library. Its parent directory is not writable by the server?','mdocs'),'error');
	echo '</div>';
	$the_list = ob_get_clean();
	return $the_list;
}
?>