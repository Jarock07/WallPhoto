@extends('layouts.app')

@section('title', 'Cảm ơn bạn! | Event Photo Wall')

@section('styles')
<style>
    .success-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: var(--spacing-lg);
        text-align: center;
        box-sizing: border-box;
        width: 100%;
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--spacing-lg) auto;
        animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .success-icon svg {
        width: 50px;
        height: 50px;
        color: white;
    }
    
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .success-title {
        font-family: var(--font-display);
        font-size: clamp(2rem, 6vw, 3rem);
        font-weight: 700;
        margin: 0 auto var(--spacing-sm) auto;
        text-align: center;
        animation: fadeInUp 0.6s ease-out 0.2s both;
    }
    
    .success-message {
        color: var(--text-secondary);
        font-size: 1.1rem;
        max-width: 400px;
        margin: 0 auto var(--spacing-xl) auto;
        text-align: center;
        line-height: 1.6;
        animation: fadeInUp 0.6s ease-out 0.4s both;
    }
    
    @keyframes fadeInUp {
        0% { transform: translateY(20px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    
    .success-actions {
        display: flex;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
        justify-content: center;
        margin: 0 auto;
        animation: fadeInUp 0.6s ease-out 0.6s both;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--radius-md);
        font-family: var(--font-primary);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: var(--gradient-primary);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-glow);
    }
    
    .btn-outline {
        background: transparent;
        color: var(--text-primary);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .btn-outline:hover {
        border-color: var(--accent-primary);
        background: rgba(139, 92, 246, 0.1);
    }
    
    /* Confetti animation */
    .confetti {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 100;
    }
    
    .confetti-piece {
        position: absolute;
        width: 10px;
        height: 20px;
        opacity: 0;
        animation: confettiFall 3s ease-out forwards;
    }
    
    @keyframes confettiFall {
        0% {
            opacity: 1;
            top: -5%;
            transform: translateX(0) rotateZ(0deg);
        }
        100% {
            opacity: 0;
            top: 100%;
            transform: translateX(100px) rotateZ(720deg);
        }
    }
</style>
@endsection

@section('content')
<div class="confetti" id="confetti"></div>

<div class="success-container">
    <div class="success-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    
    <h1 class="success-title text-gradient">Cảm ơn bạn!</h1>
    
    <p class="success-message">
        Chia sẻ của bạn đã được ghi nhận và sẽ hiển thị trên Photo Wall của chúng tôi. 
        Hãy cùng xem ngay nhé! 🎉
    </p>
    
    <div class="success-actions">
        <a href="{{ route('submissions.wall') }}" class="btn btn-primary" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Xem Photo Wall
        </a>
        
        <a href="{{ route('submissions.create') }}" class="btn btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Thêm chia sẻ mới
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const confettiContainer = document.getElementById('confetti');
    const colors = ['#8b5cf6', '#06b6d4', '#ec4899', '#f97316', '#22c55e', '#eab308'];
    
    // Create confetti pieces
    for (let i = 0; i < 50; i++) {
        const piece = document.createElement('div');
        piece.classList.add('confetti-piece');
        piece.style.left = Math.random() * 100 + '%';
        piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        piece.style.animationDelay = Math.random() * 2 + 's';
        piece.style.animationDuration = (Math.random() * 2 + 2) + 's';
        confettiContainer.appendChild(piece);
    }
    
    // Remove confetti after animation
    setTimeout(() => {
        confettiContainer.remove();
    }, 5000);
});
</script>
@endsection
