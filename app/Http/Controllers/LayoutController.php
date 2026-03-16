<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LayoutController extends Controller
{
    /**
     * Toggle between QBO and traditional layout
     */
    public function toggle(Request $request): JsonResponse
    {
        $useQbo = $request->get('qbo', false);
        
        // Store preference in session
        session(['use_qbo_layout' => $useQbo]);
        
        return response()->json([
            'success' => true,
            'layout' => $useQbo ? 'qbo' : 'traditional',
            'message' => $useQbo ? 'Switched to QBO Layout' : 'Switched to Traditional Layout'
        ]);
    }
    
    /**
     * Get current layout preference
     */
    public function current(): JsonResponse
    {
        $useQbo = session('use_qbo_layout', false);
        
        return response()->json([
            'layout' => $useQbo ? 'qbo' : 'traditional',
            'use_qbo' => $useQbo
        ]);
    }
}
