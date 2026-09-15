@foreach($products as $product)
    @include('partials.home-product-card', ['product' => $product, 'savedProductIds' => $savedProductIds])
@endforeach