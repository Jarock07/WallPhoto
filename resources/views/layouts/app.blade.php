<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Event Photo Wall')</title>
    <meta name="description" content="Chia sẻ khoảnh khắc tại sự kiện của chúng tôi">
    
    <!-- Google Fonts - Be Vietnam Pro hỗ trợ tiếng Việt tốt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Color Palette - Dark Theme */
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-card: rgba(255, 255, 255, 0.05);
            --bg-glass: rgba(255, 255, 255, 0.08);
            
            /* Accent Colors - Vibrant Gradient */
            --accent-primary: #8b5cf6;
            --accent-secondary: #06b6d4;
            --accent-pink: #ec4899;
            --accent-orange: #f97316;
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #8b5cf6 0%, #06b6d4 100%);
            --gradient-accent: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
            --gradient-warm: linear-gradient(135deg, #f97316 0%, #ec4899 100%);
            
            /* Text Colors */
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            
            /* Typography - Sử dụng Be Vietnam Pro cho tiếng Việt */
            --font-primary: 'Be Vietnam Pro', sans-serif;
            --font-display: 'Be Vietnam Pro', sans-serif;
            
            /* Spacing */
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --spacing-xl: 3rem;
            
            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-full: 9999px;
            
            /* Shadows */
            --shadow-glow: 0 0 40px rgba(139, 92, 246, 0.3);
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-primary);
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-animation::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            top: -25%;
            left: -25%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(236, 72, 153, 0.1) 0%, transparent 40%);
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(2deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }
        
        /* Utility Classes */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }
        
        .text-gradient {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        @yield('styles')
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    @yield('content')
    
    @yield('scripts')
</body>
</html>
