@extends('subadmin.layouts.layout')

@section('content')
    <h4>All Patients</h4> 
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
                                    <th class="">View</th>
                                    <th class="">Patient Record</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($patients))
                                    @php $cnt = 0; @endphp
                                    @foreach($patients as $patient)
                                        @php $cnt++; @endphp
                                        <tr>
                                            <td>{{$patient->mrn}}</td>
                                            <td>{{$patient->first_name}}</td>
                                            <td>{{$patient->last_name}}</td>
                                            <td>{{$patient->midd_name}}</td>
                                            <td>{{$patient->bir_dd}}/{{$patient->bir_mm}}/{{$patient->bir_yy}}</td>
                                            <td>{{$patient->gender}}</td>
                                            <td>{{$patient->email}}</td>
                                            <td><a href="{{URL::to('subadmin/patient_view')}}?id={{$patient->id}}">Detail</a></td>
                                            <td><a href="{{URL::to('subadmin/patient_physic')}}?id={{$patient->id}}">Patient Record</a></td>
                                        </tr>
                                    @endforeach   
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="admin-pag-na">
                <ul class="pagination list-pagenat">
                @if(isset($patients))
                {{ $patients->links() }}    
                @endif
                </ul>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function del(id){
            var url ='{{URL::to('admin/patient_delete')}}?id=' + String(id);
            swal({
                title:"Are you sure to delete ?",
                buttons: {
                    cancel: "Cancel",
                    Del: true,
                },
            })
            .then((value) => {
                switch (value) {                
                    case "Del":
                        document.location.replace(url);
                        break;
                    default:
                        event.preventDefault();
                        break;
                }
            });
        }
    </script>
@endsection