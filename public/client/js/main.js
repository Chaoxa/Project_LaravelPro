$(document).ready(function () {
    $(".title1").click(function () {
        $(".collapse1").toggleClass("show");
        $(".title1 i").toggleClass("fa-rotate-180");
    });

    $(".title2").click(function () {
        $(".collapse2").toggleClass("show");
        $(".title2 i").toggleClass("fa-rotate-180");
    });

    $(".title3").click(function () {
        $(".collapse3").toggleClass("show");
        $(".title3 i").toggleClass("fa-rotate-180");
    });

    $("#category-product-wp .list-item > li")
        .find(".sub-menu")
        .after('<i class="fa-solid fa-angle-right arrow"></i>');

    var discountEndTime = new Date("2023-07-31T23:59:59").getTime();

    var countdown = setInterval(function () {
        var now = new Date().getTime();
        var timeLeft = discountEndTime - now;

        var hours = Math.floor(
            (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        // Sử dụng getElementsByClassName thay thế cho getElementById
        var hourBoxes = document.getElementsByClassName("hour-box");
        var minuteBoxes = document.getElementsByClassName("minute-box");
        var secondBoxes = document.getElementsByClassName("second-box");

        // Lặp qua các phần tử có class tương ứng và cập nhật giá trị
        for (var i = 0; i < hourBoxes.length; i++) {
            hourBoxes[i].innerText = hours < 10 ? "0" + hours : hours;
        }

        for (var i = 0; i < minuteBoxes.length; i++) {
            minuteBoxes[i].innerText = minutes < 10 ? "0" + minutes : minutes;
        }

        for (var i = 0; i < secondBoxes.length; i++) {
            secondBoxes[i].innerText = seconds < 10 ? "0" + seconds : seconds;
        }

        if (timeLeft < 0) {
            clearInterval(countdown);
            // Để tránh hiển thị giá trị âm, bạn có thể đặt giá trị là "00" hoặc xử lý theo ý muốn
            for (var i = 0; i < hourBoxes.length; i++) {
                hourBoxes[i].innerText = "00";
            }
            for (var i = 0; i < minuteBoxes.length; i++) {
                minuteBoxes[i].innerText = "00";
            }
            for (var i = 0; i < secondBoxes.length; i++) {
                secondBoxes[i].innerText = "00";
            }
        }
    }, 1000);
    $(document).ready(function () {
        $(".show-product .owl-carousel").owlCarousel({
            loop: false,
            margin: 10,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 4,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                },
            },
        });
    });
    $(document).ready(function () {
        $(".wp-same-category .same-category.owl-carousel").owlCarousel({
            loop: false,
            margin: 10,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                },
            },
        });
    });

    $(".list_thumb .item img").on("click", function () {
        var detailImageSrc = $(this).attr("src");
        var thumbMainImage = $(".thumb_main img");
        thumbMainImage.css("opacity", 0);
        setTimeout(function () {
            thumbMainImage.attr("src", detailImageSrc);
            thumbMainImage.css("opacity", 1);
        }, 100);
    });
});

var value = parseInt($("#num-order").attr("value"));
$("#plus").click(function () {
    value++;
    $("#num-order").attr("value", value);
    update_href(value);
});
$("#minus").click(function () {
    if (value > 1) {
        value--;
        $("#num-order").attr("value", value);
    }
    update_href(value);
});

function selectOption(event, optionId) {
    var buttons = document.getElementsByClassName("option-button");
    event.preventDefault();

    document.getElementById("selected_option_id").value = optionId;
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("selected");
    }

    var selectedButton = event.target;
    selectedButton.classList.add("selected");
}

$(document).ready(function () {
    var originalDescOffset = $(".wp-desc-detail").offset().top;
    $(".desc-detail-full").hide();

    $(".view-mode").click(function () {
        if ($(".desc-detail-full").is(":visible")) {
            $(".desc-detail-demo").show();
            $(".desc-detail-full").hide();
            $(".view-mode").text("Xem thêm");
            $("html, body").animate({ scrollTop: originalDescOffset }, "slow");
        } else {
            $("html, body").animate({ scrollTop: originalDescOffset }, "slow");
            $(".desc-detail-demo").hide();
            $(".desc-detail-full").show();
            $(".view-mode").text("Ẩn bớt");
        }
    });
});
