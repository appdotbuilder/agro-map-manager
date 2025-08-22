import React, { useState, useEffect } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';

interface Province {
    id: number;
    name: string;
    code: string;
}

interface Commodity {
    id: number;
    name: string;
    category: string;
}

interface Distribution {
    id: number;
    area_hectares: number | null;
    production_tons: number | null;
    productivity: number | null;
    year: number;
    commodity: Commodity;
    province: Province | null;
    regency: { id: number; name: string } | null;
    district: { id: number; name: string } | null;
    environmental_data: Record<string, unknown>;
}

interface Props {
    provinces: Province[];
    commodities: Commodity[];
    distributions: Distribution[];
    [key: string]: unknown;
}

export default function Welcome({ provinces, commodities, distributions }: Props) {
    const { auth } = usePage<SharedData>().props;
    const [selectedProvince, setSelectedProvince] = useState<number | null>(null);
    const [selectedCommodity, setSelectedCommodity] = useState<number | null>(null);
    const [regencies, setRegencies] = useState<Array<{ id: number; name: string }>>([]);
    const [selectedRegency, setSelectedRegency] = useState<number | null>(null);
    const [filteredDistributions, setFilteredDistributions] = useState<Distribution[]>(distributions);
    const [isLoading, setIsLoading] = useState(false);

    const categories = [...new Set(commodities.map(c => c.category))].sort();

    useEffect(() => {
        if (selectedProvince) {
            fetch(`/api/map?province_id=${selectedProvince}`)
                .then(res => res.json())
                .then(data => {
                    setRegencies(data);
                    setSelectedRegency(null);
                });
        }
    }, [selectedProvince]);



    useEffect(() => {
        setIsLoading(true);
        const params = new URLSearchParams();
        if (selectedCommodity) params.append('commodity_id', selectedCommodity.toString());
        if (selectedProvince) params.append('province_id', selectedProvince.toString());
        if (selectedRegency) params.append('regency_id', selectedRegency.toString());

        fetch(`/api/map?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
                setFilteredDistributions(data);
                setIsLoading(false);
            })
            .catch(() => setIsLoading(false));
    }, [selectedCommodity, selectedProvince, selectedRegency]);

    const resetFilters = () => {
        setSelectedProvince(null);
        setSelectedCommodity(null);
        setSelectedRegency(null);
        setRegencies([]);
        setFilteredDistributions(distributions);
    };

    const totalProduction = filteredDistributions.reduce((sum, d) => sum + (d.production_tons || 0), 0);
    const totalArea = filteredDistributions.reduce((sum, d) => sum + (d.area_hectares || 0), 0);

    return (
        <>
            <Head title="🌾 GeoAgri - Agricultural Data Management System">
                <meta name="description" content="Comprehensive platform for managing geographical agricultural data, commodity information, and pest detection with interactive mapping." />
            </Head>
            
            <div className="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="bg-white/80 backdrop-blur-sm border-b border-green-100 dark:bg-gray-800/80 dark:border-gray-700">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-3">
                                <div className="text-2xl">🌾</div>
                                <h1 className="text-xl font-bold text-green-800 dark:text-green-200">GeoAgri</h1>
                            </div>
                            <nav className="flex items-center space-x-4">
                                <Link href="/commodities" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100 transition-colors">
                                    📊 Commodities
                                </Link>
                                <Link href="/varieties" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100 transition-colors">
                                    🌱 Varieties
                                </Link>
                                <Link href="/pest-detection" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100 transition-colors">
                                    🔍 Pest Detection
                                </Link>
                                {auth.user ? (
                                    <Link href="/dashboard" className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex space-x-2">
                                        <Link href="/login" className="text-green-700 hover:text-green-900 dark:text-green-300 px-3 py-2 transition-colors">
                                            Login
                                        </Link>
                                        <Link href="/register" className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                            Register
                                        </Link>
                                    </div>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="text-center mb-8">
                        <h1 className="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            🌾 Agricultural Data Management System
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-6">
                            Explore commodity distribution, manage variety data, and detect plant pests with our comprehensive platform
                        </p>
                        
                        {/* Key Features */}
                        <div className="grid md:grid-cols-3 gap-6 mb-8">
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                <div className="text-3xl mb-3">🗺️</div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Interactive Mapping</h3>
                                <p className="text-gray-600 dark:text-gray-300">Visualize commodity distribution across provinces, regencies, and districts</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                <div className="text-3xl mb-3">🌱</div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Variety Database</h3>
                                <p className="text-gray-600 dark:text-gray-300">Comprehensive information on crop varieties and their characteristics</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                                <div className="text-3xl mb-3">🔍</div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pest Detection</h3>
                                <p className="text-gray-600 dark:text-gray-300">AI-powered pest and disease identification with treatment recommendations</p>
                            </div>
                        </div>
                    </div>

                    {/* Interactive Map Section */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                        <div className="flex flex-col lg:flex-row gap-6">
                            {/* Filters */}
                            <div className="lg:w-1/3">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">📍 Location & Commodity Filters</h3>
                                
                                <div className="space-y-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Province</label>
                                        <select
                                            value={selectedProvince || ''}
                                            onChange={(e) => setSelectedProvince(e.target.value ? parseInt(e.target.value) : null)}
                                            className="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        >
                                            <option value="">All Provinces</option>
                                            {provinces.map(province => (
                                                <option key={province.id} value={province.id}>{province.name}</option>
                                            ))}
                                        </select>
                                    </div>

                                    {selectedProvince && regencies.length > 0 && (
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Regency</label>
                                            <select
                                                value={selectedRegency || ''}
                                                onChange={(e) => setSelectedRegency(e.target.value ? parseInt(e.target.value) : null)}
                                                className="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            >
                                                <option value="">All Regencies</option>
                                                {regencies.map(regency => (
                                                    <option key={regency.id} value={regency.id}>{regency.name}</option>
                                                ))}
                                            </select>
                                        </div>
                                    )}

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Commodity</label>
                                        <select
                                            value={selectedCommodity || ''}
                                            onChange={(e) => setSelectedCommodity(e.target.value ? parseInt(e.target.value) : null)}
                                            className="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        >
                                            <option value="">All Commodities</option>
                                            {categories.map(category => (
                                                <optgroup key={category} label={category}>
                                                    {commodities.filter(c => c.category === category).map(commodity => (
                                                        <option key={commodity.id} value={commodity.id}>{commodity.name}</option>
                                                    ))}
                                                </optgroup>
                                            ))}
                                        </select>
                                    </div>

                                    <button
                                        onClick={resetFilters}
                                        className="w-full bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition-colors"
                                    >
                                        Reset Filters
                                    </button>
                                </div>

                                {/* Summary Stats */}
                                <div className="mt-6 space-y-3">
                                    <h4 className="font-medium text-gray-900 dark:text-white">📈 Summary Statistics</h4>
                                    <div className="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg">
                                        <p className="text-sm text-gray-600 dark:text-gray-300">
                                            <strong>Total Production:</strong> {totalProduction.toLocaleString()} tons
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-300">
                                            <strong>Total Area:</strong> {totalArea.toLocaleString()} hectares
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-300">
                                            <strong>Records:</strong> {filteredDistributions.length} distributions
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Map/Data Display */}
                            <div className="lg:w-2/3">
                                <div className="flex items-center justify-between mb-4">
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white">🗺️ Distribution Data</h3>
                                    {isLoading && (
                                        <div className="flex items-center text-sm text-gray-500">
                                            <div className="animate-spin mr-2">⏳</div>
                                            Loading...
                                        </div>
                                    )}
                                </div>
                                
                                {/* Map Placeholder */}
                                <div className="bg-gray-100 dark:bg-gray-700 h-64 rounded-lg flex items-center justify-center mb-4">
                                    <div className="text-center text-gray-500 dark:text-gray-400">
                                        <div className="text-4xl mb-2">🗺️</div>
                                        <p>Interactive map will be displayed here</p>
                                        <p className="text-sm">Showing {filteredDistributions.length} distribution points</p>
                                    </div>
                                </div>

                                {/* Distribution List */}
                                <div className="max-h-64 overflow-y-auto space-y-2">
                                    {filteredDistributions.map(distribution => (
                                        <div key={distribution.id} className="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                            <div className="flex justify-between items-start">
                                                <div>
                                                    <h4 className="font-medium text-gray-900 dark:text-white">
                                                        {distribution.commodity.name}
                                                    </h4>
                                                    <p className="text-sm text-gray-600 dark:text-gray-300">
                                                        📍 {distribution.province?.name}
                                                        {distribution.regency && ` → ${distribution.regency.name}`}
                                                        {distribution.district && ` → ${distribution.district.name}`}
                                                    </p>
                                                    <div className="flex space-x-4 text-xs text-gray-500 mt-1">
                                                        {distribution.area_hectares && (
                                                            <span>📏 {distribution.area_hectares} ha</span>
                                                        )}
                                                        {distribution.production_tons && (
                                                            <span>📦 {distribution.production_tons} tons</span>
                                                        )}
                                                        {distribution.productivity && (
                                                            <span>📈 {distribution.productivity} t/ha</span>
                                                        )}
                                                    </div>
                                                </div>
                                                <span className="text-xs text-gray-500 bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">
                                                    {distribution.year}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Quick Access Cards */}
                    <div className="grid md:grid-cols-3 gap-6">
                        <Link href="/commodities" className="group">
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                <div className="text-4xl mb-4">📊</div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">Browse Commodities</h3>
                                <p className="text-gray-600 dark:text-gray-300 mb-4">
                                    Explore detailed information about agricultural commodities, their growing conditions, and harvest data.
                                </p>
                                <div className="text-green-600 dark:text-green-400 font-medium group-hover:translate-x-1 transition-transform duration-200">
                                    View Commodities →
                                </div>
                            </div>
                        </Link>

                        <Link href="/varieties" className="group">
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                <div className="text-4xl mb-4">🌱</div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">Variety Database</h3>
                                <p className="text-gray-600 dark:text-gray-300 mb-4">
                                    Search and discover different crop varieties with detailed agronomic traits and pest susceptibility information.
                                </p>
                                <div className="text-green-600 dark:text-green-400 font-medium group-hover:translate-x-1 transition-transform duration-200">
                                    Browse Varieties →
                                </div>
                            </div>
                        </Link>

                        <Link href="/pest-detection" className="group">
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                <div className="text-4xl mb-4">🔍</div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">Pest Detection</h3>
                                <p className="text-gray-600 dark:text-gray-300 mb-4">
                                    Identify plant pests and diseases using AI-powered image recognition or symptom-based chatbot assistance.
                                </p>
                                <div className="text-green-600 dark:text-green-400 font-medium group-hover:translate-x-1 transition-transform duration-200">
                                    Start Detection →
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}