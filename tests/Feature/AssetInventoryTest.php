<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetInventoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test accessing the Asset Vault page.
     */
    public function test_can_access_asset_vault_page(): void
    {
        $response = $this->get('/assets');

        $response->assertStatus(200);
        $response->assertSee('Asset');
        $response->assertSee('Management.');
        $response->assertSee('Nilai Aset Aktif');
    }

    /**
     * Test registering a new asset.
     */
    public function test_can_register_new_asset(): void
    {
        $response = $this->post('/assets', [
            'name'           => 'MacBook Pro M3',
            'purchase_date'  => '2026-05-20',
            'purchase_price' => 30000000,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Check if category was created automatically
        $category = Category::where('cat_name', 'Pembelian Aset')->first();
        $this->assertNotNull($category);
        $this->assertEquals('expense', $category->type);

        // Check if transaction was created automatically
        $transaction = Transaction::where('desc', 'Pembelian Aset: MacBook Pro M3')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals(30000000, $transaction->amount);
        $this->assertEquals('2026-05-20', $transaction->trans_date);
        $this->assertEquals($category->id, $transaction->category_id);

        // Check if asset was registered in inventory
        $asset = Asset::where('name', 'MacBook Pro M3')->first();
        $this->assertNotNull($asset);
        $this->assertEquals('owned', $asset->status);
        $this->assertEquals($transaction->id, $asset->purchase_transaction_id);
    }

    /**
     * Test selling an owned asset.
     */
    public function test_can_sell_owned_asset(): void
    {
        // 1. Create an asset first
        $categoryBuy = Category::create(['cat_name' => 'Pembelian Aset', 'type' => 'expense']);
        $transactionBuy = Transaction::create([
            'trans_date'  => '2026-05-10',
            'desc'        => 'Pembelian Aset: Server Dell',
            'amount'      => 50000000,
            'category_id' => $categoryBuy->id,
        ]);
        $asset = Asset::create([
            'name'                    => 'Server Dell',
            'purchase_date'           => '2026-05-10',
            'purchase_price'          => 50000000,
            'purchase_transaction_id' => $transactionBuy->id,
            'status'                  => 'owned',
        ]);

        // 2. Sell the asset
        $response = $this->post("/assets/{$asset->id}/sell", [
            'sale_date'  => '2026-05-21',
            'sale_price' => 45000000,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Check if category was created automatically
        $categorySell = Category::where('cat_name', 'Penjualan Aset')->first();
        $this->assertNotNull($categorySell);
        $this->assertEquals('income', $categorySell->type);

        // Check if transaction was created automatically
        $transactionSell = Transaction::where('desc', 'Penjualan Aset: Server Dell')->first();
        $this->assertNotNull($transactionSell);
        $this->assertEquals(45000000, $transactionSell->amount);
        $this->assertEquals($categorySell->id, $transactionSell->category_id);

        // Check if asset status updated to sold
        $asset->refresh();
        $this->assertEquals('sold', $asset->status);
        $this->assertEquals($transactionSell->id, $asset->sale_transaction_id);
        $this->assertEquals('2026-05-21', $asset->sale_date);
        $this->assertEquals(45000000, $asset->sale_price);
    }

    /**
     * Test deleting an asset.
     */
    public function test_can_delete_asset(): void
    {
        // 1. Create an asset and its transactions
        $categoryBuy = Category::create(['cat_name' => 'Pembelian Aset', 'type' => 'expense']);
        $transactionBuy = Transaction::create([
            'trans_date'  => '2026-05-10',
            'desc'        => 'Pembelian Aset: iPad Pro',
            'amount'      => 15000000,
            'category_id' => $categoryBuy->id,
        ]);
        $asset = Asset::create([
            'name'                    => 'iPad Pro',
            'purchase_date'           => '2026-05-10',
            'purchase_price'          => 15000000,
            'purchase_transaction_id' => $transactionBuy->id,
            'status'                  => 'owned',
        ]);

        // 2. Delete the asset
        $response = $this->delete("/assets/{$asset->id}");

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Check that the asset is deleted
        $this->assertDatabaseMissing('assets', ['id' => $asset->id]);

        // Check that the linked transaction is deleted
        $this->assertDatabaseMissing('transactions', ['id' => $transactionBuy->id]);
    }
}
