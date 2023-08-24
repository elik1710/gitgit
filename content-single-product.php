<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div class="p-gallery-modal" id="p-gallery-modal">
    <div class="p-gallery-modal__header p-gallery-modal-actions">

        <div class="p-gallery-modal-actions__item p-gallery-modal-info">
            <div class="p-gallery-modal-actions__item btn-modal-prev swiper-button-prev" style="
            position: relative;
             width: 40px;
             margin-right:
              10px;
">
            </div>
            <div class="p-gallery-modal-info__item" id="p-gallery-modal-current-slide"></div>
            <div class="p-gallery-modal-info__item">/</div>
            <div class="p-gallery-modal-info__item" id="p-gallery-modal-count-slides"></div>
            <div class="p-gallery-modal-actions__item btn-modal-next swiper-button-next" style="
            position: relative;
             width: 40px;
             margin-left:
              10px;
">

            </div>
        </div>

        <div class="p-gallery-modal-actions__item p-gallery-modal-actions__close">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 x="0px" y="0px"
                 width="15px" height="15px" viewBox="0 0 414.298 414.299"
                 style="enable-background:new 0 0 414.298 414.299;"
                 xml:space="preserve">
<g>
    <path fill="white" d="M3.663,410.637c2.441,2.44,5.64,3.661,8.839,3.661c3.199,0,6.398-1.221,8.839-3.661l185.809-185.81l185.81,185.811
		c2.44,2.44,5.641,3.661,8.84,3.661c3.198,0,6.397-1.221,8.839-3.661c4.881-4.881,4.881-12.796,0-17.679l-185.811-185.81
		l185.811-185.81c4.881-4.882,4.881-12.796,0-17.678c-4.882-4.882-12.796-4.882-17.679,0l-185.81,185.81L21.34,3.663
		c-4.882-4.882-12.796-4.882-17.678,0c-4.882,4.881-4.882,12.796,0,17.678l185.81,185.809L3.663,392.959
		C-1.219,397.841-1.219,405.756,3.663,410.637z"/>
</svg>
        </div>
    </div>
    <div class="p-gallery-modal__content" style="position: relative; overflow: hidden">
        <div
                class="swiper-container swiper-p-gallery-modal" style="max-width: 100%; ">
            <div class="swiper-wrapper">
                <?php
                $gallery_slides = get_field("product_gallery");
                if (!empty($gallery_slides)):
                    foreach ($gallery_slides

                             as $gallery_slide) :
                        $attach_url = $gallery_slide['photo']["url"];
                        if ($gallery_slide["type"] === 'photo'):
                            ?>
                            <div class="swiper-slide gallery-slide-modal "
                            >
                                <div class="swiper-zoom-container">
                                    <img class="p-gallery-image" src="<?= $attach_url ?>"/>

                                </div>
                            </div>
                        <?php
                        else:
                            $video_url = $gallery_slide['youtube_video_link'];
                            ?>

                            <div class="swiper-slide gallery-slide-modal"
                            >
                                <iframe class="yt-player-iframe" style="width: 95%; height: 95%"
                                        src="<?= $video_url . "?&enablejsapi=1" ?>"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>
                        <?php
                        endif;
                        ?>
                    <?php
                    endforeach;
                endif; ?>
            </div>

        </div>

    </div>
    <div class="p-gallery-modal__footer gallery-modal-footer">
        <p style="color: white"><?= $product->get_name() ?></p>
    </div>
