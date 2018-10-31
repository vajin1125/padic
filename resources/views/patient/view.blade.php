                        
@extends('patient.layouts.layout')

@section('content')
    <style>
        #photoModal .modal-body img{
            display:block;
            margin:auto;
            width: 320px;
            height:auto;
        }
    </style>
    <h4>Physician</h4>
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
                                <td>{{$physic->id}}</td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td>:</td>
                                <td>{{$physic->first_name}}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>:</td>
                                <td>{{$physic->last_name}}</td>
                            </tr>
                            <tr>
                                <td>Middle Name</td>
                                <td>:</td>
                                <td>{{$physic->midd_name}}</td>
                            </tr>
                            <tr>
                                <td>Birthday</td>
                                <td>:</td>
                                <td>{{$physic->bir_dd}}/{{$physic->bir_mm}}/{{$physic->bir_yy}}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{$physic->gender}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$physic->email}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone1</td>
                                <td>:</td>
                                <td>{{$physic->phone_num1}}</td>
                            </tr>
                            <tr>
                                <td>Phone2</td>
                                <td>:</td>
                                <td>{{$physic->phone_num2}}</td>
                            </tr>
                            <tr>
                                <td>Phone3</td>
                                <td>:</td>
                                <td>{{$physic->phone_num3}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <table class="responsive-table bordered">
                        <tbody>
                            <tr>
                                <td>Address1</td>
                                <td>:</td>
                                <td>{{$physic->address1}}</td>
                            </tr>
                            <tr>
                                <td>Address2</td>
                                <td>:</td>
                                <td>{{$physic->address2}}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>:</td>
                                <td>{{$physic->city}}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>:</td>
                                <td>{{$physic->state}}</td>
                            </tr>
                            <tr>
                                <td>Date added</td>
                                <td>:</td>
                                <td>{{$physic->added_dd}}/{{$physic->added_mm}}/{{$physic->added_yy}}</td>
                            </tr>
                            <tr>
                                <td>File</td>
                                <td>:</td>
                                <td><a href="{{URL::to('/')}}/{{$ptpy->att_file}}">{{$ptpy->att_file}}</a></td>
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
                    <h4 class="modal-title">@isset($physic){{$physic->first_name}}@endisset @isset($physic){{$physic->last_name}}@endisset</h4>
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