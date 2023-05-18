(function ($) {
  // Start block - document
  $(document).ready(function () {
    // Trigger
    $(".bookmark a").click(function (e) {
      e.preventDefault();
      let postID = $(".bookmark-post_id").val();
      if ($(this).hasClass("marked")) {
        $(this).removeClass("marked");
        markPost(false, postID);
      } else {
        $(this).addClass("marked");
        markPost(true, postID);
      }
    });
  });
  function markPost(markPost, postID) {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: bookmark_params.ajax_url,
      data: {
        action: "bookmark",
        markPost: markPost,
        postID: postID,
      },
      success: function (response) {
        if (response.success !== true) {
          console.log("The following error occured");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("The following error occured: " + textStatus, errorThrown);
      },
    });
  }
  // End block - document
})(jQuery);
