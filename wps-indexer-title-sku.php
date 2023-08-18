<?php
/**
 * Plugin Name: WPS Indexer for Product Titles and SKUs containing special characters
 * Plugin URI: https://www.netpad.gr
 * Description: WPS Indexer for Product Titles and SKUs containing special characters
 * Version: 1.0.0
 * Author: gtsiokos
 * Author URI: https://www.netpad.gr
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_Indexer_Title_Sku {

	public static function boot() {
		add_filter( 'woocommerce_product_search_indexer_filter_content', array( __CLASS__, 'woocommerce_product_search_indexer_filter_content' ), 10, 3 );
	}

	public static function woocommerce_product_search_indexer_filter_content( $content, $context, $post_id ) {
		if ( $context === 'post_content' ) {
			$special_characters = array( '.', '(', ')', '-' );
			$product = wc_get_product( $post_id );
			// Title
			$product_title = $product->get_title();
			$alternative_title = str_replace( $special_characters, '', $product_title );
			// SKU
			$product_sku = $product->get_sku();
			$alternative_sku = str_replace( $special_characters, '', $product_sku );
			//$meta_values = array();
			//foreach ( $fields as $meta_key ) {
			//	$meta_value = $product->get_meta( $meta_key );
			//	if ( !empty( $meta_value ) && is_string( $meta_value ) ) {
			//		$meta_values[] = $meta_value;
			//	}
			//}
			//if ( count( $meta_values ) > 0 ) {
			$content .= ' ' . $alternative_title . ' ' . $alternative_sku;
			//}
		}
		return $content;
	}
}
WPS_Indexer_Title_Sku::boot();
