<?php
    use Illuminate\Support\Facades\Auth;
?>

@extends('client')
@section('content')
    <style>
        .loadingbar {
            color:#00acd6;
            font-style: italic;
            font-weight: bold;
            margin-top: 0px;
        }
        .progress {
            margin-bottom: 5px;
        }
    </style>
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Download Data</h2>
            <form class="form-inline" method="POST" action="{{ asset('user/download/data') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <select class="form-control chosen-select-static" id="year">
                        <option value="">Select Year</option>
                        <?php $year = date('Y'); ?>
                        @for($i=0;$i<10;$i++)
                            <option>{{ $year-- }}</option>
                        @endfor
                    </select>

                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success col-xs-12 btn-submit"><i class="fa fa-download"></i> Download</button>
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="page-divider"></div>
            <div class="progress-section hide">
                <div class="progress">
                    <div class="progress-bar progress-bar-bg progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                </div>
                <div class="loadingbar">
                    <font class="download-text">Exporting Data...</font>
                </div>
            </div>
            <div class="alert alert-danger error hide">
                <font class="text-danger">Please select year first!</font>
            </div>
        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')
<script>
    $('.btn-submit').on('click',function(){
        var year = $('#year').val();
        if(year){
            $('.error').addClass('hide');
            $(this).attr('disabled',true);
            $('.progress-bar').addClass('progress-bar-animated');
            $('.progress-bar').addClass('progress-bar-striped');
            $('.progress-bar').removeClass('progress-bar-success');
            $('.progress-section').removeClass('hide');

            countProfile(year,function(data){

                var totalProfile = data.count;
                var totalServices = data.countServices;
                var totalCases = data.countCases;
                var totalOptions = data.countOptions;
                var totalPage = totalProfile + totalServices + totalCases + totalOptions;

                var perProfile = 0;
                var perService = 0;
                var perCase = 0;
                var perOption = 0;

                var offset = 0;
                var i = 0;
                var c = 0;
                var add = 0;

                var tmp = 0;

                var version = ['version1.4'];
                var header = [];
                var data = [];
                var servicesHeader = [];
                var servicesData = [];
                var casesHeader = [];
                var casesData = [];
                var optionsHeader = [];
                var optionsData = [];

                progress();

                function progress() {
                    /*
                     * Get the table headers, this will be CSV headers
                     * The count of headers will be CSV string separator
                     */
                    header = [
                            'unique_id',
                            'Family ID',
                            'PHIC ID',
                            'NHTS ID',
                            'Head',
                            'Relation',
                            'First Name',
                            'Middle Name',
                            'Last Name',
                            'Suffix',
                            'DOB',
                            'Sex',
                            'Barangay',
                            'Muncity',
                            'Province',
                            'Family Income',
                            'Unmet Need',
                            'Water Supply',
                            'Sanitary Toilet',
                            'Education'
                        ];

                    perProfile = data.length/header.length;
                    i = perProfile;
                    add = (i/totalPage) * 100;
                    add = parseInt(add);

                    if(perProfile>=totalProfile){
                        offset = 0;
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');
                        $('.download-text').html('Exporting profile data ('+ i + ' of ' + totalPage+')...');
                        progressServices();

                    }else{
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');

                        //ajax call for exporting data
                        var offsetUrl = "<?php echo url('user/download/data/'); ?>";
                        $.ajax({
                            url : offsetUrl+'/'+offset,
                            type: 'GET',
                            success: function(result){
                                /*
                                 * Get the actual data, this will contain all the data, in 1 array
                                 */
                                $.each(result.data, function(i,obj){
                                    data.push(obj.unique_id);
                                    data.push(obj.familyID);
                                    data.push(obj.phicID);
                                    data.push(obj.nhtsID);
                                    data.push(obj.head);
                                    data.push(obj.relation);
                                    data.push(obj.fname);
                                    data.push(obj.mname);
                                    data.push(obj.lname);
                                    data.push(obj.suffix);
                                    data.push(obj.dob);
                                    data.push(obj.sex);
                                    data.push(obj.barangay_id);
                                    data.push(obj.muncity_id);
                                    data.push(obj.province_id);
                                    data.push(obj.income);
                                    data.push(obj.unmet);
                                    data.push(obj.water);
                                    data.push(obj.toilet);
                                    data.push(obj.education);
                                });
                            }
                        });
                        offset += 100;
                        $('.download-text').html('Exporting profile data ('+ i + ' of ' + totalPage+')...');
                        setTimeout(progress,1000);
                    }
                }

                function progressServices(){
                    /*
                     * Get the table headers, this will be CSV headers
                     * The count of headers will be CSV string separator
                     */
                    servicesHeader = [
                        'unique_id',
                        'sex',
                        'status',
                        'dateProfile',
                        'profile_id',
                        'service_id',
                        'bracket_id',
                        'barangay_id',
                        'muncity_id'
                    ];

                    perService = servicesData.length/servicesHeader.length;
                    i = perProfile+perService;
                    add = (i/totalPage) * 100;
                    add = parseInt(add);

                    if(perService>=totalServices){
                        offset = 0;
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');
                        $('.download-text').html('Exporting services data ('+ i + ' of ' + totalPage+')...');
                        progressCases();

                    }else{
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');

                        //ajax call for exporting data
                        var offsetUrl = "<?php echo url('user/download/services/'); ?>";
                        $.ajax({
                            url : offsetUrl+'/'+year+'/'+offset,
                            type: 'GET',
                            success: function(result){
                                /*
                                 * Get the actual data, this will contain all the data, in 1 array
                                 */
                                $.each(result.data, function(i,obj){
                                    servicesData.push(obj.unique_id);
                                    servicesData.push(obj.sex);
                                    servicesData.push(obj.status);
                                    servicesData.push(obj.dateProfile);
                                    servicesData.push(obj.profile_id);
                                    servicesData.push(obj.service_id);
                                    servicesData.push(obj.bracket_id);
                                    servicesData.push(obj.barangay_id);
                                    servicesData.push(obj.muncity_id);
                                });
                            }
                        });
                        offset += 100;
                        $('.download-text').html('Exporting services data ('+ i + ' of ' + totalPage+')...');
                        setTimeout(progressServices,1000);
                    }
                }

                function progressCases(){
                    /*
                     * Get the table headers, this will be CSV headers
                     * The count of headers will be CSV string separator
                     */
                    casesHeader = [
                        'unique_id',
                        'dateProfile',
                        'profile_id',
                        'sex',
                        'status',
                        'barangay_id',
                        'muncity_id',
                        'bracket_id',
                        'case_id'
                    ];

                    perCase = casesData.length/casesHeader.length;
                    i = perProfile+perService+perCase;
                    add = (i/totalPage) * 100;
                    add = parseInt(add);

                    if(perCase>=totalCases){
                        offset = 0;
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');
                        $('.download-text').html('Exporting diagnoses data ('+ i + ' of ' + totalPage+')...');
                        progressOptions();

                    }else{
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');

                        //ajax call for exporting data
                        var offsetUrl = "<?php echo url('user/download/cases/'); ?>";
                        $.ajax({
                            url : offsetUrl+'/'+year+'/'+offset,
                            type: 'GET',
                            success: function(result){
                                /*
                                 * Get the actual data, this will contain all the data, in 1 array
                                 */
                                $.each(result.data, function(i,obj){
                                    casesData.push(obj.unique_id);
                                    casesData.push(obj.dateProfile);
                                    casesData.push(obj.profile_id);
                                    casesData.push(obj.sex);
                                    casesData.push(obj.status);
                                    casesData.push(obj.barangay_id);
                                    casesData.push(obj.muncity_id);
                                    casesData.push(obj.bracket_id);
                                    casesData.push(obj.case_id);
                                });
                            }
                        });
                        offset += 100;
                        $('.download-text').html('Exporting diagnoses data ('+ i + ' of ' + totalPage+')...');
                        setTimeout(progressCases,1000);
                    }
                }

                function progressOptions(){
                    /*
                     * Get the table headers, this will be CSV headers
                     * The count of headers will be CSV string separator
                     */
                    optionsHeader = [
                        'unique_id',
                        'dateProfile',
                        'profile_id',
                        'barangay_id',
                        'muncity_id',
                        'option',
                        'status'
                    ];

                    perOption = optionsData.length/optionsHeader.length;
                    i = perProfile + perService + perCase + perOption;
                    add = (i/totalPage) * 100;
                    add = parseInt(add);

                    if(perOption>=totalOptions){
                        offset = 0;
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');
                        $('.download-text').html('Exporting options data ('+ i + ' of ' + totalPage+')...');
                        exportCSV();

                    }else{
                        $('.progress-bar').html(add+'%');
                        $('.progress-bar').css('width',add+'%');

                        //ajax call for exporting data
                        var offsetUrl = "<?php echo url('user/download/options/'); ?>";
                        $.ajax({
                            url : offsetUrl+'/'+year+'/'+offset,
                            type: 'GET',
                            success: function(result){
                                /*
                                 * Get the actual data, this will contain all the data, in 1 array
                                 */
                                $.each(result.data, function(i,obj){
                                    optionsData.push(obj.unique_id);
                                    optionsData.push(obj.dateProfile);
                                    optionsData.push(obj.profile_id);
                                    optionsData.push(obj.barangay_id);
                                    optionsData.push(obj.muncity_id);
                                    optionsData.push(obj.option);
                                    optionsData.push(obj.status);
                                });
                            }
                        });
                        offset += 100;
                        $('.download-text').html('Exporting diagnoses data ('+ i + ' of ' + totalPage+')...');
                        setTimeout(progressOptions,1000);
                    }
                }

                function exportCSV(){
                    $('.download-text').html('Preparing Data...');
                    setTimeout(function(){
                        $('.progress-bar').removeClass('progress-bar-animated');
                        $('.progress-bar').removeClass('progress-bar-striped');
                        $('.progress-bar').addClass('progress-bar-success');
                        $('.progress-bar').html('Complete');
                        $('.download-text').html('Export Complete');
                        $('.btn-submit').attr('disabled',false);

                        /*
                         * Convert our data to CSV string
                         */
                        var CSVString = prepCSVRow(version, version.length, '');
                        CSVString = prepCSVRow(['PROFILES'], 1, CSVString);
                        CSVString = prepCSVRow(header, header.length, CSVString);
                        CSVString = prepCSVRow(data, header.length, CSVString);
                        CSVString = prepCSVRow(['SERVICES'], 1, CSVString);
                        CSVString = prepCSVRow(servicesHeader, servicesHeader.length, CSVString);
                        CSVString = prepCSVRow(servicesData, servicesHeader.length, CSVString);
                        CSVString = prepCSVRow(['CASES'], 1, CSVString);
                        CSVString = prepCSVRow(casesHeader, casesHeader.length, CSVString);
                        CSVString = prepCSVRow(casesData, casesHeader.length, CSVString);
                        CSVString = prepCSVRow(['OPTIONS'], 1, CSVString);
                        CSVString = prepCSVRow(optionsHeader, optionsHeader.length, CSVString);
                        CSVString = prepCSVRow(optionsData, optionsHeader.length, CSVString);

                        /*
                         * Make CSV downloadable
                         */
                        var downloadLink = document.createElement("a");
                        var blob = new Blob(["\ufeff", CSVString]);
                        var url = URL.createObjectURL(blob);
                        downloadLink.href = url;
                        var file = "<?php echo Auth::user()->username; ?>";
                        downloadLink.download = file+".DOH7v1-4";

                        /*
                         * Actually download CSV
                         */
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);

                    },2000);
                }

            });
        }else{
            $('.error').removeClass('hide');
        }

    });

    function countProfile(year, callback)
    {
        var url = "<?php echo url('user/download/data/countprofile');?>";
        $.ajax({
            url: url+'/'+year,
            dataType: 'json',
            type: 'GET',
            success: callback
        });
    }

    function prepCSVRow(arr, columnCount, initial) {
        var row = ''; // this will hold data
        var delimeter = ','; // data slice separator, in excel it's `;`, in usual CSv it's `,`
        var newLine = '\r\n'; // newline separator for CSV row

        /*
         * Convert [1,2,3,4] into [[1,2], [3,4]] while count is 2
         * @param _arr {Array} - the actual array to split
         * @param _count {Number} - the amount to split
         * return {Array} - splitted array
         */
        function splitArray(_arr, _count) {
            var splitted = [];
            var result = [];
            _arr.forEach(function(item, idx) {
                if ((idx + 1) % _count === 0) {
                    splitted.push(item);
                    result.push(splitted);
                    splitted = [];
                } else {
                    splitted.push(item);
                }
            });
            return result;
        }
        var plainArr = splitArray(arr, columnCount);
        // don't know how to explain this
        // you just have to like follow the code
        // and you understand, it's pretty simple
        // it converts `['a', 'b', 'c']` to `a,b,c` string
        plainArr.forEach(function(arrItem) {
            arrItem.forEach(function(item, idx) {
                row += item + ((idx + 1) === arrItem.length ? '' : delimeter);
            });
            row += newLine;
        });
        return initial + row;
    }

</script>

@endsection