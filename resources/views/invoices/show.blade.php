@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card my-4 shadow-sm">
            <div class="card-header bg-dark text-white">
                <h1 class="mb-0">Factura #{{ $invoice->id }}</h1>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-primary">Información del Cliente</h5>
                        <p><strong>Nombre:</strong> {{ $invoice->customer->name }}</p>
                        <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $invoice->customer->phone }}</p>
                        <p><strong>Dirección:</strong> {{ $invoice->customer->address }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5 class="text-primary">Detalles de la Factura</h5>
                        <p><strong>Fecha:</strong> {{ $invoice->invoice_date }}</p>
                        <p><strong>Total:</strong> ${{ number_format($invoice->total_amount, 2) }}</p>
                        <p><strong>Estado:</strong> <span
                                class="badge bg-{{ $invoice->status == 'active' ? 'success' : 'warning' }}">{{ ucfirst($invoice->status) }}</span>
                        </p>
                    </div>
                </div>

                <h5 class="text-primary">Detalles de Productos</h5>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->invoiceDetails as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>${{ number_format($detail->price, 2) }}</td>
                                <td>${{ number_format($detail->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>${{ number_format($invoice->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer text-end no-print">
                <button class="btn btn-primary me-2" onclick="window.print()">Imprimir</button>

                <button @disabled($invoice->status == 'cancelled') type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#cancelInvoiceModal{{ $invoice->id }}">
                    Anular
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cancelInvoiceModal{{ $invoice->id }}" tabindex="-1"
        aria-labelledby="cancelInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelInvoiceModalLabel{{ $invoice->id }}">Confirmar Anulación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de anular esta factura?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('invoices.cancel', $invoice->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Anular</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
