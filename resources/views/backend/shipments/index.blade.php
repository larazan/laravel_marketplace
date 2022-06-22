@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Pengiriman</h2>
            <p>Pastikan pembayaran terlunasi sebelum melakukan pengiriman.</p>
        </div>
        <div>
            <input type="text" placeholder="Search order ID" class="form-control bg-white" />
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
                            <th>#Order ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total Qty</th>
                            <th scope="col">Berat Total (gram)</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shipments as $shipment)
                        <tr>
                            <td>
                                {{ $shipment->order->code }}<br>
                                <span style="font-size: 12px; font-weight: normal"> {{\General::datetimeFormat($shipment->order->order_date) }}</span>
                            </td>
                            <td>{{ $shipment->order->customer_full_name }}</td>
                            <td>
                            <span class="badge rounded-pill alert-warning">{{ $shipment->status }}</span>
                                <br>
                                <span style="font-size: 12px; font-weight: normal"> {{ $shipment->shipped_at }}</span>
                            </td>
                            <td>{{ $shipment->total_qty }}</td>
                            <td>{{ \General::priceFormat($shipment->total_weight) }}</td>
                            <td>
                                <a href="{{ url('user/orders/'. $shipment->order->id) }}" class="btn btn-md rounded font-sm">show</a>
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
    {{ $shipments->links('backend.partials.paginator') }}
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