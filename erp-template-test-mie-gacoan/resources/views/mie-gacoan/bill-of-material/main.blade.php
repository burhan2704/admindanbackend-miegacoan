<!-- Header Menu -->
 <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
   {{-- left --}}
  <ol class="breadcrumb breadcrumb-style1 mb-2 mb-md-0">
    <li class="breadcrumb-item">
      <a href="{{ url('/home')}}"><span class="fs-5 fw-bold" style="color: #666cff;">Master</span></a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('mie-gacoan-product')}}">
          <span class="fs-5 fw-bold" style="color: #666cff;">{{ $data->title }}</span>
        </a>
    </li>

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

            <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('bom_code', $header ? $header->bom_code : null, [
                $disab,
                'class' => 'form-control',
                'id' => 'bom_code',
                'placeholder' => 'Bom Code',
                'required' => true
                ]) !!}
                {!! Form::label('bom_code', 'Bom Code') !!}
                <div class="invalid-feedback">Please enter your bom code</div>
            </div>


            <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('bom_desc', $header ? $header->bom_desc : null, [
                $disab,
                'class' => 'form-control',
                'id' => 'bom_desc',
                'placeholder' => 'Bom Desc',
                'required' => true
                ]) !!}
                {!! Form::label('bom_desc', 'Bom Desc') !!}
                <div class="invalid-feedback">Please enter your bom desc</div>
            </div>

            <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('prd_id', [null=>"Select"] + Arr::pluck($finish_goods, 'code', 'id'), $header ? $header->prd_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'prd_id']) !!}
              {!! Form::label('prd_id', 'Finish Goods') !!}
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

          <hr>
          <div class="card">
            <div class="card-datatable text-nowrap">
              <table id="dtDetail" class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 80px;">Action</th>
                    <th style="width: 40px;">No</th>
                    <th>Raw Material</th>
                    <th>Qty</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          <hr>
          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-secondary" title="Cancel" id="btnCancel" >Cancel</button>
            @if($ke == "createData")<button type="submit" class="btn btn-outline-primary" id="btnSaveNew">Save & New</button>@endif
            <button type="submit" class="btn btn-primary" id="btnSave" {{ $disab }}>Save</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    const disab = "{!! $disab !!}";
    const ke = "{!! $ke !!}";
    const header = {!! json_encode($header) !!};
    const raw_material = {!! json_encode($raw_material) !!};

   let dtDetailTable = null;
    const transactionDetails = {!! json_encode($detail) !!};
    const delete_details = [];

    function renderTransactionTable() {
        if (dtDetailTable) {
            dtDetailTable.clear();
            transactionDetails.forEach((item, idx) => {
                const rawOptions = raw_material.map(rm =>
                    `<option value="${rm.id}"${item.rm_id == rm.id ? ' selected' : ''}>${rm.code}</option>`
                ).join('');
                // Jika rm_id null, tambahkan option kosong di depan
                const selectHtml = item.rm_id === null
                    ? `<select class="select2 form-select rawSelect"><option value="" selected disabled>Pilih Raw Material</option>${rawOptions}</select>`
                    : `<select class="select2 form-select rawSelect">${rawOptions}</select>`;

                dtDetailTable.row.add([
                    `<button type="button" class="btn btn-sm btn-icon btn-danger btnDeleteDetail" data-idx="${idx}" title="Delete">
                        <i class="ri-delete-bin-6-line"></i>
                    </button>`,
                    idx + 1,
                    selectHtml,
                    `<input type="text" class="form-control text-end format-num qtyInput" min="0" value="${item.qty ?? 0}">`
                ]);
            });
            dtDetailTable.draw(false);

            setTimeout(() => {
                initSelect2();
                formatNumber();
            }, 10);
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
                attr: { id: 'btnAddDetail' },
                action: function () {
                    const rawOptions = raw_material.map(rm =>
                        `<option value="${rm.id}">${rm.code}</option>`
                    ).join('');

                    const newItem = {
                        rm_id: null,
                        qty: 0,
                    };
                    transactionDetails.push(newItem);
                    renderTransactionTable();
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

    // Render data awal dari backend
    renderTransactionTable();

    $(document).on('click', '.btnDeleteDetail', function() {
        const idx = $(this).data('idx');
        if (idx !== undefined) {
            // Jika ada id, masukkan ke delete_details
            if (transactionDetails[idx] && transactionDetails[idx].id) {
                delete_details.push(transactionDetails[idx].id);
            }
            transactionDetails.splice(idx, 1);
            renderTransactionTable();
        }
    });

    // Update array saat edit raw material dan qty
    $(document).on('change', '.rawSelect', function() {
        const idx = $(this).closest('tr').find('.btnDeleteDetail').data('idx');
        const selectedId = $(this).val();
        // Cek duplikat raw material kecuali baris sendiri
        let duplicate = false;
        transactionDetails.forEach((item, i) => {
            if (i !== idx && item.rm_id == selectedId && selectedId !== "") {
                duplicate = true;
            }
        });
        if (duplicate) {
            showMessage('Raw material sudah ada di detail lain!', 'error');
            transactionDetails[idx].rm_id = null;
            renderTransactionTable();
            return;
        }
        if (transactionDetails[idx]) {
            transactionDetails[idx].rm_id = selectedId;
        }
    });
    $(document).on('input', '.qtyInput', function() {
        const idx = $(this).closest('tr').find('.btnDeleteDetail').data('idx');
        if (transactionDetails[idx]) {
            transactionDetails[idx].qty = $(this).val();
        }
    });


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


  });
initSelect2()
formatNumber()

</script>
