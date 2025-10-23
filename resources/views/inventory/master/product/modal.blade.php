<!-- Modal Add Detail -->
<div class="modal fade" id="modalAddDetail" tabindex="-1" aria-labelledby="modalAddDetailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddDetailLabel">Add Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <hr>
      <div class="modal-body">
        <div class="mb-3">
          <label for="colorSelect" class="form-label">Color</label>
          <select class="form-select" id="colorSelect">
            <option value="">Select Color</option>
            <option value="Red">Red</option>
            <option value="Blue">Blue</option>
            <option value="Green">Green</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Size</label>
          <div class="mb-2">
            <button type="button" class="btn btn-sm btn-outline-primary me-1" id="btnCheckAllSize">Check All</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnUncheckAllSize">Uncheck All</button>
          </div>
          <div id="sizeCheckboxList">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="S" id="sizeS">
              <label class="form-check-label" for="sizeS">S</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="M" id="sizeM">
              <label class="form-check-label" for="sizeM">M</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="L" id="sizeL">
              <label class="form-check-label" for="sizeL">L</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="XL" id="sizeXL">
              <label class="form-check-label" for="sizeXL">XL</label>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnInsertDetail">Insert</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  $('#btnCheckAllSize').on('click', function() {
    $('#sizeCheckboxList input[type=checkbox]').prop('checked', true);
  });
  $('#btnUncheckAllSize').on('click', function() {
    $('#sizeCheckboxList input[type=checkbox]').prop('checked', false);
  });
});
</script>
