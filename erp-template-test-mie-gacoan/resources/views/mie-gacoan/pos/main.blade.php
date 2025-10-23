  <!-- Header Menu -->
 <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
   {{-- left --}}
  <ol class="breadcrumb breadcrumb-style1 mb-2 mb-md-0">
    <li class="breadcrumb-item">
      <a href="{{ url('/home')}}"><span class="fs-5 fw-bold" style="color: #666cff;">Dashboard</span></a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('mie-gacoan-product')}}">
          <span class="fs-5 fw-bold" style="color: #666cff;">Product</span>
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
              {!! Form::select('type_desc', [null=>"Select", "RAW MATERIAL"=>"RAW MATERIAL", "MIE"=>"MIE", "DIMSUM"=>"DIMSUM", "ES BUAH"=>"ES BUAH", "BEVERAGE"=>"BEVERAGE"], $header ? $header->type_desc : null, [$disab, 'class' => 'select2 form-select', 'id' => 'type_desc']) !!}
              {!! Form::label('type_desc', 'Type') !!}
            </div>

            <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('prd_code', $header ? $header->prd_code : null, [
                $disab,
                'class' => 'form-control',
                'id' => 'prd_code',
                'placeholder' => 'Item Code',
                'required' => true
                ]) !!}
                {!! Form::label('prd_code', 'Item Code') !!}
                <div class="invalid-feedback">Please enter your item code</div>
            </div>

            <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('prd_desc', $header ? $header->prd_desc : null, [
                $disab,
                'class' => 'form-control',
                'id' => 'prd_desc',
                'placeholder' => 'Item Desc',
                'required' => true
                ]) !!}
                {!! Form::label('prd_desc', 'Item Desc') !!}
                <div class="invalid-feedback">Please enter your item desc</div>
            </div>

            <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('sales_price', $header ? $header->sales_price : 0, [
                $disab,
                'class' => 'form-control text-end format-num',
                'id' => 'sales_price',
                'placeholder' => 'Sales Price',
                'required' => true
                ]) !!}
                {!! Form::label('sale_price', 'Sales Price') !!}
                <div class="invalid-feedback">Please enter your sales price</div>
            </div>

            <div class="form-floating form-floating-outline mb-4">
                {!! Form::text('qoh', $header ? $header->qoh : 0, [
                $disab,
                'class' => 'form-control text-end format-num',
                'id' => 'qoh',
                'placeholder' => 'qoh',
                'required' => true
                ]) !!}
                {!! Form::label('qoh', 'Stock') !!}
                <div class="invalid-feedback">Please enter your Stock</div>
            </div>

            <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('uom_desc', [null=>"Select", "PCS"=>"PCS", "KG"=>"KG"], $header ? $header->uom_desc : null, [$disab, 'class' => 'select2 form-select', 'id' => 'uom_desc']) !!}
              {!! Form::label('uom_desc', 'UoM') !!}
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
    const delete_details = [];

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
            details: [],
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
