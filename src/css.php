<?php
namespace RD\WP;
use RD\WP\CSS_Rule;
class CSS {
    /**
     * Class name
     */
    private $base_class = "";

    /**
     * Array of style rules ( RD_CSS_Rule )
     */
    private $rules = array();

    /**
     * Generate class name
     * @param   String  $prefix
     * @return  String  unique generated class name
     */
    private function generate_class( $prefix = "rd__dynamic-", $length = 10 ) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $prefix . $randomString;
    }

    /**
     * Main constucter
     */
    public function __construct() {
        $this->base_class = $this->generate_class();
    }



    /**
     * Return base class name
     * @return  String  base class name
     */
    public function get_class() {
        return $this->base_class;
    }

    /**
     * Create a style rule
     * @param   String  $base   css rule base
     */
    public function create_rule( $base = false ) {
        if ( ! $base ) {
            $base = $this->base_class;
        }
        else if ( $this->base_class != $base ) {
            $base = sprintf("%s %s", $this->base_class, $base);
        }
        $rule = new RD_CSS_Rule( $base );
        $this->rules[] = $rule;
        return $rule;
    }

    /**
     * Print css rules
     * @return  String  css style to print
     */
    public function css() {
        $css = "";
        foreach( $this->rules as $rule ) {
            $css .= $rule->css() . "\n";
        }

        return $css;
    }
}


