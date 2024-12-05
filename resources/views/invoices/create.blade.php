@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="mt-4">{{ $invoice->id ? 'Editar Factura' : 'Crear Nueva Factura' }}</h1>
        <form action="{{ $invoice->id ? route('invoices.update', $invoice->id) : route('invoices.store') }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="{{$invoice->status ?? 'active'}}">
            @method($invoice->id ? 'PUT' : 'POST')
            <div class="mb-3">
                <label for="customer_id" class="form-label">Nombre del Cliente</label>
                <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                    <option value="">Seleccione un cliente</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id', $invoice->customer_id) == $customer->id)>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="invoice_date" class="form-label">Fecha de la Factura</label>
                <input type="date" class="form-control @error('invoice_date') is-invalid @enderror" id="invoice_date"
                    name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date ?? now()->format('Y-m-d')) }}"
                    required>
                @error('invoice_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <h5>Detalles de Factura</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th><button type="button" class="btn btn-success btn-sm" id="add-row">+</button></th>
                    </tr>
                </thead>
                <tbody id="invoice-details">
                    @if (old('details', $invoice->invoiceDetails ?? []))
                        @foreach (old('details', $invoice->invoiceDetails ?? []) as $index => $detail)
                            <tr>
                                <td>
                                    <select
                                        class="form-control product-select @error('details.' . $index . '.product_id') is-invalid @enderror"
                                        name="details[{{ $index }}][product_id]" required>
                                        <option value="">Seleccione un producto</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                {{ old('details.' . $index . '.product_id', $detail['product_id'] ?? $detail->product_id) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('details.' . $index . '.product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td><input type="number"
                                        class="form-control quantity @error('details.' . $index . '.quantity') is-invalid @enderror"
                                        min="0"
                                        name="details[{{ $index }}][quantity]" value="{{ old('details.' . $index . '.quantity', $detail['quantity'] ?? $detail->quantity) }}"
                                        required>
                                    @error('details.' . $index . '.quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td><input type="number"
                                        class="form-control unit-price @error('details.' . $index . '.price') is-invalid @enderror"
                                        name="details[{{ $index }}][price]" value="{{ old('details.' . $index . '.price', $detail['price'] ?? $detail->price) }}"
                                        readonly>
                                    @error('details.' . $index . '.price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td><input type="text" class="form-control subtotal" name="details[{{ $index }}][total]" value="{{ old('details.' . $index . '.total', $detail['total'] ?? $detail->total) }}" readonly>
                                    </td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">x</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @error('details')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="text" class="form-control" id="total" name="total_amount" value="{{ old('total_amount', $invoice->total_amount ?? 0) }}"
                    readonly>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Factura</button>
        </form>
    </div>
    @push('js')
        <script>
            document.getElementById('add-row').addEventListener('click', function() {
                const tbody = document.getElementById('invoice-details');
                const index = tbody.children.length;

                const newRow = `
                    <tr>
                        <td>
                            <select class="form-control product-select @error('details.${index}.product_id') is-invalid @enderror" name="details[${index}][product_id]" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                                </option>
                            @endforeach
                            </select>
                            @error('details.${index}.product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td><input type="number" min="0" class="form-control quantity @error('details.${index}.quantity') is-invalid @enderror" name="details[${index}][quantity]" required>
                            @error('details.${index}.quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td><input type="number" class="form-control unit-price @error('details.${index}.price') is-invalid @enderror" name="details[${index}][price]" readonly>
                            @error('details.${index}.price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input type="text" class="form-control subtotal" name="details[${index}][total]" value="0.00" readonly>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row">x</button></td>
                    </tr>
                `;

                tbody.insertAdjacentHTML('beforeend', newRow);
            });

            document.addEventListener('change', function(event) {
                if (event.target.classList.contains('product-select')) {
                    const price = event.target.selectedOptions[0].getAttribute('data-price');
                    const row = event.target.closest('tr');
                    row.querySelector('.unit-price').value = price;
                    updateSubtotal(row);
                }
            });

            document.addEventListener('input', function(event) {
                if (event.target.classList.contains('quantity')) {
                    const row = event.target.closest('tr');
                    updateSubtotal(row);
                }
            });

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-row')) {
                    event.target.closest('tr').remove();
                    updateTotal();
                }
            });

            function updateSubtotal(row) {
                const quantity = row.querySelector('.quantity').value;
                const unitPrice = row.querySelector('.unit-price').value;
                const subtotal = quantity * unitPrice;
                row.querySelector('.subtotal').value = subtotal.toFixed(2);
                updateTotal();
            }

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(function(subtotal) {
                    total += parseFloat(subtotal.value);
                });
                document.getElementById('total').value = total.toFixed(2);
            }
        </script>
    @endpush

@endsection
