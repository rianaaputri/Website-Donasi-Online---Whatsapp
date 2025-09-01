@extends('layouts.app')

@section('title', 'Pembayaran Donasi')

@section('content')
<div class="container py-5 text-center">
    <h4>Proses Pembayaran Donasi</h4>
    <p>Silakan pilih metode pembayaran di bawah ini.</p>
    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>

   
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay("{{ $snapToken }}", {
        onSuccess: function(result){
            window.location.href = "{{ route('donation.success', $donation->id) }}";
        },
        onPending: function(result){
            window.location.href = "{{ route('donation.pending', $donation->id) }}";
        },
        onError: function(result){
            alert("Pembayaran gagal atau dibatalkan.");
            window.location.href = "{{ route('donation.status', $donation->id) }}";
        },
        onClose: function(){
            alert("Kamu menutup pembayaran sebelum selesai.");
        }
    });
};
</script>
@endpush
