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

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("form-submit")
    .addEventListener("submit", submitPatientForm);
});

function submitPatientForm(natureInjuryData, externalInjury) {
  event.preventDefault();
  let patientType = $("input[name='typePatient']:checked").val();
  let injury_intent = $("input[name='injury_intent']:checked").val();
  let multiInjury = $("input[name='multiple_injured']:checked").val();
  let firstAidGive = $("input[name='firstAidGive']:checked").val();
  let fractype = $("input[name='fracttype']:checked").val();

  let ex_burntype = $("input[name='burn_type']:checked").val();
  let ex_drowning = $("input[name='drowningType']:checked").val();

  let transVehic = $("input[name='transport_vehic']:checked").val();
  let patientvehicle = $("input[name='Patient_vehicle']:checked").val();
  let positionPatient = $("input[name='position_patient']:checked").val();
  let placeOccurrence = $("input[name='Occurrence']:checked").val();
  let activitypatient = $("input[name='activity_patient']:checked").val();
  let risk_factors = $("input[name='risk_factors']:checked").val();

  let safeotherDetails = $("#safeothers_details").val();
  let statusReashing = $("input[name='reashingFact']:checked").val();

  let hospitalData = $("input[name='hospital_data']:checked").val();
  let modetransports = $("input[name='mode_transport']:checked").val();

  let dispositions = $("input[name='disposition']:checked").val();
  let dispositions1 = $("input[name='disposition1']:checked").val();
  let outcome = $("input[name='outcome']:checked").val();
  let outcome1 = $("input[name='Outcome1']:checked").val();
  let patientsafe = $("input[name='safe[]']:checked")
    .map(function () {
      return $(this).val();
    })
    .get();

  if (safeotherDetails) {
    patientsafe.push(safeotherDetails);
  }

  // Collect nature of injury details
  let natureInjury = [];

  let exInjured = [];

  if ($("#ex_burn").is(":checked")) {
    exInjured.push({
      type: "Burns",
      burntype: ex_burntype,
      details: $("#exburnDetails").val(),
    });
  }

  if ($("#exDrowning").is(":checked")) {
    exInjured.push({
      type: "Drowning",
      drowningType: ex_drowning,
      details: $("#exdrowningDetails").val(),
    });
  }
  if ($("#Transport").is(":checked")) {
    exInjured.push({
      id: "12",
      type: "TransPort",
      details: $("#Transport_details").val(),
      transportVehicle: {
        Id: "16",
        transport_id: "12",
        TransportVehicular: transVehic,
        VehiclesInvolved: {
          transportVehicle_id: "16",
          PatientsVehicle: patientvehicle,
          patienPosition: positionPatient,
          placeOccurrence: placeOccurrence,
          PatientActivity: activitypatient,
          riskfactor: risk_factors,
          safepatient: patientsafe,
        },
      },
    });
  }
  externalInjury.forEach((external, index) => {
    if ($(`#external${index}`).is(":checked")) {
      exInjured.push({
        id: external.id,
        type: external.name,
        details: $(`#external_details${index}`).val(),
      });
    }
  });

  natureInjuryData.forEach((injured, index) => {
    // Burn details
    if (injured.name == "Burn" || injured.name == "burn") {
      if ($("#InjuredBurn").is(":checked")) {
        natureInjury.push({
          type: injured.name,
          degree:
            $("input[name='Degree1']:checked").val() ||
            $("input[name='Degree2']:checked").val() ||
            $("input[name='Degree3']:checked").val() ||
            $("input[name='Degree4']:checked").val(),
          details: $("#burnDetail").val(),
          side: $("#burnside").val(),
          bodyParts: $("#burn_body_parts").val(),
        });
      }
    } else if (injured.name == "Fracture" || injured.name == "fracture") {
      if ($("#fractureNature").is(":checked")) {
        // Fracture details
        let fractureDetails = {
          type: injured.name,
          fracstype: fractype,
          closeTypeDetails: $("#fracture_close_detail").val(),
          openTypeDetails: $("#fracture_open_detail").val(),
          closeTypeSide: $("#closetype_side").val(),
          openTypeSide: $("#opentype_side").val(),
          closeTypeBodyParts: $("#burnclose_bodyparts").val(),
          openTypeBodyParts: $("#burnOpen_bodyparts").val(),
        };
        natureInjury.push(fractureDetails);
      }
    } else if (
      injured.name == "others" ||
      injured.name == "other" ||
      injured.name == "Other" ||
      injured.name == "Others"
    ) {
      if ($("#Others_nature_injured").is(":checked")) {
        natureInjury.push({
          type: injured.name,
          details: $("#other_nature_datails").val(),
          side: $("#side_others").val(),
          bodyParts: $("#body_parts_others").val(),
        });
      }
    } else {
      if ($(`#nature${index}`).is(":checked")) {
        natureInjury.push({
          type: injured.name,
          details: $(`#nature_details${index}`).val(),
          sideInjury: $(`#sideInjured${index}`).val(),
          bodyPartInjury: $(`#body_parts_injured${index}`).val(),
        });
      }
    }
  });

  const formData = {
    Reportingfacility: {
      id: $("#facility_id").val(),
      facilityname: $("#facility").val(),
      typedru: $("#typedru").val(),
      addressfacility: $("#addressfacility").val(),
    },
    typePatient: patientType,
    PatientData: {
      id: $("#patient_id").val(),
      facility_id: $("#facility_id").val(),
      hospital_no: $("#hospital_no").val(),
      lname: $("#lname").val(),
      fname: $("#fname").val(),
      mname: $("#mname").val(),
      sex: $("#sex").val(),
      dateBirth: $("#dateofbirth").val(),
      age: $("#age").val(),
      province: $("#province").val(),
      municipal: $("#municipal").val(),
      barangay: $("#barangay").val(),
      phil_no: $("#phil_no").val(),
    },
    PreAdmissionData: {
      patient_id: $("#patient_id").val(),
      POIProvince: $("#provinceId").val(),
      POImuncity: $("#municipal_injury").val(),
      POIbarangay: $("#barangay_injury").val(),
      POIPurok: $("#purok_injury").val(),
      dateInjury: $("#date_injury").val(),
      timeInjury: $("#time_injury").val(),
      date_consult: $("#date_consultation").val(),
      time_consult: $("#time_consultation").val(),
      injury_intent: injury_intent,
      first_Aid: firstAidGive,
      what: $("#druWhat").val(),
      bywhom: $("#druByWhom").val(),
      multipleInjury: multiInjury,
      natureInjury: natureInjury,
      externalInjury: exInjured,
    },
    HospitalData: {
      id: "1",
      patient_id: $("#patient_id").val(),
      hospitaldata: hospitalData,
    },
    HospitalA: {
      id: "1",
      HospitalData_id: "1",
      hospitaldata: "A. ER/OPD/BHS/RHU", //hospitalData
      transferredFacility: $("#YesTransferred").val(),
      referredFacility: $("#NoTransferred").val(),
      namePhysician: $("name_orig").val(),
      statusReasingFact: statusReashing,
      modetransPort: modetransports,
      modeTransferOthers: $("#mode_others_details").val(),
      initialInpresion: $("#Initial_Impression").val(),
      icd10nature: $("#icd10_nature").val(),
      icd10external: $("#icd10_external").val(),
      Disposition: dispositions,
      disposition_Others: $("#trans_facility_hos_details").val(),
      outcome: outcome,
    },
    HospitalB: {
      id: "1",
      HospitalData_id: "2",
      hospitaldata: "B. In-Patient(for admitted hospital cases only)", //hospitalData
      completeDiagnose: $("#complete_final").val(),
      Disposition1: dispositions1,
      transfacility_details: $("#trans_facility_hos_details2").val(),
      outcome: outcome1,
      Icd10nature: $("#icd10_nature1").val(),
      icd10External: $("#icd10_external1").val(),
    },
  };

  const jsonDisplayElement = document.getElementById("json-display");
  if (jsonDisplayElement) {
    jsonDisplayElement.textContent = JSON.stringify(formData, null, 2);
  } else {
    console.error("Element with ID 'json-display' not found.");
  }
  console.log("formData", formData.PreAdmissionData);
  // Log the JSON object to the console for debugging purposes
  // console.log(JSON.stringify(formData));

  // $.ajax({
  //   url: "/submit-patient-form",
  //   method: "POST",
  //   headers: {
  //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  //   },
  //   contentType: "application/json",
  //   data: JSON.stringify(formData),
  //   success: function (response) {
  //     console.log(response);
  //   },
  //   error: function (xhr, status, error) {
  //     console.error("Error submitting form:", error);
  //   },
  // });
}

//first aid given
$(document).ready(function () {
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
});
