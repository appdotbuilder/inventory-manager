import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Category {
    id: number;
    name: string;
}

interface Supplier {
    id: number;
    name: string;
}

interface Product {
    id: number;
    name: string;
    sku: string;
    description: string;
    current_stock: number;
    reorder_level: number;
    cost_price: number;
    selling_price: number;
    unit: string;
    qr_code: string;
    is_active: boolean;
    category: Category;
    supplier: Supplier;
}

interface Props {
    products: {
        data: Product[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        meta: {
            current_page: number;
            total: number;
            per_page: number;
        };
    };
    categories: Category[];
    suppliers: Supplier[];
    filters: {
        search?: string;
        category?: string;
        supplier?: string;
        low_stock?: string;
    };
    [key: string]: unknown;
}

export default function ProductsIndex({ products, categories, suppliers, filters }: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    };

    const handleSearch = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const searchParams = Object.fromEntries(formData);
        
        router.get('/products', searchParams, {
            preserveState: true,
            replace: true,
        });
    };

    return (
        <AppShell>
            <Head title="Products - Inventory Management" />
            
            <div className="space-y-8">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">📦 Product Inventory</h1>
                        <p className="text-gray-600 mt-2">
                            Manage your product catalog with automated QR codes and real-time tracking
                        </p>
                    </div>
                    <Link href="/products/create">
                        <Button className="bg-indigo-600 hover:bg-indigo-700">
                            ➕ Add New Product
                        </Button>
                    </Link>
                </div>

                {/* Filters */}
                <Card>
                    <CardHeader>
                        <CardTitle>🔍 Search & Filters</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSearch} className="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            <div className="md:col-span-2">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search products, SKU..."
                                    defaultValue={filters.search || ''}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>
                            
                            <div>
                                <select
                                    name="category"
                                    defaultValue={filters.category || ''}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">All Categories</option>
                                    {categories.map(category => (
                                        <option key={category.id} value={category.id}>
                                            {category.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            
                            <div>
                                <select
                                    name="supplier"
                                    defaultValue={filters.supplier || ''}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">All Suppliers</option>
                                    {suppliers.map(supplier => (
                                        <option key={supplier.id} value={supplier.id}>
                                            {supplier.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            
                            <div className="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    name="low_stock"
                                    id="low_stock"
                                    value="1"
                                    defaultChecked={filters.low_stock === '1'}
                                    className="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                />
                                <label htmlFor="low_stock" className="text-sm text-gray-700">
                                    Low Stock Only
                                </label>
                            </div>
                            
                            <Button type="submit" variant="outline">
                                🔍 Search
                            </Button>
                        </form>
                    </CardContent>
                </Card>

                {/* Products Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {products.data.map((product) => (
                        <Card key={product.id} className="hover:shadow-lg transition-shadow">
                            <CardHeader>
                                <div className="flex items-start justify-between">
                                    <div>
                                        <CardTitle className="text-lg">{product.name}</CardTitle>
                                        <CardDescription className="mt-1">
                                            SKU: {product.sku}
                                        </CardDescription>
                                    </div>
                                    <div className="text-right">
                                        <div className="text-2xl mb-1">📱</div>
                                        <Badge variant="outline" className="text-xs">
                                            {product.qr_code}
                                        </Badge>
                                    </div>
                                </div>
                            </CardHeader>
                            
                            <CardContent>
                                <div className="space-y-4">
                                    {/* Stock Status */}
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm text-gray-600">Stock Level:</span>
                                        <div className="text-right">
                                            <span className={`font-semibold ${
                                                product.current_stock <= product.reorder_level 
                                                    ? 'text-red-600' 
                                                    : 'text-green-600'
                                            }`}>
                                                {product.current_stock} {product.unit}
                                            </span>
                                            {product.current_stock <= product.reorder_level && (
                                                <Badge variant="destructive" className="ml-2 text-xs">
                                                    ⚠️ Low Stock
                                                </Badge>
                                            )}
                                        </div>
                                    </div>

                                    {/* Category & Supplier */}
                                    <div className="space-y-2 text-sm">
                                        <div className="flex justify-between">
                                            <span className="text-gray-600">Category:</span>
                                            <Badge variant="secondary">{product.category.name}</Badge>
                                        </div>
                                        <div className="flex justify-between">
                                            <span className="text-gray-600">Supplier:</span>
                                            <span className="font-medium">{product.supplier.name}</span>
                                        </div>
                                    </div>

                                    {/* Pricing */}
                                    <div className="space-y-1 pt-2 border-t">
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-600">Cost Price:</span>
                                            <span className="font-medium">{formatCurrency(product.cost_price)}</span>
                                        </div>
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-600">Selling Price:</span>
                                            <span className="font-semibold text-green-600">
                                                {formatCurrency(product.selling_price)}
                                            </span>
                                        </div>
                                    </div>

                                    {/* Actions */}
                                    <div className="flex space-x-2 pt-4">
                                        <Link 
                                            href={`/products/${product.id}`}
                                            className="flex-1"
                                        >
                                            <Button variant="outline" size="sm" className="w-full">
                                                👁️ View
                                            </Button>
                                        </Link>
                                        <Link 
                                            href={`/products/${product.id}/edit`}
                                            className="flex-1"
                                        >
                                            <Button variant="outline" size="sm" className="w-full">
                                                ✏️ Edit
                                            </Button>
                                        </Link>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Pagination would go here */}
                {products.data.length === 0 && (
                    <Card>
                        <CardContent className="text-center py-12">
                            <div className="text-6xl mb-4">📦</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                            <p className="text-gray-600 mb-6">
                                {filters.search || filters.category || filters.supplier ? 
                                    'Try adjusting your search filters to find products.' :
                                    'Get started by adding your first product to the inventory.'
                                }
                            </p>
                            <Link href="/products/create">
                                <Button>➕ Add First Product</Button>
                            </Link>
                        </CardContent>
                    </Card>
                )}
            </div>
        </AppShell>
    );
}