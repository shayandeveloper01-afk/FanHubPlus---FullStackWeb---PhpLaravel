<?php

namespace App\Support;

/** Creates deterministic, local 16:9 event artwork without depending on remote image hosts. */
class EventArtwork
{
    public static function svg(string $title, string $category, string $city, string|int $key): string
    {
        $hash = hash('sha256', implode('|', [$title, $category, $city, $key]));
        $needle = strtolower($title.' '.$category);
        [$theme, $scene] = match (true) {
            str_contains($needle, 'community'), str_contains($needle, 'meetup') => [['#c084fc', '#312e81', '#fb7185'], self::meetup($hash)],
            str_contains($needle, 'film'), str_contains($needle, 'cinema') => [['#fb7185', '#312e81', '#fbbf24'], self::cinema($hash)],
            str_contains(strtolower($title), 'tokyo anime festival') => [['#f472b6', '#4c1d95', '#67e8f9'], self::tokyoFestival($hash)],
            str_contains(strtolower($title), 'dubai fan expo') => [['#fbbf24', '#312e81', '#67e8f9'], self::dubaiExpo($hash)],
            str_contains(strtolower($title), 'coachella') => [['#fb7185', '#7c2d12', '#fbbf24'], self::coachella($hash)],
            str_contains(strtolower($title), 'glastonbury') => [['#f472b6', '#4c1d95', '#fbbf24'], self::festival($hash)],
            str_contains(strtolower($title), 'evo') => [['#22d3ee', '#11113b', '#fb7185'], self::fightingArena($hash)],
            str_contains(strtolower($title), 'gamescom') => [['#22d3ee', '#172554', '#a78bfa'], self::gamescomExpo($hash)],
            str_contains($needle, 'anime'), str_contains($needle, 'manga'), str_contains($needle, 'cosplay') => [['#f472b6', '#4c1d95', '#67e8f9'], self::anime($hash)],
            str_contains($needle, 'evo'), str_contains($needle, 'game'), str_contains($needle, 'gaming'), str_contains($needle, 'esport') => [['#22d3ee', '#312e81', '#a78bfa'], self::arena($hash)],
            str_contains($needle, 'music'), str_contains($needle, 'coachella'), str_contains($needle, 'glastonbury') => [['#f472b6', '#7c2d12', '#fbbf24'], self::festival($hash)],
            default => [['#c084fc', '#312e81', '#fb7185'], self::convention($hash)],
        };
        [$accent, $deep, $spark] = $theme;
        $id = substr($hash, 0, 10);
        $hazeX = 570 + (hexdec(substr($hash, 0, 2)) % 250);

        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 540" role="img" aria-label="'.self::xml($title).' event artwork">'
            .'<defs><linearGradient id="bg'.$id.'" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#090915"/><stop offset=".58" stop-color="'.$deep.'"/><stop offset="1" stop-color="#080811"/></linearGradient>'
            .'<radialGradient id="glow'.$id.'"><stop stop-color="'.$accent.'" stop-opacity=".72"/><stop offset="1" stop-color="'.$accent.'" stop-opacity="0"/></radialGradient>'
            .'<pattern id="grid'.$id.'" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M40 0H0V40" fill="none" stroke="#fff" stroke-opacity=".05"/></pattern>'
            .'<linearGradient id="shade'.$id.'" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#080811" stop-opacity="0"/><stop offset=".72" stop-color="#080811" stop-opacity=".35"/><stop offset="1" stop-color="#080811" stop-opacity=".94"/></linearGradient></defs>'
            .'<rect width="960" height="540" fill="url(#bg'.$id.')"/><circle cx="'.$hazeX.'" cy="160" r="340" fill="url(#glow'.$id.')" opacity=".62"/>'
            .'<rect width="960" height="540" fill="url(#grid'.$id.')"/>'.$scene
            .'<path d="M0 360 260 295 500 365 720 286 960 350V540H0Z" fill="url(#shade'.$id.')"/>'
            .'<path d="M0 80 390 238m-390 88 420-96M960 74 570 260m390 78-410-95" stroke="'.$spark.'" stroke-opacity=".16" stroke-width="3"/>'
            .'<path d="M54 70h44" stroke="'.$spark.'" stroke-width="4" stroke-linecap="round"/><text x="54" y="101" fill="#f3e8ff" font-family="Arial,sans-serif" font-size="15" font-weight="700" letter-spacing="3">FANHUB+  /  LIVE EVENTS</text></svg>';
    }

