$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
});

var inputFile = document.querySelector("#file_upload");

function chooseFile(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#image").attr("src", e.target.result);
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
}

var inputFile = document.querySelector(".img");
const fileUpload = document.getElementById("file-uploads");
fileUpload.addEventListener("change", (event) => {
    const files = event.target.files;
    var str = "";
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var url = URL.createObjectURL(file);
        str +=
            "<span><img class = 'img m-2' src='" +
            url +
            "' width='110' height='110' class='img' </span>";
    }
    var blockImages = document.getElementById("images");
    blockImages.innerHTML = str;
    // console.log(str)
});
