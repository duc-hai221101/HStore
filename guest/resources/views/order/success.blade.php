@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Thanh toán {{ session('success') ? 'thành công' : 'thất bại' }}</h1>
    @if(session('success'))
        <p>Đơn hàng của bạn đã được thanh toán thành công. Trạng thái đơn hàng của bạn đã được cập nhật.</p>
    @else
        <p>Đã xảy ra lỗi trong quá trình thanh toán. Vui lòng thử lại.</p>
    @endif
    <a href="{{ route('profile.orders') }}" class="btn btn-primary">Quay lại đơn hàng của tôi</a>
</div>
@endsection
