jQuery(function($) {
  //blog posts static page

  $(".loadmore").click(function() {
    var button = $(this),
      data = {
        action: "loadmore",
        query: loadmore_params.posts, // that's how we get params from wp_localize_script() function
        page: loadmore_params.current_page
      };

    $.ajax({
      url: loadmore_params.ajaxurl, // AJAX handler
      data: data,
      type: "POST",
      beforeSend: function(xhr) {
        button.text("Loading..."); // change the button text, you can also add a preloader image
      },
      success: function(data) {
        if (data) {
          button
            .text("More " + ajax_session[query_id][0].post_type)
            .prev()
            .after(data); // insert new posts
          loadmore_params.current_page++;

          if (loadmore_params.current_page == loadmore_params.max_page)
            button.remove(); // if last page, remove the button
        } else {
          //button.remove(); // if no data, remove the button as well
        }
      }
    });
  });

  $(".loadmore2").click(function() {
    //custom query on front-page.php
    let query_id = $(this)
      .closest("session")
      .attr("id");
    console.log(query_id);
    var button = $(this),
      data = {
        action: "loadmore",
        query: ajax_session[query_id][0],
        page: ajax_session[query_id][2]
      };
    // console.log(pid_Data.siteurl + "/wp-admin/admin-ajax.php");
    console.log(data);
    $.ajax({
      url: pid_Data.siteurl + "/wp-admin/admin-ajax.php", // AJAX handler
      data: data,
      type: "POST",
      beforeSend: function(xhr) {
        button.text("Loading..."); // change the button text, you can also add a preloader image
      },
      success: function(data) {
        if (data) {
          button
            .text("More " + ajax_session[query_id][3])
            .prev()
            .after(data); // insert new posts

          ajax_session[query_id][2]++;
          if (ajax_session[query_id][2] == ajax_session[query_id][1])
            button.remove();
        } else {
          //button.remove(); // if no data, remove the button as well
        }
      }
    });
  });
});
