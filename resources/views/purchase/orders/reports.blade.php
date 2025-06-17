@extends('layouts.admin')

@section('page-title', 'Stock-In Report')

@section('content')
<div class="card">

<!-- Summary Section -->
    <div class="card-body">
        <h5>Report Summary ({{ request('from_date') }} to {{ request('to_date') }})</h5>
        <ul>
            
        </ul>
    </div>
    
    <!-- Report Table -->
    <div class="card-body">
        @if(isset($purchaseOrders) && count($purchaseOrders) > 0)
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>GR Number</th>
                        <th>Bill Number</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>QTY</th>
                        <th>Amount</th>
                        <th>Total</th>
                        <th>Billed</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    @endphp
                    @foreach ($purchaseOrders as $index => $order)
                    @php 
                     $total += $order->items->sum('quantity') * $order->items->sum('price');
                    @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td>{{ $order->gr_number }}</td>
                            <td>{{ $order->bill_no ?? 'N/A' }}</td>
                            <td>{{ $order->supplier->name }}</td>
                            <td>{{ $order->items[0]->product->name }}</td>
                            <td>{{ $order->items[0]->quantity }}</td>
                            <td>{{ number_format(($order->items[0]->price), 2) }}</td>
                            <td>{{ number_format(($order->items[0]->quantity * $order->items[0]->price), 2) }}</td>
                            <td>
                                @if($order->billed)
                                    <span class="badge badge-success">Billed</span>
                                @else
                                    <span class="badge badge-warning">Unbilled</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right">Total:</td>
                        <td>{{ $purchaseOrders->sum('items.0.quantity') }}</td>
                        <td>-</td>
                        <td>{{ number_format($total, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @else
            <p class="text-center text-muted">No purchase orders found for the selected filters.</p>
        @endif
    </div>
</div>
@endsection
