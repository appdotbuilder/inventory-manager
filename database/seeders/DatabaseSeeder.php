<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create leader user
        $leader = User::create([
            'name' => 'Team Leader',
            'email' => 'leader@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'leader',
            'email_verified_at' => now(),
        ]);

        // Create warehouse staff user
        $staff = User::create([
            'name' => 'Warehouse Staff',
            'email' => 'staff@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse_staff',
            'email_verified_at' => now(),
        ]);

        // Create categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'code' => 'ELEC',
            'description' => 'Electronic devices and components',
            'is_active' => true,
        ]);

        $furniture = Category::create([
            'name' => 'Furniture',
            'code' => 'FURN',
            'description' => 'Office and warehouse furniture',
            'is_active' => true,
        ]);

        $tools = Category::create([
            'name' => 'Tools',
            'code' => 'TOOL',
            'description' => 'Hand tools and equipment',
            'is_active' => true,
        ]);

        $stationery = Category::create([
            'name' => 'Stationery',
            'code' => 'STAT',
            'description' => 'Office supplies and stationery',
            'is_active' => true,
        ]);

        // Create suppliers
        $techSupplier = Supplier::create([
            'name' => 'TechCorp Supplies',
            'code' => 'TECH001',
            'email' => 'orders@techcorp.com',
            'phone' => '+1-555-0123',
            'address' => '123 Tech Street, Silicon Valley, CA 94000',
            'contact_person' => 'John Smith',
            'is_active' => true,
        ]);

        $officeSupplier = Supplier::create([
            'name' => 'OfficeMax Pro',
            'code' => 'OFF001',
            'email' => 'sales@officemax.com',
            'phone' => '+1-555-0456',
            'address' => '456 Business Ave, New York, NY 10001',
            'contact_person' => 'Sarah Johnson',
            'is_active' => true,
        ]);

        $industrialSupplier = Supplier::create([
            'name' => 'Industrial Tools Ltd',
            'code' => 'IND001',
            'email' => 'contact@industrialtools.com',
            'phone' => '+1-555-0789',
            'address' => '789 Industrial Blvd, Detroit, MI 48000',
            'contact_person' => 'Mike Wilson',
            'is_active' => true,
        ]);

        // Create products
        $products = [
            [
                'name' => 'Wireless Mouse',
                'sku' => 'ELEC-MOUSE-001',
                'description' => 'Ergonomic wireless optical mouse with USB receiver',
                'category_id' => $electronics->id,
                'supplier_id' => $techSupplier->id,
                'cost_price' => 15.99,
                'selling_price' => 29.99,
                'reorder_level' => 20,
                'current_stock' => 150,
                'unit' => 'pcs',
                'barcode' => '1234567890123',
                'qr_code' => 'QR_ELEC-MOUSE-001',
            ],
            [
                'name' => 'USB-C Cable',
                'sku' => 'ELEC-CABLE-002',
                'description' => '6-foot USB-C charging and data cable',
                'category_id' => $electronics->id,
                'supplier_id' => $techSupplier->id,
                'cost_price' => 8.50,
                'selling_price' => 19.99,
                'reorder_level' => 50,
                'current_stock' => 8, // Low stock
                'unit' => 'pcs',
                'barcode' => '1234567890124',
                'qr_code' => 'QR_ELEC-CABLE-002',
            ],
            [
                'name' => 'Office Desk',
                'sku' => 'FURN-DESK-001',
                'description' => 'Height-adjustable office desk with cable management',
                'category_id' => $furniture->id,
                'supplier_id' => $officeSupplier->id,
                'cost_price' => 299.99,
                'selling_price' => 599.99,
                'reorder_level' => 5,
                'current_stock' => 25,
                'unit' => 'pcs',
                'barcode' => '1234567890125',
                'qr_code' => 'QR_FURN-DESK-001',
            ],
            [
                'name' => 'Ergonomic Chair',
                'sku' => 'FURN-CHAIR-001',
                'description' => 'Mesh back ergonomic office chair with lumbar support',
                'category_id' => $furniture->id,
                'supplier_id' => $officeSupplier->id,
                'cost_price' => 199.99,
                'selling_price' => 399.99,
                'reorder_level' => 10,
                'current_stock' => 3, // Low stock
                'unit' => 'pcs',
                'barcode' => '1234567890126',
                'qr_code' => 'QR_FURN-CHAIR-001',
            ],
            [
                'name' => 'Screwdriver Set',
                'sku' => 'TOOL-SCREW-001',
                'description' => '12-piece precision screwdriver set with magnetic tips',
                'category_id' => $tools->id,
                'supplier_id' => $industrialSupplier->id,
                'cost_price' => 24.99,
                'selling_price' => 49.99,
                'reorder_level' => 15,
                'current_stock' => 45,
                'unit' => 'sets',
                'barcode' => '1234567890127',
                'qr_code' => 'QR_TOOL-SCREW-001',
            ],
            [
                'name' => 'A4 Paper',
                'sku' => 'STAT-PAPER-001',
                'description' => 'Premium white A4 copy paper, 500 sheets per ream',
                'category_id' => $stationery->id,
                'supplier_id' => $officeSupplier->id,
                'cost_price' => 4.99,
                'selling_price' => 9.99,
                'reorder_level' => 100,
                'current_stock' => 500,
                'unit' => 'reams',
                'barcode' => '1234567890128',
                'qr_code' => 'QR_STAT-PAPER-001',
            ],
            [
                'name' => 'Ball Point Pens',
                'sku' => 'STAT-PEN-001',
                'description' => 'Black ink ball point pens, pack of 10',
                'category_id' => $stationery->id,
                'supplier_id' => $officeSupplier->id,
                'cost_price' => 2.99,
                'selling_price' => 7.99,
                'reorder_level' => 50,
                'current_stock' => 12, // Low stock
                'unit' => 'packs',
                'barcode' => '1234567890129',
                'qr_code' => 'QR_STAT-PEN-001',
            ],
            [
                'name' => 'Power Drill',
                'sku' => 'TOOL-DRILL-001',
                'description' => '18V cordless power drill with battery and charger',
                'category_id' => $tools->id,
                'supplier_id' => $industrialSupplier->id,
                'cost_price' => 79.99,
                'selling_price' => 159.99,
                'reorder_level' => 8,
                'current_stock' => 18,
                'unit' => 'pcs',
                'barcode' => '1234567890130',
                'qr_code' => 'QR_TOOL-DRILL-001',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
            
            // Create initial stock movement
            if ($product->current_stock > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $product->current_stock,
                    'previous_stock' => 0,
                    'new_stock' => $product->current_stock,
                    'reference' => 'INITIAL_STOCK',
                    'notes' => 'Initial stock entry during system setup',
                    'user_id' => $admin->id,
                    'movement_date' => now()->subDays(random_int(1, 30)),
                ]);
                
                // Add some random stock movements for demo
                $movementCount = random_int(2, 8);
                for ($i = 0; $i < $movementCount; $i++) {
                    $isIncoming = random_int(0, 1) === 1;
                    $quantity = random_int(1, 20);
                    $previousStock = $product->current_stock;
                    
                    if (!$isIncoming && $quantity > $previousStock) {
                        $quantity = max(1, (int)($previousStock * 0.3));
                    }
                    
                    $newStock = $isIncoming ? 
                        $previousStock + $quantity : 
                        $previousStock - $quantity;
                    
                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => $isIncoming ? 'in' : 'out',
                        'quantity' => $isIncoming ? $quantity : -$quantity,
                        'previous_stock' => $previousStock,
                        'new_stock' => $newStock,
                        'reference' => $isIncoming ? 'RECEIVING_' . strtoupper(substr(hash('sha256', (string) random_int(1000, 9999)), 0, 8)) : 'SHIPMENT_' . strtoupper(substr(hash('sha256', (string) random_int(1000, 9999)), 0, 8)),
                        'notes' => $isIncoming ? 'Stock received from supplier' : 'Stock shipped to customer',
                        'user_id' => random_int(0, 1) ? $staff->id : $admin->id,
                        'movement_date' => now()->subDays(random_int(1, 29)),
                    ]);
                }
            }
        }
    }
}