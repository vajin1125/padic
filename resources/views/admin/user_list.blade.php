@extends('admin.layouts.layout')

@section('content')
    <h4> Admin Users </h4> 
    <!-- Dropdown Structure -->
    <div class="split-row">
        <div class="col-md-12">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="">UserID</th>
                                    <th class="">First Name</th>
                                    <th class="">Last Name</th>
                                    <th class="">Email</th>
                                    <!-- <th class="">Medical Spec</th> -->
                                    <th class="">User Level</th>
                                    <!-- <th class="">Active</th> -->
                                    <th class="">Update</th>
                                    <th class="">Delete</th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users))
                                    @php $cnt = 0; @endphp
                                    @foreach($users as $user)
                                        @php $cnt++; @endphp
                                        <tr>
                                            <td class="">{{$user->id}}</td>
                                            <td class="">{{$user->firstname}}</td>
                                            <td class="">{{$user->lastname}}</td>
                                            <td class="">{{$user->email}}</td>
                                            <!-- <td class="">{{$user->spec}}</td> -->
                                            <td class="">
                                                <!-- <div class="switch" >
													<label> Sub
													<input type="checkbox" disabled @if($user->role == 'superAdmin') checked @endif> <span class="lever"></span> Super </label>
                                                </div> -->
                                                {{$user->role}}
                                            </td>
                                            <!-- <td class="">{{$user->active}}</td> -->
                                            <td class=""><a href="{{URL::to('admin/user_update')}}?id={{$user->id}}">Update</a></td>
                                            <td class="">@if($user->id != 1)<a href="javascript:del('{{$user->id}}');">Del</a>@endif&nbsp</td>
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
                @if(isset($users))
                {{ $users->links() }}    
                @endif
                </ul>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function del(id){
            var url ='{{URL::to('admin/user_delete')}}?id=' + String(id);
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