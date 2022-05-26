<?php
$counter = 0;
$user_facilities = \App\Http\Controllers\SpecialistCtrl::getUserFacilities($data->user_id);
$faci_count = 0;
?>

{{--BUG:

    When this modal is shown, there will be a space incurred in the right side of the UI, it will stay there unless
    the page is refreshed and if this modal is shown continuously WITHOUT refreshing the page, that space will grow.

    - Christine 05/24/2022 4:32 pm
--}}

<style>
    .faci_table {
        table-layout: fixed !important;
    }
</style>

<form method="POST" action="{{ asset('specialist/add') }}" id="add_new_specialist">
    {{ csrf_field() }}
    <input type="hidden" id="special_id" name="user_id" value="{{ $data->user_id }}" />
    <fieldset><legend>
        @if(isset($data->user_id))
            <i class="fa fa-user-md"></i> Update Health Specialist
        @else
            <i class="fa fa-user-plus"></i> Add Health Specialist
        @endif
    </legend></fieldset>
    <div class="form-group">
        <label>First Name:</label>
        <input type="text" class="form-control" id="input_fname" autofocus name="fname" value="@if(isset($data->fname)){{$data->fname}}@endif" required>
    </div>
    <div class="form-group">
        <label>Middle Name:</label>
        <input type="text" class="form-control" id="input_mname" name="mname" value="@if(isset($data->mname)){{$data->mname}}@endif">
    </div>
    <div class="form-group">
        <label>Last Name:</label>
        <input type="text" class="form-control" id="input_lname" name="lname" value="@if(isset($data->lname)){{ $data->lname}}@endif" required>
    </div>
    <div class="form-group">
        <label>Affiliated Facilities: </label>
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-bordered table-striped faci_table" id="facility_table" onshow="disableRemoveBtn()">
                <thead>
                <tr style="font-size: 12px;">
                    <th class="text-center" style="white-space: nowrap; width:150px;">Facility Name</th>
                    <th class="text-center" style="width:150px;">Specialization</th>
                    <th class="text-center" style="width:120px;">Contact Number</th>
                    <th class="text-center" style="width:170px;">Email Address</th>
                    <th class="text-center" style="width:200px;">Schedule</th>
                    <th class="text-center" style="width:120px">Specialist Fee</th>
                    <th class="text-center" style="width:100px">Action</th>
                </tr>
                </thead>
                @if(count($user_facilities) > 0)
                    @foreach($user_facilities as $f)
                        <?php $faci_count++; ?>
                        <input type="hidden" name="remove_facility[]" value='' class="remove_facility{{$counter}}">
                        <tr style="font-size: 10pt" class="faci_apil{{$counter}}">
                            <td>
                                <small>
                                    <select class="form-control select2" id="facility" name="affil_faci[]" style="width: 100%">
                                        <option value="">Select...</option>
                                        @foreach($facilities as $faci)
                                            <option <?php if($faci->facility_id == $f->facility_id) echo 'selected'?> value="{{  $faci->facility_id }}">{{ $faci->facility_name }}</option>
                                        @endforeach
                                    </select>
                                </small>
                            </td>
                            <td>
                                <input type="text" value="{{ $f->specialization }}" name="specialization[]" placeholder="Enter specialization..." style="font-size: 12px; width:100%;">
                            </td>
                            <td>
                                <input type="text" value="{{ $f->contact }}" name="contact[]" style="font-size: 12px; width:100%;">
                            </td>
                            <td>
                                <input type="text" value="{{ $f->email }}" name="email[]" style="font-size: 12px; width:100%;"{{--value="@if(isset($data->email)) {{ $data->email }} @endif"--}}>
                            </td>
                            <td>
                                <textarea class="form-control" cols="200" name="schedule[]" style="resize: none; width: 100%; font-size: 12px" rows="2" placeholder="Enter schedule...">{{ $f->schedule }}</textarea>
                            </td>
                            <td>
                                <small><input class="money_format{{$counter}}" value="{{ $f->fee }}" oninput="formatMoney({{$counter}})" type="text" name="specialist_fee[]" placeholder="Enter fee..." style="width: 100%"></small>
                            </td>
                            <td>
                                <button class="btn-xs btn-danger text-center" id="btn_remove{{$counter}}" value="{{ $f->facility_id }}" onclick="removeFacility({{$counter++}})"type="button" style="width: 100%">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="font-size: 10pt" class="faci_apil{{$counter}}">
                        <?php $faci_count++; ?>
                        <input type="hidden" name="remove_facility[]" value='' class="remove_facility{{$counter}}">
                        <td>
                            <small>
                                <select class="form-control select2" id="facility" name="affil_faci[]" style="width: 100%">
                                    <option value="">Select...</option>
                                    @foreach($facilities as $f)
                                        <option value="{{  $f->facility_id }}">{{ $f->facility_name }}</option>
                                    @endforeach
                                </select>
                            </small>
                        </td>
                        <td>
                            <input type="text" name="specialization[]" placeholder="Enter specialization..." style="font-size: 12px; width:100%;">
                        </td>
                        <td>
                            <input type="text" name="contact[]" style="font-size: 12px; width:100%;">
                        </td>
                        <td>
                            <input type="text" name="email[]" style="font-size: 12px; width:100%;"{{--value="@if(isset($data->email)) {{ $data->email }} @endif"--}}>
                        </td>
                        <td>
                            <textarea class="form-control" cols="200" name="schedule[]" style="resize: none; width: 100%; font-size: 12px" rows="2" placeholder="Enter schedule..."></textarea>
                        </td>
                        <td>
                            <small><input class="money_format{{$counter}}" oninput="formatMoney({{$counter}})" type="text" name="specialist_fee[]" placeholder="Enter fee..." style="width: 100%"></small>
                        </td>
                        <td>
                            <button class="btn-xs btn-danger text-center" id="btn_remove{{$counter}}" onclick="removeFacility({{$counter++}})"type="button" style="width: 100%">Remove</button>
                        </td>
                    </tr>
                @endif
            </table>
        </div><br>
        <div class="text-center">
            <button class="btn-xs btn-warning text-center" id="facility_add_row" type="button">
                <i class="fa fa-plus"> Add Row</i>
            </button><br><br>
        </div>
    </div>
    <hr />

    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        @if(isset($data->user_id))
            <a href="#remove_specialist" data-toggle="modal" class="btn btn-danger btn-sm btn-flat" onclick="SpecialistDelete('{{ $data->user_id }}', '{{ $data->fname }}', '{{ $data->lname }}')">
                <i class="fa fa-trash"></i> Remove
            </a>
        @endif
        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
    </div>
