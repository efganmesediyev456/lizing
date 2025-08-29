<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeployController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $secret = env('GITHUB_WEBHOOK_SECRET', 'super_secret_key');
        $signature = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);

        if (!hash_equals($signature, $request->header('X-Hub-Signature-256'))) {
            Log::warning('Invalid GitHub signature');
            abort(403, 'Invalid signature');
        }

        $output = [];
        $return_var = 0;

        exec('cd ' . base_path() . ' && git pull origin main 2>&1', $output, $return_var);
        Log::info("GitHub auto-pull output: " . implode("\n", $output));

        return response()->json(['message' => 'Deployment triggered.'], 200);
    }
}
