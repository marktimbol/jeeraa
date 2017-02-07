<?php 
$header_bg_color = classifieds_get_option( 'header_bg_color' );
$navigation_font_color = classifieds_get_option( 'navigation_font_color' );
$navigation_font_color_hvr = classifieds_get_option( 'navigation_font_color_hvr' );
$submit_btn_bg_color = classifieds_get_option( 'submit_btn_bg_color' );
$submit_btn_font_color = classifieds_get_option( 'submit_btn_font_color' );
$submit_btn_bg_color_hvr = classifieds_get_option( 'submit_btn_bg_color_hvr' );
$submit_btn_font_color_hvr = classifieds_get_option( 'submit_btn_font_color_hvr' );

$footer_bg_color = classifieds_get_option( 'footer_bg_color' );
$footer_font_color = classifieds_get_option( 'footer_font_color' );
$footer_link_color = classifieds_get_option( 'footer_link_color' );
$footer_link_color_hvr = classifieds_get_option( 'footer_link_color_hvr' );

$copyright_bg_color = classifieds_get_option( 'copyright_bg_color' );
$copyright_font_color = classifieds_get_option( 'copyright_font_color' );
$copyright_link_color = classifieds_get_option( 'copyright_link_color' );
$copyright_link_color_hvr = classifieds_get_option( 'copyright_link_color_hvr' );

$btn1_bg_color = classifieds_get_option( 'btn1_bg_color' );
$btn1_font_color = classifieds_get_option( 'btn1_font_color' );
$btn1_bg_color_hvr = classifieds_get_option( 'btn1_bg_color_hvr' );
$btn1_font_color_hvr = classifieds_get_option( 'btn1_font_color_hvr' );

$btn2_bg_color = classifieds_get_option( 'btn2_bg_color' );
$btn2_font_color = classifieds_get_option( 'btn2_font_color' );
$btn2_bg_color_hvr = classifieds_get_option( 'btn2_bg_color_hvr' );
$btn2_font_color_hvr = classifieds_get_option( 'btn2_font_color_hvr' );

$body_links_color = classifieds_get_option( 'body_links_color' );

$expired_badge_bg_color = classifieds_get_option( 'expired_badge_bg_color' );
$expired_badge_font_color = classifieds_get_option( 'expired_badge_font_color' );

$pending_badge_bg_color = classifieds_get_option( 'pending_badge_bg_color' );
$pending_badge_font_color = classifieds_get_option( 'pending_badge_font_color' );

$live_badge_bg_color = classifieds_get_option( 'live_badge_bg_color' );
$live_badge_font_color = classifieds_get_option( 'live_badge_font_color' );

$not_paid_badge_bg_color = classifieds_get_option( 'not_paid_badge_bg_color' );
$not_paid_badge_font_color = classifieds_get_option( 'not_paid_badge_font_color' );

$off_badge_bg_color = classifieds_get_option( 'off_badge_bg_color' );
$off_badge_font_color = classifieds_get_option( 'off_badge_font_color' );

$ad_form_btn_bg_color = classifieds_get_option( 'ad_form_btn_bg_color' );
$ad_form_btn_bg_color_hvr = classifieds_get_option( 'ad_form_btn_bg_color_hvr' );
$ad_form_btn_font_color = classifieds_get_option( 'ad_form_btn_font_color' );
$ad_form_btn_font_color_hvr = classifieds_get_option( 'ad_form_btn_font_color_hvr' );

$single_ad_price_size = classifieds_get_option( 'single_ad_price_size' );

$site_logo_padding = classifieds_get_option( 'site_logo_padding' );

$theme_font = classifieds_get_option( 'theme_font' );
?>

