//=include lib/lightbox.min.js
//=include lib/slick.min.js
//=include lib/svgxuse.min.js
//=include lib/jquery.inputmask.min.js
//=include lib/ofi.min.js
//=include lib/stickyfill.min.js
//=include _map.js

window.$ = window.jQuery;

(function($) {
  $(document).ready(function() {
    var offset = 500,
      //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
      offset_opacity = 1200,
      //duration of the top scrolling animation (in ms)
      scroll_top_duration = 700,
      //grab the "back to top" link
      $backToTop = $(".cd-top");

    objectFitImages();

    //hide or show the "back to top" link
    $(window).scroll(function() {
      $(this).scrollTop() > offset
        ? $backToTop.addClass("cd-is-visible")
        : $backToTop.removeClass("cd-is-visible cd-fade-out");
      if ($(this).scrollTop() > offset_opacity) {
        $backToTop.addClass("cd-fade-out");
      }
    });

    //smooth scroll to top
    $backToTop.on("click", function(event) {
      event.preventDefault();
      $("body,html").animate(
        {
          scrollTop: 0
        },
        scroll_top_duration
      );
    });

    $("input[type=tel], .js-num").inputmask({
      regex: `^\\+(\\d{3})+$`,
      jitMasking: true
    });

    $(".js-num").inputmask({
      alias: "numeric",
      allowMinus: false
    });

    $(".js-email").inputmask({
      regex: `^[\\w@.-]+$`,
      placeholder: "",
      jitMasking: true
    });

    $(".js-heb-en").inputmask({
      regex: "^[A-Za-z\u0590-\u05FF]+$",
      placeholder: ""
    });

    $(".main-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      draggable: false,
      rtl: true,
      dots: true,
      adaptiveHeight: true,
      autoplay: true
    });

    $(".menu-toggle").click(function() {
      $(".site-nav__menu").toggleClass("mob");
      $(this).toggleClass("open");
    });

    $(".js-repair").on("change", function(e) {
      var $this = $(this),
        $repair = $(".contact-form__repair"),
        $textarea = $(".contact-form__textarea"),
        $contactInfo = $(".contact-info");

      if ($this.val() == "אחר") {
        $contactInfo.removeClass("repair-expanded");
        $repair.fadeOut();
        $textarea.slideDown();

        return;
      }

      $contactInfo.addClass("repair-expanded");
      $repair.fadeIn();
      $textarea.slideUp();
    });

    $(".js-show-list").click(function(e) {
      e.preventDefault();

      $(this).addClass("active");
      $(".js-show-grid").removeClass("active");

      $(".calc-product").addClass("calc-product--list");
    });

    $(".js-show-grid").click(function(e) {
      e.preventDefault();
      $(this).addClass("active");
      $(".js-show-list").removeClass("active");

      $(".calc-product").removeClass("calc-product--list");
    });

    $(".js-close").click(function(e) {
      $(this)
        .closest("li")
        .remove();
    });

    $(document).click(function(e) {
      if (!$(e.target).closest(".modal__dialog").length) {
        var backdrop = $(".modal-backdrop");
        var modal = $(".modal.show");

        $("body").removeClass("modal-open");
        backdrop.remove();
        modal.removeClass("show").hide();
      }
    });

    $(".js-toggle-modal").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      var $this = $(this);
      var modal = `#${$this.data("target")}`;
      var backdrop = $("<div>").addClass("modal-backdrop fade show");

      $("body").append(backdrop);
      $("body").addClass("modal-open");

      $(modal)
        .addClass("show")
        .show();
    });

    $(".js-close-modal").click(function(e) {
      e.preventDefault();

      var $this = $(this);
      var backdrop = $(".modal-backdrop");
      var modal = $(".modal.show");

      if (backdrop) {
        $("body").removeClass("modal-open");
        backdrop.remove();
        modal.removeClass("show").hide();
      }
    });

    function commaSeparateNumber(val) {
      while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, "$1" + "," + "$2");
      }
      return val;
    }

    $("body").on("click", ".btn-number", function(e) {
      e.preventDefault();

      var $this = $(this);
      var priceElFirstVal;
      var type = $this.attr("data-type");
      var input = $this.closest(".plus-minus").find(".input-number");
      var currentVal = parseInt(input.val());
      var priceEl = $this.closest("tr").find(".js-cart-price");
      var priceVal = priceEl.data("price");
      // var $updateCart = $('.button[name="update_cart"]');

      if (!isNaN(currentVal)) {
        if (type == "minus") {
          if (currentVal > input.attr("min")) {
            var price = priceVal * (currentVal - 1);
            input.val(currentVal - 1).change();
            priceEl.text(`₪${commaSeparateNumber(price)}`);
          }
          if (parseInt(input.val()) == input.attr("min")) {
            $this.attr("disabled", true);
          }
        } else if (type == "plus") {
          if (currentVal < input.attr("max")) {
            var price = priceVal * (currentVal + 1);
            input.val(currentVal + 1).change();
            priceEl.text(`₪${commaSeparateNumber(price)}`);
          }
          if (parseInt(input.val()) == input.attr("max")) {
            $this.attr("disabled", true);
          }
        }
      } else {
        input.val(0);
      }
    });

    $("body").on("focusin", ".input-number", function() {
      $(this).data("oldValue", $(this).val());
    });

    $("body").on("change", ".input-number", function() {
      var $this = $(this);
      var minValue = parseInt($this.attr("min"));
      var maxValue = parseInt($this.attr("max"));
      var valueCurrent = parseInt($this.val());
      var $plusMinus = $this.closest(".plus-minus");
      var name = $this.attr("name");

      if (valueCurrent >= minValue) {
        $plusMinus
          .find(".btn-number[data-type='minus']")
          .removeAttr("disabled");

        var input = $this.closest(".plus-minus").find(".input-number");
        var priceEl = $this.closest(".plus-minus").find(".js-cart-price");
        var priceVal = priceEl.data("price");
        var price = priceVal * valueCurrent;

        priceEl.text(`₪${commaSeparateNumber(price)}`);
        updatePrice();
      } else {
        $this.val($this.data("oldValue"));
        updatePrice();
      }
      if (valueCurrent <= maxValue) {
        $plusMinus.find(".btn-number[data-type='plus']").removeAttr("disabled");
        updatePrice();
      } else {
        $this.val($this.data("oldValue"));
        updatePrice();
      }
    });

    $("body").on("keydown", ".input-number", function(e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if (
        $.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)
      ) {
        // var it happen, don't do anything
        return;
      }
      // Ensure that it is a number and stop the keypress
      if (
        (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
        (e.keyCode < 96 || e.keyCode > 105)
      ) {
        e.preventDefault();
      } else {
      }
    });

    $(".js-remove-cart-item").click(function(e) {
      e.preventDefault();

      var $this = $(this);

      $this.closest("tr").remove();
    });

    function jsSelect() {
      $(this)
        .children("select")
        .css("display", "none");

      var $current = $(this);

      $(this)
        .find("option")
        .each(function(i) {
          var $this = $(this);

          if (i == 0) {
            $current.prepend(
              $("<div>", {
                class: $current.attr("class").replace(/sel/g, "sel__box")
              })
            );

            var placeholder = $this.text();
            var value = $this.val();
            $current.prepend(
              $("<span>", {
                class: $current
                  .attr("class")
                  .replace(/sel/g, "sel__placeholder"),
                tabindex: "0",
                text: placeholder,
                "data-placeholder": placeholder
              })
            );

            return;
          }

          $current.children("div").append(
            $("<span>", {
              class: $current
                .attr("class")
                .replace(/sel/g, "sel__box__options"),
              text: $this.text(),
              "data-value": $this.val(),
              tabindex: "0"
            })
          );
        });
    }

    window.jsSelect = jsSelect;
    var $jsSelect = $(".js-select");

    $jsSelect.each(jsSelect);

    $jsSelect.click(function() {
      $(this).toggleClass("active");
    });

    $jsSelect.keyup(function(e) {
      e.preventDefault();
      e.stopPropagation();

      var $this = $(this),
        $selBoxOptions = $this.find(".sel__box__options");

      if (!$selBoxOptions.length) {
        return;
      }

      var index = Array.from($selBoxOptions).indexOf(event.target);

      if (e.which === 38 && index > 0) {
        index--;
      }

      if (e.which === 40 && index < $selBoxOptions.length - 1) {
        index++;
      }

      if (index < 0) {
        index = 0;
      }

      $selBoxOptions[index].focus();

      if (e.keyCode === 32) {
        $this.toggleClass("active");
      }
    });

    $(".sel__box__options").click(function() {
      var $this = $(this);
      var txt = $this.text();
      var index = $this.index();
      var $currentSel = $this.closest(".js-select");

      $this.siblings(".sel__box__options").removeClass("selected");
      $this.addClass("selected");

      $currentSel
        .find(".sel__placeholder")
        .text(txt)
        .attr("data-value", txt);
      $currentSel
        .find("select")
        .prop("selectedIndex", index + 1)
        .change();
    });

    $(".calc-content").on("click", ".calc-content__tabs__btn", function(e) {
      var $this = $(this),
        $tab = $this.data("tab"),
        $calcContent = $this.closest(".calc-content");

      $this
        .closest("ul")
        .find("button")
        .removeClass("calc-content__tabs__btn--active");
      $this.addClass("calc-content__tabs__btn--active");

      if ($tab !== "all") {
        var $items = $calcContent.find(`[data-subcat="${$tab.toLowerCase()}"]`);
        $calcContent.find(".calc-product").hide();
        $items.show();

        return;
      }

      $this
        .closest(".calculator__main")
        .find(".calculator__cat--active")
        .click();
    });

    // $(".catalog__tab").click(function(e) {
    //   var $this = $(this),
    //     $tab = $this.data("tab"),
    //     $calcContent = $this.closest(".catalog");

    //   var $items = $calcContent.find(`[data-cat="${$tab}"]`);
    //   $calcContent.find(".calc-product").hide();
    //   $items.show();

    //   $this
    //     .closest(".catalog__tabs")
    //     .find(".catalog__tab")
    //     .removeClass("active");
    //   $this.addClass("active");
    // });

    $(".catalog-sidebar__link").click(function(e) {
      e.preventDefault();

      var $this = $(this),
        $tab = $this.data("tab"),
        $calcContent = $this.closest(".catalog");

      var $items = $calcContent.find(`[data-filtercat="${$tab}"]`);
      $calcContent.find(".calc-product").hide();
      $items.show();

      $this
        .closest(".catalog")
        .find(".catalog-sidebar__link")
        .removeClass("catalog-sidebar__link--active");
      $this.addClass("catalog-sidebar__link--active");
    });

    var catalogFilterList = new Map();

    $(".js-filter-checkbox").change(function(e) {
      var $this = $(this),
        id = $this.attr("id"),
        $main = $this.closest(".main"),
        $items = $main.find(`[data-filter="${id}"]`);
      $main.find(".calc-product").hide();

      if ($this.is(":checked")) {
        catalogFilterList.set(id, $items);
        catalogFilterList.forEach(i => i.show());
      } else {
        catalogFilterList.delete(id);
        catalogFilterList.forEach(i => i.show());
      }

      if (!catalogFilterList.size) {
        $main.find(".calc-product").show();
      }
    });

    $(".site-nav__sub-arrow, .dropdown .caret").click(function(e) {
      e.stopPropagation();
      e.preventDefault();

      $(this).toggleClass("open");

      $(".site-nav__mega-menu").toggleClass("mega-menu--open");
    });

    function compulsoryCheck() {
      var result = true;
      var txt = "";
      $(".calc-sidebar .calculator__cat[data-compulsory=1]").each(function(
        k,
        v
      ) {
        $("caption", v).removeClass("warning");
        if ($(".calc-sidebar__product", v).length <= 0) {
          $("caption", v).addClass("warning");
          result = false;
          var part = $.trim($("caption", v).text());
          var title = part.split("\n");
          txt += title[0] + "\n";
        }
      });
      if (!result) {
        alert(`The following options are MANDATORY: \n ${txt}`);
        return false;
      }
      return result;
    }

    function addToCart() {
      if (!compulsoryCheck()) {
        return false;
      }
      return true;
    }

    function setFilters(subCategories) {
      $(".calc-content__tabs").html("");
      $(".calc-content__tabs").html(
        `
      <li><button class="calc-content__tabs__btn calc-content__tabs__btn--active" data-tab="all">הצג הכל</button></li>
      `
      );
      var subCategories = subCategories.split(",");
      $.each(subCategories, function() {
        $(".calc-content__tabs").append(
          `<li><button class="calc-content__tabs__btn" data-tab="${this.toLowerCase()}">${this}</li> `
        );
      });
    }

    $(".js-add-to-cart").click(function(e) {
      return addToCart();
    });

    $(".calculator__cat:not(.calculator__cat--checkbox)").click(function(e) {
      var $this = $(this),
        $cid = $this.data("cid"),
        $sub = $this.data("subcategories"),
        $calcContent = $this.closest(".calculator__main").find(".calc-content"),
        $calcTabs = $calcContent.find(".calc-content__tabs");

      var $items = $calcContent.find(`.calc-product[data-cid="${$cid}"]`);
      $calcContent.find(".calc-product").hide();
      setFilters($sub);
      $items.show();

      $this
        .closest(".calc-sidebar")
        .find(".calculator__cat")
        .removeClass("calculator__cat--active");
      $this.toggleClass("calculator__cat--active");

      $calcTabs.removeClass("calc-content__tabs--inactive");
    });

    $(".article-gallery__main").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".article-gallery__nav",
      rtl: true,
      draggable: false,
      adaptiveHeight: true
    });

    $(".article-gallery__nav").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: ".article-gallery__main",
      dots: false,
      arrows: true,
      rtl: true,
      draggable: false,
      variableWidth: true,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 790,
          settings: {
            variableWidth: false
          }
        }
      ]
    });

    $(".site-elements__tab a, .js-tab").click(function(e) {
      e.preventDefault();
      $(window).trigger("resize");
      $(".product__suggestions").trigger("resize");
      $(".product__suggestions").slick("setPosition");
      var evt = window.document.createEvent("UIEvents");
      evt.initUIEvent("resize", true, false, window, 0);
      window.dispatchEvent(evt);

      var $this = $(this),
        $tab = $this.closest(".site-elements__tab");

      $this
        .closest(".site-elements__tabs")
        .find(".site-elements__tab")
        .removeClass("site-elements__tab--active");

      $(".product__tab-content").removeClass("product__tab-content--visible");
      $($this.attr("href")).addClass("product__tab-content--visible");

      $tab.addClass("site-elements__tab--active");
    });

    $(".js-agreement").on("change", function(e) {
      var $this = $(this),
        $form = $this.closest("form"),
        isChecked = $this.prop("checked");

      $form.find(".cart-form__submit").prop("disabled", !isChecked);
    });

    $(".accordion__toggle").click(function() {
      var $this = $(this),
        $accordionInner = $this.closest(".accordion").find(".accordion__inner");

      $this.toggleClass("collapsed").attr("aria-expanded", function(i, attr) {
        return !(attr == "true");
      });
      $accordionInner.slideToggle();

      return false;
    });

    $(".product__slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".product__slider-nav",
      rtl: true,
      draggable: false
    });

    $(".product__slider-nav").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: ".product__slider",
      dots: false,
      arrows: false,
      focusOnSelect: true,
      rtl: true,
      draggable: false
    });

    lightbox.option({
      resizeDuration: 200,
      albumLabel: "",
      positionFromTop: 150,
      maxWidth: 517,
      wrapAround: true
    });

    $(".js-tab").click(function(e) {
      e.preventDefault();

      $("");
    });

    $(".calc-product--gallery").click(function(e) {
      $(this)
        .find(".calc-product__checkbox")
        .toggleClass("calc-product__checkbox--active");
    });

    $(".product__suggestions").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      rtl: true,
      draggable: false,
      responsive: [
        {
          breakpoint: 1280,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 900,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 640,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });

    $(".product__suggestions").on("setPosition", function() {
      $(this)
        .find(".slick-slide")
        .height("auto");
      var slickTrack = $(this).find(".slick-track");
      var slickTrackHeight = $(slickTrack).height();
      $(this)
        .find(".slick-slide")
        .css("height", slickTrackHeight + "px");
    });

    $(".js-checkbox-diff-name").on("change", function(e) {
      $(".js-input-diff-name").slideToggle();
    });

    $("[data-show]").click(function(e) {
      $(`.${$(this).data("show")}`).show();
      $(this)
        .closest(".contact-info")
        .css("margin-bottom", "50");
    });

    $("[data-hide]").click(function(e) {
      $(`.${$(this).data("hide")}`).hide();
      $(this)
        .closest(".contact-info")
        .css("margin-bottom", "120");
    });

    $(".modal__input--search").on("input", function(e) {
      var $this = $(this),
        $out = $this.closest(".modal__input-out");

      if ($this.val().trim() === "") {
        $out.addClass("modal__input-out--empty");
      } else {
        $out.removeClass("modal__input-out--empty");
      }
    });

    function addItem(pid, pname, price, pricec, cid, qty) {
      var $c = $(`.calculator__main .calculator__cat[data-cid="${cid}"]`);
      var $calcAddToCart = $(".calc-sidebar__cart").find(".js-add-to-cart");
      if ($c.length == 0) {
        alert("category not found.");
        return false;
      }
      var max = $c.data("max") || 1;
      var totalQty = 0;

      if (totalQty >= max) {
        alert("Sorry, you can only add up to " + max + " component(s)");
        return false;
      }

      var $item = $(`.calc-sidebar__product[data-pid="${pid}"]`, $c);
      if ($item.length <= 0) {
        $(
          `<tr class="calc-sidebar__product plus-minus" data-pid="${pid}">
            <td>${pname}</td>
            <td class="calc-sidebar__qty">
            <span data-type="plus" aria-label="increase quantity by 1" class="btn-number">+</span>
            <input type="text" value="1" min="1" max="100" class="input-number"/><span data-type="minus" aria-label="decrease quantity by 1" class="btn-number">-</span>
            </td>
            <td class="js-cart-price" data-price="${price}">₪${pricec}</td>
          </tr>`
        ).insertAfter($(".calc-sidebar__t-header", $c));
      } else {
        var $qty = $(".calc-sidebar__qty input", $item);
        $qty.val(+$qty.val() + 1).change();
      }

      if ($c.hasClass("calculator__cat--closed")) {
        $c.removeClass("calculator__cat--closed");
      }
      if (!$c.hasClass("calculator__cat--active")) {
        $c.addClass("calculator__cat--active");
      }
      var $calcAddToCartHref = $calcAddToCart.attr("href");

      $calcAddToCart.attr("href", `${$calcAddToCartHref}${pid}:${qty},`);

      alert("Item has been added to the list.");
      return true;
    }

    function updatePrice() {
      var totalPrice = 0;
      var $sidebarCart = $(".js-add-to-cart");
      var $sidebarCartHref = $sidebarCart.attr("href");
      var host = location.origin;
      // $sidebarCart.attr("href", `${host}/?add-to-cart=`);

      $(".calc-sidebar__product").each(function(k, v) {
        var $this = $(this),
          $pid = $this.data("pid"),
          $pidReg = new RegExp(`${$pid}\:\\d+,`),
          $inputNumVal = $(".input-number", $this).val();
        totalPrice += $(".js-cart-price", $this).data("price") * $inputNumVal;
        $sidebarCartHref = $sidebarCartHref.replace(
          $pidReg,
          `${$pid}:${$inputNumVal},`
        );
      });

      // $sidebarCartHref = $sidebarCartHref.replace(/,$/, "");

      $sidebarCart.attr("href", $sidebarCartHref);

      $("#js-total-price").html(commaSeparateNumber(totalPrice));
    }

    $(".calculator__main").on("click", ".calc-product__add-to-cart", function(
      e
    ) {
      e.preventDefault();

      var $input = $(this);
      var pid = $input.data("pid");
      var $container = $input.closest(".calc-product");
      var pname = $(".calc-product__text", $container).text();
      var priceText =
        $(".calc-product__price ins span", $container).contents()[1] ||
        $(".calc-product__price span", $container).contents()[1];
      var price = priceText.textContent;
      var pricec = $(".calc-product__price span", $container).text();
      var cid = $input.data("cid");
      var qty = $input.data("qty");
      if (addItem(pid, pname, price, price, cid, qty)) {
        $container.addClass("calc-product--added");
      }

      updatePrice();
    });

    $(".catalog__main, .search__main").on(
      "click",
      ".calc-product__add-to-cart",
      function(e) {
        e.preventDefault();
        var $cartQty = parseInt($(".js-cart-qty").text());
        var $container = $(this).closest(".calc-product");
        $container.addClass("calc-product--added");

        $(".js-cart-qty").text($cartQty + 1);
      }
    );

    // $(".catalog__main, .search__main").on(
    //   "click",
    //   ".calc-product__remove-from-cart",
    //   function(e) {
    //     e.preventDefault();

    //     var $cartQty = parseInt($(".js-cart-qty").text());
    //     var $container = $(this).closest(".calc-product");
    //     $container.removeClass("calc-product--added");

    //     $(".js-cart-qty").text($cartQty - 1);
    //   }
    // );

    $(".calculator__main").on(
      "click",
      ".calc-product__remove-from-cart",
      function(e) {
        e.preventDefault();
        var $pid = $(this).data("pid");
        $(this)
          .closest(".calc-product")
          .removeClass("calc-product--added");

        var $item = $(`.calc-sidebar__product[data-pid="${$pid}"]`);
        if (
          $item.closest(".calculator__cat").find(".calc-sidebar__product")
            .length <= 1
        ) {
          $item
            .closest(".calculator__cat")
            .removeClass("calculator__cat--active");
          $item.closest(".calculator__cat").addClass("calculator__cat--closed");
        }
        $item.remove();

        updatePrice();
      }
    );

    $(".calc-product:not(.calc-product--gallery)").click(function(e) {
      $(this).toggleClass("calc-product--active");
    });

    $(".js-show-sidebar").click(function(e) {
      var $this = $(this),
        $calcContent = $this.closest(".calc-content");

      $calcContent.toggleClass("calc-content--sidebar-opened");
      $this
        .closest(".main")
        .find(".sidebar")
        .toggleClass("show");
    });

    // WP STUFF

    $(".catalog__main")
      .find(".calc-product__remove-from-cart")
      .click(function() {
        var $this = $(this),
          productId = $this.data("product_id");
        $.post(
          "/wp-admin/admin-ajax.php",
          {
            action: "remove_from_cart",
            product_id: productId
          },
          function(data) {
            if (data === "deleted") {
              var $cartQty = parseInt($(".js-cart-qty").text());

              $this.closest(".calc-product").removeClass("calc-product--added");

              $(".js-cart-qty").text($cartQty - 1);
            }
          }
        );
        return false;
      });
  });

  $(".js-print").click(function(e) {
    e.preventDefault();

    print();
  });

  $("[name=billing_per_month], [name='shipping_method[0]']").change(function(
    e
  ) {
    $(document.body).trigger("update_checkout");
  });

  var $awsSearchForm = $(".aws-search-form");
  if (jQuery.contains(document.documentElement, $awsSearchForm[0])) {
    $awsSearchForm.append(
      '<button type="submit" class="calc-content__search-btn"><i aria-hidden="true" class="fa fa-search"></i></button>'
    );
  }

  var $homePage = $("body.home");

  if ($homePage.length) {
    $homePage.on("keydown", function(e) {
      if (e.keyCode === 39) revapi2.revprev();
      if (e.keyCode === 37) revapi2.revnext();
    });
  }

  var $jsSubtotal = $(".js-subtotal");

  var $host = location.toString().slice(0, -1);
  var $hostLastSegment = $host.slice($host.lastIndexOf("/") + 1);
  var $catalogTabs = $(".catalog__tab");

  $catalogTabs.each(function(i, el) {
    var $this = $(this);
    $(el).removeClass("active");
    if ($this.hasClass($hostLastSegment)) {
      $this.addClass("active");
    }
  });

  $(window).on("load", function() {
    var $pageCalc = $(".page-template-page-calculator");

    if ($pageCalc.length) {
      $(".calculator__cat", $pageCalc)
        .first()
        .click();
    }

    if ($(".woocommerce-checkout").length && +$jsSubtotal.val() > 0) {
      $(document.body).trigger("update_checkout");

      $(".cart-sidebar__form").removeAttr("novalidate");
    }
  });

  $('[name="repair-delivery"]').on("change", function(e) {
    $(".js-select-repair").toggleClass("hidden");
  });

  var elements = $(".sticky");
  Stickyfill.add(elements);

  $(".woo-ordering").on("change", "select.orderby", function() {
    $(this)
      .closest("form")
      .submit();
  });
})(jQuery);
