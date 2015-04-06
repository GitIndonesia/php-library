 <!-- main content -->
<section class="main-content">
        <!-- content wrapper -->
                <div class="content-wrap">

                    <!-- inner content wrapper -->
                    <div class="wrapper">
                        <section class="panel panel-default">
                            <header class="panel-heading">
                                <h5>Master Data</h5>
                            </header>
                            <div class="panel-body">
                             <?php
                                    //flash messages
                                    if($this->session->flashdata('flash_message')) {
                                    if($this->session->flashdata('flash_message') == 'updated') {
                                    echo '<div class="alert alert-success">';
                                    echo '<a class="close" data-dismiss="alert">×</a>';
                                    echo '<strong>Well done!</strong> data deleted with success.';
                                    echo '</div>';
                                }else{
                                    echo '<div class="alert alert-warning">';
                                    echo '<a class="close" data-dismiss="alert">×</a>';
                                    echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
                                    echo '</div>';          
                                    }
                                }
                                ?>
                                <div class="table-responsive no-border">
                                    <table class="table table-bordered table-striped mg-t <?php echo $classes?>_table" id="refresh">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Keterangan</th>
                                                <th>Packing</th>
                                                <th>Main Produk</th>
                                                <th>Min Produk</th>
                                                <th>Produk Status</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /inner content wrapper -->

                </div>
                <!-- /content wrapper -->
                <a class="exit-offscreen"></a>
            </section>
            <!-- /main content -->
        </section>

    </div>