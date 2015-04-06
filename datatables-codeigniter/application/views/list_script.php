<script type="text/javascript" charset="utf-8">
 var functions = "<?php echo $classes?>";
 var url = "<?php echo $baseurl ; ?>";
 var url_ajax = "<?php echo $baseurl."api/".$module."_ajax" ; ?>";
 var m   = 1; // minutes
 var ref = 60000; //milliseconds or 60 seconds
 var url = "<?=$page_links;?>";
 var ahsDataTables = function () {
    return {
        init: function () {
           $("." + functions+"_table").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": url_ajax+"/get_produk_list",
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

    // setInterval( function (data) {
    //     tmp="";
    //     sound = new Audio(url+'assets/notify.ogg');
    //     $("." + functions+"_table").DataTable().ajax.reload();
    //     if(tmp!=data) {
    //         sound.play();
    //     }
    // }, m*ref);

        $('.chosen').chosen({
            width: "80px"
        });
      }
  };
}();
</script>