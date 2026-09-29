<?php

/* Approximate city-centre coordinates (WGS84) for event entry and map defaults.
 * Pakistan values are cross-checked against GeoNames: https://www.geonames.org/PK/largest-cities-in-pakistan.html
 * Extend this catalogue as new supported locations are needed.
 */
return [
    'default_country' => 'Pakistan',
    'default_city' => 'Karachi',
    'countries' => [
        'Pakistan' => [
            'code' => 'PK', 'cities' => [
                'Karachi' => [24.8607, 67.0011], 'Lahore' => [31.5204, 74.3587],
                'Islamabad' => [33.6844, 73.0479], 'Rawalpindi' => [33.5973, 73.0479],
                'Faisalabad' => [31.4155, 73.0897], 'Multan' => [30.1968, 71.4782],
                'Peshawar' => [34.0080, 71.5785], 'Quetta' => [30.1841, 67.0014],
                'Hyderabad' => [25.3969, 68.3772], 'Sialkot' => [32.4927, 74.5313],
                'Gujranwala' => [32.1557, 74.1871], 'Abbottabad' => [34.1463, 73.2117],
                'Bahawalpur' => [29.3956, 71.6836], 'Sukkur' => [27.7032, 68.8589],
            ],
        ],
        'India' => ['code' => 'IN', 'cities' => ['Mumbai' => [19.0760, 72.8777], 'Delhi' => [28.6139, 77.2090], 'Bengaluru' => [12.9716, 77.5946], 'Chennai' => [13.0827, 80.2707], 'Hyderabad' => [17.3850, 78.4867]]],
        'United Arab Emirates' => ['code' => 'AE', 'cities' => ['Dubai' => [25.2048, 55.2708], 'Abu Dhabi' => [24.4539, 54.3773], 'Sharjah' => [25.3463, 55.4209], 'Ajman' => [25.4052, 55.5136]]],
        'Saudi Arabia' => ['code' => 'SA', 'cities' => ['Riyadh' => [24.7136, 46.6753], 'Jeddah' => [21.4858, 39.1925], 'Mecca' => [21.3891, 39.8579], 'Medina' => [24.5247, 39.5692]]],
        'United Kingdom' => ['code' => 'GB', 'cities' => ['London' => [51.5072, -0.1276], 'Manchester' => [53.4808, -2.2426], 'Birmingham' => [52.4862, -1.8904], 'Edinburgh' => [55.9533, -3.1883]]],
        'United States' => ['code' => 'US', 'cities' => ['New York' => [40.7128, -74.0060], 'Los Angeles' => [34.0522, -118.2437], 'Chicago' => [41.8781, -87.6298], 'Las Vegas' => [36.1716, -115.1391], 'Indio' => [33.7206, -116.2156]]],
        'Canada' => ['code' => 'CA', 'cities' => ['Toronto' => [43.6532, -79.3832], 'Vancouver' => [49.2827, -123.1207], 'Montreal' => [45.5019, -73.5674], 'Ottawa' => [45.4215, -75.6972]]],
        'Australia' => ['code' => 'AU', 'cities' => ['Sydney' => [-33.8688, 151.2093], 'Melbourne' => [-37.8136, 144.9631], 'Brisbane' => [-27.4698, 153.0251], 'Perth' => [-31.9505, 115.8605]]],
        'Japan' => ['code' => 'JP', 'cities' => ['Tokyo' => [35.6762, 139.6503], 'Osaka' => [34.6937, 135.5023], 'Kyoto' => [35.0116, 135.7681], 'Yokohama' => [35.4437, 139.6380], 'Nagoya' => [35.1815, 136.9066]]],
        'South Korea' => ['code' => 'KR', 'cities' => ['Seoul' => [37.5665, 126.9780], 'Busan' => [35.1796, 129.0756], 'Incheon' => [37.4563, 126.7052], 'Daegu' => [35.8714, 128.6014]]],
        'China' => ['code' => 'CN', 'cities' => ['Beijing' => [39.9042, 116.4074], 'Shanghai' => [31.2304, 121.4737], 'Shenzhen' => [22.5431, 114.0579], 'Guangzhou' => [23.1291, 113.2644]]],
        'Germany' => ['code' => 'DE', 'cities' => ['Berlin' => [52.5200, 13.4050], 'Munich' => [48.1351, 11.5820], 'Hamburg' => [53.5511, 9.9937], 'Cologne' => [50.9375, 6.9603]]],
        'France' => ['code' => 'FR', 'cities' => ['Paris' => [48.8566, 2.3522], 'Lyon' => [45.7640, 4.8357], 'Marseille' => [43.2965, 5.3698], 'Nice' => [43.7102, 7.2620]]],
        'Turkey' => ['code' => 'TR', 'cities' => ['Istanbul' => [41.0082, 28.9784], 'Ankara' => [39.9334, 32.8597], 'Izmir' => [38.4237, 27.1428], 'Antalya' => [36.8969, 30.7133]]],
        'Malaysia' => ['code' => 'MY', 'cities' => ['Kuala Lumpur' => [3.1390, 101.6869], 'George Town' => [5.4141, 100.3288], 'Johor Bahru' => [1.4927, 103.7414], 'Kota Kinabalu' => [5.9804, 116.0735]]],
        'Singapore' => ['code' => 'SG', 'cities' => ['Singapore' => [1.3521, 103.8198]]],
    ],
];
