@extends('client')
@section('content')
    <style>
        .family {
            font-size: 0.9em;
        }
        .family label {
            font-weight: bold;
        }
        .family .info {
            color: #337ab7;
        }
        .family .sub-info {
            font-style: italic;
            color: #a94442;
        }
    </style>
    <div class="row " style="color:rgba(0,0,0,0.75);">
        <form action="{{ asset('deng/save') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-md-12">
                <div class="alert alert-jim">
                    <h3 class="text-info">Dengvaxia Vaccinee Health Profile</h3>
                    <input type="hidden" name="profile_id" value="{{ $profile->main_id }}">
                    @include('dengvaxiav2.form.page1',['some' => 'data'])
                    @include('dengvaxiav2.form.page2')
                    @include('dengvaxiav2.form.page3')
                    @include('dengvaxiav2.form.page4')

                </div>
            </div>
        </form>
    </div>
    @include('modal.populationModal')
@endsection

@section('js')
    <script>
        var hospital_history_count = "<?php echo Session::get('host_count'); ?>";
        console.log(hospital_history_count);
        function addHospitalHistory(){
            event.preventDefault();
            var html_append = "<tr id='hospital_history_tr"+hospital_history_count+"'>\n" +
                "                            <td><b>"+hospital_history_count+"</b></td>\n" +
                "                            <td><input type=\"text\" name='hos_reason[]' class=\"form-control\"></td>\n" +
                "                            <td><input type=\"date\" name='hos_date[]' class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" name='hos_place[]' class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" name='hos_phic[]' class=\"form-control\"></td>\n" +
                "                            <td><input type=\"text\" name='hos_cost[]' class=\"form-control\"></td>\n" +
                "                            <td><i class='fa fa-trash-o text-red hos_row' style='cursor: pointer;' onclick='removeHospitalHistory($(this))'></i></td>" +
                "                        </tr>";
            $("#hospital_history_row").append(html_append);
            $("#hospital_history_tr"+hospital_history_count).hide().fadeIn();
            hospital_history_count++;
        }

        function removeHospitalHistory(element){
            element.parent().parent().fadeOut("slow", function() {
                element.parent().parent().remove();
            });
        }

        var past_surgical_history_count = 0;
        function addPastSurgicalHistory(){
            event.preventDefault();
            var html_append = "<tr id='past_surgical_history"+past_surgical_history_count+"'>\n" +
                "                        <td>\n" +
                "                            <small class=\" \">Operation</small>\n" +
                "                            <input type=\"text\" name='sur_operation[]' class=\"form-control\" >\n" +
                "                        </td>\n" +
                "                        <td>\n" +
                "                            <small class=\" \">Date</small>\n" +
                "                            <input type=\"date\" name='sur_date[]' class=\"form-control\" >\n" +
                "                        </td>\n" +
                "                         <td>" +
                "                            <br>\n" +
                "                            <i class='fa fa-trash-o text-red' style='cursor: pointer;' onclick='removePastSurgicalHistory($(this))'></i>" +
                "                         </td>" +
                "               </tr>";
            $("#past_surgical_row").append(html_append);
            $("#past_surgical_history"+past_surgical_history_count).hide().fadeIn();
            past_surgical_history_count++;
        }

        function removePastSurgicalHistory(element){
            element.parent().parent().fadeOut("slow", function() {
                element.parent().parent().remove();
            });
        }

        function changeGender(form){
            var gender = form.val();
            $("input[name=sex]").prop('checked',false);
            if(gender == 'Son' || gender == 'Husband' || gender == 'Father' || gender == 'Brother' || gender == 'Nephew' || gender == 'Grandfather' || gender == 'Grandson' || gender == 'Brother in Law' || gender == 'Son in Law' || gender == 'Father in Law')
            {
                gender = 'Male';
            }
            else if(gender == 'Daughter' || gender == 'Wife' || gender == 'Mother' || gender == 'Sister' || gender == 'Niece' || gender == 'Grandmother' || gender == 'Granddaughter' || gender == 'Sister in Law' || gender == 'Daughter in Law' || gender == 'Mother in Law')
            {
                gender = 'Female';
            }
            console.log(gender);
            $("input[name=sex][value=" + gender + "]").prop('checked',true);
        }

        calculateAge();
        $('#dob').on('keyup','keydown',function(){
            calculateAge();
        });
        function calculateAge(){
            var dob = $('#dob').val();
            if(!dob){
                dob = "{{ date('Y-m-d') }}";
            }
            console.log(dob);
            $.ajax({
                url : "{{ url('user/profile/age/') }}/"+dob,
                type : 'GET',
                success: function(age){
                    console.log(age)
                    $("#age").val(age);
                }
            });
        }

        function loadLoadingModal(){
            $('#loading_page').modal('show');
        }

    </script>
@endsection