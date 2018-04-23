<!-- Modal -->
<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- modal-lg--}}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Country List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-replaceable">
                <div class="modal-body" id="modal-default-body">
                </div>
            </div>
            <div class="modal-footer" id="modal-default-footer">
                <a href="{{ route('download-csv')  }}" class="badge download-csv">
                    <button type="button" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i>
                        Download
                        CSV
                    </button>
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