    private static function festival(string $hash): string
    {
        $shift = hexdec(substr($hash, 0, 2)) % 70;
        $beams = '';
        foreach ([0, 1, 2, 3, 4] as $i) {
            $x = 490 + $i * 74 + $shift;
            $beams .= '<path d="M'.($x - 80).' 0  '.$x.' 306 '.($x + 86).' 0Z" fill="#fbbf24" opacity=".055"/>';
        }
        $crowd = '';
        for ($i = 0; $i < 19; $i++) {
            $x = 430 + $i * 28;
            $y = 354 + (hexdec(substr($hash, ($i * 2) % 58, 2)) % 26);
            $crowd .= '<circle cx="'.$x.'" cy="'.$y.'" r="8" fill="#090912"/><path d="M'.($x - 13).' 425q2-45 13-45t13 45" fill="#090912"/>';
        }
        return $beams.'<path d="M480 110h370v220H480z" fill="#090912" fill-opacity=".76" stroke="#fbbf24" stroke-opacity=".65" stroke-width="3"/><path d="M505 134h320v168H505z" fill="#f472b6" fill-opacity=".14"/><path d="M452 108h425M486 108v222m355-222v222M520 108l-32 222m96-222-20 222m244-222 20 222m44-222 32 222" stroke="#fff" stroke-opacity=".28" stroke-width="4"/>'.$crowd;
    }

    private static function cinema(string $hash): string
    {
        $shift = hexdec(substr($hash, 2, 2)) % 80;
        return '<path d="M560 92h286v214H560z" rx="12" fill="#080812" fill-opacity=".7" stroke="#fb7185" stroke-opacity=".7" stroke-width="4"/><rect x="584" y="115" width="238" height="168" rx="5" fill="#fff" fill-opacity=".07"/><path d="m661 158 92 42-92 43z" fill="#fbbf24" opacity=".9"/><path d="M544 306 632 266m-120 67 192-67m88 40 117 40m-52-80 145 48" stroke="#fb7185" stroke-width="5" stroke-opacity=".75"/><path d="M'.(610 + $shift).' 0 690 310 744 310 687 0M790 0 780 310 822 310 862 0" fill="#fff" opacity=".045"/><path d="M500 350h390l-115 190H610z" fill="#be123c" fill-opacity=".15"/><path d="M540 354 650 540m290-186L770 540" stroke="#fbbf24" stroke-opacity=".36" stroke-width="3"/>';
    }

    private static function anime(string $hash): string
    {
        $sunX = 660 + (hexdec(substr($hash, 0, 2)) % 100);
        $stars = '';
        for ($i = 0; $i < 14; $i++) {
            $x = 520 + (hexdec(substr($hash, ($i * 2) % 58, 2)) % 360);
            $y = 48 + (hexdec(substr($hash, (($i + 11) * 2) % 58, 2)) % 240);
            $stars .= '<path d="M'.$x.' '.($y - 7).'v14m-7-7h14" stroke="#fff" stroke-opacity=".55" stroke-width="2"/>';
        }
        return '<circle cx="'.$sunX.'" cy="175" r="118" fill="#fb7185" fill-opacity=".48"/><path d="M470 320h410v42H470zM510 286h40v34h-40m62-72h46v72h-46m54-112h34v112h-34m53-60h48v60h-48m65-90h36v90h-36m51-46h54v46h-54" fill="#080812" fill-opacity=".8" stroke="#e9d5ff" stroke-opacity=".28" stroke-width="2"/><path d="M570 320q90-170 180 0m-205-3q115-222 230 0" fill="none" stroke="#67e8f9" stroke-width="4" stroke-opacity=".55"/><path d="M704 252h52v68h-52m-14-66 14-28h52l14 28" fill="#4c1d95" stroke="#fff" stroke-opacity=".6" stroke-width="3"/>'.$stars;
    }

    private static function arena(string $hash): string
    {
        $shift = hexdec(substr($hash, 0, 2)) % 55;
        $lights = '';
        for ($i = 0; $i < 5; $i++) {
            $x = 500 + $i * 82 + $shift;
            $lights .= '<path d="M'.$x.' 0 '.($x - 52).' 304 '.($x + 35).' 304Z" fill="#22d3ee" opacity=".06"/>';
        }
        $crowd = '';
        for ($i = 0; $i < 18; $i++) {
            $x = 470 + $i * 25;
            $crowd .= '<circle cx="'.$x.'" cy="360" r="7" fill="#080812"/><path d="M'.($x - 10).' 408q2-34 10-34t10 34" fill="#080812"/>';
        }
        return $lights.'<path d="M510 95h356v228H510z" fill="#080812" fill-opacity=".8" stroke="#22d3ee" stroke-opacity=".62" stroke-width="4"/><path d="M538 122h300v174H538z" fill="#312e81"/><path d="M538 245h300v51H538z" fill="#a78bfa" fill-opacity=".25"/><path d="m626 169 53 33-53 33zm119 0 53 33-53 33z" fill="#22d3ee"/><path d="M490 325h396m-350 0v25m304-25v25" stroke="#fff" stroke-opacity=".35" stroke-width="5"/>'.$crowd;
    }

    private static function convention(string $hash): string
    {
        $shift = hexdec(substr($hash, 0, 2)) % 50;
        return '<path d="M480 318h430l-48-145H532z" fill="#080812" fill-opacity=".72" stroke="#c084fc" stroke-opacity=".62" stroke-width="4"/><path d="M520 174 555 82h282l36 92" fill="#c084fc" fill-opacity=".12" stroke="#fff" stroke-opacity=".32" stroke-width="3"/><path d="M'.(570 + $shift).' 174v-67h100v67m24 0V83h108v91m-273 0h347M562 217h292M562 256h292" stroke="#fff" stroke-opacity=".42" stroke-width="4"/><path d="M475 318h437v27H475z" fill="#c084fc" fill-opacity=".26"/><circle cx="654" cy="240" r="15" fill="#f472b6"/><circle cx="730" cy="240" r="15" fill="#22d3ee"/><circle cx="806" cy="240" r="15" fill="#fbbf24"/><path d="M465 358h465" stroke="#fff" stroke-opacity=".25" stroke-width="3"/>';
    }

    private static function tokyoFestival(string $hash): string
    {
        $sunX = 620 + (hexdec(substr($hash, 0, 2)) % 120);
        $lanterns = '';
        for ($i = 0; $i < 13; $i++) {
            $x = 500 + $i * 31;
            $y = 72 + (hexdec(substr($hash, ($i * 2) % 58, 2)) % 80);
            $lanterns .= '<g opacity=".82"><path d="M'.$x.' '.($y - 22).'v12" stroke="#fbcfe8" stroke-opacity=".7"/><ellipse cx="'.$x.'" cy="'.$y.'" rx="10" ry="15" fill="#fb7185"/><path d="M'.($x - 6).' '.$y.'h12" stroke="#fff" stroke-opacity=".65"/></g>';
        }

        return '<circle cx="'.$sunX.'" cy="145" r="112" fill="#fb7185" fill-opacity=".78"/><path d="M450 326h470v32H450zM520 296h330v30H520z" fill="#080812" fill-opacity=".84" stroke="#fbcfe8" stroke-opacity=".4" stroke-width="2"/><path d="M574 296V148h212v148m-236-148h260l-30-30H608zM618 296v-92h124v92" fill="#24113f" stroke="#f0abfc" stroke-width="5"/><path d="M618 204h124m-62-56v148" stroke="#f0abfc" stroke-opacity=".55" stroke-width="3"/><path d="M460 358h462" stroke="#67e8f9" stroke-opacity=".76" stroke-width="4"/>'.$lanterns.'<path d="M505 294q175-250 350 0m-322 0q148-190 294 0" fill="none" stroke="#67e8f9" stroke-opacity=".64" stroke-width="4"/>';
    }

    private static function dubaiExpo(string $hash): string
    {
        $tower = 590 + (hexdec(substr($hash, 0, 2)) % 60);

        return '<circle cx="760" cy="116" r="105" fill="#fbbf24" fill-opacity=".32"/><path d="M450 348h480v36H450zM520 308h350v36H520z" fill="#080812" fill-opacity=".88" stroke="#67e8f9" stroke-opacity=".62" stroke-width="3"/><path d="M535 308 680 146l145 162m-250 0 105-116 105 116M680 146v162m-99 0V213m198 95V213" fill="#fbbf24" fill-opacity=".1" stroke="#67e8f9" stroke-width="6"/><path d="M'.$tower.' 308V72l24-30 24 30v236m-68-170h88m-88 52h88m-88 52h88" fill="#27183f" stroke="#fbbf24" stroke-width="4"/><path d="M460 384h460" stroke="#fbbf24" stroke-opacity=".8" stroke-width="4"/><circle cx="500" cy="356" r="8" fill="#fff"/><circle cx="900" cy="356" r="8" fill="#fff"/>';
    }

    private static function coachella(string $hash): string
    {
        $sunX = 650 + (hexdec(substr($hash, 0, 2)) % 130);
        $stars = '';
        for ($i = 0; $i < 16; $i++) {
            $x = 500 + (hexdec(substr($hash, ($i * 2) % 58, 2)) % 390);
            $y = 45 + (hexdec(substr($hash, (($i + 9) * 2) % 58, 2)) % 170);
            $stars .= '<circle cx="'.$x.'" cy="'.$y.'" r="2.5" fill="#fff" fill-opacity=".78"/>';
        }

        return '<circle cx="'.$sunX.'" cy="147" r="116" fill="#fbbf24" fill-opacity=".68"/><path d="M430 350q120-100 240 0t260 0v190H430z" fill="#7c2d12" fill-opacity=".45"/><path d="M480 350h440v-25H480zM520 325l20-170h340l20 170" fill="#10101e" fill-opacity=".84" stroke="#ffd98a" stroke-opacity=".72" stroke-width="4"/><path d="M545 317v-120h300v120m-270-118 22 118m70-118v118m70-118-12 118m74-118 28 118" stroke="#fb7185" stroke-opacity=".75" stroke-width="5"/><circle cx="742" cy="236" r="58" fill="none" stroke="#fbbf24" stroke-width="5"/><circle cx="742" cy="236" r="7" fill="#fbbf24"/><path d="M742 178v116m-58-58h116m-99-41 82 82m0-82-82 82" stroke="#fbbf24" stroke-opacity=".52" stroke-width="2"/>'.$stars;
    }

    private static function fightingArena(string $hash): string
    {
        $crowd = '';
        for ($i = 0; $i < 19; $i++) {
            $x = 485 + $i * 24;
            $crowd .= '<circle cx="'.$x.'" cy="370" r="7" fill="#070710"/><path d="M'.($x - 10).' 414q2-34 10-34t10 34" fill="#070710"/>';
        }

        return '<path d="M510 0 640 314h-40L490 0m280 0L660 314h42L820 0" fill="#22d3ee" fill-opacity=".12"/><path d="M505 100h360v225H505z" fill="#0b0b20" fill-opacity=".86" stroke="#22d3ee" stroke-width="5"/><path d="M532 128h306v167H532z" fill="#171747"/><path d="M532 253h306v42H532z" fill="#22d3ee" fill-opacity=".16"/><text x="685" y="234" text-anchor="middle" fill="#fff" font-family="Arial,sans-serif" font-size="58" font-weight="900" letter-spacing="8">VS</text><path d="M571 232q16-55 56-55 26 0 40 27m112 28q-16-55-56-55-26 0-40 27" fill="none" stroke="#fb7185" stroke-width="10" stroke-linecap="round"/><path d="m621 204 26 10-19 21m104-31-26 10 19 21" fill="none" stroke="#67e8f9" stroke-width="6" stroke-linecap="round"/>'.$crowd;
    }

    private static function gamescomExpo(string $hash): string
    {
        $panels = '';
        foreach ([0, 1, 2, 3] as $i) {
            $x = 500 + $i * 95;
            $accent = $i % 2 ? '#a78bfa' : '#22d3ee';
            $panels .= '<path d="M'.$x.' 110h72v164h-72z" fill="'.$accent.'" fill-opacity=".13" stroke="'.$accent.'" stroke-opacity=".74" stroke-width="3"/><path d="m'.($x + 20).' 164 34 20-34 20z" fill="'.$accent.'"/><path d="M'.($x - 10).' 276h92" stroke="#fff" stroke-opacity=".45" stroke-width="4"/>';
        }

        return '<path d="M460 328 535 78h350l70 250" fill="#10152d" fill-opacity=".84" stroke="#22d3ee" stroke-opacity=".66" stroke-width="5"/><path d="M485 329h445m-390-40h335" stroke="#fff" stroke-opacity=".3" stroke-width="4"/>'.$panels.'<path d="M650 330q10-53 54-53t54 53m-90-27h72m-54-41v20m36-20v20" fill="none" stroke="#f0abfc" stroke-width="8" stroke-linecap="round"/><circle cx="702" cy="234" r="8" fill="#f0abfc"/><path d="M470 346h450" stroke="#22d3ee" stroke-width="5" stroke-opacity=".8"/>';
    }

    private static function meetup(string $hash): string
    {
        $shift = hexdec(substr($hash, 0, 2)) % 60;
        $people = '';
        foreach ([0, 1, 2, 3, 4, 5] as $i) {
            $x = 555 + $i * 51;
            $head = 235 + (($i % 2) * 13);
            $color = $i % 2 ? '#fb7185' : '#a78bfa';
            $people .= '<circle cx="'.$x.'" cy="'.$head.'" r="16" fill="'.$color.'" fill-opacity=".82"/><path d="M'.($x - 25).' 322q4-61 25-61t25 61" fill="#080812" stroke="#fff" stroke-opacity=".25" stroke-width="2"/>';
        }
        return '<path d="M510 104h354v116H510z" fill="#080812" fill-opacity=".72" stroke="#c084fc" stroke-opacity=".7" stroke-width="4"/><path d="M540 131h294v58H540z" fill="#c084fc" fill-opacity=".2"/><text x="'.(550 + $shift).'" y="170" fill="#f5d0fe" font-family="Arial,sans-serif" font-size="22" font-weight="700" letter-spacing="4">FAN COMMUNITY</text><path d="M500 330h400m-360 0v34m320-34v34" stroke="#fff" stroke-opacity=".36" stroke-width="4"/>'.$people.'<circle cx="690" cy="80" r="130" fill="#c084fc" opacity=".08"/>';
    }

    private static function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
