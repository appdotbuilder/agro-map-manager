import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';

interface Commodity {
    id: number;
    name: string;
    category: string;
}

interface Variety {
    id: number;
    name: string;
    description: string | null;
    maturity_days: number | null;
    potential_yield: string | null;
    yield_unit: string;
    image_url: string | null;
    agronomic_traits: Record<string, unknown>;
    pest_susceptibility: Record<string, unknown>;
    commodity: Commodity;
}

interface Props {
    varieties: {
        data: Variety[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
    filters: {
        search?: string;
        commodity_id?: string;
    };
    [key: string]: unknown;
}

export default function VarietyIndex({ varieties, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');

    const handleFilter = () => {
        router.get('/varieties', {
            search: search || undefined,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const resetFilters = () => {
        setSearch('');
        router.get('/varieties', {}, { preserveState: true });
    };

    return (
        <>
            <Head title="🌱 Varieties - GeoAgri" />
            
            <div className="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="bg-white/80 backdrop-blur-sm border-b border-green-100 dark:bg-gray-800/80 dark:border-gray-700">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-4">
                                <Link href="/" className="flex items-center space-x-2 text-green-800 dark:text-green-200 hover:text-green-600">
                                    <span className="text-2xl">🌾</span>
                                    <span className="font-bold">GeoAgri</span>
                                </Link>
                                <span className="text-gray-400">→</span>
                                <h1 className="text-lg font-semibold text-gray-900 dark:text-white">🌱 Varieties</h1>
                            </div>
                            <nav className="flex items-center space-x-4">
                                <Link href="/commodities" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100">
                                    📊 Commodities
                                </Link>
                                <Link href="/pest-detection" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100">
                                    🔍 Pest Detection
                                </Link>
                            </nav>
                        </div>
                    </div>
                </header>

                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {/* Page Header */}
                    <div className="text-center mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            🌱 Crop Varieties Database
                        </h1>
                        <p className="text-lg text-gray-600 dark:text-gray-300">
                            Explore detailed information about different crop varieties and their characteristics
                        </p>
                    </div>

                    {/* Search Bar */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                        <div className="flex gap-4 items-end">
                            <div className="flex-1">
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    🔍 Search Varieties
                                </label>
                                <input
                                    type="text"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    placeholder="Search by variety name, commodity, or description..."
                                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                />
                            </div>
                            <div className="flex space-x-2">
                                <button
                                    onClick={handleFilter}
                                    className="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium"
                                >
                                    Search
                                </button>
                                <button
                                    onClick={resetFilters}
                                    className="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Results Summary */}
                    <div className="mb-6">
                        <p className="text-gray-600 dark:text-gray-300">
                            Showing {varieties.data.length} of {varieties.total} varieties
                            {search && (
                                <span className="ml-2 text-sm bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-1 rounded">
                                    Filtered
                                </span>
                            )}
                        </p>
                    </div>

                    {/* Varieties Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        {varieties.data.map(variety => (
                            <Link key={variety.id} href={`/varieties/${variety.id}`} className="group">
                                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105 overflow-hidden">
                                    {variety.image_url ? (
                                        <img 
                                            src={variety.image_url} 
                                            alt={variety.name}
                                            className="w-full h-48 object-cover"
                                        />
                                    ) : (
                                        <div className="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-800 dark:to-green-900 flex items-center justify-center">
                                            <div className="text-4xl">🌱</div>
                                        </div>
                                    )}
                                    
                                    <div className="p-6">
                                        <div className="flex items-start justify-between mb-2">
                                            <h3 className="text-lg font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                                {variety.name}
                                            </h3>
                                            <span className="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-1 rounded-full">
                                                {variety.commodity.category}
                                            </span>
                                        </div>
                                        
                                        <p className="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                            {variety.commodity.name}
                                        </p>
                                        
                                        <p className="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-3">
                                            {variety.description || 'No description available.'}
                                        </p>
                                        
                                        <div className="space-y-2 mb-4">
                                            {variety.maturity_days && (
                                                <div className="flex items-center text-xs text-gray-500">
                                                    <span className="mr-2">⏱️</span>
                                                    <span>{variety.maturity_days} days to maturity</span>
                                                </div>
                                            )}
                                            {variety.potential_yield && (
                                                <div className="flex items-center text-xs text-gray-500">
                                                    <span className="mr-2">📈</span>
                                                    <span>{variety.potential_yield} {variety.yield_unit}/hectare potential</span>
                                                </div>
                                            )}
                                            {variety.agronomic_traits && Object.keys(variety.agronomic_traits).length > 0 && (
                                                <div className="flex items-center text-xs text-gray-500">
                                                    <span className="mr-2">🧬</span>
                                                    <span>Agronomic traits available</span>
                                                </div>
                                            )}
                                            {variety.pest_susceptibility && Object.keys(variety.pest_susceptibility).length > 0 && (
                                                <div className="flex items-center text-xs text-gray-500">
                                                    <span className="mr-2">🛡️</span>
                                                    <span>Pest resistance data</span>
                                                </div>
                                            )}
                                        </div>
                                        
                                        <div className="flex items-center justify-end">
                                            <span className="text-green-600 dark:text-green-400 font-medium group-hover:translate-x-1 transition-transform duration-200">
                                                View Details →
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>

                    {/* Empty State */}
                    {varieties.data.length === 0 && (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">🔍</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">No varieties found</h3>
                            <p className="text-gray-600 dark:text-gray-300 mb-6">
                                Try adjusting your search criteria or browse all varieties.
                            </p>
                            <button
                                onClick={resetFilters}
                                className="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors"
                            >
                                View All Varieties
                            </button>
                        </div>
                    )}

                    {/* Pagination */}
                    {varieties.last_page > 1 && (
                        <div className="flex justify-center space-x-2">
                            {varieties.links.map((link, index) => (
                                <Link
                                    key={index}
                                    href={link.url || '#'}
                                    className={`px-3 py-2 text-sm rounded-lg transition-colors ${
                                        link.active 
                                            ? 'bg-green-600 text-white' 
                                            : link.url 
                                                ? 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600'
                                                : 'bg-gray-100 dark:bg-gray-700 text-gray-400 cursor-not-allowed'
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}