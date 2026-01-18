<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProdukPromo;
use Illuminate\Support\Facades\DB;

try {
    $promo = ProdukPromo::first();
    if (!$promo) {
        echo "No promos found to delete.\n";
        exit;
    }
    echo "Attempting to delete promo ID: " . $promo->id . " for product: " . $promo->produk->nama_produk . "\n";
    $promo->delete();
    echo "Promo deleted successfully!\n";
} catch (\Exception $e) {
    echo "ERROR DELETING PROMO: " . $e->getMessage() . "\n";
    if (method_exists($e, 'getSql'))
        echo "SQL: " . $e->getSql() . "\n";
}

try {
    $produk = \App\Models\Produk::whereHas('kategori', function ($q) {
        $q->where('id', 4); })->first();
    if ($produk) {
        echo "Attempting to delete product ID: " . $produk->id . " (" . $produk->nama_produk . ") from category 4\n";
        // Manual cleanup like in controller
        DB::table('cart_details')->where('produk_id', $produk->id)->delete();
        $produk->promos()->delete();
        foreach ($produk->images as $img)
            $img->delete();

        $produk->delete();
        echo "Product deleted successfully!\n";
    }
} catch (\Exception $e) {
    echo "ERROR DELETING PRODUCT: " . $e->getMessage() . "\n";
}
