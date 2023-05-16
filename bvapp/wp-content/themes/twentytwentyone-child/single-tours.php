<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

//get_header();
$archive = get_post_field( 'archive');
$is_live = get_post_field( 'live');
if($archive){
    if(isset($archive[0]) && $archive[0]==1){
        wp_redirect( home_url('/'), 301 );
    }
}
if(empty($is_live)){
    wp_redirect( home_url('/'), 301 );    
}


$tours_setting = array();
$page_slug = get_post_field( 'post_name' );
$logo= get_field('logo'); 
$google_analytics_code = get_field('google_analytics_code'); 

$tv_video_url = get_field('tv_video_url');
$video_url=''; $video_thumb_url='';
if($tv_video_url){
    $video_url= array();
    $video_thumb_url = array();
    foreach ($tv_video_url as $key => $value) {
        $video_url[] = $value['video'];
        $video_thumb_url[] = $value['thumbnail'];
    }
}


$tour_title='';
$tour_type = get_field('tour_type');
if($tour_type==1){
    $info_below_logo= get_field('info_below_logo'); 
}else{
    $tag_lines_and_name= get_field('tag_lines_and_name'); 
    $info_below_logo= array();
    $tour_title = array();
    foreach ($tag_lines_and_name as $key => $value) {
        $info_below_logo[] = $value['tour_tag_line'];
        $tour_title[] = $value['tour_name'];
    }
}

$bottom_logo = get_field('bottom_logo'); 
$bottom_disclaimer_text = get_field('bottom_disclaimer_text'); 

$tours_setting['logo'] =$logo;
$tours_setting['tour_type'] =$tour_type;
$tours_setting['tagline'] =is_array($info_below_logo)?implode('|',$info_below_logo):$info_below_logo;
$tours_setting['tour_title'] = is_array($tour_title)?implode('|',$tour_title):$tour_title;

$tours_setting['tv_video_url'] = is_array($video_url)?implode('|',$video_url):$video_url;
$tours_setting['tv_thumb_url'] = is_array($video_thumb_url)?implode('|',$video_thumb_url):$video_thumb_url;

$tours_setting['bottom_logo'] = $bottom_logo;
$tours_setting['bottom_disclaimer_text'] = $bottom_disclaimer_text;

$tours_setting['google_analytics_code'] = $google_analytics_code;

//echo '<pre>'; print_r($tours_setting); echo '</pre>';exit();
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo get_the_title();?></title>
    <style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
    }

    iframe {
        width: 100%;
        height: 100%;
    }
    </style>
    <?php if($google_analytics_code){ ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-<?php echo $google_analytics_code?>"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-<?php echo $google_analytics_code?>');
    </script>



    <?php } ?>
</head>

<body>


    <iframe
        src="<?php echo get_stylesheet_directory_uri() . '/tours_source/'.$page_slug.'/index.php?'.http_build_query($tours_setting);?>"
        title="W3Schools Free Online Web Tutorials"></iframe>

</body>

</html>
<?php
//get_footer();