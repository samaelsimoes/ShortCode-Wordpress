/**
 * Shortcode desenvolvido por: Samael Pereira Simões
 * Lista todas as informações do produto, imagem, titulo, valor, parcela, qtx parcela e valor avista 'obs sao custom-field'
 */
function get_custom_product_list() {
	$paged = ( get_query_var(‘paged’) ) ? get_query_var(‘paged’) : 1;

    // The WP_Query
    $args = array(
		'order' 		 => 'DSC', 
        'post_type' 	 => 'product',
        'post_status'    => 'publish',
        'hide_empty'     => 0,
		'orderby' 	     => 'title',
		'posts_per_page' => '55',
		'paged' 		 => $paged
    );
	$query = new WP_Query( $args );

	$ret;
	if( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post(); { 
				$link    	= get_the_permalink($post_id);
				$image   	= get_the_post_thumbnail($post_id);
				$parcela 	= get_field("parcela");
				$parcela    =(float)$parcela;
				$parcela    = number_format($parcela, 2, ',', '.');
				$qt_parcela = get_field("qt_parcela");
				$avista  	= get_field("a_vista");
				$avista  	=(float)$avista;
				$avista 	= number_format($avista, 2, ',', '.');

		
				$title   	= get_the_title( $post_title['post_id']);
				$currency   = get_woocommerce_currency_symbol();
				$price      = get_post_meta( get_the_ID(), '_regular_price', true);
				$formatado  =(float)$price;
				$valor 		= number_format($formatado, 2, ',', '.');

				$ret .= "<div class='custom-produtos-shortcode custom-shortcode-height' style='text-align: center;'>		 
							<div class='text-center' style='align-items: center;'>".
								"<a href=".$link.">
									<img class='card-img-top' alt='Card image produto".$title."' src=".$image.
								"</a>".
								"<div class='row' style='padding: 5px;'>".
									get_star_rating().
								"</div>".
								"<div class='row'> <div class=''>".										
									"<div class=' custom-title-product'>".
										"<a href=".$link."><h3 class='custom-title-product'>".$title."</h3></a>".						
									"</div>".
									"<div class='text-center custom-value'>".
										"<span>".									
										$currency. $valor
										."</span>".
									"</div>".
									"<div class='text-center'>". 
										"<span class='custom-inf-parcela '> ou em até ". $qt_parcela . "x de </span> <span class='custom-valor-parcela'>  R$". $parcela ."</span> <span class='custom-inf-parcela '> na entrega </span>".
									"</div>".
									"<div class='text-center'>". 
										"<span class='custom-inf-parcela '> ou apenas </span><span class='custom-valor-parcela'> R$". $avista . "</span><span class='custom-inf-parcela '> à vista na entrega <span>".
									"</div>".
								"</div> </div>".
							"</div>
						</div>" ;		
			}	
		}
	}
    wp_reset_postdata();
		
			
    return $ret; 
} 
add_shortcode( 'product_list', 'get_custom_product_list' );

/**
 * Funcao responsavel de listar a avaliação
 */
function get_star_rating() {
    global $woocommerce, $product;
    $average = $product->get_average_rating();

  return '<div class="star-rating rounded mx-auto d-block">
				<span style="width:'.( ( $average / 5 ) * 100 ) . '%" title="'. $average.'">
					<strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'	
				</span>
			</div>';
}