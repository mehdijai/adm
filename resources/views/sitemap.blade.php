<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    @foreach ($vehicules as $vehicule)
        <url>
            <loc>{{ url('/') }}/vehicule/{{ $vehicule->slug }}</loc>
            <lastmod>{{ $vehicule->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    @foreach ($agences as $agence)
        <url>
            <loc>{{ url('/') }}/agence/{{ $agence->slug }}</loc>
            <lastmod>{{ $agence->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    <url>
        <loc>{{url('/')}}/login</loc>
        <lastmod>2021-11-12T14:47:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/forgot-password</loc>
        <lastmod>2021-11-12T14:47:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/register</loc>
        <lastmod>2021-11-12T14:47:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/terms-of-service</loc>
        <lastmod>2021-11-12T14:47:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/privacy-policy</loc>
        <lastmod>2021-11-12T14:47:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/</loc>
        <lastmod>2021-11-12T14:47:00+00:00</lastmod>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/sitemap.xml</loc>
        <lastmod>2021-12-11T19:53:50+00:00</lastmod>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{url('/')}}/vehicules</loc>
        <lastmod>2021-12-11T19:53:50+00:00</lastmod>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>https://pres.autodrive.ma</loc>
        <lastmod>{{ Carbon\Carbon::parse('11/12/2021 20:47:00')->tz('UTC')->toAtomString() }}</lastmod>
    </url>
</urlset>