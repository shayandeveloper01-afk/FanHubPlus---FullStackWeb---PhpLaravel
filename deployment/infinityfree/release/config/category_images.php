<?php

/*
|--------------------------------------------------------------------------
| Category images
|--------------------------------------------------------------------------
| Har category ke andar direct image links daalein (comma ke sath).
| Link "images.unsplash.com/photo-..." ya "images.pexels.com/..." jaisa
| DIRECT image ka hona chahiye (photo page ka link nahi).
|
| Link kaise milega:
|   1. Neeche diye search link par jayein
|   2. Pasandeeda photo kholein
|   3. Photo par right-click -> "Copy image address"
|   4. Woh link yahan quotes mein paste karein
|
| Keys ke naam mat badlein (ImageArtwork.php in ko folder-name ki tarah use karta hai).
| Khali list ho to public/images/categories/<key>/ ki local images use hoti hain,
| woh bhi na hon to SVG artwork.
*/

return [

    // https://unsplash.com/s/photos/anime
    'anime' => [
         'https://images.pexels.com/photos/28041345/pexels-photo-28041345.jpeg?auto=format&fit=crop&w=1280&q=80',
         'https://images.pexels.com/photos/28041345/pexels-photo-28041345.jpeg?auto=format&fit=crop&w=1280&q=80',

    ],

    // https://unsplash.com/s/photos/television
    'tv-series' => [
         'https://images.pexels.com/photos/2752779/pexels-photo-2752779.jpeg?auto=format&fit=crop&w=1280&q=80',
         'https://images.pexels.com/photos/2752779/pexels-photo-2752779.jpeg?auto=format&fit=crop&w=1280&q=80',

    ],

    // https://unsplash.com/s/photos/cinema
    'movies' => [
        // 'https://images.unsplash.com/photo-XXXXXXXX?auto=format&fit=crop&w=1280&q=80',
        'https://images.pexels.com/photos/27119954/pexels-photo-27119954.jpeg?auto=format&fit=crop&w=1280&q=80',
        'https://images.pexels.com/photos/27119954/pexels-photo-27119954.jpeg?auto=format&fit=crop&w=1280&q=80',
    ],

    // https://unsplash.com/s/photos/manga
    'manga' => [
         'https://images.pexels.com/photos/27119954/pexels-photo-27119954.jpeg?auto=format&fit=crop&w=1280&q=80',

    ],

    // https://unsplash.com/s/photos/comic-book
    'comics' => [
         'https://images.pexels.com/photos/10712402/pexels-photo-10712402.jpeg?auto=format&fit=crop&w=1280&q=80',
    ],

    // https://unsplash.com/s/photos/gaming
    'gaming' => [
         'https://images.pexels.com/photos/18966445/pexels-photo-18966445.jpeg?auto=format&fit=crop&w=1280&q=80',
    ],

    // https://unsplash.com/s/photos/cosplay
    'cosplay' => [
        // 'https://images.unsplash.com/photo-XXXXXXXX?auto=format&fit=crop&w=1280&q=80',
    ],

    // https://unsplash.com/s/photos/convention
    'events' => [
        // 'https://images.unsplash.com/photo-XXXXXXXX?auto=format&fit=crop&w=1280&q=80',
    ],

    // https://unsplash.com/s/photos/magazine
    'articles' => [
        // 'https://images.unsplash.com/photo-XXXXXXXX?auto=format&fit=crop&w=1280&q=80',
    ],

];