/* Classifieds Colors
------------------------------------------------------------- */
/* header bg color and dropdowns bg color - - - */
.navigation .navbar-default .navbar-collapse .open > .dropdown-menu li,
.navigation .navbar-default .navbar-collapse .dropdown-menu li,
.navigation {
    background-color: <?php echo  $header_bg_color ?>;
}
/* navigation font colors - - - */
.navigation .navbar-default .navbar-collapse ul li a {
    color: <?php echo  $navigation_font_color ?>;
}
/* - hover & active - */
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_price_filter form .price_slider_wrapper .ui-widget-content .ui-slider-handle,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_price_filter form .price_slider_wrapper .ui-widget-content .ui-slider-range,
.navigation .navbar-default .navbar-collapse ul li:not(.submit-add) a:hover,
.navigation .navbar-default .navbar-collapse ul li a:hover,
.navigation .navbar-default .navbar-collapse ul li.current-menu-item > a,
.navigation .navbar-default .navbar-collapse ul li a.login-action {
    color: <?php echo  $navigation_font_color_hvr ?>;
}
/* submit ad button - - - */
/* - bg & font color -*/
.navigation .navbar-default .navbar-collapse ul li a.btn {
    background-color: <?php echo  $submit_btn_bg_color ?>;
}
.navigation .navbar-default .navbar-collapse ul li a.btn {
    color: <?php echo  $submit_btn_font_color ?>;
}
/* - on hover - */
.navigation .navbar-default .navbar-collapse ul li a.btn:hover,
.navigation .navbar-default .navbar-collapse ul li a.btn:active,
.navigation .navbar-default .navbar-collapse ul li a.btn:focus {
    background-color: <?php echo  $submit_btn_bg_color_hvr ?>;
}
.navigation .navbar-default .navbar-collapse ul li a.btn:hover,
.navigation .navbar-default .navbar-collapse ul li a.btn:active,
.navigation .navbar-default .navbar-collapse ul li a.btn:focus {
    color: <?php echo  $submit_btn_font_color_hvr ?>;
}

/* footer bg color - - - */
.widget-footer {
    background-color: <?php echo  $footer_bg_color ?>;
}
/* footer font color - - - */
.widget-footer,
.widget-footer p,
.widget-footer .widget_classifieds_logo_text p,
.widget-footer .widget h4,
.widget-footer ul li {
    color: <?php echo  $footer_font_color ?>;
}
/* footer link color - - - */
.widget-footer .widget_classifieds_follow_us .widget-social a,
.widget-footer ul li a {
    color: <?php echo  $footer_link_color ?>;
}
/* - on hover -*/
.widget-footer .widget_classifieds_follow_us .widget-social a:hover,
.widget-footer ul li a:hover {
    color: <?php echo  $footer_link_color_hvr ?>;
}
/* footer link that are same on static and on hover - - - */
.widget-footer a,
.widget-footer p a,
.widget-footer a:hover,
.widget-footer p a:hover {
    color: <?php echo  $footer_link_color_hvr ?>;
}

/* Copyrights - - - - - */
/* copyrights bg color*/
.footer {
    background-color: <?php echo  $copyright_bg_color ?>;
}
/* copyrights font color - - - */
.footer {
    color: <?php echo  $copyright_font_color ?>;
}
/* copyrights link color - - - */
.footer a {
    color: <?php echo  $copyright_link_color ?>;
}
/* - on hover - */
.footer a:hover {
    color: <?php echo  $copyright_link_color_hvr ?>;
}

/* Button 1 - - - - - */
/* background - - - */
.woocommerce-account .white-block .white-block-content .page-content .woocommerce form .form-row input.button,
.woocommerce-cart .woocommerce table.cart tbody input[name="apply_coupon"],
.woocommerce-cart .woocommerce table.cart tbody input[name="update_cart"],
.woocommerce.single #respond input#submit.alt,
.woocommerce.single a.button.alt,
.woocommerce.single button.button.alt,
.woocommerce.single input.button.alt .single_add_to_cart_button.button.alt,
.woocommerce .container .woocommerce-message a.wc-forward,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .buttons a,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_product_search form input[type="submit"],
.woocommerce-account.woocommerce-edit-address .white-block .white-block-content .page-content .woocommerce p input[type="submit"],
.woocommerce-account.woocommerce-edit-account .white-block .white-block-content .page-content .woocommerce p input[type="submit"],
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_price_filter form .price_slider_wrapper .price_slider_amount button,
.woocommerce ul.products li.product a.button,
.woocommerce ul.products li.product a.wc-forward,
.btn,
.page-template-page-tpl_my_profile .tab-content .tab-pane a.submit-form, .archive.author .tab-content .tab-pane a.submit-form,
.checkbox input[type="checkbox"]:checked + label::after,
.clients-bar{
    background-color: <?php echo  $btn1_bg_color ?>;
}

