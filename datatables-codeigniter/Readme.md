## Javascript

```
var url_ajax = "<?php echo $baseurl."api/".$module."_ajax" ; ?>";
var ahsDataTables = function () {
    return {
        init: function () {
           $(".datatables").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": url_ajax+"/list",
            "aaSorting": [[0, 'desc']],
            'iDisplayLength': 10,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,

             "fnRowCallback" : function(nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                var iTotalRecords = oSettings.fnRecordsDisplay();
                $("#total").val(iTotalRecords);
                $("td:first", nRow).html(iDisplayIndex +1);
               return nRow;
            },

            "columnDefs": [
                {
                    "targets": [8],
                    "searchable": false,
                    "sortable":false
                },
             ]
    });
      }
  };
}();

//datatable
$(function () {
    "use strict";
    ahsDataTables.init();
});
```


## View 

```
<table class="table table-bordered table-striped mg-t datatables" id="refresh">
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
```