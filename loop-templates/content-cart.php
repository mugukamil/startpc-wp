<?php
/**
* Partial template for content in page.php
*
* @package veartix
*/
?>
<div class="cart-page__content">
  <?php 
  // the_content();
  if (is_wc_endpoint_url( 'order-received' )) {
    the_content();
  }

  if ( WC()->cart->is_empty() ) {
    wc_get_template( 'cart/cart-empty.php' );
  } else {
    ?>
    <?php do_action( 'woocommerce_before_cart' ); ?>

    <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
      <?php do_action( 'woocommerce_before_cart_table' ); ?>

      <div class="cart-page__table">
        <table class="cart-table" cellspacing="0">
          <thead>
            <tr>
              <th class="product-thumbnail">תמונה</th>
              <th class="product-name">המוצר</th>
              <th class="product-quantity">כמות</th>
              <th class="product-price">מחיר</th>
              <!-- <th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th> -->
              <th class="product-remove">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

            <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
              $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
              $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

              if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                <tr class="plus-minus woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                  <td class="cart-table__img"><?php
                  $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                  if ( ! $product_permalink ) {
                    echo $thumbnail;
                  } else {
                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                  }
                  ?></td>

                  

                  <td data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>"><?php
                  if ( ! $product_permalink ) {
                    echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
                  } else {
                    echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<p class="cart-table__name"><a href="%s">%s</a></p>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
                  }

              // Meta data.
                  echo wc_get_formatted_cart_item_data( $cart_item );

              // Backorder notification.
                  if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                    echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
                  }
                  ?></td>

                  <td class="" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>"><?php
                  if ( $_product->is_sold_individually() ) {
                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                  } else {
                    $product_quantity = woocommerce_quantity_input( array(
                      'input_name'    => "cart[{$cart_item_key}][qty]",
                      'input_value'   => $cart_item['quantity'],
                      'max_value'     => $_product->get_max_purchase_quantity(),
                      'min_value'     => '0',
                      'product_name'  => $_product->get_name(),
                    ), $_product, false );
                  }

                  echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                  ?></td>

                  <td data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                    <p class="cart-table__price">
                      <?php
                      echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                      ?>
                    </p>
                  </td>

                  <td class="product-remove">
                    <?php
                  // @codingStandardsIgnoreLine
                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                      '<a href="%s" class="cart-table__remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewbox="0 0 26 26"><path fill="#797979" transform="translate(-787 -156)" d="M788.35 181.35l-.7-.7L799.29 169l-11.64-11.65.7-.7L800 168.29l11.65-11.64.7.7L800.71 169l11.64 11.65-.7.7L800 169.71z"></path></svg></a>',
                      esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                      __( 'Remove this item', 'woocommerce' ),
                      esc_attr( $product_id ),
                      esc_attr( $_product->get_sku() )
                    ), $cart_item_key );
                    ?>
                  </td>
                </tr>
                <?php
              }
            }
            ?>

            <?php do_action( 'woocommerce_cart_contents' ); ?>

            <tr>
              <td colspan="6" class="actions">

                <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                <?php do_action( 'woocommerce_cart_actions' ); ?>

                <?php wp_nonce_field( 'woocommerce-cart' ); ?>
              </td>
            </tr>

            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
          </tbody>
        </table>
      </div>

      
      <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </form>

    <?php do_action( 'woocommerce_after_cart' ); ?>
    <?php } ?>

  </div>
  <aside class="site-sidebar cart-page__sidebar cart-sidebar">
    <p class="cart-sidebar__title">ביצוע הזמנה</p>
    <form required name="checkout" method="post" class="cart-sidebar__form cart-form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
      <div class="cart-form__50-50 cart-form__row">
        <input type="text" placeholder="שם פרטי *" required autocomplete="off" title="first name" class="cart-form__input js-heb-en" name="billing_first_name">
        <input type="text" placeholder="שם משפחה *" required autocomplete="off" title="last name" class="cart-form__input js-heb-en" name="billing_last_name">
      </div>
      <div class="cart-form__100 cart-form__row">
        <input type="tel" placeholder="מספר טלפון *" required autocomplete="off" title="phone" class="cart-form__input" name="billing_phone">
      </div>
      <div class="cart-form__100 cart-form__row">
        <input type="text" placeholder="דואר אלקטרוני *" required autocomplete="off" title="email"
        pattern="^([\w]+[.-]?[^\W_]?[a-zA-Z0-9]+)+@([\w][.-]?)*[\w-]\.[a-zA-Z_-]([\w-]*)[^\W_]$|^([\w]+[.-]?[^\W_]?[a-zA-Z0-9]+)+@(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$"
        class="cart-form__input js-email" name="billing_email">
      </div>
      <div class="cart-form__60-40 cart-form__row">
        <input type="text" placeholder="עיר *" required autocomplete="off" title="city" class="cart-form__input js-heb-en" name="billing_city">
        <input type="text" placeholder="רחוב *" required autocomplete="off" title="street" class="cart-form__input js-heb-en" name="billing_street">
        <input type="hidden" name="billing_country" id="billing_country" value="IL" autocomplete="country" class="country_to_state" readonly="readonly">
      </div>
      <div class="cart-form__40-30-30 cart-form__row">
        <input type="text" placeholder="בית *" required autocomplete="off" title="home" class="cart-form__input js-num" name="billing_address_1">
        <input type="text" placeholder="דירה *" required autocomplete="off" title="apartment" class="cart-form__input js-num" name="billing_address_2">
        <input type="text" placeholder="מיקוד *" required autocomplete="off" title="postal code" class="cart-form__input js-num" name="billing_postcode">
      </div>
      <div class="cart-form__row custom-checkbox cart-form__checkbox">
        <input id="diff-name" type="checkbox" name="checkout-different-name" class="custom-checkbox__input js-checkbox-diff-name">
        <label for="diff-name" tabindex="0" class="custom-checkbox__label">
          <span tabindex="0" class="custom-checkbox__icon custom-checkbox__icon--small"></span>
          ברצוני לקבל חשבונית על שם אחר
        </label>
      </div>
      <div style="display: none" class="cart-form__100 cart-form__row cart-form__small-margin js-input-diff-name">
        <input type="text" placeholder="שם על החשבונית" autocomplete="off" title="name on invoice"
        class="cart-form__input js-heb-en" name="billing_name_on_invoice">
      </div>

      <div class="cart-form__2col cart-form__row cart-form__row--with-bg">
        <div class="cart-form__col1 custom-radio">
          <input id="self-collection" type="radio" name="shipping_method[0]" data-index="0"
          checked='checked' class="cart-form__radio custom-radio__input shipping_method" value="local_pickup:2">
          <label for="self-collection" tabindex="0" class="custom-radio__label">
            <span tabindex="0" class="custom-radio__icon custom-radio__icon--white"></span>
            איסוף עצמי מסניף
          </label>
        </div>
        <div class="cart-form__col2">
          <div tabindex="0" class="sel js-select cart-form__select">
            <select hidden aria-hidden="true" title="place" class="cart-form__select" name="billing_store_pickup">
              <option>אודים</option>
              <option value="אודים">אודים</option>
              <option value="אשדוד">אשדוד</option>
              <option value="תל אביב">תל אביב</option>
              <option value="חיפה">חיפה</option>
            </select>
          </div>
        </div>
      </div>
      <div class="cart-form__100 cart-form__row cart-form__row--with-bg custom-radio">
        <input id="delivery-to-home" type="radio" name="shipping_method[0]" data-index="0" class="contact-form__radio custom-radio__input shipping_method" value="flat_rate:1"><label for="delivery-to-home" tabindex="0" class="custom-radio__label" >
          <span tabindex="0" class="custom-radio__icon custom-radio__icon--white"></span>
          משלוח עד הבית: ₪39
        </label>
      </div>
      <hr
      class="cart-form__hr">
      <div class="cart-form__row">
        <div class="cart-form__commission"><span class="js-checkout-monthly-price"><?php echo WC()->cart->get_cart_subtotal(); ?> לחודש ב-</span>
          <div tabindex="0" class="sel js-select cart-form__commission-select">
            <select hidden aria-hidden="true" title="per month" class="cart-form__commission-select" name="billing_per_month">
              <?php 
              $fees = range(1, 36);
              $feeArr = array();

              foreach ($fees as $fee => $val) {
                $fee_val = get_field($val . "_month_fee", (int) get_option( 'woocommerce_checkout_page_id' ));
                echo "<option value='$fee_val' data-fee='$fee_val'>$val</option>";
              }

              ?>
            </select>
          </div>
            <input type="hidden" value="<?php echo WC()->cart->subtotal ?>" class="js-subtotal">
            <!-- <span class="woocommerce-checkout-review-order-table"></span> -->
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
          </div>
        </div>
        <div class="cart-form__row">
          <p class="cart-form__total">סה”כ: <span class="js-checkout-total-price">₪<?php echo WC()->cart->total; ?></span></p>
        </div>
        <hr class="cart-form__hr cart-form__hr--small-margin">
        <div class="cart-form__row custom-checkbox cart-form__checkbox"><input id="agreement" type="checkbox"
          name="agreement"
          class="custom-checkbox__input js-agreement"><label
          for="agreement" tabindex="0" class="custom-checkbox__label"><span tabindex="0"
          class="custom-checkbox__icon custom-checkbox__icon--small"></span>אני
          מאשרת שקראתי, הבנתי והסכמתי&nbsp;<a href="">לתקנון</a></label></div>

          <noscript>
            <?php esc_html_e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
          </noscript>

          <?php wc_get_template( 'checkout/terms.php' ); ?>

          <?php do_action( 'woocommerce_review_order_before_submit' ); ?>


          <div
          class="cart-form__row"><?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="cart-form__submit" name="woocommerce_checkout_place_order" id="place_order" disabled value="אישור הזמנה" data-value="אישור הזמנה">אישור הזמנה</button>' ); // @codingStandardsIgnoreLine ?>
          <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

          <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

          <?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
        </div>

      </form>

      <?php 
      $checkout = new WC_Checkout;
      do_action( 'woocommerce_after_checkout_form', $checkout ); 
      ?>
      
    </aside>
