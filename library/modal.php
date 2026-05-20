<script type="text/javascript"> 
function modal(name,link,foot,size) {
    $.ajax({
        type: "GET",
        url: link,
        beforeSend: function() {
            $('#SModal-title').html(name);
            $('#SModal-body').html('Loading...');
            $('#SModal-foot').html('');
            if(size == 'sm' || size == 'small') {
                $('#SModal-size').addClass('modal-sm');
                $('#SModal-size').removeClass('modal-lg');
            } else if(size == 'lg' || size == 'large') {
                $('#SModal-size').removeClass('modal-sm');
                $('#SModal-size').addClass('modal-lg');
            } else {
                $('#SModal-size').removeClass('modal-sm');
                $('#SModal-size').removeClass('modal-lg');
            }
        },
        success: function(result) {
            $('#SModal-title').html(name);
            $('#SModal-body').html(result);
            if(foot == null) {
                $('#SModal-foot').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-success" data-dismiss="modal">OK!</button>');
            } else {
                $('#SModal-foot').html(foot);
            }
            if(size == 'sm' || size == 'small') {
                $('#SModal-size').addClass('modal-sm');
                $('#SModal-size').removeClass('modal-lg');
            } else if(size == 'lg' || size == 'large') {
                $('#SModal-size').removeClass('modal-sm');
                $('#SModal-size').addClass('modal-lg');
            } else {
                $('#SModal-size').removeClass('modal-sm');
                $('#SModal-size').removeClass('modal-lg');
            }
        },
        error: function() {
            $('#SModal-title').html(name);
            $('#SModal-body').html('Failed to get contents...');
            $('#SModal-foot').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-success" data-dismiss="modal">OK!</button>');
            if(size == 'sm' || size == 'small') {
                $('#SModal-size').addClass('modal-sm');
                $('#SModal-size').removeClass('modal-lg');
            } else if(size == 'lg' || size == 'large') {
                $('#SModal-size').removeClass('modal-sm');
                $('#SModal-size').addClass('modal-lg');
            } else {
                $('#SModal-size').removeClass('modal-sm');
                $('#SModal-size').removeClass('modal-lg');
            }
        }
    });
    $('#SModal').modal();
}
function modalKonfirmasi(name,link) {
    $.ajax({
        type: "GET",
        url: link,
        beforeSend: function() {
            $('#RGSModal-title').html(name);
            $('#RGSModal-body').html('<div id="loader"><div class="spinner-border text-primary" role="status"></div></div>');
        },
        success: function(result) {
            setTimeout( () => {
                $('#RGSModal-title').html(name);
                $('#RGSModal-body').html(result);
            }, 2000);
        },
        error: function() {
            $('#RGSModal-title').html(name);
            $('#RGSModal-body').html('Failed to get contents...');
        }
    });
    $('#RGSModal').modal();
}
</script>

    <!-- Modal Konfirmasi -->
    <div class="modal fade modalbox rgs-modal-konfirmasi" id="RGSModal" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#000957 !important;">
                    <div class="left">
                        <a href="javascript:;" data-dismiss="modal" class="headerButton">
                            <ion-icon name="chevron-back-outline" class="text-light"></ion-icon>
                            <div class="modal-title" id="RGSModal-title"></div>
                        </a>
                    </div>
                </div>
                <div class="modal-body rgs-konfirmasi" id="RGSModal-body">
                </div>
            </div>
        </div>
    </div>
    <!-- * Modal Konfirmasi -->
    
    <div class="modal fade bd-example-modal-lg" id="SModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" id="SModal-size">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="SModal-title"></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body" id="SModal-body"></div>
            <div class="modal-footer" id="SModal-foot"></div>
         </div>
      </div>
    </div>
