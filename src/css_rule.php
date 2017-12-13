<?php 
namespace RD\WP;

class CSS_Rule {
    /**
     * Base name
     */
    private $base = "";

    /**
     * Array of props
     */
    private $props = array();

    /**
     * Array or query preset
     */
    private $query_presets = array(
        'mobile' => 768
    );


    /**
     * Main constructer function
     * @param   String  $base   css base
     */
    public function __construct( $base ) {
        $this->base = $base;
    }


    /**
     * Add css property
     */
    public function add_prop( $prop, $value, $width = null, $important = false) {
        if ( $prop && $value ) {
            $query = ( $width && $width !== true ) ? $width : 'default';

            if ( is_bool($width) ) {
                $important = $width;
            }

            if ( array_key_exists( $query, $this->query_presets ) ) {
                $query = $this->query_presets[$query];
            }

            if ( ! isset( $this->props[$query] ) ) {
                $this->props[$query] = array();
            }
            $value .= ($important) ? " !important" : "";
            $this->props[$query][$prop] = $value ;
        }

        return $this;
    }

    /**
     * Print css
     * @return  String  css style to print
     */
    public function css() {
        $output = "";
        foreach( $this->props as $query => $props ) {
            $styles = "";
            foreach( $props as $prop => $value ) {
                if ( $value ) {
                    $styles .= sprintf("%s:%s;", $prop, $value);
                }
            }
            if ( "" != $styles ) {
                $styles = sprintf( ".%s {%s}", $this->base, $styles);
                if ( "default" != $query ) {
                    $output .= sprintf( "@media ( max-width: %spx) {%s}\n", $query, $styles );
                }
                else {
                    $output .= sprintf("%s\n", $styles);
                }
            }

        }

        return $output;
    }
}