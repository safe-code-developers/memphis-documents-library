<?php
if(isset($_GET['mdocs-file'])) mdocs_download_file();
if(isset($_GET['mdocs-version'])) mdocs_download_file($_GET['mdocs-version']);
if(isset($_GET['mdocs-export-file'])) mdocs_download_file($_GET['mdocs-export-file']);

function mdocs_download_file($export_file='') {
	require_once(ABSPATH . 'wp-includes/pluggable.php');
	mdocs_send_bot_alert();
	$upload_dir = wp_upload_dir();
	$mdocs = get_option('mdocs-list');
	if(!empty($export_file) ) { $filename = $export_file; }
	else {
		foreach($mdocs as $index => $value) {
			if($value['id'] == $_GET["mdocs-file"] ) {
				$filename = $mdocs[$index]['filename'];
				if(mdocs_is_bot() == false) {
					$mdocs[$index]['downloads'] = (string)(intval($mdocs[$index]['downloads'])+1);
					update_option('mdocs-list', $mdocs);
				}
				break;
			} //else $filename = 'mdocs-empty';
		}
	}
	if(isset($_GET['mdocs-export-file'])) mdocs_export_zip();
	$file = $upload_dir['basedir']."/mdocs/".$filename;
	if(isset($_GET['mdocs-version'])) $filename = substr($filename, 0, strrpos($filename, '-'));
	$filetype = wp_check_filetype($file );
	//if(mdocs_is_bot()) mdocs_send_bot_alert();
	if (file_exists($file) && mdocs_is_bot() == false ) {		
		header('Content-Description: File Transfer');
		header('Content-Type: '.$filetype['type']);
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); 
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	} else die(__('Check this file out').' <b>'.$filename. '</b>.  '.  __('Download it from').' <b>'.get_bloginfo('name').'</b>.<br><sup>'.__('powered by Memphis Documents Library').'</sup>');	
}
?>