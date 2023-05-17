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

    $document.on("change", ".symbolDet", function (e) {
        var symbolVal = $(this).val();
        if ($.trim(symbolVal) !== "") {
            $(".selectedCompName").text(
                $(this).find(":selected").attr("data-name")
            );
            $("#symbol-error").text("");
        } else {
            $("#symbol-error").text("Symbol is required.");
        }
    });

    // Add input event listener to symbol field
    // $("#symbol").on("input", function () {
    //     var symbol = $(this).val();
    //     // Clear any previous error message
    //     $("#symbol-error").text("");
    //     if (symbol !== "") {
    //         // Make AJAX request to validate symbol
    //         // $.get("validate-symbol.php", { symbol: symbol }, function (data) {
    //         //     if (data !== "valid") {
    //         //         $("#symbol-error").text("Symbol is invalid.");
    //         //     }
    //         // });
    //     }
    // });

    // Add input event listener to start date field
    $("#start-date").on("change", function () {
        var startDate = $(this).val();
        // Clear any previous error message
        $("#start-date-error").text("");
        if (startDate !== "") {
            $(".selStartDate").text(startDate);
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
            $(".selEndDate").text(endDate);
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

        var continueFrm = true;

        // Get form values
        var symbol = $("#symbol").val();
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var email = $("#email").val();

        // Validate symbol
        if (symbol === "") {
            $("#symbol-error").text("Symbol is required.");
            continueFrm = false;
        }

        // Validate start date
        if (startDate === "") {
            $("#start-date-error").text("Start date is required.");
            continueFrm = false;
        } else if (!isValidDate(startDate)) {
            $("#start-date-error").text("Start date is invalid.");
            continueFrm = false;
        } else if (new Date(startDate) > new Date()) {
            $("#start-date-error").text("Start date cannot be in the future.");
            continueFrm = false;
        }

        // Validate end date
        if (endDate === "") {
            $("#end-date-error").text("End date is required.");
            continueFrm = false;
        } else if (!isValidDate(endDate)) {
            $("#end-date-error").text("End date is invalid.");
            continueFrm = false;
        } else if (new Date(endDate) > new Date()) {
            $("#end-date-error").text("End date cannot be in the future.");
            continueFrm = false;
        } else if (new Date(endDate) < new Date(startDate)) {
            $("#end-date-error").text(
                "End date must be greater than or equal to start date."
            );
            continueFrm = false;
        }

        // Validate email
        if (email === "") {
            $("#email-error").text("Email is required.");
            continueFrm = false;
        } else if (!isValidEmail(email)) {
            $("#email-error").text("Email is invalid.");
            continueFrm = false;
        }

        if (continueFrm) {
            $("#xmForm").submit();
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

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function loadChartData() {
        // Retrieve historical data from API using AJAX request
        var formData = new FormData();
        formData.append("symbolSelected", $("#symbol").val());
        formData.append("startDate", $("#start-date").val());
        formData.append("endDate", $("#end-date").val());
        $.ajax({
            url: "/fetch-data",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $("#historical-loader-chart").css("display", "flex");
            },
            success: function (data) {
                //console.log(data);
                $("#historical-loader-chart").css("display", "none");
                // Create chart data from historical data
                var chartData = {
                    labels: data.map(function (item) {
                        return item.date;
                    }),
                    datasets: [
                        {
                            label: "Open Price",
                            data: data.map(function (item) {
                                return item.open;
                            }),
                            backgroundColor: "rgba(255, 99, 132, 0.2)",
                            borderColor: "rgba(255, 99, 132, 1)",
                            borderWidth: 1,
                        },
                        {
                            label: "Close Price",
                            data: data.map(function (item) {
                                return item.close;
                            }),
                            backgroundColor: "rgba(54, 162, 235, 0.2)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1,
                        },
                    ],
                };
                // Set chart options
                var chartOptions = {
                    responsive: true,
                    title: {
                        display: true,
                        text: "Historical Open and Close Prices",
                    },
                    scales: {
                        xAxes: [
                            {
                                type: "time",
                                time: {
                                    parser: "YYYY-MM-DD",
                                    tooltipFormat: "ll",
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: "Date",
                                },
                            },
                        ],
                        yAxes: [
                            {
                                scaleLabel: {
                                    display: true,
                                    labelString: "Price",
                                },
                            },
                        ],
                    },
                };
                // Create chart object
                var myChart = new Chart(document.getElementById("myChart"), {
                    type: "line",
                    data: chartData,
                    options: chartOptions,
                });
            },
            error: function (error) {
                console.log(error);
            },
        });
    }

    function loadStockTable() {
        $.fn.dataTable.ext.errMode = "none";
        if (!$.fn.DataTable.isDataTable("#stockTable")) {
            $("#stockTable").DataTable({
                ajax: {
                    url: "/fetch-data",
                    dataSrc: "",
                    data: function (params) {
                        // pass the DataTable search and pagination parameters to the server
                        return {
                            symbolSelected: $("#symbol").val(),
                            startDate: $("#start-date").val(),
                            endDate: $("#end-date").val(),
                        };
                    },
                    error: function (xhr, error, thrown) {
                        console.log("Error occurred: " + error);
                        // perform any necessary error handling here
                    },
                },
                aLengthMenu: [
                    [5, 10, 100, 500, 1000],
                    ["5", "10", "100", "500", "1000"],
                ],
                initComplete: function (settings, json) {
                    $(".stockTable").show();
                    loadChartData();
                    $(".backToFrm").show();
                    $("#historical-loader").hide();
                },
                columns: [
                    { data: "date" },
                    { data: "open" },
                    { data: "high" },
                    { data: "low" },
                    { data: "close" },
                    { data: "volume" },
                ],
            });
        } else {
            $("#canvaCont").html(
                '<canvas id="myChart" height="180px"></canvas>'
            );
            $("#stockTable").DataTable().clear().draw();
            var datable = $("#stockTable").DataTable();
            datable.ajax.reload();
            $("#historical-loader").hide();
            loadChartData();
            $(".backToFrm").show();
            // new $.fn.DataTable.isDataTable(datable, {});
        }
    }

    $document.on("click", "#backForm", function () {
        $("#pageTwo").hide();
        $("#pageOne").show();
        if ($.fn.DataTable.isDataTable("#stockTable")) {
            $("#stockTable").DataTable().clear().draw();
        }
        $("#myChart").html("");
    });

    $document.on("submit", "#xmForm", function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Make an AJAX request
        var formData = new FormData(this);

        formData.append("startDate", $("#start-date").val());
        formData.append("endDate", $("#end-date").val());

        $.ajax({
            url: `/submit-form`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $(".backToFrm").hide();
                $(".showOnError").hide();
                $(".hiddenOnError").show();
                $("#historical-loader").show();
                $("#pageOne").hide();
                $("#pageTwo").show();
            },
            success: function (response) {
                // console.log(response);
                if (response.data.length > 0) {
                    loadStockTable();
                } else {
                    $(".showOnError").show();
                    $(".backToFrm").show();
                    $(".hiddenOnError").hide();
                    $("#historical-loader").hide();
                }
            },
            error: function (xhr) {
                // Handle any errors
                console.log(xhr.responseText);
            },
        });
    });
});
