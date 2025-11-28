<div class="header">
    <button class="menu-toggle" aria-label="Toggle menu">
        <span></span><span></span><span></span>
    </button>
    <div class="header-left">
        <h1>Panel Guru</h1>
    </div>
    <div class="header-right">
        <span>👋 Hai, <?= $_SESSION['username']; ?></span>
    </div>
</div>
<script>
const toggleBtn = document.querySelector('.menu-toggle');
const sidebar = document.querySelector('.sidebar');
toggleBtn?.addEventListener('click', () => {
    sidebar?.classList.toggle('open');
    document.body.classList.toggle('sidebar-open');
});
</script>
