<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    use WithoutModelEvents;

    private array $catalog;

    private array $slugSet = [];

    public function run(): void
    {
        $this->catalog = json_decode(<<<'JSON'
{
  "categories": [
    {
      "name": "Lingerie & Nightwear",
      "slug": "lingerie-and-nightwear",
      "description": "Discover comfort and elegance with our premium collection of intimate apparel, cozy sleepwear, and loungewear.",
      "image": "https://www.eghuri.com/public/uploads/category/1747296012-f1afb0c05202b449beabc13dd2a9963a.webp",
      "subs": [
        { "name": "Bra & Panty Sets", "slug": "bra-and-panty-sets", "description": "Perfectly matched innerwear sets designed for everyday comfort and special occasions." },
        { "name": "Bras", "slug": "bras", "description": "Explore a wide range of supportive, comfortable, and stylish bras for every outfit." },
        { "name": "Panties & Thongs", "slug": "panties-and-thongs", "description": "From daily cotton essentials to seamless thongs, find your perfect fit." },
        { "name": "Sleepwear", "slug": "sleepwear", "description": "Cozy nightgowns, pajama sets, and sleep shirts designed for a restful night." },
        { "name": "Loungewear", "slug": "loungewear", "description": "Stylish and relaxed clothing perfect for working from home or unwinding." },
        { "name": "Stockings & Hosiery", "slug": "stockings-and-hosiery", "description": "Elegant stockings, tights, and hosiery to complement your wardrobe." },
        { "name": "Sexy Lingerie & Costumes", "slug": "sexy-lingerie-and-costumes", "description": "Beautifully crafted romantic lingerie and playful dress-up costumes." }
      ]
    },
    { "name": "Fashion & Clothing", "slug": "fashion-and-clothing", "description": "Stay trendy with our curated selection of men's, women's, and children's apparel for all seasons.", "image": "https://www.eghuri.com/public/uploads/category/1747469709-cc420aca09f6bcdd95c2c470c1c44cc6.webp", "subs": [] },
    { "name": "Shoes & Accessories", "slug": "shoes-and-accessories", "description": "Complete your look with premium footwear, statement jewelry, bags, and essential accessories.", "image": "https://www.eghuri.com/public/uploads/category/1747469709-cc420aca09f6bcdd95c2c470c1c44cc6.webp", "subs": [] },
    { "name": "Beauty & Personal Care", "slug": "beauty-and-personal-care", "description": "Premium skincare, makeup, haircare, and daily grooming essentials to help you look and feel your best.", "image": "https://www.eghuri.com/public/uploads/category/1747468839-beauty-health-illustration-with.webp", "subs": [] },
    { "name": "Kitchen & Dining", "slug": "kitchen-and-dining", "description": "Upgrade your culinary space with high-quality cookware, dinnerware, utensils, and smart kitchen gadgets.", "image": "https://www.eghuri.com/public/uploads/category/1772872168-8189ca86d4d8296f81f9887532cce0b5.webp", "subs": [] },
    { "name": "Home & Living", "slug": "home-and-living", "description": "Transform your house into a home with comfortable bedding, stylish decor, and smart storage solutions.", "image": "https://www.eghuri.com/public/uploads/category/1772872168-8189ca86d4d8296f81f9887532cce0b5.webp", "subs": [] },
    { "name": "Electronics & Gadgets", "slug": "electronics-and-gadgets", "description": "Explore the latest tech trends, smartphone accessories, audio gear, and innovative smart home gadgets.", "image": null, "subs": [] },
    { "name": "Sports & Outdoor", "slug": "sports-and-outdoor", "description": "Gear up for your fitness journey and outdoor adventures with premium sports equipment and activewear.", "image": null, "subs": [] }
  ],
  "products": [
    {
      "name": "Women's Polyester Sleeveless Shorts Sleepwear Set – Soft & Comfortable Home Wear",
      "image": "https://www.eghuri.com/public/uploads/product/1783687396-h9c6199869cbb493195a784bfcf4e1284f.jpg",
      "unitePrice": 850,
      "images": ["https://www.eghuri.com/public/uploads/product/1783687396-h9c6199869cbb493195a784bfcf4e1284f.jpg","https://www.eghuri.com/public/uploads/product/1783687396-o1cn01mawtj92ne6badrkst_!!2217230969987-0-cib-(1).jpg","https://www.eghuri.com/public/uploads/product/1783687396-s260c36d00a0c44d59c9dc439ce307e00b.jpg","https://www.eghuri.com/public/uploads/product/1783687396-s3510153816c54ffda18b39229d0f8da0c.jpg","https://www.eghuri.com/public/uploads/product/1783687396-sed63e0b77ba542c3ab7177b20f83c894l.jpg","https://www.eghuri.com/public/uploads/product/1783687396-sbc855f82ea78495ebe8dcc8e359889803-1.jpg"],
      "description": "Women's sleeveless shorts sleepwear set in soft polyester. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. মহিলাদের পলিয়েস্টার হাতাবিহীন শর্টস স্লিপওয়্যার সেট নরম ও আরামদায়ক হোম ওয়্যার। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Pearl Massage Sexy Lingerie Rose Flower Three-Piece Set – Premium Sheer Lace Nightwear",
      "image": "https://www.eghuri.com/public/uploads/product/1783686579-whatsapp-image-2026-07-10-at-2.53.23-am.jpeg",
      "unitePrice": 950,
      "images": ["https://www.eghuri.com/public/uploads/product/1783686579-whatsapp-image-2026-07-10-at-2.53.23-am.jpeg","https://www.eghuri.com/public/uploads/product/1783686579-whatsapp-image-2026-07-10-at-2.53.22-am.jpeg","https://www.eghuri.com/public/uploads/product/1783686579-whatsapp-image-2026-07-10-at-2.53.21-am.jpeg","https://www.eghuri.com/public/uploads/product/1783686646-whatsapp-image-2026-07-10-at-2.53.21-am-(1).jpeg","https://www.eghuri.com/public/uploads/product/1783686646-o1cn01whyfcc1nj8oule265_!!2621361605-0-cib-(1).jpg","https://www.eghuri.com/public/uploads/product/1783686646-o1cn018feet81nj8otppkxr_!!2621361605-0-cib.jpg"],
      "description": "Pearl massage rose flower three-piece lingerie set in premium sheer lace. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. পার্ল ম্যাসাজ সেক্সি লিঙ্গারি রোজ ফ্লাওয়ার থ্রি-পিস সেট প্রিমিয়াম শিয়ার লেস নাইটওয়্যার। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Mango Cup Breast Pads – Push-Up & Anti-Exposure Nipple Stickers",
      "image": "https://www.eghuri.com/public/uploads/product/1781078878-a296620mangobrab4_1.jpg",
      "unitePrice": 350,
      "images": ["https://www.eghuri.com/public/uploads/product/1781078878-a296620mangobrab4_1.jpg","https://www.eghuri.com/public/uploads/product/1781078878-41d2yrn6uml._ac_sy350_.jpg","https://www.eghuri.com/public/uploads/product/1781078878-bea2e097bd0656b3769e43cea2188d13.jpg","https://www.eghuri.com/public/uploads/product/1781078878-o1cn01ylknfs1gbgjmgj3pu_!!2208155474104-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1781078878-o1cn01dt60j41gbgjmgpjdk_!!2208155474104-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1781078878-o1cn01qyyrey1gbgovnq3gc_!!2208155474104-0-cib.jpg"],
      "description": "Mango cup push-up breast pads with anti-exposure nipple stickers. High-quality product available at Radiant Picks. Shop online with fast delivery across Bangladesh. ম্যাংগো কাপ ব্রেস্ট প্যাডস, পুশ-আপ ও অ্যান্টি-এক্সপোজার স্টিকার্স। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Sexy Leopard Print Strappy Harness Bra Three-Piece Bodysuit Lingerie",
      "image": "https://www.eghuri.com/public/uploads/product/1781078560-h8e8fdd45978c4ccfa08325944e6a795fw.jpg",
      "unitePrice": 850,
      "images": ["https://www.eghuri.com/public/uploads/product/1781078560-h8e8fdd45978c4ccfa08325944e6a795fw.jpg","https://www.eghuri.com/public/uploads/product/1781078560-h185ae4c95348475abaa996d602abdf1et.jpg","https://www.eghuri.com/public/uploads/product/1781078560-o1cn01mvqt0b1nj8klhl2oj_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1781078630-hdb944fd167934dd4bf89533aeda02321h.jpg","https://www.eghuri.com/public/uploads/product/1781078630-hf925f63329fc47ee85552ef12308be240.jpg","https://www.eghuri.com/public/uploads/product/1781078630-ha7c82e3ec19844088b7236ea967f2f3cv.jpg"],
      "description": "Leopard print strappy harness bra three-piece bodysuit lingerie set. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. সেক্সি চিতাবাঘ প্রিন্ট স্ট্র্যাপি হারনেস ব্রা থ্রি-পিস বডিসুট লিঙ্গারি। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Breathable Chain Bodysuit Lingerie with Sheer Panties & Cat Ear Headband",
      "image": "https://www.eghuri.com/public/uploads/product/1784012684-71ke7mxvzrl._ac_uy1000_.jpg",
      "unitePrice": 1150,
      "images": ["https://www.eghuri.com/public/uploads/product/1784012684-71ke7mxvzrl._ac_uy1000_.jpg","https://www.eghuri.com/public/uploads/product/1784012684-webpc-passthru-(4).jpg","https://www.eghuri.com/public/uploads/product/1784012684-webpc-passthru-(1).jpg","https://www.eghuri.com/public/uploads/product/1784012684-webpc-passthru-(3).jpg","https://www.eghuri.com/public/uploads/product/1784012684-webpc-passthru-(2).jpg"],
      "description": "Breathable chain bodysuit lingerie with sheer panties and cat ear headband. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. সেক্সি শ্বাসপ্রশ্বাসযোগ্য চেইন বডিসুট লিঙ্গারি স্বচ্ছ আন্ডারওয়্যার প্যান্টি ও ক্যাট কান হেডব্যান্ড। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Women's Lace Bra Top & Skirt Three-Piece Sexy Lingerie Set with Deep-V Slip Dress",
      "image": "https://www.eghuri.com/public/uploads/product/1781077450-hc65746dfb2804bd293d58962e197f186h.jpg",
      "unitePrice": 1150,
      "images": ["https://www.eghuri.com/public/uploads/product/1781077450-hc65746dfb2804bd293d58962e197f186h.jpg","https://www.eghuri.com/public/uploads/product/1781077450-h3ffc299344e5452087cef4be1a551446l.jpg","https://www.eghuri.com/public/uploads/product/1781077450-h194cd91679c24743b3afb56c90d4d494y.jpg","https://www.eghuri.com/public/uploads/product/1781077450-h6e373c165e844307b205e9117e33888fx.jpg"],
      "description": "Women's lace bra top and skirt three-piece lingerie set with deep-V slip dress and thong. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. নারীদের লেস ব্রা টপ ও স্কার্ট থ্রি-পিস সেক্সি লিঙ্গারি সেট গভীর ভি স্লিপ ড্রেসসহ। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "European Style Sheer Mesh Lingerie Set with Lace Robe Three-Piece Sleepwear",
      "image": "https://www.eghuri.com/public/uploads/product/1780992184-whatsapp-image-2026-06-09-at-12.08.24-pm-(2).jpeg",
      "unitePrice": 1450,
      "images": ["https://www.eghuri.com/public/uploads/product/1780992184-whatsapp-image-2026-06-09-at-12.08.24-pm-(2).jpeg","https://www.eghuri.com/public/uploads/product/1783600945-whatsapp-image-2026-06-09-at-12.08.24-pm.jpeg","https://www.eghuri.com/public/uploads/product/1783687034-o1cn017jqezr1qey1dugryf_!!2220813462002-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1783687034-hcbaea32844714432a5e414db61eb73c8q.jpg","https://www.eghuri.com/public/uploads/product/1783687067-1089608849975049164-600x799.jpg","https://www.eghuri.com/public/uploads/product/1783687067-10883152641351560885-1.jpg"],
      "description": "European-style sheer mesh lingerie set with lightweight lace robe - a three-piece sleepwear set. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. ইউরোপীয় স্টাইল শিয়ার মেশ লিঙ্গারি সেট, সামার লেস রোব থ্রি-পিস সেট। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "See-Through Mesh Suspender Dress – Backless Sexy Nightgown One-Piece",
      "image": "https://www.eghuri.com/public/uploads/product/1780992038-o1cn011cqu5l2ne6bv6o48b_!!2217230969987-0-cib.jpg",
      "unitePrice": 950,
      "images": ["https://www.eghuri.com/public/uploads/product/1780992038-o1cn011cqu5l2ne6bv6o48b_!!2217230969987-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780992038-o1cn01mvmfha2ne6bvcibeu_!!2217230969987-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780992055-h5f01af9bf3c14601a998aa0e8c5ae55cr.jpg","https://www.eghuri.com/public/uploads/product/1780992055-o1cn017x7wfk2ne6buye23d_!!2217230969987-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780992065-o1cn01iwwwmm2ne6bvtqkr5_!!2217230969987-0-cib.jpg"],
      "description": "See-through mesh suspender dress with backless figure-hugging silhouette - a one-piece nightgown. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. সি-থ্রু মেশ সাসপেন্ডার ড্রেস ব্যাকলেস সেক্সি নাইটগাউন ওয়ান-পিস। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Women's Satin Strap Shorts Loungewear – Color-Block Two-Piece Pajama Set",
      "image": "https://www.eghuri.com/public/uploads/product/1780128006-o1cn0102f7ao1jm6pcsuiwo_!!2217120531070-0-cib.jpg",
      "unitePrice": 1050,
      "images": ["https://www.eghuri.com/public/uploads/product/1780128006-o1cn0102f7ao1jm6pcsuiwo_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780128006-o1cn018wcqzz1jm6poyujpc_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1781077744-o1cn0102f7ao1jm6pcsuiwo_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1781077744-4597ad94a3000415fff68e672ef795c3.jpg","https://www.eghuri.com/public/uploads/product/1781077772-3a8885b5-47ad-480c-9be5-5ca58e8beadd.jpg","https://www.eghuri.com/public/uploads/product/1781077781-file.jpg"],
      "description": "Women's satin strap shorts loungewear color-block two-piece pajama set with elastic waist for summer. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. নারীদের সাটিন স্ট্র্যাপ শর্টস লাউঞ্জওয়্যার কালার-ব্লক দুই-পিস পাজামা সেট ইলাস্টিক কোমরসহ। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Summer Deep-V Halter Top & Lace Shorts Women's Pajama Set",
      "image": "https://www.eghuri.com/public/uploads/product/1780126080-h090e33a58a074716b51c1197b7ecb467n.jpg",
      "unitePrice": 1050,
      "images": ["https://www.eghuri.com/public/uploads/product/1780126080-h090e33a58a074716b51c1197b7ecb467n.jpg","https://www.eghuri.com/public/uploads/product/1780126080-h02d06de889ad400c9d3cdb234001846cf.jpg"],
      "description": "Summer deep-V halter top and lace shorts women's pajama set - lightweight sleeveless sleepwear. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. গ্রীষ্মকালীন হাতাবিহীন গভীর ভি হ্যাল্টার টপ ও লেস শর্টস নারীদের পাজামা সেট। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Red Heart Mesh Hollow-Out Backless Suspender Lingerie",
      "image": "https://www.eghuri.com/public/uploads/product/1780123497-o1cn012fqd601jm6tdci9xx_!!2217120531070-0-cib.jpg",
      "unitePrice": 950,
      "images": ["https://www.eghuri.com/public/uploads/product/1780123497-o1cn012fqd601jm6tdci9xx_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780123497-o1cn015mrskx1jm6txott1y_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780123497-o1cn01f69rbz1jm6tdyn9hb_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780123722-o1cn01n19seg1jm6tdtckv7_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780123722-h68d5449a9044489194a1662d3d9f8eb1v.jpg"],
      "description": "Red heart pattern mesh lingerie with hollow-out backless suspender design. High-quality product available at Radiant Picks. Shop online with fast delivery across Bangladesh. লাল হার্ট মেশ হোলো-আউট ব্যাকলেস সাসপেন্ডার লিঙ্গারি। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Transparent Lace Sexy Lingerie – Sheer Mesh Nightwear",
      "image": "https://www.eghuri.com/public/uploads/product/1783602982-o1cn01yb78oa1aho7llgz60_!!2217311063361-0-cib.jpg",
      "unitePrice": 1050,
      "images": ["https://www.eghuri.com/public/uploads/product/1783602982-o1cn01yb78oa1aho7llgz60_!!2217311063361-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1783602982-o1cn01fol5e92e97ibuc5fa_!!2914388701-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1783603013-o1cn01lnll5e1jm6hvaldbl_!!2217120531070-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1783603013-o1cn01as5jgu1zdkzmkl6yb_!!2218942323160-0-cib.jpg"],
      "description": "Transparent lace lingerie set in sheer mesh fabric - lightweight and elegant nightwear. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. স্বচ্ছ লেস সেক্সি লিঙ্গারি, শিয়ার মেশ নাইটওয়্যার। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Sheer Mesh Lace Embroidery Suspender Nightdress",
      "image": "https://www.eghuri.com/public/uploads/product/1780122462-h3445ab0e92d54a44a5beeb5fedf25693w.jpg",
      "unitePrice": 1050,
      "images": ["https://www.eghuri.com/public/uploads/product/1780122462-h3445ab0e92d54a44a5beeb5fedf25693w.jpg","https://www.eghuri.com/public/uploads/product/1780122568-h5879a23fc26046619d3432f2bae3d1adb.jpg","https://www.eghuri.com/public/uploads/product/1780122568-hadec3c1a59894090ab1d784d5ad5db64v.jpg"],
      "description": "Sheer mesh nightdress with delicate lace embroidery and suspender straps. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. শিয়ার মেশ লেস এমব্রয়ডারি সাসপেন্ডার নাইটড্রেস। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Hollow-Out Mesh Sheer Tight Skirt – One-Shoulder Pajama Dress",
      "image": "https://www.eghuri.com/public/uploads/product/1780121804-o1cn01wn8zfh1pr2pvo5pcq_!!2659631893-0-cib.jpg",
      "unitePrice": 650,
      "images": ["https://www.eghuri.com/public/uploads/product/1780121804-o1cn01wn8zfh1pr2pvo5pcq_!!2659631893-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780121804-o1cn01eiddfu1pr2pwlagea_!!2659631893-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780121893-o1cn01tfmw6g1pr2pwifaqs_!!2659631893-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780121909-o1cn01tlswo31pr2pwwtjbh_!!2659631893-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780121924-o1cn01zdvkwl1pr2pvb12sq_!!2659631893-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780121941-o1cn01rzya0g1pr2pullowk_!!2659631893-0-cib.jpg"],
      "description": "Hollow-out mesh sheer tight-fit one-shoulder pajama dress. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. হোলো-আউট মেশ সি-থ্রু টাইট স্কার্ট, ওয়ান-শোল্ডার পাজামা ড্রেস। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Lace Maid Costume Camisole – Sheer Uniform Roleplay Sleepwear",
      "image": "https://www.eghuri.com/public/uploads/product/1778673316-o1cn01koiou91nj8mbc55tp_!!2621361605-0-cib.jpg",
      "unitePrice": 900,
      "images": ["https://www.eghuri.com/public/uploads/product/1778673316-o1cn01koiou91nj8mbc55tp_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673406-o1cn01rkmrok1nj8mbc6qfw_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673417-o1cn01rzwzyy1nj8mbxnqfk_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673434-o1cn011alaix1nj8majloqv_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673445-o1cn01orbaty1nj8mbc6up9_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673459-o1cn01dyychs1nj8mah2pgb_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673469-o1cn01zzdotw1nj8mbay3q2_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1778673674-o1cn01b6onm91nj8mbyqw7x_!!2621361605-0-cib.jpg"],
      "description": "Lace maid costume camisole in sheer fabric - a uniform-style roleplay sleepwear. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. লেস মেড কস্টিউম ক্যামিসোল, শিয়ার ইউনিফর্ম রোল-প্লে স্লিপওয়্যার। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Leopard Print Deep V-Neck Sling Top – Backless Hip-Hugging Skirt Set",
      "image": "https://www.eghuri.com/public/uploads/product/1778672909-ha16d9534fe67486fa0811c56cc07d6d3a.jpg",
      "unitePrice": 900,
      "images": ["https://www.eghuri.com/public/uploads/product/1778672909-ha16d9534fe67486fa0811c56cc07d6d3a.jpg","https://www.eghuri.com/public/uploads/product/1780941002-ha507c30d85134a6bb5b3be719b2e376f3.jpg","https://www.eghuri.com/public/uploads/product/1780941002-h6ab4b6357d1043c58a9f678f27c41c50c.jpg","https://www.eghuri.com/public/uploads/product/1780941002-hcd94ec3e3a52463cb413777125747a02l.jpg","https://www.eghuri.com/public/uploads/product/1780941002-o1cn01nskazw1nj8ki5boc2_!!2621361605-0-cib.jpg","https://www.eghuri.com/public/uploads/product/1780941002-hc91c095fd73045b5b6d7576c40da1e0a5.jpg"],
      "description": "Leopard print deep V-neck sling top with backless hip-hugging skirt set. High-quality product available at Radiant Picks. Shop online with fast delivery across Bangladesh. চিতাবাঘ প্রিন্ট গভীর ভি-নেক স্লিং টপ, ব্যাকলেস হিপ-হাগিং স্কার্ট সেট। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    },
    {
      "name": "Lace Sling Bow Mesh Nightgown – Wave Point No-Underwire Sleepwear",
      "image": "https://www.eghuri.com/public/uploads/product/1778672215-h38c13c9b16124d15bf3ec6be98a1ff04z.jpg",
      "unitePrice": 850,
      "images": ["https://www.eghuri.com/public/uploads/product/1778672215-h38c13c9b16124d15bf3ec6be98a1ff04z.jpg"],
      "description": "Lace sling bow mesh wave-point no-underwire nightgown. High-quality product available at Radiant Picks. Available in multiple sizes. Shop online with fast delivery across Bangladesh. লেস স্লিং বো মেশ ওয়েভ পয়েন্ট নো-আন্ডারওয়্যার নাইটগাউন। রেডিয়্যান্ট পিকসে অনলাইনে অর্ডার করুন। সারা বাংলাদেশে দ্রুত ডেলিভারি।"
    }
  ]
}
JSON, true);

        $this->seedCategories();
        $this->seedProducts();
    }

    private function cleanSlug(string $text): string
    {
        $slug = str($text)
            ->lower()
            ->trim()
            ->replace("'", '')
            ->replace('&', 'and')
            ->replaceMatches('/[^\w\s-]/', '')
            ->replaceMatches('/[\s_]+/', '-')
            ->trim('-')
            ->replaceMatches('/-+/', '-')
            ->limit(200, '')
            ->toString();

        $base = $slug;
        $counter = 2;
        while (in_array($slug, $this->slugSet, true)) {
            $slug = $base.'-'.$counter++;
        }
        $this->slugSet[] = $slug;

        return $slug;
    }

    private function seedCategories(): void
    {
        foreach ($this->catalog['categories'] as $catData) {
            $parent = Category::create([
                'name' => $catData['name'],
                'slug' => $catData['slug'],
                'image_path' => $catData['image'],
                'description' => $catData['description'],
                'is_active' => true,
            ]);

            foreach ($catData['subs'] as $subData) {
                Category::create([
                    'parent_id' => $parent->id,
                    'name' => $subData['name'],
                    'slug' => $subData['slug'],
                    'description' => $subData['description'],
                    'is_active' => true,
                ]);
            }
        }
    }

    private function seedProducts(): void
    {
        $categoryIds = Category::whereNotNull('parent_id')
            ->pluck('id');

        foreach ($this->catalog['products'] as $data) {
            $categoryId = $categoryIds->random();

            $name = $data['name'];
            $slug = $this->cleanSlug($name);

            $product = Product::create([
                'category_id' => $categoryId,
                'title' => $name,
                'slug' => $slug,
                'description' => $data['description'],
                'unit_price' => $data['unitePrice'],
                'sale_price' => $data['unitePrice'] + 200,
                'status' => 'active',
                'featured' => false,
                'quantity' => 10,
            ]);

            foreach ($data['images'] as $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
    }
}
