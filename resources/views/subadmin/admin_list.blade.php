@extends('subadmin.layouts.layout')

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
                                    <th class="">View</th>
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
                                            <td class="">{{$user->role}}</td>
                                            <!-- <td class="">{{$user->active}}</td> -->
                                            <td class=""><a href="{{URL::to('subadmin/admin_view')}}?id={{$user->id}}">Detail</a></td>
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
@endsection