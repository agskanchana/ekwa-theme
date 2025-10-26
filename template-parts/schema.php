<?php if ( function_exists( 'the_custom_logo' ) ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$working_hours = get_theme_mod( 'working_hrs', null );

 }

 $country =  get_theme_mod('country', "United States");
 $schema_country = '';
 if($country == 'United States'){
	$schema_country = 'US';
 }
 if($country == 'Canada'){
	$schema_country = 'CA';
 }
 if($country == 'Australia'){
	$schema_country = 'AU';
 }
 if($country == 'England'){
	$schema_country = 'GB';
 }


 ?>
<script type="application/ld+json">
{
"@context": "http://schema.org",

<?php $departments = get_theme_mod('location_info', null);?>
<?php
if(!$departments){
    $dept_count = 1;
}else{
    $dept_count =  count($departments);
}
?>

<?php if($dept_count > 1): ?>
"@type": "Organization",
<?php endif;?>
<?php if($dept_count == 1): ?>
"@type": "<?php echo get_theme_mod('organization_type', null); ?>",
<?php endif;?>
"url": "<?php echo get_option( 'siteurl' );?>",
<?php if($image_logo):?>
"logo": "<?php echo $image_logo[0];?>",
"image": "<?php echo $image_logo[0];?>",
<?php endif;?>
"name": " <?php echo get_theme_mod('practise_name', ''); ?>",
<?php $departments = get_theme_mod('location_info', '');?>
<?php
if(!$departments){
    $dept_count = 1;
}else{
    $dept_count =  count($departments);
}
?>
<?php if($dept_count == 1): ?>
    "priceRange": 0,

	"hasMap": "<?php echo  get_location('direction');?>",
	"address": {
	"@type": "PostalAddress",
	"addressLocality": "<?php echo  get_location('city');?>",
	"addressRegion": "<?php echo  get_location('state');?>",
	"postalCode":"<?php echo  get_location('zip');?>",
	"streetAddress": "<?php echo  get_location('street_address');?>",
	<?php if($schema_country !=''):?>
	"addressCountry": "<?php echo $schema_country;?>"
	<?php endif;?>
	},
	"telephone": "<?php echo  get_location('phone');?>",


	<?php
	 if($working_hours):
		$closed_days = 0;
		foreach($working_hours as $wh){
			if($wh['closed']){
				$closed_days++;
			}
		}
		 $real_working_hours = count($working_hours) - $closed_days - 1;

	?>
	"openingHoursSpecification": [
		<?php
		$wh_counter = 0;
		foreach($working_hours as $key=>$value):?>
		<?php if(!$value['closed']):?>
		{
		     "@type": "OpeningHoursSpecification",
		     "dayOfWeek":  "<?php echo $value['day'];?>",
		     "opens": "<?php echo $value['opening'];?>",
		     "closes": "<?php echo $value['closing'];?>"
		}<?php

		 if($wh_counter != $real_working_hours) { echo ", "; }
		 ?>
		<?php
		 $wh_counter++;
		 endif;?>
		<?php endforeach;?>
	],
	<?php endif;?>
	"geo": {
	"@type": "GeoCoordinates",
	"latitude": "<?php echo get_location('latitude');?>",
	"longitude": "<?php echo get_location('longitude');?>"
	},

<?php endif;?>

<?php if($dept_count > 1): ?>
"department":
[
	<?php foreach($departments as $key=>$value):?>

	{
            "@type": "<?php echo get_theme_mod('organization_type', null); ?>",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "<?php echo $value['city'];?>",
                "addressRegion": "<?php echo $value['state'];?>",
                "postalCode": "<?php echo $value['zip'];?>",
                "streetAddress": "<?php echo $value['street_address'];?>",
				<?php if($schema_country !=''):?>
				"addressCountry": "<?php echo $schema_country;?>"
				<?php endif;?>
            },
	     <?php  $working_hours = get_theme_mod( 'working_hrs', null );?>
	     <?php if($working_hours):?>
	     "openingHoursSpecification":
	     [

		<?php foreach($working_hours as $k=>$val):?>
		{
		     "@type": "OpeningHoursSpecification",
		     "dayOfWeek":  "<?php echo $val['day'];?>",
		     "opens": "<?php echo $val['opening'];?>",
		     "closes": "<?php echo $val['closing'];?>"
		}<?php if($k != count($working_hours)-1) { echo ", "; }?>

		<?php endforeach;?>

	    ],
	     <?php endif;?>
            "telephone" : "<?php echo $value['phone'];?>",
            "name": "<?php echo get_theme_mod('practise_name', null); ?>",
			<?php if($image_logo):?>
            "image": "<?php echo $image_logo[0];?>",
			<?php endif;?>
            "priceRange": 0,

	    "hasMap": "<?php echo $value['direction'];?>",
            "geo": {
              "@type": "GeoCoordinates",
              "latitude": "<?php echo $value['latitude'];?>",
              "longitude": "<?php echo $value['longitude'];?>"
              }
         }<?php if($key != count($departments)-1) { echo ", "; }?>

	<?php endforeach;?>
	    ],
<?php endif;?>

<?php $email_address =  get_theme_mod('email_address', null);
 if($email_address):
?>
"email": "<?php echo $email_address;?>",
<?php endif;?>
"sameAs" : ["<?php $social_media_links = get_theme_mod('social_media_links', null);
if($social_media_links){
foreach($social_media_links as $link_k=>$link_val){ echo $link_val['social_media_link']; if($link_k != count($social_media_links)-1) { echo ", "; }}
}
?>"]
}
</script>



