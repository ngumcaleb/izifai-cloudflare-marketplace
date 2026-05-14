<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('products.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('stores.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @foreach($categories as $cat)
    <url>
        <loc>{{ url('/products?category=' . $cat->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
    @foreach($stores as $store)
    <url>
        <loc>{{ route('stores.show', $store->slug) }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod>{{ $store->updated_at->tz('UTC')->toW3cString() }}</lastmod>
    </url>
    @endforeach
    @foreach($products as $product)
    <url>
        <loc>{{ route('products.show', $product->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <lastmod>{{ $product->updated_at->tz('UTC')->toW3cString() }}</lastmod>
    </url>
    @endforeach
</urlset>
