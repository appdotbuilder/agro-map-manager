import React, { useState, useRef } from 'react';
import { Head, Link } from '@inertiajs/react';

interface Pest {
    id: number;
    name: string;
    scientific_name: string | null;
    type: 'pest' | 'disease';
    description: string | null;
    symptoms: string[] | null;
    control_methods: string[] | null;
    insecticide_recommendations: string[] | null;
    image_url: string | null;
}

interface Commodity {
    id: number;
    name: string;
}

interface Props {
    recentPests: Pest[];
    commodities: Commodity[];
    [key: string]: unknown;
}

interface ChatMessage {
    id: string;
    type: 'user' | 'bot';
    message: string;
    timestamp: Date;
}

export default function PestDetection({ recentPests, commodities }: Props) {
    const [activeTab, setActiveTab] = useState<'upload' | 'symptoms' | 'chatbot'>('upload');
    const [searchResults, setSearchResults] = useState<Pest[]>([]);
    const [isSearching, setIsSearching] = useState(false);
    const [chatMessages, setChatMessages] = useState<ChatMessage[]>([
        {
            id: '1',
            type: 'bot',
            message: "Hello! I'm your AI pest detection assistant. I can help you identify plant pests and diseases. You can describe symptoms, upload images, or ask questions about pest management. How can I help you today?",
            timestamp: new Date()
        }
    ]);
    const [chatInput, setChatInput] = useState('');
    const [isChatLoading, setIsChatLoading] = useState(false);
    const fileInputRef = useRef<HTMLInputElement>(null);

    // Symptom search form
    const [symptoms, setSymptoms] = useState('');
    const [selectedCommodity, setSelectedCommodity] = useState<number | null>(null);
    const [selectedType, setSelectedType] = useState<'pest' | 'disease' | ''>('');

    const handleSymptomSearch = async () => {
        if (!symptoms.trim()) return;
        
        setIsSearching(true);
        try {
            const response = await fetch('/api/pest-search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify({
                    symptoms,
                    commodity_id: selectedCommodity || undefined,
                    type: selectedType || undefined,
                }),
            });
            
            if (response.ok) {
                const results = await response.json();
                setSearchResults(results);
            }
        } catch (error) {
            console.error('Search error:', error);
        } finally {
            setIsSearching(false);
        }
    };

    const handleImageUpload = () => {
        fileInputRef.current?.click();
    };

    const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const file = event.target.files?.[0];
        if (file) {
            // In a real implementation, this would upload to an AI service
            const newMessage: ChatMessage = {
                id: Date.now().toString(),
                type: 'user',
                message: `📸 Uploaded image: ${file.name}`,
                timestamp: new Date()
            };
            
            const botResponse: ChatMessage = {
                id: (Date.now() + 1).toString(),
                type: 'bot',
                message: "I can see your image! Based on the visual analysis, this appears to be a leaf with some discoloration patterns. For more accurate identification, could you also describe: 1) What crop/plant is this? 2) When did you first notice the symptoms? 3) Are other plants affected? This will help me provide better recommendations.",
                timestamp: new Date()
            };

            setChatMessages(prev => [...prev, newMessage, botResponse]);
        }
    };

    const handleChatSubmit = async () => {
        if (!chatInput.trim()) return;

        const userMessage: ChatMessage = {
            id: Date.now().toString(),
            type: 'user',
            message: chatInput,
            timestamp: new Date()
        };

        setChatMessages(prev => [...prev, userMessage]);
        setChatInput('');
        setIsChatLoading(true);

        try {
            const response = await fetch('/api/pest-chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify({
                    message: chatInput,
                    context: chatMessages.slice(-5), // Send last 5 messages for context
                }),
            });

            if (response.ok) {
                const data = await response.json();
                const botResponse: ChatMessage = {
                    id: (Date.now() + 1).toString(),
                    type: 'bot',
                    message: data.response,
                    timestamp: new Date()
                };
                setChatMessages(prev => [...prev, botResponse]);
            }
        } catch (error) {
            console.error('Chat error:', error);
            const errorMessage: ChatMessage = {
                id: (Date.now() + 1).toString(),
                type: 'bot',
                message: "I'm sorry, I'm having trouble processing your request right now. Please try again or describe your pest/disease symptoms in more detail.",
                timestamp: new Date()
            };
            setChatMessages(prev => [...prev, errorMessage]);
        } finally {
            setIsChatLoading(false);
        }
    };

    const quickQuestions = [
        "My plant leaves are turning yellow",
        "I see small holes in the leaves",
        "There are white spots on my crop",
        "How do I control aphids naturally?"
    ];

    return (
        <>
            <Head title="🔍 Pest Detection - GeoAgri" />
            
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
                                <h1 className="text-lg font-semibold text-gray-900 dark:text-white">🔍 Pest Detection</h1>
                            </div>
                            <nav className="flex items-center space-x-4">
                                <Link href="/commodities" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100">
                                    📊 Commodities
                                </Link>
                                <Link href="/varieties" className="text-green-700 hover:text-green-900 dark:text-green-300 dark:hover:text-green-100">
                                    🌱 Varieties
                                </Link>
                            </nav>
                        </div>
                    </div>
                </header>

                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {/* Page Header */}
                    <div className="text-center mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            🔍 Plant Pest & Disease Detection
                        </h1>
                        <p className="text-lg text-gray-600 dark:text-gray-300">
                            Identify pests and diseases using AI-powered image recognition or symptom analysis
                        </p>
                    </div>

                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Detection Interface */}
                        <div className="lg:col-span-2">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                                {/* Tab Navigation */}
                                <div className="border-b border-gray-200 dark:border-gray-700">
                                    <nav className="flex">
                                        <button
                                            onClick={() => setActiveTab('upload')}
                                            className={`flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-colors ${
                                                activeTab === 'upload'
                                                    ? 'border-green-500 text-green-600 dark:text-green-400'
                                                    : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'
                                            }`}
                                        >
                                            📸 Image Upload
                                        </button>
                                        <button
                                            onClick={() => setActiveTab('symptoms')}
                                            className={`flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-colors ${
                                                activeTab === 'symptoms'
                                                    ? 'border-green-500 text-green-600 dark:text-green-400'
                                                    : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'
                                            }`}
                                        >
                                            🔍 Symptom Search
                                        </button>
                                        <button
                                            onClick={() => setActiveTab('chatbot')}
                                            className={`flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-colors ${
                                                activeTab === 'chatbot'
                                                    ? 'border-green-500 text-green-600 dark:text-green-400'
                                                    : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'
                                            }`}
                                        >
                                            🤖 AI Assistant
                                        </button>
                                    </nav>
                                </div>

                                <div className="p-6">
                                    {/* Image Upload Tab */}
                                    {activeTab === 'upload' && (
                                        <div className="text-center">
                                            <div className="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-12 hover:border-green-400 transition-colors">
                                                <div className="text-4xl mb-4">📸</div>
                                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                                    Upload Plant Image
                                                </h3>
                                                <p className="text-gray-600 dark:text-gray-300 mb-6">
                                                    Take a clear photo of the affected plant part (leaves, stems, fruits) for AI analysis
                                                </p>
                                                <button
                                                    onClick={handleImageUpload}
                                                    className="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium"
                                                >
                                                    Choose Image File
                                                </button>
                                                <input
                                                    ref={fileInputRef}
                                                    type="file"
                                                    accept="image/*"
                                                    onChange={handleFileChange}
                                                    className="hidden"
                                                />
                                            </div>
                                            <p className="text-sm text-gray-500 dark:text-gray-400 mt-4">
                                                💡 Tip: For best results, use clear, well-lit photos showing the affected area clearly
                                            </p>
                                        </div>
                                    )}

                                    {/* Symptom Search Tab */}
                                    {activeTab === 'symptoms' && (
                                        <div className="space-y-6">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    🔍 Describe Symptoms
                                                </label>
                                                <textarea
                                                    value={symptoms}
                                                    onChange={(e) => setSymptoms(e.target.value)}
                                                    placeholder="Describe what you observe: leaf spots, discoloration, wilting, insect damage, etc."
                                                    rows={4}
                                                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                />
                                            </div>

                                            <div className="grid md:grid-cols-2 gap-4">
                                                <div>
                                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        🌱 Affected Crop (Optional)
                                                    </label>
                                                    <select
                                                        value={selectedCommodity || ''}
                                                        onChange={(e) => setSelectedCommodity(e.target.value ? parseInt(e.target.value) : null)}
                                                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                    >
                                                        <option value="">Select crop type...</option>
                                                        {commodities.map(commodity => (
                                                            <option key={commodity.id} value={commodity.id}>{commodity.name}</option>
                                                        ))}
                                                    </select>
                                                </div>

                                                <div>
                                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        🐛 Type
                                                    </label>
                                                    <select
                                                        value={selectedType}
                                                        onChange={(e) => setSelectedType(e.target.value as 'pest' | 'disease' | '')}
                                                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                    >
                                                        <option value="">Pest or Disease</option>
                                                        <option value="pest">🐛 Pest</option>
                                                        <option value="disease">🦠 Disease</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button
                                                onClick={handleSymptomSearch}
                                                disabled={!symptoms.trim() || isSearching}
                                                className="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium disabled:bg-gray-400 disabled:cursor-not-allowed"
                                            >
                                                {isSearching ? '🔍 Searching...' : '🔍 Search for Pests & Diseases'}
                                            </button>

                                            {/* Search Results */}
                                            {searchResults.length > 0 && (
                                                <div className="mt-6">
                                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                                        Search Results ({searchResults.length})
                                                    </h3>
                                                    <div className="space-y-3">
                                                        {searchResults.map(pest => (
                                                            <Link key={pest.id} href={`/pests/${pest.id}`} className="block">
                                                                <div className="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                                    <div className="flex items-start justify-between">
                                                                        <div className="flex-1">
                                                                            <h4 className="font-semibold text-gray-900 dark:text-white">
                                                                                {pest.type === 'pest' ? '🐛' : '🦠'} {pest.name}
                                                                            </h4>
                                                                            {pest.scientific_name && (
                                                                                <p className="text-sm text-gray-500 italic">{pest.scientific_name}</p>
                                                                            )}
                                                                            <p className="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                                                {pest.description}
                                                                            </p>
                                                                        </div>
                                                                        <span className="text-green-600 dark:text-green-400 text-sm">→</span>
                                                                    </div>
                                                                </div>
                                                            </Link>
                                                        ))}
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    )}

                                    {/* AI Chatbot Tab */}
                                    {activeTab === 'chatbot' && (
                                        <div className="h-96 flex flex-col">
                                            {/* Chat Messages */}
                                            <div className="flex-1 overflow-y-auto space-y-4 mb-4">
                                                {chatMessages.map(message => (
                                                    <div key={message.id} className={`flex ${message.type === 'user' ? 'justify-end' : 'justify-start'}`}>
                                                        <div className={`max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${
                                                            message.type === 'user'
                                                                ? 'bg-green-600 text-white'
                                                                : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'
                                                        }`}>
                                                            <p className="text-sm">{message.message}</p>
                                                            <p className="text-xs opacity-70 mt-1">
                                                                {message.timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                                            </p>
                                                        </div>
                                                    </div>
                                                ))}
                                                {isChatLoading && (
                                                    <div className="flex justify-start">
                                                        <div className="bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                                                            <div className="flex space-x-1">
                                                                <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                                                <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '0.1s' }}></div>
                                                                <div className="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style={{ animationDelay: '0.2s' }}></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )}
                                            </div>

                                            {/* Quick Questions */}
                                            <div className="mb-4">
                                                <p className="text-xs text-gray-500 dark:text-gray-400 mb-2">💡 Quick questions:</p>
                                                <div className="flex flex-wrap gap-2">
                                                    {quickQuestions.map((question, index) => (
                                                        <button
                                                            key={index}
                                                            onClick={() => setChatInput(question)}
                                                            className="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-1 rounded hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors"
                                                        >
                                                            {question}
                                                        </button>
                                                    ))}
                                                </div>
                                            </div>

                                            {/* Chat Input */}
                                            <div className="flex space-x-2">
                                                <input
                                                    type="text"
                                                    value={chatInput}
                                                    onChange={(e) => setChatInput(e.target.value)}
                                                    onKeyPress={(e) => e.key === 'Enter' && handleChatSubmit()}
                                                    placeholder="Describe your pest problem or ask a question..."
                                                    className="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                />
                                                <button
                                                    onClick={handleChatSubmit}
                                                    disabled={!chatInput.trim() || isChatLoading}
                                                    className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                                >
                                                    Send
                                                </button>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Recent Pests Sidebar */}
                        <div className="space-y-6">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    🐛 Recent Pest Reports
                                </h3>
                                <div className="space-y-3">
                                    {recentPests.map(pest => (
                                        <Link key={pest.id} href={`/pests/${pest.id}`} className="block">
                                            <div className="border border-gray-200 dark:border-gray-600 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <h4 className="font-medium text-gray-900 dark:text-white text-sm">
                                                    {pest.type === 'pest' ? '🐛' : '🦠'} {pest.name}
                                                </h4>
                                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                                    {pest.description}
                                                </p>
                                            </div>
                                        </Link>
                                    ))}
                                </div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    💡 Detection Tips
                                </h3>
                                <div className="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                    <div className="flex items-start space-x-2">
                                        <span>📸</span>
                                        <p>Take clear, well-lit photos of affected plant parts</p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span>🔍</span>
                                        <p>Look for patterns: spots, holes, discoloration, or insects</p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span>📝</span>
                                        <p>Note when symptoms first appeared and how they've spread</p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span>🌤️</span>
                                        <p>Consider recent weather conditions that might favor pests</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}