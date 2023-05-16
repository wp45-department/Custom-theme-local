jQuery(document).ready(function () {
  /**
   * Handle error messages
   */
  function wpse_97845_handle_error(error) {
    jQuery("#ajax-error").html(error).show();
  }

  /**
   * Process Ajax response
   */
  function wpse_97845_do_response(response) {
    // Error
    jQuery(".sp-show-spinner").css("visibility", "hidden");
    if (!response.success) {
      wpse_97845_handle_error(response.data.error);
      return;
    }

    // Display success response
    jQuery("#ajax-success").html(response.data).show();
  }

  /**
   * Ajax button call
   */
  jQuery("#publish-to-other-blog").click(function (event) {
    event.preventDefault();
    jQuery("#ajax-success").hide();
    jQuery("#ajax-error").hide();

    post_id = jQuery("#publish-to-other-blog").attr("name");
    tour_title = jQuery("input[name='dup_post_title']").val();
    tour_slug = jQuery("input[name='dup_post_slug']").val();
    if (tour_title == "") {
      jQuery("input[name='dup_post_title']").focus();
      return false;
    }
    if (tour_slug == "") {
      jQuery("input[name='dup_post_slug']").focus();
      return false;
    }
    // Prepare data
    var data = {
      action: "update_metabox_wpse_97845",
      ajaxnonce: wp_ajax.ajaxnonce,
      wpse_97845_post_id: post_id,
      wpse_97845_tour_title: tour_title,
      wpse_97845_tour_slug: tour_slug,
    };
    jQuery(".sp-show-spinner").css("visibility", "visible");
    // Send Ajax request
    jQuery.post(wp_ajax.ajaxurl, data, wpse_97845_do_response);
  });
});
