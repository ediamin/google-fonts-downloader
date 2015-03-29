<?php
/**
 * The downloader script
 *
 * @package     Google Fonts Downloader
 */

if ( !empty( $_POST )  && !empty( $_POST['link'] ) ) {
	$link = $_POST['link'];

	$regex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

	// Check if there is a url in the text
	if( preg_match( $regex_url, $link, $url ) ) {

		$css_file = "google-fonts.css";
		$google_css = $url[0];
		$google_css = rtrim( $google_css, "'" );

		$ch = curl_init();
		$fp = fopen ( $css_file, 'w+' );
		$ch = curl_init( $google_css );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 50 );
		curl_setopt( $ch, CURLOPT_FILE, $fp );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_exec( $ch );
		curl_close( $ch );
		fclose( $fp );		

		// fonts folder operations. Delete if exists. Then create a new
		if ( file_exists( "fonts" ) ) {
			delTree( "fonts" );
		}

		mkdir( "fonts" );

		// get the download css content
		$css_file_contents = file_get_contents( $css_file );

		if ( preg_match_all( $regex_url, $css_file_contents, $fonts ) ) {
			$fonts = $fonts[0];

			foreach ( $fonts as $i => $font ) {
				$font = rtrim( $font, ")" );

				$font_file = explode( "/", $font );
				$font_file = array_pop( $font_file );

				// download font
				$ch = curl_init();
				$fp = fopen ( "fonts/{$font_file}", 'w+' );
				$ch = curl_init( $font );
				curl_setopt( $ch, CURLOPT_TIMEOUT, 50 );
				curl_setopt( $ch, CURLOPT_FILE, $fp );
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
				curl_exec( $ch );
				curl_close( $ch );
				fclose( $fp );				

				// replace string
				$css_file_contents = str_replace( $font, "../fonts/{$font_file}", $css_file_contents );
			}

			$fh = fopen ( $css_file, 'w+' );
			fwrite( $fh, $css_file_contents );
			fclose( $fh );

			$msg = "Done!";
		}
	}
}

// recursive delete files/directories in a directory
// http://php.net/manual/en/function.rmdir.php
function delTree( $dir ) { 
	$files = array_diff( scandir( $dir ), array( '.', '..' ) ); 
	foreach ( $files as $file ) { 
		( is_dir( "$dir/$file" ) && !is_link( $dir ) ) ? delTree( "$dir/$file" ) : unlink( "$dir/$file" ); 
	} 

	return rmdir($dir); 
}
