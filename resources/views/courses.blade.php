<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses - Online Course Enrollment</title>
    <style>
        :root{--bg:#f4f7fb;--card:#fff;--accent:#5b6cff;--muted:#6b7280}
        *{box-sizing:border-box}
        body{font-family:Inter,ui-sans-serif,system-ui,Arial;margin:0;background:var(--bg);color:#111}
        header{background:linear-gradient(90deg,#6b8bff, #5b6cff);color:white;padding:20px;text-align:center}
        .container{max-width:1100px;margin:24px auto;padding:0 16px}
        h1{margin:0;font-size:20px}
        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
        @media (max-width:900px){.grid{grid-template-columns:repeat(2,1fr)}}
        @media (max-width:600px){.grid{grid-template-columns:1fr}}

        .card{background:var(--card);border-radius:12px;padding:16px;box-shadow:0 6px 18px rgba(15,23,42,0.06);display:flex;flex-direction:column}
        .card h3{margin:0 0 8px;font-size:18px}
        .meta{font-size:13px;color:var(--muted);margin-bottom:12px}
        .price{margin-top:auto;font-weight:700;color:var(--accent)}

        .controls{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:18px}
        .form{background:var(--card);padding:16px;border-radius:12px;box-shadow:0 6px 18px rgba(15,23,42,0.04)}
        label{display:block;font-size:13px;margin-bottom:6px}
        input,select,button{width:100%;padding:10px;border-radius:8px;border:1px solid #e6e9ef;font-size:14px}
        button{cursor:pointer;background:var(--accent);color:white;border:none}
        .small{max-width:360px}
        .row{display:flex;gap:12px}
        .row > *{flex:1}

        .notice{background:#eaf0ff;border-left:4px solid var(--accent);padding:12px;border-radius:6px;margin-bottom:12px}
        .muted{color:var(--muted)}

        footer{text-align:center;color:var(--muted);padding:32px 0}
        a.cta{display:inline-block;margin-top:8px;padding:8px 12px;background:#fff;color:#5b6cff;border-radius:8px;text-decoration:none}
    </style>
</head>
<body>
    <header>
        <h1>Online Course Enrollment — Courses</h1>
        <div class="muted">Halaman pendaftaran kursus (disimpan di localStorage)</div>
    </header>

    <main class="container">
        <p><a href="/" class="cta">Kembali ke beranda</a></p>

        <section class="controls">
            <div class="form small" id="enrollForm">
                <h3>Form Pendaftaran</h3>
                <div class="notice">Isi nama, email, dan pilih kursus lalu klik "Daftar".</div>
                <label for="studentName">Nama</label>
                <input id="studentName" placeholder="Nama lengkap">

                <label for="studentEmail">Email</label>
                <input id="studentEmail" placeholder="contoh@mail.com">

                <label for="courseSelect">Pilih Kursus</label>
                <select id="courseSelect"></select>

                <div style="margin-top:10px">
                    <button id="enrollBtn">Daftar</button>
                </div>
                <div id="enrollMsg" style="margin-top:12px"></div>
            </div>

            <div class="form small" id="loginBox">
                <h3>Login Sederhana</h3>
                <label for="loginEmail">Email</label>
                <input id="loginEmail" placeholder="Masukkan email untuk melihat kursus Anda">
                <div style="margin-top:10px" class="row">
                    <button id="loginBtn">Login</button>
                    <button id="logoutBtn" style="background:#ef4444">Logout</button>
                </div>
                <div id="loginMsg" style="margin-top:12px"></div>
            </div>
        </section>

        <section>
            <h2 style="margin-top:6px">Daftar Kursus</h2>
            <div id="coursesGrid" class="grid" style="margin-top:12px"></div>
        </section>

        <section style="margin-top:22px">
            <h2>Riwayat Pendaftaran (LocalStorage)</h2>
            <div id="myCourses" class="form" style="margin-top:12px"></div>
        </section>
    </main>

    <footer>
        &copy; {{ date('Y') }} - Online Course Enrollment • Data disimpan di browser (localStorage)
    </footer>

    <script>
        const COURSES = [
            {id: 'c1', name: 'HTML & CSS Dasar', duration: '4 minggu', price: 0, desc: 'Pemahaman dasar HTML dan CSS, layout responsif.'},
            {id: 'c2', name: 'JavaScript untuk Pemula', duration: '6 minggu', price: 150000, desc: 'Dasar-dasar JS, manipulasi DOM, fetch API.'},
            {id: 'c3', name: 'React Dasar', duration: '8 minggu', price: 350000, desc: 'Component, props, state, hooks dasar.'},
            {id: 'c4', name: 'Backend PHP (Laravel)', duration: '10 minggu', price: 500000, desc: 'Routing, controllers, views sederhana.'}
        ];

        function readParticipants(){ try{ return JSON.parse(localStorage.getItem('participants')||'[]') }catch(e){return []} }
        function writeParticipants(list){ localStorage.setItem('participants', JSON.stringify(list)) }

        function renderCourses(){ const grid = document.getElementById('coursesGrid'); grid.innerHTML=''; COURSES.forEach(c=>{ const el=document.createElement('div'); el.className='card'; el.innerHTML=`<h3>${escapeHtml(c.name)}</h3><div class="meta">${escapeHtml(c.desc)}</div><div class="meta">Durasi: ${escapeHtml(c.duration)}</div><div class="price">${formatPrice(c.price)}</div>`; grid.appendChild(el); }) }
        function populateSelect(){ const sel = document.getElementById('courseSelect'); sel.innerHTML=''; COURSES.forEach(c=>{ const o=document.createElement('option'); o.value=c.id; o.textContent = `${c.name} — ${formatPrice(c.price)}`; sel.appendChild(o); }) }
        function formatPrice(p){ return p===0? 'Gratis' : new Intl.NumberFormat('id-ID', {style:'currency',currency:'IDR'}).format(p) }
        function escapeHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') }

        document.getElementById('enrollBtn').addEventListener('click', ()=>{
            const name = document.getElementById('studentName').value.trim();
            const email = document.getElementById('studentEmail').value.trim().toLowerCase();
            const courseId = document.getElementById('courseSelect').value;
            const msg = document.getElementById('enrollMsg'); msg.innerText='';
            if(!name||!email){ msg.innerText='Nama dan email wajib diisi.'; return }
            if(!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)){ msg.innerText='Format email tidak valid.'; return }
            const participants = readParticipants();
            const exists = participants.find(p=>p.email===email && p.courseId===courseId);
            if(exists){ msg.innerText='Anda sudah terdaftar di kursus ini.'; return }
            participants.push({name, email, courseId, createdAt:(new Date()).toISOString()});
            writeParticipants(participants);
            msg.innerText='Pendaftaran sukses!';
            document.getElementById('studentName').value='';
            renderMyCourses(); renderLoginState();
        })

        document.getElementById('loginBtn').addEventListener('click', ()=>{ const email=document.getElementById('loginEmail').value.trim().toLowerCase(); const msg=document.getElementById('loginMsg'); msg.innerText=''; if(!email){ msg.innerText='Masukkan email untuk login.'; return } localStorage.setItem('currentUser', email); renderLoginState(); renderMyCourses(); })
        document.getElementById('logoutBtn').addEventListener('click', ()=>{ localStorage.removeItem('currentUser'); document.getElementById('loginMsg').innerText='Telah logout.'; renderLoginState(); renderMyCourses(); })
        function getCurrentUser(){ return localStorage.getItem('currentUser') }
        function renderLoginState(){ const cur=getCurrentUser(); const loginMsg=document.getElementById('loginMsg'); if(cur){ loginMsg.innerHTML=`Login sebagai <strong>${escapeHtml(cur)}</strong>`; document.getElementById('loginEmail').value=cur } else { loginMsg.innerHTML='Belum login.'; document.getElementById('loginEmail').value='' } }
        function renderMyCourses(){ const container=document.getElementById('myCourses'); container.innerHTML=''; const participants=readParticipants(); const cur=getCurrentUser(); const list=cur?participants.filter(p=>p.email===cur):participants; if(list.length===0){ container.innerHTML='<div class="muted">Belum ada pendaftaran.</div>'; return } const ul=document.createElement('div'); ul.style.display='grid'; ul.style.gap='8px'; list.forEach(p=>{ const course=COURSES.find(c=>c.id===p.courseId); const item=document.createElement('div'); item.className='card'; item.innerHTML=`<div><strong>${escapeHtml(p.name)}</strong> <span class="muted">(${escapeHtml(p.email)})</span></div><div class="meta">Kursus: ${escapeHtml(course?course.name:p.courseId)}</div><div class="meta">Waktu: ${new Date(p.createdAt).toLocaleString()}</div>`; ul.appendChild(item); }); container.appendChild(ul); }

        populateSelect(); renderCourses(); renderLoginState(); renderMyCourses();
    </script>
</body>
</html>