</form>

<script>
    $(".select2").select2({ width: '100%' });

    var user_id = '{{ $data->user_id }}';
    console.log("user_id: " + user_id);

    if(user_id == ''){
        $('#checkUserProfile').modal({backdrop: 'static', keyboard: false});
    }

    /*  ____________________
    *   |  CURRENCY FORMAT |
    *   --------------------
    */
    function formatMoney(pos) {
        money = $('.money_format'+pos).val();
        $('.money_format'+pos).val(transformString(money));
    }

    function transformString(str) {
        str = str.replace(/[^0-9]/g, '');

        integer = str.slice(0, str.length-2).toLocaleString();
        decimal = str.slice(-2);

        final = "PHP " + integer + '.' + decimal;
        final = final.replace(/\d(?=(\d{3})+\.)/g, '$&,');
        return final;
    }

    /*  _____________________________________
    *   |  ADD/REMOVE AFFILIATED FACILITIES |
    *   -------------------------------------
    */
    counter = {{ $counter }};
    faci_count = {{ $faci_count }};

    function removeFacility(pos) {
        $('.faci_apil'+pos).prop('disabled', true);
        $('.faci_apil'+pos).hide();
        $('.remove_facility'+pos).val($('#btn_remove'+pos).val());
        faci_count -= 1;
        disableRemoveBtn();
    }

    disableRemoveBtn();
    function disableRemoveBtn() {
        for(var i = 0; i <= counter; i++) {
            if(faci_count > 1)
                $('#btn_remove'+i).show();
            else
                $('#btn_remove'+i).hide();
        }
    }

    $('#facility_add_row').on('click', function() {
        faci_count += 1;
        string =
            '<tr style="font-size: 10pt" class="faci_apil'+counter+'">\n' +
            '                    <input type="hidden" name="remove_facility[]" value="" class="remove_facility'+counter+'">\n' +
            '                    <td><small>\n' +
            '                        <select class="form-control select2" name="affil_faci[]" style="width: 100%">\n' +
            '                            <option value="">Select...</option>\n';

        @foreach($facilities as $f)
            id = '{{ $f->facility_id }}';
            name = '{{ $f->facility_name }}';
            string += "<option value="+id+">"+name+"</option>";
        @endforeach

        string +=
            '                        </select></small>\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input type="text" name="specialization[]" placeholder="Enter specialization..." style="font-size: 12px; width:100%;">\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input type="text" name="contact[]" style="font-size: 12px; width:100%;">\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input type="text" name="email[]" style="font-size: 12px; width:100%;"{{--value="@if(isset($data->email)) {{ $data->email }} @endif"--}}>\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <textarea class="form-control" cols="200" name="schedule[]" style="resize: none; width: 100%; font-size: 12px" rows="2" placeholder="Enter schedule..."></textarea>\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <small><input class="money_format'+counter+'" oninput="formatMoney('+counter+')" type="text" name="specialist_fee[]" placeholder="Enter fee..." style="width: 100%"></small>\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <button class="btn-xs btn-danger text-center" id="btn_remove'+counter+'" onclick="removeFacility('+counter+')"type="button" style="width: 100%">Remove</button>\n' +
            '                    </td>\n' +
            '                </tr>';
        $('#facility_table').append(string);
        $(".select2").select2({ width: '100%' });
        counter += 1;
        disableRemoveBtn();
    });
</script>
