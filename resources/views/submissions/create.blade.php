@extends('layouts.app')

@section('title', 'Chia sẻ khoảnh khắc | Event Photo Wall')

@section('styles')
<style>
    .form-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: var(--spacing-lg) var(--spacing-md);
        box-sizing: border-box;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: var(--spacing-xl);
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        max-width: 500px;
        display: block;
    }
    
    .form-header h1 {
        font-family: var(--font-display);
        font-size: clamp(2rem, 5vw, 3.5rem);
        margin-bottom: var(--spacing-sm);
    }
    
    .form-header p {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }
    
    .form-card {
        width: 100%;
        max-width: 500px;
        padding: var(--spacing-xl);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        margin: 0 auto;
        box-sizing: border-box;
    }
    
    .form-group {
        margin-bottom: var(--spacing-md);
    }
    
    .form-group label {
        display: block;
        margin-bottom: var(--spacing-xs);
        font-weight: 500;
        color: var(--text-secondary);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md);
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        font-family: var(--font-primary);
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--accent-primary);
        background: rgba(139, 92, 246, 0.05);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.2);
    }
    
    .form-control::placeholder {
        color: var(--text-muted);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    /* ===== PREMIUM CAMERA SECTION ===== */
    .camera-section {
        margin-bottom: var(--spacing-md);
    }
    
    .camera-section > label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: var(--spacing-sm);
    }
    
    .camera-section > label svg {
        width: 18px;
        height: 18px;
        opacity: 0.7;
    }
    
    /* Camera Frame with Gradient Border */
    .camera-frame {
        position: relative;
        padding: 4px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-pink), var(--accent-secondary));
        margin-bottom: var(--spacing-md);
        box-shadow: 
            0 0 30px rgba(139, 92, 246, 0.3),
            0 0 60px rgba(236, 72, 153, 0.2),
            inset 0 0 20px rgba(255, 255, 255, 0.1);
        animation: borderGlow 3s ease-in-out infinite;
    }
    
    @keyframes borderGlow {
        0%, 100% { 
            box-shadow: 
                0 0 30px rgba(139, 92, 246, 0.3),
                0 0 60px rgba(236, 72, 153, 0.2);
        }
        50% { 
            box-shadow: 
                0 0 40px rgba(139, 92, 246, 0.5),
                0 0 80px rgba(236, 72, 153, 0.3);
        }
    }
    
    .camera-frame.has-image {
        background: linear-gradient(135deg, #22c55e, #10b981, #06b6d4);
        animation: none;
        box-shadow: 0 0 40px rgba(34, 197, 94, 0.4);
    }
    
    .camera-preview-container {
        position: relative;
        width: 100%;
        aspect-ratio: 1/1;
        border-radius: 16px;
        overflow: hidden;
        background: linear-gradient(145deg, #1a1a2e, #0f0f1a);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    #camera-video, #camera-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    
    #camera-preview.visible, #camera-video.visible {
        display: block;
    }
    
    /* Polaroid Preview Style */
    .preview-polaroid {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-2deg);
        width: 85%;
        padding: 12px 12px 40px 12px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(0, 0, 0, 0.1);
        display: none;
        animation: polaroidDrop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .preview-polaroid.visible {
        display: block;
    }
    
    @keyframes polaroidDrop {
        0% {
            opacity: 0;
            transform: translate(-50%, -100%) rotate(-5deg) scale(0.8);
        }
        100% {
            opacity: 1;
            transform: translate(-50%, -50%) rotate(-2deg) scale(1);
        }
    }
    
    .preview-polaroid img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        border-radius: 2px;
    }
    
    .preview-polaroid::after {
        content: '📸 Ảnh của bạn';
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Be Vietnam Pro', sans-serif;
        font-size: 12px;
        color: #666;
        white-space: nowrap;
    }
    
    /* Camera Placeholder */
    .camera-placeholder {
        text-align: center;
        padding: var(--spacing-xl);
        color: var(--text-muted);
    }
    
    .camera-placeholder .icon-container {
        width: 80px;
        height: 80px;
        margin: 0 auto var(--spacing-md);
        border-radius: 50%;
        background: rgba(139, 92, 246, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed rgba(139, 92, 246, 0.3);
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.05); opacity: 1; }
    }
    
    .camera-placeholder svg {
        width: 40px;
        height: 40px;
        opacity: 0.7;
        color: var(--accent-primary);
    }
    
    .camera-placeholder p {
        font-size: 0.95rem;
        color: var(--text-secondary);
    }
    
    /* Flash Effect */
    .flash-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        opacity: 0;
        pointer-events: none;
        border-radius: 16px;
        z-index: 10;
    }
    
    .flash-overlay.flash {
        animation: flashEffect 0.3s ease-out;
    }
    
    @keyframes flashEffect {
        0% { opacity: 0.9; }
        100% { opacity: 0; }
    }
    
    /* Camera Controls */
    .camera-controls {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }
    
    .camera-main-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-lg);
        padding: var(--spacing-sm) 0;
    }
    
    /* Circular Capture Button */
    .btn-capture-main {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(145deg, #ff6b6b, #ee5a5a);
        border: 4px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 
            0 4px 20px rgba(238, 90, 90, 0.4),
            inset 0 2px 4px rgba(255, 255, 255, 0.2);
    }
    
    .btn-capture-main::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: 3px solid rgba(255, 255, 255, 0.6);
        transition: all 0.2s ease;
    }
    
    .btn-capture-main:hover:not(:disabled) {
        transform: scale(1.1);
        box-shadow: 
            0 6px 30px rgba(238, 90, 90, 0.6),
            inset 0 2px 4px rgba(255, 255, 255, 0.2);
    }
    
    .btn-capture-main:hover:not(:disabled)::before {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .btn-capture-main:active:not(:disabled) {
        transform: scale(0.95);
    }
    
    .btn-capture-main:disabled {
        opacity: 0.3;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-capture-main.ready {
        animation: captureReady 1.5s ease-in-out infinite;
    }
    
    @keyframes captureReady {
        0%, 100% { box-shadow: 0 4px 20px rgba(238, 90, 90, 0.4); }
        50% { box-shadow: 0 4px 40px rgba(238, 90, 90, 0.8), 0 0 60px rgba(238, 90, 90, 0.4); }
    }
    
    /* Side Control Buttons */
    .btn-control {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.15);
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .btn-control svg {
        width: 22px;
        height: 22px;
    }
    
    .btn-control:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .btn-control.active {
        background: var(--gradient-primary);
        border-color: transparent;
    }
    
    /* Gallery Button */
    .btn-gallery {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 14px 20px;
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        color: var(--text-primary);
        font-family: var(--font-primary);
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .btn-gallery svg {
        width: 20px;
        height: 20px;
        opacity: 0.8;
    }
    
    .btn-gallery:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .camera-hint {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-top: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    
    /* ===== END CAMERA SECTION ===== */
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: var(--spacing-sm) var(--spacing-md);
        border: none;
        border-radius: var(--radius-md);
        font-family: var(--font-primary);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-secondary {
        flex: 1;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    
    .btn-submit {
        width: 100%;
        padding: var(--spacing-md);
        background: var(--gradient-primary);
        color: white;
        font-size: 1.1rem;
        margin-top: var(--spacing-sm);
    }
    
    .btn-submit:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: var(--shadow-glow);
    }
    
    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-submit .loader {
        display: none;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    .btn-submit.loading .btn-text {
        display: none;
    }
    
    .btn-submit.loading .loader {
        display: block;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Error/Success Messages */
    .alert {
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--radius-sm);
        margin-bottom: var(--spacing-md);
        font-weight: 500;
    }
    
    .alert-error {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.5);
        color: #fca5a5;
    }
    
    .alert-success {
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid rgba(34, 197, 94, 0.5);
        color: #86efac;
    }
    
    /* Link to wall */
    .wall-link {
        margin-top: var(--spacing-lg);
        text-align: center;
    }
    
    .wall-link a {
        color: var(--accent-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .wall-link a:hover {
        color: var(--accent-primary);
    }
    
    /* Loading overlay */
    .processing-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 12px;
        color: white;
        border-radius: 16px;
        z-index: 15;
    }
    
    .processing-overlay.active {
        display: flex;
    }
    
    .processing-spinner {
        width: 44px;
        height: 44px;
        border: 4px solid rgba(255, 255, 255, 0.2);
        border-top-color: var(--accent-primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    .processing-overlay span {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    /* Responsive */
    @media (max-width: 480px) {
        .form-card {
            padding: var(--spacing-md);
        }
        
        .btn-capture-main {
            width: 64px;
            height: 64px;
        }
        
        .btn-capture-main::before {
            width: 44px;
            height: 44px;
        }
        
        .btn-control {
            width: 44px;
            height: 44px;
        }
        
        .preview-polaroid {
            width: 90%;
            padding: 8px 8px 32px 8px;
        }
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1 class="text-gradient">Chia sẻ khoảnh khắc</h1>
        <p>Hãy để lại ấn tượng của bạn về sự kiện hôm nay</p>
    </div>
    
    <div class="form-card glass-effect">
        <div id="alert-container"></div>
        
        <form id="submission-form">
            <div class="form-group">
                <label for="name">Tên của bạn</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    placeholder="Nhập tên của bạn..."
                    required
                    maxlength="255"
                >
            </div>
            
            <div class="form-group">
                <label for="feedback">Cảm nhận của bạn</label>
                <textarea 
                    id="feedback" 
                    name="feedback" 
                    class="form-control" 
                    placeholder="Chia sẻ cảm nhận của bạn về sự kiện..."
                    required
                    maxlength="1000"
                ></textarea>
            </div>
            
            <div class="form-group camera-section">
                <label>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Chụp ảnh của bạn
                </label>
                
                <!-- Camera Frame with Gradient Border -->
                <div class="camera-frame" id="camera-frame">
                    <div class="camera-preview-container" id="camera-container">
                        <video id="camera-video" autoplay playsinline muted webkit-playsinline></video>
                        
                        <!-- Polaroid Style Preview -->
                        <div class="preview-polaroid" id="preview-polaroid">
                            <img id="camera-preview" alt="Preview">
                        </div>
                        
                        <div class="camera-placeholder" id="camera-placeholder">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p>Nhấn nút chụp hoặc chọn ảnh từ thư viện</p>
                        </div>
                        
                        <!-- Flash Effect -->
                        <div class="flash-overlay" id="flash-overlay"></div>
                        
                        <div class="processing-overlay" id="processing-overlay">
                            <div class="processing-spinner"></div>
                            <span>Đang xử lý ảnh...</span>
                        </div>
                    </div>
                </div>
                
                <!-- Camera Controls -->
                <div class="camera-controls">
                    <div class="camera-main-controls">
                        <!-- Switch Camera / Reset Button -->
                        <button type="button" id="btn-open-camera" class="btn-control" title="Mở camera">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                        
                        <!-- Main Capture Button -->
                        <button type="button" id="btn-capture" class="btn-capture-main" disabled title="Chụp ảnh">
                        </button>
                        
                        <!-- Retake Button -->
                        <button type="button" id="btn-retake" class="btn-control" title="Chụp lại" style="opacity: 0.3; pointer-events: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Gallery / File Upload Button -->
                    <label for="file-input" class="btn-gallery">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Chọn ảnh từ thư viện
                    </label>
                    <input type="file" id="file-input" accept="image/*" capture="user" style="display: none;">
                    
                    <p class="camera-hint">
                        💡 Trên iPhone/iPad, hãy dùng nút "Chọn ảnh từ thư viện" để chụp
                    </p>
                </div>
            </div>
            
            <input type="hidden" id="image-data" name="image">
            
            <button type="submit" id="btn-submit" class="btn btn-submit" disabled>
                <span class="btn-text">Gửi chia sẻ</span>
                <span class="loader"></span>
            </button>
        </form>
        
        <div class="wall-link">
            <a href="{{ route('submissions.wall') }}" target="_blank">📸 Xem Photo Wall →</a>
        </div>
    </div>
</div>

<!-- Hidden canvas for capturing image -->
<canvas id="capture-canvas" style="display: none;"></canvas>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('camera-video');
    const preview = document.getElementById('camera-preview');
    const previewPolaroid = document.getElementById('preview-polaroid');
    const placeholder = document.getElementById('camera-placeholder');
    const container = document.getElementById('camera-container');
    const cameraFrame = document.getElementById('camera-frame');
    const flashOverlay = document.getElementById('flash-overlay');
    const canvas = document.getElementById('capture-canvas');
    const btnOpenCamera = document.getElementById('btn-open-camera');
    const btnCapture = document.getElementById('btn-capture');
    const btnRetake = document.getElementById('btn-retake');
    const btnSubmit = document.getElementById('btn-submit');
    const imageDataInput = document.getElementById('image-data');
    const form = document.getElementById('submission-form');
    const alertContainer = document.getElementById('alert-container');
    const fileInput = document.getElementById('file-input');
    const processingOverlay = document.getElementById('processing-overlay');
    
    let stream = null;
    let hasPhoto = false;
    let cameraActive = false;
    
    // Detect iOS
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    
    // Check if camera API is available
    const hasCameraAPI = !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    
    // On iOS without HTTPS, hide camera controls
    if (isIOS && window.location.protocol !== 'https:' && window.location.hostname !== 'localhost') {
        btnOpenCamera.style.display = 'none';
        btnCapture.style.display = 'none';
    }
    
    // Open camera (for desktop and Android)
    btnOpenCamera.addEventListener('click', async function() {
        // If camera is active and photo taken, this is retake
        if (hasPhoto) {
            resetCamera();
            return;
        }
        
        try {
            // Stop any existing stream
            stopCamera();
            
            // Request camera access with iOS-friendly constraints
            const constraints = {
                video: { 
                    facingMode: 'user',
                    width: { ideal: 1080, max: 1920 },
                    height: { ideal: 1080, max: 1920 }
                },
                audio: false
            };
            
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            
            video.srcObject = stream;
            
            // For iOS Safari - need to call play() explicitly
            try {
                await video.play();
            } catch (playError) {
                console.log('Auto-play prevented, user interaction needed');
            }
            
            video.classList.add('visible');
            previewPolaroid.classList.remove('visible');
            placeholder.style.display = 'none';
            
            // Enable capture button with animation
            btnCapture.disabled = false;
            btnCapture.classList.add('ready');
            
            // Mark camera button as active
            btnOpenCamera.classList.add('active');
            
            cameraActive = true;
            hasPhoto = false;
            cameraFrame.classList.remove('has-image');
            updateSubmitButton();
            
        } catch (error) {
            console.error('Camera error:', error);
            let errorMessage = 'Không thể truy cập camera. ';
            
            if (error.name === 'NotAllowedError') {
                errorMessage += 'Vui lòng cho phép quyền truy cập camera trong cài đặt trình duyệt.';
            } else if (error.name === 'NotFoundError') {
                errorMessage += 'Không tìm thấy camera trên thiết bị này.';
            } else if (error.name === 'NotSupportedError' || error.name === 'SecurityError') {
                errorMessage += 'Camera chỉ hoạt động trên HTTPS. Hãy dùng nút "Chọn ảnh từ thư viện".';
            } else {
                errorMessage += 'Hãy thử dùng nút "Chọn ảnh từ thư viện".';
            }
            
            showAlert(errorMessage, 'error');
        }
    });
    
    // Capture photo from video stream
    btnCapture.addEventListener('click', function() {
        if (!stream) return;
        
        // Wait for video to be ready
        if (video.videoWidth === 0 || video.videoHeight === 0) {
            showAlert('Vui lòng đợi camera sẵn sàng...', 'error');
            return;
        }
        
        // Trigger flash effect
        flashOverlay.classList.add('flash');
        setTimeout(() => flashOverlay.classList.remove('flash'), 300);
        
        // Set canvas size (square crop from center)
        const videoWidth = video.videoWidth;
        const videoHeight = video.videoHeight;
        const size = Math.min(videoWidth, videoHeight);
        const maxSize = 1200;
        const outputSize = Math.min(size, maxSize);
        
        canvas.width = outputSize;
        canvas.height = outputSize;
        
        // Calculate crop offset for center
        const offsetX = (videoWidth - size) / 2;
        const offsetY = (videoHeight - size) / 2;
        
        // Draw video frame to canvas (center crop)
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, offsetX, offsetY, size, size, 0, 0, outputSize, outputSize);
        
        // Get image data - optimized compression
        let quality = 0.75;
        let imageData = canvas.toDataURL('image/jpeg', quality);
        
        // Check size and compress more if needed
        while (imageData.length > 2 * 1024 * 1024 * 1.37 && quality > 0.3) {
            quality -= 0.1;
            imageData = canvas.toDataURL('image/jpeg', quality);
        }

        imageDataInput.value = imageData;
        
        // Show polaroid preview
        preview.src = imageData;
        previewPolaroid.classList.add('visible');
        video.classList.remove('visible');
        
        // Stop camera stream
        stopCamera();
        
        hasPhoto = true;
        cameraActive = false;
        cameraFrame.classList.add('has-image');
        btnCapture.disabled = true;
        btnCapture.classList.remove('ready');
        btnOpenCamera.classList.remove('active');
        
        // Enable retake button
        btnRetake.style.opacity = '1';
        btnRetake.style.pointerEvents = 'auto';
        
        updateSubmitButton();
        showAlert('Đã chụp ảnh thành công! 📸', 'success');
    });
    
    // Retake button
    btnRetake.addEventListener('click', function() {
        resetCamera();
    });
    
    function resetCamera() {
        // Reset everything
        hasPhoto = false;
        cameraActive = false;
        stopCamera();
        
        video.classList.remove('visible');
        previewPolaroid.classList.remove('visible');
        placeholder.style.display = 'flex';
        cameraFrame.classList.remove('has-image');
        btnCapture.disabled = true;
        btnCapture.classList.remove('ready');
        btnOpenCamera.classList.remove('active');
        btnRetake.style.opacity = '0.3';
        btnRetake.style.pointerEvents = 'none';
        imageDataInput.value = '';
        
        updateSubmitButton();
    }
    
    // Handle file input (for iOS and fallback)
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showAlert('Vui lòng chọn file ảnh', 'error');
            return;
        }
        
        // Validate file size (max 15MB)
        if (file.size > 15 * 1024 * 1024) {
            showAlert('Ảnh quá lớn. Vui lòng chọn ảnh nhỏ hơn 15MB', 'error');
            return;
        }
        
        processingOverlay.classList.add('active');
        
        const reader = new FileReader();
        
        reader.onload = function(event) {
            // Create image to resize if needed
            const img = new Image();
            img.onload = function() {
                // Make square crop from center
                const size = Math.min(img.width, img.height);
                const maxSize = 1200;
                const outputSize = Math.min(size, maxSize);
                
                // Calculate crop offset for center
                const offsetX = (img.width - size) / 2;
                const offsetY = (img.height - size) / 2;
                
                // Draw to canvas and get compressed image
                canvas.width = outputSize;
                canvas.height = outputSize;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, offsetX, offsetY, size, size, 0, 0, outputSize, outputSize);
                
                // Initial compression
                let quality = 0.75;
                let imageData = canvas.toDataURL('image/jpeg', quality);
                
                // Check size (base64 string length * 0.75 approx bytes)
                // If > 2MB, compress more
                while (imageData.length > 2 * 1024 * 1024 * 1.37 && quality > 0.3) {
                    quality -= 0.1;
                    imageData = canvas.toDataURL('image/jpeg', quality);
                }
                
                if (imageData.length > 3 * 1024 * 1024 * 1.37) {
                     processingOverlay.classList.remove('active');
                     showAlert('Ảnh vẫn quá lớn sau khi nén. Vui lòng chọn ảnh khác.', 'error');
                     return;
                }

                imageDataInput.value = imageData;
                
                // Show polaroid preview
                preview.src = imageData;
                previewPolaroid.classList.add('visible');
                video.classList.remove('visible');
                placeholder.style.display = 'none';
                
                // Stop any camera stream
                stopCamera();
                
                hasPhoto = true;
                cameraActive = false;
                cameraFrame.classList.add('has-image');
                btnCapture.disabled = true;
                btnCapture.classList.remove('ready');
                btnOpenCamera.classList.remove('active');
                
                // Enable retake button
                btnRetake.style.opacity = '1';
                btnRetake.style.pointerEvents = 'auto';
                
                updateSubmitButton();
                
                processingOverlay.classList.remove('active');
                showAlert('Đã tải và xử lý ảnh thành công! 📸', 'success');
            };
            
            img.onerror = function() {
                processingOverlay.classList.remove('active');
                showAlert('Không thể đọc file ảnh. Vui lòng thử ảnh khác.', 'error');
            };
            
            img.src = event.target.result;
        };
        
        reader.onerror = function() {
            processingOverlay.classList.remove('active');
            showAlert('Không thể đọc file. Vui lòng thử lại.', 'error');
        };
        
        reader.readAsDataURL(file);
        
        // Reset file input so same file can be selected again
        fileInput.value = '';
    });
    
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        video.srcObject = null;
        cameraActive = false;
    }
    
    function updateSubmitButton() {
        const name = document.getElementById('name').value.trim();
        const feedback = document.getElementById('feedback').value.trim();
        btnSubmit.disabled = !(name && feedback && hasPhoto);
    }
    
    // Update submit button state when inputs change
    document.getElementById('name').addEventListener('input', updateSubmitButton);
    document.getElementById('feedback').addEventListener('input', updateSubmitButton);
    
    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!hasPhoto) {
            showAlert('Vui lòng chụp ảnh trước khi gửi', 'error');
            return;
        }
        
        btnSubmit.classList.add('loading');
        btnSubmit.disabled = true;
        
        const formData = {
            name: document.getElementById('name').value.trim(),
            feedback: document.getElementById('feedback').value.trim(),
            image: imageDataInput.value
        };
        
        try {
            const response = await fetch('{{ route("submissions.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Redirect to success page
                window.location.href = '{{ route("submissions.success") }}';
            } else {
                showAlert(result.message || 'Có lỗi xảy ra, vui lòng thử lại', 'error');
                btnSubmit.classList.remove('loading');
                updateSubmitButton();
            }
        } catch (error) {
            console.error('Submit error:', error);
            showAlert('Có lỗi xảy ra, vui lòng thử lại', 'error');
            btnSubmit.classList.remove('loading');
            updateSubmitButton();
        }
    });
    
    function showAlert(message, type) {
        alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        
        if (type === 'success') {
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }
    }
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', stopCamera);
});
</script>
@endsection
