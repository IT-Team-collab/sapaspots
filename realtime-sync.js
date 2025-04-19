// Real-time sync with storage event listener
window.addEventListener("storage", (event) => {
  // Handle different storage key changes
  switch(event.key) {
    case 'userProfile':
      handleUserProfileChange(event.newValue);
      break;
    case 'tray':
      handleTrayChange(event.newValue);
      break;
    case 'orders':
      handleOrdersChange(event.newValue);
      break;
    case 'vendors':
      handleVendorsChange(event.newValue);
      break;
  }
});

// Handle userProfile changes
function handleUserProfileChange(newValue) {
  // Update user info in header if on a page with user info
  const userNameElement = document.getElementById('user-name');
  const userImageElement = document.getElementById('user-image');
  
  if (newValue && (userNameElement || userImageElement)) {
    const userProfile = JSON.parse(newValue);
    
    if (userNameElement) {
      userNameElement.textContent = userProfile.name || 'User';
    }
    
    if (userImageElement) {
      userImageElement.src = userProfile.picUrl || 'default-user.png';
    }
  }
}

// Handle tray changes
function handleTrayChange(newValue) {
  // Update tray UI if on vendor.html or order-details.html
  const trayContainer = document.getElementById('tray-container');
  if (trayContainer) {
    refreshTrayUI();
  }
}

// Handle orders changes
function handleOrdersChange(newValue) {
  // When orders change in localStorage, also update sessionStorage
  if (newValue) {
    sessionStorage.setItem('sapaspots_orders', newValue);
    
    // Update cookie as well for persistence across sessions
    try {
      document.cookie = `sapaspots_orders=${encodeURIComponent(newValue)};path=/;max-age=86400`;
    } catch (e) {
      console.error('Failed to update orders cookie', e);
    }
  }
  
  // Check which page we're on and update appropriately
  
  // Update orders UI if on my-orders page
  const ordersGroupsContainer = document.getElementById('orders-groups');
  if (ordersGroupsContainer) {
    // Preserve current filter when refreshing
    const activeFilter = document.querySelector('.filter-tab.active');
    const filterValue = activeFilter ? activeFilter.dataset.filter : 'all';
    
    if (typeof refreshOrdersUI === 'function') {
      refreshOrdersUI();
    } else if (typeof loadOrders === 'function') {
      loadOrders(filterValue);
    }
  }
  
  // Update orders list if on any page with orders list
  const ordersList = document.getElementById('orders-list');
  if (ordersList && typeof refreshOrdersUI === 'function') {
    refreshOrdersUI();
  }
  
  // Update dashboard if on student dashboard
  const studentDashboard = document.getElementById('student-dashboard');
  if (studentDashboard) {
    if (typeof refreshStudentDashboard === 'function') {
      refreshStudentDashboard();
    } else if (typeof loadDashboard === 'function') {
      loadDashboard();
    }
  }
  
  // Update vendor dashboard if on vendor dashboard
  const vendorDashboard = document.getElementById('vendor-dashboard');
  if (vendorDashboard) {
    if (typeof refreshVendorDashboard === 'function') {
      refreshVendorDashboard();
    } else if (typeof loadOrders === 'function') {
      loadOrders();
    }
  }
}

// Handle vendors changes
function handleVendorsChange(newValue) {
  // Update vendor list if on vendors.html
  const vendorsList = document.getElementById('vendors-list');
  if (vendorsList) {
    refreshVendorsUI();
  }
  
  // Update vendor details if on vendor.html
  const vendorDetails = document.getElementById('vendor-details');
  if (vendorDetails) {
    refreshVendorDetailsUI();
  }
  
  // Update map if on map.html
  const vendorMap = document.getElementById('vendor-map');
  if (vendorMap) {
    refreshMapUI();
  }
}

// Placeholder functions to be implemented in respective pages
function refreshTrayUI() {
  console.log('Tray UI refresh needed');
  // Will be implemented in vendor.html and order-details.html
}

function refreshOrdersUI() {
  console.log('Orders UI refresh needed');
  // Will be implemented in my-orders.html
}

function refreshStudentDashboard() {
  console.log('Student dashboard refresh needed');
  // Will be implemented in student-dashboard.html
}

function refreshVendorDashboard() {
  console.log('Vendor dashboard refresh needed');
  // Will be implemented in vendor-dashboard.html
}

function refreshVendorsUI() {
  console.log('Vendors list refresh needed');
  // Will be implemented in vendors.html
}

function refreshVendorDetailsUI() {
  console.log('Vendor details refresh needed');
  // Will be implemented in vendor.html
}

function refreshMapUI() {
  console.log('Map refresh needed');
  // Will be implemented in map.html
} 