.checkbox label::before{
	border-color: <?php echo  $btn1_bg_color ?>;
}

/* - bg on hover */
.woocommerce-account .white-block .white-block-content .page-content .woocommerce form .form-row input.button:hover,
.woocommerce-cart .woocommerce table.cart tbody input[name="apply_coupon"]:hover,
.woocommerce-cart .woocommerce table.cart tbody input[name="update_cart"]:hover,
.woocommerce.single #respond input#submit.alt:hover,
.woocommerce.single a.button.alt:hover,
.woocommerce.single button.button.alt:hover,
.woocommerce.single input.button.alt .single_add_to_cart_button.button.alt:hover,
.woocommerce .container .woocommerce-message a.wc-forward:hover,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .buttons a:hover,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_product_search form input[type="submit"]:hover,
.woocommerce-account.woocommerce-edit-address .white-block .white-block-content .page-content .woocommerce p input[type="submit"]:hover,
.woocommerce-account.woocommerce-edit-account .white-block .white-block-content .page-content .woocommerce p input[type="submit"]:hover,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_price_filter form .price_slider_wrapper .price_slider_amount button:hover,
.woocommerce ul.products li.product a.button:hover,
.woocommerce ul.products li.product a.wc-forward:hover,
.btn:hover,
.btn:active,
.btn:focus,
.page-template-page-tpl_my_profile .tab-content .tab-pane a.submit-form:hover, .archive.author .tab-content .tab-pane a.submit-form:hover{
    background-color: <?php echo  $btn1_bg_color_hvr ?>;
}
/* font color - */
.woocommerce-account .white-block .white-block-content .page-content .woocommerce form .form-row input.button,
.woocommerce-cart .woocommerce table.cart tbody input[name="apply_coupon"],
.woocommerce-cart .woocommerce table.cart tbody input[name="update_cart"],
.woocommerce.single #respond input#submit.alt,
.woocommerce.single a.button.alt,
.woocommerce.single button.button.alt,
.woocommerce.single input.button.alt .single_add_to_cart_button.button.alt,
.woocommerce .container .woocommerce-message a.wc-forward,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .buttons a,
.woocommerce-account.woocommerce-edit-address .white-block .white-block-content .page-content .woocommerce p input[type="submit"],
.woocommerce-account.woocommerce-edit-account .white-block .white-block-content .page-content .woocommerce p input[type="submit"],
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_product_search form input[type="submit"],
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_price_filter form .price_slider_wrapper .price_slider_amount button,
.woocommerce ul.products li.product a.button,
.woocommerce ul.products li.product a.wc-forward,
.btn,
.page-template-page-tpl_my_profile .tab-content .tab-pane a.submit-form, .archive.author .tab-content .tab-pane a.submit-form{
    color: <?php echo  $btn1_font_color ?>;
}
/* font color on hover - */
.woocommerce-account .white-block .white-block-content .page-content .woocommerce form .form-row input.button:hover,
.woocommerce-cart .woocommerce table.cart tbody input[name="apply_coupon"]:hover,
.woocommerce-cart .woocommerce table.cart tbody input[name="update_cart"]:hover,
.woocommerce.single #respond input#submit.alt:hover,
.woocommerce.single a.button.alt:hover,
.woocommerce.single button.button.alt:hover,
.woocommerce.single input.button.alt .single_add_to_cart_button.button.alt:hover,
.woocommerce .container .woocommerce-message a.wc-forward:hover,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .buttons a:hover,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_product_search form input[type="submit"]:hover,
.woocommerce-account.woocommerce-edit-address .white-block .white-block-content .page-content .woocommerce p input[type="submit"]:hover,
.woocommerce-account.woocommerce-edit-account .white-block .white-block-content .page-content .woocommerce p input[type="submit"]:hover,
.woocommerce .col-md-9 + .col-md-3 .widget.woocommerce.widget_price_filter form .price_slider_wrapper .price_slider_amount button:hover,
.woocommerce ul.products li.product a.button:hover,
.woocommerce ul.products li.product a.wc-forward:hover,
.btn:hover,
.btn:active,
.btn:focus,
.page-template-page-tpl_my_profile .tab-content .tab-pane a.submit-form:hover, .archive.author .tab-content .tab-pane a.submit-form:hover{
    color: <?php echo  $btn1_font_color_hvr ?>;
}

