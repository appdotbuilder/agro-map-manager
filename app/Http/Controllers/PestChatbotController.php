<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PestChatbotController extends Controller
{
    /**
     * Handle AI chatbot interaction for pest identification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'context' => 'nullable|array',
        ]);

        // This would integrate with an AI service like OpenAI
        // For now, we'll return a mock response
        $message = strtolower($request->message);
        $response = '';

        if (str_contains($message, 'leaf') && str_contains($message, 'spot')) {
            $response = "Based on your description of leaf spots, this could be a fungal disease. Common causes include leaf blight or leaf spot diseases. I recommend checking for circular or irregular brown spots on leaves. Would you like me to show you some common leaf spot diseases and their treatments?";
        } elseif (str_contains($message, 'wilt')) {
            $response = "Wilting symptoms can be caused by various factors including bacterial wilt, fungal diseases, or water stress. Can you describe the pattern of wilting? Is it affecting the whole plant or just certain leaves?";
        } elseif (str_contains($message, 'insect') || str_contains($message, 'bug')) {
            $response = "For insect identification, it would help to know the size, color, and behavior of the pest. Can you describe what the insect looks like? Also, what type of crop is affected?";
        } else {
            $response = "I'd be happy to help identify pests or diseases. Please describe the symptoms you're observing, such as: leaf discoloration, spots, wilting, insect damage, or any other unusual signs. Also mention what crop or plant is affected.";
        }

        return response()->json([
            'response' => $response,
            'suggestions' => [
                'Show me common leaf diseases',
                'Help identify insect pests',
                'What causes plant wilting?',
                'Recommend pest control methods'
            ]
        ]);
    }
}