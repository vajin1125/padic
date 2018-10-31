@extends('admin.layouts.layout')

@section('content')
    <h4>Search Patient</h4>
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="hom-cre-acc-left hom-cre-acc-right">
                        <div class="">
                            <form class="patient_search_form" method="post" action="{{URL::to('/admin/patient_search')}}">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="input-field col s2">
                                        <select size="10" name="sitem" required>
                                            <option value="" disabled selected>Search Items</option>
                                            <option value="1">MRN</option>
                                            <option value="2">Last Name</option>
                                        </select>
                                    </div>
                                    <div class="input-field col s8">
                                        <input id="keyword" name="keyword" type="text" class="validate" required>
                                        <label for="keyword">Keyword</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <button  type="submit" class="waves-effect waves-light btn-large full-btn">Search
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    <th class="">Update</th>
                                    <th class="">Add Record</th>
                                    <th class="">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($patients))
                                    @php $cnt = 0; @endphp
                                    @foreach($patients as $patient)
                                        @php $cnt++; @endphp
                                        <tr>
                                            <td>{{$patient->id}}</td>
                                            <td>{{$patient->first_name}}</td>
                                            <td>{{$patient->last_name}}</td>
                                            <td>{{$patient->midd_name}}</td>
                                            <td>{{$patient->bir_dd}}/{{$patient->bir_mm}}/{{$patient->bir_yy}}</td>
                                            <td>{{$patient->gender}}</td>
                                            <td>{{$patient->email}}</td>
                                            <td><a href="{{URL::to('admin/patient_update')}}?id={{$patient->id}}">Update</a></td>
                                            <td><a href="{{URL::to('admin/patient_send_msg')}}?id={{$patient->id}}">Send Message</a></td>
                                            <td><a href="javascript:del('{{$patient->id}}');">Del</a></td>
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