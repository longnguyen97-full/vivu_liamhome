(function ($) {
  // Start block - document
  $(document).ready(function () {
    // Trigger form
    $(".dang-nhap a").click(function (e) {
      e.preventDefault();
      let data = {
        title: "Đăng Nhập",
        sucess_button: "Đăng Nhập",
        failed_button: "Hủy Bỏ",
        slug: "login",
        isLogout: true,
      };
      getSweetAlert2Form(data);
      // Trigger login via email
      $("#login_email").change(function () {
        if ($(this).is(":checked")) {
          $("#username").parent().addClass("hide");
          $("#email").parent().removeClass("hide");
        } else {
          $("#email").parent().addClass("hide");
          $("#username").parent().removeClass("hide");
        }
      });
    });
    $(".dang-ki a").click(function (e) {
      e.preventDefault();
      let data = {
        title: "Đăng Kí",
        sucess_button: "Đăng Kí",
        failed_button: "Hủy Bỏ",
        slug: "register",
      };
      getSweetAlert2Form(data);
    });
    $(".dang-xuat a").click(function (e) {
      e.preventDefault();
      ajaxSweetAlert2Form({ isLogout: true });
    });
    // Get form
    function getSweetAlert2Form(data) {
      Swal.fire({
        title: `<strong>${data.title}</strong>`,
        html: buildSweetAlert2Form(data.slug),
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `<i class="fas fa-check"></i> ${data.sucess_button}`,
        cancelButtonText: `<i class="fas fa-ban"></i> ${data.failed_button}`,
        preConfirm: () => {
          return new Promise((resolve, reject) => {
            // get your inputs using their placeholder or maybe add IDs to them
            let slug = $('input[id="slug"]').val();
            let data = "";
            if (slug == "login") {
              data = {
                username: $('input[id="username"]').val(),
                email: $('input[id="email"]').val(),
                password: $('input[id="password"]').val(),
                slug: slug,
              };
            }
            if (slug == "register") {
              data = {
                username: $('input[id="username"]').val(),
                email: $('input[id="email"]').val(),
                first_name: $('input[id="first_name"]').val(),
                last_name: $('input[id="last_name"]').val(),
                password: $('input[id="password"]').val(),
                confirm_password: $('input[id="confirm_password"]').val(),
                slug: slug,
              };
            }
            resolve(data);
          });
        },
      }).then((result) => {
        if (result.isConfirmed) {
          ajaxSweetAlert2Form(result.value);
        }
      });
    }
  });
  // End block - document
  // Build form
  function buildSweetAlert2Form(slug) {
    if (slug == "login") {
      return `
      <div class="container">
        <form class="text-start">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username">
            </div>
            <div class="mb-3 hide">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Chúng tôi sẽ không bao giờ chia sẻ địa chỉ email của bạn với người khác.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="login_email">
                <label class="form-check-label" for="login_email">Đăng nhập bằng email</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me">
                <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
            </div>
            <input type="hidden" id="slug" value="${slug}">
        </form>
      </div>`;
    }
    if (slug == "register") {
      return `
      <div class="container">
        <form class="text-start">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" placeholder="member123">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="member123@gmail.com" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Chúng tôi sẽ không bao giờ chia sẻ địa chỉ email của bạn với người khác.</div>
            </div>
            <div class="mb-3 row">
                <label class="form-label">Họ và tên</label>
                <div class="col">
                    <input type="text" class="form-control" id="first_name" placeholder="Họ" aria-label="Họ">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="last_name" placeholder="Tên" aria-label="Tên">
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" placeholder="Mật khẩu của bạn">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="Mật khẩu của bạn">
            </div>
            <input type="hidden" id="slug" value="${slug}">
        </form>
      </div>`;
    }
  }
  // Call ajax
  function ajaxSweetAlert2Form(data) {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: authentication_params.ajax_url,
      data: {
        action: "authenticate",
        data: data,
      },
      success: function (response) {
        response.success
          ? location.reload()
          : console.log("The following error occured");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("The following error occured: " + textStatus, errorThrown);
      },
    });
  }
})(jQuery);
