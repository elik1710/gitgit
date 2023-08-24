<?php
/*
 *  Template Part: Product gallery
 *
----------------------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------------------- */

$product = $args['product'];
?>

<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff;"
     class="swiper-container swiper-p-gallery" style="max-width: 100%;">
    <div class="swiper-wrapper">
        <?php
        //        $gallery_slides = get_field("gallery");
        $gallery_slides = get_field("product_gallery");
        //        var_dump($gallery_slides);
        //exit();
        if (!empty($gallery_slides)):
            foreach ($gallery_slides as $gallery_slide) :
                    $attach_url = $gallery_slide['photo']["url"] ?? null;
                if ($gallery_slide["type"] === 'photo'):
                    ?>
                    <div class="swiper-slide gallery-slide">
                        <img src="<?= $attach_url ?>"/>
                    </div>
                <?php
                else:
                    $video_url = $gallery_slide['youtube_video_link'];
                    ?>
                    <div class="swiper-slide gallery-slide"
                    >
                        <img src="<?= $attach_url ?>"/>
                    </div>
                <?php
                endif;
            endforeach;
        endif;
        ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<div class="swiper-container p-gallery-thumbs">
    <div class="swiper-wrapper">
        <?php
        $gallery_slides = get_field("product_gallery");
        if (!empty($gallery_slides)):
            foreach ($gallery_slides

                     as $gallery_slide) :
                $attach_url = $gallery_slide['photo']["url"];
                if ($gallery_slide["type"] === 'photo'):
                    ?>
                    <div class="swiper-slide gallery-slide gallery-slide--thumb"
                         data-type="<?= $gallery_slide['type'] ?>"
                         data-src="<?= $attach_url ?>"
                    >
                        <img src="<?= $attach_url ?>"/>
                    </div>
                <?php
                else:
                    $video_url = $gallery_slide['youtube_video_link'];
                    ?>
                    <div class="swiper-slide gallery-slide gallery-slide--thumb gallery-slide--video"
                         data-video-youtube="<?= $video_url ?>"
                         data-src="<?= $attach_url ?>"
                         data-type="<?= $gallery_slide['type'] ?>"
                    >
                        <img src="<?= $attach_url ?>"/>
                    </div>
                <?php
                endif;
                ?>
            <?php
            endforeach;
        endif;
        ?>
    </div>
</div>
<script>


</script>