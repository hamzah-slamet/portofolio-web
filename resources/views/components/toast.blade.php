@props(['type' => 'success', 'message' => ''])

@php
    $isError = in_array($type, ['error', 'danger']);
    $icon    = $isError ? 'bi-exclamation-circle-fill' : 'bi-check-circle-fill';
@endphp

{{-- Styling toast ada di admin.css (.app-toast*). Di sini hanya markup + JS. --}}
@once
    @push('scripts')
    <script>
        function dismissToast(el) {
            if (!el) return;
            el.classList.add('hide');
            setTimeout(() => el.remove(), 250);
        }
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.app-toast').forEach(function (el) {
                setTimeout(() => dismissToast(el), 3000);
            });
        });
    </script>
    @endpush
@endonce

<div {{ $attributes->merge(['class' => 'app-toast ' . ($isError ? 'app-toast-danger' : 'app-toast-success')]) }} role="alert">
    <i class="bi {{ $icon }} app-toast-icon"></i>
    <span class="app-toast-msg">{{ $message }}</span>
    <button type="button" class="app-toast-close" onclick="dismissToast(this.parentElement)">
        <i class="bi bi-x-lg"></i>
    </button>
</div>
