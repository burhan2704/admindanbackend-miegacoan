

<!-- Header Menu -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
   {{-- left --}}
  <div class="d-flex flex-wrap gap-2">
    <h3>{{ $data->title }}</h3>
  </div>

   {{-- right --}}
  <ol class="breadcrumb breadcrumb-style1 mb-2 mb-md-0">
    <li class="breadcrumb-item">
      <a href="{{ url('/home')}}"><span class="fs-5 fw-bold" style="color: #666cff;">Master</span></a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('mie-gacoan-product')}}">
          <span class="fs-5 fw-bold" style="color: #666cff;">{{ $data->title }}</span>
        </a>
    </li>

  </ol>
</div>


<!-- Filter Section -->
@include("mie-gacoan.product.search")

<div class="card">
  <div class="card-datatable table-responsive">
    <table class="dataTableIndex table">

    </table>
  </div>
</div>

<script type="text/javascript">
    var dataTableIndex;
    $(document).ready(function() {

      dataTableIndex = $(".dataTableIndex").DataTable({
            serverSide: true,
            processing: true,
            searching: false,
          ajax: {
              url: '{!! $data->url !!}/dataAll',
              type: 'GET',
              data: {
                store_name: () => { return $('#searchForm #store_name').val() },
                status: () => { return $('#searchForm #status').val() },
                trans_no: () => { return $('#searchForm #trans_no').val() },
              },
              timeout: 60 * 1000
          },
          dom: `
            <'row'<'col-sm-12 col-md-12'<'d-flex align-items-center w-100' l>>>
            <'row'<'col-sm-12'tr>>
            <'row mt-2'<'col-sm-6 ps-sm-3'i><'col-sm-6 pe-sm-5'p>>
          `,
          initComplete: function() {
            const btnGroup = $(`
                <div class="d-flex gap-2 ms-auto">
                </div>
            `);

            const $length = $(".dataTables_length");
            const $container = $("<div class='d-flex align-items-center w-100'></div>");

            $length.wrap($container);
            $length.parent().append(btnGroup);

              $('.dataTables_length select').select2({
                  minimumResultsForSearch: Infinity
              });

              $("#btnAdd").on("click", function () {
                  getForm()
              });
          },
          columns: [
              {
                  data: null,
                  title: 'No',
                  width: '5%',
                  orderable: false,
              },
              {
                  data: 'trans_no',
                  title: 'Trans No',
              },
               {
                  data: 'trans_date',
                  title: 'Trans Date',
              },

                {
                    data: 'store_name',
                    title: 'Store Name',
                },
                {
                    data: 'total_payment',
                    title: 'Total Payment',
                },
              {
                  data: 'created_at',
                  title: 'Created At',
              },
              {
                  data: 'created_by',
                  title: 'Created By',
              }
          ],
          drawCallback: function(settings) {
            var api = this.api();
            api.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                cell.innerHTML = api.page.info().start + i + 1;
            });

            $(".view").off().on("click", function() {
                const id = $(this).data("id");
                editForm({ke: "editData", id: id, disab: "disabled"});
            });

            $(".edit").off().on("click", function(e) {
                e.preventDefault();
                const id = $(this).data("id");
                editForm({ke: "editData", id: id, disab: ""});
            });

            $(".delete").off().on("click", function(e) {
                e.preventDefault();
                const id = $(this).data("id");
                setStatus({ke: "deleteData", id: id, status: 'delete', success: () => reloadData(api)});

            });

            $(".dropdown-item.edit").off().on("click", function(e) {
                e.preventDefault();
                const id = $(this).data("id");
                editForm({ke: "editData", id: id, disab: ""});
            });

            $(".dropdown-item.delete-dropdown").off().on("click", function(e) {
                e.preventDefault();
                const id = $(this).data("id");
                setStatus({ke: "deleteData", id: id, status: 'delete', success: () => reloadData(api)});

            });

            $(".dataTables_wrapper i.disabled").css({ color: "grey", cursor: "not-allowed" });
          },
          order: [3, "asc"]
      });

      $('#status').select2({
          placeholder: "All",
          allowClear: true,
          width: '100%'
      });

      $("#searchForm #btnSearch").click(() => {
          // reloadData(dataTableIndex)
          dataTableIndex.page('first').draw('page');
      });

      $("#btnRefresh").on("click", function () {
            resetSearch();

            $("#filter-section").collapse("hide");


            dataTableIndex.search('').columns().search('').draw();
            dataTableIndex.order([3, 'asc']).draw();
            dataTableIndex.page('first').draw('page');

            reloadData(dataTableIndex);
        });
      moreLess();

    });

</script>
