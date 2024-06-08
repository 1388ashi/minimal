function convertToPersianNumbers(text) {
    return text.replace(/[0-9]/g, function (digit) {
        return String.fromCharCode(digit.charCodeAt(0) + 1728);
    });
}

$(document).ready(function () {
    $("body")
        .find("*")
        .each(function () {
            if ($(this).is(":not(:has(*))")) {
                var text = $(this).text();
                var persianText = convertToPersianNumbers(text);
                $(this).text(persianText);
            }
        });

    $("input.comma").on("keyup", function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });

    $(".date").each(function () {
        var date = new Date($(this).text());
        if (!isNaN(date)) {
            var options = { year: "numeric", month: "numeric", day: "numeric" };
            var formattedDate = date.toLocaleDateString("fa-IR", options);
            $(this).text(formattedDate);
        }
    });
});
