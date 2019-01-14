# Dynamic css generator
### v3.0.0

## Cached dynamic css
```html
<?php
use \RD\WP\Styles;
Styles::init();
  
Styles::add_rule('.text')
	->add_prop( 'color', 'red');
?>
<div class="wrapper <?= Styles::class() ?>">
  <div class="text">
    This text is red.
  </div>
</div>
<?php Styles::done();  ?>
```


## Dynamic css
```php
$css = new \RD\WP\CSS();
$css->add_rule() // Select base class
  ->add_prop('color', '#000000');

$css->add_rule('a') // Select all <a> 
  ->add_prop('text-decoration', 'none');

```
```html
<?php $css->styles(); // Print style tag  ?>
<div class="<?php $css->class(); ?>">
  <a href="#">This is a link</a>
</div>
```

## Inline style
```html
<?php
$styles = array(
  'color' => 'blue',
  'text-decoration' => 'none'
);
?>
<a href="#" <?php \RD\WP\CSS::inline( $styles ) ?> >This is a link</a>
```


## TODO

- [ ] Fix PHP docBlocks.
- [ ] Remove WP from namespace.
- [ ] Clean up codes

## Changelog
### v3.0.0
- Added: A new way to dynamically generate css. It will add all the css in `wp_footer` section.
  
### v2.0.0
- Fixed: class name
- Added: Inline style generator
- Some minor changes


### v1.0.0
- Initial release