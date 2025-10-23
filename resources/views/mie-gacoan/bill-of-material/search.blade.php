@php
use Illuminate\Support\Arr;

@endphp
<form id="searchForm" onsubmit="return false;">

  <div class="card card-body">
    <!-- First Row of Filters -->
    <div class="row mb-3">
      <div class="col-md-4">
        <label for="status" class="form-label">Status</label>
        {!! Form::select('status', ['' => 'All'] + Arr::pluck($status, 'code', 'id'), '', ['id'=>'status', 'class'=>'form-control select2', 'placeholder'=>"Pilih"]) !!}
      </div>

      <div class="col-md-4">
        <label for="bom_code" class="form-label">Bom Code</label>
        <input type="text" id="bom_code"  name="bom_code" class="form-control" placeholder="">
      </div>

      <div class="col-md-4">
        <label for="bom_desc" class="form-label">Bom Desc</label>
        <input type="text" id="bom_desc"  name="bom_desc" class="form-control" placeholder="">
      </div>

    </div>

    <!-- Second Row of Filters -->
    <div class="collapse row mb" id="filter-section">
        <div class="col-md-4">
        <label for="prd_desc" class="form-label">Item</label>
        <input type="text" id="prd_desc"  name="prd_desc" class="form-control" placeholder="Item Code / Item Desc">
      </div>
      <div class="col-md-4">
      </div>
    </div>
    <hr>
    <!-- Action Buttons -->
    <div class="d-flex justify-content-start gap-2">
      <button
        class="btn btn-outline-secondary collapse-toggle-btn"
        data-bs-toggle="collapse"
        data-bs-target="#filter-section"
        data-label-more="More"
        data-label-less="Less"
        type="button">
        <i class="ri-arrow-down-double-line icon-more me-1"></i>
        <i class="ri-arrow-up-double-line icon-less me-1 d-none"></i>
        <span class="toggle-label">More</span>
        </button>
        <button class="btn btn-outline-secondary" id="btnRefresh">
            <i class="ri-refresh-line me-1"></i>Refresh
        </button>
        <button class="btn btn-primary" id="btnSearch">
            <i class="ri-search-line me-1"></i>Search
        </button>
    </div>
  </div>
</form>
