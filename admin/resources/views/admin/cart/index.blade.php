
@extends('layouts.admin')
 
@section('title')
  <title>Trang Chủ</title>
@endsection

@section('content')

<div class="content-wrapper">
@include('partials.content-header',['name'=> 'cart-User', 'key'=> 'List'])

<h1>User Carts</h1>
<table>
    <thead>
        <tr>
            <th>User</th>
            <th>View Cart</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td><a href="{{ route('carts.show', $user->id) }}">Giỏ hàng của  {{$user->name  }}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection