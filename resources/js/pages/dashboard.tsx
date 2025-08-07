import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Product {
    id: number;
    name: string;
    sku: string;
    current_stock: number;
    reorder_level: number;
    category: {
        name: string;
    };
    supplier: {
        name: string;
    };
}

interface StockMovement {
    id: number;
    type: string;
    quantity: number;
    movement_date: string;
    product: {
        name: string;
        sku: string;
    };
    user: {
        name: string;
    };
}

interface OutgoingRequest {
    id: number;
    request_number: string;
    purpose: string;
    status: string;
    requested_at: string;
    requested_by: {
        name: string;
    };
    items: Array<{
        requested_quantity: number;
        product: {
            name: string;
        };
    }>;
}

interface Props {
    stats: {
        total_products: number;
        low_stock_products: number;
        pending_requests: number;
        pending_repairs: number;
        recent_returns: number;
        total_suppliers: number;
        total_categories: number;
        total_stock_value: number;
    };
    lowStockProducts: Product[];
    recentMovements: StockMovement[];
    pendingRequests: OutgoingRequest[];
    [key: string]: unknown;
}

export default function Dashboard({ stats, lowStockProducts, recentMovements, pendingRequests }: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    const getMovementBadgeVariant = (type: string) => {
        switch (type) {
            case 'in':
                return 'default';
            case 'out':
                return 'destructive';
            case 'adjustment':
                return 'secondary';
            case 'return':
                return 'outline';
            default:
                return 'secondary';
        }
    };

    const getMovementIcon = (type: string) => {
        switch (type) {
            case 'in':
                return '📦';
            case 'out':
                return '📤';
            case 'adjustment':
                return '🔧';
            case 'return':
                return '🔄';
            case 'repair':
                return '🛠️';
            default:
                return '📋';
        }
    };

    return (
        <AppShell>
            <Head title="Inventory Dashboard" />
            
            <div className="space-y-8">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">📦 Inventory Dashboard</h1>
                        <p className="text-gray-600 mt-2">
                            Monitor your warehouse operations and stock levels in real-time
                        </p>
                    </div>
                    <div className="flex space-x-3">
                        <Link href="/products">
                            <Button>📋 Manage Products</Button>
                        </Link>
                        <Link href="/products/create">
                            <Button variant="outline">➕ Add Product</Button>
                        </Link>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Total Products</CardTitle>
                            <span className="text-2xl">📦</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{stats.total_products}</div>
                            <p className="text-xs text-gray-600 mt-1">Active products in inventory</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Low Stock Alerts</CardTitle>
                            <span className="text-2xl">⚠️</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-orange-600">{stats.low_stock_products}</div>
                            <p className="text-xs text-gray-600 mt-1">Items below reorder level</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Pending Requests</CardTitle>
                            <span className="text-2xl">📋</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-blue-600">{stats.pending_requests}</div>
                            <p className="text-xs text-gray-600 mt-1">Awaiting approval</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Stock Value</CardTitle>
                            <span className="text-2xl">💰</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">
                                {formatCurrency(stats.total_stock_value)}
                            </div>
                            <p className="text-xs text-gray-600 mt-1">Total inventory value</p>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Low Stock Products */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span>⚠️</span>
                                <span>Low Stock Products</span>
                            </CardTitle>
                            <CardDescription>
                                Products that need to be restocked soon
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {lowStockProducts.length > 0 ? (
                                    lowStockProducts.map((product) => (
                                        <div key={product.id} className="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                                            <div>
                                                <p className="font-medium">{product.name}</p>
                                                <p className="text-sm text-gray-600">{product.sku} • {product.category.name}</p>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-bold text-orange-600">{product.current_stock} left</p>
                                                <p className="text-xs text-gray-600">Min: {product.reorder_level}</p>
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500 text-center py-4">
                                        ✅ All products are adequately stocked
                                    </p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Recent Stock Movements */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span>📊</span>
                                <span>Recent Stock Movements</span>
                            </CardTitle>
                            <CardDescription>
                                Latest inventory transactions and updates
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentMovements.map((movement) => (
                                    <div key={movement.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div className="flex items-center space-x-3">
                                            <span className="text-lg">{getMovementIcon(movement.type)}</span>
                                            <div>
                                                <p className="font-medium">{movement.product.name}</p>
                                                <p className="text-sm text-gray-600">by {movement.user.name}</p>
                                            </div>
                                        </div>
                                        <div className="text-right">
                                            <Badge variant={getMovementBadgeVariant(movement.type)}>
                                                {movement.type === 'out' ? '-' : '+'}{Math.abs(movement.quantity)}
                                            </Badge>
                                            <p className="text-xs text-gray-600 mt-1">
                                                {formatDate(movement.movement_date)}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Pending Outgoing Requests */}
                {pendingRequests.length > 0 && (
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span>📋</span>
                                <span>Pending Outgoing Requests</span>
                            </CardTitle>
                            <CardDescription>
                                Requests awaiting approval from leadership
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {pendingRequests.map((request) => (
                                    <div key={request.id} className="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <div>
                                            <p className="font-medium">{request.request_number}</p>
                                            <p className="text-sm text-gray-600">
                                                {request.purpose} • Requested by {request.requested_by.name}
                                            </p>
                                            <p className="text-xs text-gray-500 mt-1">
                                                {request.items.length} item(s) • {formatDate(request.requested_at)}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <Badge variant="secondary">Pending</Badge>
                                            <Link 
                                                href={`/outgoing-requests/${request.id}`}
                                                className="block mt-2"
                                            >
                                                <Button size="sm" variant="outline">
                                                    Review
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                )}

                {/* Quick Actions */}
                <Card>
                    <CardHeader>
                        <CardTitle>🚀 Quick Actions</CardTitle>
                        <CardDescription>
                            Common tasks and shortcuts for efficient workflow
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <Link href="/products/create">
                                <Button variant="outline" className="w-full h-20 flex flex-col space-y-1">
                                    <span className="text-2xl">➕</span>
                                    <span className="text-sm">Add Product</span>
                                </Button>
                            </Link>
                            
                            <Link href="/stock-movements">
                                <Button variant="outline" className="w-full h-20 flex flex-col space-y-1">
                                    <span className="text-2xl">📊</span>
                                    <span className="text-sm">Stock Movements</span>
                                </Button>
                            </Link>
                            
                            <Link href="/outgoing-requests/create">
                                <Button variant="outline" className="w-full h-20 flex flex-col space-y-1">
                                    <span className="text-2xl">📤</span>
                                    <span className="text-sm">New Request</span>
                                </Button>
                            </Link>
                            
                            <Link href="/reports">
                                <Button variant="outline" className="w-full h-20 flex flex-col space-y-1">
                                    <span className="text-2xl">📈</span>
                                    <span className="text-sm">Reports</span>
                                </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}