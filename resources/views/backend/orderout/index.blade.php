@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Daftar Pesanan</h2>
            <p>Lorem ipsum dolor sit amet.</p>
        </div>
        
    </div>
    @include('backend.partials.flash')
    <div class="card mb-4">
    
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        <tr class="{{ ($order->opened_shopper == 1) ? '' : 'seal' }}">
                            <td>{{ $order->code }}</td>
                            <td><b>{{ $order->customer_full_name }}</b><br>{{ $order->customer_email }}</td>
                            <td>{{\General::priceFormat($order->grand_total) }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td><span class="badge rounded-pill alert-warning">{{ $order->status }}</span></td>
                            <td>{{\General::datetimeFormat($order->order_date) }}</td>
                            <td class="text-end">
                                <a href="{{ url('user/orderout/detail/'. $order->id) }}" class="btn btn-md rounded font-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    {{ $orders->links('backend.partials.paginator') }}
</section>

@endsection

@section('style')
<style>
 .seal {
	background-color: #fbbf24;
    border-bottom: 1px solid #fff;
 }
 </style>
@endsection