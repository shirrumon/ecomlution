# wp-fontawesome-iconpicker-control
FontAwesome IconPicker for WordPress Customizer

## Installation
**Composer**
```json
{ 
  "repositories": [    
    {
      "type": "vcs",
      "url": "https://github.com/thanks-to-it/wp-fontawesome-iconpicker-control"
    },
  ],
  "require": {
      "thanks-to-it/wp-fontawesome-iconpicker-control": "dev-master"
  }
}
```

## Usage
```php
$section = $wp_customize->add_section( 'Section', array(
	'title'       => __( 'My Section' ),
	'description' => __( 'My Description' ),	
	'panel'       => 'prefix_mypanel',
) );

$wp_customize->add_control( new \ThanksToIT\WPFAIPC\IconPicker_Control(
	$wp_customize,
	'ttt_pnwc_success_icon',
	array(
		'label'    => __( 'Icon Class' ),
		'section'  => $section->id,
		'settings' => $setting->id,
		'options'  => array( 'placement' => 'bottom' )
	)
) );
```
