@extends('admin.layout')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Orders</h2>
					</div>
					<div class="card-body">
						@include('admin.partials.flash')
						@include('admin.orders.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>Order ID</th>
								<th>Grand Total</th>
								<th>Name</th>
								<th>Status</th>
								<th>Payment</th>
								<th>Action</th>
							</thead>
							<tbody>
								@forelse ($orders as $order)
									<!-- @php
										$seal = ($order->opened == 1) ? 'seal' : '';
									@endphp -->
									<tr class="{{ ($order->opened == 1) ? '' : 'seal' }}">    
										<td>
											{{ $order->code }}<br>
											<span style="font-size: 12px; font-weight: normal"> {{\General::datetimeFormat($order->order_date) }}</span>
										</td>
										<td>{{\General::priceFormat($order->grand_total) }}</td>
										<td>
											{{ $order->customer_full_name }}<br>
											<span style="font-size: 12px; font-weight: normal"> {{ $order->customer_email }}</span>
										</td>
										<td>{{ $order->status }}</td>
										<td>{{ $order->payment_status }}</td>
										<td>
											
												<a href="{{ url('admin/orders/'. $order->id) }}" class="btn btn-info btn-sm">show</a>
											
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="5">No records found</td>
									</tr>
								@endforelse
							</tbody>
						</table>
						<div class="pagination-style">
						{{ $orders->links('admin.partials.paginator') }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('css')
<style>
 .seal {
	background-color: #fbbf24;
 }
 </style>
@endsection