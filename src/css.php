<?php
namespace RD\WP;

class CSS {
    /**
     * Class name
	 * @since 1.0.0
     */
    private $base_class = "";

    /**
     * Array of style rules ( RD_CSS_Rule )
	 * @since 1.0.0
     */
    private $rules = array();

    /**
     * Generate class name
     * @param   String  $prefix
     * @return  String  unique generated class name
	 * @since 1.0.0
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
	 * @since 1.0.0
     */
    public function __construct() {
        $this->base_class = $this->generate_class();
    }



    /**
     * Return base class name
     * @return  String  base class name
	 * @since 1.0.0
     */
    public function get_class() {
        return $this->base_class;
    }
	
	/**
	 * Print class name 
	 * @since 2.0.0
	 * @return void 
	 */
	public function class(){
		echo $this->get_class();
	}

    /**
     * Just an alias of add_rule method
     * @param   String  $base   css rule base
	 * @deprecated 1.0.0
	 * @since 1.0.0
     */
    public function create_rule( $base = false ) {
		return $this->add_rule( $base );
    }
	
    /**
     * Create a style rule
     * @param   String  $base   css rule base
	 * @since 1.0.0
     */
	public function add_rule( $base = false ){
        if ( ! $base ) {
            $base = $this->base_class;
        }
        else if ( $this->base_class != $base ) {
            $base = sprintf("%s %s", $this->base_class, $base);
        }
        $rule = new CSS_Rule( $base );
        $this->rules[] = $rule;
        return $rule;
	}

    /**
     * Print css rules
	 * @since 1.0.0
     * @return  String  css style to print
     */
    public function css() {
        $css = "";
        foreach( $this->rules as $rule ) {
            $css .= $rule->css() . "\n";
        }

        return $css;
    }
	/**
	 * Print <style> tag
	 * @since 2.0.0
	 * @return void
	 */
	public function styles(){
		$css = $this->css();
		echo sprintf('<style>%s</style>', $css);
    }
    


    
    /**
     * Stringify css properties
     *
     * 
     * @param string $name
     * @param string $value
     * @param string $pattern
     * @since  2.0.0
     * @return string
     */
     static private function inline_prop_stringify( $prop, $value, $pattern = "%s: %s;" ) {
        $css = '';
        if ( $value ) {
        	if (is_array($value)){
        		foreach( $value as $v ){
        			$css .= sprintf($pattern, $prop, $v);
        		}
        	}else{
        		$css .= sprintf($pattern, $prop, $value);
        	}
        }
    	return $css;
    }
    /**
     * Return html ready css inline style
     *
     * @param array $styles
     * @param boolean $return
     * @return string
     * @since 2.0.0
     */
    static function inline( $styles = array(), $return = false ){
    	if( empty( $styles ) || ! is_array( $styles ) )
    		return '';
    	$output = '';
    	$i = 0;
    	foreach ( $styles as $key => $val ) {
    		$i++;
    		switch ($key) {
    			case 'background-image':
    				$search = 'url(';
    				if (substr(trim($val), 0, strlen($search)) === $search){
    					$output .= self::inline_prop_stringify($key, $val);
    				}else{
    					$output .= self::inline_prop_stringify($key, $val,"%s: url('%s');");
    				}
    				break;
    			default:
    				$output .= self::inline_prop_stringify($key, $val);
    				break;
    		}
        }
        if ( $return ){
            return $output;
        }else{
            echo \sprintf('style="%s"', \htmlspecialchars( $output ) );
        }
    	
    }
}
