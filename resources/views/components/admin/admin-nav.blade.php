<div class="grid grid-rows-4 justify-center">
    <div>
        <a href="{{ route('admin.index') }}"
           class="{{ $current == 'index' ? 'font-bold' : '' }}">{{ __('Admin panel') }}</a>
    </div>
    <div>
        <a href="{{ route('admin.category.index') }}"
           class="{{ $current == 'categories' ? 'font-bold' : '' }}">{{ __('Categories') }}</a>
    </div>
    <div>
        <a href="{{ route('admin.product.index') }}"
           class="{{ $current == 'products' ? 'font-bold' : '' }}">{{ __('Products') }}</a>
    </div>
    <div>
        <a href="{{ route('admin.order.index') }}"
           class="{{ $current == 'orders' ? 'font-bold' : '' }}">{{ __('Orders') }}</a>
    </div>
</div>