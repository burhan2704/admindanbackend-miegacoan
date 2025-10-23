
initImageUploader = (options) => {
    const { imagePreview, fileInput, fileInfo, logoPreview } = options;

    // Click to upload
    imagePreview.on('click', function() {
        fileInput.click();
    });

    // Handle file selection
    fileInput.on('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.type.match('image.*')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Create image preview
                    if (logoPreview && logoPreview.length) {
                        logoPreview.attr('src', e.target.result);
                    } else {
                        imagePreview.html(`<img src="${e.target.result}" alt="Preview" class="logo-preview">`);
                    }

                    // Show file info with buttons
                    fileInfo.removeClass('d-none').html(`
                        <span>${file.name}</span>
                        <button class="btn-view" title="View Image">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button class="btn-clear" title="Remove Image">
                            <i class="ri-close-line"></i>
                        </button>
                    `);
                };

                reader.readAsDataURL(file);
            } else {
                alert('Please select an image file.');
            }
        }
    });

    // Handle drag and drop
    imagePreview.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    imagePreview.on('dragleave', function() {
        $(this).removeClass('dragover');
    });

    imagePreview.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');

        const file = e.originalEvent.dataTransfer.files[0];
        if (file && file.type.match('image.*')) {
            fileInput[0].files = e.originalEvent.dataTransfer.files;
            fileInput.trigger('change');
        } else {
            alert('Please drop an image file.');
        }
    });

    // Handle clear button (using event delegation)
    $(document).on('click', '.btn-clear', function(e) {
        e.stopPropagation();
        fileInput.val('');
        imagePreview.html(`
            <div class="upload-placeholder">
                <i class="ri-upload-cloud-2-line fs-1"></i>
                <p>click to upload</p>
            </div>
        `);
        fileInfo.addClass('d-none');
    });

    // Handle view button (using event delegation)
    $(document).on('click', '.btn-view', function(e) {
        e.stopPropagation();
        const imgSrc = imagePreview.find('.logo-preview').attr('src') ||
                    (logoPreview && logoPreview.attr('src'));

        if (!imgSrc) return;

        // Create modal to view larger image
        const modal = `
            <div class="image-modal" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            ">
                <div style="position: relative;">
                    <img src="${imgSrc}" style="max-width: 90vw; max-height: 90vh;">
                    <button class="close-modal" style="
                        position: absolute;
                        top: -40px;
                        right: 0;
                        background: none;
                        border: none;
                        color: white;
                        font-size: 2rem;
                        cursor: pointer;
                    ">&times;</button>
                </div>
            </div>
        `;

        $('body').append(modal);

        // Close modal
        $('.close-modal').on('click', function() {
            $('.image-modal').remove();
        });
    });

    // Close modal when clicking outside image
    $(document).on('click', '.image-modal', function(e) {
        if (e.target === this) {
            $(this).remove();
        }
    });
}

initSelect2 = (selector = '.select2', options = {}) => {
    const defaultOptions = {
        placeholder: "Select",
        allowClear: true,
        width: '100%'
    };

    // initializeSelect2('.my-select', { placeholder: "Choose an option", minimumResultsForSearch: 5 });
    const config = $.extend({}, defaultOptions, options); // Gabungkan opsi default dengan opsi kustom
    $(selector).select2(config);
}


const formatNumber = () => {
  $(document).ready(() => {

    $(".format-num")
      .off("blur")
      .on("blur", function() {
        $(this).val(buatNumber($(this).val(), 2));
      });

    $(".format-int")
      .off("blur")
      .on("blur", function() {
        $(this).val(buatNumber($(this).val(), 0));
      });

    $('.format-num, .format-int').each(function() {
      $(this).val(buatNumber($(this).val(), $(this).hasClass('format-num') ? 2 : 0));
    });
  });
};


const buatNumber = (num, fraction = 2) => {
  num = num || 0;

  const is_negative = num.toString().trim().charAt(0) === "-";

  num = num.toString().replace(/[^\d.]/g, "");

  let parsed = parseFloat(num);
  if (isNaN(parsed)) parsed = 0;

  const formatted = new Intl.NumberFormat('en-US', {
    minimumFractionDigits: fraction,
    maximumFractionDigits: fraction
  }).format(parsed);

  return is_negative ? `-${formatted}` : formatted;
};



