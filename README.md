# Dynamic css generator
### v2.0.0

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

## Changelog
### v2.0.0
- Fixed: class name
- Added: Inline style generator
- Some minor changes


### v1.0.0
- Initial release