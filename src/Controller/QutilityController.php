<?php

namespace Wuang\Qutility\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\GeneralSetting;
use Wuang\Qutility\Wuang;

class QutilityController extends Controller
{
    public function WuangStart()
    {
        $pageTitle = 'Active';
        return view('laramin_start', compact('pageTitle'));
    }
  
    
    public function laraminSubmit(Request $request)
    {
        // Tạo mảng thông tin cần gửi
        $param = [
            'code' => $request->purchase_code,
            'url' => env("APP_URL"),
            'user' => $request->envato_username,
            'email' => $request->email,
            'product' => 'wuang'
        ];
    
        // Địa chỉ máy chủ xác thực
        $reqRoute = Wuang::lcLabSbm();
    
        // Gửi yêu cầu POST đến máy chủ và nhận phản hồi
        $response = Http::post($reqRoute, $param);
    
        // Kiểm tra phản hồi
        if ($response->status() !== 200) {
            return response()->json(['type' => 'error', 'message' => 'Invalid response status']);
        }
    
        $responseData = $response->json();
    
        if ($responseData['error'] ?? '' === 'error') {
            return response()->json(['type' => 'error', 'message' => $responseData['message']]);
        }
    
        // Cập nhật tệp .env
        $envFilePath = base_path('.env');
        $envContent = file_get_contents($envFilePath);
        $envLines = explode("\n", $envContent);
        $envLines = array_filter($envLines, function ($line) use ($param) {
            return !str_starts_with(trim($line), 'PURCHASECODE=');
        });
        $envLines[] = 'PURCHASECODE=' . $param['code'];
        $envString = implode("\n", $envLines);
        file_put_contents($envFilePath, $envString);
    
        // Cập nhật tệp wuang.json
        $laraminFilePath = base_path('wuang.json');
        $laraminContent = [
            'purchase_code' => $request->purchase_code,
            'installcode' => $responseData['installcode'] ?? '',
            'license_type' => $responseData['license_type'] ?? ''
        ];
        file_put_contents($laraminFilePath, json_encode($laraminContent, JSON_PRETTY_PRINT));
    
        // Cập nhật cơ sở dữ liệu
        $general = GeneralSetting::first();
        if ($general) {
            $general->maintenance_mode = 0;
            $general->save();
        }
    
        return response()->json(['type' => 'success']);
    }
    
}
