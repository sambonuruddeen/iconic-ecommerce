@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Cart</h1>

        @if (session('cart'))
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp

                    @foreach (session('cart') as $productId => $item)
                        @php
                            $product = App\Models\Product::find($productId);
                            $subtotal = $product->price * $item['quantity'];
                            $total += $subtotal;
                        @endphp

                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ $product->price }}</td>
                            <td>${{ $subtotal }}</td>
                            <td>
                                <form action="{{ route('cart.remove', ['productId' => $productId]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <th>Total:</th>
                        <td>${{ $total }}</td>
                    </tr>
                </tfoot>
            </table>

            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-danger">Clear Cart</button>
            </form>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
@endsection
