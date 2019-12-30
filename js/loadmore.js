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
        page: ajax_session[query_id][2],
        session_id: query_id
      };
    var nav = $(this)
      .closest("session")
      .find("nav");
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
          nav.prev().before(data);
          button.text("More " + ajax_session[query_id][3]);
          // .prev()
          // .after(data); // insert new posts

          ajax_session[query_id][2]++;
          if (ajax_session[query_id][2] == ajax_session[query_id][1]) {
            button.text("");
            button.off("click");
          } else {
            button.text("More " + ajax_session[query_id][3]);
            button.on("click", loadbutton);
          }
        } else {
          button.text(""); // if no data, remove the button as well
        }
      }
    });
  });

  $(".pid-page-numbers").click(function() {
    let query_id = $(this)
      .closest("session")
      .attr("id");
    // console.log(query_id);
    let page_anchor = $(this);
    let page_anchors = $(this)
      .closest("session")
      .find("nav a");
    console.log(page_anchors);
    let button = $(this)
      .closest("session")
      .find(".loadmore2");
    // console.log(button);
    let post_div = $(this)
      .closest("session")
      .find("." + query_id);
    // console.log(post_div);
    let nav = $(this).closest("nav");
    let page_number = page_anchor.attr("page_id");
    ajax_session[query_id][2] = page_number;

    var data = {
      action: "loadmore",
      query: ajax_session[query_id][0],
      page: ajax_session[query_id][2] - 1,
      session_id: query_id
    };

    // console.log(page_anchor.attr("page_id"));
    // console.log(ajax_session);
    // console.log(data);
    $.ajax({
      url: pid_Data.siteurl + "/wp-admin/admin-ajax.php", // AJAX handler
      data: data,
      type: "POST",
      beforeSend: function(xhr) {
        button.text("Loading..."); // change the button text, you can also add a preloader image
      },
      success: function(data) {
        if (data) {
          post_div.remove();
          nav.prev().before(data);

          button.text("More " + ajax_session[query_id][3]);

          console.log(ajax_session[query_id][2]);
          console.log(ajax_session[query_id][1]);
          if (ajax_session[query_id][2] == ajax_session[query_id][1]) {
            button.text("");
            button.off("click");
          } else {
            button.text("More " + ajax_session[query_id][3]);
            button.on("click");
          }
          //re-pagination by javascript
          page_anchors.removeClass("current");
        } else {
          button.text("");
        }
      }
    });
  });

  $("body").on("click", "#misha_loadmore", function() {
    $.ajax({
      url: pid_Data.siteurl + "/wp-admin/admin-ajax.php", // AJAX handler
      data: {
        action: "loadmore",
        query: misha_loadmore_params.posts,
        page: misha_loadmore_params.current_page,
        first_page: pid_Data.first_page // here is the new parameter
      },
      type: "POST",
      beforeSend: function(xhr) {
        $("#misha_loadmore").text("Loading...");
      },
      success: function(data) {
        $("#misha_loadmore").remove(); // remove button
        $("#misha_pagination")
          .before(data)
          .remove(); // add new posts and remove pagination links
        misha_loadmore_params.current_page++;
      }
    });
    return false;
  });
});
