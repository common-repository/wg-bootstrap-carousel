<?php
add_action( 'admin_init', 'add_wgbc_slides' );
add_action( 'admin_head-post.php', 'wgbc_slides_styles' );
add_action( 'admin_head-post-new.php', 'wgbc_slides_styles' );
add_action( 'save_post', 'update_wgbc_slides', 10, 2 );

/**
 * Add custom Meta Box to Posts post type
 */
function add_wgbc_slides()
{
    add_meta_box(
        'slides',
        __('Slides','WGBC'),
        'post_wgbc_slides',
        'wgbc_carousels',
        'normal',//('normal', 'advanced', or 'side').
        'core'//$priority ('high', 'core', 'default' or 'low')
    );
    add_meta_box(
        'slide_options',
        __('Slider Options (Optional)','WGBC'),
        'post_wgbc_options',
        'wgbc_carousels',
        'side',//('normal', 'advanced', or 'side').
        'core'//$priority ('high', 'core', 'default' or 'low')
    );
}
function post_wgbc_options(){
    global $post;
    $wgbc_slides = get_post_meta( $post->ID );
    $wgbc_options = unserialize($wgbc_slides['options'][0]);
?>
            <label for="wgbc_carousel_id"><?php echo __('Set Container\'s ID :','WGBC') ?></label><br/><input placeholder="<?php echo __('Set id for the container','WGBC'); ?>" id="wgbc_caousel_id" name="wgbc_caousel_id" type="text" value="<?php if(isset($wgbc_options['id'])){echo  $wgbc_options['id'];} ?>" /><br/>
            <label for="wgbc_carousel_interval"><?php echo __('Interval Time : (seconds)','WGBC') ?></label><br/><input placeholder="<?php echo __('Default Time = 10 seconds','WGBC'); ?>" id="wgbc_caousel_interval" name="wgbc_caousel_interval" type="number" value="<?php if(isset($wgbc_options['time'])){echo  $wgbc_options['time'];} ?>"  <?php ?> /><br/>
<?php }
/**
 * Print the Meta Box content
 */
function post_wgbc_slides(){
    global $post;
    $wgbc_slides = get_post_meta( $post->ID );
    $wgbc_caption = unserialize($wgbc_slides['caption'][0]);
    $wgbc_slides = unserialize($wgbc_slides['slide'][0]);
?><div class="save_container_buttons">
        <input id="add_slides" class="button button-primary button-large" type="button" value="+" onclick="add_slide();" />
        <input name="save_slide" class="button button-primary button-large" type="submit" value="Save" />
    </div>
    <hr />
    <?php
    $x = 1;
    if($wgbc_slides){?>
    <div id="wgbc_sortable">
        <?php while( $x <= count( $wgbc_slides ) ){?>
            <div class="slide_add_item">
                <div class="wgbc_handle">Drag</div><div id="slidebar<?php echo $x; ?>" class="slidebar">slide <?php echo $x; ?></div>

                <div class="wgbc_metbox_left">
                    <input id="wgbc_upload" type="file" name="file<?php echo $x; ?>" /><br />
                    <img class="admin_slide_img" src="<?php echo $wgbc_slides[$x]['url']?>" /><br />
                    <input id="hidden_input_name" type="hidden" name="admin_slide<?php echo $x; ?>_img_name" value="<?php echo $wgbc_slides[$x]['name']?>" />
                    <input id="hidden_input_url" id="" type="hidden" name="admin_slide<?php echo $x; ?>_img_url" value="<?php echo $wgbc_slides[$x]['url']?>" />
                    <input name="remove" class="button button-primary button-small" type="submit" value="Remove<?php echo $x; ?>" /><br />
                </div>

                <div class="wgbc_metbox_right">
                    <label class="slide_input_label" for="caption_h_<?php echo $x; ?>" >Head Caption</label>
                    <input class="input_caption" name="caption_h_<?php echo $x; ?>" id="caption_h_<?php echo $x; ?>" type="text" value="<?php if( isset($wgbc_caption[$x]['head']) ){echo $wgbc_caption[$x]['head'];} ?>" />
                    <label class="slide_input_label" for="caption_<?php echo $x; ?>" >Caption</label>
                    <input class="input_caption" name="caption_<?php echo $x; ?>" id="caption_<?php echo $x; ?>" type="text" value="<?php if( isset($wgbc_caption[$x]['caption']) ){echo $wgbc_caption[$x]['caption'];} ?>" />
                </div>

            </div><?php
            $x++;
        }?>
    </div>
    <?php }
    ?>
    <div id="slides_add_container">
    </div>
    <input name="slidescount" type="hidden" />
<?php }
/**
 * Print styles and scripts
 */
