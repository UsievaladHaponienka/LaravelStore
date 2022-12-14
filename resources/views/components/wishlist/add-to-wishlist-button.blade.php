<button class="inline-flex px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-2"
        onclick="addToWishlist({{ $productId }})">
    {{ __('Add to wishlist') }}
</button>

<script>
    function addToWishlist(productId) {
        axios.post('{{route('wishlist.store')}}', {
            'productId': productId
        })
            .then(response => {
                alert('Product was added to your wishlist');
                window.location.href = '{{url()->current()}}'
            })
    }
</script>