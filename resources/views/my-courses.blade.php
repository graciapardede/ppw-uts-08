<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Saya - Online Course Enrollment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #5b6cff;
            --primary-dark: #4a5bcc;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        header {
            background: white;
            padding: 24px 32px;
            border-radius: 16px;
            margin-bottom: 32px;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        header h1 {
            color: var(--primary-color);
            font-size: 28px;
            font-weight: 700;
        }

        .header-nav {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(91, 108, 255, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Alert Box */
        .alert {
            background: white;
            padding: 20px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .alert-warning {
            border-left: 4px solid var(--warning-color);
        }

        .alert-info {
            border-left: 4px solid var(--primary-color);
        }

        /* User Info */
        .user-info {
            background: white;
            padding: 20px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .user-status {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--success-color);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Content Section */
        .content-section {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 28px;
            background: var(--primary-color);
            border-radius: 4px;
        }

        /* Course Cards */
        .course-list {
            display: grid;
            gap: 20px;
        }

        .course-item {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .course-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #764ba2);
        }

        .course-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 16px;
            gap: 16px;
        }

        .course-info h3 {
            color: var(--text-dark);
            font-size: 20px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .course-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 12px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            text-align: center;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state svg {
            width: 120px;
            height: 120px;
            margin: 0 auto 24px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 20px;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 20px;
            }

            header h1 {
                font-size: 24px;
            }

            .course-header {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <div>
                <h1>📚 Kursus Saya</h1>
                <p style="color: var(--text-muted); margin-top: 4px;">Kelola kursus yang telah Anda ambil</p>
            </div>
            <div class="header-nav">
                <a href="/" class="btn btn-outline">Daftar Kursus</a>
                <a href="/my-courses" class="btn btn-primary">Kursus Saya</a>
            </div>
        </header>

        <!-- User Status -->
        <div class="user-info" id="userInfo" style="display: none;">
            <div class="user-status">
                <span class="status-indicator"></span>
                <div>
                    <strong>Selamat datang kembali!</strong>
                    <p style="color: var(--text-muted); margin-top: 4px; font-size: 14px;" id="userEmail"></p>
                </div>
            </div>
            <button class="btn btn-outline" onclick="logout()">Logout</button>
        </div>

        <!-- Alert when not logged in -->
        <div class="alert alert-warning" id="loginAlert">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <strong>Login diperlukan!</strong>
                <p style="color: var(--text-muted); margin-top: 4px; font-size: 14px;">
                    Silakan kembali ke halaman utama dan login untuk melihat kursus Anda.
                </p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid" id="statsGrid" style="display: none;">
            <div class="stat-card">
                <div class="stat-value" id="totalCourses">0</div>
                <div class="stat-label">Total Kursus</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="totalInvestment">Rp 0</div>
                <div class="stat-label">Total Investasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="totalDuration">0 minggu</div>
                <div class="stat-label">Total Durasi</div>
            </div>
        </div>

        <!-- My Courses List -->
        <div class="content-section" id="coursesSection" style="display: none;">
            <div class="section-title">🎯 Kursus Yang Diambil</div>
            <div class="course-list" id="courseList"></div>
        </div>

        <!-- Empty State -->
        <div class="content-section" id="emptyState" style="display: none;">
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3>Belum Ada Kursus</h3>
                <p>Anda belum mendaftar kursus apapun. Mulai belajar sekarang!</p>
                <a href="/" class="btn btn-primary">Lihat Daftar Kursus</a>
            </div>
        </div>
    </div>

    <script>
        // Course data
        const COURSES = [
            {
                id: 'html-css',
                name: 'HTML & CSS Dasar',
                duration: '4 minggu',
                price: 0,
                description: 'Pelajari fundamental HTML dan CSS untuk membuat website yang responsif dan modern.'
            },
            {
                id: 'javascript',
                name: 'JavaScript untuk Pemula',
                duration: '6 minggu',
                price: 150000,
                description: 'Kuasai dasar-dasar JavaScript, manipulasi DOM, dan interaksi dengan API.'
            },
            {
                id: 'react',
                name: 'React JS Fundamental',
                duration: '8 minggu',
                price: 350000,
                description: 'Membangun aplikasi web modern dengan React, dari component hingga hooks.'
            },
            {
                id: 'laravel',
                name: 'Backend PHP Laravel',
                duration: '10 minggu',
                price: 500000,
                description: 'Belajar membuat aplikasi web backend dengan Laravel framework.'
            },
            {
                id: 'nodejs',
                name: 'Node.js & Express',
                duration: '7 minggu',
                price: 400000,
                description: 'Membuat REST API dan server-side application dengan Node.js dan Express.'
            },
            {
                id: 'python',
                name: 'Python Programming',
                duration: '8 minggu',
                price: 300000,
                description: 'Belajar Python dari dasar hingga membuat aplikasi sederhana.'
            }
        ];

        // Helper Functions
        function getCurrentUser() {
            return localStorage.getItem('currentUser');
        }

        function getParticipants() {
            try {
                return JSON.parse(localStorage.getItem('participants') || '[]');
            } catch (e) {
                return [];
            }
        }

        function formatCurrency(amount) {
            if (amount === 0) return 'Gratis';
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function getCourseById(courseId) {
            return COURSES.find(c => c.id === courseId);
        }

        // Logout
        function logout() {
            localStorage.removeItem('currentUser');
            window.location.href = '/';
        }

        // Render User Courses
        function renderUserCourses() {
            const currentUser = getCurrentUser();
            const loginAlert = document.getElementById('loginAlert');
            const userInfo = document.getElementById('userInfo');
            const statsGrid = document.getElementById('statsGrid');
            const coursesSection = document.getElementById('coursesSection');
            const emptyState = document.getElementById('emptyState');
            const userEmail = document.getElementById('userEmail');

            // Check if user is logged in
            if (!currentUser) {
                loginAlert.style.display = 'flex';
                userInfo.style.display = 'none';
                statsGrid.style.display = 'none';
                coursesSection.style.display = 'none';
                emptyState.style.display = 'none';
                return;
            }

            loginAlert.style.display = 'none';
            userInfo.style.display = 'flex';
            userEmail.textContent = currentUser;

            // Get user's enrolled courses
            const participants = getParticipants();
            const userCourses = participants.filter(p => p.email === currentUser);

            if (userCourses.length === 0) {
                statsGrid.style.display = 'none';
                coursesSection.style.display = 'none';
                emptyState.style.display = 'block';
                return;
            }

            // Show stats and courses
            statsGrid.style.display = 'grid';
            coursesSection.style.display = 'block';
            emptyState.style.display = 'none';

            // Calculate statistics
            let totalInvestment = 0;
            let totalWeeks = 0;

            userCourses.forEach(enrollment => {
                const course = getCourseById(enrollment.courseId);
                if (course) {
                    totalInvestment += course.price;
                    const weeks = parseInt(course.duration.match(/\d+/)[0]);
                    totalWeeks += weeks;
                }
            });

            document.getElementById('totalCourses').textContent = userCourses.length;
            document.getElementById('totalInvestment').textContent = formatCurrency(totalInvestment);
            document.getElementById('totalDuration').textContent = totalWeeks + ' minggu';

            // Render course list
            const courseList = document.getElementById('courseList');
            courseList.innerHTML = userCourses.map(enrollment => {
                const course = getCourseById(enrollment.courseId);
                if (!course) return '';

                return `
                    <div class="course-item">
                        <div class="course-header">
                            <div class="course-info">
                                <h3>${course.name}</h3>
                                <p style="color: var(--text-muted); margin-bottom: 12px;">${course.description}</p>
                                <div class="course-meta">
                                    <div class="meta-item">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ${course.duration}
                                    </div>
                                    <div class="meta-item">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Terdaftar: ${formatDate(enrollment.enrolledAt)}
                                    </div>
                                    <div class="meta-item">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ${formatCurrency(course.price)}
                                    </div>
                                </div>
                            </div>
                            <span class="badge badge-success">✓ Terdaftar</span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderUserCourses();
        });
    </script>
</body>
</html>