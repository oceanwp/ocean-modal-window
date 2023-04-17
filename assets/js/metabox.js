var $j = jQuery.noConflict();

$j(document).on("ready", function () {

  if ( $j("div#butterbean-control-oceanwp_mw_cond_logic").length > 0 ) {
    var mwId = $j("input[name='post_ID']").val();
    var activeCond = 0;
    if (
      $j(
        "input[name='butterbean_oceanwp_mw_settings_setting_oceanwp_mw_cond_logic']"
      ).is(":checked")
    ) {
      activeCond = 1;
    }

    var data = {
      "action": "get_mw_conditional_rules",
      "activeCond": activeCond,
      "mwId": mwId,
    };
    //alert(data.toSource());
    $j.post(ajaxurl, data, function (response) {
      //alert('Got this from the server: ' + response);
      console.log(response);
      var obj = JSON.parse(response);
      if (obj.status) {
        $j("div#butterbean-control-oceanwp_mw_cond_logic").after(obj.condHTML);
      }
    });

    $j(document).on(
      "change",
      "input[name='butterbean_oceanwp_mw_settings_setting_oceanwp_mw_cond_logic']",
      function () {
        var checkbox = $j(this);
        if (checkbox.is(":checked")) {
          $j("div.options-cond").show();
        } else {
          $j("div.options-cond").hide();
        }
      }
    );

    // Remove Display
    $j(document).on("click", ".display-on-remove", function () {
      $j(this).closest(".dispaly-on").remove();
    });

    $j(document).on("click", ".hide-on-remove", function () {
      $j(this).closest(".hide-on").remove();
    });
  }
});

/* ==============================================
ADD/REMOVE DISPLAY ON
============================================== */
function add_mw_display_on() {
  var template = wp.template("dispaly-on-field");
  $j(".display-on-fields").append(template());
}

/* ==============================================
ADD/REMOVE HIDE ON
============================================== */
function add_mw_hide_on() {
  var template = wp.template("hide-on-field");

  $j(".hide-on-fields").append(template());
}
