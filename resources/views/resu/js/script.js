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
  function firstAidfields() {
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
  }

  firstAidfields();

  $("#firstAidYes, #firstAidNo").change(function () {
    console.log("it works");
    firstAidfields();
  });

  if ($("#Transport").is(":checked")) {
    $(".Transport-group").show();
  } else {
    $(".Transport-group").hide();
    $('.Transport-group input[type="checkbox"]').prop("checked", false);
    $('.Transport-group input[type="text"]').val("");
  }

  $("#Transport").change(function () {
    if ($(this).is(":checked")) {
      $(".Transport-group").show();

      Lobibox.alert("info", {
        msg: "Transport/Vehicular Accident is checked. Please fill up the other fields in the <strong>Next option!</strong>",
        buttons: {
          ok: {
            class: "btn btn-info",
            text: "OK",
            closeOnClick: true,
          },
        },
        modal: true,
        centered: true,
      });
    } else {
      $(".Transport-group").hide();
      $('.Transport-group input[type="checkbox"]').prop("checked", false);
      $('.Transport-group input[type="text"]').val("");
    }
  });

  if ($("#Collision").is(":checked")) {
    $(".collision_group").show();
  } else {
    $(".collision_group").hide();
  }

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
  function MunicipalData(provinceId, muncity, muncity_id = null) {
    $(muncity).empty().append('<option value="">Select Municipal</option>'); // Reset municipal dropdown
    console.log("update province Id", provinceId);
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
            if (muncity_id) {
              $(muncity).val(muncity_id);
              $(muncity).trigger("chosen:updated");
              console.log("chosen", $(muncity).trigger("chosen:updated"));
            } else {
              $(muncity).trigger("chosen:updated");
              console.log("chosen", $(muncity).trigger("chosen:updated"));
            }
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
  function BarangayData(muncityId, barangay, barangay_id = null) {
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
        if (barangay_id) {
          $(barangay).val(barangay_id);
          $(barangay).trigger("chosen:updated");
        } else {
          $(barangay).trigger("chosen:updated");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(JSON.stringify(jqXHR));
        console.log("AJAX error: " + textStatus + " : " + errorThrown);
      },
    });
  }

  //this is upate portion permanent Address
  var provinceId = $("#update-province").val();
  var municipalId = $("#update-municipal").data("selected");
  var barangayId = $("#update-barangay").data("selected");
  if (provinceId) {
    $("#update-province").change(function () {
      var provinceId = $(this).val();
      MunicipalData(provinceId, "#update-municipal");
    });
    MunicipalData(provinceId, "#update-municipal", municipalId);
  }

  if (municipalId) {
    $("#update-municipal").change(function () {
      var muncityId = $(this).val();
      BarangayData(muncityId, "#update-barangay");
    });
    BarangayData(municipalId, "#update-barangay", barangayId);
  }
  // end of update portion

  //Address place injury
  var placeprovinceId = $("#update_provinceId").val();
  var placemunicipalId = $("#update_municipal_injury").data("selected");
  var placebarangayId = $("#update_barangay_injury").data("selected");

  if (placeprovinceId) {
    $("#update_provinceId").change(function () {
      var PprovinceId = $(this).val();
      MunicipalData(PprovinceId, "#update_municipal_injury");
    });
    MunicipalData(
      placeprovinceId,
      "#update_municipal_injury",
      placemunicipalId
    );
  }

  if (placemunicipalId) {
    $("#update_municipal_injury").change(function () {
      var pmuncity_id = $(this).val();
      console.log("pmunicity", pmuncity_id);
      BarangayData(pmuncity_id, "#update_barangay_injury");
    });
    BarangayData(placemunicipalId, "#update_barangay_injury", placebarangayId);
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
