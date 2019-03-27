<?php 
/* Template Name: Contact Page Template */ 

// check for form submission - if it doesn't exist then send back to contact form
// if ( ! isset( $_POST['contact_nonce'] ) 
//     || ! wp_verify_nonce( $_POST['contact_nonce'], 'contact_nonce_action' ) ) {
if (isset($_POST['contact_submitted'])) {
    // Trigger action/function 'contact_send_message'
    do_action( 'contact_send_message' );
}

global $contact_errors;

get_header(); 

?>
<main id="main">
  <div class="contact">
    <div class="contact-info">
      <div class="container">
        <div class="contact-table">
          <p class="contact-info__heading">פרטי התקשרות:</p>
          <table>
            <tr class="contact-table__row">
              <?php if (get_field('contact_page_email')): ?>
                <th><?php  _e( 'טלפון:', 'understrap' ); ?></th>
                <td>
                  <?php 
                    $phone = preg_replace('/ \(/', '<span>(', get_field('phone')); 
                    $phone = preg_replace('/\)/', ')</span>', $phone); 
                  ?>
                  <p class="contact-table__text"><?php echo $phone ?></p>
                </td>
              <?php endif; ?>
            </tr>
            <tr class="contact-table__row">
              <?php if (get_field('contact_page_email')): ?>
                <th><?php  _e( 'דוא”ל:', 'understrap' ); ?></th>
                <td>
                  <?php 
                    $contact_page_email = preg_replace('/\(/', '<span>(', get_field('contact_page_email')); 
                    $contact_page_email = preg_replace('/\)/', ')</span>', $contact_page_email); 
                  ?>
                  <p class="contact-table__text"><a href="<?php echo $contact_page_email ?>"><?php echo $contact_page_email ?></a></p>
                </td>
              <?php endif; ?>
            </tr>
            <tr class="contact-table__row">
              <?php if (get_field('opening_hours')): ?>
                <th><?php  _e( 'שעות פתיחה:', 'understrap' ); ?></th>
                <td>
                  <?php 
                    $opening_hours = preg_replace('/\(/', '<span>(', get_field('opening_hours')); 
                    $opening_hours = preg_replace('/\)/', ')</span>', $opening_hours); 
                  ?>
                  <p class="contact-table__text"><?php echo $opening_hours ?></p>
                </td>
              <?php endif; ?>
            </tr>
            <tr class="contact-table__row">
              <?php if (get_field('address')): ?>
                <th><?php  _e( 'כתובת:', 'understrap' ); ?></th>
                <td>
                  <?php 
                    $address = preg_replace('/\(/', '<span>(', get_field('address')); 
                    $address = preg_replace('/\)/', ')</span>', $address); 
                  ?>
                  <p class="contact-table__text"><?php echo $address ?></p>
                </td>
              <?php endif; ?>
            </tr>
          </table>
        </div>
        <div class="contact-form">
          <p class="contact-info__heading">טופס צור קשר:</p>
          <form method="post" action="<?php the_permalink(); ?>">
            <?php wp_nonce_field( 'contact_nonce_action', 'contact_nonce' ); ?>
            <div><input type="text" name="contact_fullname" placeholder="שם מלא" autocomplete="off" title="name" class="contact-form__input" required></div>
            <div><input type="tel" placeholder="טלפון" name="contact_phone" autocomplete="off" title="telephone" class="contact-form__input" required></div>
            <div><input type="email" placeholder="דוא”ל" name="contact_email" autocomplete="off" title="email" class="contact-form__input" required pattern="^([\w]+[.-]?[^\W_]?[a-zA-Z0-9]+)+@([\w][.-]?)*[\w-]\.[a-zA-Z_-]([\w-]*)[^\W_]$|^([\w]+[.-]?[^\W_]?[a-zA-Z0-9]+)+@(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$"></div>
            <div>
              <div tabindex="0" class="sel sel--black-panther js-select contact-form__select"><select id="select-profession" title="repair" class="contact-form__select js-repair" name="contact_repair"><option value="">בחר נושא</option><option value="before-buy">בירור לפני רכישה</option><option value="repair">טופס תיקונים</option><option value="other">אחר</option></select></div>
              <div
              class="contact-form__repair">
              <div><input type="text" placeholder="תיאור התקלה" autocomplete="off" title="problem" class="contact-form__input" name="contact_problem"></div>
              <div><input type="text" placeholder="סיסמה למערכת ההפעלה" name="contact_os" autocomplete="off" title="operating system" class="contact-form__input"></div>
              <div class="contact-form__2col">
                <div class="contact-form__col1 custom-radio"><input id="repair-free" value="free" type="radio" name="repair-delivery" checked data-hide="js-repair-input" class="contact-form__radio custom-radio__input"><label for="repair-free" tabindex="0" class="contact-form__label custom-radio__label"><span tabindex="0" class="custom-radio__icon"></span>מסירה עצמאית לנקודת השירות</label></div>
                <div
                class="contact-form__col2">
                <div tabindex="0" class="sel js-select contact-form__select js-select-repair"><select title="service point" class="contact-form__select" name="contact_service_point"><option>בחר נקודת שירות</option><option value="בחר נקודת שירות">אודים, הדקל 35</option><option value="אשדוד, תש”ח 9">אשדוד, תש”ח 9</option><option value="תל אביב, אבן גבירול 1">תל אביב, אבן גבירול 1</option><option value="חיפה, מוריה 118">חיפה, מוריה 118</option></select></div>
              </div>
            </div>
            <div class="custom-radio"><input id="repair-paid" value="paid" type="radio" name="repair-delivery" data-show="js-repair-input" class="contact-form__radio custom-radio__input"><label for="repair-paid" tabindex="0" class="contact-form__label custom-radio__label"><span tabindex="0" class="custom-radio__icon"></span>איסוף ע”י חברת שליחויות בעלות של 35 ₪</label></div>
            <div><input type="text" placeholder="כתובת מלאה (עיר, רחוב ומספר בית)" autocomplete="off" style="display: none" title="full address" class="contact-form__input js-repair-input" name="contact_address"></div>
            <div class="custom-checkbox"><input id="repair-apply" type="checkbox" name="repair-apply" class="contact-form__checkbox custom-checkbox__input"><label for="repair-apply" tabindex="0" class="contact-form__label custom-checkbox__label"><span class="custom-checkbox__icon"></span>אני מאשרת שארזתי את המוצר בקפידה ושכל זנק שנגרם ע”י חברת השליחויות הינו באחריותי.</label></div>
          </div>
        </div>
        <div><textarea placeholder="הודעה" name="contact_message" autocomplete="off" title="message" class="contact-form__textarea"></textarea></div>
        <div><input type="submit" value="שלח הודעה" class="contact-form__submit"></div>
        <input type="hidden" name="contact_submitted">
      </form>
    </div>
  </div>
  <div id="map" data-marker-url="<?php echo get_template_directory_uri() ?>/img/map.png" aria-hidden="true" class="contact-info__map">
    <div class="map-placeholder"></div>
  </div>
  </div>
  <div class="contact-extra">
    <div class="container">
      <div class="contact-extra__hr"></div>
      <p class="contact-extra__title">נקודות שירות נוספות&nbsp;<span>(נא לתאם הגעה מראש)</span></p>
      <div class="contact-extra__addresses">
        <?php
              $args = array(
                  'post_type' => 'contact_addresses'
              );
               
              $contact_addresses = new WP_Query( $args );
        
              if ( $contact_addresses->have_posts()):
                  while ( $contact_addresses->have_posts() ):
                      $contact_addresses->the_post();
              ?>

              <div class="contact-extra__address contact-address">
                <div class="contact-address__header">
                  <?php if (get_field('address_direction')): ?>
                  <p><?php echo get_field('address_direction') ?></p>
                  <?php endif; ?>
                  <p><strong><?php the_title() ?></strong></p>
                </div>
                <div class="contact-address__table">
                  <table>
                    <tr class="contact-address__table-row">
                    <?php if (get_field('phone')): ?>
                      <th><?php  _e( 'טלפון:', 'understrap' ); ?></th>
                      <?php 
                        $phone_field = preg_replace('/\<p\>/', '', get_field('phone')); 
                        $phone_field = preg_replace('/\<\/p\>/', '', $phone_field); 
                      ?>
                      <td>
                        <p class="contact-address__table-text"><a href="tel:<?php echo $phone_field ?>"><?php echo $phone_field ?></a></p>
                      </td>
                  <?php endif; ?>
                    </tr>
                    <tr class="contact-address__table-row">
                    <?php if (get_field('opening_hours')): ?>
                      <th><?php  _e( 'שעות פתיחה:', 'understrap' ); ?></th>
                      <td>
                        <?php 
                          $opening_hours = preg_replace('/\(/', '<span>(', get_field('opening_hours')); 
                          $opening_hours = preg_replace('/\)/', ')</span>', $opening_hours); 
                        ?>
                        <p class="contact-address__table-text"><?php echo $opening_hours; ?></p>
                      </td>
                    <?php endif; ?>
                    </tr>
                    <tr class="contact-address__table-row">
                    <?php if (get_field('address')): ?>
                      <th><?php  _e( 'כתובת:', 'understrap' ); ?></th>
                      <td>
                        <?php 
                          $address = preg_replace('/\(/', '<span>(', get_field('address')); 
                          $address = preg_replace('/\)/', ')</span>', $address); 
                        ?>
                        <p class="contact-address__table-text"><?php echo $address ?></p>
                      </td>
                    <?php endif; ?>
                    </tr>
                  </table>
                  <?php the_content() ?>
                </div>
              </div>
                    
              <?php endwhile; endif;
               
              // Reset the `$post` data to the current post in main query.
              wp_reset_postdata();
               
              ?>
      </div>
    </div>
  </div>
  </div>
</main>
<?php get_footer() ?>
<script>
  loadMap('#map')
</script>
