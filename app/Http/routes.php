<?php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::auth();
Route::group(['middleware' => 'checkUserPrivilege'], function(){
    Route::get('/', 'HomeCtrl@index');
    Route::get('home', 'HomeCtrl@index');
    Route::get('home/chart','HomeCtrl@chart');
    Route::get('home/count/{type}','HomeCtrl@count');
    Route::get('home/count/target/{year}','HomeCtrl@countTarget');
    Route::get('home/count/province/{id}/{year}', 'HomeCtrl@countPerProvince');
    Route::get('home/count/muncity/{id}/{year}', 'HomeCtrl@countPerMuncity');
    Route::get('home/count/barangay/{id}/{year}', 'HomeCtrl@countPerBarangay');

    Route::get('population', 'PopulationCtrl@index');
    Route::post('population', 'PopulationCtrl@searchPopulation');
    Route::get('population/profiles/{id}', 'PopulationCtrl@familyMember');

    Route::get('population/less', 'PopulationCtrl@less');
    Route::post('population/less', 'PopulationCtrl@searchLess');
    Route::get('population/service/{id}', 'PopulationCtrl@servicePopulation');

    //Service
    Route::get('services','ServiceCtrl@index');
    Route::post('services','ServiceCtrl@search');
    Route::post('services/save','ServiceCtrl@save');
    Route::get('service/info/{id}','ServiceCtrl@info');
    Route::post('services/update','ServiceCtrl@update');
    //end service

    //Dengvaxia
    Route::match(['get', 'post'],'dengvaxia/profile','DengvaxiaCtrl@index');
    Route::match(['get', 'post'],'dengvaxia/link','DengvaxiaCtrl@link');
    Route::get('dengvaxia/count/{id}','DengvaxiaCtrl@countProfile');
    Route::get('dengvaxia/link/{id}/{offset}','DengvaxiaCtrl@linkProfile');
    Route::get('dengvaxia/finish/{id}','DengvaxiaCtrl@finish');
    //End Dengvaxia

    //REPORT
    Route::match(['GET','POST'],'report/status','ReportCtrl@status');
    Route::get('report/monthly','ReportCtrl@monthly');
    Route::post('report/monthly','ReportCtrl@monthly');
    Route::get('report/online','ReportCtrl@online');
    //end REPORT
    //PROGRAMS
    Route::get('bracket', 'BracketCtrl@index');
    Route::post('bracket','BracketCtrl@search');
    Route::post('bracket/assign','BracketCtrl@assign');
    Route::get('bracket/remove/{id}','BracketCtrl@remove');
    //end programs
    Route::get('change/password',function(){
        return view('app');
    });
    //end PROGRAMS

    //DOWNLOAD
    Route::get('download','DownloadCtrl@index');
    Route::post('download','DownloadCtrl@index');
    Route::match(['GET','POST'],'download/iclinicsys','DownloadCtrl@downloadClinicSys');
    //Route::get('download/{id}/{prov_desc}/{mun_id}/{mun_desc}','DownloadCtrl@generateDownload');
    Route::get('download/user/{id}','DownloadCtrl@generateUserDownload');
    Route::post('generatedownload', 'DownloadCtrl@generateDownload');
    Route::get('generatedownload/barangay/{province_id}/{muncity_id}/{year}', 'FacilityCtrl@downloadBarangay');
    //END DOWNLOAD

    //parameters
    Route::get('age','ParameterCtrl@getAge');
    Route::get('delete','ParameterCtrl@delete');
    //end parameter

    //users
    Route::get('users','UserCtrl@index');
    Route::post('users','UserCtrl@search');
    Route::post('users/save','UserCtrl@save');
    Route::post('users/update','UserCtrl@update');
    Route::get('users/info/{id}','UserCtrl@info');
    Route::get('users/assign/{id}','UserCtrl@assign');   
    //end users

    //location
    Route::get('location/muncity/{id}','LocationCtrl@getMuncityByProvince');
    Route::get('location/barangay/{id}','LocationCtrl@getBarangayByMuncity');

    //end location

    //feedback
    Route::get('feedback','FeedbackCtrl@index');
    Route::get('feedback/view/{id}','FeedbackCtrl@view');
    Route::post('feedback/status','FeedbackCtrl@status');
    //end feedback

    //client
    Route::get('user/home','ClientCtrl@index');
    Route::get('user/home/chart','ClientCtrl@chart');
    Route::get('user/count/barangay/{id}','ClientCtrl@countPerBarangay');

    //count
    Route::get('user/home/count','ClientCtrl@count');

    //end count
    //population
    Route::get('user/population','ClientCtrl@population');
    Route::post('user/population','ClientCtrl@searchPopulation');

    Route::post('user/profile/verify','ClientCtrl@verifyProfile');
    Route::get('user/profile/age/{dob}','ClientCtrl@calculateAge');
    Route::get('user/profile/age/day/{dob}','ParameterCtrl@getAgeDay');
    Route::get('user/profile/age/withDay/{dob}','ClientCtrl@calculateAgeWithDay');

    Route::get('user/population/add/{id}','ClientCtrl@addPopulation');
    Route::post('user/population/save','ClientCtrl@savePopulation');

    // I move this route
    Route::post('user/population/head/save','ClientCtrl@saveHeadProfile');

    Route::get('user/population/info/{id}','ClientCtrl@infoPopulation');
    Route::post('user/population/update','ClientCtrl@updatePopulation');

    Route::get('user/population/less','ClientCtrl@populationLess');
    Route::post('user/population/less','ClientCtrl@searchPopulationLess');

    Route::get('user/population/member/{id}','ClientCtrl@memberPopulation');
    Route::get('user/population/service/{id}/{year}','ClientCtrl@servicePopulation');
    Route::get('user/population/less/service/{profileID}','ClientCtrl@servicePopulationLess');

    Route::get('user/profiles','ClientCtrl@getFamilyProfiles');
    Route::get('user/profiles/all','ClientCtrl@getProfiles');
    Route::get('user/profiles/pending','ClientCtrl@profilePending');
    //end population
    //services
    Route::post('user/services/date','ClientCtrl@updateDate');


    Route::post('user/services','ClientCtrl@searchServices');
    Route::get('user/services','ClientCtrl@services');
    Route::get('user/services/{id}','ClientCtrl@services');
    Route::post('user/services/save','ClientCtrl@saveServices');
    Route::get('user/services/updategender/{gender}/{id}','ClientCtrl@updategender');
    //end services
    //reports
    Route::get('user/report','ClientCtrl@report');
    Route::post('user/report','ClientCtrl@searchReport');
    Route::post('user/report/delete','ClientCtrl@deleteReport');
    Route::get('user/report/cases','ClientCtrl@casesReport');
    Route::post('user/report/cases','ClientCtrl@searchCase');
    Route::post('user/report/cases/delete','ClientCtrl@deleteCase');

    Route::get('user/report/monthly','ClientCtrl@monthlyReport');
    Route::post('user/report/monthly','ClientCtrl@monthlyReport');

    //request monthly report
    Route::get('user/report/monthly/count/{code}/{month}/{year}', 'MonthlyReportCtrl@countService');

    //graph report
    Route::get('/user/report/health','ClientCtrl@health');
    Route::get('/user/report/health/data','ClientCtrl@healthData');

    Route::get('user/report/status','ClientCtrl@statusReport');
    Route::get('user/report/iclinicsys','ClientCtrl@iclinicSys');
    Route::get('admin/report/iclinicsys','ReportCtrl@iclinicSys');
    Route::get('admin/report/statdetails/{mun_id}/{bar_id}','ReportCtrl@statusDetails');
    //upload report
    Route::get('user/upload/temp',function(){
        return view('temp');
    });

    //Dengvaxia
    Route::get('user/dengvaxia','client\DengvaxiaCtrl@index');
    Route::get('user/dengvaxia/add/{id}','client\DengvaxiaCtrl@add');
    Route::post('user/dengvaxia/save','client\DengvaxiaCtrl@save');

    Route::get('user/dengvaxia/validate/date_given/{start}/{end}','client\DengvaxiaCtrl@validateDoseDateGiven');
    //end Dengvaxia


    //Downloading of Data of 1.4
    //Route::get('user/download/data','Client\ReportCtrl@download');
    //Route::get('user/download/data/countprofile/{year}','Client\ReportCtrl@countProfile');
    //Route::get('user/download/data/{offset}','Client\ReportCtrl@downloadProfile');

    ////Downloading of Services
    //Route::get('user/download/services/{year}/{offset}','Client\ReportCtrl@getServices');
    //
    ////Downloading of Cases
    //Route::get('user/download/cases/{year}/{offset}','Client\ReportCtrl@getCases');
    //
    ////Downloading of Options
    //Route::get('user/download/options/{year}/{offset}','Client\ReportCtrl@getOptions');


    ////Uploading of Data
    //Route::get('user/upload/data','Client\ReportCtrl@upload');
    //Route::post('user/upload/data','Client\ReportCtrl@uploadData');
    //
    ////UPloading old data
    //Route::get('user/upload/old/data','Client\ReportCtrl@uploadOld');
    //Route::post('user/upload/old/data','Client\ReportCtrl@uploadDataOld');
    //
    ////Downloading of Data of 1.2
    //Route::get('user/download/old/data','Client\OldDataCtrl@download');
    //Route::get('user/download/old/data/countprofile/{year}','Client\OldDataCtrl@countProfile');
    //Route::get('user/download/old/data/{offset}','Client\OldDataCtrl@downloadProfile');

    //Downloading of Services
    Route::get('user/download/old/services/{year}/{offset}','Client\OldDataCtrl@getServices');

    //Downloading of Cases
    Route::get('user/download/old/cases/{year}/{offset}','Client\OldDataCtrl@getCases');

    //Downloading of status
    Route::get('user/download/old/status/{year}/{offset}','Client\OldDataCtrl@getStatus');

    //Downloading of Options
    Route::get('user/download/old/options/{year}/{offset}','Client\OldDataCtrl@getOptions');

    //Download login Info
    Route::get('user/download','ClientCtrl@downloadLogin');
    //end reports
    //users
    Route::get('user/add','ClientCtrl@addUser');
    Route::post('user/add','ClientCtrl@searchUser');
    Route::post('user/save','ClientCtrl@saveUser');
    Route::post('user/update','ClientCtrl@updateUser');
    Route::get('user/info/{id}','ClientCtrl@infoUser');
    //end users

    //feedback
    Route::post('feedback/send','ParameterCtrl@sendFeedback');
    //end client

    Route::get('accounts',function(){
        return view('system.account');
    });
    Route::get('negros',function(){
        return view('system.bohol');
    });

    Route::get('api','ApiCtrl@api');
    Route::get('apiv21','ApiCtrlv21@api');
    Route::post('api/syncprofile','ApiCtrl@syncProfile');
    Route::post('apiv21/syncprofilev21','ApiCtrlv21@syncProfile');
    Route::post('api/syncservices','ApiCtrl@syncServices');

    Route::get('api/users/xQQQt5FVpy2bH2WJk0cY4nkDJVe3pOyU','ApiCtrl@getUsers');
    Route::get('api/barangay/jryarUWnsKDrPJoRGDRUcD4Bofbakif7','ApiCtrl@getBarangay');
    Route::get('api/brackets/bpiQj6XvkM5uceikTflASTz4ndesvKso','ApiCtrl@getBrackets');
    Route::get('api/cases/fqZvUqILCTEhujhnWOHAFW9ylNJa8giY','ApiCtrl@getCases');
    Route::get('api/feedback/rUiXXyGlxIPFOxaP152fkX2NWgC1lUZX','ApiCtrl@getFeedback');
    Route::get('api/muncity/KhhkVQmAuykkG2K4WgAaZM6jO0nWz6Yd','ApiCtrl@getMuncity');
    Route::get('api/profile/koFi2jImlFLSqs7ObyNExBePYsk6iKth/{offset}/{limit}','ApiCtrl@getProfile');
    Route::get('api/profile_device/x6ubxP0lotYU1TpCdK0W0icVgcKDlZnq/{offset}/{limit}','ApiCtrl@getProfileDevice');
    Route::get('api/province/hPSKFkWhBtNtYiU70Ud4nvwIKV8fmXqp','ApiCtrl@getProvince');
    Route::get('api/services/58eqDKCL4HRO1oUxnCXzG0g1GS14fIWa','ApiCtrl@getServices');
    Route::get('api/userbrgy/4D7PzqmsPHkHLhQU84bcVO5d9Pp0B2Fp/{offset}/{limit}','ApiCtrl@getUserBrgy');
    Route::get('api/sitio/Q2X97Uniunk4Y3rAMioPZaIGuWqusRp5','ApiCtrl@getSitio');
    Route::get('api/purok/DQ7d1CSfd6qcPizNugRcsRFJVkfOaPO7','ApiCtrl@getPurok');
    Route::get('api/facility/hmLGUE1trAZ4gwdSGikiWpOPnSaACcoe','ApiCtrl@getFacility');

    //RUSEL
    Route::get('verify_dengvaxia/{id}/{unique_id}','DengvaxiaController@verify_dengvaxia');
    Route::get('form_dengvaxia/{id}/{unique_id}/{tsekap_id}','DengvaxiaController@form_dengvaxia');
    Route::get('form_dengvaxia_add/{unique_id}/{tsekap_id}','DengvaxiaController@form_dengvaxia_add');
    Route::post('post_dengvaxia/{id}/{unique_id}/{tsekap_id}','DengvaxiaController@post_dengvaxia');
    Route::post('api/insertDengvaxia','ApiCtrl@insertDengvaxia');

    Route::get('fpdf','DengvaxiaController@fpdf');
    Route::get('patient_api/{id}','ApiCtrl@patient_api');

    Route::get('sessionProcessPrint/{id}', 'DengvaxiaController@sessionProcessPrint');
    Route::get('topNdp', 'TopController@index');
    Route::get('crossMatching/{provinceId}/{muncityId}', 'DengvaxiaController@crossMatching');
    Route::get('crossMatchingResult/{provinceId}/{muncityId}', 'TopController@crossMatchingResult');

    //excel
    Route::get('importView', 'ExcelCtrl@importView');
    Route::post('importExcel', 'ExcelCtrl@importExcel');
    Route::post('ExportExcelBarangay', 'ExcelCtrl@ExportExcelBarangay');
    Route::post('ExportExcelMunicipality', 'ExcelCtrl@ExportExcelMunicipality');
    Route::get('NdpProfileExcel', 'ExcelCtrl@NdpProfileExcel');
    Route::get('NumberColumnProfiled', 'ExcelCtrl@NumberColumnProfiled');
    Route::get('ProfiledByFamilyId', 'ExcelCtrl@ProfiledByFamilyId');

    //DENGVAXIA version 2
    Route::get("deng/form","DengController@form");
    Route::get("deng/pdf","DengController@pdf");
    Route::post("deng/save","DengController@save");
    Route::post("deng/profile_id","DengController@sessionProfileId");

    //BHERT API
    Route::get('kbwk5SMQYatyNsZDM36RzndUHYOXn1nC/{username}/{password}','BhertApiCtrl@login'); //login
    Route::get('K0LslN7GOrirjxWKpmssymMWukBF2X4b/{userid}/{sitio_id}/{offset}/{limit}','BhertApiCtrl@getProfileSitio'); //get profile where sitio_id
    Route::get('mR9tbLLFIwxnWCKWMFS3EMyKrrNHrxYE/{userid}/{purok_id}/{offset}/{limit}','BhertApiCtrl@getProfilePurok'); //get profile where purok_id
    Route::match(['GET','POST'],'IhBKItxoEpTK425HpIMtyKCqan2IdRUn','BhertApiCtrl@insertBhert'); //insert bhert
    Route::get('oKibOqWOFZUYYm6RbkuEtRDEiNpLWu03/{userid}','BhertApiCtrl@countProfile'); //count profile defends on userid


    //SITIO
    Route::match(['GET','POST'],"sitio","SitioController@Sitio");
    Route::post("sitio/add","SitioController@addSitio");
    Route::post("sitio/remove","SitioController@removeSitio");
    Route::match(['GET','POST'],"sitio/add/content","SitioController@addContent");
    Route::post("sitio/select/get","SitioController@selectSitioGet");
    Route::post("sitio/select/post","SitioController@selectSitioPost");

    //PUROK
    Route::match(['GET','POST'],"purok","PurokController@Purok");
    Route::post("purok/add","PurokController@addPurok");
    Route::post("purok/remove","PurokController@removePurok");
    Route::match(['GET','POST'],"purok/add/content","PurokController@addContent");
    Route::post("purok/select/get","PurokController@selectPurokGet");
    Route::post("purok/select/post","PurokController@selectPurokPost");


    // ISSUE
    Route::get('issue/duplicate/population','ClientCtrl@populationDuplicate');
    Route::post('issue/duplicate/population','ClientCtrl@searchPopulationDuplicate');
    Route::get('issue/head/child','ClientCtrl@headChild');
    Route::post('issue/head/child','ClientCtrl@searchHeadChild');

    // FACILITY
    Route::match(['GET','POST'],'facility','FacilityCtrl@index');
    Route::get('facility/body', 'FacilityCtrl@getFacility');
    Route::post('facility/add', 'FacilityCtrl@addFacility');
    Route::post('facility/delete', 'FacilityCtrl@deleteFacility');

    // HEALTH SPECIALISTS
    Route::match(['GET','POST'],'specialist','SpecialistCtrl@index');
    Route::get('specialist/body', 'SpecialistCtrl@getSpecialist');
    Route::get('specialist/facilities/{id}', 'SpecialistCtrl@getUserFacilities');
    Route::post('specialist/add', 'SpecialistCtrl@addSpecialist');
    Route::post('specialist/delete', 'SpecialistCtrl@deleteSpecialist');
    Route::get('specialist/verify', 'SpecialistCtrl@verify');

    // TARGET POPULATION
    Route::get('population/target/{year}','TargetCtrl@targetPopulation');
    Route::post('population/target/{year}','TargetCtrl@targetPopulation');
    Route::post('population/update','TargetCtrl@updateTarget');
    Route::post('population/target/delete','TargetCtrl@delete');
    Route::get('population/target/getMuncityTotal/{mun_id}/{year}','TargetCtrl@getMuncityTotal');
    Route::get('population/target/getBrgyTotal/{bar_id}/{year}','TargetCtrl@getBrgyTotal');
    Route::post('target/generateDownload/{year}','TargetCtrl@generateDownload');
    Route::post('target/getProfileCount/{id}/{year}','TargetCtrl@getProfileCount');

    // API for Specialists and Facilities (retrieve and store)
    Route::get('apiv21/getSpecialists/{user_id}','ApiCtrlv21@getSpecialists');
    Route::get('apiv21/getFacilities/{user_id}','ApiCtrlv21@getFacilities');
    Route::post('apiv21/uploadSpecialist','ApiCtrlv21@uploadSpecialist');
    Route::post('apiv21/uploadFacility','ApiCtrlv21@uploadFacility');

    // API for province, muncity, and brgy
    Route::get('apiv21/getProvinces','ApiCtrlv21@getProvinces');
    Route::get('apiv21/getMuncities','ApiCtrlv21@getMuncities');
    Route::get('apiv21/getBarangays','ApiCtrlv21@getBarangays');

    // onboard users
    Route::get('report/onboard/users','OnboardCtrl@users');
    Route::get('report/onboard/facility','OnboardCtrl@facility');
});

