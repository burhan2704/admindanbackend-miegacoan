<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
   {{-- left --}}
  <div class="d-flex flex-wrap gap-2">
    <h3>{{ $data->title }}</h3>
  </div>

  {{-- right --}}
  <ol class="breadcrumb breadcrumb-style1 mb-2 mb-md-0">
    <li class="breadcrumb-item">
      <a href="{{ url('/home')}}"><span class="fs-5 fw-bold" style="color: #666cff;">Dashboard</span></a>
    </li>
    @foreach ($data->breadcrumb as $v)
    <li class="breadcrumb-item {{ $v->route ? "active" : "" }}">
      @if($v->route)
        <a href="{{ $v->route ? url($v->route) : "javascript:void(0);"}}">
          <span class="fs-5 fw-bold" style="color: #666cff;">{{ $v->name }}</span>
        </a>

      @else
        <a href="{{ $v->route ? url($v->route) : "javascript:void(0);"}}"><span class="fs-5">{{ $v->name }}</span></a>
      @endif
    </li>
    @endforeach
  </ol> 
</div>

<!-- Filter Section -->
@include("company-management.company.search")

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
                names: () => { return $('#searchForm #names').val() },
                status: () => { return $('#searchForm #status').val() },
                emails: () => { return $('#searchForm #emails').val() },
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
                    <button class="btn btn-primary" id="btnAdd" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                        <i class="ri-add-large-line me-1"></i>Add
                    </button>
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
                  data: null,
                  title: 'Action',
                  searchable: false,
                  orderable: false,
                  render: function(data, type, row, meta) {
                      return `
                      <div class="d-flex align-items-center gap-2">
                          <i class="ri-eye-line ri-20px pointer view" data-id="${row.id}" title="View"></i>
                          <i class="ri-pencil-line me-1 pointer edit ${row.deleted_at ? 'disabled' : null }" data-id="${row.id}" title="Edit"></i>
                          <i class="ri-delete-bin-7-line ri-20px pointer delete ${AUTH.is_superadmin == true ? (row.status.code == "Active" ? null : 'disabled') : 'disabled' }" data-id="${row.id}" title="Delete"></i>
                      </div>`;
                  }
              },
             {
                data: 'status',
                title: 'Status',
                render: function(data, type, row) {
                  return `<span class="badge bg-label-${data.badge}">${data.code}</span>`;
                }
              },
              { 
                  data: 'code', 
                  title: 'Code',
              },
              { 
                  data: 'name', 
                  title: 'Name',
              },
              { 
                  data: 'created_at', 
                  title: 'Created At',
              },
              { 
                  data: 'created_by', 
                  title: 'Created By',
              },
                { 
                  data: 'deleted_at', 
                  title: 'Deleted At',
              },
              { 
                  data: 'deleted_by', 
                  title: 'Deleted By',
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

      // $('#status').select2({
      //     placeholder: "All",
      //     allowClear: true,
      //     width: '100%'
      // });

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
      initSelect2();
    
    });



</script>
