<?php 
//Classify Categories custom fields query//
function classify_CF_search_Query($custom_fields){
	$searchQueryCustomFields = array();
	$value = array_filter($custom_fields, function($value) { return $value !== ''; });		
	$value = array_values($value);
	if(!empty($value)){
		foreach ($value as $val) {				
			$searchQueryCustomFields[] = array(
				'key' => 'custom_field',
				'value' => $val,
				'compare' => 'LIKE',
			);
		}			
	}
	return $searchQueryCustomFields;
}
//Classify search price query//
function classify_Price_search_Query($minPrice, $maxPrice){	
	$searchQueryPrice = array(
		'key' => 'post_price',
		'value' => array($minPrice, $maxPrice),
		'compare' => 'BETWEEN',
		'type' => 'NUMERIC'
	);
	return $searchQueryPrice;	
}
//Classify search by country query//
function classify_Country_search_Query($country){
	$searchQueryCountry = '';
	if (is_numeric($country)){
		$countryArgs = array(
			'post__in' => array($country),
			'post_per_page' => -1,
			'post_type' => 'countries',
		);
		$countryPosts = get_posts($countryArgs);		
		foreach ($countryPosts as $p) :		
		$search_country = $p->post_title;
		endforeach;
	}else{
		$search_country = $country;
	}
	if(!empty($search_country)){
		$searchQueryCountry = array(
			'key' => 'post_location',
			'value' => $search_country,
			'compare' => 'LIKE',
		);
	}
	return $searchQueryCountry;
}
//Classify search by states query//
function classify_State_search_Query($state){
	$searchQueryState = '';
	if($state != 'All' && !empty($state)){
		$search_state = $state;
		$searchQueryState = array(
			'key' => 'post_state',
			'value' => $search_state,
			'compare' => 'LIKE',
		);
	}
	
	return $searchQueryState;
}
//Classify search by City query//
function classify_City_search_Query($city){
	if($city != 'All' && !empty($city)){
		$search_city = $city;
		$searchQueryCity = array(
			'key' => 'post_city',
			'value' => $search_city,
			'compare' => 'LIKE',
		);
	}	
	return $searchQueryCity;
}
//Classify search by Item Condition query//
function classify_Condition_search_Query($search_condition){
	$searchCondition = '';
	if($search_condition != 'All'  && !empty($search_condition)){
		$searchCondition = array(
			'key' => 'classify_ad_condition',
			'value' => $search_condition,
			'compare' => '=',
		);
	}
	return $searchCondition;
}
//Classify search by Ads Type query//
function classify_adstype_search_Query($search_adstype){
	$searchAdsType = '';
	if($search_adstype != 'All' && !empty($search_adstype)){
		$searchAdsType = array(
			'key' => 'classify_ads_type',
			'value' => $search_adstype,
			'compare' => '=',
		);
	}
	return $searchAdsType;
}
//classify_smart_search//
function classify_smart_search( $search, $wp_query ) {
    global $wpdb; 
    if ( empty( $search ))
        return $search;
 
    $terms = $wp_query->query_vars[ 's' ];
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );
         
    $search = '';
    foreach( $exploded as $tag ) {
        $search .= " AND (
            ($wpdb->posts.post_title LIKE '%$tag%')
            OR ($wpdb->posts.post_content LIKE '%$tag%')
            OR EXISTS
            (
                SELECT * FROM $wpdb->comments
                WHERE comment_post_ID = $wpdb->posts.ID
                    AND comment_content LIKE '%$tag%'
            )
            OR EXISTS
            (
                SELECT * FROM $wpdb->terms
                INNER JOIN $wpdb->term_taxonomy
                    ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
                INNER JOIN $wpdb->term_relationships
                    ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
                WHERE taxonomy = 'post_tag'
                    AND object_id = $wpdb->posts.ID
                    AND $wpdb->terms.name LIKE '%$tag%'
            )
        )";
    }
 
    return $search;
} 
add_filter( 'posts_search', 'classify_smart_search', 500, 2 );
?>