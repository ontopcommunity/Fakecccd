<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

function generateRandomCCCD() {
    $randomCCCD = '';
    $randomCCCD .= rand(1, 9);
    for ($i = 1; $i <= 11; $i++) {
        $randomCCCD .= rand(0, 9);
    }
    return $randomCCCD;
}

$name = $_POST['name'] ?? '';
$anhthe = $_POST['anhthe'] ?? '';
$sex = $_POST['sex'] ?? 'Nam';
$birthday = $_POST['birthday'] ?? '';
$quequan = $_POST['quequan'] ?? '';
$thuongtru = $_POST['thuongtru'] ?? '';
$ngaycap = $_POST['ngaycap'] ?? '';

$currentCCCD = isset($_POST['socccd']) && !empty($_POST['socccd']) ? $_POST['socccd'] : generateRandomCCCD();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCCD Generator - Tạo phôi nhanh chóng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0B0B0F;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100vw; height: 100vh;
            background-image: radial-gradient(circle at 50% 0, rgba(0, 150, 255, 0.15) 0%, transparent 50%);
            z-index: -2;
        }
        
        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                                        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 4rem 4rem;
            opacity: 0.3;
            z-index: -1;
        }

        .glass-panel {
            background: rgba(30, 34, 48, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0, 0.2);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #00D1FF;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 209, 255, 0.1);
        }

        .btn-glow {
            background: linear-gradient(135deg, #00D1FF 0%, #0054FF 100%);
            box-shadow: 0 4px 15px rgba(0, 84, 255, 0.4);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 84, 255, 0.5);
        }
        .btn-glow:active {
            transform: translateY(1px);
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        #particles-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        .particle {
            position: absolute;
            background: white;
            border-radius: 50%;
            opacity: 0;
            animation: floatParticles 20s infinite linear;
        }
        @keyframes floatParticles {
            0% { transform: translateY(100vh); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-100vh); opacity: 0; }
        }
    </style>
