function showNextStep() {
  var currentStep = document.querySelector(
    '.form-step:not([style*="display: none"])'
  );
  var nextStep = currentStep.nextElementSibling;

  if (nextStep) {
    currentStep.style.display = "none";
    nextStep.style.display = "block";
  }
}

function showPreviousStep() {
  var currentStep = document.querySelector(
    '.form-step:not([style*="display: none"])'
  );
  var previousStep = currentStep.previousElementSibling;

  if (previousStep) {
    currentStep.style.display = "none";
    previousStep.style.display = "block";
  }
}

//first aid given
$(document).ready(function () {
  $("#checkProfile").modal({
    backdrop: "static",
    keyboard: false,
  });

  var checkmodal = $("#checkProfile").modal("show");
  console.log("modal", checkmodal);

  $("#firstAidYes, #firstAidNo").change(function () {
    console.log("it works");
    if ($("#firstAidYes").is(":checked")) {
      $("#druWhat").show();
      $("#druByWhom").show();
      $("#firstAidNo").prop("checked", false);
    } else {
      $("#druWhat").hide();
      $("#druByWhom").hide();
    }

    if ($("#firstAidNo").is(":checked")) {
      $("#firstAidYes").prop("checked", false);
    }
  });
  //for Transport hide condition
  $("#Transport").change(function () {
    console.log("works");
    $(".Transport-group").hide();

    if ($(this).is(":checked")) {
      $(".Transport-group").show();
    } else {
      $(".Transport-group").hide();
      $('.Transport-group input[type="checkbox"]').prop("checked", false);
      $('.Transport-group input[type="text"]').val("");
    }
  });

  $("#Collision").change(function () {
    console.log("works");
    $(".collision_group").hide();

    if ($(this).is(":checked")) {
      $(".collision_group").show();
    } else {
      $(".collision_group").hide();
    }
  });
  // for option hide of  A. ER/OPD/BHS/RHU or  B. In-Patient(for admitted hospital cases only)
  $("#A_ErOpd").change(function () {
    if ($(this).is(":checked")) {
      $(".B_InpatientGroup").hide();
    } else {
      $(".B_InpatientGroup").show();
    }
  });

  $("#B_InPatient").change(function () {
    if ($(this).is(":checked")) {
      $(".A_ErOpdGroup").hide();
      $(".Inpatient_linehr").hide();
    } else {
      $(".A_EropdGroup").show();
      $(".Inpatient_linehr").show();
    }
  });

  $("#facility").change(function () {
    var facilityId = $(this).val();
    var selectedfacility = $(this).find("option:selected");
    var address = selectedfacility.data("address");
    var hospital_type = selectedfacility.data("hospital_type");
    console.log("address", hospital_type);
    $("#typedru").val(hospital_type);
    $("#addressfacility").val(address);
  });

  //display municipal
  function MunicipalData(provinceId, muncity) {
    $(muncity).empty().append('<option value="">Select Municipal</option>'); // Reset municipal dropdown

    if (provinceId) {
      $.ajax({
        url: "get/municipal/" + provinceId,
        type: "GET",
        dataType: "json",
        success: function (data) {
          if (data && data.length > 0) {
            $.each(data, function (key, value) {
              if (value.id && value.description) {
                $(muncity).append(
                  '<option value="' +
                    value.id +
                    '">' +
                    value.description +
                    "</option>"
                );
              }
            });
            $(muncity).trigger("chosen:updated");
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + " : " + errorThrown);
        },
      });
    }
  }
  //display municipal city
  $("#province").change(function () {
    var provinceId = $(this).val();
    MunicipalData(provinceId, "#municipal");
  });

  $("#provinceId").change(function () {
    var provinceId = $(this).val();
    MunicipalData(provinceId, "#municipal_injury");
  });

  // display Barangay
  function BarangayData(muncityId, barangay) {
    $(barangay).empty().append("<option>Select Barangay</option>");

    $.ajax({
      url: "get/barangay/" + muncityId,
      type: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data, function (key, value) {
          $(barangay).append(
            '<option value="' +
              value.id +
              '">' +
              value.description +
              "</option>"
          );
        });
        $(barangay).trigger("chosen:updated");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(JSON.stringify(jqXHR));
        console.log("AJAX error: " + textStatus + " : " + errorThrown);
      },
    });
  }

  $("#municipal").change(function () {
    var muncityId = $(this).val();

    BarangayData(muncityId, "#barangay");
  });

  $("#municipal_injury").change(function () {
    var muncityId = $(this).val();
    BarangayData(muncityId, "#barangay_injury");
  });

  //display age base the birth date
  function calculateAge(dateOfBirth) {
    const today = new Date();
    const birthDate = new Date(dateOfBirth);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    // If the birth month is in future compared to current month
    if (
      monthDiff < 0 ||
      (monthDiff === 0 && today.getDate() < birthDate.getDate())
    ) {
      age--;
    }

    return age;
  }

  $("#dateofbirth").on("change", function () {
    const dob = $(this).val();
    const ageField = $("#age");

    if (dob) {
      const age = calculateAge(dob);
      ageField.val(age);
    } else {
      ageField.val("");
    }
  });
});
