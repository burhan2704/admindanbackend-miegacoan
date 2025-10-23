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
          {{-- Dynamic nested children UI --}}
          <div class="mb-3">
            {{-- <button type="button" class="btn btn-sm btn-outline-primary" id="add-parent">Add Top-Level Menu</button> --}}
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-parent" disabled>Main Menu</button>
          </div>
          <div id="menu-nested-container" class="menu-tree"></div>

          <hr class="my-4">

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
  $(document).ready(function () {
    const disab = "{!! $disab !!}";
    const ke = "{!! $ke !!}";
    const header = {!! json_encode($header) !!};
    const menus = {!! json_encode($menus ?? []) !!};
    const delete_details = [];

    // Enable add-parent button initially
    // $('#add-parent').prop('disabled', false);

    $("#btnCancel").on("click", function () {
      cancelForm(true);
    });

    $('#mainForm #btnSave, #mainForm #btnSaveNew').click(function (e) {
        e.preventDefault();

        loadingPage('show');

        $('#btnSave, #btnSaveNew').prop('disabled', true);

       const formData = Object.fromEntries(new FormData($('#mainForm form')[0]));

        const children = collectChildren();

        const data = Object.assign(formData, {
          id: header ? header.id : null,
          ke: ke,
          menu: children,
          delete_details: delete_details
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
                // After saving and new, re-add a parent if it was empty
                if ($('#menu-nested-container').children().length === 0) {
                    $('#add-parent').click();
                }
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

    $('#add-parent').click(function () {
      $('#menu-nested-container').append(renderMenuItem('parent'));
    });

    $(document).on('click', '.add-child', function () {
      $(this).closest('.menu-item').find('> .children-container')
        .append(renderMenuItem('child'));
    });

    $(document).on('click', '.add-grandchild', function () {
      $(this).closest('.menu-item').find('> .grandchildren-container')
        .append(renderMenuItem('grandchild'));
    });

    $(document).on('click', '.add-grandchild2', function () {
      $(this).closest('.menu-item').find('> .grandchild2-container')
        .append(renderMenuItem('grandchild2'));
    });

    $(document).on('click', '.add-grandchild3', function () {
      $(this).closest('.menu-item').find('> .grandchild3-container')
        .append(renderMenuItem('grandchild3'));
    });

    $(document).on('click', '.remove-item', function () {
        const $itemToRemove = $(this).closest('.menu-item');
        // if (confirm('Are you sure you want to remove this menu item and its children?')) {
            // If this item was pre-filled (has an ID), mark it for deletion in the backend
            if ($itemToRemove.data('id')) {
                delete_details.push($itemToRemove.data('id'));
            }
            $itemToRemove.remove();
            // If no more parents, enable add-parent button
            if ($('#menu-nested-container .menu-item[data-level="parent"]').length === 0 && ke === 'updateData') {
                 $('#add-parent').prop('disabled', false);
            }
        // }
    });

    function renderMenuItem(level = 'parent', menuId = null) {
      let indentClass = '';
      let buttons = '';
      let nestedContainers = '';
      let namePlaceholder = '';
      let routePlaceholder = '';
      let iconPlaceholder = '';
      let seqIdPlaceholder = '';
      let addButtonClass = ''; // For outline buttons

      switch (level) {
        case 'parent':
          indentClass = ''; // No extra indent for parent
          addButtonClass = 'btn-primary'; // Info for child add
          buttons = `<button type="button" class="btn btn-sm ${addButtonClass} add-child" title="Add Child">+ Child 1</button>`;
          nestedContainers = '<div class="children-container menu-branch"></div>';
          namePlaceholder = 'Top-Level Name';
          routePlaceholder = 'top-level-route';
          iconPlaceholder = 'mdi mdi-cube';
          seqIdPlaceholder = '100';
          break;
        case 'child':
          indentClass = 'level-1'; // Custom class for tree indent
          addButtonClass = 'btn-outline-info'; // Secondary for grandchild add
          buttons = `<button type="button" class="btn btn-sm ${addButtonClass} add-grandchild" title="Add Grandchild">+ Child 2</button>`;
          nestedContainers = '<div class="grandchildren-container menu-branch"></div>';
          namePlaceholder = 'Child 1 Name';
          routePlaceholder = 'Child 1 Route';
          iconPlaceholder = '';
          seqIdPlaceholder = '200';
          break;
        case 'grandchild':
          indentClass = 'level-2'; // Custom class for tree indent
          addButtonClass = 'btn-success'; // Success for grandchild2 add
          buttons = `<button type="button" class="btn btn-sm ${addButtonClass} add-grandchild2" title="Add Grandchild2">+ Child 3</button>`;
          nestedContainers = '<div class="grandchild2-container menu-branch"></div>';
          namePlaceholder = 'Child 2 Name';
          routePlaceholder = 'Child 2 Route';
          iconPlaceholder = '';
          seqIdPlaceholder = '300';
          break;
        case 'grandchild2':
          indentClass = 'level-3'; // Custom class for tree indent
          addButtonClass = 'btn-outline-secondary'; // Warning for grandchild3 add
          buttons = `<button type="button" class="btn btn-sm ${addButtonClass} add-grandchild3" title="Add Grandchild3">+ Child 4</button>`;
          nestedContainers = '<div class="grandchild3-container menu-branch"></div>';
          namePlaceholder = 'Child 3 Name';
          routePlaceholder = 'Child 3 Route';
          iconPlaceholder = '';
          seqIdPlaceholder = '400';
          break;
        case 'grandchild3':
          indentClass = 'level-4'; // Custom class for tree indent
          // No more levels, so no "add" button
          buttons = '';
          nestedContainers = '';
          namePlaceholder = 'Child 4 Name';
          routePlaceholder = 'Child 4 Route';
          iconPlaceholder = '';
          seqIdPlaceholder = '500';
          break;
      }
      // Use btn-outline-danger for remove button
      const removeButton = `<button type="button" class="btn btn-sm btn-outline-danger remove-item" title="Remove Item"><i class="ri-close-line ri-20px pointer " title="View"></i></button>`;

      return `
        <div class="menu-item ${indentClass}" data-level="${level}" ${menuId ? `data-id="${menuId}"` : ''}>
          <div class="menu-item-content border rounded p-2 mb-2 d-flex align-items-center justify-content-between gap-2">
            <div class="row flex-grow-1 g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="${namePlaceholder}" data-name>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="${routePlaceholder}" data-route>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="${iconPlaceholder}"  data-icon ${iconPlaceholder == '' ? 'disabled' : ''}>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" placeholder="${seqIdPlaceholder}" data-seq-id>
                </div>
            </div>
            <div class="d-flex flex-shrink-0 gap-1">
              ${buttons}
              ${level == 'parent' ? '' : removeButton}
            </div>
          </div>
          ${nestedContainers}
        </div>`;
    }

    function fillMenuData($el, data) {
      $el.find('[data-name]').val(data.name);
      $el.find('[data-route]').val(data.route);
      $el.find('[data-icon]').val(data.icon);
      $el.find('[data-seq-id]').val(data.seq_id);
      if (data.id) { // Store ID for potential deletion tracking
          $el.attr('data-id', data.id);
      }
    }

    function collectChildren() {
      const data = [];
      $('#menu-nested-container .menu-item[data-level="parent"]').each(function () {
        const parent = extractData($(this));
        parent.child = [];

        $(this).find('> .menu-branch > .menu-item[data-level="child"]').each(function () {
          const child = extractData($(this));
          child.grandChild = [];

          $(this).find('> .menu-branch > .menu-item[data-level="grandchild"]').each(function () {
            const grandchild = extractData($(this));
            grandchild.grandChild2 = [];

            $(this).find('> .menu-branch > .menu-item[data-level="grandchild2"]').each(function () {
              const grandchild2 = extractData($(this));
              grandchild2.grandChild3 = [];

              $(this).find('> .menu-branch > .menu-item[data-level="grandchild3"]').each(function () {
                const grandchild3 = extractData($(this));
                grandchild2.grandChild3.push(grandchild3);
              });
              grandchild.grandChild2.push(grandchild2);
            });
            child.grandChild.push(grandchild);
          });
          parent.child.push(child);
        });
        data.push(parent);
      });
      return data;
    }

    function extractData($el) {
        return {
            id: $el.data('id') || null, // Include ID if present
            name: $el.find('[data-name]').val(),
            route: $el.find('[data-route]').val(),
            icon: $el.find('[data-icon]').val(),
            seq_id: parseInt($el.find('[data-seq-id]').val()) || 0
        };
    }

    // Kondisi awal: auto klik atau render
    if (ke === 'createData') {
      $('#add-parent').click();
    }

    if (ke === 'updateData' && menus.length > 0) {
      menus.forEach(parent => {
        const $parent = $(renderMenuItem('parent', parent.id)); // Pass ID
        fillMenuData($parent, parent);

        parent.child.forEach(child => {
          const $child = $(renderMenuItem('child', child.id)); // Pass ID
          fillMenuData($child, child);

          child.grandChild.forEach(grand => {
            const $grand = $(renderMenuItem('grandchild', grand.id)); // Pass ID
            fillMenuData($grand, grand);

            if (grand.grandChild2) {
              grand.grandChild2.forEach(grand2 => {
                const $grand2 = $(renderMenuItem('grandchild2', grand2.id)); // Pass ID
                fillMenuData($grand2, grand2);

                if (grand2.grandChild3) {
                  grand2.grandChild3.forEach(grand3 => {
                    const $grand3 = $(renderMenuItem('grandchild3', grand3.id)); // Pass ID
                    fillMenuData($grand3, grand3);
                    $grand2.find('> .menu-branch').append($grand3);
                  });
                }
                $grand.find('> .menu-branch').append($grand2);
              });
            }
            $child.find('> .menu-branch').append($grand);
          });
          $parent.find('> .menu-branch').append($child);
        });
        $('#menu-nested-container').append($parent);
      });
    }
  });
</script>


<style>
:root {
  --color-text-primary: #333;
  --color-border-light: #e0e0e0;
  --color-background-card: #fff;
  --color-shadow-subtle: rgba(0, 0, 0, 0.05);
  --color-shadow-lighter: rgba(0, 0, 0, 0.03);
  --color-border-parent: #6a82fb;
  --color-border-child: #55c2da;
  --color-border-grandchild: #8c8c8c;
  --color-border-grandchild2: #4CAF50;
  --color-border-grandchild3: #FFC107;
  --color-focus-border: #80bdff;
  --color-focus-shadow: rgba(0, 123, 255, 0.25);
  --spacing-unit: 8px;
  --border-radius-small: 8px;
  --border-radius-medium: 12px;
  --border-width-thin: 1px;
  --border-width-medium: 1.5px;
  --indent-level: 30px;
  --line-offset-x: 15px;
  --line-offset-y: 20px;
}

body {
  font-family: 'Inter', sans-serif;
  color: var(--color-text-primary);
  line-height: 1.6;
}

.card {
  border-radius: var(--border-radius-medium);
  box-shadow: 0 4px 10px var(--color-shadow-subtle);
}

.form-control {
  border-radius: var(--border-radius-small);
  padding: 0.75rem 1rem;
  border: var(--border-width-thin) solid var(--color-border-light);
  transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.form-control:focus {
  border-color: var(--color-focus-border);
  box-shadow: 0 0 0 0.25rem var(--color-focus-shadow);
  outline: none;
}

.btn {
  border-radius: var(--border-radius-small);
  font-weight: 500;
  transition: all 0.2s ease-in-out;
}

.btn-outline-primary,
.btn-outline-secondary,
.btn-outline-info,
.btn-outline-success,
.btn-outline-warning,
.btn-outline-danger {
  border-width: var(--border-width-medium);
}

.menu-item .form-control[data-level="parent"] {
  border-color: var(--color-border-parent);
}
.menu-item .form-control[data-level="child"] {
  border-color: var(--color-border-child);
}
.menu-item .form-control[data-level="grandchild"] {
  border-color: var(--color-border-grandchild);
}
.menu-item .form-control[data-level="grandchild2"] {
  border-color: var(--color-border-grandchild2);
}
.menu-item .form-control[data-level="grandchild3"] {
  border-color: var(--color-border-grandchild3);
}

.menu-tree {
  position: relative;
  padding-top: var(--spacing-unit);
}

.menu-item {
  position: relative;
  margin-bottom: 0;
  background-color: transparent;
}

.menu-item.level-0 {
  padding-left: 0;
}
.menu-item.level-1 {
  padding-left: var(--indent-level);
}
.menu-item.level-2 {
  padding-left: calc(2 * var(--indent-level));
}
.menu-item.level-3 {
  padding-left: calc(3 * var(--indent-level));
}
.menu-item.level-4 {
  padding-left: calc(4 * var(--indent-level));
}

.menu-item-content {
  position: relative;
  background-color: var(--color-background-card);
  box-shadow: 0 2px 5px var(--color-shadow-lighter);
  margin-bottom: var(--spacing-unit);
  padding: var(--spacing-unit);
  border-radius: var(--border-radius-small);
  display: flex;
  align-items: center;
}

.menu-branch {
  position: relative;
}

.menu-branch::before {
  content: '';
  position: absolute;
  top: 0;
  left: var(--line-offset-x);
  width: var(--border-width-thin);
  height: 100%;
  background-color: var(--color-border-light);
  z-index: 1;
}

.menu-item:not(.level-0)::before {
  content: '';
  position: absolute;
  top: var(--line-offset-y);
  left: calc(var(--line-offset-x) - var(--indent-level));
  width: var(--line-offset-x);
  height: var(--border-width-thin);
  background-color: var(--color-border-light);
  z-index: 2;
}

.menu-branch > .menu-item:last-of-type::before {

}

.menu-item:not(.level-0)::after {
  content: '';
  position: absolute;
  top: var(--line-offset-y);
  left: calc(var(--line-offset-x) - var(--indent-level) + var(--line-offset-x));
  width: 4px;
  height: 4px;
  background-color: var(--color-border-light);
  border-radius: 50%;
  z-index: 3;
}
</style>