/* Button 2 - - - - - */
/* background - - - */
.form-register a,
#login .form-login .submit-form-ajax,
.contact-page .white-block-content form a,
#commentform .form-submit input,
.blog .load-more,
.col-md-6:first-child .pricing-box .pricing-info a,
.hiw .col-md-6 a.btn,
.col-md-6:first-child .pricing-box .pricing-info a,
.section-banner .banner-content .btn,
.home .all-ads a{
    background-color: <?php echo  $btn2_bg_color ?>;
}

/* - bg on hover - */
.form-register a:hover,
#login .form-login .submit-form-ajax:hover,
.contact-page .white-block-content form a:hover,
#commentform .form-submit input:hover,
.blog .load-more:hover,
.col-md-6:first-child .pricing-box .pricing-info a:hover,
.hiw .col-md-6 a.btn:hover,
.col-md-6:first-child .pricing-box .pricing-info a:hover,
.section-banner .banner-content .btn:hover,
.home .all-ads a:hover {
    background-color: <?php echo  $btn2_bg_color_hvr ?>;
}
/* font color - */
.form-register a,
#login .form-login .submit-form-ajax,
.contact-page .white-block-content form a,
#commentform .form-submit input,
.blog .load-more,
.col-md-6:first-child .pricing-box .pricing-info a,
.hiw .col-md-6 a.btn,
.col-md-6:first-child .pricing-box .pricing-info a,
.section-banner .banner-content .btn,
.home .all-ads a {
    color: <?php echo  $btn2_font_color ?>;
}
/* font color on hover - */
.form-register a:hover,
#login .form-login .submit-form-ajax:hover,
.contact-page .white-block-content form a:hover,
#commentform .form-submit input:hover,
.blog .load-more:hover,
.col-md-6:first-child .pricing-box .pricing-info a:hover,
.hiw .col-md-6 a.btn:hover,
.col-md-6:first-child .pricing-box .pricing-info a:hover,
.section-banner .banner-content .btn:hover,
.home .all-ads a:hover {
    color: <?php echo  $btn2_font_color_hvr ?>;
}

.page-template-page-tpl_my_profile .col-md-4 .widget .media ~ ul li.active:after, .page-template-page-tpl_my_profile .col-md-8 + .col-md-4 .widget .media ~ ul li.active:after, .archive.author .col-md-4 .widget .media ~ ul li.active:after, .archive.author .col-md-8 + .col-md-4 .widget .media ~ ul li.active:after{
	color: <?php echo  $btn2_bg_color ?>
}

