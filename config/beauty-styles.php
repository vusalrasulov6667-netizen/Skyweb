<?php
/**
 * Sky Beauty — Virtual Stil Studiyası kataloqu.
 * ------------------------------------------------------------------
 * Müştəri öz şəklini brauzerdə yükləyir (şəkil serverə getmir), stil və rəng seçir,
 * nəticəni real olaraq öz şəklində görür. Bəyənsə — ustaya sifariş göndərir.
 *
 * Kateqoriya:
 *   label{4 dil} · icon · demo (demo_face|demo_hand) · hint{4 dil} · photo_hint{4 dil} · service_id
 *
 * Stil:
 *   id · service_id · mode · img (nümunə foto) · name{4 dil} · desc{4 dil} · colors[] · opts{}
 *
 * mode:
 *   hair   — saç sahəsi ayrılır və real boyanır (rəng seçimi var)
 *   gloss  — saç parlaqlığı / hamarlıq effekti (keratin)
 *   makeup — dodaq + göz + yanaq (rəng seçimi var)
 *   brow   — qaş tonu və forması (rəng seçimi var)
 *   nails  — dırnaq lövhəsinə real örtük (rəng seçimi var)
 *   sample — real forma dəyişikliyi mümkün deyil → stil nümunəsi göstərilir
 *
 * Rəng açarları `config/beauty-studio.php` → `bsx_palette()` içindədir.
 */
declare(strict_types=1);

$face = 'uploads/beauty/demo-face.jpg';
$hand = 'uploads/beauty/demo-hand.jpg';

$P = 'https://images.pexels.com/photos/';

