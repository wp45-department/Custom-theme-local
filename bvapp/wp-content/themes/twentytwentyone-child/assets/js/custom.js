// $("body .demo-edit-btn").on("click", function () {
//     $(".demo-title").addClass("active");
//   });
//   $(document).on("click", function () {
//     $(".demo-title").removeClass("active");
//   });

$(document).ready(function () {
  $(".demo-edit-btn").click(function () {
    var docClick = function (ev) {
      if (!$(ev.target).hasClass("demo-edit-btn")) {
        closeDropdown();
      }
    };

    var closeDropdown = function () {
      $(".demo-title").removeClass("active");
      $(document).unbind("click", docClick);
    };

    if ($(this).parent().prev(".demo-title").hasClass("active")) {
      closeDropdown();
    } else {
      $(document).bind("click", docClick);
      $(this).parent().prev(".demo-title").addClass("active");
    }
  });
});

$("#login-from-submit").submit(function (e) {
  e.preventDefault();
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: $(this).serialize(),
    success: function (data) {
      $("#loadershowhide").hide();
      if (data == 1) {
        window.location.href = site_url + "/admin-dashboard";
      } else if (data == 2) {
        window.location.href = site_url + "/dashboard";
      } else if (data == 3) {
        window.location.href = site_url + "/viewer-dashboard";
      } else {
        $("#responce_error").html(data);
      }
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});

$("#myaccount-form-sumbit").submit(function (e) {
  e.preventDefault();
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: $(this).serialize(),
    success: function (data) {
      $("#loadershowhide").hide();
      $("#rep_error").html(data);
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});

$("#register-from-submit").submit(function (e) {
  e.preventDefault();
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: $(this).serialize(),
    success: function (data) {
      $("#loadershowhide").hide();
      if (data == 1) {
        window.location.href = site_url + "/login";
      } else {
        $("#responce_error").html(data);
      }
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});

$(document).on("click", ".exampleModalEdit", function () {
  var tourid = $(this).data("tourid");
  $("#modal-content-edit").html(
    '<div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Edit</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
  );
  // var option = new Option(data.owner_list, data.id, true, true);
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { tourid: tourid, action: "tour_edit_ajax" },
    success: function (data) {
      $("#loadershowhide").hide();
      $("#modal-content-edit").html(data);
      setTimeout(function () {
        if ($("#owner_listnew").length) {
          $(document)
            .find("#owner_listnew")
            .select2({
              dropdownParent: $("#exampleModalEdit .modal-owner-listnew"),
              width: "100%",
              placeholder: "Select an Option",
              allowClear: true,
            });
        }
        if ($("#viewer_listnew").length) {
          $(document)
            .find("#viewer_listnew")
            .select2({
              dropdownParent: $("#exampleModalEdit .modal-viewer-listnew"),
              width: "100%",
              placeholder: "Select an Option",
              allowClear: true,
            });
        }
      }, 500);
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});

$(document).on("click", ".removevideojs", function () {
  if (confirm("Are you sure you want to delete this?")) {
    var id = $(this).data("group");
    $(".removevideogrp" + id).remove();
  }
});

$(document).on("submit", "#edti-tour-form-byowner", function (e) {
  e.preventDefault();

  var formData = new FormData(this);
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: formData,
    processData: false,
    cache: false,
    contentType: false,
    success: function (data) {
      $("#loadershowhide").hide();
      if (data == 1) {
        window.location.href = site_url + "/dashboard";
      } else {
        $("#responce_error").html(data);
      }
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});
$(document).on("click", function (e) {
  if ($(e.target).is(".dropdown-toggle") === false) {
    $(".dropdown").removeClass("show");
    $(".dropdown-menu").removeClass("show");
  }
});
$(document).on("click", ".dropdown", function () {
  $(this).addClass("show");
  $(".dropdown-menu").addClass("show");
});

$(document).on("click", ".senttoarchivetour", function () {
  var tourid = $(this).data("tourid");
  if (confirm("Are you sure you want to delete this?")) {
    $("#loadershowhide").show();
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: { tourid: tourid, action: "tour_sent_to_archive_ajax" },
      success: function (data) {
        $("#loadershowhide").hide();
        $(".tourblock" + tourid).remove();
      },
      error: function name(e) {
        $("#loadershowhide").hide();
      },
    });
  }
});

$(document).on("click", ".restoretourfromarchive", function () {
  var tourid = $(this).data("tourid");
  if (confirm("Are you sure you want to restore this?")) {
    $("#loadershowhide").show();
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: { tourid: tourid, action: "tour_sent_to_restore_ajax" },
      success: function (data) {
        $("#loadershowhide").hide();
        $(".tourblock" + tourid).remove();
      },
      error: function name(e) {
        $("#loadershowhide").hide();
      },
    });
  }
});

$(document).on("click", ".deletepermanently", function () {
  var tourid = $(this).data("tourid");
  if (confirm("Are you sure you want to delete this?")) {
    $("#loadershowhide").show();
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        tourid: tourid,
        action: "tour_sent_to_deletepermanently_ajax",
      },
      success: function (data) {
        $("#loadershowhide").hide();
        $(".tourblock" + tourid).remove();
      },
      error: function name(e) {
        $("#loadershowhide").hide();
      },
    });
  }
});

