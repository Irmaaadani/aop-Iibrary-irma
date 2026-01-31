<div class="sidebar bg-primary text-white p-3">
    <h5 class="mb-3 text-center sidebar-text">
        Sistem Peminjaman Perpustakaan
    </h5>

    <div class="mb-4 text-center border-bottom pb-3">
        <div class="fw-bold sidebar-text">
            {{ auth()->user()->name }}
        </div>
        <div class="small text-white-50 sidebar-text">
            {{ auth()->user()->email }}
        </div>
        <div class="small text-white-50 sidebar-text">
          Role:  {{ auth()->user()->role }}
        </div>
    </div>
    <ul class="nav flex-column mb-4">
        <li class="nav-item">
            <a href="/books" class="nav-link text-white">
                📚 <span class="sidebar-text">Buku</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="/categories" class="nav-link text-white">
                🗂 <span class="sidebar-text">Kategori</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="/loans" class="nav-link text-white">
                🏛️ <span class="sidebar-text">Peminjaman</span>
            </a>
        </li>
        @if(auth()->user()->role === 'admin')
            <li class="nav-item">
                <a href="/user" class="nav-link text-white">
                    👥 <span class="sidebar-text">User</span>
                </a>
            </li>
        @endif
    </ul>


    <form method="POST" action="/logout">
        @csrf
        <button class="btn btn-danger w-100 sidebar-text">
            Logout
        </button>
    </form>

</div>