return [
    'demo_face' => $face,
    'demo_hand' => $hand,
    'categories' => [

        /* ── SAÇ RƏNGİ ─────────────────────────────────────────── */
        'hair_color' => [
            'label'      => ['az' => 'Saç rəngi', 'en' => 'Hair colour', 'tr' => 'Saç rengi', 'ru' => 'Цвет волос'],
            'icon'       => '🎨',
            'demo'       => 'demo_face',
            'service_id' => 401,
            'hint'       => [
                'az' => 'Rəngi seçin — nəticə dərhal öz saçınızda görünür.',
                'en' => 'Pick a colour — the result appears on your own hair instantly.',
                'tr' => 'Rengi seçin — sonuç hemen kendi saçınızda görünür.',
                'ru' => 'Выберите цвет — результат сразу появится на ваших волосах.',
            ],
            'photo_hint' => [
                'az' => 'Saçınız aydın görünən, ön cəbhədən çəkilmiş şəkil yükləyin',
                'en' => 'Upload a front-facing photo where your hair is clearly visible',
                'tr' => 'Saçınızın net göründüğü önden bir fotoğraf yükleyin',
                'ru' => 'Загрузите фото анфас, где хорошо видны волосы',
            ],
            'styles' => [
                [
                    'id' => 'hc_balayage', 'service_id' => 401, 'mode' => 'hair',
                    'img' => $P . '3993445/pexels-photo-3993445.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Balayaj', 'en' => 'Balayage', 'tr' => 'Balayaj', 'ru' => 'Балаяж'],
                    'desc' => [
                        'az' => 'Kökdən uca yumşaq keçid, isti qızılı çalarlar.',
                        'en' => 'Soft root-to-tip transition in warm golden tones.',
                        'tr' => 'Kökten uca yumuşak geçiş, sıcak altın tonlar.',
                        'ru' => 'Мягкий переход от корней к кончикам в тёплых золотистых тонах.',
                    ],
                    'colors' => ['gold', 'caramel', 'platinum'],
                    'opts'   => ['balayage' => true, 'strength' => 0.92],
                ],
                [
                    'id' => 'hc_ash', 'service_id' => 401, 'mode' => 'hair',
                    'img' => $P . '3993446/pexels-photo-3993446.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Külə çalan sarı', 'en' => 'Ash blonde', 'tr' => 'Küllü sarı', 'ru' => 'Пепельный блонд'],
                    'desc' => [
                        'az' => 'Soyuq, kül tonunda sarı — üzü daha təmiz göstərir.',
                        'en' => 'Cool ash blonde that makes the complexion look cleaner.',
                        'tr' => 'Soğuk küllü sarı — cildi daha temiz gösterir.',
                        'ru' => 'Холодный пепельный блонд — кожа выглядит чище.',
                    ],
                    'colors' => ['ash', 'platinum', 'gold'],
                    'opts'   => ['strength' => 0.9],
                ],
                [
                    'id' => 'hc_platinum', 'service_id' => 401, 'mode' => 'hair',
                    'img' => $P . '3993446/pexels-photo-3993446.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Platin sarı', 'en' => 'Platinum blonde', 'tr' => 'Platin sarı', 'ru' => 'Платиновый блонд'],
                    'desc' => [
                        'az' => 'Çox açıq, təmiz sarı — parlaq və müasir görünüş.',
                        'en' => 'Very light, clean blonde for a bright modern look.',
                        'tr' => 'Çok açık, temiz sarı — parlak ve modern görünüm.',
                        'ru' => 'Очень светлый чистый блонд — яркий современный образ.',
                    ],
                    'colors' => ['platinum', 'ash', 'gold'],
                    'opts'   => ['strength' => 0.95],
                ],
                [
                    'id' => 'hc_copper', 'service_id' => 401, 'mode' => 'hair',
                    'img' => $P . '3993443/pexels-photo-3993443.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Mis qırmızısı', 'en' => 'Copper red', 'tr' => 'Bakır kızıl', 'ru' => 'Медный рыжий'],
                    'desc' => [
                        'az' => 'İsti mis çalarlı, parlaq və cəsarətli rəng.',
                        'en' => 'A bold, glossy colour in warm copper tones.',
                        'tr' => 'Sıcak bakır tonlarında cesur ve parlak renk.',
                        'ru' => 'Смелый блестящий цвет в тёплых медных тонах.',
                    ],
                    'colors' => ['copper', 'red', 'burgundy'],
                    'opts'   => ['strength' => 0.93],
                ],
                [
                    'id' => 'hc_chocolate', 'service_id' => 401, 'mode' => 'hair',
                    'img' => $P . '3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Tünd şokolad', 'en' => 'Dark chocolate', 'tr' => 'Koy çikolata', 'ru' => 'Тёмный шоколад'],
                    'desc' => [
                        'az' => 'Dərin, tünd rəng — saç daha qalın və parlaq görünür.',
                        'en' => 'Deep dark colour — hair looks thicker and glossier.',
                        'tr' => 'Derin koyu renk — saç daha dolgun ve parlak görünür.',
                        'ru' => 'Глубокий тёмный цвет — волосы выглядят гуще и блестящее.',
                    ],
                    'colors' => ['chocolate', 'black', 'burgundy'],
                    'opts'   => ['strength' => 0.95],
                ],
                [
                    'id' => 'hc_burgundy', 'service_id' => 401, 'mode' => 'hair',
                    'img' => $P . '3993443/pexels-photo-3993443.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Bordo', 'en' => 'Burgundy', 'tr' => 'Bordo', 'ru' => 'Бордо'],
                    'desc' => [
                        'az' => 'Şərab çalarlı bordo — payız və axşam üçün.',
                        'en' => 'Wine-toned burgundy for autumn and evening looks.',
                        'tr' => 'Şarap tonlu bordo — sonbahar ve akşam için.',
                        'ru' => 'Бордовый с винным оттенком — для осени и вечера.',
                    ],
                    'colors' => ['burgundy', 'red', 'black'],
                    'opts'   => ['strength' => 0.93],
                ],
            ],
        ],

        /* ── SAÇ DÜZÜMÜ (nümunə) ───────────────────────────────── */
        'hair_style' => [
            'label'      => ['az' => 'Saç düzümü', 'en' => 'Hairstyle', 'tr' => 'Saç modeli', 'ru' => 'Причёска'],
            'icon'       => '💇‍♀️',
            'demo'       => 'demo_face',
            'service_id' => 401,
            'hint'       => [
                'az' => 'Düzümü seçin — nümunə foto göstərilir, usta bunu sizin saçınızda edir.',
                'en' => 'Pick a style — a sample photo is shown; the stylist recreates it on your hair.',
                'tr' => 'Modeli seçin — örnek foto gösterilir, uzman bunu saçınızda yapar.',
                'ru' => 'Выберите причёску — показывается пример; мастер повторит её на ваших волосах.',
            ],
            'photo_hint' => [
                'az' => 'Saçınız açıq görünən şəkil yükləyin',
                'en' => 'Upload a photo where your hair is visible',
                'tr' => 'Saçınızın göründüğü bir fotoğraf yükleyin',
                'ru' => 'Загрузите фото, где видны волосы',
            ],
            'styles' => [
                [
                    'id' => 'hs_low_bun', 'service_id' => 401, 'mode' => 'sample',
                    'img' => $P . '5128274/pexels-photo-5128274.jpeg?auto=compress&cs=tinysrgb&w=500',
                    'name' => ['az' => 'Gelin aşağı topuzu', 'en' => 'Bridal low bun', 'tr' => 'Gelin topuzu', 'ru' => 'Свадебный низкий пучок'],
                    'desc' => [
                        'az' => 'Boyun xəttini açan zərif aşağı topuz, gelinlik üçün ideal.',
                        'en' => 'An elegant low bun that opens the neckline — ideal for a bride.',
                        'tr' => 'Boyun çizgisini açan zarif topuz — gelinlik için ideal.',
                        'ru' => 'Элегантный низкий пучок открывает шею — идеально для невесты.',
                    ],
                    'colors' => [],
                ],
                [
                    'id' => 'hs_bridal_waves', 'service_id' => 401, 'mode' => 'sample',
                    'img' => $P . '5128265/pexels-photo-5128265.jpeg?auto=compress&cs=tinysrgb&w=500',
                    'name' => ['az' => 'Gelin dalğaları', 'en' => 'Bridal waves', 'tr' => 'Gelin dalgaları', 'ru' => 'Свадебные волны'],
                    'desc' => [
                        'az' => 'Yumşaq dalğalar və təbii parlaqlıq — romantik görünüş.',
                        'en' => 'Soft waves and natural shine for a romantic look.',
                        'tr' => 'Yumuşak dalgalar ve doğal parlaklık — romantik görünüm.',
                        'ru' => 'Мягкие волны и естественный блеск — романтичный образ.',
                    ],
                    'colors' => [],
                ],
                [
                    'id' => 'hs_hollywood', 'service_id' => 401, 'mode' => 'sample',
                    'img' => $P . '3993446/pexels-photo-3993446.jpeg?auto=compress&cs=tinysrgb&w=500',
                    'name' => ['az' => 'Hollivud dalğaları', 'en' => 'Hollywood waves', 'tr' => 'Hollywood dalgaları', 'ru' => 'Голливудские волны'],
                    'desc' => [
                        'az' => 'Dərin yan ayrım və böyük dalğalar — axşam üçün klassika.',
                        'en' => 'A deep side part with big waves — an evening classic.',
                        'tr' => 'Derin yan ayrım ve büyük dalgalar — akşam klasiği.',
                        'ru' => 'Глубокий пробор и крупные волны — вечерняя классика.',
                    ],
                    'colors' => [],
                ],
                [
                    'id' => 'hs_high_bun', 'service_id' => 401, 'mode' => 'sample',
                    'img' => $P . '3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=500',
                    'name' => ['az' => 'Hündür axşam topuzu', 'en' => 'High evening bun', 'tr' => 'Yüksek akşam topuzu', 'ru' => 'Высокий вечерний пучок'],
                    'desc' => [
                        'az' => 'Üzü uzadan hündür topuz, açıq boyun və qulaqlar.',
                        'en' => 'A high bun that lengthens the face and opens the neck.',
                        'tr' => 'Yüzü uzatan yüksek topuz, açık boyun ve kulaklar.',
                        'ru' => 'Высокий пучок вытягивает лицо и открывает шею.',
                    ],
                    'colors' => [],
                ],
                [
                    'id' => 'hs_ponytail', 'service_id' => 401, 'mode' => 'sample',
                    'img' => $P . '3993443/pexels-photo-3993443.jpeg?auto=compress&cs=tinysrgb&w=500',
                    'name' => ['az' => 'Hamar at quyruğu', 'en' => 'Sleek ponytail', 'tr' => 'Düz at kuyruğu', 'ru' => 'Гладкий хвост'],
                    'desc' => [
                        'az' => 'Gərgin, hamar at quyruğu — səliqəli və müasir.',
                        'en' => 'A tight, sleek ponytail — clean and modern.',
                        'tr' => 'Gergin, düz at kuyruğu — temiz ve modern.',
                        'ru' => 'Тугой гладкий хвост — аккуратно и современно.',
                    ],
                    'colors' => [],
                ],
                [
                    'id' => 'hs_bob', 'service_id' => 401, 'mode' => 'sample',
                    'img' => $P . '3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=500',
                    'name' => ['az' => 'Bob kəsim', 'en' => 'Bob cut', 'tr' => 'Bob kesim', 'ru' => 'Стрижка боб'],
                    'desc' => [
                        'az' => 'Çənə xəttində səliqəli bob — üzü incə göstərir.',
                        'en' => 'A clean chin-length bob that frames the face.',
                        'tr' => 'Çene hizasında temiz bob — yüzü ince gösterir.',
                        'ru' => 'Аккуратное каре до подбородка — подчёркивает овал лица.',
                    ],
                    'colors' => [],
                ],
            ],
        ],

        /* ── KERATİN ───────────────────────────────────────────── */
        'keratin' => [
            'label'      => ['az' => 'Keratin', 'en' => 'Keratin', 'tr' => 'Keratin', 'ru' => 'Кератин'],
            'icon'       => '✨',
            'demo'       => 'demo_face',
            'service_id' => 402,
            'hint'       => [
                'az' => 'Hamarlıq və parlaqlıq effekti — saçınızda canlı görün.',
                'en' => 'Smoothness and shine preview — see it on your own hair.',
                'tr' => 'Pürüzsüzlük ve parlaklık önizlemesi — kendi saçınızda görün.',
                'ru' => 'Предпросмотр гладкости и блеска — на ваших волосах.',
            ],
            'photo_hint' => [
                'az' => 'Saçınız açıq görünən şəkil yükləyin',
                'en' => 'Upload a photo where your hair is clearly visible',
                'tr' => 'Saçınızın net göründüğü bir fotoğraf yükleyin',
                'ru' => 'Загрузите фото, где хорошо видны волосы',
            ],
            'styles' => [
                [
                    'id' => 'kt_smoothing', 'service_id' => 402, 'mode' => 'gloss',
                    'img' => $P . '3993446/pexels-photo-3993446.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Keratin düzləşdirmə', 'en' => 'Keratin smoothing', 'tr' => 'Keratin düzleştirme', 'ru' => 'Кератиновое выпрямление'],
                    'desc' => [
                        'az' => 'Qıvrım və cod saçlar hamar, səliqəli və parlaq olur.',
                        'en' => 'Frizz and wave become smooth, tidy and glossy.',
                        'tr' => 'Kıvırcık ve sert saçlar pürüzsüz, düzenli ve parlak olur.',
                        'ru' => 'Пушистые и волнистые волосы становятся гладкими и блестящими.',
                    ],
                    'colors' => [], 'opts' => ['sheen' => 0.55],
                ],
                [
                    'id' => 'kt_botox', 'service_id' => 402, 'mode' => 'gloss',
                    'img' => $P . '3993445/pexels-photo-3993445.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Botoks düzləşdirmə', 'en' => 'Botox smoothing', 'tr' => 'Botoks düzleştirme', 'ru' => 'Ботокс-выпрямление'],
                    'desc' => [
                        'az' => 'Daha dolğun, hamar və güzgü kimi parlaq saç.',
                        'en' => 'Fuller, smoother hair with a mirror-like shine.',
                        'tr' => 'Daha dolgun, pürüzsüz ve ayna gibi parlak saç.',
                        'ru' => 'Более густые, гладкие волосы с зеркальным блеском.',
                    ],
                    'colors' => [], 'opts' => ['sheen' => 0.75],
                ],
                [
                    'id' => 'kt_gloss', 'service_id' => 402, 'mode' => 'gloss',
                    'img' => $P . '3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Parlaqlıq terapiyası', 'en' => 'Gloss therapy', 'tr' => 'Parlaklık terapisi', 'ru' => 'Глянцевая терапия'],
                    'desc' => [
                        'az' => 'Rəngi dəyişmədən saça güzgü parlaqlığı verir.',
                        'en' => 'Adds mirror shine without changing the colour.',
                        'tr' => 'Rengi değiştirmeden saça ayna parlaklığı verir.',
                        'ru' => 'Добавляет зеркальный блеск, не меняя цвет.',
                    ],
                    'colors' => [], 'opts' => ['sheen' => 0.9],
                ],
            ],
        ],

        /* ── MAKİYAJ ───────────────────────────────────────────── */
        'makeup' => [
            'label'      => ['az' => 'Makiyaj', 'en' => 'Makeup', 'tr' => 'Makyaj', 'ru' => 'Макияж'],
            'icon'       => '💄',
            'demo'       => 'demo_face',
            'service_id' => 406,
            'hint'       => [
                'az' => 'Dodaq rəngini seçin — makiyaj öz üzünüzdə görünür.',
                'en' => 'Pick a lip colour — the makeup appears on your own face.',
                'tr' => 'Dudak rengini seçin — makyaj kendi yüzünüzde görünür.',
                'ru' => 'Выберите цвет губ — макияж появится на вашем лице.',
            ],
            'photo_hint' => [
                'az' => 'Üzünüzün ön cəbhədən, işıqlı şəklini yükləyin',
                'en' => 'Upload a well-lit front-facing photo of your face',
                'tr' => 'Yüzünüzün önden, iyi ışıklı bir fotoğrafını yükleyin',
                'ru' => 'Загрузите хорошо освещённое фото лица анфас',
            ],
            'styles' => [
                [
                    'id' => 'mk_daily', 'service_id' => 406, 'mode' => 'makeup',
                    'img' => $P . '5128263/pexels-photo-5128263.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Gündəlik təbii', 'en' => 'Everyday natural', 'tr' => 'Günlük doğal', 'ru' => 'Естественный дневной'],
                    'desc' => [
                        'az' => 'Yüngül ton, təbii qaşlar və yumşaq dodaq rəngi.',
                        'en' => 'Light base, natural brows and a soft lip tone.',
                        'tr' => 'Hafif ton, doğal kaşlar ve yumuşak dudak rengi.',
                        'ru' => 'Лёгкий тон, естественные брови и мягкий цвет губ.',
                    ],
                    'colors' => ['nude', 'rose', 'coral'],
                    'opts'   => ['lips' => 0.55, 'eyes' => 0, 'blush' => 0.3, 'liner' => 0],
                ],
                [
                    'id' => 'mk_smokey', 'service_id' => 406, 'mode' => 'makeup',
                    'img' => $P . '5128275/pexels-photo-5128275.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Axşam smokey', 'en' => 'Evening smokey', 'tr' => 'Gece smokey', 'ru' => 'Вечерний смоки'],
                    'desc' => [
                        'az' => 'Dərin göz makiyajı, ifadəli baxış və davamlı ton.',
                        'en' => 'A deep eye look, defined gaze and long-wear base.',
                        'tr' => 'Derin göz makyajı, etkileyici bakış ve kalıcı ton.',
                        'ru' => 'Глубокий макияж глаз, выразительный взгляд и стойкий тон.',
                    ],
                    'colors' => ['berry', 'plum', 'red'],
                    'opts'   => ['lips' => 0.45, 'eyes' => 0.8, 'blush' => 0.2, 'liner' => 0.6],
                ],
                [
                    'id' => 'mk_bridal', 'service_id' => 406, 'mode' => 'makeup',
                    'img' => $P . '5128265/pexels-photo-5128265.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Gelinlik makiyajı', 'en' => 'Bridal makeup', 'tr' => 'Gelin makyajı', 'ru' => 'Свадебный макияж'],
                    'desc' => [
                        'az' => 'İşıqda gözəl görünən, foto üçün davamlı gelin makiyajı.',
                        'en' => 'A photogenic bridal look built to last all day.',
                        'tr' => 'Fotoğrafta güzel görünen, tüm gün dayanan gelin makyajı.',
                        'ru' => 'Фотогеничный свадебный макияж, который держится весь день.',
                    ],
                    'colors' => ['rose', 'red', 'nude'],
                    'opts'   => ['lips' => 0.7, 'eyes' => 0.45, 'blush' => 0.45, 'liner' => 0.3],
                ],
                [
                    'id' => 'mk_glass', 'service_id' => 406, 'mode' => 'makeup',
                    'img' => $P . '5128263/pexels-photo-5128263.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Şüşə dəri (glass skin)', 'en' => 'Glass skin', 'tr' => 'Cam cilt', 'ru' => 'Стеклянная кожа'],
                    'desc' => [
                        'az' => 'İşıq verən, hamar dəri effekti və nude dodaqlar.',
                        'en' => 'A dewy, smooth skin effect with nude lips.',
                        'tr' => 'Işıltılı, pürüzsüz cilt efekti ve nude dudaklar.',
                        'ru' => 'Сияющая гладкая кожа и нюдовые губы.',
                    ],
                    'colors' => ['nude', 'rose', 'coral'],
                    'opts'   => ['lips' => 0.35, 'eyes' => 0, 'blush' => 0.25, 'liner' => 0, 'glow' => 0.55],
                ],
                [
                    'id' => 'mk_graphic', 'service_id' => 406, 'mode' => 'makeup',
                    'img' => $P . '5128274/pexels-photo-5128274.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Qrafik eyeliner', 'en' => 'Graphic eyeliner', 'tr' => 'Grafik eyeliner', 'ru' => 'Графичная стрелка'],
                    'desc' => [
                        'az' => 'Cizgi xəttini vurğulayan qrafik oxlar — fotosessiya üçün.',
                        'en' => 'Graphic liner that sharpens the eye line — great for shoots.',
                        'tr' => 'Göz çizgisini vurgulayan grafik oklar — çekim için.',
                        'ru' => 'Графичная стрелка подчёркивает линию глаз — для съёмок.',
                    ],
                    'colors' => ['red', 'berry', 'nude'],
                    'opts'   => ['lips' => 0.3, 'eyes' => 0.2, 'blush' => 0.15, 'liner' => 0.9],
                ],
            ],
        ],

        /* ── QAŞ ───────────────────────────────────────────────── */
        'brow' => [
            'label'      => ['az' => 'Qaş', 'en' => 'Brows', 'tr' => 'Kaş', 'ru' => 'Брови'],
            'icon'       => '👁️',
            'demo'       => 'demo_face',
            'service_id' => 407,
            'hint'       => [
                'az' => 'Tonu seçin — qaşınızın rəngi dərhal dəyişir.',
                'en' => 'Pick a shade — your brow colour changes instantly.',
                'tr' => 'Tonu seçin — kaşınızın rengi hemen değişir.',
                'ru' => 'Выберите оттенок — цвет бровей меняется сразу.',
            ],
            'photo_hint' => [
                'az' => 'Üzünüzün ön cəbhədən şəkli daha yaxşı nəticə verir',
                'en' => 'A front-facing photo gives the best result',
                'tr' => 'Önden çekilmiş bir fotoğraf en iyi sonucu verir',
                'ru' => 'Лучший результат — фото анфас',
            ],
            'styles' => [
                [
                    'id' => 'br_lami', 'service_id' => 407, 'mode' => 'brow',
                    'img' => $P . '5128275/pexels-photo-5128275.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Laminasiya + forma', 'en' => 'Lamination + shape', 'tr' => 'Laminasyon + şekil', 'ru' => 'Ламинирование + форма'],
                    'desc' => [
                        'az' => 'Qaş telləri qaldırılır, forma səliqəli olur, 4–6 həftə qalır.',
                        'en' => 'Brow hairs are lifted and shaped — the result lasts 4–6 weeks.',
                        'tr' => 'Kaş telleri kaldırılır, şekil düzenli olur, 4–6 hafta kalır.',
                        'ru' => 'Волоски приподняты, форма аккуратная — держится 4–6 недель.',
                    ],
                    'colors' => ['soft_brown', 'chocolate', 'ash', 'black_brown'],
                    'opts'   => ['shape' => 'arch', 'strength' => 0.75],
                ],
                [
                    'id' => 'br_arch', 'service_id' => 407, 'mode' => 'brow',
                    'img' => $P . '5128265/pexels-photo-5128265.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Yumşaq qövs', 'en' => 'Soft arch', 'tr' => 'Yumuşak kavis', 'ru' => 'Мягкая дуга'],
                    'desc' => [
                        'az' => 'Üzə yumşaq ifadə verən təbii qövs forması.',
                        'en' => 'A natural arch that softens the whole face.',
                        'tr' => 'Yüze yumuşak bir ifade veren doğal kavis.',
                        'ru' => 'Естественная дуга смягчает лицо.',
                    ],
                    'colors' => ['soft_brown', 'chocolate', 'ash'],
                    'opts'   => ['shape' => 'arch', 'strength' => 0.6],
                ],
                [
                    'id' => 'br_straight', 'service_id' => 407, 'mode' => 'brow',
                    'img' => $P . '5128263/pexels-photo-5128263.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Düz forma', 'en' => 'Straight shape', 'tr' => 'Düz form', 'ru' => 'Прямая форма'],
                    'desc' => [
                        'az' => 'Koreya tərzi düz qaşlar — cavan və yumşaq görünüş.',
                        'en' => 'Korean-style straight brows for a youthful look.',
                        'tr' => 'Kore tarzı düz kaşlar — genç ve yumuşak görünüm.',
                        'ru' => 'Прямые брови в корейском стиле — молодой и мягкий образ.',
                    ],
                    'colors' => ['soft_brown', 'ash', 'chocolate'],
                    'opts'   => ['shape' => 'straight', 'strength' => 0.65],
                ],
                [
                    'id' => 'br_tint', 'service_id' => 407, 'mode' => 'brow',
                    'img' => $P . '5128275/pexels-photo-5128275.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Tonlama', 'en' => 'Brow tint', 'tr' => 'Kaş boyama', 'ru' => 'Окрашивание бровей'],
                    'desc' => [
                        'az' => 'Rəngi dəyişmədən qaşlara sıxlıq və ifadə verir.',
                        'en' => 'Adds density and definition without changing the shape.',
                        'tr' => 'Şekli değiştirmeden kaşlara yoğunluk ve ifade verir.',
                        'ru' => 'Добавляет густоту и выразительность, не меняя форму.',
                    ],
                    'colors' => ['chocolate', 'ash', 'black_brown', 'soft_brown'],
                    'opts'   => ['shape' => 'natural', 'strength' => 0.85],
                ],
            ],
        ],

        /* ── DIRNAQ ────────────────────────────────────────────── */
        'nails' => [
            'label'      => ['az' => 'Dırnaq', 'en' => 'Nails', 'tr' => 'Tırnak', 'ru' => 'Ногти'],
            'icon'       => '💅',
            'demo'       => 'demo_hand',
            'service_id' => 403,
            'hint'       => [
                'az' => 'Əlinizin şəklini yükləyin, dizaynı və rəngi seçin.',
                'en' => 'Upload a photo of your hand, pick a design and colour.',
                'tr' => 'Elinizin fotoğrafını yükleyin, tasarımı ve rengi seçin.',
                'ru' => 'Загрузите фото руки, выберите дизайн и цвет.',
            ],
            'photo_hint' => [
                'az' => 'Əlinizin şəklini yükləyin — dırnaqlar aydın görünsün',
                'en' => 'Upload a hand photo with your nails clearly visible',
                'tr' => 'Tırnaklarınızın net göründüğü bir el fotoğrafı yükleyin',
                'ru' => 'Загрузите фото руки, где хорошо видны ногти',
            ],
            'styles' => [
                [
                    'id' => 'nl_french', 'service_id' => 403, 'mode' => 'nails',
                    'img' => $P . '3997386/pexels-photo-3997386.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Fransız manikür', 'en' => 'French manicure', 'tr' => 'Fransız manikür', 'ru' => 'Французский маникюр'],
                    'desc' => [
                        'az' => 'Təmiz forma və ağ uclu klassik fransız görünüşü.',
                        'en' => 'A clean shape with the classic white-tip look.',
                        'tr' => 'Temiz form ve beyaz uçlu klasik Fransız görünümü.',
                        'ru' => 'Аккуратная форма и классические белые кончики.',
                    ],
                    'colors' => ['nude', 'rose', 'white'],
                    'opts'   => ['design' => 'french'],
                ],
                [
                    'id' => 'nl_nude', 'service_id' => 403, 'mode' => 'nails',
                    'img' => $P . '3997390/pexels-photo-3997390.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Nude gel-lak', 'en' => 'Nude gel polish', 'tr' => 'Nude kalıcı oje', 'ru' => 'Нюдовый гель-лак'],
                    'desc' => [
                        'az' => 'Təbii, səliqəli nude ton — hər günə uyğun.',
                        'en' => 'A natural, tidy nude shade that works every day.',
                        'tr' => 'Doğal, düzenli nude ton — her güne uygun.',
                        'ru' => 'Естественный аккуратный нюдовый оттенок на каждый день.',
                    ],
                    'colors' => ['nude', 'rose', 'white'],
                    'opts'   => ['design' => 'solid'],
                ],
                [
                    'id' => 'nl_burgundy', 'service_id' => 403, 'mode' => 'nails',
                    'img' => $P . '3997381/pexels-photo-3997381.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Bordo gel-lak', 'en' => 'Burgundy gel polish', 'tr' => 'Bordo kalıcı oje', 'ru' => 'Бордовый гель-лак'],
                    'desc' => [
                        'az' => 'Dərin bordo ton — payız və axşam görünüşləri üçün.',
                        'en' => 'A deep burgundy shade for autumn and evening looks.',
                        'tr' => 'Derin bordo ton — sonbahar ve akşam görünümleri için.',
                        'ru' => 'Глубокий бордовый оттенок для осени и вечера.',
                    ],
                    'colors' => ['burgundy', 'red', 'black'],
                    'opts'   => ['design' => 'solid'],
                ],
                [
                    'id' => 'nl_chrome', 'service_id' => 403, 'mode' => 'nails',
                    'img' => $P . '3997390/pexels-photo-3997390.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Xrom (güzgü)', 'en' => 'Chrome mirror', 'tr' => 'Krom ayna', 'ru' => 'Хром-зеркало'],
                    'desc' => [
                        'az' => 'Güzgü effektli metal örtük — müasir və parlaq.',
                        'en' => 'A mirror-metal finish — modern and glossy.',
                        'tr' => 'Ayna efektli metal kaplama — modern ve parlak.',
                        'ru' => 'Зеркальное металлическое покрытие — современно и блестяще.',
                    ],
                    'colors' => ['silver', 'white', 'gold'],
                    'opts'   => ['design' => 'chrome'],
                ],
                [
                    'id' => 'nl_almond', 'service_id' => 403, 'mode' => 'nails',
                    'img' => $P . '5240677/pexels-photo-5240677.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Badam forma', 'en' => 'Almond shape', 'tr' => 'Badem form', 'ru' => 'Миндалевидная форма'],
                    'desc' => [
                        'az' => 'Barmaqları uzun göstərən badam forma və yumşaq ton.',
                        'en' => 'An almond shape that lengthens the fingers, in a soft tone.',
                        'tr' => 'Parmakları uzun gösteren badem form ve yumuşak ton.',
                        'ru' => 'Миндалевидная форма удлиняет пальцы, мягкий оттенок.',
                    ],
                    'colors' => ['nude', 'rose', 'white'],
                    'opts'   => ['design' => 'solid'],
                ],
                [
                    'id' => 'nl_art', 'service_id' => 403, 'mode' => 'nails',
                    'img' => $P . '3997381/pexels-photo-3997381.jpeg?auto=compress&cs=tinysrgb&w=400',
                    'name' => ['az' => 'Nail art', 'en' => 'Nail art', 'tr' => 'Nail art', 'ru' => 'Нейл-арт'],
                    'desc' => [
                        'az' => 'Nazik xətlər və kiçik vurğular — fərdi dizayn.',
                        'en' => 'Fine lines and small accents — a custom design.',
                        'tr' => 'İnce çizgiler ve küçük vurgular — kişiye özel tasarım.',
                        'ru' => 'Тонкие линии и акценты — индивидуальный дизайн.',
                    ],
                    'colors' => ['red', 'rose', 'black', 'gold'],
                    'opts'   => ['design' => 'art'],
                ],
            ],
        ],
    ],
];
