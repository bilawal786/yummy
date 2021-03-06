<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Http\Resources\v1\ProductShopResource;
use App\Http\Services\RatingsService;
use App\Models\Category;
use App\Models\OrderLineItem;
use App\Models\Product;
use App\Models\ShopProduct;

class ShopCategoryProductController extends Controller
{
    /**
     * @param $shop
     * @param Category $category
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function action( $shop, Category $category )
    {
        $shopProduct = pluck(ShopProduct::where([ 'shop_id' => $shop ])->get(), 'obj', 'product_id');

        $products = Product::with([
            'shops',
            'categories'
        ])->whereHas('categories', function( $query ) use ( $category ) {
                $query->where('category_id', $category->id);
            })->whereHas('shops', function( $query ) use ( $shop ) {
                $query->where('shop_id', $shop);
            })->get();

        $products->map(function( $query ) use ( $shopProduct, $shop ) {
            $avgRating = app(RatingsService::class)->avgRating($shop, $query->id);
            $query['unit_price']     = isset($shopProduct[ $query->id ]) ? $shopProduct[ $query->id ]->unit_price : 0;
            $query['discount_price'] = isset($shopProduct[ $query->id ]) ? $shopProduct[ $query->id ]->discount_price : 0;
            $query['stock_count']    = $query->stockCount($shop);
            $query['in_stock']       = $query->inStock($shop);
            $query['avgRating']      = $avgRating['avgRating'];
        });

        return response()->json([
            'status' => 200,
            'data'   => ProductResource::collection($products),
        ], 200);
    }

    /**
     * @param $shop
     * @param $product
     *
     * @return ProductShopResource
     */
    public function show( $shop, $product )
    {
        $shopProduct = ShopProduct::where([
            'shop_id'    => $shop,
            'product_id' => $product,
        ])->first();

        $getProduct = Product::with([
            'shops' => function( $query ) use ( $shop ) {
                $query->find($shop);
            },
        ])->find($product);
        if ( blank($getProduct) ) {
            return response()->json([
                'status' => 401,
                'data'   => 'This product not found',
            ], 401);
        }
        if ( blank($shopProduct) ) {
            return response()->json([
                'status' => 401,
                'data'   => 'This shop product not found',
            ], 401);
        }
        $variationArray = [];
        if ( isset($shopProduct->variations) && !blank($shopProduct->variations) ) {
            foreach ( $shopProduct->variations as $variation ) {
                $variation->discount_price = $variation->discount_price;
                $order_line_item_count     = OrderLineItem::where('shop_product_variation_id', $variation->id)->sum('quantity');
                $variation->stock_count    = $variation->quantity - $order_line_item_count;
                $variation->in_stock       = ($variation->stock_count > 0) ? true : false;
                $variationArray[]          = $variation;
            }
        }
        $getProduct->setAttribute('variations', $variationArray);
        $getProduct->setAttribute('options', $shopProduct->options);
        $getProduct->setAttribute('ratings', app(RatingsService::class)->avgRating($shop, $product));
        $getProduct->setAttribute('shop_product_unit_price', $shopProduct->unit_price);
        $getProduct->setAttribute('shop_product_discount_price', $shopProduct->discount_price);
        return response()->json([
            'status' => 200,
            'data'   => new ProductShopResource($getProduct),
        ], 200);
    }
}
