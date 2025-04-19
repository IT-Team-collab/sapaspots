// Auth check for all pages except login
const currentPage = window.location.pathname.split('/').pop();
if (currentPage !== 'login.html') {
  const userProfile = JSON.parse(localStorage.getItem('userProfile'));
  if (!userProfile || !userProfile.type) {
    window.location.href = 'login.html';
  }
}

// Load header and footer
document.addEventListener('DOMContentLoaded', () => {
  // Load header
  fetch('header.html')
    .then(response => response.text())
    .then(html => {
      document.getElementById('header-container').innerHTML = html;
      updateUserInfo();
      setupLogout();
      updateNavigationVisibility();
    });
  
  // Load footer
  fetch('footer.html')
    .then(response => response.text())
    .then(html => {
      document.getElementById('footer-container').innerHTML = html;
    });
});

// Update user info in header
function updateUserInfo() {
  const userProfile = JSON.parse(localStorage.getItem('userProfile'));
  if (userProfile) {
    const userNameElement = document.getElementById('user-name');
    const userImageElement = document.getElementById('user-image');
    
    if (userNameElement) {
      userNameElement.textContent = userProfile.name || 'User';
    }
    
    if (userImageElement) {
      userImageElement.src = userProfile.picUrl || 'default-user.png';
    }
  }
}

// Update navigation visibility based on user type
function updateNavigationVisibility() {
  const userProfile = JSON.parse(localStorage.getItem('userProfile'));
  if (userProfile) {
    const isVendor = userProfile.type === 'vendor';
    
    const studentOnlyElements = document.querySelectorAll('.student-only-nav');
    const vendorOnlyElements = document.querySelectorAll('.vendor-only-nav');
    
    studentOnlyElements.forEach(element => {
      if (isVendor) {
        element.classList.add('hidden');
      } else {
        element.classList.remove('hidden');
      }
    });
    
    vendorOnlyElements.forEach(element => {
      if (isVendor) {
        element.classList.remove('hidden');
      } else {
        element.classList.add('hidden');
      }
    });
  }
}

// Setup logout functionality
function setupLogout() {
  const logoutBtn = document.getElementById('logout-btn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
      localStorage.clear();
      window.location.href = 'login.html';
    });
  }
}

// Mobile menu toggle
function toggleMobileMenu() {
  const menuToggle = document.querySelector('.menu-toggle');
  const mainNav = document.querySelector('.main-nav');
  
  menuToggle.classList.toggle('active');
  mainNav.classList.toggle('show');
} 