.home .nav.nav-tabs li.active a,
.woocommerce nav.woocommerce-pagination ul.page-numbers li.active > a, .woocommerce nav.woocommerce-pagination ul.page-numbers li.active > a:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li.active > a:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li.active > span, .woocommerce nav.woocommerce-pagination ul.page-numbers li.active > span:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li.active > span:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child.active > a, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child.active > a:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child.active > a:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child.active > span, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child.active > span:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child.active > span:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child > span.active > a, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child > span.active > a:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child > span.active > a:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child > span.active > span, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child > span.active > span:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:first-child > span.active > span:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child.active > a, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child.active > a:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child.active > a:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child.active > span, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child.active > span:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child.active > span:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child > span.active > a, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child > span.active > a:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child > span.active > a:hover, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child > span.active > span, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child > span.active > span:focus, .woocommerce nav.woocommerce-pagination ul.page-numbers li:last-child > span.active > span:hover, .pagination li.active > a, .pagination li.active > a:focus, .pagination li.active > a:hover, .pagination li.active > span, .pagination li.active > span:focus, .pagination li.active > span:hover, .pagination li:first-child.active > a, .pagination li:first-child.active > a:focus, .pagination li:first-child.active > a:hover, .pagination li:first-child.active > span, .pagination li:first-child.active > span:focus, .pagination li:first-child.active > span:hover, .pagination li:first-child > span.active > a, .pagination li:first-child > span.active > a:focus, .pagination li:first-child > span.active > a:hover, .pagination li:first-child > span.active > span, .pagination li:first-child > span.active > span:focus, .pagination li:first-child > span.active > span:hover, .pagination li:last-child.active > a, .pagination li:last-child.active > a:focus, .pagination li:last-child.active > a:hover, .pagination li:last-child.active > span, .pagination li:last-child.active > span:focus, .pagination li:last-child.active > span:hover, .pagination li:last-child > span.active > a, .pagination li:last-child > span.active > a:focus, .pagination li:last-child > span.active > a:hover, .pagination li:last-child > span.active > span, .pagination li:last-child > span.active > span:focus, .pagination li:last-child > span.active > span:hover{
	background-color: <?php echo  $btn2_bg_color ?>;	
	color: <?php echo  $btn2_font_color ?>;
}


/* body links */
.blog .white-block-content h3:hover,
.white-block.ad-box-alt .media .media-body p + a,
.widget ul li a:hover{
	color: <?php echo  $body_links_color ?>;
}

/*AD BADGES*/
.white-block.ad-box-alt .media .expire-badge{
	background: <?php echo  $expired_badge_bg_color ?>;
	color: <?php echo  $expired_badge_font_color ?>;
}

.white-block.ad-box-alt .media .expire-badge.pending-badge{
	background: <?php echo  $pending_badge_bg_color ?>;
	color: <?php echo  $pending_badge_font_color ?>;
}

.white-block.ad-box-alt .media .expire-badge.time-badge{
	background: <?php echo  $live_badge_bg_color ?>;
	color: <?php echo  $live_badge_font_color ?>;
}

.white-block.ad-box-alt .media .expire-badge.pending-payment{
    background: <?php echo  $not_paid_badge_bg_color ?>;
    color: <?php echo  $not_paid_badge_font_color ?>;
}

.white-block.ad-box-alt .media .expire-badge.off-badge{
    background: <?php echo  $off_badge_bg_color ?>;
    color: <?php echo  $off_badge_font_color ?>;
}

/* AD FORM BUTTONS */
.page-template-page-tpl_my_profile .tab-content .tab-pane .image-wrap + a, .archive.author .tab-content .tab-pane .image-wrap + a,
.page-template-page-tpl_my_profile .tab-content .ad-images, .page-template-page-tpl_my_profile .tab-content .ad-videos, .archive.author .tab-content .ad-images, .archive.author .tab-content .ad-videos{
	background: <?php echo  $ad_form_btn_bg_color ?>;
	color: <?php echo  $ad_form_btn_font_color ?>;
}

.page-template-page-tpl_my_profile .tab-content .tab-pane .image-wrap + a:hover,
.archive.author .tab-content .tab-pane .image-wrap + a:hover,
.page-template-page-tpl_my_profile .tab-content .ad-images:hover,
.page-template-page-tpl_my_profile .tab-content .ad-videos:hover,
.archive.author .tab-content .ad-images:hover,
.archive.author .tab-content .ad-videos:hover,
.page-template-page-tpl_my_profile .tab-content .tab-pane .image-wrap + a:hover, .page-template-page-tpl_my_profile .tab-content .tab-pane .image-wrap + a:active, .page-template-page-tpl_my_profile .tab-content .tab-pane .image-wrap + a:focus, .archive.author .tab-content .tab-pane .image-wrap + a:hover, .archive.author .tab-content .tab-pane .image-wrap + a:active, .archive.author .tab-content .tab-pane .image-wrap + a:focus,
.page-template-page-tpl_my_profile .tab-content .ad-images:hover, .page-template-page-tpl_my_profile .tab-content .ad-images:active, .page-template-page-tpl_my_profile .tab-content .ad-images:focus, .page-template-page-tpl_my_profile .tab-content .ad-videos:hover, .page-template-page-tpl_my_profile .tab-content .ad-videos:active, .page-template-page-tpl_my_profile .tab-content .ad-videos:focus, .archive.author .tab-content .ad-images:hover, .archive.author .tab-content .ad-images:active, .archive.author .tab-content .ad-images:focus, .archive.author .tab-content .ad-videos:hover, .archive.author .tab-content .ad-videos:active, .archive.author .tab-content .ad-videos:focus{
	background: <?php echo  $ad_form_btn_bg_color_hvr ?>;
	color: <?php echo  $ad_form_btn_font_color_hvr ?>;
}

