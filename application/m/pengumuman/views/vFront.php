<div class="title-page">
	<div class="row">
		<div class="col-md-7">
			<h1>Manajemen User </b> </h1>
			<div class="divider"></div>
		</div>
		<div class="col-md-2">
		
		</div>
		<div class="col-md-3">
			<div class="pull-right" >
				<a href="<?= base_url()?>user/add" style="width:100%" class="btn btn-primary"> <i data-feather="plus"></i> Tambah  </a>
			</div>
		</div>
	</div>

</div>
<div class="container">
	<div class="widget-content-area br4">
		
		<div class="table-responsive mb-4 mt-4">
			<table id="table_user" class="table table-hover" style="width:100%">
				<thead>
				<tr>
					<th width="2%">No.</th>
					<th>Nama  </th>
					<th>WA </th>
					<th>Username </th>
					<th class="no-content"></th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>


    <script type="text/javascript">

    var save_method; //for save method string
    var table;


    $(document).ready(function() {
        //datatables
	    
        table = $('#table_user').DataTable({
 
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
	        
	        
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('user/ajax_list')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
            ],

        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });


    });

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }


    function delete_(id)
    {
        if(confirm('Anda yakin ingin menghapus data ?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('user/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#delete').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }


    
</script>