function wgbc_slides_styles(){
    ?>
    <style type="text/css">
        .slidebar{
            cursor: pointer;
            background-color: #006799;
            color: #fff;
            margin: -20px -5.6% 20px;
            line-height: 30px;
            text-align: center;
            font-size: 14px;
        }
        .slide_input{
            display: block;
            margin: 20px 2%;
        }

        .admin_slide_img{
            max-width: 200px;
            max-height: 200px;
        }
        [class^="slide_input"],.input_caption{
            display: block;
        }
        .input_caption{
            width: 100%;
        }
        .slide_input_label{
            cursor: default;
            margin-top: 10px;
        }
        .slide_add_item{
            margin-top: 20px;
            margin: 20px 2%;
            background-color: #f0f0f0;
            padding: 20px 5%;
            border-radius: 3px;
            overflow: hidden;
        }
        .save_container_buttons{
            padding: 5px 2%;
        }
        .wgbc_noheight{
            height: 0;
        }
        .wgbc_handle{
            float: left;
            display: inline-block;
            background-color: #d0d0d0;
            padding: 0 20px;
            cursor: grab;
            color: #000;
            margin: -20px -6%;
            line-height: 30px;
        }
        .wgbc_metbox_left{
            display: inline-block;
            float: left;
            width: 30%;
        }
        .wgbc_metbox_right{
            display: inline-block;
            float: right;
            width: 30%;
            margin-top: 40px;
        }
        #hidden_input{
            height: 0.1px;
        }
    </style>
    <script type="text/javascript">
        <?php
            global $post;
            $wgbc_slides = get_post_meta( $post->ID );
            $wgbc_slides = unserialize($wgbc_slides['slide'][0]);
        ?>
        add_slide.count = <?php if($wgbc_slides!=NULL){ echo count($wgbc_slides); }else{echo 0;} ?> ;
        function add_slide(){
            add_slide.count = add_slide.count +1;

            var add_slides = document.getElementById("slides_add_container");
            var slide_item = document.createElement('div');
            slide_item.className = 'slide_add_item';
            add_slides.appendChild(slide_item);

            var e = document.createElement('div');
            e.className = 'slidebar'; var t = document.createTextNode("Slide "+add_slide.count );
            e.appendChild(t);
            slide_item.appendChild(e);

            e = document.createElement('input');
            e.type = 'file';
            e.name = 'file'+add_slide.count;
            e.className = 'slide_input';
            slide_item.appendChild(e);

            e = document.createElement('label'); var t = document.createTextNode("Head Caption");
            e.appendChild(t);
            e.className = 'slide_input_label';
            e.setAttribute('for', 'caption_h_'+add_slide.count);
            slide_item.appendChild(e);

            e = document.createElement('input');
            e.type = 'text';
            e.name = 'caption_h_'+add_slide.count;
            e.className = 'input_caption';
            e.setAttribute('id', 'caption_h_'+add_slide.count);
            slide_item.appendChild(e);

            e = document.createElement('label'); var t = document.createTextNode("Caption");
            e.appendChild(t);
            e.className = 'slide_input_label';
            e.setAttribute('for', 'caption_'+add_slide.count);
            slide_item.appendChild(e);

            e = document.createElement('input');
            e.type = 'text';
            e.name = 'caption_'+add_slide.count;
            e.className = 'input_caption';
            e.setAttribute('id', 'caption_'+add_slide.count);
            slide_item.appendChild(e);
        }
    </script>
    <?php
}

/**
 * Save post action, process fields
 */