//change Password

Route::get('user/change/password','ParameterCtrl@password');
Route::post('user/change/password','ParameterCtrl@changePassword');

Route::get('change/password','UserCtrl@password');
Route::post('change/password','UserCtrl@changePassword');

//LOGOUT
Route::get('logout',function(){
    Auth::logout();
    \Illuminate\Support\Facades\Session::flush();
    return redirect('login');
});
//for resu 
Route::get('restrictAccess', 'resu\IndexController@forbidden')->name('restrictAccess'); // user can't access base on the user type

    Route::get('surveillance', 'resu\IndexController@index')->name('surveillance');
Route::get('listinjury', 'resu\InjuryController@index');
Route::get('bodyparts', 'resu\InjuryController@bodypart');
Route::post('add-nature-injury', 'resu\InjuryController@addinjury')->name('add-nature-injury');
Route::post('injury-delete', 'resu\InjuryController@deleteInjury')->name('injury-delete');
Route::get('injury-edit/{id}', 'resu\InjuryController@editInjury')->name('injury-edit');
Route::post('injury-update/{id}', 'resu\InjuryController@updateInjury')->name('injury-update');

Route::post('add-bodypart', 'resu\InjuryController@addbodypart')->name('add-bodypart');
Route::get('edit-body-parts/{id}', 'resu\InjuryController@editBodyParts')->name('edit-body-parts');
Route::post('update-body-parts/{id}', 'resu\InjuryController@updateBodyparts')->name('update-body-parts');
Route::get('external-injury', 'resu\InjuryController@listExternal')->name('external-injury');
Route::post('add-external', 'resu\InjuryController@addExternal')->name('add-external');
Route::get('injury-external-edit/{id}', 'resu\InjuryController@editExternalInjury')->name('injury-external-edit');
Route::post('injury-external-upJapdate/{id}','resu\InjuryController@updateExternalInjury')->name('injury-external-update');
Route::post('delete-external', 'resu\InjuryController@deleteExternalInjury')->name('delete-external');

