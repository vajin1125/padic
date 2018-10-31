@extends('patient.layouts.layout')

@section('content')
<h4> Patient records. </h4> 
    <!-- Dropdown Structure -->
    <div class="split-row">
        @php 
            $cnt = 0; $nRecords = sizeof($ptrecords);
            $nSheets = ceil($ptpys->perPage()/2);
            
            $n = array();
            if(floor($ptpys->perPage()/2) >= $nRecords) {
                array_push($n, $nRecords);
                array_push($n, 0);
            }
            if(floor($ptpys->perPage()/2) <= $nRecords){
                array_push($n, floor($ptpys->perPage()/2));
                array_push($n, $nRecords);
            }
        @endphp
        @for($i=0; $i<=1; $i++)
        <div class="col-md-6">
            <div class="box-inn-sp ad-inn-page">
                <div class="tab-inn ad-tab-inn">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="">ID</th>
                                    <th class="">File</th>
                                    <th class="">Time</th>
                                    
                                    <!-- <th class="">Phone1</th>
                                    <th class="">Address1</th>
                                    <th class="">File</th> --> 
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $cnt = 0;  
                                    $n0 = $i * $ptpys->perPage()/2;
                                @endphp
                                @for($j=$n0; $j<=$n[$i]-1; $j++)
                                    @php 
                                        $ptrecord = $ptrecords[$j];
                                        $cnt++;
                                        $tmp = $ptrecord['time'];
                                        $date_cur = explode(' ', $tmp)[0];
                                        $time_cur = explode(' ', $tmp)[1];

                                        $tmp = explode('-',$date_cur);
                                        $yy = $tmp[0]; $mm = $tmp[1]; $dd = $tmp[2]; 

                                        $tmp = explode(':',$time_cur);
                                        $hh = $tmp[0]; $ii = $tmp[1]; $ss = $tmp[2]; 
                                        //$dt = $yy."-".$mm."-".$dd."T".$hh.":".$ii;
                                        $dt_create = $dd."-".$mm."-".$yy." ".$hh.":".$ii.":".$ss;
                                    @endphp 
                                    <tr>
                                        <td>{{($ptpys->currentPage() - 1) * $ptpys->perPage()  + $j + 1}}</td>
                                        <td><a href="{{URL::to('/')}}/{{$ptrecord['att_file']}}">View</a></td>
                                        <td>{{$dt_create}}</td>
                                    </tr>
                                @endfor   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        @endfor
        <div class="col-md-12">
            <div class="admin-pag-na">
                <ul class="pagination list-pagenat">
                @if(isset($ptpys))
                {{ $ptpys->links() }}    
                @endif
                </ul>
            </div>
        </div>  
    </div>
@endsection