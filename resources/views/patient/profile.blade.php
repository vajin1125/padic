                        
@extends('patient.layouts.layout')

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
                                <td>MRN</td>
                                <td>:</td>
                                <td>{{$patient->mrn}}</td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td>:</td>
                                <td>{{$patient->first_name}}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>:</td>
                                <td>{{$patient->last_name}}</td>
                            </tr>
                            <tr>
                                <td>Middle Name</td>
                                <td>:</td>
                                <td>{{$patient->midd_name}}</td>
                            </tr>
                            <tr>
                                <td>Birthday</td>
                                <td>:</td>
                                <td>{{$patient->bir_mm}}/{{$patient->bir_dd}}/{{$patient->bir_yy}}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{$patient->gender}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$patient->email}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone1</td>
                                <td>:</td>
                                <td>{{$patient->phone_num1}}</td>
                            </tr>
                            <tr>
                                <td>Phone2</td>
                                <td>:</td>
                                <td>{{$patient->phone_num2}}</td>
                            </tr>
                            <tr>
                                <td>Phone3</td>
                                <td>:</td>
                                <td>{{$patient->phone_num3}}</td>
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
                                <td>{{$patient->address1}}</td>
                            </tr>
                            <tr>
                                <td>Address2</td>
                                <td>:</td>
                                <td>{{$patient->address2}}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>:</td>
                                <td>{{$patient->city}}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>:</td>
                                <td>{{$patient->state}}</td>
                            </tr>
                            <tr>
                                <td>Date added</td>
                                <td>:</td>
                                <td>{{$patient->added_mm}}/{{$patient->added_dd}}/{{$patient->added_yy}}</td>
                            </tr>
                         </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection