import React, { useState } from "react";
import "../css/styles.css";
import ReactDOM from "react-dom";
// import axios from "axios";

const PatientInjuryForm = () => {
  const [multipleInjuries, setMultipleInjuries] = useState(false);
  const [formData, setFormData] = useState({
    druByWhom: "",
    druWhat: "",
    firstAidGiven: false,
    IntentionalViolence: false,
    Undetermined: false,
    VawcPatient: false,
    unintentionalAccidental: false,
    intentionalSelfInflicted: false,
    facilityname: "",
    dru: "",
    "facility-add": "",
    patientType1: false,
    patientType2: false,
    patientType3: false,
    patientType4: false,
    patientType5: false,
    hospital_no: "",
    lname: "",
    fname: "",
    mname: "",
    sex: "",
    dateBirth: "",
    age: "",
    province: "",
    municipal: "",
    barangay: "",
    phil_no: "",
    permanent_add_province: "",
    permanent_add_municipal: "",
    permanent_add_barangay: "",
    date_injury: "",
    time_injury: "",
    date_consultation: "",
    time_consultation: "",
  });

  const [injuryDetails, setInjuryDetails] = useState({
    Abrasion: "",
    AbrasionDetail: "",
    Avulsion: "",
    AvulsionDetail: "",
    Burn: "",
    burnDegree: "",
    BurnDetail: "",
    Concussion: "",
    ConcussionDetail: "",
    Contusion: "",
    ContusionDetail: "",
    Fracture: "",
    close_type: false,
    closetype_details: "",
    open_type: false,
    opentype_details: "",
    OpenWound: "",
    OpenWoundDetail: "",
    TraumaticAmputation: "",
    TraumaticAmputationDetail: "",
    Others: "",
    OthersDetail: "",
  });

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData((prevState) => ({
      ...prevState,
      [name]: type === "checkbox" ? checked : value,
    }));
  };

  return (
    <div className="col-md-8 wrapper">
      <div className="alert alert-jim">
        <h2 className="page-header">
          <i className="fa fa-user-plus"></i>&nbsp; Patient Injury Form
        </h2>
        <div className="page-divider"></div>
        <form
          className="form-horizontal form-submit"
          id="form-submit"
          action=""
        >
          <div className="row">
            <div className="col-md-12 col-divider">
              <h4 className="patient-font">Disease Reporting Unit</h4>
              <div className="row">
                <div className="col-md-6">
                  <label htmlFor="facility-name">
                    Name of Reporting Facility
                  </label>
                  <input
                    type="text"
                    className="form-control"
                    name="facilityname"
                    value={formData.facilityname}
                    onChange={handleChange}
                    id="facility-name"
                  />
                </div>
                <div className="col-md-6">
                  <label htmlFor="dru">Type of DRU</label>
                  <input
                    type="text"
                    className="form-control"
                    name="dru"
                    value={formData.dru}
                    onChange={handleChange}
                    id="dru"
                  />
                </div>
                <div className="col-md-6">
                  <label htmlFor="address-facility">
                    Address of Reporting Facility
                  </label>
                  <input
                    type="text"
                    className="form-control"
                    name="facility-add"
                    value={formData["facility-add"]}
                    onChange={handleChange}
                    id="address-facility"
                  />
                </div>
                <div className="col-md-6">
                  <label>Type of Patient</label>
                  <div className="checkbox">
                    <label className="checkbox-inline">
                      <input
                        type="checkbox"
                        id="patientType1"
                        name="patientType1"
                        checked={formData.patientType1}
                        onChange={handleChange}
                        value="ER"
                      />{" "}
                      ER
                    </label>
                    <label className="checkbox-inline">
                      <input
                        type="checkbox"
                        id="patientType2"
                        name="patientType2"
                        checked={formData.patientType2}
                        onChange={handleChange}
                        value="OPD"
                      />{" "}
                      OPD
                    </label>
                    <label className="checkbox-inline">
                      <input
                        type="checkbox"
                        id="patientType3"
                        name="patientType3"
                        checked={formData.patientType3}
                        onChange={handleChange}
                        value="In-Patient"
                      />{" "}
                      In-Patient
                    </label>
                    <label className="checkbox-inline">
                      <input
                        type="checkbox"
                        id="patientType4"
                        name="patientType4"
                        checked={formData.patientType4}
                        onChange={handleChange}
                        value="BHS"
                      />{" "}
                      BHS
                    </label>
                    <label className="checkbox-inline">
                      <input
                        type="checkbox"
                        id="patientType5"
                        name="patientType5"
                        checked={formData.patientType5}
                        onChange={handleChange}
                        value="RHU"
                      />{" "}
                      RHU
                    </label>
                  </div>
                </div>
              </div>
              <h4 className="patient-font mt-4">General Data</h4>
              <div className="row">
                <div className="col-md-3">
                  <label htmlFor="hospital_no">Hospital Case No.</label>
                  <input
                    type="text"
                    className="form-control"
                    name="hospital_no"
                    value={formData.hospital_no}
                    onChange={handleChange}
                    id="hospital_no"
                  />
                </div>
                <div className="col-md-3">
                  <label htmlFor="lname">Last Name</label>
                  <input
                    type="text"
                    className="form-control"
                    name="lname"
                    value={formData.lname}
                    onChange={handleChange}
                    id="lname"
                  />
                </div>
                <div className="col-md-3">
                  <label htmlFor="fname">First Name</label>
                  <input
                    type="text"
                    className="form-control"
                    name="fname"
                    value={formData.fname}
                    onChange={handleChange}
                    id="fname"
                  />
                </div>
                <div className="col-md-2">
                  <label htmlFor="mname">Middle Name</label>
                  <input
                    type="text"
                    className="form-control"
                    name="mname"
                    value={formData.mname}
                    onChange={handleChange}
                    id="mname"
                  />
                </div>
                <div className="col-md-1">
                  <label htmlFor="sex">Sex</label>
                  <input
                    type="text"
                    className="form-control"
                    name="sex"
                    value={formData.sex}
                    onChange={handleChange}
                    id="sex"
                  />
                </div>
                <div className="col-md-3">
                  <label htmlFor="dateofbirth">Date Of Birth</label>
                  <input
                    type="date"
                    className="form-control"
                    id="dateofbirth"
                    name="dateBirth"
                    value={formData.dateBirth}
                    onChange={handleChange}
                  />
                </div>
                <div className="col-md-3">
                  <label htmlFor="age">Age</label>
                  <input
                    type="text"
                    className="form-control"
                    id="age"
                    name="age"
                    value={formData.age}
                    disabled
                  />
                </div>
                <div className="col-md-3">
                  <label htmlFor="province">Province</label>
                  <select
                    className="form-control"
                    name="province"
                    value={formData.province}
                    onChange={handleChange}
                  >
                    <option value="">Select Province</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div>
                <div className="col-md-3">
                  <label htmlFor="municipal">Municipal</label>
                  <select
                    className="form-control"
                    name="municipal"
                    value={formData.municipal}
                    onChange={handleChange}
                  >
                    <option value="">Select Municipal</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div>
                <div className="col-md-3">
                  <label htmlFor="barangay">Barangay</label>
                  <select
                    className="form-control"
                    name="barangay"
                    value={formData.barangay}
                    onChange={handleChange}
                  >
                    <option value="">Select Barangay</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div>
                <div className="col-md-9">
                  <label htmlFor="phil_no">PhilHealth No.</label>
                  <input
                    type="text"
                    className="form-control"
                    name="phil_no"
                    value={formData.phil_no}
                    onChange={handleChange}
                    id="phil_no"
                  />
                </div>
              </div>
              <h4 className="patient-font mt-4">Pre-admission Data</h4>
              <div className="row">
                <div className="col-md-12">
                  <label>Place Of Injury:</label>
                </div>
                <div className="col-md-4">
                  <select
                    className="form-control"
                    name="permanent_add_province"
                    value={formData.permanent_add_province}
                    onChange={handleChange}
                  >
                    <option value="">Select Province</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div>
                <div className="col-md-4">
                  <select
                    className="form-control"
                    name="permanent_add_municipal"
                    value={formData.permanent_add_municipal}
                    onChange={handleChange}
                  >
                    <option value="">Select Municipal</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div>
                <div className="col-md-4">
                  <select
                    className="form-control"
                    name="permanent_add_barangay"
                    value={formData.permanent_add_barangay}
                    onChange={handleChange}
                  >
                    <option value="">Select Barangay</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div>
                <div className="col-md-6">
                  <label>Date and Time Injury:</label>
                  <input
                    type="date"
                    className="form-control"
                    name="date_injury"
                    value={formData.date_injury}
                    onChange={handleChange}
                  />
                  <input
                    type="time"
                    className="form-control"
                    name="time_injury"
                    value={formData.time_injury}
                    onChange={handleChange}
                  />
                </div>
                <div className="col-md-6">
                  <label>Date and Time Consultation:</label>
                  <input
                    type="date"
                    className="form-control"
                    name="date_consultation"
                    value={formData.date_consultation}
                    onChange={handleChange}
                  />
                  <input
                    type="time"
                    className="form-control"
                    name="time_consultation"
                    value={formData.time_consultation}
                    onChange={handleChange}
                  />
                </div>
              </div>
            </div>

            <div className="row">
              <div
                className="col-md-12 text-center"
                style={{ marginTop: "20px" }}
              >
                <button type="button" className="btn btn-primary mx-2">
                  Previous
                </button>
                &nbsp;
                <button type="button" className="btn btn-primary mx-2">
                  Next
                </button>
              </div>
            </div>
            {/* <div className="col-md-6">
              <div className="row">
                <div className="col-md-3">
                  <div>
                    <label>Injury Intent:</label>
                  </div>
                </div>
                <div className="col-md-3">
                  <label className="checkbox-inline">
                    <input
                      type="checkbox"
                      name="unintentionalAccidental"
                      checked={formData.unintentionalAccidental}
                      onChange={handleChange}
                    />{" "}
                    Unintentional/Accidental
                  </label>
                  <label className="checkbox-inline">
                    <input
                      type="checkbox"
                      name="intentionalSelfInflicted"
                      checked={formData.intentionalSelfInflicted}
                      onChange={handleChange}
                    />{" "}
                    Intentional (Self-inflicted)
                  </label>
                </div>
                <div className="col-md-3">
                  <label className="checkbox-inline">
                    <input
                      type="checkbox"
                      name="IntentionalViolence"
                      checked={formData.IntentionalViolence}
                      onChange={handleChange}
                    />{" "}
                    Intentional/(Violence)
                  </label>
                  <label className="checkbox-inline">
                    <input
                      type="checkbox"
                      name="Undetermined"
                      checked={formData.Undetermined}
                      onChange={handleChange}
                    />{" "}
                    Undetermined
                  </label>
                </div>
                <div className="col-md-3">
                  <label className="checkbox-inline">
                    <input
                      type="checkbox"
                      name="VAWCPatient"
                      checked={formData.VawcPatient}
                      onChange={handleChange}
                    />{" "}
                    VAWC Patient
                  </label>
                </div>
              </div>
            </div>
            <div className="col-md-6">
              <div className="row">
                <hr />
                <div className="col-md-3">
                  <label>First Aid Given:</label>
                </div>
                <div className="col-md-1">
                  <label className="checkbox-inline">
                    <input
                      type="checkbox"
                      name="firstAidGiven"
                      checked={formData.firstAidGiven}
                      onChange={handleChange}
                    />{" "}
                    Yes
                  </label>
                </div>
                <div className="col-md-2">
                  <input
                    type="text"
                    className="form-control"
                    name="druWhat"
                    value={formData.druWhat}
                    onChange={handleChange}
                    placeholder="What:"
                  />
                </div>
                <div className="col-md-2">
                  <input
                    type="text"
                    className="form-control"
                    name="druByWhom"
                    value={formData.druByWhom}
                    onChange={handleChange}
                    placeholder="By whom:"
                  />
                </div>
                <div className="col-md-2">
                  <input
                    type="checkbox"
                    name="firstAidGiven"
                    checked={!formData.firstAidGiven}
                    onChange={handleChange}
                  />{" "}
                  No
                </div>

                <div className="col-md-12">
                  <hr />
                  <label>Nature of Injuries:</label>
                </div>
                <div className="col-md-3">
                  <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    multiple Injuries?
                  </p>
                </div>
                <div className="col-md-3">
                  <input
                    type="checkbox"
                    id="patientType1"
                    value="Yes"
                    checked={multipleInjuries}
                    onChange={() => setMultipleInjuries(!multipleInjuries)}
                  />{" "}
                  Yes &nbsp;&nbsp;&nbsp;&nbsp;
                  <input
                    type="checkbox"
                    id="patientType2"
                    value="No"
                    checked={!multipleInjuries}
                    onChange={() => setMultipleInjuries(!multipleInjuries)}
                  />{" "}
                  No
                </div>
                <div className="col-md-12">
                  <p className="underline-text text-center" id="underline-text">
                    Check all applicable, indicate in the blank space opposite
                    each type of injury the body location [site] and affected
                    and other details
                  </p>
                </div>
                <div className="col-md-4">
                  <div>
                    <input
                      type="checkbox"
                      id="Abrasion"
                      name="Abrasion"
                      checked={injuryDetails.Abrasion}
                      onChange={handleChange}
                    />{" "}
                    Abrasion :
                    <input
                      type="text"
                      name="AbrasionDetail"
                      value={injuryDetails.AbrasionDetail}
                      onChange={handleChange}
                      id="natureinput"
                    />
                  </div>

                  <div>
                    <input
                      type="checkbox"
                      id="Avulsion"
                      name="Avulsion"
                      checked={injuryDetails.Avulsion}
                      onChange={handleChange}
                    />{" "}
                    Avulsion :
                    <input
                      type="text"
                      name="AvulsionDetail"
                      value={injuryDetails.AvulsionDetail}
                      onChange={handleChange}
                      id="natureinput"
                    />
                  </div>
                </div>
              </div>
            </div> */}
          </div>
        </form>
      </div>
    </div>
  );
};

const root = ReactDOM.createRoot(
  document.getElementById("patient-injury-form-container")
);
root.render(<PatientInjuryForm />);

export default PatientInjuryForm;
