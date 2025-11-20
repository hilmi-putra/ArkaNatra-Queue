<!-- layouts/components/loading.blade.php -->
<div id="auto-loading"
    class="hidden fixed inset-0 z-[9999] bg-white/80 backdrop-blur-sm flex items-center justify-center">

    <div class="flex space-x-3">
        <div class="w-3 h-3 rounded-full bg-blue-600 worm"></div>
        <div class="w-3 h-3 rounded-full bg-blue-600 worm" style="animation-delay: 0.15s"></div>
        <div class="w-3 h-3 rounded-full bg-blue-600 worm" style="animation-delay: 0.3s"></div>
    </div>

</div>

<style>
    @keyframes wormMove {
        0% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        25% {
            transform: translateY(-6px) scale(1.2);
            opacity: 0.9;
        }

        50% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        75% {
            transform: translateY(6px) scale(0.9);
            opacity: 0.85;
        }

        100% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    .worm {
        animation: wormMove 0.8s infinite ease-in-out;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loading = document.getElementById('auto-loading');

        // Show on link clicks (internal links only)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && link.hostname === window.location.hostname) {
                loading.classList.remove('hidden');
            }
        });

        // Show on form submit
        document.addEventListener('submit', function() {
            loading.classList.remove('hidden');
        });

        // Show loading on refresh / reload / close tab (beforeunload always fires)
        window.addEventListener('beforeunload', function() {
            loading.classList.remove('hidden');
        });

        // Hide after page fully loads
        window.addEventListener('load', function() {
            setTimeout(() => {
                loading.classList.add('hidden');
            }, 300);
        });

        // Hide on page show (back-forward cache)
        window.addEventListener('pageshow', function() {
            loading.classList.add('hidden');
        });
    });

    // Manual controls (optional)
    function showLoading() {
        document.getElementById('auto-loading').classList.remove('hidden');
    }

    function hideLoading() {
        document.getElementById('auto-loading').classList.add('hidden');
    }
</script>
