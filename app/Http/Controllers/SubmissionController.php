<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    /**
     * Show the form for creating a new submission.
     */
    public function create(): View
    {
        return view('submissions.create');
    }

    /**
     * Store a newly created submission in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'feedback' => 'required|string|max:1000',
                'image' => 'required|string', // Base64 image
            ]);

            // Decode base64 image
            $imageData = $request->input('image');
            
            if (empty($imageData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng chụp hoặc chọn ảnh'
                ], 400);
            }
            
            // Remove data URL prefix if present
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $extension = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
            } else {
                $extension = 'png';
            }
            
            $imageData = base64_decode($imageData);
            
            if ($imageData === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu ảnh không hợp lệ'
                ], 400);
            }

            // Generate unique filename
            $filename = 'submissions/' . Str::uuid() . '.' . $extension;
            
            // Store image
            Storage::disk('public')->put($filename, $imageData);
            
            // Generate random position and rotation for wall display
            $submission = Submission::create([
                'name' => $request->input('name'),
                'feedback' => $request->input('feedback'),
                'image_path' => $filename,
                'position_x' => rand(0, 80), // Percentage position
                'position_y' => rand(0, 70),
                'rotation' => rand(-15, 15), // Random rotation in degrees
                'scale' => rand(90, 110) / 100, // Scale between 0.9 and 1.1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã chia sẻ!',
                'submission' => $submission
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the photo wall.
     */
    public function wall(): View
    {
        // Lấy tất cả submissions (tối đa 500 cho hội nghị lớn)
        $submissions = Submission::orderBy('created_at', 'desc')
            ->take(500)
            ->get();
            
        return view('submissions.wall', compact('submissions'));
    }

    /**
     * Get submissions for AJAX refresh (returns submissions after a given ID)
     */
    public function getSubmissions(Request $request): JsonResponse
    {
        $lastId = (int) $request->input('last_id', 0);
        
        // Chỉ lấy submissions mới (có ID lớn hơn last_id)
        // Nếu last_id = 0, không trả về gì (client đã có data ban đầu từ server render)
        if ($lastId <= 0) {
            return response()->json([
                'success' => true,
                'submissions' => [],
                'last_id' => 0
            ]);
        }
        
        $submissions = Submission::where('id', '>', $lastId)
            ->orderBy('id', 'asc') // Lấy theo thứ tự ID tăng dần để xử lý đúng
            ->take(50) // Giới hạn 50 kết quả mỗi lần
            ->get()
            ->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'name' => $submission->name,
                    'feedback' => $submission->feedback,
                    'image_url' => $submission->image_url,
                    'position_x' => $submission->position_x,
                    'position_y' => $submission->position_y,
                    'rotation' => $submission->rotation,
                    'scale' => $submission->scale,
                    'created_at' => $submission->created_at->format('H:i d/m/Y'),
                ];
            });
        
        // last_id là ID lớn nhất trong kết quả trả về
        $newLastId = $submissions->max('id') ?? $lastId;
        
        return response()->json([
            'success' => true,
            'submissions' => $submissions,
            'last_id' => $newLastId
        ]);
    }

    /**
     * Success page after submission
     */
    public function success(): View
    {
        return view('submissions.success');
    }
}
