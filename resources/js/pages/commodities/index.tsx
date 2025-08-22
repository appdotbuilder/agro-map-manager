import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';

interface Commodity {
    id: number;
    name: string;
    scientific_name: string | null;
    description: string | null;
    category: string;
    image_url: string | null;
    growing_conditions: Record<string, unknown>;
    harvest_info: Record<string, unknown>;
    varieties_count?: number;
}

interface Props {
    commodities: {
        data: Commodity[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
    categories: string[];
    filters: {
        search?: string;
        category?: string;
    };
    [key: string]: unknown;
}

export default function CommodityIndex({ commodities, categories, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');
    const [selectedCategory, setSelectedCategory] = useState(filters.category || '');

    const handleFilter = () => {
        router.get('/commodities', {
            search: search || undefined,
            category: selectedCategory || undefined,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const resetFilters = () => {
        setSearch('');
        setSelectedCategory('');
        router.get('/commodities', {}, { preserveState: true });
    };

    return (
        <>
            <Head title="📊 Commodities - GeoAgri" />
            
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
                                <h1 className="text-lg font-semibold text-gray-900 dark:text-white">📊 Commodities</h1>
                            </div>
                            <nav className="flex items-center space-x-4">
                                <Link href="/varieties" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100">
                                    🌱 Varieties
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
                            📊 Agricultural Commodities
                        </h1>
                        <p className="text-lg text-gray-600 dark:text-gray-300">
                            Explore detailed information about various agricultural commodities
                        </p>
                    </div>

                    {/* Search and Filters */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                        <div className="grid md:grid-cols-4 gap-4 items-end">
                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    🔍 Search Commodities
                                </label>
                                <input
                                    type="text"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    placeholder="Search by name, scientific name, or category..."
                                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    🏷️ Category
                                </label>
                                <select
                                    value={selectedCategory}
                                    onChange={(e) => setSelectedCategory(e.target.value)}
                                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                    <option value="">All Categories</option>
                                    {categories.map(category => (
                                        <option key={category} value={category}>{category}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="flex space-x-2">
                                <button
                                    onClick={handleFilter}
                                    className="flex-1 bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium"
                                >
                                    Search
                                </button>
                                <button
                                    onClick={resetFilters}
                                    className="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Results Summary */}
                    <div className="mb-6">
                        <p className="text-gray-600 dark:text-gray-300">
                            Showing {commodities.data.length} of {commodities.total} commodities
                            {(search || selectedCategory) && (
                                <span className="ml-2 text-sm bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-1 rounded">
                                    Filtered
                                </span>
                            )}
                        </p>
                    </div>

                    {/* Commodities Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        {commodities.data.map(commodity => (
                            <Link key={commodity.id} href={`/commodities/${commodity.id}`} className="group">
                                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105 overflow-hidden">
                                    {commodity.image_url ? (
                                        <img 
                                            src={commodity.image_url} 
                                            alt={commodity.name}
                                            className="w-full h-48 object-cover"
                                        />
                                    ) : (
                                        <div className="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-800 dark:to-green-900 flex items-center justify-center">
                                            <div className="text-4xl">🌾</div>
                                        </div>
                                    )}
                                    
                                    <div className="p-6">
                                        <div className="flex items-start justify-between mb-2">
                                            <h3 className="text-lg font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                                {commodity.name}
                                            </h3>
                                            <span className="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-1 rounded-full">
                                                {commodity.category}
                                            </span>
                                        </div>
                                        
                                        {commodity.scientific_name && (
                                            <p className="text-sm text-gray-500 dark:text-gray-400 italic mb-2">
                                                {commodity.scientific_name}
                                            </p>
                                        )}
                                        
                                        <p className="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-3">
                                            {commodity.description || 'No description available.'}
                                        </p>
                                        
                                        <div className="flex items-center justify-between text-xs text-gray-500">
                                            <div className="flex items-center space-x-3">
                                                {commodity.growing_conditions && (
                                                    <span className="flex items-center">
                                                        <span className="mr-1">🌤️</span>
                                                        Growing info
                                                    </span>
                                                )}
                                                {commodity.harvest_info && (
                                                    <span className="flex items-center">
                                                        <span className="mr-1">🌾</span>
                                                        Harvest info
                                                    </span>
                                                )}
                                            </div>
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
                    {commodities.data.length === 0 && (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">🔍</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">No commodities found</h3>
                            <p className="text-gray-600 dark:text-gray-300 mb-6">
                                Try adjusting your search criteria or browse all commodities.
                            </p>
                            <button
                                onClick={resetFilters}
                                className="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors"
                            >
                                View All Commodities
                            </button>
                        </div>
                    )}

                    {/* Pagination */}
                    {commodities.last_page > 1 && (
                        <div className="flex justify-center space-x-2">
                            {commodities.links.map((link, index) => (
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