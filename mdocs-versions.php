<?php
function mdocs_versions() {
	$cats = get_option('mdocs-cats');
	$mdocs = get_option('mdocs-list');
	$mdoc_index = $_GET['mdocs-index'];
	$upload_dir = wp_upload_dir();
	if(isset($_GET['cat'])) $current_cat = $_GET['cat'];
	else $current_cat = $current_cat = key($cats);
	$the_mdoc = $mdocs[$mdoc_index];	
?>
<div class="mdocs-uploader-bg"></div>
<div class="mdocs-uploader">
	<h2 class="mdocs-uploader-header">
		<div class="close"><a href="<?php echo 'admin.php?page=memphis-documents.php&cat='.$current_cat; ?>"><img src='<?php echo MDOC_URL; ?>/assets/imgs/close.png'/></a></div>
		<?php echo __('Versions').': '.$the_mdoc['name']; ?>
	</h2>
	<div class="mdocs-container">
		<div class="mdocs-uploader-content">
			<form class="mdocs-uploader-form" enctype="multipart/form-data" action="<?php echo $_REQUEST['REQUEST_URI']; ?>" method="POST">
				<input type="hidden" name="mdocs-nonce" value="<?php echo MDOCS_NONCE; ?>" />
				<input type="hidden" name="mdocs-index" value="<?php echo $mdoc_index; ?>" />
				<input type="hidden" name="action" value="mdocs-update-revision" />
				<table>
					<thead>
						<tr>
							<th scope="col" class="mdocs-table-header" ><?php _e('File'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Version'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Date Modified'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Download'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Delete'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Current'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="mdocs-table-header" ><?php _e('File'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Version'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Date Modified'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Download'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Delete'); ?></th>
							<th scope="col" class="mdocs-table-header" ><?php _e('Current'); ?></th>
						</tr>
					</tfoot>
					<tbody id="the-list">
							<tr class="mdocs-bg-odd">
								<td class="mdocs-blue" id="file" ><?php echo $the_mdoc['filename']; ?></td>
								<td class="mdocs-green" id="version" ><?php echo $the_mdoc['version']; ?></td>
								<td class="mdocs-red" id="date"><?php  echo gmdate('F jS Y \a\t g:i A',filemtime($upload_dir['basedir'].'/mdocs/'.$the_mdoc['filename'])+MDOCS_TIME_OFFSET); ?></td>
								<td id="download"><input type="button" id="mdocs-download" name="<?php echo $key; ?>" class="button button-primary" value=<?php _e("Download"); ?>  /></td>
								<td></td>
								<td id="current"><input type="radio" name="mdocs-version" value="<?php echo 'current'; ?>" checked /></td>
							</tr>
						</tr>
					<?php
						$bgcolor = 'mdocs-bg-even';
						foreach( array_reverse($the_mdoc['archived']) as $key => $archive ){ 
							$file = substr($archive, 0, strrpos($archive, '-'));
							$version = substr(strrchr($archive, '-'), 2 );
							?>
							<tr class="<?php echo $bgcolor; ?>">
								<td class="mdocs-blue" id="file" ><?php echo $file; ?></td>
								<td class="mdocs-green" id="version" ><?php echo $version; ?></td>
								<td class="mdocs-red" id="date"><?php  echo gmdate('F jS Y \a\t g:i A',filemtime($upload_dir['basedir'].'/mdocs/'.$archive)+MDOCS_TIME_OFFSET); ?></td>
								<td id="download"><input onclick="mdocs_download_version('<?php echo $archive; ?>')" type="button" id="mdocs-download" name="<?php echo $key; ?>" class="button button-primary" value=<?php _e("Download"); ?>  /></td>
								<td id="download"><input onclick="mdocs_delete_version('<?php echo $archive; ?>','<?php echo $mdoc_index; ?>','<?php echo $current_cat; ?>','<?php echo MDOCS_NONCE; ?>')" type="button" id="mdocs-delete" name="<?php echo $key; ?>" class="button button-primary" value=<?php _e("Delete"); ?>  /></td>
								<td id="current"><input type="radio" name="mdocs-version" value="<?php echo count($the_mdoc['archived'])-$key-1; ?>" /></td>
							</tr>
							<?php
							if($bgcolor == "mdocs-bg-even") $bgcolor = "mdocs-bg-odd";
							else $bgcolor = "mdocs-bg-even"; 
						}
						?>
					</tbody>
				</table>
				<input type="submit" class="button button-primary" value="<?php _e('Update To Revision') ?>" /><br/>
			</form>
		</div>
	</div>
</div>
<?php
}

function mdocs_delete_version() {
	if ($_GET['mdocs-nonce'] == MDOCS_NONCE ) {
		$index = $_GET['mdocs-index'];
		$version_file = $_GET['version-file'];
		$mdocs = get_option('mdocs-list');
		$the_mdoc = $mdocs[$index];
		$upload_dir = wp_upload_dir();
		$archive_index = array_search($version_file,$the_mdoc['archived']);
		unset($the_mdoc['archived'][$archive_index]);
		$the_mdoc['archived'] = array_values($the_mdoc['archived']);
		$mdocs[$index] = $the_mdoc;
		update_option('mdocs-list',$mdocs);
		unlink($upload_dir['basedir'].'/mdocs/'.$version_file);
	} else mdocs_errors(MDOCS_ERROR_4,'error');
}

function mdocs_update_revision() {
	//MDOCS NONCE VERIFICATION
	if ($_REQUEST['mdocs-nonce'] == MDOCS_NONCE ) {
		if($_POST['mdocs-version'] != 'current') {
			global $current_user;
			$mdocs = get_option('mdocs-list');
			$mdocs_index = $_POST['mdocs-index'];
			$upload_dir = wp_upload_dir();
			$the_mdoc = $mdocs[$mdocs_index];
			$the_update =  substr($the_mdoc['archived'][$_POST['mdocs-version']], 0, strrpos($the_mdoc['archived'][$_POST['mdocs-version']], '-'));
			$the_update_type =  substr(strrchr($the_update, '.'), 1 );
			$old_doc_name = $the_mdoc['filename'].'-v'.preg_replace('/ /','',$the_mdoc['version']);
			if(in_array($old_doc_name, $the_mdoc['archived'])) $old_doc_name = $old_doc_name.'.'.time();
			$name = substr($the_mdoc['filename'], 0, strrpos($the_mdoc['filename'], '.') );
			$filename = $name.'.'.$the_update_type;
			rename($upload_dir['basedir'].'/mdocs/'.$the_mdoc['filename'],$upload_dir['basedir'].'/mdocs/'.$old_doc_name);
			copy($upload_dir['basedir'].'/mdocs/'.$the_mdoc['archived'][$_POST['mdocs-version']], $upload_dir['basedir'].'/mdocs/'.$filename);
			$new_version = $the_mdoc['version'].' revised';
			$mdocs[$mdocs_index]['filename'] = $filename;
			$mdocs[$mdocs_index]['name'] = $the_mdoc['name'];
			$mdocs[$mdocs_index]['desc'] = $the_mdoc['desc'];
			$mdocs[$mdocs_index]['version'] = (string)$new_version;
			$mdocs[$mdocs_index]['type'] = (string)$the_update_type;
			$mdocs[$mdocs_index]['cat'] = $the_mdoc['cat'];
			$mdocs[$mdocs_index]['owner'] = $mdocs_user = $current_user->display_name;
			$mdocs[$mdocs_index]['size'] = (string)filesize($upload_dir['basedir'].'/mdocs/'.$filename);
			$mdocs[$mdocs_index]['modified'] = (string)time();
			array_push($mdocs[$mdocs_index]['archived'], $old_doc_name);
			$mdocs = mdocs_array_sort($mdocs, 'name', 'SORT_ASC, SORT_STRING');
			update_option('mdocs-list', $mdocs);
			$mdocs_post_cat = get_category_by_slug( 'mdocs-media' );
			$wp_filetype = wp_check_filetype($upload_dir['basedir'].'/mdocs/'.$filename, null );
			$mdocs_post = array(
				'ID' => $the_mdoc['parent'],
				'post_author' => $current_user->ID
			);
			$mdocs_post_id = wp_update_post( $mdocs_post );
			$attachment = array(
				'ID' => $the_mdoc['id'],
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => $the_mdoc['name'],
				'post_author' => $current_user->ID
			 );
			update_attached_file( $the_mdoc['id'], $upload_dir['basedir'].'/mdocs/'.$filename );
			$mdocs_attach_id = wp_update_post( $attachment );
			$mdocs_attach_data = wp_generate_attachment_metadata( $mdocs_attach_id, $upload_dir['basedir'].'/mdocs/'.$filename );
			wp_update_attachment_metadata( $mdocs_attach_id, $mdocs_attach_data );
			wp_set_post_tags( $mdocs_post_id, 'memphis documents library,memphis,documents,library,media,'.$wp_filetype['type'] );
		
		} else mdocs_errors('You are already at the most recent version of this document.');
	} else mdocs_errors(MDOCS_ERROR_4,'error'); 
}

?>