@extends('admin.layouts.layout')

@section('content')
    <h4>Admin</h4> 
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="hom-cre-acc-left hom-cre-acc-right">
                        <div class="">
                            <form id="user_save_form" method="post" >
                            {{ csrf_field() }}
                                <input type="hidden" id="uid" name="id" value="{{$user->id}}">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="first_name" name="first_name" type="text" class="validate" value="{{$user->firstname}}" title = "first name" required>
                                        <label for="first_name">First Name</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="last_name" name="last_name" type="text" class="validate" value="{{$user->lastname}}" title = "last name" required>
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="email" name="email" type="text" class="validate" value="{{$user->email}}" title = "email" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                @if($user->role == 'physician')                        
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="text" id="med_spec" name="med_spec" class="validate" value="{{$user->spec}}" title = "Medical Specialty" required >
                                        <label>Medical Specialty</label>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="password" id="password" name="password" class="validate" title = "password" >
                                        <label>Password</label>                                
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="validate" title = "confirm password" >
                                        <label>Confirm password</label>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="input-field col s2">
                                        <select size="20" name="active" required >
                                            <option value="" disabled >Active</option>
                                            <option title="hover text!" value="yes" @if($user->active == 'yes') selected @endif  >yes</option>
                                            <option title="hover text!" value="no"  @if($user->active == 'no')  selected @endif  >no</option>
                                        </select>
                                    </div>        
                                </div>-->
                                <div class="row">
                                    <div class="input-field col s3">
                                        <select size="10" id="role" name="role" >
                                            <option value="norole" @if($user->role == 'norole') selected @endif > No Role</option>
                                            <option value="superAdmin" @if($user->role == 'superAdmin') selected @endif > SuperAdmin  </option>
                                            <option value="subAdmin"   @if($user->role == 'subAdmin') selected @endif > SubAdmin </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="row"> 
                                    <!-- <div class="input-field col s12"> <a class="waves-effect waves-light btn-large full-btn" href="#!">Save</a> </div> -->
                                    <div class="input-field col s6">
                                        <button id="save_btn"  type="submit" class="waves-effect waves-light btn-large full-btn">Save
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var base_url = "{{URL::to('/')}}";
        function bPassword(){
            if($("#password").val() !== $("#password_confirmation").val())  return false;
            return true;
        }
        function bEmail(){
            var uid = $("#uid").val();
            var email = $("#email").val();

            $.ajax({
                type:'get',
                url:base_url + '/admin/email_user',
                dataType:'json',
                data:{
                    uid : uid,
                    email : email,
                },
                async:false,
                success:function(data){
                    if(data.msg === "false") bb = false;
                    else bb = true;
                }
            });
            return bb;
        }
        $("#save_btn").click(function(event){
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
                        if(bPassword() !== false){
                            if(!bEmail()) {
                                swal("The email address already exist.");
                                event.preventDefault(); break;
                            }
                            $("#user_save_form").attr('action',"{{URL::to('admin/user_update')}}");
                            $("#user_save_form").attr('method',"post");
                            $("#user_save_form").submit();
                        }
                        else{
                            swal("The password and confirm password do not match !");
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
