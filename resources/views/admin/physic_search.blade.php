@extends('admin.layouts.layout')

@section('content')
    <h4>Search Physician</h4> 
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="hom-cre-acc-left hom-cre-acc-right">
                        <div class="">
                            <form class="physic_search_form" method="post" action="{{URL::to('admin/physic_search')}}">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="input-field col s2">
                                        <select size="10" name="sitem" required>
                                            <option value="" disabled selected>Search Items</option>
                                            <option value="1">PIN</option>
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
                                    <th class="">PIN</th>
                                    <th class="">First Name</th>
                                    <th class="">Last Name</th>
                                    <th class="">Middle Name</th>
                                    <th class="">Birthday</th>
                                    <th class="">Gender</th>
                                    <th class="">Medical Spec</th>
                                    <th class="">Email</th>
                                    <th class="">Update</th>
                                    <th class="">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($physics))
                                    @php $cnt = 0; @endphp
                                    @foreach($physics as $physic)
                                        @php $cnt++; @endphp
                                        <tr>
                                            <td>{{$physic->pin}}</td>
                                            <td>{{$physic->first_name}}</td>
                                            <td>{{$physic->last_name}}</td>
                                            <td>{{$physic->midd_name}}</td>
                                            <td>{{$physic->bir_dd}}/{{$physic->bir_mm}}/{{$physic->bir_yy}}</td>
                                            <td>{{$physic->gender}}</td>
                                            <td>{{$physic->med_spec}}</td>
                                            <td>{{$physic->email}}</td>
                                            <td><a href="{{URL::to('admin/physic_update')}}?id={{$physic->id}}">Update</td>
                                            <td><a href="javascript:del('{{$physic->id}}');">Del</a></td>
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
                @if(isset($physics))
                {{ $physics->links() }}    
                @endif
                </ul>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function del(id){
            var url ='{{URL::to('admin/physic_delete')}}?id=' + String(id);
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