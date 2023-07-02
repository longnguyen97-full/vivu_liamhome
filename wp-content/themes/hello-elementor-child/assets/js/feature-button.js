(function ($) {
  $(document).ready(function () {
    let vPostIDFields = $(".hidden-post-id .elementor-icon-list-text");
    let vPostIDs = [];
    for (let vPostIDField of vPostIDFields) {
      let vPostID = parseInt($(vPostIDField).html());
      vPostIDs.push(vPostID);
    }
    $.ajax({
      type: "post", //HTTP method: Get/Post
      dataType: "json", //Type of response data: xml, json, script, html
      url: ajax_object.ajax_url, //An endpoint (url) contain functions that handle data by default
      data: {
        action: "feature_button", //Action name: JS and PHP both call to this name to handle data together
        postIDs: vPostIDs, //Pass data from JS to 1 variable, and PHP will catch it, for example: $_POST['description']
      },
      context: this, //Decide value to use in function is whatever the value was where this ajax call was made
      //Ajax was handled
      success: function (response) {
        if (response.success) {
          //response with data
          addFeatureButton(response.data);
        } else {
          //response without data
          console.log("Something went wrong");
        }
      },
      //Ajax wasn't handled
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("The following error occured: " + textStatus, errorThrown);
      },
    });
    function addFeatureButton(paramButtonData) {
      let vPostIDFields = $(".hidden-post-id .elementor-icon-list-text");
      for (let i = 0; i < vPostIDFields.length; i++) {
        let vPostID = parseInt(paramButtonData[i].postID);
        let vClass = paramButtonData[i].class;
        let vPostURL = paramButtonData[i].postURL;
        let vPostIDRef = parseInt($(vPostIDFields[i]).html());
        let isLoggedIn = jQuery("body").hasClass("logged-in");
        // create a button list
        let vButtonList = `<a href="${vPostURL}" class="btn btn-primary shadow-none">Chi tiết</a>&nbsp;`;
        if (isLoggedIn) {
          vButtonList += `<span class="bookmark"><a href="#" class="btn btn-primary shadow-none ${vClass}">Lưu lại</a></span>`;
          vButtonList += `<input type="hidden" value="${vPostID}" class="bookmark-post_id">`;
        }
        // add button list to DOM tree
        if (vPostIDRef === vPostID) {
          vPostIDFields[i].closest(".hidden-post-id").innerHTML = vButtonList;
        }
      }
    }
  });
})(jQuery);
