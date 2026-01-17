@extends('layouts.app')

@section('title', 'Photo Wall | Event Gallery')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    html, body {
        height: 100%;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }
    
    /* ===== BACKGROUND ===== */
    .photo-wall {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        background: 
            radial-gradient(ellipse at 20% 0%, rgba(120, 119, 198, 0.15) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 100%, rgba(168, 85, 247, 0.12) 0%, transparent 50%),
            radial-gradient(ellipse at 0% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 40%),
            radial-gradient(ellipse at 100% 50%, rgba(139, 92, 246, 0.1) 0%, transparent 40%),
            linear-gradient(180deg, #0a0a0f 0%, #13131a 50%, #0d0d12 100%);
    }
    
    /* ===== ANIMATED BACKGROUND ORBS ===== */
    .bg-orbs {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }
    
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.4;
        animation: orbFloat 20s ease-in-out infinite;
    }
    
    .orb-1 {
        width: 500px;
        height: 500px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        top: -10%;
        left: -10%;
    }
    
    .orb-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        bottom: -15%;
        right: -10%;
        animation-delay: -7s;
    }
    
    .orb-3 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #06b6d4 0%, #6366f1 100%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation-delay: -14s;
    }
    
    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(30px, -30px) scale(1.05); }
        50% { transform: translate(-20px, 20px) scale(0.95); }
        75% { transform: translate(20px, 30px) scale(1.02); }
    }
    
    /* ===== PARTICLES ===== */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 1;
    }
    
    .particle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
    
    .particle-star {
        width: 3px;
        height: 3px;
        background: white;
        box-shadow: 0 0 6px 2px rgba(255, 255, 255, 0.3);
        animation: twinkle 4s ease-in-out infinite;
    }
    
    .particle-glow {
        width: 4px;
        height: 4px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.8) 0%, transparent 70%);
        animation: floatUp 15s linear infinite;
    }
    
    @keyframes twinkle {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.5); }
    }
    
    @keyframes floatUp {
        0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
        10% { opacity: 0.8; }
        90% { opacity: 0.8; }
        100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
    }
    
    /* ===== HEADER ===== */
    .event-header {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 15px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 70%, transparent 100%);
    }
    
    .header-logo {
        height: 90px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.5));
        transition: transform 0.3s ease;
    }
    
    .header-logo:hover {
        transform: scale(1.05);
    }
    
    .header-title-wrapper {
        text-align: right;
        position: relative;
    }
    
    .header-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
        line-height: 1.4;
        background: linear-gradient(
            135deg,
            #462523 0%,
            #cb9b51 22%, 
            #f6e27a 45%,
            #f6f2c0 50%,
            #f6e27a 55%,
            #cb9b51 78%,
            #462523 100%
        );
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: goldShimmer 4s ease infinite;
    }
    
    @keyframes goldShimmer {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .header-title-wrapper::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -8px;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #cb9b51 30%, #f6e27a 50%, #cb9b51 70%, transparent 100%);
        opacity: 0.6;
    }
    
    .header-title-wrapper::after {
        content: '✦';
        position: absolute;
        right: -25px;
        top: 50%;
        transform: translateY(-50%);
        color: #cb9b51;
        font-size: 0.8rem;
        opacity: 0.8;
        animation: starPulse 2s ease-in-out infinite;
    }
    
    @keyframes starPulse {
        0%, 100% { opacity: 0.5; transform: translateY(-50%) scale(1); }
        50% { opacity: 1; transform: translateY(-50%) scale(1.2); }
    }
    
    /* ===== PHOTO GRID CONTAINER ===== */
    .photo-grid {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
    }
    
    /* ===== POLAROID CARD ===== */
    .polaroid {
        position: absolute;
        width: 180px; /* Slightly larger for better visibility */
        background: linear-gradient(165deg, #ffffff 0%, #f8f8f8 100%);
        padding: 6px;
        padding-bottom: 28px;
        border-radius: 3px;
        box-shadow: 
            0 15px 35px rgba(0, 0, 0, 0.4),
            0 5px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: 
            opacity 1s cubic-bezier(0.4, 0, 0.2, 1),
            transform 1s cubic-bezier(0.4, 0, 0.2, 1);
        transform-style: preserve-3d;
        opacity: 0; /* Hidden by default */
        pointer-events: none; /* Non-interactive when hidden */
        overflow: hidden;
        z-index: 10;
    }

    .polaroid.active {
        opacity: 1;
        pointer-events: auto;
        z-index: 1000 !important;
        transform: scale(1.2) rotate(var(--rotation, 0deg)) translateY(0) !important;
    }
    
    /* Remove old animations that might conflict */

    
    .polaroid:hover {
        z-index: 99999 !important;
        transform: scale(1.25) rotate(0deg) translateY(-15px) !important;
        box-shadow: 
            0 30px 60px rgba(139, 92, 246, 0.4),
            0 20px 40px rgba(0, 0, 0, 0.5);
        animation-play-state: paused !important;
    }
    
    .polaroid.new-arrival {
        animation: polaroidNewArrival 1.2s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    }
    
    @keyframes polaroidNewArrival {
        0% {
            opacity: 0;
            transform: scale(0) rotate(var(--rotation, 0deg));
            box-shadow: 0 0 0 rgba(168, 85, 247, 0);
        }
        40% {
            opacity: 1;
            transform: scale(1.15) rotate(var(--rotation, 0deg));
            box-shadow: 0 0 60px rgba(168, 85, 247, 0.8), 0 0 100px rgba(139, 92, 246, 0.5);
        }
        70% {
            transform: scale(0.95) rotate(var(--rotation, 0deg));
        }
        100% {
            opacity: 1;
            transform: scale(1) rotate(var(--rotation, 0deg));
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
        }
    }
    
    .polaroid.new-arrival::after {
        content: '✨ NEW';
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, #f97316 0%, #ec4899 100%);
        color: white;
        font-size: 0.5rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        z-index: 10;
        animation: badgePulse 2s ease-in-out infinite;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.5);
    }
    
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    /* ===== TWINKLE CARD (star-like flash) ===== */
    .polaroid.twinkle {
        animation: twinkleFlash 0.8s ease-in-out !important;
    }
    
    @keyframes twinkleFlash {
        0% {
            transform: scale(1) rotate(var(--rotation, 0deg));
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
            filter: brightness(1);
        }
        50% {
            transform: scale(1.08) rotate(var(--rotation, 0deg)) translateY(-5px);
            box-shadow: 
                0 20px 40px rgba(139, 92, 246, 0.5),
                0 0 30px rgba(255, 255, 255, 0.4),
                0 0 60px rgba(168, 85, 247, 0.3);
            filter: brightness(1.3);
        }
        100% {
            transform: scale(1) rotate(var(--rotation, 0deg));
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
            filter: brightness(1);
        }
    }
    
    /* ===== SPOTLIGHT MODE FOR NEW SUBMISSIONS ===== */
    .modal-overlay.spotlight-mode {
        pointer-events: none; /* Can't close by clicking */
    }
    
    .modal-overlay.spotlight-mode .modal-close {
        display: none; /* Hide close button */
    }
    
    .modal-overlay.spotlight-mode .modal-polaroid {
        animation: spotlightEnter 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    }
    
    @keyframes spotlightEnter {
        0% {
            transform: scale(0.5) rotate(-10deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.05) rotate(3deg);
            opacity: 1;
        }
        100% {
            transform: scale(1) rotate(2deg);
            opacity: 1;
        }
    }
    
    /* ===== POLAROID IMAGE ===== */
    .polaroid-image-wrap {
        position: relative;
        width: 100%;
        height: 140px;
        overflow: hidden;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 2px;
    }
    
    .polaroid-image-wrap::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: imageShimmer 2s infinite;
        z-index: 1;
    }
    
    .polaroid-image-wrap.loaded::before {
        display: none;
    }
    
    @keyframes imageShimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .polaroid-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    
    .polaroid-image.loaded {
        opacity: 1;
    }
    
    .polaroid:hover .polaroid-image.loaded {
        transform: scale(1.05);
    }
    
    /* ===== POLAROID CAPTION ===== */
    .polaroid-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 4px 6px;
        text-align: center;
        background: linear-gradient(165deg, #ffffff 0%, #fafafa 100%);
        height: 22px;
        overflow: hidden;
    }
    
    .polaroid-name {
        font-family: 'Great Vibes', cursive;
        font-size: 0.85rem;
        color: #2d2d2d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
    }
    
    /* ===== EMPTY STATE ===== */
    .empty-state {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 10;
    }
    
    .empty-state h2 {
        font-family: 'Great Vibes', cursive;
        font-size: 3rem;
        color: white;
        margin-bottom: 15px;
        text-shadow: 0 0 30px rgba(139, 92, 246, 0.5);
    }
    
    .empty-state p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 30px;
    }
    
    .qr-box {
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
    }
    
    /* ===== MODAL ===== */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(20px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-polaroid {
        max-width: 500px;
        width: 90%;
        background: linear-gradient(165deg, #ffffff 0%, #f8f8f8 100%);
        padding: 20px 20px 70px 20px;
        border-radius: 4px;
        transform: scale(0.8) rotate(-5deg);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: 
            0 40px 80px rgba(0, 0, 0, 0.5),
            0 0 100px rgba(139, 92, 246, 0.2);
    }
    
    .modal-overlay.active .modal-polaroid {
        transform: scale(1) rotate(2deg);
    }
    
    .modal-image-container {
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        background: #1a1a2e;
        border-radius: 2px;
    }
    
    .modal-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    .modal-caption {
        padding: 25px 15px 10px;
        text-align: center;
    }
    
    .modal-name {
        font-family: 'Great Vibes', cursive;
        font-size: 2.2rem;
        color: #2d2d2d;
        margin-bottom: 10px;
    }
    
    .modal-message {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        color: #666;
        font-style: italic;
        line-height: 1.6;
    }
    
    .modal-close {
        position: absolute;
        top: 25px;
        right: 25px;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg) scale(1.1);
    }
    
    /* ===== NOTIFICATION ===== */
    .notification {
        position: fixed;
        top: 100px;
        right: 30px;
        padding: 18px 30px;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.9) 0%, rgba(99, 102, 241, 0.9) 100%);
        backdrop-filter: blur(20px);
        color: white;
        font-weight: 500;
        border-radius: 16px;
        box-shadow: 
            0 15px 40px rgba(139, 92, 246, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transform: translateX(calc(100% + 50px));
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        z-index: 2000;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    /* ===== PHOTO COUNT ===== */
    .photo-count {
        position: fixed;
        bottom: 25px;
        right: 30px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        padding: 10px 20px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        z-index: 100;
    }
    
    .photo-count span {
        color: white;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<!-- Background Orbs -->
<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<!-- Particles -->
<div class="particles" id="particles"></div>

<!-- Header -->
<div class="event-header">
    <img src="/images/logo.png" alt="Bảo Việt Nhân Thọ 30 Năm" class="header-logo">
    <div class="header-title-wrapper">
        <div class="header-title">Thành Viên Hội Đồng<br>Khách Hàng Danh Dự</div>
    </div>
</div>

<!-- Photo Wall -->
<div class="photo-wall" id="photo-wall">
    @if(count($submissions) === 0)
    <div class="empty-state" id="empty-state">
        <h2>Welcome to Photo Wall</h2>
        <p>No photos shared yet. Be the first one!</p>
        <div class="qr-box">
            <img src="/images/qr-code.png" alt="Scan QR" style="width: 100%; height: 100%; object-fit: contain; border-radius: 10px;">
        </div>
    </div>
    @endif
    
    <div class="photo-grid" id="photo-grid"></div>
</div>

<!-- Photo Count -->
<div class="photo-count" id="photo-count">
    <span id="count-number">0</span> memories shared
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal">
    <button class="modal-close" id="modal-close">×</button>
    <div class="modal-polaroid">
        <div class="modal-image-container">
            <img src="" alt="" class="modal-image" id="modal-image">
        </div>
        <div class="modal-caption">
            <h2 class="modal-name" id="modal-name"></h2>
            <p class="modal-message" id="modal-message"></p>
        </div>
    </div>
</div>

<!-- Notification -->
<div class="notification" id="notification">
    ✨ New photo shared!
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('photo-grid');
    const modal = document.getElementById('modal');
    const modalImage = document.getElementById('modal-image');
    const modalName = document.getElementById('modal-name');
    const modalMessage = document.getElementById('modal-message');
    const modalClose = document.getElementById('modal-close');
    const notification = document.getElementById('notification');
    const emptyState = document.getElementById('empty-state');
    const countNumber = document.getElementById('count-number');
    const particlesContainer = document.getElementById('particles');
    
    // Config
    const CARD_WIDTH = 180;
    const CARD_HEIGHT = 210;
    const REFRESH_INTERVAL = 5000;
    const SPOTLIGHT_DURATION = 5000; 
    const SLIDESHOW_INTERVAL = 3000; // Change image every 3 seconds
    
    // State
    let allSubmissions = [];
    let currentZIndex = 10;
    let lastId = 0;
    let cardMap = new Map();
    let spotlightQueue = []; 
    let isShowingSpotlight = false;
    const existingIds = new Set();
    
    let activeCardId = null; // Currently visible card ID
    let slideshowTimer = null;
    
    // Initial data
    const initialSubmissions = @json($submissions);
    
    // ===== PARTICLES =====
    function createParticles() {
        for (let i = 0; i < 50; i++) {
            const star = document.createElement('div');
            star.className = 'particle particle-star';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 4 + 's';
            star.style.animationDuration = (3 + Math.random() * 3) + 's';
            particlesContainer.appendChild(star);
        }
        
        for (let i = 0; i < 20; i++) {
            const glow = document.createElement('div');
            glow.className = 'particle particle-glow';
            glow.style.left = Math.random() * 100 + '%';
            glow.style.animationDelay = Math.random() * 15 + 's';
            glow.style.animationDuration = (12 + Math.random() * 8) + 's';
            particlesContainer.appendChild(glow);
        }
    }
    
    // ===== RANDOM POSITION =====
    function getRandomPosition() {
        const screenWidth = window.innerWidth;
        const screenHeight = window.innerHeight;
        const margin = 40;
        
        // Random position anywhere on screen
        const maxX = screenWidth - CARD_WIDTH - margin;
        const maxY = screenHeight - CARD_HEIGHT - margin;
        
        return {
            x: margin + Math.random() * maxX,
            y: margin + Math.random() * maxY
        };
    }
    
    // ===== CREATE POLAROID =====
    function createPolaroid(submission, isNew = false) {
        const card = document.createElement('div');
        // Initial state is just 'polaroid' (hidden). 'new-arrival' handled separately if needed.
        card.className = 'polaroid'; 
        card.dataset.id = submission.id;
        
        const position = getRandomPosition();
        const rotation = (Math.random() - 0.5) * 20; // -10 to +10 degrees
        
        card.style.setProperty('--rotation', `${rotation}deg`);
        card.style.left = `${position.x}px`;
        card.style.top = `${position.y}px`;
        card.style.zIndex = currentZIndex;
        
        const imageUrl = submission.image_url || '/storage/' + submission.image_path;
        
        card.innerHTML = `
            <div class="polaroid-image-wrap">
                <img data-src="${imageUrl}" alt="${escapeHtml(submission.name)}" class="polaroid-image">
            </div>
            <div class="polaroid-info">
                <div class="polaroid-name">${escapeHtml(submission.name)}</div>
            </div>
        `;
        
        // Load image
        const img = card.querySelector('.polaroid-image');
        loadImage(img);
        
        // Click handler
        card.addEventListener('click', () => openModal(submission, imageUrl));
        
        return card;
    }
    
    // ===== LOAD IMAGE =====
    function loadImage(img) {
        const temp = new Image();
        temp.onload = function() {
            img.src = img.dataset.src;
            img.classList.add('loaded');
            img.parentElement.classList.add('loaded');
        };
        temp.onerror = function() {
            img.src = img.dataset.src;
            img.classList.add('loaded');
            img.parentElement.classList.add('loaded');
        };
        temp.src = img.dataset.src;
    }
    
    // ===== SLIDESHOW LOGIC =====
    function startSlideshow() {
        if (allSubmissions.length === 0) return;
        
        // Stop any existing timer
        if (slideshowTimer) clearInterval(slideshowTimer);
        
        // Function to show random card
        const showNext = () => {
            if (allSubmissions.length === 0) return;
            
            // Hide current active card
            if (activeCardId !== null) {
                const currentCard = cardMap.get(activeCardId);
                if (currentCard) {
                    currentCard.classList.remove('active');
                    // Pick a new random position for next time it shows
                    // This keeps it dynamic even if we see the same card again later
                    setTimeout(() => {
                        const newPos = getRandomPosition();
                        const newRot = (Math.random() - 0.5) * 20;
                        currentCard.style.left = `${newPos.x}px`;
                        currentCard.style.top = `${newPos.y}px`;
                        currentCard.style.setProperty('--rotation', `${newRot}deg`);
                    }, 1000); // Wait for fade out
                }
            }
            
            // Pick new random card (try to avoid same one if possible)
            let nextSubmission;
            if (allSubmissions.length === 1) {
                nextSubmission = allSubmissions[0];
            } else {
                let attempts = 0;
                do {
                    nextSubmission = allSubmissions[Math.floor(Math.random() * allSubmissions.length)];
                    attempts++;
                } while (nextSubmission.id === activeCardId && attempts < 5);
            }
            
            const nextCard = cardMap.get(nextSubmission.id);
            if (nextCard) {
                // Ensure z-index is top
                currentZIndex++;
                nextCard.style.zIndex = currentZIndex;
                nextCard.classList.add('active');
                activeCardId = nextSubmission.id;
            }
        };
        
        // Run immediately then interval
        showNext();
        slideshowTimer = setInterval(showNext, SLIDESHOW_INTERVAL);
    }
    
    // ===== SPOTLIGHT FOR NEW SUBMISSIONS =====
    function showSpotlight(submission) {
        // Pause slideshow
        if (slideshowTimer) clearInterval(slideshowTimer);
        
        // Hide currently active card if any
        if (activeCardId !== null) {
            const currentCard = cardMap.get(activeCardId);
            if (currentCard) currentCard.classList.remove('active');
        }

        const imageUrl = submission.image_url || '/storage/' + submission.image_path;
        
        // Open modal with submission data
        modalImage.src = imageUrl;
        modalName.textContent = submission.name;
        modalMessage.textContent = submission.feedback ? `"${submission.feedback}"` : '';
        modal.classList.add('active');
        modal.classList.add('spotlight-mode');
        
        // Auto close after SPOTLIGHT_DURATION
        setTimeout(() => {
            modal.classList.remove('active');
            modal.classList.remove('spotlight-mode');
            
            // Short delay before resume
            setTimeout(() => {
                isShowingSpotlight = false;
                processSpotlightQueue(); 
                // Resume slideshow if queue empty
                if (spotlightQueue.length === 0) {
                     startSlideshow();
                }
            }, 500);
        }, SPOTLIGHT_DURATION);
    }
    
    // ===== PROCESS SPOTLIGHT QUEUE =====
    function processSpotlightQueue() {
        if (spotlightQueue.length === 0) {
            isShowingSpotlight = false;
            return;
        }
        
        if (isShowingSpotlight) return;
        
        isShowingSpotlight = true;
        const submission = spotlightQueue.shift();
        showSpotlight(submission);
    }
    
    // ===== ADD TO SPOTLIGHT QUEUE =====
    function addToSpotlightQueue(submission) {
        spotlightQueue.push(submission);
        
        if (!isShowingSpotlight) {
            processSpotlightQueue();
        }
    }
    
    // ===== CREATE ALL CARDS INITIALLY =====
    function createAllCards() {
        if (allSubmissions.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            return;
        }
        
        if (emptyState) emptyState.style.display = 'none';
        
        // Create invisible cards
        allSubmissions.forEach(submission => {
            const card = createPolaroid(submission);
            grid.appendChild(card);
            cardMap.set(submission.id, card);
        });

        countNumber.textContent = allSubmissions.length;
    }
    
    // ===== ADD NEW SUBMISSION (from server) =====
    function addNewSubmission(submission) {
        if (emptyState) emptyState.style.display = 'none';
        
        allSubmissions.unshift(submission);
        countNumber.textContent = allSubmissions.length;
        
        // Create card for the new submission
        const card = createPolaroid(submission, true);
        grid.appendChild(card);
        cardMap.set(submission.id, card);
        
        // Add to spotlight queue (auto-show in modal for 5s)
        addToSpotlightQueue(submission);
        
        showNotification();
    }
    
    // ===== FETCH NEW SUBMISSIONS =====
    async function fetchNewSubmissions() {
        if (lastId <= 0) return;
        
        try {
            const response = await fetch(`{{ route('api.submissions') }}?last_id=${lastId}`);
            const data = await response.json();
            
            if (data.success && data.submissions?.length > 0) {
                data.submissions.forEach((sub) => {
                    if (!existingIds.has(sub.id)) {
                        existingIds.add(sub.id);
                        addNewSubmission(sub);
                    }
                });
                
                if (data.last_id > lastId) lastId = data.last_id;
            }
        } catch (e) {
            console.error('Fetch error:', e);
        }
    }
    
    // ===== MODAL =====
    function openModal(submission, imageUrl) {
        if (isShowingSpotlight) return;
        
        modalImage.src = imageUrl;
        modalName.textContent = submission.name;
        modalMessage.textContent = submission.feedback ? `"${submission.feedback}"` : '';
        modal.classList.add('active');
    }
    
    function closeModal() {
        if (modal.classList.contains('spotlight-mode')) return;
        modal.classList.remove('active');
    }
    
    modalClose.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    
    // ===== NOTIFICATION =====
    function showNotification() {
        notification.classList.add('show');
        setTimeout(() => notification.classList.remove('show'), 4000);
    }
    
    // ===== UTILS =====
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // ===== KEYBOARD =====
    document.addEventListener('keydown', e => {
        if (modal.classList.contains('active') && e.key === 'Escape' && !modal.classList.contains('spotlight-mode')) {
            closeModal();
        }
    });
    
    // ===== INIT =====
    function init() {
        createParticles();
        
        if (initialSubmissions.length > 0) {
            lastId = Math.max(...initialSubmissions.map(s => s.id));
            initialSubmissions.forEach(s => existingIds.add(s.id));
            allSubmissions = [...initialSubmissions].sort((a, b) => b.id - a.id);
            
            // Create cards and START SLIDESHOW
            createAllCards();
            setTimeout(startSlideshow, 1000); // Wait 1s before valid start
        }
        
        // Fetch new submissions periodically
        setInterval(fetchNewSubmissions, REFRESH_INTERVAL);
    }
    
    init();
});

</script>
@endsection
