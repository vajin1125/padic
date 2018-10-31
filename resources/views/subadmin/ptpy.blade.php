@extends('subadmin.layouts.layout')

@section('content')

    <h4> Patient Record </h4>
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
                                    <td>{{$patient->bir_mm}}/{{$patient->bir_dd}}/{{$patient->bir_yy}}</td>
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
                                    <td>{{$physic->bir_mm}}/{{$physic->bir_dd}}/{{$physic->bir_yy}}</td>
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
                                    <td>{{$ptpy->created_at}}</td>
                                    <td><a href="{{URL::to('/')}}/{{$ptpy->att_file}}" >View</a></td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