Route::get('patientInjury', 'resu\PatientInjuryController@PatientInjured')->name('patientInjury');
Route::get('/search-patient-injured', 'resu\PatientInjuryController@PatientInjured')->name('search.patient_injured'); // for search imjury
Route::get('sublist-patient/{id}', 'resu\PatientInjuryController@SublistPatient');
Route::get('patient-form', 'resu\PatientInjuryController@PatientForm');

Route::get('/body-parts', 'resu\InjuryController@Listbodyparts')->name('body-parts');
Route::post('/delete-body-parts', 'resu\InjuryController@deleteBodyPart')->name('delete-body-parts');

//check profile resu client
Route::get('get/checkprofiles', 'resu\ClientVerifyController@CheckClients')->name('get.checkprofiles');

//get municipal && province
Route::get('sublist-patient/get/municipal/{id}', 'resu\PatientInjuryController@getMunicipal');
Route::get('sublist-patient/get/barangay/{id}', 'resu\PatientInjuryController@getBarangay');

Route::get('get/municipal/{id}', 'resu\PatientInjuryController@getMunicipal');
Route::get('get/barangay/{id}', 'resu\PatientInjuryController@getBarangay');

//add patient injury
Route::post('submit-patient-form', 'resu\PatientInjuryController@SubmitPatientInjury')->name('submit-patient-form');
Route::post('update-patient-form', 'resu\PatientInjuryController@UpdatePatientInjury')->name('update-patient-form');

//accident type
Route::get('accidentType', 'resu\InjuryController@viewAccident')->name("accidentType");
Route::post('add-accident-type', 'resu\InjuryController@AddAccidenttype')->name("add-accident-type");
Route::post('delete-accident-type','resu\InjuryController@deleteAccidentType')->name("delete-accident-type");
Route::get('edit-accident-type/{id}','resu\InjuryController@editAccidentType')->name("edit-accident-type");
Route::post('update-accident-type/{id}','resu\InjuryController@updateAccidentType')->name("update-accident-type");

Route::get('hospital', 'resu\HospitalController@index')->name('hospital');
Route::post('add-hospital', 'resu\HospitalController@SaveHospital')->name('add-hospital');

Route::get('viewSafety', 'resu\InjuryController@safetyView')->name("viewSafety");
Route::post('addSafety', 'resu\InjuryController@Savesafety')->name("addSafety");
//for tsekap route
Route::get('user/population/head','ClientCtrl@addHeadProfile');

//delete nature injury categories
Route::post('/delete-nature', 'resu\PatientInjuryController@Deletenature')->name('delete-nature');

Route::get('view-Import', 'resu\ExcelPatientInjuryController@ViewImport');
Route::post('/import-excel', 'resu\ExcelPatientInjuryController@import')->name('import.excel');

// users
Route::get('viewUsers', 'resu\UsersCtrl@index')->name('resu.admin.view_Users');
Route::post('add-users', 'resu\UsersCtrl@AddUsers');
Route::post('users-search','resu\UsersCtrl@SearchUsers')->name('users-search');
Route::post('/admin/delete_user', 'resu\UsersCtrl@deleteUser')->name('resu.admin.delete_user');
Route::post('/update/User{id}', 'resu\UsersCtrl@updateUser')->name('update-User');

// csv files patient injury
Route::get('/export/csv', 'resu\ExcelPatientInjuryController@exportCSV')->name('export.csv');


//risk assessment 
Route::get('/RiskAssessment', function () {
    return view('risk\riskAssessment'); // Assuming the view file is 'resources/views/riskassessment.blade.php'
})->name('riskassessment');

//risk get profile verification
Route::get('get/riskCheckProfile', 'risk\RiskClientVerificationController@riskCheckClient')->name('get.riskcheckprofiles');
Route::get('get/riskGetSpecificProfile', 'risk\RiskClientExtractionController@riskGetSpecificClient')->name('get.riskgetspecificprofile');
Route::post('/submit-risk-profile', 'risk\RiskProfileController@SubmitRiskPForm')->name('submit-patient-risk-form');
