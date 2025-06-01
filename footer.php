<?php
// Get current year and system info
$currentYear = date("Y");
$systemVersion = "2.0.1";
$lastUpdate = "June 2025";
?>

<style>
  /* Enhanced Footer Styles */
  .enhanced-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    margin-top: 50px;
    border-radius: 20px 20px 0 0;
    overflow: hidden;
    position: relative;
    box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
  }

  .enhanced-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
    background-size: 200% 100%;
    animation: shimmer 3s ease-in-out infinite;
  }

  @keyframes shimmer {

    0%,
    100% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }
  }

  .footer-content {
    padding: 40px 0 20px 0;
  }

  .footer-main {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 30px;
  }

  .footer-section h5 {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 18px;
    position: relative;
    padding-bottom: 10px;
  }

  .footer-section h5::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 1px;
  }

  .footer-section p,
  .footer-section li {
    color: #bdc3c7;
    line-height: 1.8;
    margin-bottom: 8px;
    font-size: 14px;
  }

  .footer-section ul {
    list-style: none;
    padding: 0;
  }

  .footer-section ul li {
    padding: 5px 0;
    transition: all 0.3s ease;
  }

  .footer-section ul li:hover {
    color: white;
    padding-left: 10px;
  }

  .footer-section ul li i {
    margin-right: 8px;
    color: #667eea;
    width: 16px;
  }

  .social-links {
    display: flex;
    gap: 15px;
    margin-top: 20px;
  }

  .social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(102, 126, 234, 0.2);
    border-radius: 50%;
    color: #667eea;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 16px;
  }

  .social-link:hover {
    background: #667eea;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
  }

  .footer-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin: 30px 0;
    padding: 20px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .stat-item {
    text-align: center;
    padding: 15px;
  }

  .stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 5px;
    display: block;
  }

  .stat-label {
    font-size: 12px;
    color: #95a5a6;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .footer-bottom {
    text-align: center;
  }

  .footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
  }

  .copyright {
    color: #95a5a6;
    font-size: 14px;
    margin: 0;
  }

  .copyright strong {
    color: #667eea;
    font-weight: 600;
  }

  .system-info {
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
  }

  .info-badge {
    background: rgba(102, 126, 234, 0.2);
    color: #667eea;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid rgba(102, 126, 234, 0.3);
  }

  .back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
    opacity: 0;
    visibility: hidden;
    z-index: 1000;
  }

  .back-to-top.show {
    opacity: 1;
    visibility: visible;
  }

  .back-to-top:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
  }

  /* Loading animation for stats */
  .stat-number {
    animation: countup 2s ease-out;
  }

  @keyframes countup {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .footer-main {
      grid-template-columns: 1fr;
      gap: 30px;
    }

    .footer-bottom-content {
      flex-direction: column;
      text-align: center;
    }

    .system-info {
      justify-content: center;
    }

    .footer-stats {
      grid-template-columns: repeat(2, 1fr);
    }

    .back-to-top {
      bottom: 20px;
      right: 20px;
      width: 45px;
      height: 45px;
      font-size: 16px;
    }
  }

  @media (max-width: 480px) {
    .footer-content {
      padding: 30px 15px 15px 15px;
    }

    .footer-stats {
      grid-template-columns: 1fr;
    }

    .social-links {
      justify-content: center;
    }
  }

  /* Dark mode support */
  @media (prefers-color-scheme: dark) {
    .enhanced-footer {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    }
  }
</style>

<footer class="enhanced-footer">
  <div class="container-fluid">
    <!-- Main Footer Content -->
    <div class="footer-main">
      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <div class="footer-bottom-content">
          <p class="copyright">
            &copy; <?php echo $currentYear; ?> <strong>Ardi Nurohman</strong>.
            Semua hak dilindungi. Dibuat dengan <i class="fas fa-heart" style="color: #e74c3c;"></i>
            untuk kemajuan bisnis Anda.
          </p>
          <div class="system-info">
            <span class="info-badge">
              <i class="fas fa-code"></i> v<?php echo $systemVersion; ?>
            </span>
            <span class="info-badge">
              <i class="fas fa-calendar"></i> <?php echo $lastUpdate; ?>
            </span>
            <span class="info-badge">
              <i class="fas fa-server"></i> Online
            </span>
          </div>
        </div>
      </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" onclick="scrollToTop()">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize DataTables with enhanced options
    if ($.fn.DataTable && $('#myTable').length) {
      $('#myTable').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        "responsive": true,
        "pageLength": 25,
        "lengthMenu": [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "Semua"]
        ],
        "order": [
          [0, "desc"]
        ],
        "columnDefs": [{
          "orderable": false,
          "targets": -1
        }]
      });
    }

    // Animate counters
    animateCounters();

    // Back to top functionality
    handleBackToTop();

    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
      var target = $(this.getAttribute('href'));
      if (target.length) {
        event.preventDefault();
        $('html, body').stop().animate({
          scrollTop: target.offset().top - 100
        }, 1000);
      }
    });
  });

  // Counter animation function
  function animateCounters() {
    $('.stat-number').each(function() {
      const $this = $(this);
      const target = parseInt($this.data('target')) || 0;
      const duration = 2000;
      const step = target / (duration / 16);
      let current = 0;

      const timer = setInterval(function() {
        current += step;
        if (current >= target) {
          $this.text(target);
          clearInterval(timer);
        } else {
          $this.text(Math.floor(current));
        }
      }, 16);
    });
  }

  // Back to top functionality
  function handleBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');

    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    });
  }

  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }

  // Toast notification system
  function showToast(message, type = 'success') {
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    // Create toast container if it doesn't exist
    if (!document.getElementById('toastContainer')) {
      const container = document.createElement('div');
      container.id = 'toastContainer';
      container.className = 'toast-container position-fixed top-0 end-0 p-3';
      container.style.zIndex = '9999';
      document.body.appendChild(container);
    }

    const container = document.getElementById('toastContainer');
    const toastElement = document.createElement('div');
    toastElement.innerHTML = toastHtml;
    container.appendChild(toastElement.firstElementChild);

    const toast = new bootstrap.Toast(toastElement.firstElementChild);
    toast.show();

    // Remove toast element after it's hidden
    toastElement.firstElementChild.addEventListener('hidden.bs.toast', function() {
      this.remove();
    });
  }

  // Loading overlay
  function showLoading() {
    if (!document.getElementById('loadingOverlay')) {
      const overlay = document.createElement('div');
      overlay.id = 'loadingOverlay';
      overlay.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memproses...</div>
            </div>
        `;
      overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            color: white;
            flex-direction: column;
        `;
      document.body.appendChild(overlay);
    }
  }

  function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
      overlay.remove();
    }
  }

  // Form validation helper
  function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        field.classList.add('is-invalid');
        isValid = false;
      } else {
        field.classList.remove('is-invalid');
      }
    });

    return isValid;
  }

  // Auto-save functionality
  let autoSaveTimer;

  function enableAutoSave(formId, saveFunction) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('input', function() {
      clearTimeout(autoSaveTimer);
      autoSaveTimer = setTimeout(() => {
        saveFunction();
      }, 3000);
    });
  }

  // Console warning for security
  console.log('%cPeringatan!', 'color: red; font-size: 20px; font-weight: bold;');
  console.log('%cJangan menjalankan kode yang tidak Anda pahami di sini. Ini dapat membahayakan akun Anda.', 'color: red; font-size: 14px;');
</script>

</body>

</html>