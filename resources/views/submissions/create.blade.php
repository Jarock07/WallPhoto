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
    
    /* ===== PHOTO SECTION ===== */
    .photo-section {
        margin-bottom: var(--spacing-md);
    }
    
    .photo-section > label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: var(--spacing-md);
    }
    
    .photo-section > label svg {
        width: 18px;
        height: 18px;
        opacity: 0.7;
    }
    
    /* Photo Frame with Gradient Border */
    .photo-frame {
        position: relative;
        padding: 4px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-pink), var(--accent-secondary));
        margin-bottom: var(--spacing-md);
        box-shadow: 
            0 0 30px rgba(139, 92, 246, 0.3),
            0 0 60px rgba(236, 72, 153, 0.2);
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
    
    .photo-frame.has-image {
        background: linear-gradient(135deg, #22c55e, #10b981, #06b6d4);
        animation: none;
        box-shadow: 0 0 40px rgba(34, 197, 94, 0.4);
    }
    
    .photo-preview-container {
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
    
    /* Preview Image */
    .preview-polaroid {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-2deg);
        width: 85%;
        padding: 12px 12px 45px 12px;
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
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        font-family: 'Be Vietnam Pro', sans-serif;
        font-size: 13px;
        color: #555;
        white-space: nowrap;
    }
    
    /* Photo Placeholder */
    .photo-placeholder {
        text-align: center;
        padding: var(--spacing-xl);
        color: var(--text-muted);
    }
    
    .photo-placeholder .icon-container {
        width: 90px;
        height: 90px;
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
    
    .photo-placeholder svg {
        width: 44px;
        height: 44px;
        opacity: 0.7;
        color: var(--accent-primary);
    }
    
    .photo-placeholder p {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }
    
    /* Photo Buttons */
    .photo-buttons {
        display: flex;
        gap: 12px;
    }
    
    .btn-photo {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 20px 16px;
        border-radius: 16px;
        font-family: var(--font-primary);
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-photo svg {
        width: 32px;
        height: 32px;
    }
    
    /* Camera Button - Primary */
    .btn-camera {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        color: white;
        box-shadow: 0 4px 20px rgba(236, 72, 153, 0.3);
    }
    
    .btn-camera:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(236, 72, 153, 0.4);
    }
    
    .btn-camera:active {
        transform: translateY(-1px);
    }
    
    /* Gallery Button - Secondary */
    .btn-library {
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.15);
        color: var(--text-primary);
        backdrop-filter: blur(10px);
    }
    
    .btn-library:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-3px);
    }
    
    /* Retake Button */
    .btn-retake {
        display: none;
        width: 100%;
        padding: 14px 20px;
        margin-top: 12px;
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        color: var(--text-primary);
        font-family: var(--font-primary);
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-retake.visible {
        display: flex;
    }
    
    .btn-retake svg {
        width: 20px;
        height: 20px;
    }
    
    .btn-retake:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }
    
    /* Hidden file inputs */
    .hidden-input {
        display: none;
    }
    
    /* Processing Overlay */
    .processing-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.85);
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
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* ===== END PHOTO SECTION ===== */
    
    .btn-submit {
        width: 100%;
        padding: var(--spacing-md);
        background: var(--gradient-primary);
        color: white;
        font-family: var(--font-primary);
        font-size: 1.1rem;
        font-weight: 600;
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
        margin-top: var(--spacing-sm);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
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
    
    /* Responsive */
    @media (max-width: 480px) {
        .form-card {
            padding: var(--spacing-md);
        }
        
        .photo-buttons {
            gap: 10px;
        }
        
        .btn-photo {
            padding: 16px 12px;
        }
        
        .btn-photo svg {
            width: 28px;
            height: 28px;
        }
        
        .preview-polaroid {
            width: 88%;
            padding: 10px 10px 38px 10px;
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
            
            <div class="form-group photo-section">
                <label>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ảnh của bạn
                </label>
                
                <!-- Photo Frame -->
                <div class="photo-frame" id="photo-frame">
                    <div class="photo-preview-container" id="photo-container">
                        <!-- Polaroid Style Preview -->
                        <div class="preview-polaroid" id="preview-polaroid">
                            <img id="photo-preview" alt="Preview">
                        </div>
                        
                        <div class="photo-placeholder" id="photo-placeholder">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p>Chụp ảnh hoặc chọn từ thư viện</p>
                        </div>
                        
                        <div class="processing-overlay" id="processing-overlay">
                            <div class="processing-spinner"></div>
                            <span>Đang xử lý ảnh...</span>
                        </div>
                    </div>
                </div>
                
                <!-- Photo Buttons -->
                <div class="photo-buttons">
                    <label for="camera-input" class="btn-photo btn-camera">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Chụp ảnh
                    </label>
                    
                    <label for="gallery-input" class="btn-photo btn-library">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Thư viện
                    </label>
                </div>
                
                <!-- Retake Button -->
                <button type="button" id="btn-retake" class="btn-retake">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Chọn ảnh khác
                </button>
                
                <!-- Hidden File Inputs -->
                <!-- capture="environment" = camera sau, capture="user" = camera trước -->
                <input type="file" id="camera-input" class="hidden-input" accept="image/*" capture="user">
                <input type="file" id="gallery-input" class="hidden-input" accept="image/*">
            </div>
            
            <input type="hidden" id="image-data" name="image">
            
            <button type="submit" id="btn-submit" class="btn-submit" disabled>
                <span class="btn-text">Gửi chia sẻ</span>
                <span class="loader"></span>
            </button>
        </form>
        
        <div class="wall-link">
            <a href="{{ route('submissions.wall') }}" target="_blank">📸 Xem Photo Wall →</a>
        </div>
    </div>
</div>

<!-- Hidden canvas for processing image -->
<canvas id="process-canvas" style="display: none;"></canvas>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoFrame = document.getElementById('photo-frame');
    const photoPlaceholder = document.getElementById('photo-placeholder');
    const previewPolaroid = document.getElementById('preview-polaroid');
    const photoPreview = document.getElementById('photo-preview');
    const processingOverlay = document.getElementById('processing-overlay');
    const canvas = document.getElementById('process-canvas');
    
    const cameraInput = document.getElementById('camera-input');
    const galleryInput = document.getElementById('gallery-input');
    const btnRetake = document.getElementById('btn-retake');
    const btnSubmit = document.getElementById('btn-submit');
    const imageDataInput = document.getElementById('image-data');
    const form = document.getElementById('submission-form');
    const alertContainer = document.getElementById('alert-container');
    
    let hasPhoto = false;
    
    // Handle camera input
    cameraInput.addEventListener('change', handleImageSelect);
    
    // Handle gallery input
    galleryInput.addEventListener('change', handleImageSelect);
    
    // Handle retake
    btnRetake.addEventListener('click', resetPhoto);
    
    function handleImageSelect(e) {
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
                
                // Compress image
                let quality = 0.75;
                let imageData = canvas.toDataURL('image/jpeg', quality);
                
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
                
                // Save image data
                imageDataInput.value = imageData;
                
                // Show preview
                photoPreview.src = imageData;
                previewPolaroid.classList.add('visible');
                photoPlaceholder.style.display = 'none';
                photoFrame.classList.add('has-image');
                
                // Show retake button
                btnRetake.classList.add('visible');
                
                hasPhoto = true;
                updateSubmitButton();
                
                processingOverlay.classList.remove('active');
                showAlert('Đã tải ảnh thành công! 📸', 'success');
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
        
        // Reset input so same file can be selected again
        e.target.value = '';
    }
    
    function resetPhoto() {
        hasPhoto = false;
        imageDataInput.value = '';
        
        previewPolaroid.classList.remove('visible');
        photoPlaceholder.style.display = 'flex';
        photoFrame.classList.remove('has-image');
        btnRetake.classList.remove('visible');
        
        updateSubmitButton();
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
            showAlert('Vui lòng chụp hoặc chọn ảnh trước khi gửi', 'error');
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
});
</script>
@endsection
