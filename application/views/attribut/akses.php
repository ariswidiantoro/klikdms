<!-- ajax layout which only needs content area -->
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- #section:pages/error -->
        <div class="error-container">
            <div class="well">
                <h1 class="grey lighter smaller">
                    <span class="blue bigger-125">
                        <i class="ace-icon fa fa-random"></i>
                        Maaf
                    </span>
                    Anda tidak berhak mengakses halaman ini
                </h1>

                <hr />
                <h3 class="lighter smaller">
                    <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
                </h3>

                <div class="space"></div>

                <div>
                    <h4 class="lighter smaller">Kemungkinan:</h4>

                    <ul class="list-unstyled spaced inline bigger-110 margin-15">
                        <li>
                            <i class="ace-icon fa fa-hand-o-right blue"></i>
                           Anda telah logout
                        </li>

                        <li>
                            <i class="ace-icon fa fa-hand-o-right blue"></i>
                            Anda tidak punya hak akses pada menu ini
                        </li>
                    </ul>
                </div>

                <hr />
                <div class="space"></div>

            </div>
        </div>

        <!-- /section:pages/error -->

        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>