/* SINGLE AD PRICE FONT SIZE */

.widget.single-ad-author .price-block .ad-pricing span.free-price,
.widget.single-ad-author .price-block .ad-pricing span.call-price,
.widget.single-ad-author .price-block .ad-pricing {
    font-size: <?php echo  $single_ad_price_size ?>;
}

/* FONT */
body,
h1,
h2,
h3,
h4,
h5,
h6,
p,
.pac-container,
.select2-display-none .select2-search input,
#select2-drop .select2-search input,
.white-block.ad-box .white-block-content p,
.pricing-box .pricing-value,
.footer,
#login .form-login .forgot-password,
#login .form-login .checkbox label,
#commentform .form-submit input,
.widget ul li,
.search-block .white-block-content p,
.search-block .white-block-content .col-md-3 .save-search,
.search-block .white-block-content .col-md-3 .reset-search,
.header-map #map .infoBox .info-window .info-details a,
.header-map #map .infoBox .info-window .info-details p a,
.woocommerce-checkout .white-block .checkout_coupon .form-row input[type="submit"],
.woocommerce-checkout .white-block .woocommerce-billing-fields p label,
.woocommerce-checkout .white-block .woocommerce-shipping-fields p label,
.woocommerce.single div.product .woocommerce-tabs .panel.wc-tab #reviews .comment-reply-title,
.woocommerce.single div.product .woocommerce-tabs .panel.wc-tab .comment-form p label,
.woocommerce-account .white-block .white-block-content .page-content .woocommerce form .form-row label,
.woocommerce-account .white-block .white-block-content .page-content .woocommerce .address a,
.woocommerce-account .white-block .white-block-content .page-content .woocommerce .address address,
.woocommerce-account.woocommerce-edit-address .white-block .white-block-content .page-content .woocommerce p input[type="submit"],
.woocommerce-account.woocommerce-edit-account .white-block .white-block-content .page-content .woocommerce p input[type="submit"],
.woocommerce #reviews #comments ol.commentlist li.comment .comment-text p.meta,
.woocommerce-cart .woocommerce .cart_totals table tbody tr.cart-subtotal,
.woocommerce-cart .woocommerce .cart_totals table tbody tr.order-total,
.single-ad .col-md-8 .white-block .white-block-content .ad-details .list-2-col,
.single-ad .col-md-8 + .col-md-4 .widget .media .media-body ul li,
.page-template-page-tpl_my_profile .col-md-4 .widget .media .media-body ul li,
.page-template-page-tpl_my_profile .col-md-8 + .col-md-4 .widget .media .media-body ul li,
.archive.author .col-md-4 .widget .media .media-body ul li,
.archive.author .col-md-8 + .col-md-4 .widget .media .media-body ul li,
.page-template-page-tpl_my_profile .col-md-4 .widget .media ~ ul.my-networks li:first-child,
.page-template-page-tpl_my_profile .col-md-8 + .col-md-4 .widget .media ~ ul.my-networks li:first-child,
.archive.author .col-md-4 .widget .media ~ ul.my-networks li:first-child,
.archive.author .col-md-8 + .col-md-4 .widget .media ~ ul.my-networks li:first-child{
	font-family: "<?php echo  $theme_font; ?>", Helvetica, Arial, sans-serif;
}

form a.register-close-login,
form a.register-close-login:hover{
    background: transparent;
    color: <?php echo  $btn2_bg_color ?>;
}

.site-logo{
    display: block;
    padding: <?php echo  $site_logo_padding ?>;
}

?>