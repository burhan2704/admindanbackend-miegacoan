{{-- add on  --}}
{{-- <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/jstree/jstree.css') }}" />   --}}
{{-- <script src="{{ asset('core-template/assets/vendor/libs/jstree/jstree.js') }}"></script> --}}
    <script src="{{ asset('core-template/assets/js/tables-datatables-extensions.js') }}"></script>
    <script src="{{ asset('core-template/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

     <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('core-template/assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}" />

<!-- Header Menu -->
 <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
   {{-- left --}}
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
    <li class="breadcrumb-item">
      <span class="fs-5">{{ ucwords(preg_replace('/(?<!^)([A-Z])/', ' $1', $ke)) }}</span>
    </li>
  </ol>
</div>

<div class="col-md-12">
  <div class="card mb-12">
    <div class="card-body demo-vertical-spacing demo-only-element">
      <div id="mainForm">
        <form enctype="multipart/form-data" method="POST" onsubmit="return false;">
        
          <div class="form-floating form-floating-outline mb-4" style="{{ $permission->isSuperAdmin ?? 'display: none;' }}">
              {!! Form::select('company_id', [null=>"Select"] + Arr::pluck($permission->company, 'code', 'id'), $header ? $header->company_id :  Auth::user()->company_id, [$disab, 'class' => 'select2 form-select', 'id' => 'company_id']) !!}
              {!! Form::label('company_id', 'Company') !!}
          </div>

          {{-- Role Name --}}
          <div class="form-floating form-floating-outline mb-4">
            {!! Form::text('role_name', $header ? $header->role_name : null, [
              $disab,
              'class' => 'form-control',
              'id' => 'role_name',
              'placeholder' => '',
              'required' => true
            ]) !!}
            {!! Form::label('role_name', 'Role Name') !!}
          </div>

          <div class="form-floating form-floating-outline mb-4">
              <div class="text-light small fw-medium">Active Flag</div>
              <div class="demo-vertical-spacing">
                  <label class="switch">
                      {!! Form::checkbox('is_active', 1, $header ? (bool)$header->is_active : true, [$disab, 'class' => 'switch-input']) !!}
                      <span class="switch-toggle-slider">
                          <span class="switch-on"></span>
                          <span class="switch-off"></span>
                      </span>
                  </label>
              </div>
          </div>

          <hr>
          <h5>Permission</h5>
          <div class="mb-3">
    <button type="button" class="btn btn-primary" id="checkAllBtn">Check All</button>
    <button type="button" class="btn btn-outline-secondary" id="uncheckAllBtn">Uncheck All</button>
</div>
          
          <div class="card">
            <div class="card-datatable text-nowrap">
              <table class="dtDetail table table-bordered">
                <thead>
                  <tr>
                    <th>Menu</th>
                    <th>Create</th>
                    <th>Update</th>
                    <th>Delete</th>
                    <th>View</th>
                    <th>Print</th>
                    <th>Open</th>
                    <th>Confirm</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-secondary" id="btnCancel" >Cancel</button>
            @if($ke == "createData")<button type="submit" class="btn btn-outline-primary" id="btnSaveNew">Save & New</button>@endif
            <button type="submit" class="btn btn-primary" id="btnSave" {{ $disab }}>Save</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<

<script type="text/javascript">
  $(document).ready(function() {
    const disab = "{!! $disab !!}";
    const url = "{!! $data->url !!}";
    const ke = "{!! $ke !!}";
    const header = {!! json_encode($header) !!};
    const delete_details = [];
    const menuTreeData = {!! json_encode($menus) !!};

    const dtDetail = $(".dtDetail").DataTable({
      data: menuTreeData,
      scrollY: "500px",
      scrollX: true,
      paging: false,
      ordering: false, 
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      language: {
        paginate: {
          next: '<i class="ri-arrow-right-s-line"></i>',
          previous: '<i class="ri-arrow-left-s-line"></i>',
        },
      },
      columns: [
        // {
        //   data: "name",
        //   render: function (data, type, row) {
        //     const level = row.level || 1;
        //     const padding = (level - 1) * 30;
        //     return `
        //       <div style="padding-left: ${padding}px;" data-level="${level}">
        //         <span class="tree-text">• ${data}</span>
        //       </div>`;
        //   },
        // },
        {
            data: "name",
            render: function (data, type, row) {
                const level = row.level || 1;
                const padding = (level - 1) * 20;

                const content = level === 1
                    ? `<i class="menu-icon tf-icons ${row.icon}"></i> ${data}`
                    : `• ${data}`;

                return `
                    <div style="padding-left: ${padding}px;" data-level="${level}">
                      <span class="tree-text">
                        ${content}
                      </span>
                    </div>`;
            },
        },
        {
          data: "can_create",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_create" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: "can_update",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_update" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: "can_delete",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_delete" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: "can_view",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_view" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: "can_print",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_print" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: "can_open",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_open" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: "can_confirm",
          render: function (data, type, row) {
            return `<input type="checkbox" class="form-check-input" data-property="can_confirm" data-id="${row.id}" ${data ? "checked" : ""}>`;
          },
          className: 'text-center',

        },
        {
          data: null,
          render: function (data, type, row) {
              return `
                  <button type="button" class="btn btn-sm btn-primary check-row-btn" data-id="${row.id}"><i class="ri-checkbox-circle-line ri-20px pointer view"  title="Check"></i></button>
                  <button type="button" class="btn btn-sm btn-outline-primary uncheck-row-btn" data-id="${row.id}"><i class="ri-checkbox-blank-circle-line ri-20px pointer view" title="Uncheck"></i></button>
              `;
          },
          width: '10%',
          className: 'text-center',

        },
      ],
    })
    .on("click", ".check-row-btn", function () {
        const rowId = $(this).data("id");
        const rowData = menuTreeData.find(item => item.id === rowId);

        if (rowData) {
            // Define all permission properties
            const properties = ["can_create", "can_update", "can_delete", "can_view", "can_print", "can_open", "can_confirm"];
            properties.forEach(prop => {
                // We're setting them to true, so recursively update children as well
                // Call updateCheckboxState for each property for this row to ensure children are affected
                updateCheckboxState(rowId, prop, true);
            });
             dtDetail.rows().invalidate().draw(false); // Refresh DataTable after mass update for a row
        }
    })
    .on("click", ".uncheck-row-btn", function () {
        const rowId = $(this).data("id");
        const rowData = menuTreeData.find(item => item.id === rowId);

        if (rowData) {
            const properties = ["can_create", "can_update", "can_delete", "can_view", "can_print", "can_open", "can_confirm"];
            properties.forEach(prop => {
                // We're setting them to false, so recursively update children/parents
                updateCheckboxState(rowId, prop, false);
            });
            dtDetail.rows().invalidate().draw(false); // Refresh DataTable after mass update for a row
        }
    })
    .off("change", "input[type='checkbox']")
    .on("change", "input[type='checkbox']", function () {
      const isChecked = $(this).is(":checked");
      const id = $(this).data("id");
      const property = $(this).data("property");

      updateCheckboxState(id, property, isChecked);
    });


    function updateCheckboxState(id, property, isChecked) {
      const updateItemAndChildren = (itemId) => {
        const item = menuTreeData.find((x) => x.id === itemId);
        if (item) {
          item[property] = isChecked;

          // Update DOM
          $(`.dtDetail input[data-id="${itemId}"][data-property="${property}"]`).prop("checked", isChecked);

          // Update children recursively
          menuTreeData
            .filter((x) => x.parent === itemId)
            .forEach((child) => {
              updateItemAndChildren(child.id);
            });
        }
      };

      updateItemAndChildren(id);

      // Optional: Update parent if necessary
      if (!isChecked) {
        const item = menuTreeData.find((x) => x.id === id);
        if (item && item.parent) {
          const parent = menuTreeData.find((x) => x.id === item.parent);
          if (parent) {
            const allChildrenUnchecked = menuTreeData
              .filter((x) => x.parent === parent.id)
              .every((x) => !x[property]);

            if (allChildrenUnchecked) {
              parent[property] = false;
              $(`.dtDetail input[data-id="${parent.id}"][data-property="${property}"]`).prop("checked", false);
            }
          }
        }
      }

      // Refresh DataTable
      dtDetail.rows().invalidate().draw(false);
    }

    $("#checkAllBtn").on("click", function () {
        const properties = ["can_create", "can_update", "can_delete", "can_view", "can_print", "can_open", "can_confirm"];
        menuTreeData.forEach(item => {
            properties.forEach(prop => {
                if (item[prop] !== true) { 
                    item[prop] = true;
                    $(`.dtDetail input[data-id="${item.id}"][data-property="${prop}"]`).prop("checked", true);
                }
            });
        });
        dtDetail.rows().invalidate().draw(false);
    });

    $("#uncheckAllBtn").on("click", function () {
        const properties = ["can_create", "can_update", "can_delete", "can_view", "can_print", "can_open", "can_confirm"];
        menuTreeData.forEach(item => {
            properties.forEach(prop => {
                if (item[prop] !== false) { 
                    item[prop] = false;
                    $(`.dtDetail input[data-id="${item.id}"][data-property="${prop}"]`).prop("checked", false);
                }
            });
        });
        dtDetail.rows().invalidate().draw(false); 
    });


    $("#btnCancel").on("click", function() {
      cancelForm(true);
    });

    $("#btnCancel").on("click", function() {
        cancelForm(true);
    });

    $('#togglePassword').on('click', function () {
      const passwordInput = $('#password');
      const icon = $('#toggleIcon');

      const isPassword = passwordInput.attr('type') === 'password';
      passwordInput.attr('type', isPassword ? 'text' : 'password');
      icon
        .removeClass(isPassword ? 'ri-eye-off-line' : 'ri-eye-line')
        .addClass(isPassword ? 'ri-eye-line' : 'ri-eye-menusoff-line');
    });

    $('#mainForm #btnSave, #mainForm #btnSaveNew').click(function (e) {
        e.preventDefault();

        loadingPage('show'); 

        $('#btnSave, #btnSaveNew').prop('disabled', true); 

        const formData = Object.fromEntries(new FormData($('#mainForm form')[0])); 
        const data = $.extend(formData, {
            id: header ? header.id : null,
            ke: ke,
            details: $.map(dtDetail.data(), v => v),
            delete_details: delete_details,
        });

        submitForm(data)
        .done((response) => {
            loadingPage('hide'); 

            showMessage(response.message); 

            if ($(this).attr('id') === 'btnSave') {
                cancelForm(); 
            } else {
                $('#mainForm form')[0].reset(); 
                // dtDetail.clear().draw();
                dtDetail.rows().nodes().to$().find('input[type="checkbox"]').each(function () {
                    this.checked = false;
                });
                
                $('#btnSave, #btnSaveNew').prop('disabled', false); 
            }

            reloadData(dataTableIndex); 
        })
        .fail((xhr) => {
            loadingPage('hide');

            const response = JSON.parse(xhr.responseText); 

            if (xhr.status == 422) {
                $.each(response.errors, (k, v) => {
                    showMessage(v[0], 'error');
                });
            } else {
                showMessage(response.message, 'error'); 
            }

            $('#btnSave, #btnSaveNew').prop('disabled', false);
        });
    });
    
  });
initSelect2()

</script>
