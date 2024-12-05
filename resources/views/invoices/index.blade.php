@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4">Lista de Facturas</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">Crear Nueva Factura</a>
            <form class="d-flex"  action="{{ route('invoices.search') }}" method="post">
                @csrf
                <input class="form-control me-2" type="search" placeholder="Buscar factura" aria-label="Search"
                    name="search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>${{ number_format($invoice->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $invoice->status == 'active' ? 'success' : 'warning' }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('invoices.edit', $invoice->id) }}"
                                    class="btn btn-sm btn-warning">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $invoices->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
