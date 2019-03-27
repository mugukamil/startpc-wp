<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package veartix
 */

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="skip"><a href="#main">Skip to main content</a></div>

<!-- MODALS -->
<div id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true" class="modal fade modal--search">
  <div class="modal__dialog"><button type="button" aria-label="close modal" class="modal__close js-close-modal"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="26" viewbox="0 0 26 26"><path fill="#fff" transform="translate(-787 -156)" d="M788.35 181.35l-.7-.7L799.29 169l-11.64-11.65.7-.7L800 168.29l11.65-11.64.7.7L800.71 169l11.64 11.65-.7.7L800 169.71z"></path></svg></button>
    <div
      role="document" class="modal__content">
      <p id="searchModalLabel" class="modal__title">חיפוש באתר</p>
      <form action="<?php echo get_site_url(); ?>">
        <div class="modal__input-out modal__input-out--empty">
          <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="נא להזין את מונח החיפוש..." title="search" class="modal__input modal__input--search">
          <button type="submit" aria-label="search" class="modal__search"></button>
        </div>
      </form>
  </div>
</div>
</div>
<div id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true" class="modal fade modal--order">
  <div class="modal__dialog"><button type="button" aria-label="close modal" class="modal__close js-close-modal"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="26" viewbox="0 0 26 26"><path fill="#fff" transform="translate(-787 -156)" d="M788.35 181.35l-.7-.7L799.29 169l-11.64-11.65.7-.7L800 168.29l11.65-11.64.7.7L800.71 169l11.64 11.65-.7.7L800 169.71z"></path></svg></button>
    <div
      role="document" class="modal__content">
      <p id="orderModalLabel" class="modal__title">הזמנתך נקלטה בהצלחה</p>
      <p class="modal__sub">אנו ניצור איתך קשר בהקדם האפשרי</p>
  </div>
</div>
</div>
<div class="facebook"><button class="facebook__btn">facebook</button>
  <div class="facebook__frame"><iframe name="f3f30d045e22348" width="285" height="300" allowfullscreen title="fb:page Facebook Social Plugin" src="https://www.facebook.com/v2.4/plugins/page.php?adapt_container_width=true&amp;app_id=128011213963529&amp;channel=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2F18W0fzbK7xg.js%3Fversion%3D42%23cb%3Dfd7eff5a453a8%26domain%3Dwww.startpc.co.il%26origin%3Dhttp%253A%252F%252Fwww.startpc.co.il%252Ff1e548f4919c874%26relation%3Dparent.parent&amp;container_width=465&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Fstartpc.gaming&amp;locale=en_US&amp;sdk=joey&amp;show_facepile=true&amp;show_posts=false&amp;small_header=false&amp;width=285"
      style="border: none; visibility: visible;"></iframe></div>
</div>

<header class="site-header">
  <div class="container">
 <?php if ( has_custom_logo() ) { ?>
 	<?php the_custom_logo(); ?>
 <?php } ?>

        <nav role="navigation" class="site-nav">
          <div class="menu-toggle"><button aria-label="Menu" class="hamburger"><i aria-controls="navigation" aria-expanded="false" role="img" class="fa fa-bars"></i><i aria-controls="navigation" aria-expanded="false" role="img" class="fa fa-times"></i></button></div>
          <!-- The WordPress Menu goes here -->
          <?php 
          wp_nav_menu(
            array(
              'theme_location'  => 'primary',
              'container_class' => false,
              'container_id'    => '',
              'menu_class'      => 'site-nav__menu',
              'fallback_cb'     => '',
              'menu_id'         => 'navigation',
              'walker'          => new understrap_WP_Bootstrap_Navwalker(),
            ) );

          ?>
          <!-- The WordPress Menu goes here -->
        </nav>

    <div class="cart-and-search">
      <ul>
        <li class="cart-and-search__item cart-and-search__item--cart">
          <a href="<?php echo get_site_url() ?>/cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="32px" viewbox="0 0 26 33" class="icon-cart"><path fill="#fff" d="M26 28.66L24.12 8.03a.89.89 0 0 0-.89-.8h-3.82A6.38 6.38 0 0 0 13 1a6.38 6.38 0 0 0-6.42 6.22H2.76a.88.88 0 0 0-.9.8L.02 28.67l-.01.08C0 31.09 2.19 33 4.88 33h16.24c2.7 0 4.88-1.91 4.88-4.26v-.08zM13 2.76a4.6 4.6 0 0 1 4.62 4.46H8.38A4.6 4.6 0 0 1 13 2.77zm8.12 28.47H4.88c-1.7 0-3.06-1.1-3.09-2.45L3.57 9h3v2.68c0 .49.4.88.9.88s.9-.39.9-.88V9h9.25v2.68c0 .49.4.88.9.88s.9-.39.9-.88V9h3l1.79 19.78c-.03 1.35-1.4 2.45-3.09 2.45z"></path><text x="13" y="25" class="js-cart-qty icon-cart__text"><?php echo WC()->cart->get_cart_contents_count(); ?></text></svg>
          </a>
          <?php if (!is_checkout() && !is_cart()): ?>
            <div class="cart-dropdown">
              <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
            </div>
          <?php endif ?>
        </li>
        <li class="cart-and-search__item"><button type="button" data-toggle="modal" data-target="searchModal" aria-label="Search" class="js-toggle-modal cart-and-search__button"></button></li>
      </ul>
  </div>
  </div>
</header>
