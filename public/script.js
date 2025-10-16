// ========================================
// DATA KURSUS
// ========================================
const COURSES = [
    { id: 'html-css', name: 'HTML & CSS Fundamentals', duration: '4 minggu', price: 500000, description: 'Belajar dasar HTML dan CSS' },
    { id: 'javascript', name: 'JavaScript Essentials', duration: '6 minggu', price: 750000, description: 'Belajar JavaScript dari dasar' },
    { id: 'react', name: 'React Development', duration: '8 minggu', price: 1200000, description: 'Membuat aplikasi dengan React' },
    { id: 'nodejs', name: 'Node.js Backend', duration: '8 minggu', price: 1200000, description: 'Backend development dengan Node.js' },
    { id: 'python', name: 'Python Programming', duration: '6 minggu', price: 800000, description: 'Pemrograman Python untuk pemula' },
    { id: 'laravel', name: 'Laravel Framework', duration: '10 minggu', price: 1500000, description: 'Web development dengan Laravel' }
];

// ========================================
// HELPER FUNCTIONS
// ========================================
function formatPrice(price) {
    return 'Rp ' + price.toLocaleString('id-ID');
}

// ========================================
// USER AUTHENTICATION FUNCTIONS
// ========================================
function getUsers() {
    const data = localStorage.getItem('users');
    return data ? JSON.parse(data) : [];
}

function saveUsers(users) {
    localStorage.setItem('users', JSON.stringify(users));
}

function getCurrentUser() {
    const email = localStorage.getItem('currentUser');
    if (!email) return null;
    
    const users = getUsers();
    return users.find(u => u.email === email);
}

function registerUser(name, email, password) {
    const users = getUsers();
    
    // Check if email already exists
    if (users.some(u => u.email === email)) {
        return { success: false, message: 'Email sudah terdaftar!' };
    }
    
    // Add new user
    users.push({
        id: Date.now().toString(),
        name: name,
        email: email,
        password: password, // In production, this should be hashed!
        createdAt: new Date().toISOString()
    });
    
    saveUsers(users);
    return { success: true, message: 'Registrasi berhasil!' };
}

function loginUser(email, password) {
    const users = getUsers();
    const user = users.find(u => u.email === email && u.password === password);
    
    if (!user) {
        return { success: false, message: 'Email atau password salah!' };
    }
    
    localStorage.setItem('currentUser', email);
    return { success: true, message: 'Login berhasil!' };
}

function logoutUser() {
    localStorage.removeItem('currentUser');
}

// ========================================
// ENROLLMENT FUNCTIONS
// ========================================
function getEnrollments() {
    const data = localStorage.getItem('enrollments');
    return data ? JSON.parse(data) : [];
}

function saveEnrollments(enrollments) {
    localStorage.setItem('enrollments', JSON.stringify(enrollments));
}

function enrollCourse(userEmail, courseId) {
    const enrollments = getEnrollments();
    
    // Check if already enrolled
    const exists = enrollments.some(e => e.userEmail === userEmail && e.courseId === courseId);
    if (exists) {
        return { success: false, message: 'Anda sudah terdaftar di kursus ini!' };
    }
    
    // Add enrollment
    enrollments.push({
        id: Date.now().toString(),
        userEmail: userEmail,
        courseId: courseId,
        enrolledAt: new Date().toISOString()
    });
    
    saveEnrollments(enrollments);
    return { success: true, message: 'Pendaftaran kursus berhasil!' };
}

function getUserEnrollments(userEmail) {
    const enrollments = getEnrollments();
    return enrollments.filter(e => e.userEmail === userEmail);
}

// ========================================
// UI FUNCTIONS
// ========================================
function updateNavbar() {
    const navLinks = document.getElementById('navLinks');
    if (!navLinks) return;
    
    const currentUser = getCurrentUser();
    
    if (currentUser) {
        // User logged in - show Dashboard and Logout
        navLinks.innerHTML = `
            <a href="index.html">Beranda</a>
            <a href="login.html">Dashboard</a>
            <a href="#" id="navLogout">Logout</a>
        `;
        
        // Add logout handler
        const logoutLink = document.getElementById('navLogout');
        if (logoutLink) {
            logoutLink.addEventListener('click', function(e) {
                e.preventDefault();
                logoutUser();
                window.location.href = 'index.html';
            });
        }
    } else {
        // User not logged in - show Login and Register
        navLinks.innerHTML = `
            <a href="index.html">Beranda</a>
            <a href="login.html">Login</a>
            <a href="register.html">Daftar</a>
        `;
    }
}

