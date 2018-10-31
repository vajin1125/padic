    <!-- Modal -->
    <div id="photoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@isset($patient){{$patient->first_name}}@endisset @isset($patient){{$patient->last_name}}@endisset</h4>
                </div>
                <div class="modal-body">
                    <img src="@isset($photofile){{URL::to('/')}}/{{$photofile}}@endisset">
                </div>
                <div class="modal-footer">
                    <button type="button" class="waves-effect waves-light btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>                            
    </div>