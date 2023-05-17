import "./bootstrap";

$(document).ready(function () {
    "use strict";
    var $window = $(window),
        $document = $(document);

    // Initialize datepicker
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: 0, // Today's date
    });

    $("input").attr("autocomplete", "off");

    // $document.on("change", ".symbolDet", function (e) {
    //     var symbolVal = $(this).val();
    //     if ($.trim(symbolVal) !== "") {
    //         $("#symbol-error").text("");
    //     } else {
    //         $("#symbol-error").text("Symbol is required.");
    //     }
    // });

    // Add input event listener to symbol field
    $("#symbol").on("input", function () {
        var symbol = $(this).val();
        // Clear any previous error message
        $("#symbol-error").text("");
        if (symbol !== "") {
            // Make AJAX request to validate symbol
            $.get("validate-symbol.php", { symbol: symbol }, function (data) {
                if (data !== "valid") {
                    $("#symbol-error").text("Symbol is invalid.");
                }
            });
        }
    });

    // Add input event listener to start date field
    $("#start-date").on("change", function () {
        var startDate = $(this).val();
        // Clear any previous error message
        $("#start-date-error").text("");
        if (startDate !== "") {
            if (!isValidDate(startDate)) {
                $("#start-date-error").text("Start date is invalid.");
            } else if (new Date(startDate) > new Date()) {
                $("#start-date-error").text(
                    "Start date cannot be in the future."
                );
            } else {
                var endDate = $("#end-date").val();
                if (endDate !== "" && new Date(startDate) > new Date(endDate)) {
                    $("#start-date-error").text(
                        "Start date must be less than or equal to end date."
                    );
                }
            }
        }
    });

    // Add input event listener to end date field
    $("#end-date").on("change", function () {
        var endDate = $(this).val();
        // Clear any previous error message
        $("#end-date-error").text("");
        if (endDate !== "") {
            if (!isValidDate(endDate)) {
                $("#end-date-error").text("End date is invalid.");
            } else if (new Date(endDate) > new Date()) {
                $("#end-date-error").text("End date cannot be in the future.");
            } else {
                var startDate = $("#start-date").val();
                if (
                    startDate !== "" &&
                    new Date(endDate) < new Date(startDate)
                ) {
                    $("#end-date-error").text(
                        "End date must be greater than or equal to start date."
                    );
                }
            }
        }
    });

    // Add input event listener to email field
    $("#email").on("input", function () {
        var email = $(this).val();
        // Clear any previous error message
        $("#email-error").text("");
        if (email !== "" && !isValidEmail(email)) {
            $("#email-error").text("Email is invalid.");
        }
    });

    // Validate form on submit
    $document.on("click", "#submitForm", function (event) {
        event.preventDefault();
        // Clear any previous error messages
        $(".text-red-500").text("");

        // Get form values
        var symbol = $("#symbol").val();
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var email = $("#email").val();

        // Validate symbol
        if (symbol === "") {
            $("#symbol-error").text("Symbol is required.");
            event.preventDefault();
        }

        // Validate start date
        if (startDate === "") {
            $("#start-date-error").text("Start date is required.");
            event.preventDefault();
        } else if (!isValidDate(startDate)) {
            $("#start-date-error").text("Start date is invalid.");
            event.preventDefault();
        } else if (new Date(startDate) > new Date()) {
            $("#start-date-error").text("Start date cannot be in the future.");
            event.preventDefault();
        }

        // Validate end date
        if (endDate === "") {
            $("#end-date-error").text("End date is required.");
            event.preventDefault();
        } else if (!isValidDate(endDate)) {
            $("#end-date-error").text("End date is invalid.");
            event.preventDefault();
        } else if (new Date(endDate) > new Date()) {
            $("#end-date-error").text("End date cannot be in the future.");
            event.preventDefault();
        } else if (new Date(endDate) < new Date(startDate)) {
            $("#end-date-error").text(
                "End date must be greater than or equal to start date."
            );
            event.preventDefault();
        }

        // Validate email
        if (email === "") {
            $("#email-error").text("Email is required.");
            event.preventDefault();
        } else if (!isValidEmail(email)) {
            $("#email-error").text("Email is invalid.");
            event.preventDefault();
        }
    });

    // Function to check if a string is a valid date in the format "yyyy-mm-dd"
    function isValidDate(dateString) {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(dateString)) {
            return false;
        }
        var year = parseInt(dateString.substr(0, 4), 10);
        var month = parseInt(dateString.substr(5, 2), 10) - 1; // Months are zero-indexed
        var day = parseInt(dateString.substr(8, 2), 10);
        var date = new Date(year, month, day);
        return (
            date.getFullYear() === year &&
            date.getMonth() === month &&
            date.getDate() === day
        );
    }

    // Function to check if a string is a valid email address
    function isValidEmail(emailString) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(emailString);
    }
});
