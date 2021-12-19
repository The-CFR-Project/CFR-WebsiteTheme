<?php
$post = get_page_by_path("model-house");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );

$model = $doc->query( "//p" );
echo $model[0];
echo do_shortcode($model[0]);
?>