function renderCourses() {
    const list = document.getElementById('coursesList');
    if (!list) return;
    
    list.innerHTML = '';
    COURSES.forEach(course => {
        const card = document.createElement('div');
        card.className = 'course-card';
        card.innerHTML = `
            <h3>${course.name}</h3>
            <div class="course-info">
                <p><strong>Durasi:</strong> ${course.duration}</p>
                <p class="course-price">${formatPrice(course.price)}</p>
            </div>
            <p class="course-description">${course.description}</p>
        `;
        list.appendChild(card);
    });
}

function populateCourseSelect() {
    const select = document.getElementById('courseSelect');
    if (!select) return;
    
    // Clear existing options except the first one
    const firstOption = select.querySelector('option');
    select.innerHTML = '';
    if (firstOption) select.appendChild(firstOption);
    
    COURSES.forEach(course => {
        const option = document.createElement('option');
        option.value = course.id;
        option.textContent = `${course.name} - ${formatPrice(course.price)}`;
        select.appendChild(option);
    });
}

function renderMyCoursesForUser() {
    const currentUser = getCurrentUser();
    if (!currentUser) return;
    
    const enrollments = getUserEnrollments(currentUser.email);
    const list = document.getElementById('myCoursesList');
    
    if (!list) return;
    
    if (enrollments.length === 0) {
        list.innerHTML = `
            <div class="empty-state">
                <p style="text-align: center; color: #666; padding: 40px;">
                    📚 Anda belum mendaftar kursus apapun.<br>
                    <a href="index.html" style="color: #28a745;">Lihat daftar kursus</a>
                </p>
            </div>
        `;
        
        document.getElementById('totalCourses').textContent = '0';
        document.getElementById('totalInvestment').textContent = 'Rp 0';
        document.getElementById('totalDuration').textContent = '0 minggu';
        return;
    }
    
    // Calculate stats
    let totalInvestment = 0;
    let totalWeeks = 0;
    
    list.innerHTML = '';
    enrollments.forEach(enrollment => {
        const course = COURSES.find(c => c.id === enrollment.courseId);
        if (!course) return;
        
        totalInvestment += course.price;
        const weeks = parseInt(course.duration);
        totalWeeks += weeks;
        
        const card = document.createElement('div');
        card.className = 'course-card';
        card.innerHTML = `
            <h3>${course.name}</h3>
            <div class="course-info">
                <p><strong>Durasi:</strong> ${course.duration}</p>
                <p class="course-price">${formatPrice(course.price)}</p>
                <p><strong>Terdaftar:</strong> ${new Date(enrollment.enrolledAt).toLocaleDateString('id-ID')}</p>
            </div>
            <p class="course-description">${course.description}</p>
        `;
        list.appendChild(card);
    });
    
    // Update stats
    document.getElementById('totalCourses').textContent = enrollments.length;
    document.getElementById('totalInvestment').textContent = formatPrice(totalInvestment);
    document.getElementById('totalDuration').textContent = totalWeeks + ' minggu';
}

// ========================================
// EVENT HANDLERS
// ========================================
function handleEnrollment(e) {
    e.preventDefault();
    
    const currentUser = getCurrentUser();
    if (!currentUser) {
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.html';
        return;
    }
    
    const courseId = document.getElementById('courseSelect').value;
    const messageDiv = document.getElementById('enrollmentMessage');
    
    if (!courseId) {
        messageDiv.textContent = 'Silakan pilih kursus!';
        messageDiv.className = 'message error-message';
        messageDiv.style.display = 'block';
        return;
    }
    
    const result = enrollCourse(currentUser.email, courseId);
    
    messageDiv.textContent = result.message;
    messageDiv.className = 'message ' + (result.success ? 'success-message' : 'error-message');
    messageDiv.style.display = 'block';
    
    if (result.success) {
        document.getElementById('enrollmentForm').reset();
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 3000);
    }
}

// ========================================
// INITIALIZATION
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Update navbar on all pages
    updateNavbar();
    
    // Index page
    if (document.getElementById('coursesList')) {
        renderCourses();
        populateCourseSelect();
        
        const form = document.getElementById('enrollmentForm');
        if (form) {
            form.addEventListener('submit', handleEnrollment);
        }
    }
});
