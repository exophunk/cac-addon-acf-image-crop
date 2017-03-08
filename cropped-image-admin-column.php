<?php

/*
 *
 * Plugin Name: Admin Columns - Advanced Custom Fields Image Crop add-on
 * Description: Allow users to use both "Advanced Custom Fields: Image Crop Add-on" and "Codepress Admin Columns" plugins. This plugin allow cropped images to be shown on the admin list pages.
 * Author: Robert Krieg
 * Version: 0.1
 * Author URI: http://robertkrieg.ch
 * 
 */

class CPAC_Addon_ACF_Image_Crop
{


    public function __construct()
    {
        add_action( 'cpac-acf/loaded', array( $this, 'init' ) );
    }


    /**
     * Init
     */
    public function init( $cpacACF ) {
        add_filter('cac/acf/format_acf_value', array($this, 'changeValue'), 10, 5);
    }


    /**
     * TODO: Currently there is no way to hook the CAC ACF Plugin to enable
     * setting the image_size options, so it is always using the default
     */
    public function changeValue($value, $field, $id, $originalvalue, $column)
    {
        if($field['type'] == 'image_crop') {
            $value = json_decode($value);
            if($value && $value->cropped_image) {
                $value = $value->cropped_image;
                $value = implode($column->get_thumbnails($value, array(
                    'image_size'   => $column->options->image_size,
                    'image_size_w' => $column->options->image_size_w,
                    'image_size_h' => $column->options->image_size_h,
                )));
            } else {
                $value = '';
            }
        }

        return $value;
    }

}

new CPAC_Addon_ACF_Image_Crop();
