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

$(document).on("click", ".update-btn", function () {
  var profileId = $(this).data("id");
  $("#profile_id").val(profileId); // Set the profile_id in the hidden input
  $("#form-submit").submit(); // Submit the form
});

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

  //for transport
  var transport = $("#Transport");
  var detailsTrans = $("#Transport_details");

  transport.change(function () {
    detailsTrans.prop("disabled", !this.checked);

    if (!this.checked) {
      detailsTrans.prop("disabled", true).val("");
    }
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

  // function toggleCollision() {
  //   if ($("#Collision").is(":checked")) {
  //     $(".collision_group").show();
  //   } else if ($("#non_collision").is(":checked")) {
  //     $(".collision_group").hide();
  //   } else {
  //     $(".collision_group").hide();
  //   }
  // }

  // $("input[name='transport_collision']").on("change", toggleCollision);
  // toggleCollision();

  $("#Collision").change(function () {
    console.log("works");
    $(".collision_group").hide();

    if ($(this).is(":checked")) {
      $(".collision_group").show();
    } else {
      $(".collision_group").hide();
    }
  });

  $("#non_collision").change(function () {
    console.log("works");

    if ($(this).is(":checked")) {
      $(".collision_group").hide();
    }
  });

  // for option hide of  A. ER/OPD/BHS/RHU or  B. In-Patient(for admitted hospital cases only)

  function toggleInPatientContent() {
    if ($("#B_InPatient").is(":checked")) {
      $(".A_ErOpdGroup").hide();
      $(".Inpatient_linehr").hide();
      $(".hrA_ErOpdGroup").hide();
      $(".In_patient_content").show();
    } else {
      $(".A_EropdGroup").show();
      $(".Inpatient_linehr").show();
      $(".In_patient_content").hide();
    }
  }

  toggleInPatientContent();
  $("#B_InPatient").on("change", function () {
    toggleInPatientContent();
  });

  function toggleEROpd() {
    if ($("#A_ErOpd").is(":checked")) {
      $(".B_InpatientGroup").hide();
      $(".ER_Content").show();
    } else {
      $(".B_InpatientGroup").show();
      $(".ER_Content").hide();
    }
  }

  toggleEROpd();

  $("#A_ErOpd").on("change", function () {
    toggleEROpd();
  });

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

    $("#typedru").val(hospital_type);
    $("#addressfacility").val(address);
  });

  //display municipal

  function MunicipalData(provinceId, muncity, muncity_id = null) {
    $(muncity)
      .empty()
      .append('<option value="0" selected>Select Municipal</option>'); // Reset municipal dropdown
    // console.log("update province Id", provinceId);
    if (provinceId) {
      $.ajax({
        url: "get/municipal/" + provinceId,
        type: "GET",
        dataType: "json",
        success: function (data) {
          console.log("data province", provinceId);
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
            }
          }
          //this is HUC muncities not provinceId
          if (provinceId == 63 || provinceId == 76 || provinceId == 80) {
            var muncities = JSON.parse(
              document.getElementById("muncities-data").value
            );
            muncities.forEach(function (mun) {
              if (mun.id == provinceId) {
                $(muncity).append(
                  '<option value="' +
                    mun.id +
                    '" >' +
                    mun.description +
                    "</option>"
                );
              }
            });

            if (provinceId) {
              $(muncity).val(provinceId);
              $(muncity).trigger("chosen:updated");
            } else {
              $(muncity).trigger("chosen:updated");
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

  // display Barangay
  function BarangayData(muncityId, barangay, barangay_id = null) {
    $(barangay).empty().append("<option>Select Barangay</option>");
    console.log("muncity id: ", muncityId);
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

  //display municipal city
  $("#province").change(function () {
    var provinceId = $(this).val();

    MunicipalData(provinceId, "#municipal");
  });

  $("#provinceId").change(function () {
    var provinceId = $(this).val();
    MunicipalData(provinceId, "#municipal_injury");
  });

  $("#municipal").change(function () {
    var muncityId = $(this).val();
    console.log("barangay muncity id:", muncityId);
    BarangayData(muncityId, "#barangay");
  });

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
    if (barangayId !== null && barangayId !== undefined) {
      BarangayData(municipalId, "#update-barangay", barangayId);
    }
  }
  // end of update portion
  console.log("Document ready!");

  if ($("#update_provinceId").length) {
    console.log("Element #update_provinceId is present.");
  } else {
    console.error("Element #update_provinceId is not found!");
  }

  //Address place injury
  var placeprovinceId = $("#update_provinceId").val();
  var placemunicipalId = $("#update_municipal_injury").data("selected");
  var placebarangayId = $("#update_barangay_injury").data("selected");

  if (placeprovinceId) {
    $("#update_provinceId").change(function () {
      var PprovinceId = $(this).val();
      console.log("place province injury", PprovinceId);
      MunicipalData(PprovinceId, "#update_municipal_injury");
    });

    MunicipalData(
      placeprovinceId,
      "#update_municipal_injury",
      placemunicipalId
    );
  } else {
    console.error("placeprovinceId is not set!");
  }

  if (placemunicipalId !== null && placemunicipalId !== undefined) {
    $("#update_municipal_injury").change(function () {
      var pmuncity_id = $(this).val();
      console.log("place injuruy municity Id", pmuncity_id);
      BarangayData(pmuncity_id, "#update_barangay_injury");
    });

    BarangayData(placemunicipalId, "#update_barangay_injury", placebarangayId);
  } else {
    console.error("placemunicipalId is not set!");
  }

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

  // for enabled and disabled Nature Injury for adding patient
  var BurnCheckbox = $("#InjuredBurn");

  var degree1 = $("#Degree1");
  var degree2 = $("#Degree2");
  var degree3 = $("#Degree3");
  var degree4 = $("#Degree4");

  var burnDetails = $("#burnDetail");

  var burnSide = $("#burnside");
  var burnBodyParts = $("#burnbody_parts");

  burnDetails.prop("disabled", true);
  burnSide.prop("disabled", true);
  burnBodyParts.prop("disabled", true);

  BurnCheckbox.change(function () {
    burnDetails.prop("disabled", !this.checked);

    if (!this.checked) {
      burnDetails.prop("disabled", true).val("");
      burnBodyParts.prop("disabled", true).val("").trigger("chosen:updated");
      degree1.prop("disabled", true).removeAttr("checked");
      degree2.prop("disabled", true).removeAttr("checked");
      degree3.prop("disabled", true).removeAttr("checked");
      degree4.prop("disabled", true).removeAttr("checked");
    }
  });

  burnDetails.on("input", function () {
    // burnSide.prop("disabled", $(this).val().trim() === "");
    var hasValue = $(this).val() !== "";
    burnBodyParts.prop("disabled", !hasValue).trigger("chosen:updated");
  });

  burnBodyParts.change(function () {
    // burnDetails.prop("disabled", !this.checked);
    if ($(this).val().length > 0) {
      degree1.prop("disabled", false);
      degree2.prop("disabled", false);
      degree3.prop("disabled", false);
      degree4.prop("disabled", false);
    }
  });

  // for fracture
  var fractureCheck = $("#fractureNature");

  var closetype = $("#closetype");
  var opentype = $("#opentype");

  var fractureCloseDetails = $("#fracture_close_detail");
  var fractureOpenDetails = $("#fracture_open_detail");

  var closetypeside = $("#closetype_side");
  var opentypeside = $("#opentype_side");

  var fractureclosebody = $("#fractureclose_bodyparts");
  var fractureopenbody = $("#fracture_Open_bodyparts");

  fractureCheck.change(function () {
    closetype.prop("disabled", !this.checked);
    opentype.prop("disabled", !this.checked);
    if (!this.checked) {
      fractureCloseDetails.prop("disabled", true).val("");
      fractureOpenDetails.prop("disabled", true).val("");
      closetypeside.prop("disabled", true).val("");
      opentypeside.prop("disabled", true).val("");
      fractureopenbody.prop("disabled", true).val("").trigger("chosen:updated");
      fractureclosebody
        .prop("disabled", true)
        .val("")
        .trigger("chosen:updated");
      closetype.removeAttr("checked");
      opentype.removeAttr("checked");
    }
  });

  closetype.add(opentype).change(function () {
    fractureCloseDetails.prop("disabled", !this.checked);
    fractureOpenDetails.prop("disabled", !this.checked);
  });

  fractureCloseDetails.add(fractureOpenDetails).on("input", function () {
    var hasValue = $(this).val() !== "";
    fractureopenbody.prop("disabled", !hasValue).trigger("chosen:updated");
    fractureclosebody.prop("disabled", !hasValue).trigger("chosen:updated");
  });

  // closetypeside.add(opentypeside).change(function () {
  //   var hasValue = $(this).val() !== "";

  //   fractureopenbody.prop("disabled", !hasValue).trigger("chosen:updated");
  //   fractureclosebody.prop("disabled", !hasValue).trigger("chosen:updated");
  // });

  // for Others
  var other_nature = $("#Others_nature_injured");
  var other_nature_details = $("#other_nature_datails");
  var side_others = $("#side_others");
  var bodyparts_others = $("#body_parts_others");

  other_nature.change(function () {
    other_nature_details.prop("disabled", $(this).val().trim === "");
    if (!this.checked) {
      other_nature_details.prop("disabled", true).val("");
      side_others.prop("disabled", true).val("");
      bodyparts_others.prop("disabled", true).val("").trigger("chosen:updated");
    }
  });

  other_nature_details.on("input", function () {
    var hasValue = $(this).val() !== "";

    bodyparts_others.prop("disabled", !hasValue).trigger("chosen:updated");
  });

  //nature multiple generated counter
  $('[id^="nature"]').each(function () {
    var counter = $(this).attr("id").match(/\d+/);
    if (counter !== null) {
      var counters = counter[0];
    }

    var natureCheckbox = $("#nature" + counters);
    var natureDetails = $("#nature_details" + counters);
    var natureside = $("#sideInjured" + counters);
    var natureBodyParts = $("#body_parts_injured" + counters);

    natureCheckbox.change(function () {
      natureDetails.prop("disabled", !this.checked);
      if (!this.checked) {
        natureDetails.val("");
        natureside.prop("disabled", true).val("");
        natureBodyParts
          .prop("disabled", true)
          .val("")
          .trigger("chosen:updated");
      }
    });

    natureDetails.on("input", function () {
      var hasValue = $(this).val() !== "";

      natureBodyParts.prop("disabled", !hasValue).trigger("chosen:updated");
    });
  });

  //external injury
  var exburn = $("#ex_burn");
  var burn1 = $("#burn1");
  var burn2 = $("#burn2");
  var burn3 = $("#burn3");
  var burn4 = $("#burn4");
  var burn5 = $("#burn5");
  var burndetails = $("#exburnDetails");
  exburn.change(function () {
    burn1.prop("disabled", !this.checked);
    burn2.prop("disabled", !this.checked);
    burn3.prop("disabled", !this.checked);
    burn4.prop("disabled", !this.checked);
    burn5.prop("disabled", !this.checked);

    if (!this.checked) {
      burn1.removeAttr("checked");
      burn2.removeAttr("checked");
      burn3.removeAttr("checked");
      burn4.removeAttr("checked");
      burn5.removeAttr("checked");

      burndetails.prop("disabled", true).val("");
    }
  });

  burn1
    .add(burn2)
    .add(burn3)
    .add(burn4)
    .add(burn5)
    .change(function () {
      burndetails.prop("disabled", !this.checked);
    });

  //drowning
  var exdrowning = $("#exDrowning");
  var drowning1 = $("#drowning1");
  var drowning2 = $("#drowning2");
  var drowning3 = $("#drowning3");
  var drowning4 = $("#drowning4");
  var drowning5 = $("#drowning5");
  var drowningDetails = $("#exdrowningDetails");

  exdrowning.change(function () {
    drowning1.prop("disabled", !this.checked);
    drowning2.prop("disabled", !this.checked);
    drowning3.prop("disabled", !this.checked);
    drowning4.prop("disabled", !this.checked);
    drowning5.prop("disabled", !this.checked);

    if (!this.checked) {
      drowning1.removeAttr("checked");
      drowning2.removeAttr("checked");
      drowning3.removeAttr("checked");
      drowning4.removeAttr("checked");
      drowning5.removeAttr("checked");

      drowningDetails.prop("disabled", true).val("");
    }
  });
  drowning1
    .add(drowning2)
    .add(drowning3)
    .add(drowning4)
    .add(drowning5)
    .change(function () {
      drowningDetails.prop("disabled", !this.checked);
    });

  $('[id^="external"]').each(function () {
    var counter = $(this).attr("id").match(/\d+/);

    var external_checkbox = $("#external" + counter);
    var external_details = $("#external_details" + counter);

    external_checkbox.change(function () {
      external_details.prop("disabled", !this.checked);

      if (!this.checked) {
        external_details.prop("disabled", true).val("");
      }
    });
  });

  //---------------------------------------for profile verification---------------------------------------//
  $("#checkProfiles").modal({
    backdrop: "static",
    keyboard: false,
  });

  var checkmodal = $("#checkProfiles").modal("show");
  console.log("modal", checkmodal);

  // $("#checkProfiles").modal({ backdrop: "static", keyboard: false });
  // $.validator.setDefaults({
  //   errorElement: "span",
  //   errorClass: "help-block",
  //   //	validClass: 'stay',
  //   highlight: function (element, errorClass, validClass) {
  //     $(element).addClass(errorClass); //.removeClass(errorClass);
  //     $(element)
  //       .closest(".has-group")
  //       .removeClass("has-success")
  //       .addClass("has-error");
  //   },
  //   unhighlight: function (element, errorClass, validClass) {
  //     $(element).removeClass(errorClass); //.addClass(validClass);
  //     $(element)
  //       .closest(".has-group")
  //       .removeClass("has-error")
  //       .addClass("has-success");
  //   },
  //   errorPlacement: function (error, element) {
  //     if (element.parent(".input-group").length) {
  //       error.insertAfter(element.parent());
  //     } else if (element.hasClass("select2")) {
  //       error.insertAfter(element.next("span"));
  //     } else if (element.hasClass("chosen-select")) {
  //       error.insertAfter(element.next("div"));
  //     } else if (element.hasClass("sex")) {
  //       error.insertAfter(".span");
  //     } else {
  //       error.insertAfter(element);
  //     }
  //   },
  // });

  function fetchProfiles(data) {
    $(".loading").show();

    $.ajax({
      url: "get/checkprofiles",
      method: "GET",
      headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
      },
      data: data,
      success: function (record) {
        let content = "";
        if (record.length > 0) {
          content +=
            '<table class="table table-hover table-striped">' +
            "<thead>" +
            "<tr>" +
            "<th>First Name</th>" +
            "<th>Middle Name</th>" +
            "<th>Last Name</th>" +
            "<th>Date of Birth</th>" +
            "<th>Update</th>" +
            "</tr></thead>" +
            "<tbody>";
          jQuery.each(record, function (i, val) {
            content +=
              "<tr>" +
              "<td>" +
              val.fname +
              "</td>" +
              "<td>" +
              (val.mname || "") +
              "</td>" + // Handle null values
              "<td>" +
              val.lname +
              "</td>" +
              "<td>" +
              val.dob +
              "</td>" +
              `<td><a class="btn btn-xs btn-success" href="${baseUrl}/${val.id}"><i class="fa fa-pencil"></i> Update</a></td>` +
              "</tr>";
          });

          content += "</tbody></table>";
          $("#checkProfiles").find(".modal-body").html(content);
        } else {
          alert("No matching profiles found.");
          console.log("where is my data", data);
          $("#fname").val(data.fname);
          $("#mname").val(data.mname);
          $("#lname").val(data.lname);
          $("#dateofbirth").val(data.dob);
          $("#checkProfiles").modal("hide");
        }
        $(".loading").hide(); // Hide loading indicator
      },
      error: function () {
        $(".loading").hide(); // Hide loading indicator
        alert("An error occurred while fetching profiles.");
      },
    });
  }

  // Event listener for the 'Check' button
  $(".btn-checkProfiles").on("click", function () {
    const data = {
      fname: $(".fname").val(),
      mname: $(".mname").val(),
      lname: $(".lname").val(),
      dob: $(".dob").val(),
    };

    fetchProfiles(data);
  });

  // $(".btn-checkProfiles").on("click", function () {
  //   $(".loading").show();
  //   var content = "";
  //   var form = $("#form-submit");

  //   var data = {
  //     fname: $("#checkProfiles").find(".fname").val(),
  //     mname: $("#checkProfiles").find(".mname").val(),
  //     lname: $("#checkProfiles").find(".lname").val(),
  //     dob: $("#checkProfiles").find(".dob").val(),
  //   };

  //   form.find(".fname").val(data.fname);
  //   form.find(".mname").val(data.mname);
  //   form.find(".lname").val(data.lname);
  //   form.find(".dob").val(data.dob);

  //   $.ajax({
  //     url: "get/checkprofiles",
  //     method: "GET",
  //     headers: {
  //       "X-CSRF-TOKEN": "{{ csrf_token() }}",
  //     },
  //     data: data,
  //     success: function (data) {
  //       console.log(data);
  //       if (data.length > 0) {
  //         content +=
  //           '<table class="table table-hover table-striped">' +
  //           "<thead>" +
  //           "<tr>" +
  //           "<th>First Name</th>" +
  //           "<th>Middle Name</th>" +
  //           "<th>Last Name</th>" +
  //           "<th>Date of Birth</th>" +
  //           "<th>Update</th>" +
  //           "</tr></thead>" +
  //           "<tbody>";
  //         jQuery.each(data, function (i, val) {
  //           content +=
  //             "<tr>" +
  //             "<td>" +
  //             val.fname +
  //             "</td>" +
  //             "<td>" +
  //             val.mname +
  //             "</td>" +
  //             "<td>" +
  //             val.lname +
  //             "</td>" +
  //             "<td>" +
  //             val.dob +
  //             "</td>" +
  //             `<td><a class="btn btn-xs btn-success" href="${baseUrl}/${val.id}"><i class="fa fa-pencil"></i> Update</a></td>` +
  //             "</tr>";
  //         });

  //         content += "</tbody></table>";

  //         // content += '<div class="pagination-controls">';
  //         // if (data.prev_page_url) {
  //         //   content +=
  //         //     '<button onclick="loadPage(' +
  //         //     (data.current_page - 1) +
  //         //     ')">Previous</button>';
  //         // }
  //         // if (data.next_page_url) {
  //         //   content +=
  //         //     '<button onclick="loadPage(' +
  //         //     (data.current_page + 1) +
  //         //     ')">Next</button>';
  //         // }
  //         // content += "</div>";

  //         $("#checkProfiles").find(".modal-body").html(content);
  //         $("#checkProfiles").find(".btn-checkProfiles").hide();
  //       } else {
  //         $("#checkProfiles").modal("hide");
  //       }

  //       $(".loading").hide();
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error checking profile:", error);
  //     },
  //   });
  // });
});

// for deleteing nature
document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelectorAll('input[type="checkbox"]')
    .forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        if (!this.checked) {
          let csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
          let natureId = this.value;
          let preadmissionId = document.getElementById(
            "preadmission_id_update"
          ).value;
          let category = this.getAttribute("data-category");
          console.log("nature_id", natureId, "preadmissionId", preadmissionId);

          Lobibox.confirm({
            title: "Confirm Deletion",
            msg: "Are you sure you want to delete this data?",
            buttons: {
              yes: {
                class: "btn btn-success",
                text: "Yes",
                closeOnClick: true,
              },
              no: {
                class: "btn btn-danger",
                text: "No",
                closeOnClick: true,
              },
            },

            callback: function (lobibox, type) {
              if (type == "yes") {
                $.ajax({
                  url: deleteNatureUrl,
                  type: "POST",
                  headers: {
                    "X-CSRF-TOKEN": csrfToken,
                  },
                  data: {
                    nature_id: natureId,
                    preadmission_id: preadmissionId,
                    category: category,
                  },
                  success: function (response) {
                    console.log("Nature deleted successfully", response);
                  },
                  error: function (xhr) {
                    // Handle error, e.g., show an error message
                    console.error(
                      "An error occurred while deleting the nature"
                    );
                  },
                });
              }
            },
          });
        }
      });
    });
});
