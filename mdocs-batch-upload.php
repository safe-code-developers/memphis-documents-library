<?php
function mdocs_batch_upload($current_cat) {
	$do_zip = false;
	//$mdocs = get_option('mdocs-list');
	$cats = get_option('mdocs-cats');
	//var_dump($cats);
	$do_complte = false;
	if(isset($_FILES['mdocs-batch']) && strpos($_FILES['mdocs-batch']['type'],'zip') == false) {
		?>
		<div class="error">
			<p><?php _e('Please upload a zip file.'); ?></p>
		</div>
		<?php
	} elseif(isset($_FILES['mdocs-batch']) && strpos($_FILES['mdocs-batch']['type'],'zip') >= 0) {
		if(!file_exists('/tmp/')) mkdir('/tmp/');
		if(!file_exists('/tmp/mdocs/')) mkdir('/tmp/mdocs/');
		$zip_result = mdocs_unzip($_FILES['mdocs-batch']['tmp_name'], '/tmp');
		$do_zip = true;
	} elseif (isset($_POST['mdocs-batch-complete'])) {
		$do_complte = true;
	}
?>
<h1><?php _e('Batch Library Upload'); ?></h1>
<div class="error">
	<h3>Warning</h3>
	<p><?php _e('Batch Upload  is still in beta.  Be sure to backup your library before running this process.  If anything should go wrong, just import the backup using the"Overwrite Saved Variables" option, and then run the "File System Cleanup" process to revert to the original state.'); ?></p></div>
<div class="updated">
	<p><?php _e('Create a zip file of all the documents you want to upload.  You may name it whatever you want, naming doesn\'t matter.  Once you have created the file, simply upload it, then use the quick select form to place the files in the proper directory.  Once satisfied press the \'Complete\' button to finsh the process.'); ?></p>
</div>
<?php if($do_zip == false && $do_complte == false) { ?>
<form class="mdocs-uploader-form" enctype="multipart/form-data" action="<?php echo get_site_url().'/wp-admin/admin.php?page='.$_REQUEST['page'].'&cat='.$_REQUEST['cat']; ?>" method="POST">
	<input type="file" name="mdocs-batch" /><br/>
	<input type="submit" class="button button-primary" value="<?php _e('Upload Zip File') ?>" /><br/>
</form>
<?php } elseif($do_zip) {
	$cats = get_option('mdocs-cats');
	$current_cat = key($cats);
	?>
	<form class="mdocs-uploader-form" enctype="multipart/form-data" action="<?php echo get_site_url().'/wp-admin/admin.php?page='.$_REQUEST['page'].'&cat='.$_REQUEST['cat']; ?>" method="POST">
		<input type="hidden" name="mdocs-batch-complete" value="1" />
		<input type="hidden" name="mdocs-type" value="mdocs-add" />
		<?php
		foreach($zip_result['file'] as $index => $zip_file) {
			$file = explode('/',$zip_file);
			if(count($file) == 1) $file = explode('\\',$zip_file);
			$file = $file[count($file)-1];
			$file = preg_replace('/[^A-Za-z0-9\-._]/', '', $file);
			$file = str_replace(' ','', $file);
			$filename = $file;
			$file = explode('.',$file);
			$file = $file[0];
			?>
			<div class="mdocs-batch-container">
				<input type="hidden" name="mdocs[filename][<?php echo $index; ?>]" value="<?php echo $filename; ?>" />
				<input type="hidden" name="mdocs[tmp-file][<?php echo $index; ?>]" value="<?php echo $zip_file; ?>" />
				<label><?php _e('File Name'); ?>:
					<input type="text" name="mdocs[name][<?php echo $index; ?>]" value="<?php echo $file; ?>"/>
				</label>
				<label><?php _e('Category'); ?>:
					<select name="mdocs[cat][<?php echo $index; ?>]">
						<?php mdocs_get_cats($cats, $current_cat); ?>
					</select>
				</label>
				<label>
						<?php _e('Version'); ?>: 
					<input type="text" name="mdocs[version][<?php echo $index; ?>]" value="1.0" />
				</label>
			</div>
			<?php
		}
		?>
		<br>
		<input type="submit" class="button button-primary" value="<?php _e('Complete') ?>" />
		<br/>
	</form>
	<?php
} elseif ($_POST['mdocs-batch-complete'] ) {
	$file = array();
	$current_user = wp_get_current_user();
	$batch_log = '';
	foreach($_POST['mdocs']['tmp-file'] as $index => $tmp) {
		$valid_mime_type = false;
		$file['name'] = $_POST['mdocs']['filename'][$index];
		$result = wp_check_filetype($tmp);
		$file['tmp_name'] = $tmp;
		$file['error'] = 0;
		if(file_exists($tmp)) $file['size'] = filesize($tmp);
		$file['post_status'] = 'publish';
		$file['post-status'] = 'publish';
		//MDOCS FILE TYPE VERIFICATION	
		$mimes = get_allowed_mime_types();
		foreach ($mimes as $type => $mime) {
		  if ($mime === $result['type']) {
			$valid_mime_type = true;
			break;
		  }
		}
		$batch_log .= _('Processed File => ').$file['name']."<br>";
		if($valid_mime_type) {
			$upload = mdocs_process_file($file);
			$mdocs = get_option('mdocs-list');
			array_push($mdocs, array(
				'id'=>(string)$upload['attachment_id'],
				'parent'=>(string)$upload['parent_id'],
				'filename'=>$upload['filename'],
				'name'=>$upload['name'],
				'desc'=>$upload['desc'],
				'type'=>$result['type'],
				'cat'=>$_POST['mdocs']['cat'][$index],
				'owner'=>$current_user->user_login,
				'size'=>(string)$file['size'],
				'modified'=>(string)time(),
				'version'=>(string)$_POST['mdocs']['version'][$index],
				'show_social'=>(string)'on',
				'non_members'=> (string)'on',
				'file_status'=>(string)'public',
				'post_status'=> (string)'publish',
				'post_status_sys'=> (string)'publish',
				'doc_preview'=>(string)'',
				'downloads'=>(string)0,
				'archived'=>array(),
				'ratings'=>array(),
				'rating'=>0
			));
			$mdocs = mdocs_array_sort($mdocs, 'name', SORT_ASC);
			update_option('mdocs-list', $mdocs);
			$batch_log .= _('Mime Type Allowed => ').$result['type']."<br>";
			$batch_log .= _('File Uploaded with No Errors.')."<br><br>";
		} else {
			$batch_log .= __("Invalid Mime Type => ").$result['type']._(" Unable to process file.")."<br>";
			$batch_log .= _('File Was Not Uploaded because an Error occured.')."<br><br>";
		}
		$file = array();
	}
	$batch_log .= _("Cleaning up tmp folder and files")."<br><br>";
	$files = glob('/tmp/mdocs/*'); 
	foreach($files as $file) if(is_file($file)) unlink($file);
	if(file_exists('/tmp/mdocs')) @rmdir('/tmp/mdocs');
	$batch_log .= _("Batch Process Complete.");
	?>
	<div class="updated">
		<p><?php _e('The batch process has completed, below is a log of results:'); ?></p>
		<p><?php echo $batch_log; ?></p>
	</div>
	<form class="mdocs-uploader-form" enctype="multipart/form-data" action="<?php echo get_site_url().'/wp-admin/admin.php?page='.$_REQUEST['page'].'&cat='.$_REQUEST['cat']; ?>" method="POST">
		<input type="file" name="mdocs-batch" /><br/>
		<input type="submit" class="button button-primary" value="<?php _e('Upload Zip File') ?>" /><br/>
	</form>
	<?php
}
}
?>