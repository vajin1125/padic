                        
@extends('physic.layouts.layout')

@section('content')
    <h4>Profile</h4>
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-6">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <table class="responsive-table bordered">
                        <tbody>
                            <tr>
                                <td>PIN</td>
                                <td>:</td>
                                <td>{{$physic->pin}}</td>
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
                                <td>{{$physic->bir_mm}}/{{$physic->bir_dd}}/{{$physic->bir_yy}}</td>
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
                                <td>Medical Specialty</td>
                                <td>:</td>
                                <td>{{$physic->med_spec}}</td>
                            </tr>
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
                                <td>{{$physic->added_mm}}/{{$physic->added_dd}}/{{$physic->added_yy}}</td>
                            </tr>
                         </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection