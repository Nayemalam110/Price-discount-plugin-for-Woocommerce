<?php

/**
 * Plugin Name: DisPl
 * Description: Show discount.
 * Plugin URI:        http://nayemalambdcalling.rf.gd/
 * Version:           1.0.0
 * Author:            Nayem Alam
 * Author URI:        http://nayemalambdcalling.rf.gd/
 * License:           GPL v2 or later
 */

add_action( 'woocommerce_before_shop_loop_item_title', 'New_show_sale_percentage_loop', 25 );

function New_show_sale_percentage_loop() {
    global $product;
    if ( ! $product->is_on_sale() ) return;
    if ( $product->is_type( 'simple' ) ) {
       $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ));
    } elseif ( $product->is_type( 'variable' ) ) {
       $max_percentage = 0;
       foreach ( $product->get_children() as $child_id ) {
          $variation = wc_get_product( $child_id );
          $price = $variation->get_regular_price();
          $sale = $variation->get_sale_price();
          if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) ;
          if ( $percentage > $max_percentage ) {
             $max_percentage = $percentage;
          }
       }
    }
     
    if ( $max_percentage > 0) echo "<div class='dispriccss'>Save " . round($max_percentage) . "$</div>"; 
     
 }