</head>
<body class="antialiased flex flex-col justify-between">

    <div id="particles-container"></div>

    <header class="fixed top-0 w-full z-50 border-b border-white/5 bg-[#0B0B0F]/80 backdrop-blur-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center font-bold text-white">ID</div>
                <span class="font-bold text-xl tracking-tight">CCCD<span class="text-[#00D1FF]">Gen</span></span>
            </div>
            <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Công cụ hỗ trợ</a>
        </nav>
    </header>

    <main class="container mx-auto px-4 pt-28 pb-12 flex-grow">
        <div class="max-w-4xl mx-auto">
            
            <div class="text-center mb-10 fade-in-up">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white via-blue-100 to-gray-400">
                    Tạo phôi CCCD
                </h1>
                <p class="text-gray-400 max-w-lg mx-auto">
                    Điền thông tin vào form bên dưới để hệ thống tự động tạo ảnh thẻ và mặt sau CCCD nhanh chóng.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-7 fade-in-up" style="transition-delay: 100ms;">
                    <div class="glass-panel p-6 md:p-8">
                        <form action="" method="POST" class="space-y-5">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Họ và tên <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required 
                                    class="w-full rounded-lg px-4 py-3 input-glass placeholder-gray-600" placeholder="NGUYEN VAN A">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Link ảnh thẻ 
                                    <a href="tool-upload-lay-link" target="_blank" class="text-[#00D1FF] hover:underline text-xs ml-1">(Upload lấy link tại đây)</a>
                                </label>
                                <input type="text" name="anhthe" value="<?= htmlspecialchars($anhthe) ?>" required 
                                    class="w-full rounded-lg px-4 py-3 input-glass placeholder-gray-600" placeholder="https://linkanh.com/abc.jpg">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Giới tính</label>
                                    <div class="relative">
                                        <select name="sex" class="w-full rounded-lg px-4 py-3 input-glass appearance-none cursor-pointer">
                                            <option value="Nam" <?= $sex == 'Nam' ? 'selected' : '' ?> class="bg-[#1A1D2A]">Nam</option>
                                            <option value="Nữ" <?= $sex == 'Nữ' ? 'selected' : '' ?> class="bg-[#1A1D2A]">Nữ</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Ngày sinh</label>
                                    <input type="text" name="birthday" value="<?= htmlspecialchars($birthday) ?>" required 
                                        class="w-full rounded-lg px-4 py-3 input-glass placeholder-gray-600" placeholder="12/12/2000">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Số CCCD (Random)</label>
                                    <input type="text" name="socccd" value="<?= $currentCCCD ?>" required 
                                        class="w-full rounded-lg px-4 py-3 input-glass font-mono text-[#00D1FF] tracking-wider">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Quê quán</label>
                                    <input type="text" name="quequan" value="<?= htmlspecialchars($quequan) ?>" required 
                                        class="w-full rounded-lg px-4 py-3 input-glass placeholder-gray-600">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Địa chỉ thường trú</label>
                                <input type="text" name="thuongtru" value="<?= htmlspecialchars($thuongtru) ?>" required 
                                    class="w-full rounded-lg px-4 py-3 input-glass placeholder-gray-600">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Ngày cấp</label>
                                <input type="text" name="ngaycap" value="<?= htmlspecialchars($ngaycap) ?>" required 
                                    class="w-full rounded-lg px-4 py-3 input-glass placeholder-gray-600" placeholder="dd/mm/yyyy">
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-lg text-white font-bold text-lg btn-glow mt-4">
                                Khởi tạo CCCD
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-5 fade-in-up" style="transition-delay: 200ms;">
                    <div class="glass-panel p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="w-2 h-6 bg-[#00D1FF] rounded-full"></span>
                            Kết quả
                        </h2>
                        
                        <?php if(isset($_POST['name'])): ?>
                            <div class="space-y-4">
                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-200"></div>
                                    <img class="relative w-full rounded-lg border border-white/10 shadow-xl" 
                                        src="edit-image.php?name=<?=urlencode($_POST['name'])?>&socccd=<?=urlencode($_POST['socccd'])?>&birthday=<?=urlencode($_POST['birthday'])?>&sex=<?=urlencode($_POST['sex'])?>&quequan=<?=urlencode($_POST['quequan'])?>&thuongtru=<?=urlencode($_POST['thuongtru'])?>&ngaycap=<?=urlencode($_POST['ngaycap'])?>&anhthe=<?=urlencode($_POST['anhthe'])?>" 
                                        alt="Mặt trước CCCD">
                                </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-200"></div>
                                    <img class="relative w-full rounded-lg border border-white/10 shadow-xl" 
                                        src="mat-sau.php?name=<?=urlencode($_POST['name'])?>&socccd=<?=urlencode($_POST['socccd'])?>&birthday=<?=urlencode($_POST['birthday'])?>&sex=<?=urlencode($_POST['sex'])?>&quequan=<?=urlencode($_POST['quequan'])?>&thuongtru=<?=urlencode($_POST['thuongtru'])?>&ngaycap=<?=urlencode($_POST['ngaycap'])?>&anhthe=<?=urlencode($_POST['anhthe'])?>" 
                                        alt="Mặt sau CCCD">
                                </div>
                                <div class="text-center">
                                    <span class="text-xs text-green-400 bg-green-400/10 px-3 py-1 rounded-full border border-green-400/20">
                                        ✓ Đã tạo thành công
                                    </span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center py-12 text-gray-500 border-2 border-dashed border-white/10 rounded-lg">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm">Vui lòng nhập thông tin để xem trước</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="border-t border-white/10 bg-[#0B0B0F]/50 py-8">
        <div class="container mx-auto px-6 text-center text-sm text-gray-500">
            <p>&copy; <?= date('Y') ?> CCCD Generator Tool. Interface inspired by APIKey.</p>
        </div>
    </footer>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

        document.addEventListener("DOMContentLoaded", () => {
            const animatedElements = document.querySelectorAll('.fade-in-up');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1 });
            animatedElements.forEach(el => observer.observe(el));

            const particleContainer = document.getElementById('particles-container');
            const particleCount = 20;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 3 + 1;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${Math.random() * 100}vw`;
                const duration = Math.random() * 10 + 15;
                particle.style.animationDuration = `${duration}s`;
                const delay = Math.random() * 20;
                particle.style.animationDelay = `${delay}s`;
                particleContainer.appendChild(particle);
            }
        });
    </script>
</body>
</html>