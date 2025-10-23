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

          <div class="row">
            {{-- KIRI --}}
            <div class="col-md-6">
              {{-- Code --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('code', $header?->code, [$disab, 'class'=>'form-control', 'id'=>'code', 'placeholder'=>'Enter Code', 'required']) !!}
                {!! Form::label('code', 'Code') !!}
                <div class="invalid-feedback">Please enter a valid code</div>
              </div>

              {{-- Short Name --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('short_name', $header?->short_name, [$disab, 'class'=>'form-control', 'id'=>'short_name', 'placeholder'=>'Enter Short Name']) !!}
                {!! Form::label('short_name', 'Short Name') !!}
              </div>

              {{-- Product Category --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('prd_cat_id', [null=>'Select'] + $dropdowns['prd_cat'], $header?->prd_cat_id, [$disab, 'class'=>'select2 form-select', 'id'=>'prd_cat_id']) !!}
                {!! Form::label('prd_cat_id', 'Product Category') !!}
              </div>

              {{-- Group --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('group_id', [null=>'Select'] + $dropdowns['group'], $header?->group_id, [$disab, 'class'=>'select2 form-select', 'id'=>'group_id']) !!}
                {!! Form::label('group_id', 'Group') !!}
              </div>

              {{-- Size Group --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('size_group_id', [null=>'Select'] + $dropdowns['size_group'], $header?->size_group_id, [$disab, 'class'=>'select2 form-select', 'id'=>'size_group_id']) !!}
                {!! Form::label('size_group_id', 'Size Group') !!}
              </div>

              {{-- UOM 2 + Ratio --}}
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    {!! Form::select('uom2_id', [null=>'Select'] + $dropdowns['uom'], $header?->uom2_id, [$disab, 'class'=>'select2 form-select', 'id'=>'uom2_id']) !!}
                    {!! Form::label('uom2_id', 'UOM 2') !!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    {!! Form::number('uom2_ratio', $header?->uom2_ratio ?? 0, [$disab, 'class'=>'form-control', 'id'=>'uom2_ratio', 'step'=>'0.0001']) !!}
                    {!! Form::label('uom2_ratio', 'Ratio UOM2') !!}
                  </div>
                </div>
              </div>

              {{-- Min Stock --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::number('min_stock', $header?->min_stock ?? 0, [$disab, 'class'=>'form-control', 'id'=>'min_stock', 'step'=>'0.0001']) !!}
                {!! Form::label('min_stock', 'Min Stock') !!}
              </div>

              {{-- Supplier Product Code --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('supp_prd_code', $header?->supp_prd_code, [$disab, 'class'=>'form-control', 'id'=>'supp_prd_code', 'placeholder'=>'Enter Supplier Product Code']) !!}
                {!! Form::label('supp_prd_code', 'Supplier Product Code') !!}
              </div>
            </div>

            {{-- KANAN --}}
            <div class="col-md-6">
              {{-- Name --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('name', $header?->name, [$disab, 'class'=>'form-control', 'id'=>'name', 'placeholder'=>'Enter Name', 'required']) !!}
                {!! Form::label('name', 'Name') !!}
                <div class="invalid-feedback">Please Enter name</div>
              </div>

              {{-- Product Type --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('prd_type_id', [null=>'Select'] + $dropdowns['prd_type'], $header?->prd_type_id, [$disab, 'class'=>'select2 form-select', 'id'=>'prd_type_id']) !!}
                {!! Form::label('prd_type_id', 'Product Type') !!}
              </div>

              {{-- Brand --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('brand_id', [null=>'Select'] + $dropdowns['brand'], $header?->brand_id, [$disab, 'class'=>'select2 form-select', 'id'=>'brand_id']) !!}
                {!! Form::label('brand_id', 'Brand') !!}
              </div>

              {{-- Sub Group --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('sub_group_id', [null=>'Select'] + $dropdowns['sub_group'], $header?->sub_group_id, [$disab, 'class'=>'select2 form-select', 'id'=>'sub_group_id']) !!}
                {!! Form::label('sub_group_id', 'Sub Group') !!}
              </div>

              {{-- UOM1 --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::select('uom1_id', [null=>'Select'] + $dropdowns['uom'], $header?->uom1_id, [$disab, 'class'=>'select2 form-select', 'id'=>'uom1_id']) !!}
                {!! Form::label('uom1_id', 'UOM 1 (Primary)') !!}
              </div>

              {{-- UOM 3 + Ratio --}}
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    {!! Form::select('uom3_id', [null=>'Select'] + $dropdowns['uom'], $header?->uom3_id, [$disab, 'class'=>'select2 form-select', 'id'=>'uom3_id']) !!}
                    {!! Form::label('uom3_id', 'UOM 3') !!}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    {!! Form::number('uom3_ratio', $header?->uom3_ratio ?? 0, [$disab, 'class'=>'form-control', 'id'=>'uom3_ratio', 'step'=>'0.0001']) !!}
                    {!! Form::label('uom3_ratio', 'Ratio UOM3') !!}
                  </div>
                </div>
              </div>

              {{-- Max Stock --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::number('max_stock', $header?->max_stock ?? 0, [$disab, 'class'=>'form-control', 'id'=>'max_stock', 'step'=>'0.0001']) !!}
                {!! Form::label('max_stock', 'Max Stock') !!}
              </div>

              {{-- Supplier Product Name --}}
              <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('supp_prd_name', $header?->supp_prd_name, [$disab, 'class'=>'form-control', 'id'=>'supp_prd_name', 'placeholder'=>'Enter Supplier Product Name']) !!}
                {!! Form::label('supp_prd_name', 'Supplier Product Name') !!}
              </div>
            </div>
          </div>

          {{-- Header Image --}}
          <div class="form-floating form-floating-outline mb-4">
            <input type="file" name="header_image" class="form-control" id="header_image" accept="image/*" {{ $disab }}>
            {!! Form::label('header_image', 'Header Image') !!}
            @if (!empty($header->header_image))
              <img src="{{ asset('storage/'.$header->header_image) }}" alt="Header Image" class="mt-2" style="max-width: 200px;">
            @endif
          </div>

          <div class="form-floating form-floating-outline mb-4">
            <div class="text-light small fw-medium">Active Flag</div>
              <div class="demo-vertical-spacing">
                  <label class="switch">
                      {!! Form::checkbox('is_active', 1, $header ? (bool)$header->is_active : true, [
                          $disab,
                          'class' => 'switch-input',
                      ]) !!}
                      <span class="switch-toggle-slider">
                          <span class="switch-on"></span>
                          <span class="switch-off"></span>
                      </span>
                  </label>
              </div>
          </div>


          
          <hr/>
          <div class="card">
            <div class="card-datatable text-nowrap">
              <table id="dtDetail" class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 80px;">Action</th>
                    <th style="width: 40px;">No</th>
                    <th>Color</th>
                    <th>Size</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          @include('inventory.master.product.modal')
          <hr>
          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-secondary" id="btnCancel" >Cancel</button>
            @if($ke == "createData")<button type="submit" class="btn btn-outline-primary" id="btnSaveNew">Save & New</button>@endif
            <button type="submit" class="btn btn-primary" id="btnSave" {{ $disab }}>Save</button>


        </form>
      </div>
    </div>
  </div>
</div>


<script>
$(function() {
  let transactionDetails = [];
  const delete_details = [];
  let dtDetailTable = null;

  function renderTransactionTable() {
    if (dtDetailTable) {
      dtDetailTable.clear();
      transactionDetails.forEach((item, idx) => {
        dtDetailTable.row.add([
          `<button type="button" class="btn btn-sm btn-icon btn-danger btnDeleteDetail" data-idx="${idx}" title="Delete"><i class="ri-delete-bin-6-line"></i></button>`,
          idx + 1,
          item.color,
          item.size
        ]);
      });
      dtDetailTable.draw(false);
    }
  }

  dtDetailTable = $('#dtDetail').DataTable({
    scrollY: "500px",
    scrollX: true,
    paging: false,
    ordering: false,
    dom: '<"row align-items-center"<"col-sm-12 col-md-6 d-flex align-items-center"B><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    buttons: [
      {
        text: '<i class="ri-add-large-line me-1"></i>Add Detail',
        className: 'btn btn-primary',
        attr: {
          id: 'btnAddDetail',
          'data-bs-toggle': 'offcanvas',
          'data-bs-target': '#offcanvasAddUser'
        },
        action: function (e, dt, node, config) {
          $('#modalAddDetail').modal('show');
          $('#colorSelect').val('');
          $('#sizeCheckboxList input[type=checkbox]').prop('checked', false);
        }
      }
    ],
    language: {
      paginate: {
        next: '<i class="ri-arrow-right-s-line"></i>',
        previous: '<i class="ri-arrow-left-s-line"></i>',
      },
      emptyTable: 'No data available in table',
      info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      infoEmpty: 'Showing 0 to 0 of 0 entries',
      lengthMenu: 'Show _MENU_ entries',
      search: 'Search:',
    },
  });

  renderTransactionTable();

  $(document).on('click', '#btnAddDetail', function() {
    $('#modalAddDetail').modal('show');
    $('#colorSelect').val('');
    $('#sizeCheckboxList input[type=checkbox]').prop('checked', false);
  });

  $(document).on('click', '#btnInsertDetail', function() {
    const color = $('#colorSelect').val();
    const sizes = [];
    $('#sizeCheckboxList input[type=checkbox]:checked').each(function() {
      sizes.push($(this).val());
    });
    if (!color || sizes.length === 0) {
      alert('Please select color and at least one size.');
      return;
    }
    let duplicateFound = false;
    sizes.forEach(size => {
      if (transactionDetails.some(item => item.color === color && item.size === size)) {
        duplicateFound = true;
      }
    });
    if (duplicateFound) {
      alert('Combination of color and size already exists in the transaction detail.');
      return;
    }
    sizes.forEach(size => {
      transactionDetails.push({ color, size });
    });
    renderTransactionTable();
    $('#modalAddDetail').modal('hide');
  });

  $(document).on('click', '.btnDeleteDetail', function() {
    const idx = $(this).data('idx');
    if (transactionDetails[idx] && transactionDetails[idx].id) {
      delete_details.push(transactionDetails[idx].id);
    }
    transactionDetails.splice(idx, 1);
    renderTransactionTable();
  });

  const disab = "{!! $disab !!}";
  const ke = "{!! $ke !!}";
  const header = {!! json_encode($header) !!};

  $("#btnCancel").on("click", function() {
    cancelForm(true);
  });

  $('#mainForm #btnSave, #mainForm #btnSaveNew').click(function (e) {
    e.preventDefault();
    loadingPage('show');
    $('#btnSave, #btnSaveNew').prop('disabled', true);
    const formData = Object.fromEntries(new FormData($('#mainForm form')[0]));
    const data = $.extend(formData, {
      id: header ? header.id : null,
      ke: ke,
      details: $.map(transactionDetails, v => v),
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

  initSelect2();
});
</script>