$(document).on("click", ".makeitlivetour", function () {
  var tourid = $(this).data("tourid");
  if (confirm("Are you sure you want to live this?")) {
    $("#loadershowhide").show();
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: { tourid: tourid, action: "tour_sent_to_live_ajax" },
      success: function (data) {
        $("#loadershowhide").hide();
        location.reload();
      },
      error: function name(e) {
        $("#loadershowhide").hide();
      },
    });
  }
});

$(document).on("click", ".makeitunlivetour", function () {
  var tourid = $(this).data("tourid");
  if (confirm("Are you sure you want to deactive this?")) {
    $("#loadershowhide").show();
    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: { tourid: tourid, action: "tour_sent_to_deactive_ajax" },
      success: function (data) {
        $("#loadershowhide").hide();
        location.reload();
      },
      error: function name(e) {
        $("#loadershowhide").hide();
      },
    });
  }
});

$(document).on("click", ".exampleModalaViewAnalitis", function () {
  var tourid = $(this).data("tourid");
  $("#loadershowhide").show();
  $("#exampleModalView .modal-body").html(
    '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>'
  );
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: { tourid: tourid, action: "tour_google_analytic" },
    success: function (data) {
      $("#loadershowhide").hide();
      if (data.indexOf("accounts.google.com") != -1) {
        window.location.replace(data);
        return false;
      }
      chartResult = $.parseJSON(data);
      console.log(chartResult);
      chartResultFun(chartResult, tourid);
      /* End here */
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});

function datefilterjaxcall(start, end, tourid) {
  console.log(start);
  console.log(end);
  console.log(tourid);
  $("#exampleModalView .modal-body").html(
    '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>'
  );
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: {
      start: start,
      end: end,
      tourid: tourid,
      action: "tour_google_analytic",
    },
    success: function (data) {
      $("#loadershowhide").hide();
      chartResult = $.parseJSON(data);
      console.log(chartResult);
      chartResultFun(chartResult, tourid);
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
}

function chartResultFun(chartResult, tourid) {
  Chart.plugins.register({
    afterDraw: (chart) => {
      if (chart.data.datasets[0].data.length === 0) {
        var ctx = chart.chart.ctx;
        ctx.save();
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.font = "18px Arial";
        ctx.fillStyle = "gray";
        ctx.fillText(
          "No data available",
          chart.chart.width / 2,
          chart.chart.height / 2
        );
        ctx.restore();
      }
    },
  });

  $("#exampleModalView .modal-body").html(
    '<div class="row"><div class="col-sm-8"></div><div class="col-sm-4"><div class="form-group"><input type="text" name="filter-start-from" class="form-control"  placeholder="Select Date"><small id="emailHelp" class="form-text text-muted"></small></div></div></div><div class="row"> <div class="col-sm-6"> <h6 class="mb-2">Total View Count</h6> <canvas id="myChartTwo"></canvas> </div> <div class="col-sm-6"> <h6 class="mb-2">Visit trends by medium</h6> <canvas id="myChart"></canvas> </div> <div class="col-sm-4 pt-3"> <h6 class="mb-2">Users by Session default channel group</h6> <canvas id="myChartThree"></canvas> </div> <div class="col-sm-4 pt-3"> <h6 class="mb-2">Unique visitors</h6> <canvas id="myChartFour"></canvas> </div> <div class="col-sm-4 pt-3"> <h6 class="mb-2">New VS Returning<h6> <canvas id="myChartFive"></canvas> </div><div class="col-sm-4 pt-3"> <h6 class="mb-2">Trafic by Source</h6> <canvas id="myChartSix"></canvas> </div><div class="col-sm-4 pt-3"> <h6 class="mb-2">Trafic by Medium</h6> <canvas id="myChartSeven"></canvas> </div><div class="col-sm-4 pt-3"> <h6 class="mb-2">Trafic by Campaign Name</h6> <canvas id="myChartEight"></canvas> </div> </div>'
  );

  setTimeout(function () {
    $('input[name="filter-start-from"]').daterangepicker(
      {
        opens: "left",
        autoApply: true,
        alwaysShowCalendars: true,
        startDate: chartResult.startDate,
        endDate: chartResult.endDate,
        ranges: {
          Today: [moment(), moment()],
          Yesterday: [
            moment().subtract(1, "days"),
            moment().subtract(1, "days"),
          ],
          "Last 7 Days": [moment().subtract(6, "days"), moment()],
          "Last 30 Days": [moment().subtract(29, "days"), moment()],
          "This Month": [moment().startOf("month"), moment().endOf("month")],
          "Last Month": [
            moment().subtract(1, "month").startOf("month"),
            moment().subtract(1, "month").endOf("month"),
          ],
          "This Year": [moment().startOf("year"), moment().endOf("year")],
          "Last Year": [
            moment().subtract(1, "year").startOf("year"),
            moment().subtract(1, "year").endOf("year"),
          ],
        },
      },
      function (start, end, label) {
        datefilterjaxcall(
          start.format("YYYY-MM-DD"),
          end.format("YYYY-MM-DD"),
          tourid
        );
        // console.log(
        //   "A new date selection was made: " +
        //     start.format("YYYY-MM-DD") +
        //     " to " +
        //     end.format("YYYY-MM-DD")
        // );
      }
    );
  }, 500);

  var barColors = ["red", "green", "blue", "orange", "brown", "brown"];

  var chartOptions = {
    responsive: true,
    legend: {
      position: "top",
    },
    title: {
      display: false,
      text: "Chart.js Bar Chart",
    },
    scales: {
      yAxes: [
        {
          ticks: {
            beginAtZero: true,
          },
        },
      ],
    },
  };

  var barChartData = {
    labels: [
      "Total Users",
      "New Users",
      "Sessions",
      "Average Session Duration",
      "Screen Page Views",
    ],
    datasets: [
      {
        label: "Last Year",
        backgroundColor: "#b91d47",
        borderColor: "#b91d47",
        borderWidth: 1,
        data: [
          chartResult.resultDate.totalUsers[0],
          chartResult.resultDate.newUsers[0],
          chartResult.resultDate.sessions[0],
          chartResult.resultDate.averageSessionDuration[0],
          chartResult.resultDate.screenPageViews[0],
        ],
      },
      {
        label: "This Year",
        backgroundColor: "green",
        borderColor: "green",
        borderWidth: 1,
        data: [
          chartResult.resultDate.totalUsers[1],
          chartResult.resultDate.newUsers[1],
          chartResult.resultDate.sessions[1],
          chartResult.resultDate.averageSessionDuration[1],
          chartResult.resultDate.screenPageViews[1],
        ],
      },
    ],
  };

  const ctx = document.getElementById("myChart");
  new Chart(ctx, {
    type: "bar",
    data: barChartData,
    options: chartOptions,
  });

  var yValues = [];
  var xValues = [];
  $.each(chartResult.screenPageViews, function (index, value) {
    xValues.push(index.replace("m_", ""));
    yValues.push(value);
  });
  console.log(yValues);
  new Chart("myChartTwo", {
    type: "line",
    data: {
      labels: xValues,
      datasets: [
        {
          fill: true,
          lineTension: 0,
          backgroundColor: "rgba(26,115,232,0.5)",
          borderColor: "rgba(26,115,232,0.1)",
          data: yValues,
        },
      ],
    },
    options: {
      legend: { display: false },
      scales: {
        //yAxes: [{ ticks: { min: 6, max: 25 } }],
      },
    },
  });

  var yValues = [];
  var xValues = [];
  $.each(chartResult.CampainDefultsSource, function (index, value) {
    xValues.push(index);
    yValues.push(value);
  });
  const ctx2 = document.getElementById("myChartThree");
  new Chart(ctx2, {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [
        {
          label: "Traffic by Source",
          data: yValues,
          backgroundColor: [
            "rgba(255, 99, 132, 1)",
            "rgba(255, 159, 64, 1)",
            "rgba(255, 205, 86, 1)",
            "rgba(75, 192, 192, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(153, 102, 255, 1)",
          ],
          borderColor: [
            "rgb(255, 99, 132)",
            "rgb(255, 159, 64)",
            "rgb(255, 205, 86)",
            "rgb(75, 192, 192)",
            "rgb(54, 162, 235)",
            "rgb(153, 102, 255)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      legend: { display: false },
      scales: {
        y: {
          beginAtZero: false,
        },
      },
    },
  });

  var xValues = ["New", "Returning"];
  var yValues = [
    chartResult.resultDateUR.new,
    chartResult.resultDateUR.returning,
  ];
  var barColors = ["#b91d47", "#00aba9"];

  new Chart("myChartFive", {
    type: "pie",
    data: {
      labels: xValues,
      datasets: [
        {
          backgroundColor: barColors,
          data: yValues,
        },
      ],
    },
    options: {
      title: {
        display: false,
        text: "World Wide Wine Production 2018",
      },
    },
  });

  var yValues = [];
  var xValues = [];
  $.each(chartResult.totalUsers, function (index, value) {
    xValues.push(index.replace("m_", ""));
    yValues.push(value);
  });

  const ctx4 = document.getElementById("myChartFour");
  new Chart(ctx4, {
    type: "line",
    data: {
      labels: xValues,
      datasets: [
        {
          fill: true,
          lineTension: 0,
          backgroundColor: "rgba(26,115,232,0.5)",
          borderColor: "rgba(26,115,232,0.1)",
          data: yValues,
        },
      ],
    },
    options: {
      legend: { display: false },
      scales: {
        // yAxes: [{ ticks: { min: 6, max: 16 } }],
      },
    },
  });

  //myChartSix
  var yValues = [];
  var xValues = [];
  $.each(chartResult.CampainSource, function (index, value) {
    xValues.push(index);
    yValues.push(value);
  });
  const ctx6 = document.getElementById("myChartSix");
  new Chart(ctx6, {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [
        {
          label: "Trafic by Source",
          data: yValues,
          backgroundColor: [
            "rgba(255, 159, 64, 1)",
            "rgba(255, 99, 132, 1)",
            "rgba(255, 205, 86, 1)",
            "rgba(75, 192, 192, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(153, 102, 255, 1)",
          ],
          borderColor: [
            "rgb(255, 159, 64)",
            "rgb(255, 99, 132)",
            "rgb(255, 205, 86)",
            "rgb(75, 192, 192)",
            "rgb(54, 162, 235)",
            "rgb(153, 102, 255)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      legend: { display: false },
      scales: {
        y: {
          beginAtZero: false,
        },
      },
    },
  });

  //myChartSeven
  var yValues = [];
  var xValues = [];
  $.each(chartResult.CampainMedium, function (index, value) {
    xValues.push(index);
    yValues.push(value);
  });
  const ctx7 = document.getElementById("myChartSeven");
  new Chart(ctx7, {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [
        {
          label: "Trafic by Medium",
          data: yValues,
          backgroundColor: [
            "rgba(255, 205, 86, 1)",
            "rgba(255, 99, 132, 1)",
            "rgba(255, 159, 64, 1)",
            "rgba(75, 192, 192, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(153, 102, 255, 1)",
          ],
          borderColor: [
            "rgb(255, 205, 86)",
            "rgb(255, 99, 132)",
            "rgb(255, 159, 64)",
            "rgb(75, 192, 192)",
            "rgb(54, 162, 235)",
            "rgb(153, 102, 255)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      legend: { display: false },
      scales: {
        y: {
          beginAtZero: false,
        },
      },
    },
  });

  //myChartEight
  var yValues = [];
  var xValues = [];
  $.each(chartResult.CampainName, function (index, value) {
    xValues.push(index);
    yValues.push(value);
  });
  const ctx8 = document.getElementById("myChartEight");
  new Chart(ctx8, {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [
        {
          label: "Trafic by Campaign Name",
          data: yValues,
          backgroundColor: [
            "rgba(75, 192, 192, 1)",
            "rgba(255, 99, 132, 1)",
            "rgba(255, 159, 64, 1)",
            "rgba(255, 205, 86, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(153, 102, 255, 1)",
          ],
          borderColor: [
            "rgb(75, 192, 192)",
            "rgb(255, 99, 132)",
            "rgb(255, 159, 64)",
            "rgb(255, 205, 86)",
            "rgb(54, 162, 235)",
            "rgb(153, 102, 255)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      legend: { display: false },
      scales: {
        y: {
          beginAtZero: false,
        },
      },
    },
  });
}

$(document).on("change", "input[name='tour_type']", function () {
  var tour_type = $(this).val();
  if (tour_type == 1) {
    $(".singletour").slideDown();
    $("#form6Example13").prop("required", true);
    $("#form6Example11").prop("required", false);
    $("#form6Example12").prop("required", false);

    $(".multitour").slideUp();
  } else {
    $(".singletour").slideUp();
    $("#form6Example13").prop("required", false);
    $("#form6Example11").prop("required", true);
    $("#form6Example12").prop("required", true);
    $(".multitour").slideDown();
  }
});

$(document).on("click", ".custom-add-tags", function () {
  $(".addnewtopurresponse").append(
    '<div class="row mb-4 cust-remove"><div class="col"> <div class="form-outline"> <label class="form-label font-weight-bold" for="form6Example11">Tour Name</label> <input type="text" id="form6Example11" class="form-control" name= tour_names[]" required="" value=""> </div> </div><div class="col"> <div class="form-outline position-relative"> <label class="form-label font-weight-bold" for="form6Example12">Tour Tag line</label> <input type="text" id="form6Example12" class="form-control" name="tour_tag_line[]" required="" value=""> <div class="row1 mb-4 removetourstagbtn"><button type="button" class="btn btn-danger cust-remove-raw">-</button></div></div> </div></div>'
  );
});

$(document).on("click", ".cust-remove-raw", function () {
  $(this).closest(".cust-remove").remove();
});

$(document).ready(function () {
  var checkboxes = $(".checkboxes");
  checkboxes.change(function () {
    if ($(".checkboxes:checked").length > 0) {
      checkboxes.removeAttr("required");
    } else {
      checkboxes.attr("required", "required");
    }
  });
});

// $(document).on("submit", "#tour-form-sumbit", function (e) {
//   e.preventDefault();
//   var formData = new FormData("#tour-form-sumbit");
//   $.ajax({
//     type: "POST",
//     url: ajaxurl,
//     data: formData,
//     processData: false,
//     cache: false,
//     contentType: false,
//     success: function (data) {
//       $("#rep_error").html(data);
//     },
//   });
// });

$(document).on("submit", "#tour-form-sumbit", function (e) {
  e.preventDefault();

  var formData = new FormData(this);
  $("#loadershowhide").show();
  $.ajax({
    type: "POST",
    url: ajaxurl,
    data: formData,
    processData: false,
    cache: false,
    contentType: false,
    success: function (data) {
      $("#loadershowhide").hide();
      window.location.href = site_url + "/admin-dashboard";
    },
    error: function name(e) {
      $("#loadershowhide").hide();
    },
  });
});

if ($("#owner_list").length) {
  $("#owner_list").select2({
    width: "100%",
    placeholder: "Select an Option",
    allowClear: true,
  });
}

if ($("#viewer_list").length) {
  $("#viewer_list").select2({
    width: "100%",
    placeholder: "Select an Option",
    allowClear: true,
  });
}

 jQuery("#contactform").on("submit", function(e){
 alert("s");
   return false;
 });