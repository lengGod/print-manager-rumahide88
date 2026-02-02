@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-sm font-medium mb-6">
        <span class="text-slate-400">Menu Utama</span>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <a href="{{ route('orders.index') }}"
            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">Pesanan</a>
        <span class="material-symbols-outlined text-slate-300 mx-2 text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white">Edit Pesanan</span>
    </nav>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Edit Pesanan #{{ $order->order_number }}</h2>

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Customer Information -->
            <div class="mb-6">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Informasi Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_id"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pelanggan</label>
                        <select id="customer_id" name="customer_id" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                            <option value="">Pilih Pelanggan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $order->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="order_date"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal
                            Pesanan</label>
                        <input type="date" id="order_date" name="order_date"
                            value="{{ old('order_date', $order->order_date->format('Y-m-d')) }}" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label for="deadline"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Batas Waktu</label>
                        <input type="date" id="deadline" name="deadline"
                            value="{{ old('deadline', $order->deadline->format('Y-m-d')) }}" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label for="discount"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Diskon (Rp)</label>
                        <input type="number" id="discount" name="discount" min="0" step="1"
                            value="{{ old('discount', number_format($order->discount, 0, '', '')) }}"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label for="paid_amount"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jumlah Dibayar
                            (Rp)</label>
                        <input type="number" id="paid_amount" name="paid_amount" min="0" step="1"
                            value="{{ old('paid_amount', number_format($order->paid_amount, 0, '', '')) }}"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label for="payment_status"
                            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status
                            Pembayaran</label>
                        <select id="payment_status" name="payment_status" required
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">
                            <option value="unpaid"
                                {{ old('payment_status', $order->payment_status) == 'unpaid' ? 'selected' : '' }}>Belum
                                Lunas</option>
                            <option value="partial"
                                {{ old('payment_status', $order->payment_status) == 'partial' ? 'selected' : '' }}>Sebagian
                            </option>
                            <option value="paid"
                                {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Lunas
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="notes"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Catatan</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white">{{ old('notes', $order->notes) }}</textarea>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Item Pesanan</h3>
                <div id="order-items" class="space-y-4">
                    @foreach ($order->items as $item)
                        @php
                            $itemSpecifications = is_string($item->specifications)
                                ? json_decode($item->specifications, true) ?? []
                                : (is_object($item->specifications)
                                    ? $item->specifications->pluck('id')->toArray()
                                    : []);
                        @endphp
                        <div class="order-item p-4 border border-slate-200 dark:border-slate-700 rounded-lg"
                            data-item-id="{{ $loop->iteration }}">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-medium text-slate-900 dark:text-white">Item {{ $loop->iteration }}
                                </h4>
                                <button type="button" class="remove-item text-rose-600 hover:text-rose-800"
                                    data-item-id="{{ $loop->iteration }}">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Produk</label>
                                    <select name="items[{{ $loop->iteration }}][product_id]"
                                        class="product-select w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                        data-item-id="{{ $loop->iteration }}" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-unit="{{ $product->unit }}"
                                                data-default-price="{{ $product->price ?? 0 }}"
                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="price-option-container" data-item-id="{{ $loop->iteration }}">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi Harga</label>
                                    <select name="items[{{ $loop->iteration }}][price_option_id]"
                                        class="price-option-select w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                        data-item-id="{{ $loop->iteration }}"
                                        {{ $item->product->priceOptions->count() > 0 ? 'required' : '' }}
                                        style="display: {{ $item->product->priceOptions->count() > 0 ? 'block' : 'none' }}">
                                        <option value="">Pilih Harga</option>
                                        @foreach ($item->product->priceOptions as $option)
                                            <option value="{{ $option->id }}" data-price="{{ $option->price }}"
                                                {{ $item->product_price_option_id == $option->id ? 'selected' : '' }}>
                                                {{ $option->label }} (Rp {{ number_format($option->price, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kuantitas</label>
                                    <input type="number" name="items[{{ $loop->iteration }}][quantity]" min="1"
                                        value="{{ old('items.' . $loop->iteration . '.quantity', $item->quantity) }}"
                                        class="quantity-input w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                        data-item-id="{{ $loop->iteration }}" required>
                                </div>
                                <div class="size-container" data-item-id="{{ $loop->iteration }}"
                                    style="display: {{ $item->product->unit === 'meter' ? 'block' : 'none' }};">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ukuran
                                        (cm)</label>
                                    <input type="text" name="items[{{ $loop->iteration }}][size]"
                                        placeholder="Contoh: 100x100"
                                        value="{{ old('items.' . $loop->iteration . '.size', $item->size) }}"
                                        class="size-input w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white"
                                        data-item-id="{{ $loop->iteration }}">
                                </div>
                                <div class="md:col-span-4">
                                    <label
                                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Spesifikasi</label>
                                    <div class="specifications-container" data-item-id="{{ $loop->iteration }}">
                                        @if ($item->product->specifications)
                                            @foreach ($item->product->specifications as $spec)
                                                <div class="flex items-center mb-2">
                                                    <input type="checkbox"
                                                        id="spec-{{ $loop->parent->iteration }}-{{ $spec->id }}"
                                                        name="items[{{ $loop->parent->iteration }}][specifications][]"
                                                        value="{{ $spec->id }}" class="spec-checkbox mr-2"
                                                        data-item-id="{{ $loop->parent->iteration }}"
                                                        data-price="{{ $spec->additional_price }}"
                                                        {{ in_array($spec->id, $itemSpecifications) ? 'checked' : '' }}>
                                                    <label for="spec-{{ $loop->parent->iteration }}-{{ $spec->id }}"
                                                        class="text-sm text-slate-700 dark:text-slate-300">{{ $spec->name }}:
                                                        {{ $spec->value }} (+Rp
                                                        {{ number_format($spec->additional_price, 0, ',', '.') }})</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="items[{{ $loop->iteration }}][item_id]"
                                value="{{ $item->id }}">
                            <input type="hidden" name="items[{{ $loop->iteration }}][selected_price]" class="selected-item-price"
                                value="{{ $item->price }}" data-item-id="{{ $loop->iteration }}">
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-item"
                    class="mt-4 px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-md text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Tambah Item
                </button>
            </div>

            <!-- Order Summary -->
            <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Subtotal:</span>
                    <span id="subtotal" class="text-sm font-medium text-slate-900 dark:text-white">Rp 0</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Diskon:</span>
                    <span id="discount-display" class="text-sm font-medium text-slate-900 dark:text-white">Rp 0</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-slate-200 dark:border-slate-700">
                    <span class="text-base font-semibold text-slate-900 dark:text-white">Total:</span>
                    <span id="total" class="text-base font-semibold text-slate-900 dark:text-white">Rp 0</span>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('orders.index') }}"
                    class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Perbarui Pesanan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = @json($products);
            const initialOrderItems = @json($order->items);
            let itemCount = initialOrderItems.length;

            // Setup event listeners for initial items
            initialOrderItems.forEach((item, index) => {
                const currentItemCount = index + 1;
                const itemElement = document.querySelector(
                    `.order-item[data-item-id="${currentItemCount}"]`);
                if (itemElement) {
                    setupItemEventListeners(itemElement);
                    // Manually trigger product change to populate price options and specifications
                    const productSelect = itemElement.querySelector('.product-select');
                    if (productSelect) {
                        const event = new Event('change');
                        productSelect.dispatchEvent(event);
                    }
                }
            });

            // Add item button
            document.getElementById('add-item').addEventListener('click', function() {
                addItem();
                updateOrderSummary();
            });

            // Initial summary calculation
            updateOrderSummary();

            function addItem() {
                itemCount++;
                const itemHtml = `
                <div class="order-item p-4 border border-slate-200 dark:border-slate-700 rounded-lg" data-item-id="${itemCount}">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-medium text-slate-900 dark:text-white">Item ${itemCount}</h4>
                        <button type="button" class="remove-item text-rose-600 hover:text-rose-800" data-item-id="${itemCount}">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Produk</label>
                            <select name="items[${itemCount}][product_id]" class="product-select w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white" data-item-id="${itemCount}" required>
                                <option value="">Pilih Produk</option>
                                ${products.map(product => `<option value="${product.id}" data-unit="${product.unit}" data-default-price="${product.price || 0}">${product.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="price-option-container" data-item-id="${itemCount}" style="display: none;">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Opsi Harga</label>
                            <select name="items[${itemCount}][price_option_id]" class="price-option-select w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white" data-item-id="${itemCount}">
                                <option value="">Pilih Harga</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kuantitas</label>
                            <input type="number" name="items[${itemCount}][quantity]" min="1" value="1" class="quantity-input w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white" data-item-id="${itemCount}" required>
                        </div>
                         <div class="size-container" data-item-id="${itemCount}" style="display: none;">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ukuran (cm)</label>
                            <input type="text" name="items[${itemCount}][size]" placeholder="Contoh: 100x100" class="size-input w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary dark:bg-slate-700 dark:text-white" data-item-id="${itemCount}">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Spesifikasi</label>
                            <div class="specifications-container" data-item-id="${itemCount}">
                                <!-- Specifications will be added here when a product is selected -->
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="items[${itemCount}][price]" class="selected-item-price" value="0" data-item-id="${itemCount}">
                    <div class="specifications-hidden-inputs" data-item-id="${itemCount}">
                        <!-- Hidden inputs for specifications will be added here dynamically -->
                    </div>
                </div>
                `;

                document.getElementById('order-items').insertAdjacentHTML('beforeend', itemHtml);
                const newItem = document.querySelector(`.order-item[data-item-id="${itemCount}"]`);
                setupItemEventListeners(newItem);
            }

            function setupItemEventListeners(itemElement) {
                // Product change event
                itemElement.querySelector('.product-select').addEventListener('change', function() {
                    const productId = this.value;
                    const itemId = this.dataset.itemId;
                    const selectedProductOption = this.options[this.selectedIndex];
                    const unit = selectedProductOption.dataset.unit;
                    const defaultPrice = parseFloat(selectedProductOption.dataset.defaultPrice || 0);

                    const sizeContainer = itemElement.querySelector(`.size-container[data-item-id="${itemId}"]`);
                    if (unit === 'meter') {
                        sizeContainer.style.display = 'block';
                    } else {
                        sizeContainer.style.display = 'none';
                    }

                    // Populate price options
                    const priceOptionSelect = itemElement.querySelector(`.price-option-select[data-item-id="${itemId}"]`);
                    priceOptionSelect.innerHTML = '<option value="">Pilih Harga</option>'; // Reset options

                    const product = products.find(p => p.id == productId);
                    if (product) {
                        if (product.price_options && product.price_options.length > 0) {
                            product.price_options.forEach(option => {
                                const optionElement = document.createElement('option');
                                optionElement.value = option.id;
                                optionElement.textContent = `${option.label} (Rp ${number_format(option.price, 0, ',', '.')})`;
                                optionElement.dataset.price = option.price;
                                priceOptionSelect.appendChild(optionElement);
                            });
                            priceOptionSelect.setAttribute('required', 'required');
                            priceOptionSelect.closest('.price-option-container').style.display = 'block';
                        } else {
                            // If no price options, use product's default price and hide price option select
                            itemElement.querySelector(`.selected-item-price[data-item-id="${itemId}"]`).value = defaultPrice;
                            priceOptionSelect.removeAttribute('required');
                            priceOptionSelect.closest('.price-option-container').style.display = 'none';
                        }

                        // Update specifications
                        const specificationsContainer = itemElement.querySelector(`.specifications-container[data-item-id="${itemId}"]`);
                        specificationsContainer.innerHTML = ''; // Clear previous specifications

                        if (product.specifications && product.specifications.length > 0) {
                            product.specifications.forEach(spec => {
                                const specHtml = `
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="spec-${itemId}-${spec.id}" name="items[${itemId}][specifications][]" value="${spec.id}" class="spec-checkbox mr-2" data-item-id="${itemId}" data-price="${spec.additional_price}">
                                        <label for="spec-${itemId}-${spec.id}" class="text-sm text-slate-700 dark:text-slate-300">${spec.name}: ${spec.value} (+Rp ${number_format(spec.additional_price, 0, ',', '.')})</label>
                                    </div>
                                `;
                                specificationsContainer.insertAdjacentHTML('beforeend', specHtml);
                            });

                            // Add event listeners to specification checkboxes
                            specificationsContainer.querySelectorAll('.spec-checkbox').forEach(checkbox => {
                                checkbox.addEventListener('change', updateOrderSummary);
                            });
                        }
                    }
                    updateOrderSummary();
                });

                // Price Option change event
                itemElement.querySelector('.price-option-select').addEventListener('change', function() {
                    const itemId = this.dataset.itemId;
                    const selectedPriceOption = this.options[this.selectedIndex];
                    const selectedPrice = parseFloat(selectedPriceOption.dataset.price || 0);
                    itemElement.querySelector(`.selected-item-price[data-item-id="${itemId}"]`).value = selectedPrice;
                    updateOrderSummary();
                });


                // Quantity change event
                itemElement.querySelector('.quantity-input').addEventListener('input', updateOrderSummary);

                // Size change event
                const sizeInput = itemElement.querySelector('.size-input');
                if (sizeInput) {
                    sizeInput.addEventListener('input', updateOrderSummary);
                }

                // Remove item button
                itemElement.querySelector('.remove-item').addEventListener('click', function() {
                    this.closest('.order-item').remove();
                    updateOrderSummary();
                });

                // Pre-select existing product and price option if available
                const itemId = itemElement.dataset.itemId;
                const existingItem = initialOrderItems[itemId - 1]; // items are 1-indexed
                if (existingItem) {
                    const productSelect = itemElement.querySelector('.product-select');
                    productSelect.value = existingItem.product_id;
                    const event = new Event('change');
                    productSelect.dispatchEvent(event); // Trigger change to populate price options

                    if (existingItem.product_price_option_id) {
                        const priceOptionSelect = itemElement.querySelector('.price-option-select');
                        priceOptionSelect.value = existingItem.product_price_option_id;
                        const priceOptionEvent = new Event('change');
                        priceOptionSelect.dispatchEvent(priceOptionEvent); // Trigger change to set price
                    } else if (existingItem.price) {
                        // Fallback for items with no price option but a direct price (legacy or default product price)
                        itemElement.querySelector(`.selected-item-price[data-item-id="${itemId}"]`).value = existingItem.price;
                    }

                    // Pre-check specifications
                    if (existingItem.specifications && Array.isArray(existingItem.specifications)) {
                        existingItem.specifications.forEach(specId => {
                            const checkbox = itemElement.querySelector(
                                `#spec-${itemId}-${specId}`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    }
                }
            }


            // Discount input event
            document.getElementById('discount').addEventListener('input', updateOrderSummary);
            // Paid amount input event
            document.getElementById('paid_amount').addEventListener('input', updateOrderSummary);

            function updateOrderSummary() {
                let subtotal = 0;

                document.querySelectorAll('.order-item').forEach(item => {
                    const productId = item.querySelector('.product-select').value;
                    const quantity = parseInt(item.querySelector('.quantity-input').value) || 0;
                    const sizeInput = item.querySelector('.size-input');
                    const sizeValue = sizeInput ? sizeInput.value : '';
                    const productSelectElement = item.querySelector('.product-select');
                    const selectedProductOptionElement = productSelectElement.options[productSelectElement.selectedIndex];
                    const unit = selectedProductOptionElement ? selectedProductOptionElement.dataset.unit : null;

                    if (productId) {
                        const product = products.find(p => p.id == productId);
                        if (product) {
                            let itemPrice = 0;

                            // Get price from selected price option or default product price
                            const selectedItemPriceInput = item.querySelector(`.selected-item-price[data-item-id="${item.dataset.itemId}"]`);
                            itemPrice = parseFloat(selectedItemPriceInput.value || product.price || 0);


                            // Add specification prices
                            item.querySelectorAll('.spec-checkbox:checked').forEach(checkbox => {
                                itemPrice += parseFloat(checkbox.dataset.price);
                            });

                            if (unit === 'meter' && sizeValue) {
                                const dimensions = sizeValue.split('x').map(d => parseFloat(d.trim()));
                                if (dimensions.length === 2 && !isNaN(dimensions[0]) && !isNaN(dimensions[
                                        1])) {
                                    const widthInMeters = dimensions[0] / 100;
                                    const heightInMeters = dimensions[1] / 100;
                                    let area = widthInMeters * heightInMeters;
                                    if (area > 0 && area < 1) {
                                        area = 1;
                                    }
                                    subtotal += itemPrice * area * quantity;
                                }
                            } else {
                                subtotal += itemPrice * quantity;
                            }
                        }
                    }
                });

                const discount = parseFloat(document.getElementById('discount').value) || 0;
                const total = Math.max(0, subtotal - discount);
                const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;

                document.getElementById('subtotal').textContent = 'Rp ' + number_format(subtotal, 0, ',', '.');
                document.getElementById('discount-display').textContent = 'Rp ' + number_format(discount, 0, ',',
                    '.');
                document.getElementById('total').textContent = 'Rp ' + number_format(total, 0, ',', '.');

                // Determine payment status
                let paymentStatus = 'unpaid';
                if (paidAmount >= total && total > 0) {
                    paymentStatus = 'paid';
                } else if (paidAmount > 0 && paidAmount < total) {
                    paymentStatus = 'partial';
                }
                document.getElementById('payment_status').value = paymentStatus;

                // Update hidden specifications inputs
                document.querySelectorAll('.order-item').forEach(item => {
                    const itemId = item.dataset.itemId;
                    // Find existing hidden inputs for specifications and remove them if they are from the old structure
                    item.querySelectorAll(`input[name^="items[${itemId}][specifications]["]`).forEach(input => input.remove());

                    const checkedSpecs = Array.from(item.querySelectorAll('.spec-checkbox:checked')).map(
                        cb => cb.value);

                    checkedSpecs.forEach(specId => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `items[${itemId}][specifications][]`;
                        input.value = specId;
                        // Append to the order-item div itself, or a specific container if preferred
                        item.appendChild(input);
                    });
                });
            }

            // Helper function for number formatting
            function number_format(number, decimals, dec_point, thousands_sep) {
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                const n = !isFinite(+number) ? 0 : +number;
                const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
                const sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
                const dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

                const s = (prec ? n.toFixed(prec) : Math.round(n)).toString().split('.');
                if (sep) {
                    const re = /(-?\d+)(\d{3})/;
                    while (re.test(s[0])) {
                        s[0] = s[0].replace(re, '$1' + sep + '$2');
                    }
                }

                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }

                return s.join(dec);
            }
        });
    </script>
@endpush