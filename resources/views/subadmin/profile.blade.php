@extends('subadmin.layouts.layout')

@section('content')
    <h4>Admin</h4> 
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="hom-cre-acc-left hom-cre-acc-right">
                        <div class="">
                            <form id="user_save_form" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <input type="hidden" id="uid" name="id" value="{{$user->id}}">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="user_level" name="user_level" type="text" class="validate" value="{{$user->role}}" title = "user level" required readonly>
                                        <label for="user_level">Admin Level</label>
                                    </div>
                                </div>
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
                                        <input id="email" name="email" type="text" class="validate" value="{{$user->email}}" title = "email" required readonly>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
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
                                <div class="row">
                                    <div class="input-field col s6">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="file-field  input-field col s6">
                                        <div class="tz-up-btn">
                                            <span>Photo</span>
                                            <input type="file" id="photo_file" name="photo_file" class="validate" accept="image/jpeg, image/bmp, image/png" required title="Input Photo File">
                                        </div>
                                        <div class="file-path-wrapper db-v2-pg-inp">
                                            <input class="file-path validate" type="text" title="Photo File Name"> 
                                        </div>
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
                url:base_url + '/subadmin/email_user',
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
                            $("#user_save_form").attr('action',"{{URL::to('subadmin/profile_update')}}");
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
