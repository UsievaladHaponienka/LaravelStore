<x-header title="{{ __('Checkout') }}"/>
@if($cart->items->count())
    <div class="grid grid-cols-12">
        <div class="col-span-8 col-start-2 mx-6 mb-6 bg-blue-200 sm:rounded-lg">
            <div class="mt-6 mx-6">
                <a href="{{ route('cart.index') }}"> {{ __('Back to Cart') }}</a>
            </div>
            <p class="text-3xl text-center text-gray-500">{{ __('Delivery address') }}</p>
            @auth()
                <div class="grid grid-cols-11 gap-4">
                    <div class="col-span-5">
                        <div class="col-span-6 my-6 mr-6">
                            <x-user.address-form/>
                        </div>
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <span class="text-3xl mt-10">{{ __('OR') }}</span>
                    </div>
                    <div class="col-span-5">
                        <div class="col-span-6 my-6 ml-6">
                            <x-main-form>
                                <form method="POST" action="#" enctype="multipart/form-data">
                                    <label for="delivery-address">{{ __('Select delivery address') }}</label>
                                    <select name="delivery-address"
                                            id="delivery-address"
                                            onchange="displayAddressData(this.value)"
                                            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @php /** @var App\Models\Address $address*/ @endphp
                                        @foreach($user->addresses as $address)
                                            <option value="{{$address}}"
                                                    id="address-id" {{ $address->is_default ? 'selected' : '' }}>
                                                {{ __($address->title) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @csrf
                                </form>
                            </x-main-form>
                            <x-main-form>
                                <strong>{{__('Full name: ')}}</strong>
                                <p id="selected-address-full_name" class="inline">{{$user->full_name}}</p><br>
                                <strong>{{__('Email: ')}}</strong>
                                <p id="selected-address-email" class="inline">{{$user->email}}</p><br>
                                <strong>{{__('Country: ')}}</strong>
                                <p id="selected-address-country" class="inline">{{$user->getDefaultAddress()->country}}</p><br>
                                <strong>{{__('City: ')}}</strong>
                                <p id="selected-address-city" class="inline">{{$user->getDefaultAddress()->city}}</p><br>
                                <strong>{{__('Street: ')}}</strong>
                                <p id="selected-address-street" class="inline">{{$user->getDefaultAddress()->street}}</p><br>
                                <strong>{{__('Zip/Postal Code: ')}}</strong>
                                <p id="selected-address-zip" class="inline">{{$user->getDefaultAddress()->zip}}</p><br>
                                <strong>{{__('Phone: ')}}</strong>
                                <p id="selected-address-phone" class="inline">{{$user->getDefaultAddress()->phone}}</p><br>
                            </x-main-form>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-span-6 my-6 mr-6">
                    <x-user.address-form/>
                </div>
            @endauth
        </div>
        <div class="col-span-2">
            <div class="grid grid-rows gap-4 mx-6 mb-6 bg-blue-200 sm:rounded-lg">
                <div class="flex justify-center mt-2">
                    <p class="text-xl text-gray-500">{{ __('Order Summary') }}</p>
                </div>
                @php /** @var App\Models\CartItem $item */@endphp
                @foreach($cart->items as $item)
                    <div class="grid grid-cols-8 gap-4 mx-6">
                        <div class="col-span-4 flex justify-center">
                            <a href="/product/{{ $item->product->id }}">
                                <img class="max-h-40" src="/storage/{{ $item->product->image }}"
                                     alt="{{ $item->product->name }}">
                            </a>
                        </div>
                        <div class="col-span-4 flex justify-center">
                            <div class="grid grid-rows">
                                <div>{{ $item->product->name }}</div>
                                <div>{{ 'Qty: ' . $item->qty }}</div>
                                <div>{{ 'Price: ' . $item->product->price }}</div>
                                <div>{{ 'Subtotal: ' . $item->product->price * $item->qty }}</div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                @endforeach
                <div class="flex justify-center">
                    <p class="text-xl">{{ __('Final price: ') .  number_format($finalPrice, 2) }}</p>
                </div>
                <div class="flex justify-center mb-2">
                    @auth()
                        <x-checkout.place-order-button/>
                    @else
                        <x-checkout.place-order-guest-button/>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endif
<script>
    function displayAddressData(value) {
        let address = JSON.parse(value)
        document.getElementById('selected-address-full_name').innerHTML = address.full_name;
        document.getElementById('selected-address-country').innerHTML = address.country;
        document.getElementById('selected-address-city').innerHTML = address.city;
        document.getElementById('selected-address-street').innerHTML = address.street;
        document.getElementById('selected-address-zip').innerHTML = address.zip;
        document.getElementById('selected-address-phone').innerHTML = address.phone;
    }
</script>