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
          
          {{-- Full Name --}}
          <div class="form-floating form-floating-outline mb-4">
            {!! Form::text('name', $header ? $header->name : null, [
              $disab,
              'class' => 'form-control',
              'id' => 'name',
              'placeholder' => 'John Doe',
              'required' => true
            ]) !!}
            {!! Form::label('name', 'Full Name') !!}
            <div class="invalid-feedback">Please enter your full name</div>
          </div>

          {{-- Email --}}
          <div class="form-floating form-floating-outline mb-4">
            {!! Form::email('email', $header ? $header->email : null, [
              $disab,
              'class' => 'form-control',
              'id' => 'email',
              'placeholder' => 'name@example.com',
              'required' => true
            ]) !!}
            {!! Form::label('email', 'Email') !!}
            <div class="invalid-feedback">Please enter a valid email</div>
          </div>

          {{-- Password --}}
          <div class="form-password-toggle mb-4">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline flex-grow-1">
                {!! Form::password('password', [
                  $disab,
                  'class' => 'form-control',
                  'id' => 'password',
                  'placeholder' => 'Password',
                  'required' => true
                ]) !!}
                {!! Form::label('password', 'Password') !!}
              </div>
              <span class="input-group-text cursor-pointer" id="togglePassword">
                <i class="ri-eye-off-line" id="toggleIcon"></i>
              </span>
            </div>
            <div class="invalid-feedback">Please enter your password</div>
          </div>

           <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('department_id', [null=>"Select"] + Arr::pluck($department, 'code', 'id'), $header ? $header->department_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'department_id']) !!}
              {!! Form::label('department_id', 'Department') !!}
          </div>

          <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('position_id', [null=>"Select"] + Arr::pluck($position, 'code', 'id'), $header ? $header->position_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'position_id']) !!}
              {!! Form::label('position_id', 'Position') !!}
          </div>

          <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('level_id', [null=>"Select"] + Arr::pluck($level, 'code', 'id'), $header ? $header->level_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'level_id']) !!}
              {!! Form::label('level_id', 'Level') !!}
          </div>

          <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('parent_user_id', [null=>"Select"] + Arr::pluck($approver, 'code', 'id'), $header ? $header->parent_user_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'parent_user_id']) !!}
              {!! Form::label('parent_user_id', 'Approver / Direct Supervisor') !!}
          </div>

          <div class="form-floating form-floating-outline mb-4">
              {!! Form::select('role_id', [null=>"Select"] + Arr::pluck($role, 'code', 'id'), $header ? $header->role_id : null, [$disab, 'class' => 'select2 form-select', 'id' => 'role_id']) !!}
              {!! Form::label('role_id', 'Role') !!}
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

    $('#company_id').change(() => {
        loadingPage('show');

        $.ajax({
            type: "POST",
            data: {
                _token: TOKEN, 
                ke: 'listDepartment', 
                company_id: $('#company_id').val(),
            },
            url: URI,
            success: (res) => {
                $('#department_id').html(dropDown(res))
                loadingPage('hide');
            },
            error: (xhr) => {
                loadingPage('hide');
                showMessage('alert-form', [xhr.responseText],'error');
            }
        });

    });

    $('#department_id').change(() => {
        loadingPage('show');

        $.ajax({
            type: "POST",
            data: {
                _token: TOKEN, 
                ke: 'listPosition', 
                department_id: $('#department_id').val(),
            },
            url: URI,
            success: (res) => {
                $('#position_id').html(dropDown(res))
                loadingPage('hide');
            },
            error: (xhr) => {
                loadingPage('hide');
                showMessage('alert-form', [xhr.responseText],'error');
            }
        });

    });

    $('#position_id').change(() => {
        loadingPage('show');

        $.ajax({
            type: "POST",
            data: {
                _token: TOKEN, 
                ke: 'listLevel', 
                position_id: $('#position_id').val(),
            },
            url: URI,
            success: (res) => {
                $('#level_id').html(dropDown(res))
                loadingPage('hide');
            },
            error: (xhr) => {
                loadingPage('hide');
                showMessage('alert-form', [xhr.responseText],'error');
            }
        });

    });

    $('#togglePassword').on('click', function () {
      const passwordInput = $('#password');
      const icon = $('#toggleIcon');

      const isPassword = passwordInput.attr('type') === 'password';
      passwordInput.attr('type', isPassword ? 'text' : 'password');
      icon
        .removeClass(isPassword ? 'ri-eye-off-line' : 'ri-eye-line')
        .addClass(isPassword ? 'ri-eye-line' : 'ri-eye-off-line');
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

</script>
