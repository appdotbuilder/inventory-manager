import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
        } | null;
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    return (
        <div className="min-h-screen bg-gradient-to-b from-gray-50 to-white">
            <Head title="Inventory Management System" />
            
            {/* Header */}
            <header className="bg-white shadow-sm border-b">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center py-6">
                        <div className="flex items-center">
                            <div className="flex-shrink-0">
                                <span className="text-2xl font-bold text-indigo-600">📦 InvenTrack</span>
                            </div>
                        </div>
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href="/dashboard"
                                    className="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <div className="flex items-center space-x-3">
                                    <Link
                                        href="/login"
                                        className="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href="/register"
                                        className="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors"
                                    >
                                        Get Started
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </header>

            {/* Hero Section */}
            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="text-center">
                    <h1 className="text-4xl font-bold text-gray-900 sm:text-5xl md:text-6xl">
                        📦 Comprehensive
                        <span className="block text-indigo-600">Inventory Management</span>
                    </h1>
                    <p className="mt-6 max-w-3xl mx-auto text-xl text-gray-600">
                        Streamline your warehouse operations with automated QR code generation, 
                        real-time stock tracking, product returns, repairs, and multi-role user management.
                    </p>
                    
                    {!auth.user && (
                        <div className="mt-10 flex justify-center space-x-4">
                            <Link href="/register">
                                <Button size="lg" className="px-8 py-3 text-lg">
                                    🚀 Start Free Trial
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button variant="outline" size="lg" className="px-8 py-3 text-lg">
                                    📋 View Demo
                                </Button>
                            </Link>
                        </div>
                    )}
                </div>

                {/* Features Grid */}
                <div className="mt-20">
                    <h2 className="text-3xl font-bold text-center text-gray-900 mb-12">
                        ✨ Powerful Features for Modern Warehouses
                    </h2>
                    
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {/* Feature 1 */}
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">📱</div>
                            <h3 className="text-xl font-semibold mb-3">QR Code Generation</h3>
                            <p className="text-gray-600">
                                Automatically generate unique QR codes for every SKU unit. 
                                Quick scanning for stock movements and tracking.
                            </p>
                        </div>

                        {/* Feature 2 */}
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-xl font-semibold mb-3">Real-time Stock Tracking</h3>
                            <p className="text-gray-600">
                                Monitor inventory levels in real-time with automated alerts 
                                for low stock and detailed movement history.
                            </p>
                        </div>

                        {/* Feature 3 */}
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">🔄</div>
                            <h3 className="text-xl font-semibold mb-3">Returns & Repairs</h3>
                            <p className="text-gray-600">
                                Complete workflow for product returns and repair management 
                                with status tracking and cost analysis.
                            </p>
                        </div>

                        {/* Feature 4 */}
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-xl font-semibold mb-3">Multi-Role Access</h3>
                            <p className="text-gray-600">
                                Admin, Leader, and Warehouse Staff roles with appropriate 
                                permissions and approval workflows.
                            </p>
                        </div>

                        {/* Feature 5 */}
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">📋</div>
                            <h3 className="text-xl font-semibold mb-3">Outgoing Requests</h3>
                            <p className="text-gray-600">
                                Staff can create outgoing requests that require leader approval 
                                before stock fulfillment with full audit trail.
                            </p>
                        </div>

                        {/* Feature 6 */}
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">📈</div>
                            <h3 className="text-xl font-semibold mb-3">Inventory Reports</h3>
                            <p className="text-gray-600">
                                Comprehensive reporting on stock levels, movements, 
                                supplier performance, and financial summaries.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Role-based Access Section */}
                <div className="mt-20 bg-indigo-50 rounded-2xl p-8">
                    <h2 className="text-3xl font-bold text-center text-gray-900 mb-8">
                        🎭 Role-Based Access Control
                    </h2>
                    
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div className="bg-white rounded-lg p-6 text-center">
                            <div className="text-3xl mb-3">👑</div>
                            <h3 className="text-lg font-semibold mb-2">Admin</h3>
                            <p className="text-sm text-gray-600">Full system control, user management, reports</p>
                        </div>
                        
                        <div className="bg-white rounded-lg p-6 text-center">
                            <div className="text-3xl mb-3">🎯</div>
                            <h3 className="text-lg font-semibold mb-2">Leader</h3>
                            <p className="text-sm text-gray-600">Approves outgoing requests, oversees operations</p>
                        </div>
                        
                        <div className="bg-white rounded-lg p-6 text-center">
                            <div className="text-3xl mb-3">👷</div>
                            <h3 className="text-lg font-semibold mb-2">Warehouse Staff</h3>
                            <p className="text-sm text-gray-600">Stock input, operational tasks, request creation</p>
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                {!auth.user && (
                    <div className="mt-20 text-center bg-white rounded-2xl p-12 shadow-lg">
                        <h2 className="text-3xl font-bold text-gray-900 mb-6">
                            Ready to Transform Your Inventory Management? 🚀
                        </h2>
                        <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                            Join thousands of warehouses already using InvenTrack to streamline 
                            their operations and reduce costs.
                        </p>
                        <div className="flex justify-center space-x-4">
                            <Link href="/register">
                                <Button size="lg" className="px-8 py-4 text-lg">
                                    💼 Create Account
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button variant="outline" size="lg" className="px-8 py-4 text-lg">
                                    🔑 Sign In
                                </Button>
                            </Link>
                        </div>
                    </div>
                )}
            </main>

            {/* Footer */}
            <footer className="bg-gray-50 border-t mt-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div className="text-center">
                        <div className="text-2xl font-bold text-indigo-600 mb-4">📦 InvenTrack</div>
                        <p className="text-gray-600">
                            Professional inventory management system with QR code automation
                        </p>
                        <div className="mt-6 flex justify-center space-x-6 text-sm text-gray-500">
                            <span>✅ Real-time Tracking</span>
                            <span>✅ QR Code Integration</span>
                            <span>✅ Multi-role Access</span>
                            <span>✅ Return Management</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}