</div>
<script>


    document.addEventListener('DOMContentLoaded', function () {
        var gallerySwiperModal = new Swiper(".swiper-p-gallery-modal", {
            spaceBetween: 0,
            slidesPerView: 1,
            loop: true,
            zoom: {
                toggle: true,
                maxRatio: 6
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

        });

        gallerySwiperModal.init(gallerySwiperModal);

        gallerySwiperModal.on("slideChange", function () {
            let slidesIndex = document.getElementById("p-gallery-modal-current-slide");
            slidesIndex.innerText = gallerySwiperModal.realIndex + 1;
            document.querySelectorAll('.yt-player-iframe').forEach(function (item) {
                item.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
            });
        });

        var gallerySwiperThumbs = new Swiper(".p-gallery-thumbs", {
            spaceBetween: 10,
            slidesPerView: 4,
        });
        var gallerySwiper = new Swiper(".swiper-p-gallery", {
            spaceBetween: 0,
            slidesPerView: 1,
            thumbs: {
                swiper: gallerySwiperThumbs,
            },
        });
        let thumbs = document.querySelectorAll('.gallery-slide--thumb');
        let pGalleryModal = document.getElementById("p-gallery-modal");

        thumbs.forEach(function (item, index) {
            item.addEventListener("click", function (e) {
                pGalleryModal.classList.toggle("p-gallery-modal--active");
                document.body.classList.toggle('body--scroll-disabled');
                let slidesCounter = document.getElementById("p-gallery-modal-count-slides");
                slidesCounter.innerText = gallerySwiperModal.slides.length - 2;
                gallerySwiperModal.slideToLoop(index);
            });
        });
         thumbs.forEach(function (item, index) {
            item.addEventListener("mousemove", function (e) {
                gallerySwiper.slideTo(index);
            });
        });

        let closeBtn = document.querySelector('.p-gallery-modal-actions__close');
        closeBtn.addEventListener("click", function () {
            pGalleryModal.classList.toggle("p-gallery-modal--active");
            document.body.classList.remove('body--scroll-disabled');
            document.querySelectorAll('.yt-player-iframe').forEach(function (item) {
                item.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
            });
        });


    });
</script>

<section id="product-<?php the_ID(); ?>" class="product-page">
    <div class="product-preview-wrapper" id="banner-popup" style="display: none;">
        <div class="product-page__item product-preview">
            <div class="product-preview__image">
                <img src="<?php echo get_template_directory_uri() . "/media/relive-balance.png"; ?>"
                     alt="Relive Balance">
            </div>

            <div class="product-preview__item">
                <p class="product-info__title">
                    <span class="title--brand">Relive Balance ®</span></br>
                    – нутрієнти для активного довголіття
                </p>
            </div>

        </div>
    </div>


    <div class="product-page__item frame">
        <div class="frame__item frame__item-main">

            <?php //echo get_template_directory_uri() . "/media/relive-balance.png"; ?>
            <div class="sticky-container sticky-container--offset-top sticky-container--products"
                 style="flex-flow: column nowrap">

                 <div class="frame__item frame__info">
                    <?php $productNames = get_field('product_names');
                    if (!empty($productNames)): ?>
                    <p class="product-info__title"><span
                                class="product-info__title--big"><?= $productNames; ?></span><?php endif; ?> – <br>
                          <?php $productDes = get_field('product_des');
if (!empty($productDes)): ?>
<?= $productDes; ?>
<?php endif; ?></p>
                </div>
				
				
                <div class="frame__item frame__gallery">
                    <?php
                    get_template_part("template-parts/product/gallery-slider", null, [
                        'product' => $product
                    ]);
                    ?>
                </div>
                <div class="frame__image" style="display: none">
                    <img class="wp-post-image"
                         src="<?php echo wp_get_attachment_image_src($product->get_image_id(), 'full')[0]; ?>"
                         alt="Relive Balance">
                </div>

                <div class="frame__item">
                    <div class="product-page__item product-info product-info--price" style="padding-bottom: 20px;">
                        <div>
                            <?php woocommerce_template_single_price(); ?>
                            <?php woocommerce_template_single_add_to_cart(); ?>
                            <div class="buy-in-one-click-js" data-fancybox data-touch="false"
                                 data-src="#a-modal-consult">
                                Купити в 1
                                клік
                            </div>
                            <div class="buy-in-two-click-js" data-fancybox data-touch="false"
                                 data-src="#modal-consult"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>




 <div class="frame__item frame__item-main product-info product-info--shadow">
  <?php $productTitle = get_field('product_title'); ?>
  <?php if (!empty($productTitle)): ?>

    <p class="product-info__item product-info__name product-info__item--pb-0"><?= $productTitle; ?></p>
  <?php endif; ?>

  <?php $productTitlecopy = get_field('product_title_copy'); ?>
  <?php if (!empty($productTitlecopy)): ?>
   
    <p class="product-info__item product-info__name product-info__item--pb-0 product-title-copy"><?= $productTitlecopy; ?></p> 
  <?php endif; ?>

            <div class="product-info__item info-card ">
                <h2 class="info-card__item info-card__header product-info__title">
                    <?php $subtitle_indication_for_use = get_field('subtitle_indication_for_use');
                    if (!empty($productTitle)): ?>
                    <span class="title--brand"> <?= $subtitle_indication_for_use; ?></span>
                </h2>
                <?php endif; ?>

                <?php

                $indications = get_field('indication_for_use');
                if ($indications) { ?>
                    <ul class="info-card__item custom-list">
						
                        <?php foreach ($indications as $key => $item):
                            if ($item): ?>
                                <li><?php echo $indications[$key]['text']; ?></li>
                            <?php
                            endif;
                        endforeach; ?>
                    </ul>

                <?php }
                if (!empty($indicationsSubtitle)):?>
                    <p class="info-card__item info-card__text"><?= $indicationsSubtitle; ?></p>
                <?php endif; ?>
				
            </div>
<span class="toggle-button product-info__item product-info__name product-info__item--pb-0"> для тих хто любить багато читати ▼</span>
	
	 
	 
	 
            <?php
            $idImage = get_field('first_image')["ID"];
            $size = 'full';
            if ($idImage) :
                ?>
	 <div class="product-title-copy">
                <div class="product-info__image">
                    <img src="<?php echo wp_get_attachment_image_src($idImage, $size)[0]; ?>" alt="Image">
                </div>
            <?php endif; ?>

            <?php
            $shortDesc = get_field("short_desc");
            if ($shortDesc !== null):
                ?>
                <p class="product-info__item product-info__text">
                    <?php echo $shortDesc ?>
                </p>

            <?php endif ?>

            <?php $group_fields = get_field('composition'); ?>

            <?php if ($group_fields) { ?>

                <div class="product-info__item info-card product-title-copy">
                    <h2 class="info-card__header product-info__title">
                        Нуртієнтна цінність комплексу :
                    </h2>
                    <div class="dropdowns-list">
                        <?php foreach ($group_fields as $key => $item) { ?>
                            <div class="accordion-container">
                                <div class="dropdowns-list__item accordion-btn collapsed" type="button"
                                     data-toggle="collapse"
                                     data-target="#collapse-compose<?= $key; ?>" aria-expanded="false"
                                     aria-controls="collapse-compose<?= $key; ?>">
                                    <div class="accordion-btn__title accordion-btn__title--deep-blue">
                                        <?php echo $item["title"]; ?>
                                    </div>
                                    <div class="accordion-btn__marker accordion-btn__marker--small">
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='currentColor'>
                                            <path fill-rule='evenodd'
                                                  d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="void-keeper">
                                    <div class="collapse" id="collapse-compose<?= $key; ?>" style="">
                                        <div class="accordion-content">
                                            <p>
                                                <?php echo $item["text"]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            <?php } ?>


            <?php
            $origin = get_field("origin");
            if ($origin !== null):
                ?>
                <div class="product-info__item product-info__item--dark-blue info-block-big">
                    <div class="info-block-big__icon">
                        <img src="<?php echo get_template_directory_uri() . "/media/microscope-grow.svg"; ?>" alt="">
                    </div>
                    <div class="info-block-big__content">
                        <p class="product-info__title"><?= "Оригінальна технологія " ?></p>
                        <p class="product-info__text"><?= $origin; ?></p>
                    </div>
                </div>

            <?php endif ?>



            <?php
            $complexDesc = get_field("complex_desc");
            if ($complexDesc !== null):
                ?>

                <div class="product-info__item">
                    <p class="product-info__title title"><?= 'Комплекси <span class="title--brand">Relive Balance <sup><span
                                        style="font-size: 12px;">Ⓡ</sup></span></span>'; ?>
                    </p>
                    <p class="product-info__text"><?= $complexDesc; ?></p>
                </div>

            <?php endif ?>




            <?php
            $idImage = get_field('second_image')["ID"];
            $size = 'full';
            if ($idImage) :
                ?>
                <div class="product-info__image">
                    <img src="<?php echo wp_get_attachment_image_src($idImage, $size)[0]; ?>" alt="Image">
                </div>
            <?php endif; ?>

            <div class="product-info__item info-card">
                <h2 class="info-card__item info-card__header product-info__title">
                    <?php $uniqueness = get_field('uniqueness');

                    if (!empty($uniqueness)): ?>Унікальність <span class="title--brand"><?= $productNames; ?></span>
                </h2>
                <?php endif; ?>
                <?php
                $uniqueness = get_field('uniqueness');
                $uniquenessSubtitle = get_field('subtitle_uniqueness');
                ?>

                <?php if ($uniqueness) { ?>

                    <ul class="info-card__item custom-list">
                        <?php foreach ($uniqueness as $key => $item) { ?>
                            <?php if ($item) { ?>
                                <li><?php echo $uniqueness[$key]['text']; ?></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>

                <?php }
                if (!empty($uniquenessSubtitle)):?>
                    <p class="info-card__item info-card__text"><?= $uniquenessSubtitle; ?></p>
                <?php endif; ?>
            </div>


            <?php
            $descWithIcon = get_field("desc_with_icon");
            if ($descWithIcon !== null):
                ?>
                <div class="dropdown-content accordion-container product-info__item product-info__item--dark-blue info-block-small">
                    <div class="accordion-btn collapsed" type="button"
                         data-toggle="collapse"
                         data-target="#collapse-compose<?= "micro-1"; ?>" aria-expanded="false"
                         aria-controls="collapse-compose<?= "micro-1"; ?>" style="width: 100%;">
                        <div class="accordion-btn__title" style="display: flex; flex-flow: row nowrap;">
                            <div class="info-block-small__icon ">
                                <img src="<?php echo get_template_directory_uri() . "/media/microscope.svg"; ?>" alt="">
                            </div>
                            <div class="content-dropdown__title info-block-small__text product-info__text"
                                 style="color: white;">
                                <div>
                                    <?php echo $descWithIcon["title"]; ?>
                                    <div class="accordion-btn__marker accordion-btn__marker--small"
                                         style="margin-left: 10px; display: inline-flex; height: 20px; width: 20px; outline: solid 1px white;">
                                        <svg width="20" height="20" xmlns='http://www.w3.org/2000/svg'
                                             viewBox='0 0 16 16' fill='currentColor'>
                                            <path fill-rule='evenodd'
                                                  d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="void-keeper" style="width: 100%;">
                                    <div class="collapse" id="collapse-compose<?= "micro-1"; ?>" style="">
                                        <div class="accordion-content"
                                             style="width: 100%; display: flex; flex-flow: row nowrap;">
                                            <div class="info-block-small__text product-info__text"
                                                 style="font-weight: normal; max-width: 100%; word-break: break-word;">
                                                <?php echo $descWithIcon["content"]; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="void-keeper" style="width: 100%;">-->
                    <!--                        <div class="collapse" id="collapse-compose--><? //= "micro-1";
                    ?><!--" style="">-->
                    <!--                            <div class="accordion-content" style="width: 100%; display: flex; flex-flow: row nowrap;">-->
                    <!--                                <div class="info-block-small__icon info-block-small__icon--dropdown" style="opacity: 0;">-->
                    <!--                                    <img src="-->
                    <?php //echo get_template_directory_uri() . "/media/microscope.svg";
                    ?><!--" alt="">-->
                    <!--                                </div>-->
                    <!--                                <div class="info-block-small__text product-info__text" style="font-weight: normal;">-->
                    <!--                                    --><?php //echo $descWithIcon["content"];
                    ?>
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>

            <?php endif ?>
	</div> </div>
		
	 
	 
	 <script>
  jQuery('.toggle-button').on('click', function() {
    jQuery(this).toggleClass('active');
    jQuery('.product-title-copy').slideToggle();
  });
</script>


<style>
  .product-title-copy {
    display: none;
  }

  .toggle-button {
    cursor: pointer;
    color: #fff;
    background: #2b52c4;
    padding: 5px 15px 5px 15px;
	display: inline-block;
  }

.toggle-button::after {
    content: "";
        color: #fff;
    background: #2b52c4;
    #padding: 5px 15px 5px 15px;

  }

.toggle-button.active::after {
    content: " ▲";
        color: #fff;
    background: #2b52c4;
    #padding: 5px 15px 5px 15px;
    }
</style>
        <div class="product-page__item product-info product-info--price-mobile" style="padding-bottom: 20px;">
            <div>
                <?php woocommerce_template_single_price(); ?>
                <?php woocommerce_template_single_add_to_cart(); ?>
                <div class="buy-in-one-click-js" data-fancybox data-touch="false" data-src="#a-modal-consult">Купить в 1
                    клик
                </div>
                <div class="buy-in-two-click-js" data-fancybox data-touch="false" data-src="#modal-consult"></div>
            </div>
        </div>


    </div>
    <div class="product-page__item row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0; padding-right: 0;">
            <?php woocommerce_output_product_data_tabs(); ?>
        </div>
    </div>
    <!------------------------------------------------------------------------->
    <div style="display: none;" id="a-modal-consult">
        <div class="title">Заповніть форму і ми <br/> обов'язково з Вами зв'яжемось!</div>
        <?php echo do_shortcode('[contact-form-7 id="719" title="Contact form 1"]'); ?>
    </div>
    <!------------------------------------------------------------------------->
    <div style="display: none;" id="modal-consult">
        <div class="title">Дякуємо!</div>
        <p>Ми зв’яжемось з Вами найближчим часом.</p>
        <p>Залишайтесь із нами на зв’язку – підпишісься на<br>Tobeplus у соціальних мережах та будьте в курсі<br>останніх
            новин:</p>
        <ul class="socials">

            <li><a href="<? echo $socials['facebook']; ?>" target="_blank" rel="noopener noreferrer"><i
                            class="iconify" data-icon="cib:facebook-f"></i></a></li>
            <li><a href="<? echo $socials['youtube']; ?>" target="_blank" rel="noopener noreferrer"><i
                            class="iconify" data-icon="cib:youtube"></i></a></li>
            <li><a href="<? echo $socials['instagram']; ?>" target="_blank" rel="noopener noreferrer"><i
                            class="iconify" data-icon="cib:instagram"></i></a></li>

        </ul>
    </div>
</section>

<?php
// Template Sections: Postline
get_template_part('template-sections/section', 'products-carousel');

get_template_part('template-sections/section', 'postline-new');
?>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script type="text/javascript">

    (function ($) {

        const prodInfo = document.querySelector(".product-page__item.frame");

        $(document).scroll(function () {
            var y = $(this).scrollTop();
            if (y > (prodInfo.scrollTop + prodInfo.offsetHeight)) {
                $('#banner-popup').fadeIn();
            } else {
                $('#banner-popup').fadeOut();
            }
        });

        $('.wpcf7-form.init').submit(function () {
            if ($('.wpcf7-form-control').val() == '') {
                return;
            }

            if ($('.wpcf7-tel').val() == '') {
                return;
            }
            $.fancybox.close(true);
            $('.buy-in-two-click-js').trigger('click');

        });


        $('#phone-mask-2').inputmask("+380(99) 999-99-99");

        // var phoneMask2 = IMask(
        //   document.getElementById('phone-mask-2'), {
        //     mask: '+{38O}(00)000-00-00'
        //   });

        $(document).on('click', '.qty_button.plus', function (e) {
            e.preventDefault();

            var $thisbutton = $('.single_add_to_cart_button.button.alt'),
                $form = $thisbutton.closest('form.cart'),
                id = $thisbutton.val(),
                product_qty = 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input[name=variation_id]').val() || 0;

            var data = {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: product_id,
                product_sku: '',
                quantity: product_qty,
                variation_id: variation_id,
            };

            $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: data,
                beforeSend: function (response) {
                    $thisbutton.removeClass('added').addClass('loading');
                },
                complete: function (response) {
                    $thisbutton.addClass('added').removeClass('loading');
                },
                success: function (response) {

                    if (response.error && response.product_url) {
                        window.location = response.product_url;
                        return;
                    } else {
                        var pcount = $('.mini-cart__button .count')[0];
                        pcount = $(pcount).text();

                        pcount = parseInt(pcount);
                        var nepcount = pcount + parseInt(product_qty);

                        $('.mini-cart__button .count').text(nepcount);

                        $('.notif-card').remove();

                        $('body').append('<div style="display:block;" class="notif-card" data-aos="fade-down"><div class="widget_shopping_cart_content-notif"><div class="ttt">Товар додано у кошик</div>' +
                            '<ul class="woocommerce-mini-cart-notif cart_list-notif product_list_widget-notif">' +
                            '<li class="woocommerce-mini-cart-item-notif mini_cart_item-notif"><a>' +
                            '<img width="150" height="150" src="' + $('.wp-post-image').attr('src') + '" class="attachment-woocommerce_thumbnail-notif size-woocommerce_thumbnail-notif" alt="" loading="lazy">' + $('.entry-title').text() + '</a>' +
                            '<span class="quantity-notif">1 × <span class="woocommerce-Price-amount amount">' +
                            '<bdi>' + $('.price .woocommerce-Price-amount').eq(0).find('bdi').html() +
                            '</bdi>' +
                            '</span>' +
                            '</span>' +
                            '</li>' +
                            '</ul><p class="woocommerce-mini-cart__buttons-notif buttons-notif"><a href="/cart" class="button wc-forward">В кошик</a><a href="/checkout" class="button checkout wc-forward">Оформити замовлення</a></p></div></div>');

                        setTimeout(function (e) {
                            $('.notif-card').removeClass('aos-animate');
                            $('.notif-card').remove();
                        }, 4000);

                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    }
                },
            });

        });

        $(document).on('click', '.qty_button.minus', function (e) {
            var newCount = $('.mini-cart__button .count').text();

            newCount = parseInt(newCount);

            var $thisbutton = $('.single_add_to_cart_button.button.alt'),
                $form = $thisbutton.closest('form.cart'),
                id = $thisbutton.val(),
                product_qty = 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input[name=variation_id]').val() || 0;

            var data = {
                action: 'woocommerce_ajax_remove_from_cart',
                product_id: product_id,
                quantity: product_qty,
                newCount: newCount,
            };

            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: data,
                beforeSend: function (response) {
                    $thisbutton.removeClass('added').addClass('loading');
                },
                complete: function (response) {
                    $thisbutton.addClass('added').removeClass('loading');
                },
                success: function (response) {

                    if (response.error && response.product_url) {
                        window.location = response.product_url;
                        return;
                    } else {

                        var pcount = $('.mini-cart__button .count')[0];
                        pcount = $(pcount).text();

                        pcount = parseInt(pcount);

                        var nepcount = pcount <= 1 ? 1 : pcount - parseInt(product_qty);

                        $('.mini-cart__button .count').text(nepcount);

                        $(document.body).trigger('removed_from_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    }
                },
            });

        });

        $(document).on('click', '.single_add_to_cart_button', function (e) {

            $(this).hide();
            e.preventDefault();

            var $thisbutton = $('.single_add_to_cart_button.button.alt'),
                $form = $thisbutton.closest('form.cart'),
                id = $thisbutton.val(),
                product_qty = 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input[name=variation_id]').val() || 0;

            var data = {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: product_id,
                product_sku: '',
                quantity: product_qty,
                variation_id: variation_id,
            };

            $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: data,
                beforeSend: function (response) {
                    $thisbutton.removeClass('added').addClass('loading');
                },
                complete: function (response) {
                    $thisbutton.addClass('added').removeClass('loading');
                },
                success: function (response) {

                    if (response.error && response.product_url) {
                        window.location = response.product_url;
                        return;
                    } else {

                        var pcount = $('.mini-cart__button .count')[0];
                        pcount = $(pcount).text();

                        pcount = parseInt(pcount);
                        var nepcount = pcount + parseInt(product_qty);

                        $('.mini-cart__button .count').text(nepcount);

                        $('.notif-card').remove();

                        $('body').append('<div class="notif-card" data-aos="fade-down"><div class="widget_shopping_cart_content-notif"><div class="ttt">Товар додано у кошик</div>' +
                            '<ul class="woocommerce-mini-cart-notif cart_list-notif product_list_widget-notif">' +
                            '<li class="woocommerce-mini-cart-item-notif mini_cart_item-notif"><a>' +
                            '<img width="150" height="150" src="' + $('.wp-post-image').attr('src') + '" class="attachment-woocommerce_thumbnail-notif size-woocommerce_thumbnail-notif" alt="" loading="lazy">' + $('.entry-title').text() + '</a>' +
                            '<span class="quantity-notif">1 × <span class="woocommerce-Price-amount amount">' +
                            '<bdi>' + $('.price .woocommerce-Price-amount').eq(0).find('bdi').html() +
                            '</bdi>' +
                            '</span>' +
                            '</span>' +
                            '</li>' +
                            '</ul><p class="woocommerce-mini-cart__buttons-notif buttons-notif"><a href="/cart" class="button wc-forward">В кошик</a><a href="/checkout" class="button checkout wc-forward">Оформити замовлення</a></p></div></div>');

                        setTimeout(function (e) {
                            $('.notif-card').removeClass('aos-animate');
                            $('.notif-card').remove();
                        }, 4000);

                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    }
                },
            });

            $('.quantity.ddd').css({
                'display': 'flex'
            });

            return false;
        });
    })(jQuery);
</script>
<?php
do_action('woocommerce_after_single_product'); ?>

