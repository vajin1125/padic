                        
@extends('subadmin.layouts.layout')

@section('content')
    <style>
        #photoModal .modal-body img{
            display:block;
            margin:auto;
            width: 320px;
            height:auto;
        }
    </style>
    <h4> Admin </h4>
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-6">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <table class="responsive-table bordered">
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>:</td>
                                <td>{{$admin->id}}</td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td>:</td>
                                <td>{{$admin->firstname}}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>:</td>
                                <td>{{$admin->lastname}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$admin->email}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Admin Level</td>
                                <td>:</td>
                                <td>{{$admin->role}}</td>
                            </tr>
                            <tr>
                                <td>Photo</td>
                                <td>:</td>
                                <td>
                                <button type="button" class="waves-effect waves-light btn btn-info" data-toggle="modal" data-target="#photoModal" @empty($photofile) disabled @endisset>View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <h4 class="modal-title">@isset($physic){{$admin->firstname}}@endisset @isset($admin){{$admin->lastname}}@endisset</h4>
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
@endsection