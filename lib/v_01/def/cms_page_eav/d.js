// recreate page ids

function recreate_page(page_ids) {
  var row_counter = GET_E_VALUE("D_COUNTER");

  var lv = new Object({});

  lv.page_ids = [];

  for (var chk_i = 1; chk_i <= row_counter; chk_i++) {
    if (document.getElementById("c" + chk_i).checked == true) {
      lv.page_ids.push(document.getElementById("c" + chk_i).value);
    } //end if
  } //end for

  if (lv.page_ids.length > 0) {
    lv.page_id_list = lv.page_ids.join(",");

    d_series.ajax.set_request(
      "router.php",
      "&action=RCPC&page_id_list=" + lv.page_id_list,
    );

    d_series.ajax.send_get(page_recreate_response);

    G.showLoader("Updating");
  } else {
    bootbox.alert({ message: "Kindly select atleast one page" });
  }
} // end

// response

function page_recreate_response(response) {
  G.hideLoader();

  var lv = JSON.parse(response);

  if (lv.status == 1) {
    G.bs_alert_success(
      "Pages <br><b>" + lv.recreated_pages + "</b><br>successfully updated",
      "",
      "Recreaion Update",
    );
  } else {
    G.bs_alert_error("Sorry, something went wrong");
  }
} //

function coach_content(input) {
  //var data = input.split(':');

  var lv = new Object({});

  lv.key_id = input;

  //lv.page  = data[1];

  d_series.ajax.set_request(
    "router.php",
    "&series=a&action=cms_page_eav&token=SECT&param=" + JSON.stringify(lv) + "",
  );

  //d_series.get_resonse_action((function(){alert('--')})());
  G.showLoader("Updating");

  d_series.ajax.send_get(coach_content_response_action);
}

function coach_content_response_action() {
  G.hideLoader();

  bootbox.alert({
    message: "Successfully Published",
    size: "small",
    callback: function () {
      G.hideLoader();
    },
  });
} // end
