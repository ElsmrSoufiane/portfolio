<style>
    .alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        max-width: 400px;
        width: 90%;
    }
    
    .alert {
        padding: 15px 20px;
        margin-bottom: 15px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        animation: slideIn 0.3s ease-out forwards;
        position: relative;
        overflow: hidden;
    }
    
    .alert-success {
        background-color: #f0fdf4;
        border-left: 4px solid #16a34a;
        color: #166534;
    }
    
    .alert-error {
        background-color: #fef2f2;
        border-left: 4px solid #dc2626;
        color: #991b1b;
    }
    
    .alert-icon {
        margin-right: 12px;
        font-size: 20px;
    }
    
    .alert-close {
        margin-left: auto;
        cursor: pointer;
        background: none;
        border: none;
        font-size: 18px;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .alert-close:hover {
        opacity: 1;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .alert.hide {
        animation: slideOut 0.3s ease-in forwards;
    }
    
    @keyframes slideOut {
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

@if(session('success'))
<div class="alert-container">
    <div id="success-alert" class="alert alert-success">
        <span class="alert-icon">✓</span>
        <span>{{ session('success') }}</span>
        <button class="alert-close" onclick="this.parentElement.classList.add('hide')">×</button>
    </div>
</div>

<script>
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        var alert = document.getElementById('success-alert');
        if (alert) alert.classList.add('hide');
    }, 5000);
</script>
@endif

@if(session('error'))
<div class="alert-container">
    <div id="error-alert" class="alert alert-error">
        <span class="alert-icon">!</span>
        <span>{{ session('error') }}</span>
        <button class="alert-close" onclick="this.parentElement.classList.add('hide')">×</button>
    </div>
</div>

<script>
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        var alert = document.getElementById('error-alert');
        if (alert) alert.classList.add('hide');
    }, 5000);
</script>
@endif