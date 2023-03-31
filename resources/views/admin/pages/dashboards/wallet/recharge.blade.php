@extends('admin.layouts.master')

@section('title', 'Recarga - Adicione Saldo')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-md-12">
            @livewire('pages.dashboards.wallet.recharge.table')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showSuccessMiniAlert(message) {
            toastr.success(message, "Aeee! \\o/", {
                timeOut: 5000,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }

        function copyText() {
            if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
                var $input = $('#input_output');
                $input.val();
                var el = $input.get(0);
                var editable = el.contentEditable;
                var readOnly = el.readOnly;
                el.contentEditable = true;
                el.readOnly = false;
                var range = document.createRange();
                range.selectNodeContents(el);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
                el.setSelectionRange(0, 999999);
                el.contentEditable = editable;
                el.readOnly = readOnly;

                var successful = document.execCommand('copy');
                $input.blur();
                var msg = successful ? 'successful ' : 'un-successful ';
            }
            else{

                var copyTextarea = $('#input_output');
                copyTextarea.select();

                var successful = document.execCommand('copy');
                var msg = successful ? 'successful ' : 'unsuccessful';
            }

            showSuccessMiniAlert('Código copiado');
        }
    </script>
@endpush
