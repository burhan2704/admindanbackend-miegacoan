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
          
        {{-- Code --}}
        <div class="form-floating form-floating-outline mb-4">
          {!! Form::text('code', $header ? $header->code : null, [
            $disab,
            'class' => 'form-control',
            'id' => 'code',
            'placeholder' => 'Enter Code',
            'required' => true
          ]) !!}
          {!! Form::label('code', 'Code') !!}
          <div class="invalid-feedback">Please enter a valid code</div>
        </div>

        {{-- Name --}}
        <div class="form-floating form-floating-outline mb-4">
          {!! Form::text('name', $header ? $header->name : null, [
            $disab,
            'class' => 'form-control',
            'id' => 'name',
            'placeholder' => 'Enter Name',
            'required' => true
          ]) !!}
          {!! Form::label('name', 'Name') !!}
          <div class="invalid-feedback">Please Enter name</div>
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
            <button type="button" class="btn btn-outline-secondary" id="btnCancel" >Cancel</button>
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
                // dtDetail.clear().draw();
                // dtDetail.rows().nodes().to$().find('input[type="checkbox"]').each(function () {
                //     this.checked = false;
                // });
                
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
      initSelect2();

</script>
