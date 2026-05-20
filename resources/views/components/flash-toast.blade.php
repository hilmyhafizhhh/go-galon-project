@if (session('success'))
    <script>
        window.addEventListener('load', () => {
            showToast(@json(session('success')), 'success');
        });
    </script>
@endif

@if (session('error'))
    <script>
        window.addEventListener('load', () => {
            showToast(@json(session('error')), 'error');
        });
    </script>
@endif