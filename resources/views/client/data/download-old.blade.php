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
                    var totalStatus = data.countStatus;
                    var totalPage = totalProfile + totalServices + totalCases + totalOptions + totalStatus;

                    var perProfile = 0;
                    var perService = 0;
                    var perCase = 0;
                    var perOption = 0;
                    var perStatus = 0;

                    var offset = 0;
                    var i = 0;
                    var c = 0;
                    var add = 0;

                    var tmp = 0;

                    var header = [];
                    var data = [];
                    var servicesHeader = [];
                    var servicesData = [];
                    var casesHeader = [];
                    var casesData = [];
                    var statusHeader = [];
                    var statusData = [];
                    var optionsHeader = [];
                    var optionsData = [];

                    progress();

                    function progress() {
                        /*
                         * Get the table headers, this will be CSV headers
                         * The count of headers will be CSV string separator
                         */
                        header = [
                            'FAMILY ID',
                            'HEAD',
                            'RELATION',
                            'FIRST NAME',
                            'MIDDLE NAME',
                            'LAST NAME',
                            'SUFFIX',
                            'BIRTHDAY',
                            'SEX',
                            'BARANGAY ID',
                            'MUNICIPAL / CITY ID',
                            'PROVINCE ID'
                        ];

                        perProfile = data.length/header.length;
                        i = perProfile;
                        add = (i/totalPage) * 100;
                        add = parseInt(add);
                        if(add>=100){
                            add = 100;
                        }

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
                            var offsetUrl = "<?php echo url('user/download/old/data/'); ?>";
                            $.ajax({
                                url : offsetUrl+'/'+offset,
                                type: 'GET',
                                success: function(result){
                                    /*
                                     * Get the actual data, this will contain all the data, in 1 array
                                     */
                                    $.each(result.data, function(i,obj){
                                        data.push(obj.familyID);
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
                            'DATE CREATED',
                            'FIRST NAME',
                            'MIDDLE NAME',
                            'LAST NAME',
                            'SUFFIX',
                            'SERVICE ID',
                            'BRACKET ID',
                            'BARANGAY ID',
                            'MUNICIPAL / CITY ID',
                        ];

                        perService = servicesData.length/servicesHeader.length;
                        i = perProfile+perService;
                        add = (i/totalPage) * 100;
                        add = parseInt(add);
                        if(add>=100){
                            add = 100;
                        }

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
                            var offsetUrl = "<?php echo url('user/download/old/services/'); ?>";
                            $.ajax({
                                url : offsetUrl+'/'+year+'/'+offset,
                                type: 'GET',
                                success: function(result){
                                    /*
                                     * Get the actual data, this will contain all the data, in 1 array
                                     */
                                    $.each(result.data, function(i,obj){
                                        servicesData.push(obj.dateProfile);
                                        servicesData.push(obj.fname);
                                        servicesData.push(obj.mname);
                                        servicesData.push(obj.lname);
                                        servicesData.push(obj.suffix);
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
                            'DATE CREATED',
                            'FIRST NAME',
                            'MIDDLE NAME',
                            'LAST NAME',
                            'SUFFIX',
                            'CASE ID',
                            'BRACKET ID',
                            'BARANGAY ID',
                            'MUNICIPAL / CITY ID',
                        ];

                        perCase = casesData.length/casesHeader.length;
                        i = perProfile+perService+perCase;
                        add = (i/totalPage) * 100;
                        add = parseInt(add);
                        if(add>=100){
                            add = 100;
                        }

                        if(perCase>=totalCases){
                            offset = 0;
                            $('.progress-bar').html(add+'%');
                            $('.progress-bar').css('width',add+'%');
                            $('.download-text').html('Exporting diagnoses data ('+ i + ' of ' + totalPage+')...');
                            progressStatus();

                        }else{
                            $('.progress-bar').html(add+'%');
                            $('.progress-bar').css('width',add+'%');

                            //ajax call for exporting data
                            var offsetUrl = "<?php echo url('user/download/old/cases/'); ?>";
                            $.ajax({
                                url : offsetUrl+'/'+year+'/'+offset,
                                type: 'GET',
                                success: function(result){
                                    /*
                                     * Get the actual data, this will contain all the data, in 1 array
                                     */
                                    $.each(result.data, function(i,obj){
                                        casesData.push(obj.dateProfile);
                                        casesData.push(obj.fname);
                                        casesData.push(obj.mname);
                                        casesData.push(obj.lname);
                                        casesData.push(obj.suffix);
                                        casesData.push(obj.case_id);
                                        casesData.push(obj.bracket_id);
                                        casesData.push(obj.barangay_id);
                                        casesData.push(obj.muncity_id);
                                    });
                                }
                            });
                            offset += 100;
                            $('.download-text').html('Exporting diagnoses data ('+ i + ' of ' + totalPage+')...');
                            setTimeout(progressCases,1000);
                        }
                    }

                    function progressStatus(){
                        /*
                         * Get the table headers, this will be CSV headers
                         * The count of headers will be CSV string separator
                         */
                        statusHeader = [
                            'DATE CREATED',
                            'FIRST NAME',
                            'MIDDLE NAME',
                            'LAST NAME',
                            'SUFFIX',
                            'STATUS',
                            'CODE',
                            'BARANGAY ID',
                            'MUNICIPAL / CITY ID'
                        ];

                        perStatus = statusData.length/statusHeader.length;
                        i = perProfile+perService+perCase+perStatus;
                        add = (i/totalPage) * 100;
                        add = parseInt(add);
                        if(add>=100){
                            add = 100;
                        }

                        if(perStatus>=totalStatus){
                            offset = 0;
                            $('.progress-bar').html(add+'%');
                            $('.progress-bar').css('width',add+'%');
                            $('.download-text').html('Exporting diagnoses data ('+ i + ' of ' + totalPage+')...');
                            progressOptions();

                        }else{
                            $('.progress-bar').html(add+'%');
                            $('.progress-bar').css('width',add+'%');

                            //ajax call for exporting data
                            var offsetUrl = "<?php echo url('user/download/old/status/'); ?>";
                            $.ajax({
                                url : offsetUrl+'/'+year+'/'+offset,
                                type: 'GET',
                                success: function(result){
                                    /*
                                     * Get the actual data, this will contain all the data, in 1 array
                                     */
                                    $.each(result.data, function(i,obj){
                                        statusData.push(obj.dateProfile);
                                        statusData.push(obj.fname);
                                        statusData.push(obj.mname);
                                        statusData.push(obj.lname);
                                        statusData.push(obj.suffix);
                                        statusData.push(obj.status);
                                        statusData.push(obj.code);
                                        statusData.push(obj.barangay_id);
                                        statusData.push(obj.muncity_id);
                                    });
                                }
                            });
                            offset += 100;
                            console.log(statusData);
                            $('.download-text').html('Exporting status data ('+ i + ' of ' + totalPage+')...');
                            setTimeout(progressStatus,1000);
                        }
                    }

                    function progressOptions(){
                        /*
                         * Get the table headers, this will be CSV headers
                         * The count of headers will be CSV string separator
                         */
                        optionsHeader = [
                            'DATE CREATED',
                            'FIRST NAME',
                            'MIDDLE NAME',
                            'LAST NAME',
                            'SUFFIX',
                            'OPTION',
                            'STATUS',
                            'BARANGAY ID',
                            'MUNICIPAL / CITY ID'
                        ];

                        perOption = optionsData.length/optionsHeader.length;
                        i = perProfile + perService + perCase + perOption + perStatus;
                        add = (i/totalPage) * 100;
                        add = parseInt(add);
                        if(add>=100){
                            add = 100;
                        }
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
                            var offsetUrl = "<?php echo url('user/download/old/options/'); ?>";
                            $.ajax({
                                url : offsetUrl+'/'+year+'/'+offset,
                                type: 'GET',
                                success: function(result){
                                    /*
                                     * Get the actual data, this will contain all the data, in 1 array
                                     */
                                    $.each(result.data, function(i,obj){
                                        optionsData.push(obj.dateProfile);
                                        optionsData.push(obj.fname);
                                        optionsData.push(obj.mname);
                                        optionsData.push(obj.lname);
                                        optionsData.push(obj.suffix);
                                        optionsData.push(obj.option);
                                        optionsData.push(obj.status);
                                        optionsData.push(obj.barangay_id);
                                        optionsData.push(obj.muncity_id);
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
                            var CSVString = prepCSVRow(['PROFILE'], 1, '');
                            CSVString = prepCSVRow(header, header.length, CSVString);
                            CSVString = prepCSVRow(data, header.length, CSVString);
                            CSVString = prepCSVRow(['SERVICES'], 1, CSVString);
                            CSVString = prepCSVRow(servicesHeader, servicesHeader.length, CSVString);
                            CSVString = prepCSVRow(servicesData, servicesHeader.length, CSVString);
                            CSVString = prepCSVRow(['CASES'], 1, CSVString);
                            CSVString = prepCSVRow(casesHeader, casesHeader.length, CSVString);
                            CSVString = prepCSVRow(casesData, casesHeader.length, CSVString);
                            CSVString = prepCSVRow(['STATUS'], 1, CSVString);
                            CSVString = prepCSVRow(statusHeader, statusHeader.length, CSVString);
                            CSVString = prepCSVRow(statusData, statusHeader.length, CSVString);
                            CSVString = prepCSVRow(['SERVICE OPTION'], 1, CSVString);
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
                            downloadLink.download = file+".DOH7";

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
            var url = "<?php echo url('user/download/old/data/countprofile');?>";
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