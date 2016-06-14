/**
 *   All Modals/Dialog boxes for Buying.
 */

$(document).ready()
{
    // Close any modal on esc keypress
    $(document).on('keyup', function (evt) {
        if (evt.keyCode == 27) {
            $(".modal").modal('hide');
            $('.modal-backdrop').remove();
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    // Button click event listener
    $("#register-btn").click(function () {
        $("#sign-up-modal").modal('show');
    });

    // Buy button click events
    $(".buy-btn").click(function () {
      if ($("input[type=radio]:checked").length > 0) {
          $("#radio-error").html("&nbsp");
          $("#quick-buy-modal").modal('hide');
          if (signedIn) {
              $("#buy-dialog-user").modal('show');
          }
          else {
              $("#buy-dialog-guest").modal('show');
          }
      }
      else {
          $("#radio-error").html("Please select a license");
      }
    });

    // Close buttons
    $(".close-btn").click(function () {
        $(".modal").modal('hide');
    });

    // Sign in buttons
    $("#sign-in-click").click(function () {
        $("#buy-dialog-guest").modal('hide');
        $("#sign-in-modal").modal('show');
    });

    // Retrive license type for quick buy
    function quickBuy(ImageID, ImageName) {
        $.ajax({
            type: 'POST',
            url: 'quickBuy.php',
            data: {'currentImageID': ImageID},
            success: function (html) {
                $("#quick-buy-modal").html(html);
                $("#quick-buy-item").html(ImageName);
                $("#quick-buy-modal").modal('show');
            }
        });
    }

    // Radio lincense buttons
    function uncheck(lic, priceSize) {

        $("#selected-license span").html(priceSize);

        if (lic === "standard") {
            var radios = document.getElementsByName('extended');
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked)
                    radios[i].checked = false;
            }

        } else if (lic === "extended") {
            var radios = document.getElementsByName('standard');
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked)
                    radios[i].checked = false;
            }
        }
    }
}
