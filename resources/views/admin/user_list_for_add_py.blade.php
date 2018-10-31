@extends('admin.layouts.layout')

@section('content')
    <h4> Register Physician  </h4> 
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
                                    <th class="">Medical Spec</th>
                                    <th class="">Add</th>
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
                                            <td class="">{{$user->spec}}</td>
                                            <td class=""><a href="{{URL::to('admin/physic_add')}}?id={{$user->id}}">Add</a></td>
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