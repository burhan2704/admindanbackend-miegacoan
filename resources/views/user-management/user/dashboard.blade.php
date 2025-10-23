{{-- Dashboard --}}
<div class="row g-6 mb-6">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Total User</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-2">{{ $data->totalUser }}</h4>
              {{-- <p class="text-success mb-1">(+29%)</p> --}}
            </div>
            <small class="mb-0">Total Semua User</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded-3">
              <div class="ri-group-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
   <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">User Aktif</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{ $data->totalUserActive }}</h4>
              {{-- <p class="text-danger mb-1">(-14%)</p> --}}
            </div>
            <small class="mb-0">User Aktif Saat Ini</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-success rounded-3">
              <div class="ri-user-follow-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">User Tidak Aktif</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{ $data->totalUserInactive }}</h4>
              {{-- <p class="text-success mb-1">(+18%)</p> --}}
            </div>
            <small class="mb-0">User Tidak Aktif Saat Ini</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-danger rounded-3">
              <div class="ri-user-add-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Total User Login</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{ $data->totalUserOnline }}</h4>
              {{-- <p class="text-success mb-1">(+42%)</p> --}}
            </div>
            <small class="mb-0">User  / Online Saat Ini</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-warning rounded-3">
              <div class="ri-user-search-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>