<?php

add_shortcode('show-wgbc' , 'wgbc_carousel');
function wgbc_carousel($params = array()){
    if(  $params['name'] == '' ){
        return;
    }
    if(!isset($params['id'])){
        $params['id'] = 'unset_'.rand(0, 100);
    }
     $wgbc_query = new WP_Query(array(
         'post_type' => 'wgbc_carousels',
         'posts_per_page' => -1,
     ));
    wp_reset_query();
    if($wgbc_query->have_posts()){
        while ($wgbc_query->have_posts()) {
            $wgbc_query->the_post();
            $wgbc_title = get_the_title() ;
            if( $wgbc_title == $params['name'] ){
                $wgbc_sildes_toshow = get_post_meta( get_the_ID() , 'slide', true );
                $wgbc_captions_toshow = get_post_meta( get_the_ID() , 'caption', true );
                if($wgbc_sildes_toshow){
                    $output = "<div id=";
                    $output .= $params['id']; 
                    $output .= " class='carousel slide' data-ride='carousel' data-pause='false' data-interval='";
                    if(isset($params['interval'])){
                        $output .= ($params['interval']*1000)."'";
                    }else{
                        $output .= "'10000'";
                    }
                    $output .= '">';
                    $output .= '<ol class="carousel-indicators">';
                    for($i=1;$i<=count($wgbc_sildes_toshow);$i++){
                       $output .= '<li data-target="#'.$params['id'].'" data-slide-to="'.($i-1).'" class="';
                        if($i==1){
                            $output .= 'active';
                        } 
                        $output .='"></li>';
                    }
                    $output .= '</ol>';
                    $output .= '<div class="carousel-inner" role="listbox">';
                    for($i=1;$i<=count($wgbc_sildes_toshow);$i++){
                        $output .= '<div class="item ';
                        if($i==1){ $output .= 'active';}
                         $output .= '">';
                         $output .= '<img src="'.$wgbc_sildes_toshow[$i]['url'].'">
                                    <div class="carousel-caption">
                                        <h3>'.$wgbc_captions_toshow[$i]['head'].'</h3>
                                        <p>'.$wgbc_captions_toshow[$i]['caption'].'</p>
                                    </div>
                                </div>';
                    } $output .= '</div>';
                    $output .= "<a class='left carousel-control' href=";
                    $output .= '#'.$params['id']." role='button' data-slide='prev'><span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span><span class='sr-only'>Previous</span></a><a class='right carousel-control' href=";
                    $output .= '#'.$params['id']." role='button' data-slide='next'>
                        <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
                        <span class='sr-only'>Next</span>
                      </a>

                    </div>";
                    return $output;

                }
            }

        }
    }

}