function update_wgbc_slides( $post_id, $post_object )
{
    // Doing revision, exit earlier **can be removed**
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // Doing revision, exit earlier
    if ( 'revision' == $post_object->post_type )
        return;



    add_filter( 'upload_dir', 'wg_bootstrap_dir' );

    $wgbc_slides = get_post_meta( $post_id );
    $wgbc_captions = unserialize($wgbc_slides['caption'][0]);
    $wgbc_slides = unserialize($wgbc_slides['slide'][0]);



    if( isset($_POST['remove']) ){
        $skip_this = str_replace('Remove','',$_POST['remove']) ;
        $i = 1 ;
        $n = 1 ;
        foreach($wgbc_slides as $wgbc_slide){
            if( $i == $skip_this ){
                $i++;
                $file_name = substr($wgbc_slide['url'], strpos($wgbc_slide['url'],'wgbc') + 5  );
//                if( !unlink( wp_upload_dir()['path'].'/'.$file_name ) ){
//                    echo '1';
//                }
                continue;
            }
            $caption[$n]['head'] = $wgbc_caption['head'];
            $caption[$n]['caption'] = $wgbc_caption['caption'];
            $slide[$n]['url'] = $wgbc_slide['url'];
            $slide[$n]['name'] =  $wgbc_slide['name'];
            $n++;$i++;
        }
        $i = 1 ;
        $n = 1 ;
        foreach($wgbc_captions as $wgbc_caption){
            if( $i == $skip_this ){
                $i++;
                $file_name = substr($wgbc_slide['url'], strpos($wgbc_slide['url'],'wgbc') + 5  );
//                if( !unlink( wp_upload_dir()['path'].'/'.$file_name ) ){
//                    echo '2';
//                }
                continue;
            }
            $caption[$n]['head'] = $wgbc_caption['head'];
            $caption[$n]['caption'] = $wgbc_caption['caption'];
            $n++;$i++;
        }
        update_post_meta( $post_id, 'slide' , $slide );
        update_post_meta( $post_id, 'caption' , $caption );
        return;
    }// end remove
    $n = 0;
    $i = 1;
    $upload_overrides = array( 'test_form' => false ,'unique_filename_callback' => 'wg_bootstrap_silder');


    if($wgbc_slides){// have old information
        foreach($wgbc_slides as $wgbc_slide){
            if( $_FILES['file'.$i]['name'] == '' ){
                if(  isset($_POST['caption_h_'.$i])  ){
                    $caption[$i]['head'] = $_POST['caption_h_'.$i];
                }
                if(  isset($_POST['caption_'.$i])  ){
                    $caption[$i]['caption'] = $_POST['caption_'.$i];
                }
                $slide[$i]['url'] = $_POST['admin_slide'.$i.'_img_url'];
                $slide[$i]['name'] =  $_POST['admin_slide'.$i.'_img_name'];
                $i++;
            }else{
                $uploadedfile = $_FILES['file'.$i];
                $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
                if ( $movefile && !isset( $movefile['error'] ) ) {

                    if(  isset($_POST['caption_h_'.$i])  ){
                        $caption[$i]['head'] = $_POST['caption_h_'.$i];
                    }
                    if(  isset($_POST['caption_'.$i])  ){
                        $caption[$i]['caption'] = $_POST['caption_'.$i];
                    }
                    $file_name = substr($wgbc_slide['url'], strpos($wgbc_slide['url'],'wgbc') + 5  );
//                    if( !unlink( wp_upload_dir()['path'].'/'.$file_name ) ){
//                    }

                    $slide[$i]['url'] = $movefile['url'];
                    $slide[$i]['name'] = $_FILES['file'.$i]['name'];
                    $i++;

                }
            }
        }
    }

    while( $n <= count($_FILES) ){
        if( $_FILES['file'.$n]['name'] != ''  ){
            if( get_post_meta( $post_id, 'slide'.$i) != $_FILES['file'.$n]['name'] ){
                $uploadedfile = $_FILES['file'.$n];
                $upload_overrides = array( 'test_form' => false ,'unique_filename_callback' => 'wg_bootstrap_silder');
                $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
                if ( $movefile && !isset( $movefile['error'] ) ) {

                    if(  isset($_POST['caption_h_'.$i])  ){
                        $caption[$i]['head'] = $_POST['caption_h_'.$n];
                    }
                    if(  isset($_POST['caption_'.$i])  ){
                        $caption[$i]['caption'] = $_POST['caption_'.$n];
                    }

                    $slide[$i]['url'] = $movefile['url'];
                    $slide[$i]['name'] = $_FILES['file'.$n]['name'];
                    $i++;
                }
            }

        }
        $n++;
    }
    update_post_meta( $post_id, 'slide' , $slide );
    update_post_meta( $post_id, 'caption' , $caption );
    remove_filter( 'upload_dir', 'wg_bootstrap_dir' );

    if( isset($_POST['wgbc_caousel_id']) && $_POST['wgbc_caousel_id']!=''){
        $options['id'] = $_POST['wgbc_caousel_id'];
    }
    if( isset($_POST['wgbc_caousel_interval']) && $_POST['wgbc_caousel_interval']!= ''){
        $options['time'] = $_POST['wgbc_caousel_interval'];
    }
    update_post_meta( $post_id, 'options' , $options );

}
