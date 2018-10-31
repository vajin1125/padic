@extends('admin.layouts.layout')

@section('content')

    <h4> Add Records </h4>
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="">MRN</th>
                                    <th class="">First Name</th>
                                    <th class="">Last Name</th>
                                    <th class="">Middle Name</th>
                                    <th class="">Birthday</th>
                                    <th class="">Gender</th>
                                    <th class="">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($patient)
                                <tr>
                                    <td>{{$patient->mrn}}</td>
                                    <td>{{$patient->first_name}}</td>
                                    <td>{{$patient->last_name}}</td>
                                    <td>{{$patient->midd_name}}</td>
                                    <td>{{$patient->bir_dd}}/{{$patient->bir_mm}}/{{$patient->bir_yy}}</td>
                                    <td>{{$patient->gender}}</td>
                                    <td>{{$patient->email}}</td>
                                </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @isset($physic)
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="">PIN</th>
                                    <th class="">First Name</th>
                                    <th class="">Last Name</th>
                                    <th class="">Middle Name</th>
                                    <th class="">Birthday</th>
                                    <th class="">Gender</th>
                                    <th class="">Medical Specialty</th>
                                    <th class="">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$physic->pin}}</td>
                                    <td>{{$physic->first_name}}</td>
                                    <td>{{$physic->last_name}}</td>
                                    <td>{{$physic->midd_name}}</td>
                                    <td>{{$physic->bir_dd}}/{{$physic->bir_mm}}/{{$physic->bir_yy}}</td>
                                    <td>{{$physic->gender}}</td>
                                    <td>{{$physic->med_spec}}</td>
                                    <td>{{$physic->email}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endisset
    <div class="split-row">
        <div class="col-md-4">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="">Added Time</th>
                                    <th class="">File</th>
                                    <!-- <th class="">Message</th> -->
                                    <th class="">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($ptpy)
                                <tr>
                                    @php
                                        //"2018-07-20 17:07:32"
                                        $tmp = $ptpy->created_at;
                                        $date_cur = explode(' ', $tmp)[0];
                                        $time_cur = explode(' ', $tmp)[1];

                                        $tmp = explode('-',$date_cur);
                                        $yy = $tmp[0]; $mm = $tmp[1]; $dd = $tmp[2]; 

                                        $tmp = explode(':',$time_cur);
                                        $hh = $tmp[0]; $ii = $tmp[1]; $ss = $tmp[2]; 
                                        //$dt = $yy."-".$mm."-".$dd."T".$hh.":".$ii;
                                        $dt_create = $dd."-".$mm."-".$yy." ".$hh.":".$ii.":".$ss;
                                    @endphp
                                    <td>{{$dt_create}}</td>
                                    <td><button class="waves-effect waves-light" type="button" id="viewBtn">View</button></td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                    
                        <!-- patient files list -->
                        <div id="viewTable" style="width:550px;display:none">
                            <table class="table table-hover">
                                @isset($pt_file)
                                    <thead>
                                        <tr>
                                            <td>File Name</td>
                                            <td>Uploaded Time</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pt_file as $attrFile)
                                        @php
                                           $split_url = explode ("/", $attrFile['att_file']);
                                           $filename = $split_url[2];
                                        @endphp
                                        <tr>
                                            <td><a href="{{URL::to('/')}}/{{$attrFile['att_file']}}" target="_blank">{{$filename}}</a></td>
                                            <td>{{$attrFile['created_at']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endisset
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="hom-cre-acc-right">
                        <div class="">
                            <form id="physic_save_form" method="post" action="{{URL::to('admin/patient_send_msg')}}" style="height:300px" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                @isset($patient)<input type="hidden" name="id" value="{{$patient->id}}">@endisset
                                @isset($patient)<input type="hidden" name="mrn" value="{{$patient->mrn}}">@endisset
                                <div class="row">
    
                                    <div class="file-field  input-field col s9">
                                        <div class="tz-up-btn">
                                            <span>File</span>
                                            <input type="file" id="att_file" name="att_file" class="validate" accept=".doc, .pdf, image/jpeg, image/bmp, image/png" required title="Input File">
                                        </div>
                                        <div class="file-path-wrapper db-v2-pg-inp">
                                            <input class="file-path validate" type="text" title="File Name"> 
                                        </div>
                                        @php
                                            $tmp = explode('-',date('d-m-Y'));
                                            $mm = $tmp[1]; $dd = $tmp[0]; $yy = $tmp[2]; 
                                            $tmp = explode(':',date("H:i:s"));

                                            $hh = $tmp[0]; $ii = $tmp[1]; $ss = $tmp[2]; 
                                            //$dt = $yy."-".$mm."-".$dd."T".$hh.":".$ii;
                                            $dt = $dd."-".$mm."-".$yy." ".$hh.":".$ii.":".$ss;
                                        @endphp
                                    </div>
                                    <div class="input-field col s3">
                                        <!-- <input type="datetime-local" id="meet_time" name="meet_time" value="{{$dt}}" min="1900-01-01T00:00" title="Meet Time">-->
                                        <input type="text" id="meet_time" name="meet_time" value="{{$dt}}" readonly>        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="text" id="select_physican" name="select_physican" class="autocomplete" title="LastName ( PIN )" value="">
                                        <label for="select_physican"> Enter Physician name </label>                                        
                                    </div>
                                    <div class="input-field col s3">
                                        <!-- <input type="checkbox" id="bSend" name="bSend" value="send" class="validate" checked>  -->
                                        <input type="checkbox" id="bSend" name="bSend" class="validate" >
                                        <label for="bSend" style="font-size:14px;"> Add Record To Physician </label>
                                    </div>
                                    <div class="input-field col s3">
                                        <button id="send_msg_btn"  type="submit" class="waves-effect waves-light btn-large full-btn"> Add Record
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('footer-script')
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            var base_url = "{{URL::to('/')}}";
            var bAutoComp = false;
            $(function(){
                $('#select_physican.autocomplete').autocomplete({
                    data: {
                        @foreach($physics as $physic1)
                            "{{$physic1->last_name}}({{$physic1->pin}})":null,
                        @endforeach
                    },
                    limit: 4, // The max amount of results that can be shown at once. Default: Infinity.
                    onAutocomplete: function(val) {
                        // Callback function when value is autcompleted.
                        swal("The data is entered correctly!");
                        bAutoComp = true;
                    },
                    minLength: 1 // The minimum length of the input for the autocomplete to start. Default: 1.
                });
            });
            $("#send_msg_btn").click(function(event){
                var val = $("#select_physican").val();
                var att_file = $("#att_file").val();
                var bSend = $("#bSend").prop("checked");
                if(bSend){
                    $("#bSend").val("send");
                }
                if(att_file == ''){
                    swal("No file to be uploaded found. Please select a file. !");
                    event.preventDefault();   
                    return;
                }
                if(bSend && !bAutoComp){
                    swal("There is no physician. Please re-enter physician's last name or PIN !");
                    event.preventDefault();   
                    return;
                }
                $.ajax({
                    type:'get',
                    url:base_url + '/admin/patient_vali_py',
                    dataType:'json',
                    data:{
                        param : val
                    },
                    async:false,
                    success:function(data){
                        if(data.msg === "false"){
                            swal("There is no physician. Please re-enter your last name or PIN !");
                            event.preventDefault();   
                        }
                        else{
                            $("#physic_save_form").submit();
                        }
                    }
                });
            });

            $("#viewBtn").click(function(){
                $("#viewTable").toggle("fast");
            });
        </script>
    @endpush
@endsection
