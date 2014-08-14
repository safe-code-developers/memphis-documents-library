<?php
function mdocs_file_info_small($the_mdoc, $page_type='site', $index=0, $current_cat) {
	global $post, $mdocs_img_types;
	$upload_dir = wp_upload_dir();
	$the_mdoc_permalink = htmlspecialchars(get_permalink($the_mdoc['parent']));
	$the_post = get_post($the_mdoc['parent']);
	$is_new = preg_match('/new=true/',$the_post->post_content);
	$post_date = strtotime($the_post->post_date);
	$last_modified = gmdate('d-m-y H:i',$the_mdoc['modified']+MDOCS_TIME_OFFSET);
	$user_logged_in = is_user_logged_in();
	$mdocs_show_non_members = $the_mdoc['non_members'];
	$mdocs_hide_all_files = get_option( 'mdocs-hide-all-files' );
	$mdocs_hide_all_posts = get_option( 'mdocs-hide-all-posts' );
	$mdocs_hide_all_files_non_members = get_option( 'mdocs-hide-all-files-non-members' );
	$mdocs_show_downloads = get_option( 'mdocs-show-downloads' );
	$mdocs_show_author = get_option( 'mdocs-show-author' );
	$mdocs_show_version = get_option( 'mdocs-show-version' );
	$mdocs_show_update = get_option( 'mdocs-show-update' );
	$mdocs_show_ratings = get_option( 'mdocs-show-ratings' );
	$mdocs_show_new_banners = get_option('mdocs-show-new-banners');
	$mdocs_time_to_display_banners = get_option('mdocs-time-to-display-banners');
	$mdocs_default_content = get_option('mdocs-default-content');
	$mdocs_show_description = get_option('mdocs-show-description');
	$mdocs_show_preview = get_option('mdocs-show-preview');
	if(isset($post)) $permalink = get_permalink($post->ID);
	else $permalink = '';
	$mdocs_desc = apply_filters('the_content', $the_mdoc['desc']);
	$mdocs_desc = str_replace('\\','',$mdocs_desc);
	if(preg_match('/\?page_id=/',$permalink) || preg_match('/\?p=/',$permalink)) {
		$mdocs_get = $permalink.'&mdocs-cat=';
	} else $mdocs_get = $permalink.'?mdocs-cat=';
	$tooltip = '<button class="mdocs-close-btn mdocs-close-desc" onclick="mdocs_close_preview(\'wp\');">Close</button>';
	$tooltip .= '<h1>'.$the_mdoc['filename'].'</h1>';
	$tooltip .= '<div class="mdocs-divider"></div>';
	if($page_type == 'dashboard') {
		$tooltip .= __('File Status').':<b class="mdocs-olive"> '.$the_mdoc['file_status'].'</b><br>';
		$tooltip .= __('Post Status').':<b class="mdocs-salmon"> '.$the_post->post_status.'</b><br>';
		if($mdocs_hide_all_files) $tooltip .= '<br><i class="fa fa-lock mdocs-orange"></i> '.__('All Files Are Hidden');
		if($mdocs_hide_all_posts) $tooltip .= '<br><i class="fa fa-lock mdocs-red"></i> '.__('All Posts Are Hidden'); 
	}
	$tooltip .= '<p>'.$mdocs_desc.'</p>';
	$tooltip .= '<div class="mdocs-divider"></div>';
	
	
	$tooltip = htmlspecialchars($tooltip);
	
	if($mdocs_hide_all_files_non_members &&  is_user_logged_in() == false) $show_files = false;
	elseif($mdocs_hide_all_files == false || $page_type == 'dashboard') $show_files = true;
	else $show_files = false;
	if( $show_files) {
		$the_rating = mdocs_get_rating($the_mdoc);
		$file_type = wp_check_filetype($the_mdoc['filename']);
		if(file_exists(plugin_dir_path( __FILE__ ).'assets/imgs/filetype-icons/'.$file_type['ext'].'.png'))  $file_icon = '<img src="'.plugins_url().'/memphis-documents-library/assets/imgs/filetype-icons/'.$file_type['ext'].'.png" class="hidden-xs hidden-sm"/>';
		else $file_icon = '<img src="'.plugins_url().'/memphis-documents-library/assets/imgs/filetype-icons/unknow.png" />';
		//var_dump($file_icon);
		if($mdocs_show_new_banners) {
			$modified = floor($the_mdoc['modified']/86400)*86400;
			$today = floor(time()/86400)*86400;
			$days = (($today-$modified)/86400);
			if($mdocs_time_to_display_banners > $days) {
				if($is_new == true) $status_tag = MDOCS_NEW_SMALL;
				else $status_tag = MDOCS_UPDATE_SMALL;
			} else $status_tag = '';
		} else $status_tag = '';
		if ( current_user_can('read_private_posts') ) $read_private_posts = true;
		else $read_private_posts = false;
	?>
		<tr>
			<td id="title" class="mdocs-tooltip">
				<button type="button" class="btn btn-default test-pop" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">Popover on left</button>
				<?php
				
				if($page_type == 'dashboard') {
				?>
					<a href="<?php echo 'admin.php?page=memphis-documents.php&mdocs-cat='.$current_cat.'&action=update-doc&mdocs-index='.$index; ?>" ><?php echo str_replace('\\','',$the_mdoc['name']).$status_tag; ?></a>
				<?php }
				else {
					if($the_mdoc['post_status'] == 'private' && $read_private_posts == false) echo str_replace('\\','',$the_mdoc['name']).$status_tag;
					else { ?>
					<div class="btn-group">
						<a class="dropdown-toggle mdocs-title-href" data-toggle="dropdown" href="#" ><?php echo $file_icon.' '.str_replace('\\','',$the_mdoc['name']).$status_tag; ?></a>
						
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
							<li role="presentation" class="dropdown-header">File Options</li>
							<?php
								mdocs_download_rights($the_mdoc);
								mdocs_preview_rights($the_mdoc);
								mdocs_rating_rights($the_mdoc,$current_cat);
							?>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $the_mdoc_permalink; ?>" target="_blank"><i class="fa fa-arrow-circle-o-right"></i> <?php _e('Goto Post'); ?></a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-share"></i> <?php _e('Share'); ?></a></li>
							<?php if(is_admin()) { ?>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header">Admin Options</li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo 'admin.php?page=memphis-documents.php&mdocs-cat='.$current_cat.'&action=update-doc&mdocs-index='.$index; ?>"><i class="fa fa-file-o"></i> <?php _e('Manage File'); ?></a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="?page=memphis-documents.php&mdocs-cat=short-codes"><i class="fa fa-road"></i> <?php _e('Manage Versions'); ?></a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="?page=memphis-documents.php&mdocs-cat=batch"><i class="fa fa-times-circle"></i> <?php _e('Delete File'); ?></a></li>
							<?php } ?>
						  </ul>
					</div>
					<?php }} ?>
			</td>
			<?php if($mdocs_show_downloads) { ?><td id="downloads"><i class="fa fa-cloud-download"></i> <b class="mdocs-orange"><?php echo $the_mdoc['downloads'].' '.__('Downloads'); ?></b></td><?php } ?>
			<?php if($mdocs_show_version) { ?><td id="version"><i class="fa fa-power-off"></i><b class="mdocs-blue"> <?php echo $the_mdoc['version']; ?></b></td><?php } ?>
			<?php if($mdocs_show_author) { ?><td id="owner"><i class="fa fa-pencil"></i> <i class="mdocs-green"><?php echo $the_mdoc['owner']; ?></i></td><?php } ?>
			<?php if($mdocs_show_update) { ?><td id="update"><i class="fa fa-calendar"></i> <b class="mdocs-red"><?php echo $last_modified; ?></b></td><?php } ?>
			<?php
				if($mdocs_show_ratings) {
					echo '<td id="rating">';
					for($i=1;$i<=5;$i++) {
						if($the_rating['average'] >= $i) echo '<i class="fa fa-star mdocs-gold" id="'.$i.'"></i>';
						elseif(ceil($the_rating['average']) == $i ) echo '<i class="fa fa-star-half-full mdocs-gold" id="'.$i.'"></i>';
						else echo '<i class="fa fa-star-o" id="'.$i.'"></i>';
					}
					echo '</td>';
				} ?>
		</tr>
		<tr>
<?php
	}
}
?>