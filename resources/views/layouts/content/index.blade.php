@extends('layouts.app')

@section('content')
    <div id="dynamicContent">
        @include($content)
    </div>
    <div id="primaryForm" style="display:none;"></div>
@endsection

<script src="{{ asset('core-template/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('core-template/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>


<script type="text/javascript">

    const TOKEN = '{!! csrf_token() !!}';
	const URI = '{!! $data->url !!}';
    const baseUrl = window.location.origin;
    const AUTH = {!! json_encode(Auth::user()) !!};

    
    loadingPage = (args) => {
        args == "show" ? $("#fullscreen-loader").fadeIn("slow") : 
                $("#fullscreen-loader").fadeOut("slow"); 
    }

    getForm = () => {
        loadingPage('show');

        setTimeout(() => {
            $('#dynamicContent').hide();

            $.ajax({
                type: "GET",
                url: URI+"/getForm",
                timeout: 10 * 10000,
                success: function (data) {
                    $('#primaryForm').html(data).show();
                    loadingPage('hide');
                },
                error: function (xhr, status, error) {
                    loadingPage('hide');
                    $('#dynamicContent').show();
                    showMessage(error, 'error');

                }
            });
        }, 1000); 
    }

    editForm = ({ke,id, disab = ''}) => {
        loadingPage('show');

        setTimeout(() => {
            $('#dynamicContent').hide();

            $.ajax({
                type: "POST",
                url: URI,
                data: {
                    _token: TOKEN, 
                    ke: ke, 
                    id: id, 
                    disab: disab
                },
                timeout: 10 * 10000,
                success: function (data) {
                    $('#primaryForm').html(data).show();
                    loadingPage('hide');
                },
                error: function (xhr, status, error) {
                    loadingPage('hide');
                    $('#dynamicContent').show();

                    const errorMessage = xhr.responseJSON?.message || 'Unexpected error occurred'+error;
                    showMessage(errorMessage, 'error');
                }
            });
        }, 1000); 
    }

    cancelForm = (args = null) => {
        if (args) loadingPage('show');

        setTimeout(() => {
            if (args) loadingPage('hide');
            $('#primaryForm').hide().empty();
            $('#dynamicContent').show();
        }, 1000);
    }

    submitForm = (data) => {
        data['_token'] = TOKEN;
        
        return $.ajax({
            url: URI,
            type: 'post',
            data: JSON.stringify(data),
            timeout: 10 * 10000,
            contentType: 'application/json', 
            processData: false,
        });
    }


    submitFormFiles = ({id = null, ke, form_data = new FormData(), details = null, delete_details = null}) => {
            
        form_data.append('_token', TOKEN);
        form_data.append('id', id);
        form_data.append('ke', ke);
        form_data.append('details', JSON.stringify(details || []));
        form_data.append('delete_details', JSON.stringify(delete_details || []));

        return $.ajax({
            url: URI,
            type: 'POST',
            data: form_data,
            timeout: 60 * 10000,
            contentType: false, 
            processData: false,
        });
    }

   
    showMessage = (message, type = "success") => {
        const isAutoClose = type === 'success';

        Swal.fire({
            icon: type,
            title: type.toUpperCase(),
            text: message,
            timer: isAutoClose ? 3000 : undefined,
            timerProgressBar: isAutoClose ? true : false,
            showConfirmButton: false,         
            showCancelButton: !isAutoClose,   
            allowOutsideClick: isAutoClose,
            allowEscapeKey: isAutoClose,
            customClass: {
                cancelButton: 'btn btn-danger'  
            },
            buttonsStyling: false             
        });
    }

    const post = (data = null) => {
        return $.post(URI, $.extend({}, data, { _token: TOKEN }));
    };

    const swalSuccess = (text, onClose = null) => {
        Swal.fire({
            title: "Success",
            icon: "success",
            html: text,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            willClose: onClose,
        });
    };

    const swalFailed = (text) => {
        Swal.fire({
            title: "Failed",
            icon: "error",
            html: text,
            showConfirmButton: true,
            confirmButtonText: 'Close',
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        });
    };

    const confirmMessage = ({
        message,
        confirmAction,
        confirmButtonText = 'Yes',
        cancelButtonText = 'No'
    }) => {
        return Swal.fire({
            title: 'Confirmation',
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false, 
            showLoaderOnConfirm: true,
            allowEscapeKey: false,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => confirmAction()
        });
    };


    const setStatus = ({
        ke,
        id,
        status,
        success = null,
        error = null,
        always = null
    }) => {
        confirmMessage({
            message: `Are you sure you want to ${status} this data?`,
            confirmAction: () => {
                return new Promise((resolve, reject) => {
                    post({ ke, id })
                        .done(response => resolve(response))
                        .fail(xhr => {
                            const response = xhr.responseJSON || JSON.parse(xhr.responseText);
                            reject(response);
                        })
                        .always(() => {
                            if (typeof always === "function") always();
                        });
                });
            }
        })
        .then(result => {
            if (result.isConfirmed && result.value) {
                swalSuccess(result.value.message, () => {
                    if (typeof success === "function") success();
                });
            }
        })
        .catch(err => {
            console.error(err?.message || err);
            swalFailed(err?.message || 'An error occurred.');
            if (typeof error === "function") error(err);
        })
        .finally(() => {
            if (typeof always === "function") always();
        });
    };

    const reloadData = (dataTable, refresh = false) => {
        if (dataTable && typeof dataTable.ajax !== 'undefined') {
            dataTable.ajax.reload(null, false);
        }
    };

    moreLess = () => {
        $('.collapse-toggle-btn').each(function () {
            const $btn = $(this);
            const targetSelector = $btn.attr('data-bs-target');
            const $collapse = $(targetSelector);

            const $iconMore = $btn.find('.icon-more');
            const $iconLess = $btn.find('.icon-less');
            const $label = $btn.find('.toggle-label');

            const labelMore = $btn.data('label-more') || 'More';
            const labelLess = $btn.data('label-less') || 'Less';

            $collapse.on('show.bs.collapse', function () {
                $iconMore.addClass('d-none');
                $iconLess.removeClass('d-none');
                $label.text(labelLess);
            });

            $collapse.on('hide.bs.collapse', function () {
                $iconMore.removeClass('d-none');
                $iconLess.addClass('d-none');
                $label.text(labelMore);
            });
        });
    }

    resetSearch = () => {
        $("#searchForm").find("input, select").val("").trigger("change");
    }

    dropDown = (data, isDisabled = false) => {
        let opt = `<option value="" ${isDisabled ? 'disabled' : ''}>Select</option>`;

        $.each(data, (k, v) => {
            if (v.id && v.code != null) {
                opt += `<option value="${v.id}">${v.code}</option>`;
            }
        });

        return opt;
    };


</script>
