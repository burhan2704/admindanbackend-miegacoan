

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
        <div class="row mt-1 g-5">
            <!-- Left Column -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4" id="uploadImageDragAndDrop">
                    <div class="text-light small fw-medium">Company Logo</div>
                    <div class="image-uploader">
                        <div class="image-preview" id="imagePreview">
                            @if(isset($header) && $header->logo)
                                <img src="{{ asset($header->logo) }}" alt="Company Logo" id="logoPreview">
                            @else
                                <div class="upload-placeholder">
                                    <i class="ri-upload-cloud-2-line fs-1"></i>
                                    <p>Drag & drop or click to upload</p>
                                </div>
                            @endif
                        </div>
                        <div class="file-info d-none" id="fileInfo">
                            <span id="fileName">{{ $header->logo ?? 'No file selected' }}</span>
                        </div>
                        <input type="file" id="logo_file" name="logo_file" accept="image/*" class="d-none">
                    </div>
                </div>

                <!-- Code -->
                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('code', $header ? $header->code : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'code',
                        'placeholder' => 'Code',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('code', 'Code') !!}
                </div>

                 <!-- Name -->
                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('name', $header ? $header->name : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'name',
                        'placeholder' => 'Name',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('name', 'Name') !!}
                </div>

                 <!-- Short Description -->
                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('short_desc', $header ? $header->short_desc : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'short_desc',
                        'placeholder' => 'Short Desc',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('short_desc', 'Short Desc') !!}
                </div>

                <!-- Email -->
                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::email('email', $header ? $header->email : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'email',
                        'placeholder' => 'name@example.com',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('email', 'Email') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('phone', $header ? $header->phone : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'phone',
                        'placeholder' => 'Phone',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('phone', 'Phone') !!}
                </div>

                 <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('whatsapp', $header ? $header->whatsapp : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'whatsapp',
                        'placeholder' => 'Whatsapp',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('whatsapp', 'Whatsapp') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                  {!! Form::text('domain', $header ? $header->domain : null, [
                      $disab,
                      'class' => 'form-control',
                      'id' => 'domain',
                      'placeholder' => 'Domain',
                      'required' => true,
                  ]) !!}
                  {!! Form::label('domain', 'Domain') !!}
              </div>
                 
            </div>

            <div class="col-md-6">
                 <div class="form-floating form-floating-outline mb-4">
                    {!! Form::textarea('address', $header ? $header->address : null, [
                        $disab,
                        'class' => 'form-control h-px-100',
                        'id' => 'address',
                        'placeholder' => 'Address',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('address', 'Address') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::select('province_id', [null=>"Select"] + Arr::pluck($province, 'code', 'id'), $header ? $header->province_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'province_id']) !!}
                    {!! Form::label('province_id', 'Province') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::select('city_id', [null=>"Select"] + Arr::pluck($city, 'code', 'id'), $header ? $header->city_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'city_id']) !!}
                    {!! Form::label('city_id', 'City') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                        {!! Form::select('sub_district_id', [null=>"Select"] + Arr::pluck($sub_district, 'code', 'id'), $header ? $header->sub_district_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'sub_district_id']) !!}
                        {!! Form::label('sub_district_id', 'Sub District') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('zip_code', $header ? $header->zip_code : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'zip_code',
                        'placeholder' => 'Zip Code',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('zip_code', 'Zip Code') !!}
                </div>

                <div class="form-floating form-floating-outline mb-4">
                    {!! Form::text('country', $header ? $header->country : null, [
                        $disab,
                        'class' => 'form-control',
                        'id' => 'country',
                        'placeholder' => 'Country',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('country', 'Country') !!}
                </div>


                   <div class="form-floating form-floating-outline mb-4">
                  {!! Form::text('npwp', $header ? $header->npwp : null, [
                      $disab,
                      'class' => 'form-control',
                      'id' => 'npwp',
                      'placeholder' => 'NPWP',
                      'required' => true,
                  ]) !!}
                  {!! Form::label('npwp', 'NPWP') !!}
              </div>

              
              <div class="form-floating form-floating-outline mb-4">
                  {!! Form::text('fax', $header ? $header->fax : null, [
                      $disab,
                      'class' => 'form-control',
                      'id' => 'fax',
                      'placeholder' => 'Fax',
                      'required' => true,
                  ]) !!}
                  {!! Form::label('fax', 'Fax') !!}
              </div>

               <div class="form-floating form-floating-outline mb-4">
                  {!! Form::text('po_box', $header ? $header->po_box : null, [
                      $disab,
                      'class' => 'form-control',
                      'id' => 'po_box',
                      'placeholder' => 'Po. Box',
                      'required' => true,
                  ]) !!}
                  {!! Form::label('po_box', 'Po. Box') !!}
              </div>

              <!-- Active Flag -->
              <div class="form-floating form-floating-outline mb-4" style="{{ Auth::user()->is_superadmin == true ? '' : 'display: none;' }}">

                  <div class="text-light small fw-medium">Active Flag</div>
                  <div class="demo-vertical-spacing">
                      <label class="switch" >
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

            </div>
            
        </div>          

          <hr>
          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-secondary" id="btnCancel" >Cancel</button>
            {{-- <button type="submit" class="btn btn-outline-secondary" id="btnSaveCancel" {{ $disab }}>Save & Cancel</button> --}}
            {{-- <button type="submit" class="btn btn-primary" id="btnSave" {{ $disab }}>Save</button> --}}

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
    
    initImageUploader({
        imagePreview: $('#imagePreview'),
        fileInput: $('#logo_file'),
        fileInfo: $('#fileInfo'),
        logoPreview: $('#logoPreview') 
    });

    const disab = "{!! $disab !!}";
    const ke = "{!! $ke !!}";
    const header = {!! json_encode($header) !!};
    const details = [];
    const delete_details = [];

    
    $('#province_id').change(() => {
        loadingPage('show');

        $.ajax({
            type: "POST",
            data: {
                _token: TOKEN, 
                ke: 'listCity', 
                province_id:  $('#province_id').val()
            },
            url: URI,
            success: (res) => {
                $('#city_id').html(dropDown(res))
                loadingPage('hide');

                
            },
            error: (xhr) => {
                loadingPage('hide');
                showMessage('alert-form', [xhr.responseText],'error');
            }
        });

    });

    $('#city_id').change(() => {
        loadingPage('show');

        $.ajax({
            type: "POST",
            data: {
                _token: TOKEN, 
                ke: 'listSubDistrict', 
                city_id: $('#city_id').val(),
                province_id: $('#province_id').val(),
            },
            url: URI,
            success: (res) => {
                $('#sub_district_id').html(dropDown(res))
                loadingPage('hide');

                
            },
            error: (xhr) => {
                loadingPage('hide');
                showMessage('alert-form', [xhr.responseText],'error');
            }
        });

    });

    $("#btnCancel").on("click", function() {
        cancelForm(true);
    });

    $('#mainForm #btnSave, #mainForm #btnSaveNew').click(function (e) {
        e.preventDefault();

        loadingPage('show'); 

        $('#btnSave, #btnSaveNew').prop('disabled', true); 

        const formData = new FormData($("#mainForm form")[0]);

        submitFormFiles({
            id: header ? header.id : null,
            ke: ke,
            form_data: formData,
            details: details,
            delete_details: delete_details
        })
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
</script>
