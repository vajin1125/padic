@extends('admin.layouts.layout')

@section('content')
    <style>
        #photoModal .modal-body img{
            display:block;
            margin:auto;
            width: 320px;
            height:auto;
        }
    </style>
    <h4>Patient</h4>
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="hom-cre-acc-left hom-cre-acc-right">
                        <div class="">
                            <form id="patient_save_form" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                @isset($patient->id)<input type="hidden" name="id" value="{{$patient->id}}">@endisset
                                <input type="hidden" name="mrn" value="{{$patient->mrn}}">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="first_name" name="first_name" type="text" class="validate" value="@isset($patient){{$patient->first_name}}@endisset" required>
                                        <label for="first_name">First Name</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="last_name" name="last_name" type="text" class="validate" value="@isset($patient){{$patient->last_name}}@endisset" required>
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="row">
                                <!--
                                    <div class="input-field col s6">
                                        <input id="midd_name" name="midd_name" type="text" class="validate" value="@isset($patient){{$patient->midd_name}}@endisset" required>
                                        <label for="midd_name">Middle Name</label>
                                    </div>
                                -->
                                    <div class="input-field col s2">
                                        <input id="bir_dd" name="bir_dd" type="text" class="validate"  value="@isset($patient){{$patient->bir_dd}}@endisset" required>
                                        <label for="bir_dd">Birthday(dd)</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="bir_mm" name="bir_mm" type="text" class="validate"  value="@isset($patient){{$patient->bir_mm}}@endisset" required>
                                        <label for="bir_mm">Birthday(mm)</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="bir_yy" name="bir_yy" type="text" class="validate"  value="@isset($patient){{$patient->bir_yy}}@endisset" required>
                                        <label for="bir_yy">Birthday(yy)</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s2">
                                        <select size="10" id="gender" name="gender" required>
                                            <option value="" disabled @empty($patient) selected @endempty>Gender</option>
                                            <option value="male" @isset($patient) @if($patient->gender == 'male') selected @endif @endisset> male  </option>
                                            <option value="female" @isset($patient) @if($patient->gender == 'female') selected @endif @endisset> female  </option>
                                        </select>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="city" name="city" type="text" class="validate" value="@isset($patient){{$patient->city}}@endisset" required>
                                        <label for="city">City</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="state" name="state" type="text" class="validate" value="@isset($patient){{$patient->state}}@endisset" required>
                                        <label for="state">State</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="email" name="email" type="text" class="validate" value="@isset($patient){{$patient->email}}@endisset" required  @isset($patient) readonly @endisset>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="address1" name="address1" type="text" class="validate" value="@isset($patient){{$patient->address1}}@endisset" required>
                                        <label for="address1">Address1</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="address2" name="address2" type="text" class="validate" class="validate" value="@isset($patient){{$patient->address2}}@endisset">
                                        <label for="address2">Address2</label>
                                    </div>
                                </div>
                                <!--
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="phone_num1" name="phone_num1" type="number" class="validate" class="validate" value="@isset($patient){{$patient->phone_num1}}@endisset" required>
                                        <label for="phone_num1">Phone 1</label>
                                    </div>
                                    <div class="input-field col s6">
                                    <input id="phone_num2" name="phone_num2" type="number" class="validate" class="validate" value="@isset($patient){{$patient->phone_num2}}@endisset">
                                        <label for="phone_num2">Phone 2</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="phone_num3" name="phone_num3" type="number" class="validate" value="@isset($patient){{$patient->phone_num3}}@endisset">
                                        <label for="phone_num3">Phone 3</label>
                                    </div>
                                </div>
                                -->
                                <div class="row">
                                    <div class="file-field  input-field col s5">
                                        <div class="tz-up-btn">
                                            <span>Photo</span>
                                            <input type="file" id="photo_file" name="photo_file" class="validate" accept="image/jpeg, image/bmp, image/png" required title="Input Photo File">
                                        </div>
                                        <div class="file-path-wrapper db-v2-pg-inp">
                                            <input class="file-path validate" type="text" title="Photo File Name"> 
                                        </div>
                                    </div>
                                    <div class="input-field col s1">
                                        <button type="button" class="waves-effect waves-light btn btn-info" data-toggle="modal" data-target="#photoModal" @empty($photofile) disabled @endisset>View</button>
                                    </div>
                                    @php
                                    if(empty($patient)) {
                                        $added = explode('-',date('d-m-Y'));
                                        $mm = $added[1]; $dd = $added[0]; $yy = $added[2]; 
                                    }
                                    elseif(isset($patient)){
                                        $mm = $patient->added_mm; $dd = $patient->added_dd; $yy = $patient->added_yy;
                                    }
                                    @endphp
                                    <div class="input-field col s2">
                                        <input id="added_dd" name="added_dd" type="text" class="validate" value="{{$dd}}" >
                                        <label for="added_dd">Date added(dd)</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="added_mm" name="added_mm" type="text" class="validate" value="{{$mm}}" >
                                        <label for="added_mm">Date added(mm)</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="added_yy" name="added_yy" type="text" class="validate" value="{{$yy}}" >
                                        <label for="added_yy">Date added(yy)</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        &nbsp;
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    {{--  birthday message  --}}
                                    <div class="input-field col">
                                        <textarea name="bir_msg" id="bir_msg" rows="4" cols="80">@isset($patient){{$patient->birthday_msg}}@endisset</textarea>
                                        <label for="bir_msg">Birthday Messages</label>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <!-- <div class="input-field col s12"> <a class="waves-effect waves-light btn-large full-btn" href="#!">Save</a> </div> -->
                                    <div class="input-field col s12">
                                        <button id="save_btn" class="waves-effect waves-light btn-large full-btn">Save
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="photoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@isset($patient){{$patient->first_name}}@endisset @isset($patient){{$patient->last_name}}@endisset</h4>
                </div>
                <div class="modal-body">
                    <img src="@isset($photofile){{URL::to('/')}}/{{$photofile}}@endisset">
                </div>
                <div class="modal-footer">
                    <button type="button" class="waves-effect waves-light btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>                            
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var base_url = "{{URL::to('/')}}";
        function bSave(){
            if($("#first_name").val() == '') {
                swal("Enter First Name !","");
                return false;
            }
            if($("#last_name").val() == '') {
                swal("Enter Last Name !","");
                return false;
            }
            if($("#midd_name").val() == '') {
                swal("Enter Middle Name !","");
                return false;
            }
            if($("#bir_mm").val() == '' || $("#bir_dd").val() == '' || $("#bir_yy").val() == '') {
                swal("Enter Birthday !","");
                return false;
            }                        
            if($("#gender").val() == null) {
                swal("Enter Gender !","");
                return false;
            }
            if($("#email").val() == '') {
                swal("Enter Email !","");
                return false;
            }
            if($("#phone_num1").val() == '') {
                swal("Enter Phone1 !","");
                return false;
            }
            if($("#address1").val() == '') {
                swal("Enter Address1 !","");
                return false;
            }
            if($("#city").val() == '') {
                swal("Enter City !","");
                return false;
            }
            if($("#state").val() == '') {
                swal("Enter State !","");
                return false;
            }
            if($("#added_mm").val() == '' || $("#added_dd").val() == '' || $("#added_yy").val() == '') {
                swal("Enter Added Date !","");
                return false;
            }
            if($("bir_msg").val() == ''){
                swal("Enter Birthday Message !", "");
                return false;
            }
            return true;
        }
        $("#save_btn").click(function(event){
            @isset($patient->id)
            var bAdd = false;
            @endisset

            @empty($patient->id)
            var bAdd = true;
            @endisset

            event.preventDefault();
            swal({
                title:"Are you sure to save ?",
                buttons: {
                    cancel: "Cancel",
                    Save: true,
                },
            })
            .then((value) => {
                switch (value) {                
                    case "Save":
                        if(bSave()){                            
                            if(bAdd){
                                $("#patient_save_form").attr('action',"{{URL::to('admin/patient_add')}}");
                                $("#patient_save_form").attr('method',"post");
                                $("#patient_save_form").submit();
                            } 
                            else{
                                $("#patient_save_form").attr('action',"{{URL::to('admin/patient_update')}}");
                                $("#patient_save_form").attr('method',"post");
                                $("#patient_save_form").submit();
                            }
                        }
                        else{
                            event.preventDefault();
                        }    
                        break;                  
                    default:
                        event.preventDefault();
                }
            });
        });
        
    </script>
@endsection
